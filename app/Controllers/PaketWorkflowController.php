<?php

namespace App\Controllers;

use App\Controllers\Traits\ProcurementScope;
use App\Libraries\PaketWorkflow;
use App\Models\BaReviewModel;
use App\Models\CatatanModel;
use App\Models\DokumenModel;
use App\Models\PaketModel;
use App\Models\PaketPokjaModel;
use App\Models\PejabatPengadaanSkpdModel;
use App\Models\UserModel;

/**
 * Tahapan paket setelah diajukan:
 * - Jalur Tender/Seleksi (13 tahapan): Verifikasi -> Saran Distribusi -> Distribusi & SK Pokja ->
 *   Review Pokja & BA Review -> Pemilihan -> Serahkan Hasil & BA ke Verifikator -> Unggah & Kirim ke Kepala UKPBJ ->
 *   Teruskan ke PPK -> PPK Terima (Selesai) / Tolak (Tender Ulang kembali ke Review Pokja atau Tidak Dilanjutkan/Gagal).
 * - Jalur Pengadaan Langsung (8 tahapan): Verifikasi -> Pejabat Pengadaan (otomatis berdasarkan SKPD) ->
 *   Review & BA Review -> Serahkan Dokumen & BA ke Verifikator -> Unggah & Kirim ke Kepala UKPBJ ->
 *   Teruskan ke PPK -> Selesai.
 */
class PaketWorkflowController extends BaseController
{
    use ProcurementScope;

    private const MAX_FILE_BYTES = 20 * 1024 * 1024;

    private const ALLOWED_FILES = [
        'pdf'  => ['application/pdf'],
        'doc'  => ['application/msword', 'application/CDFV2', 'application/x-ole-storage'],
        'xls'  => ['application/vnd.ms-excel', 'application/CDFV2', 'application/x-ole-storage'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'],
        'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'],
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png'  => ['image/png'],
        'zip'  => ['application/zip', 'application/x-zip-compressed'],
    ];

    protected PaketModel $paketModel;
    protected PaketPokjaModel $pokjaModel;
    protected PejabatPengadaanSkpdModel $pejabatSkpdModel;
    protected BaReviewModel $baReviewModel;
    protected CatatanModel $catatanModel;
    protected DokumenModel $dokumenModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->paketModel       = new PaketModel();
        $this->pokjaModel       = new PaketPokjaModel();
        $this->pejabatSkpdModel = new PejabatPengadaanSkpdModel();
        $this->baReviewModel    = new BaReviewModel();
        $this->catatanModel     = new CatatanModel();
        $this->dokumenModel     = new DokumenModel();
        $this->userModel        = new UserModel();
    }

    // ------------------------------------------------------------------
    // Transisi status
    // ------------------------------------------------------------------

    public function transition(string $action = '', $id = null)
    {
        $def = PaketWorkflow::ACTIONS[$action] ?? null;
        if ($def === null) {
            return $this->failWith('Aksi tidak dikenal.', 404, '/paket');
        }

        $paket = $this->loadPaket((int) $id);
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404, '/paket');
        }

        $ctx   = $this->context($paket);
        $avail = PaketWorkflow::available($paket, $this->actor(), $ctx['isMember'], $ctx['pokjaCount'], $ctx['latestBa']);

        if (! isset($avail[$action])) {
            return $this->failWith('Aksi ini tidak tersedia untuk peran Anda atau status paket saat ini.', 403, '/paket');
        }
        if (! empty($avail[$action]['blocked'])) {
            return $this->failWith($avail[$action]['blocked'], 422, '/paket');
        }

        $note = trim((string) $this->request->getPost('catatan'));
        if (($def['note'] ?? null) === 'required' && mb_strlen($note) < 3) {
            return $this->failWith('Catatan / alasan wajib diisi (minimal 3 karakter).', 422, '/paket');
        }

        // Pengembalian oleh Admin ULP / Pokja wajib memiliki catatan (atau BA Review untuk sarankaji)
        $expectedNoteStatus = match ($action) {
            'kembalikan' => 3,
            'saranadd'   => 10,
            default      => null,
        };
        if ($expectedNoteStatus !== null && mb_strlen($note) < 3) {
            $hasOpenNote = $this->catatanModel
                ->where('paket_id', (int) $paket['id'])
                ->where('status_paket', $expectedNoteStatus)
                ->groupStart()->where('isi_jawaban IS NULL')->orWhere('isi_jawaban', '')->groupEnd()
                ->countAllResults() > 0;

            if (! $hasOpenNote) {
                return $this->failWith('Harap isi Catatan terlebih dahulu (pada tab Catatan atau form ini) sebelum mengembalikan paket ke PPK.', 422, '/paket');
            }
        }

        // Pengajuan ulang oleh PPK: dokumen persyaratan wajib harus tetap lengkap
        if (in_array($action, ['ajukan_kembali', 'ajukan_kaji', 'ajukan_add'], true)) {
            $missing = (new \App\Models\SyaratModel())->select('nama_persyaratan')
                ->where('paket_id', (int) $paket['id'])->where('wajib', 1)
                ->groupStart()->where('nama_file IS NULL')->orWhere('nama_file', '')->groupEnd()
                ->findAll();

            if ($missing !== []) {
                return $this->failWith(
                    'Dokumen persyaratan wajib belum lengkap: ' . implode('; ', array_column($missing, 'nama_persyaratan')),
                    422,
                    '/paket'
                );
            }
        }

        $actor        = $this->actor();
        $isDirect     = PaketWorkflow::isDirectProcurement($paket);
        $from         = (int) $paket['status_paket'];
        $to           = (int) $def['to'];
        $now          = date('Y-m-d H:i:s');
        $today        = date('Y-m-d');
        $update       = ['updated_at' => $now];
        $rupSet       = null;
        $autoPejabat  = null;
        $uploadedFile = null;

        switch ($action) {
            case 'pilih':
                $update['admin_ukpbj_id'] = (int) $actor['id'];
                $to = $from; // status tidak berubah
                break;

            case 'kembalikan':
                $update['status_verifikasi'] = 2;
                $rupSet = 1;
                break;

            case 'ajukan_kembali':
                $update['status_verifikasi'] = 0;
                $rupSet = 2;
                break;

            case 'terima':
                $update['status_verifikasi'] = 1;
                if ($isDirect) {
                    // Tahap 04 Pengadaan Langsung: otomatis masuk ke Pejabat Pengadaan yang mengampu SKPD terkait
                    $pejabat = $this->pejabatSkpdModel->findPejabatBySkpd((int) ($paket['skpd_id'] ?? 0));
                    if (! $pejabat) {
                        return $this->failWith(
                            'SKPD pada paket ini belum memiliki Pejabat Pengadaan (akun ber-role POKJA yang dihubungkan ke SKPD ini). Harap atur terlebih dahulu di menu Manajemen Akun.',
                            422,
                            '/paket'
                        );
                    }
                    $to = 6; // Langsung diterima oleh Pejabat Pengadaan untuk direview (tanpa Saran/Distribusi Kepala)
                    $update['tgl_distribusi'] = $today;
                    $autoPejabat = $pejabat;
                }
                break;

            case 'saran':
                $update['admin_distribusi_id'] = (int) $actor['id'];
                break;

            case 'distribusi':
                $noSk  = trim((string) $this->request->getPost('no_sk_pokja'));
                $tglSk = trim((string) $this->request->getPost('tgl_sk_pokja')) ?: $today;
                if ($noSk !== '') {
                    $update['no_sk_pokja']  = mb_substr($noSk, 0, 100);
                    $update['tgl_sk_pokja'] = $tglSk;
                }
                $update['tgl_distribusi']  = $today;
                $update['kepala_ukpbj_id'] = (int) $actor['id'];
                break;

            case 'sarankaji':
                $rupSet = 1;
                if ($note === '' && ! empty($ctx['latestBa']['catatan_perbaikan'])) {
                    $note = '[BA Review Putaran #' . (int) $ctx['latestBa']['putaran'] . '] ' . trim((string) $ctx['latestBa']['catatan_perbaikan']);
                }
                break;

            case 'ajukan_kaji':
                $rupSet = 2;
                break;

            case 'lelang':
                $update['tgl_tayang'] = $today;
                break;

            case 'teruskan_hasil':
                $update['kepala_ukpbj_id'] = (int) $actor['id'];
                if ($isDirect) {
                    // Tahap 08 Pengadaan Langsung: Kepala UKPBJ meneruskan hasil ke PPK -> Status Paket langsung SELESAI
                    $to = 14;
                }
                break;

            case 'ulang':
                // Tahap 12a Tender Ulang: dikembalikan oleh PPK langsung ke Review Pokja Pemilihan (status 6)
                $to = 6;
                $update['alasan_penolakan'] = $note;
                break;

            case 'batal_tolak':
                // Tahap 12b Tidak Dilanjutkan: WAJIB isi alasan & unggah surat resmi penolakan / pembatalan -> Status GAGAL (15)
                $file = $this->request->getFile('surat_penolakan');
                $stored = $this->storeUpload($file, 'surat-penolakan-paket-' . (int) $paket['id'], $err);
                if ($stored === null) {
                    return $this->failWith('Surat resmi penolakan/pembatalan wajib diunggah: ' . $err, 422, '/paket');
                }
                $uploadedFile = $stored;
                $to = 15;
                $update += [
                    'alasan_penolakan' => $note,
                    'surat_penolakan'  => $stored,
                    'nama_pemenang'    => null,
                    'npwp'             => null,
                    'alamat'           => null,
                    'nama_penanggung'  => null,
                    'nilai_kontrak'    => 0,
                    'tgl_penetapan'    => null,
                ];
                break;
        }

        $update['status_paket'] = $to;
        $db = db_connect();

        try {
            $db->transBegin();

            // Update bersyarat (optimistic): hanya jika status belum berubah oleh pengguna lain
            $db->table('paket')->where('id', (int) $paket['id'])->where('status_paket', $from)->update($update);
            if ($db->affectedRows() !== 1) {
                $db->transRollback();
                if ($uploadedFile) {
                    @unlink($this->uploadDir() . $uploadedFile);
                }

                return $this->failWith('Status paket sudah berubah. Muat ulang halaman.', 409, '/paket');
            }

            if ($autoPejabat !== null) {
                $exists = $this->pokjaModel->where([
                    'paket_id' => (int) $paket['id'],
                    'user_id'  => (int) $autoPejabat['id'],
                ])->countAllResults() > 0;

                if (! $exists) {
                    $this->pokjaModel->insert([
                        'paket_id' => (int) $paket['id'],
                        'user_id'  => (int) $autoPejabat['id'],
                        'role'     => 'Pejabat Pengadaan',
                    ]);
                }
            }

            if ($rupSet !== null && ! empty($paket['rup_id'])) {
                $db->table('rup')->where('id', (int) $paket['rup_id'])->update(['rup_status' => $rupSet, 'updated_at' => $now]);
            }

            if (in_array($action, ['hasil', 'serahkan_pl'], true)) {
                $db->table('syarat')->where('paket_id', (int) $paket['id'])->update(['selesai' => 1, 'updated_at' => $now]);
                $db->table('dokumen')->where('paket_id', (int) $paket['id'])->update(['selesai' => 1, 'updated_at' => $now]);
            }

            if ($uploadedFile !== null) {
                $this->dokumenModel->insert([
                    'paket_id'     => (int) $paket['id'],
                    'nama_dokumen' => 'Surat Resmi Penolakan / Pembatalan PPK',
                    'nama_file'    => $uploadedFile,
                    'uploaded_by'  => (int) $actor['id'],
                    'selesai'      => 1,
                ]);
            }

            if ($note !== '') {
                $this->catatanModel->insert([
                    'paket_id'     => (int) $paket['id'],
                    'user_id'      => (int) $actor['id'],
                    'role_id'      => (int) $actor['role_id'],
                    'status_paket' => $to,
                    'isi_catatan'  => $note,
                ]);
            }

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            if ($uploadedFile) {
                @unlink($this->uploadDir() . $uploadedFile);
            }
            log_message('error', 'PaketWorkflow::transition ' . $action . ': ' . $e->getMessage());

            return $this->failWith('Gagal memproses aksi. Silakan coba lagi.', 500, '/paket');
        }

        return $this->okWith('Berhasil: ' . $def['label'] . '.', ['status_paket' => $to], '/paket');
    }

    // ------------------------------------------------------------------
    // Berita Acara Review (BA Review)
    // ------------------------------------------------------------------

    public function baReview($id = null)
    {
        $paket = $this->loadPaket((int) $id);
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404);
        }

        $ctx  = $this->context($paket);
        $caps = PaketWorkflow::capabilities($paket, $this->actor(), $ctx['isMember']);
        $rows = $this->baReviewModel->getByPaketId((int) $paket['id']);

        return $this->response->setJSON([
            'status'    => 'success',
            'data'      => $rows,
            'latest'    => $rows !== [] ? $rows[count($rows) - 1] : null,
            'can_add'   => $caps['ba_review'],
            'is_direct' => $caps['is_direct'],
        ]);
    }

    public function baReviewStore()
    {
        $paket = $this->loadPaket((int) $this->request->getPost('paket_id'));
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404);
        }

        $ctx  = $this->context($paket);
        $caps = PaketWorkflow::capabilities($paket, $this->actor(), $ctx['isMember']);
        if (! $caps['ba_review']) {
            return $this->failWith('Anda tidak memiliki kewenangan menyusun Berita Acara Review pada tahap ini.', 403);
        }

        $nomorBa          = trim((string) $this->request->getPost('nomor_ba'));
        $tglBa            = trim((string) $this->request->getPost('tgl_ba')) ?: date('Y-m-d');
        $hasilPemeriksaan = trim((string) $this->request->getPost('hasil_pemeriksaan'));
        $catatanPerbaikan = trim((string) $this->request->getPost('catatan_perbaikan'));
        $perluPerbaikan   = (int) $this->request->getPost('perlu_perbaikan') === 1 ? 1 : 0;

        if (mb_strlen($hasilPemeriksaan) < 5) {
            return $this->failWith('Hasil pemeriksaan wajib diisi (minimal 5 karakter).', 422);
        }
        if ($perluPerbaikan === 1 && mb_strlen($catatanPerbaikan) < 3) {
            return $this->failWith('Catatan perbaikan wajib diisi apabila dokumen memerlukan perbaikan dari PPK.', 422);
        }

        $latest      = $this->baReviewModel->getLatestByPaketId((int) $paket['id']);
        $nextPutaran = $latest ? ((int) $latest['putaran'] + 1) : 1;

        $insertId = $this->baReviewModel->insert([
            'paket_id'          => (int) $paket['id'],
            'putaran'           => $nextPutaran,
            'nomor_ba'          => $nomorBa !== '' ? mb_substr($nomorBa, 0, 100) : null,
            'tgl_ba'            => $tglBa,
            'hasil_pemeriksaan' => $hasilPemeriksaan,
            'catatan_perbaikan' => $catatanPerbaikan !== '' ? $catatanPerbaikan : null,
            'perlu_perbaikan'   => $perluPerbaikan,
            'reviewer_id'       => (int) $this->actor()['id'],
        ]);

        // Ambil ulang state tombol aksi terbaru agar UI bisa langsung mengaktifkan tombol Lelang / Kembalikan
        $updatedCtx = $this->context($paket);
        $actions    = array_values(PaketWorkflow::available(
            $paket,
            $this->actor(),
            $updatedCtx['isMember'],
            $updatedCtx['pokjaCount'],
            $updatedCtx['latestBa']
        ));

        return $this->okWith(
            "Berita Acara Review Putaran #{$nextPutaran} berhasil disimpan.",
            [
                'ba_id'            => $insertId,
                'putaran'          => $nextPutaran,
                'perlu_perbaikan'  => $perluPerbaikan,
                'workflow_actions' => $actions,
                'data'             => [
                    'ba_id'            => $insertId,
                    'putaran'          => $nextPutaran,
                    'perlu_perbaikan'  => $perluPerbaikan,
                    'workflow_actions' => $actions,
                ],
            ]
        );
    }

    // ------------------------------------------------------------------
    // Pokja (P5)
    // ------------------------------------------------------------------

    public function pokja($id = null)
    {
        $paket = $this->loadPaket((int) $id);
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404);
        }

        $caps       = PaketWorkflow::capabilities($paket, $this->actor(), $this->context($paket)['isMember']);
        $members    = $this->pokjaModel->getMembersByPaket((int) $paket['id']);
        $candidates = [];

        if ($caps['pokja']) {
            $taken      = array_column($members, 'user_id');
            $q          = $this->userModel->select('users.id, users.full_name, users.nip')
                ->join('roles', 'roles.id = users.role_id')
                ->where('roles.name', 'POKJA')->where('users.is_active', 1);
            if ($taken !== []) {
                $q->whereNotIn('users.id', $taken);
            }
            $candidates = $q->orderBy('users.full_name', 'ASC')->findAll();
        }

        return $this->response->setJSON([
            'status'     => 'success',
            'members'    => $members,
            'candidates' => $candidates,
            'can_edit'   => $caps['pokja'],
            'is_direct'  => $caps['is_direct'],
            'sizes'      => PaketWorkflow::POKJA_SIZES,
            'roles'      => ['Ketua', 'Sekretaris', 'Anggota'],
        ]);
    }

    public function pokjaStore()
    {
        $paket = $this->loadPaket((int) $this->request->getPost('paket_id'));
        if (! $paket || ! PaketWorkflow::capabilities($paket, $this->actor(), false)['pokja']) {
            return $this->failWith('Anda tidak dapat mengubah Pokja paket ini.', 403);
        }

        $userId = (int) $this->request->getPost('user_id');
        $jabatan = trim((string) $this->request->getPost('role')) ?: 'Anggota';
        if (! in_array($jabatan, ['Ketua', 'Sekretaris', 'Anggota'], true)) {
            $jabatan = 'Anggota';
        }

        $user = $this->userModel->select('users.id')->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $userId)->where('roles.name', 'POKJA')->where('users.is_active', 1)->first();
        if (! $user) {
            return $this->failWith('Personil Pokja tidak valid.', 422);
        }

        $paketId = (int) $paket['id'];
        if ($this->pokjaModel->where(['paket_id' => $paketId, 'user_id' => $userId])->countAllResults() > 0) {
            return $this->failWith('Personil sudah ada di dalam Pokja paket ini.', 409);
        }
        if ($this->pokjaModel->where('paket_id', $paketId)->countAllResults() >= max(PaketWorkflow::POKJA_SIZES)) {
            return $this->failWith('Anggota Pokja maksimal ' . max(PaketWorkflow::POKJA_SIZES) . ' orang.', 422);
        }

        $this->pokjaModel->insert(['paket_id' => $paketId, 'user_id' => $userId, 'role' => $jabatan]);

        $updatedCtx = $this->context($paket);
        $actions    = array_values(PaketWorkflow::available(
            $paket,
            $this->actor(),
            $updatedCtx['isMember'],
            $updatedCtx['pokjaCount'],
            $updatedCtx['latestBa']
        ));

        return $this->okWith('Anggota Pokja ditambahkan.', [
            'workflow_actions' => $actions,
            'data'             => ['workflow_actions' => $actions],
        ]);
    }

    public function pokjaDelete($id = null)
    {
        $row   = $this->pokjaModel->find((int) $id);
        $paket = $row ? $this->loadPaket((int) $row['paket_id']) : null;
        if (! $paket || ! PaketWorkflow::capabilities($paket, $this->actor(), false)['pokja']) {
            return $this->failWith('Anda tidak dapat mengubah Pokja paket ini.', 403);
        }

        $this->pokjaModel->delete((int) $id);

        $updatedCtx = $this->context($paket);
        $actions    = array_values(PaketWorkflow::available(
            $paket,
            $this->actor(),
            $updatedCtx['isMember'],
            $updatedCtx['pokjaCount'],
            $updatedCtx['latestBa']
        ));

        return $this->okWith('Anggota Pokja dihapus.', [
            'workflow_actions' => $actions,
            'data'             => ['workflow_actions' => $actions],
        ]);
    }

    // ------------------------------------------------------------------
    // Catatan
    // ------------------------------------------------------------------

    public function catatan($id = null)
    {
        $paket = $this->loadPaket((int) $id);
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404);
        }

        $actor = $this->actor();
        $role  = strtoupper((string) ($actor['role_name'] ?? ''));
        $caps  = PaketWorkflow::capabilities($paket, $actor, $this->context($paket)['isMember']);
        $rows  = $this->catatanModel->getByPaketId((int) $paket['id']);

        foreach ($rows as &$r) {
            $isOwner = (int) ($r['user_id'] ?? 0) === (int) $actor['id'];
            $r['can_delete'] = (PaketWorkflow::isAdmin($actor) || $isOwner) && empty($r['isi_jawaban']);
            $r['can_jawab']  = $caps['catatan'] && empty($r['isi_jawaban']) && (PaketWorkflow::isAdmin($actor) || in_array($role, ['PPK', 'ADMIN PPK'], true));
        }
        unset($r);

        return $this->response->setJSON([
            'status'   => 'success',
            'data'     => $rows,
            'can_add'  => $caps['catatan'],
            'statuses' => array_map(static fn ($s) => $s['name'], PaketModel::STATUS_PAKET),
        ]);
    }

    public function catatanStore()
    {
        $paket = $this->loadPaket((int) $this->request->getPost('paket_id'));
        $text  = trim((string) $this->request->getPost('isi_catatan'));
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404);
        }
        if (! PaketWorkflow::capabilities($paket, $this->actor(), false)['catatan']) {
            return $this->failWith('Anda tidak dapat menambah catatan pada paket ini.', 403);
        }
        if (mb_strlen($text) < 3) {
            return $this->failWith('Isi catatan minimal 3 karakter.', 422);
        }

        $actor      = $this->actor();
        $role       = strtoupper((string) ($actor['role_name'] ?? ''));
        $statusCode = (int) $this->request->getPost('status_paket');
        if ($statusCode <= 0) {
            $curStatus = (int) $paket['status_paket'];
            if ($role === 'ADMIN ULP' && $curStatus === 2) {
                $statusCode = 3;
            } elseif ($role === 'POKJA' && in_array($curStatus, [6, 8], true)) {
                $statusCode = 7;
            } elseif ($role === 'POKJA' && in_array($curStatus, [9, 11], true)) {
                $statusCode = 10;
            } else {
                $statusCode = $curStatus;
            }
        }

        $insertId = $this->catatanModel->insert([
            'paket_id'     => (int) $paket['id'],
            'user_id'      => (int) $actor['id'],
            'role_id'      => (int) $actor['role_id'],
            'status_paket' => $statusCode,
            'isi_catatan'  => $text,
        ]);

        return $this->okWith('Catatan ditambahkan.', ['catatan_id' => $insertId]);
    }

    public function catatanDelete($id = null)
    {
        $row   = $this->catatanModel->find((int) $id);
        $paket = $row ? $this->loadPaket((int) $row['paket_id']) : null;
        if (! $paket) {
            return $this->failWith('Catatan tidak ditemukan.', 404);
        }

        $actor   = $this->actor();
        $isAdmin = PaketWorkflow::isAdmin($actor);
        $isOwner = (int) ($row['user_id'] ?? 0) === (int) $actor['id'];

        if (! $isAdmin && ! $isOwner) {
            return $this->failWith('Anda hanya dapat menghapus catatan yang Anda buat sendiri.', 403);
        }
        if (! empty($row['isi_jawaban'])) {
            return $this->failWith('Catatan yang sudah dijawab oleh PPK tidak dapat dihapus.', 409);
        }

        $this->catatanModel->delete((int) $id);

        return $this->okWith('Catatan berhasil dihapus.');
    }

    public function catatanJawab($id = null)
    {
        $row   = $this->catatanModel->find((int) $id);
        $paket = $row ? $this->loadPaket((int) $row['paket_id']) : null;
        $text  = trim((string) $this->request->getPost('isi_jawaban'));
        if (! $paket) {
            return $this->failWith('Catatan tidak ditemukan.', 404);
        }
        if (! PaketWorkflow::capabilities($paket, $this->actor(), false)['catatan']) {
            return $this->failWith('Anda tidak dapat menjawab catatan ini.', 403);
        }
        if (! empty($row['isi_jawaban'])) {
            return $this->failWith('Catatan ini sudah dijawab.', 409);
        }
        if (mb_strlen($text) < 2) {
            return $this->failWith('Isi jawaban wajib diisi.', 422);
        }

        $actor = $this->actor();
        $this->catatanModel->update((int) $id, [
            'isi_jawaban'   => $text,
            'jawab_user_id' => (int) $actor['id'],
            'jawab_role_id' => (int) $actor['role_id'],
        ]);

        return $this->okWith('Jawaban disimpan.');
    }

    // ------------------------------------------------------------------
    // Hasil / data pemenang (P9) & LPSE (P9b)
    // ------------------------------------------------------------------

    public function simpanHasil($id = null)
    {
        $paket = $this->loadPaket((int) $id);
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404);
        }
        $isMember = $this->context($paket)['isMember'];
        if (! PaketWorkflow::capabilities($paket, $this->actor(), $isMember)['hasil']) {
            return $this->failWith('Data hasil pemilihan tidak dapat diubah pada tahap ini.', 403);
        }

        $rules = [
            'nama_pemenang'   => 'permit_empty|max_length[100]',
            'npwp'            => 'permit_empty|max_length[50]',
            'alamat'          => 'permit_empty|max_length[1000]',
            'nama_penanggung' => 'permit_empty|max_length[100]',
            'nilai_kontrak'   => 'permit_empty|max_length[30]',
            'tgl_penetapan'   => 'permit_empty|valid_date[Y-m-d]',
            'no_surat'        => 'permit_empty|max_length[50]',
            'tgl_surat'       => 'permit_empty|valid_date[Y-m-d]',
        ];
        if (! $this->validate($rules)) {
            return $this->failWith(implode(' ', $this->validator->getErrors()), 422);
        }

        $kontrak = str_replace(['Rp', ' ', '.'], '', (string) $this->request->getPost('nilai_kontrak'));
        $kontrak = str_replace(',', '.', $kontrak);
        if ($kontrak !== '' && (! is_numeric($kontrak) || (float) $kontrak < 0 || (float) $kontrak >= 1e15)) {
            return $this->failWith('Nilai kontrak tidak valid.', 422);
        }

        $val = fn (string $k) => ($v = trim((string) $this->request->getPost($k))) === '' ? null : $v;

        $this->paketModel->update((int) $paket['id'], [
            'nama_pemenang'   => $val('nama_pemenang'),
            'npwp'            => $val('npwp'),
            'alamat'          => $val('alamat'),
            'nama_penanggung' => $val('nama_penanggung'),
            'nilai_kontrak'   => $kontrak === '' ? 0 : (float) $kontrak,
            'tgl_penetapan'   => $val('tgl_penetapan'),
            'no_surat'        => $val('no_surat'),
            'tgl_surat'       => $val('tgl_surat'),
        ]);

        return $this->okWith('Data hasil pemilihan disimpan.');
    }

    public function lpse($id = null)
    {
        $paket = $this->loadPaket((int) $id);
        if (! $paket || ! PaketWorkflow::capabilities($paket, $this->actor(), false)['lpse']) {
            return $this->failWith('Room LPSE tidak dapat dibuat untuk paket ini.', 403);
        }

        $this->paketModel->update((int) $paket['id'], ['is_lpse' => 1]);

        return $this->okWith('Room LPSE ditandai sudah dibuat.');
    }

    // ------------------------------------------------------------------
    // Dokumen lelang / hasil pengadaan
    // ------------------------------------------------------------------

    public function dokumen($id = null)
    {
        $paket = $this->loadPaket((int) $id);
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404);
        }

        $caps = PaketWorkflow::capabilities($paket, $this->actor(), $this->context($paket)['isMember']);
        $rows = $this->dokumenModel->getByPaketId((int) $paket['id']);
        foreach ($rows as &$r) {
            $r['file_url'] = site_url('paket/dokumen/download/' . $r['id']);
        }
        unset($r);

        return $this->response->setJSON(['status' => 'success', 'data' => $rows, 'can_edit' => $caps['dokumen']]);
    }

    public function dokumenUpload()
    {
        $paket = $this->loadPaket((int) $this->request->getPost('paket_id'));
        if (! $paket) {
            return $this->failWith('Data paket tidak ditemukan.', 404);
        }
        $isMember = $this->context($paket)['isMember'];
        if (! PaketWorkflow::capabilities($paket, $this->actor(), $isMember)['dokumen']) {
            return $this->failWith('Dokumen hanya dapat diunggah oleh Pokja/Pejabat Pengadaan atau Verifikator pada tahapan yang sesuai.', 403);
        }

        $nama = trim((string) $this->request->getPost('nama_dokumen'));
        if ($nama === '' || mb_strlen($nama) > 150) {
            return $this->failWith('Nama dokumen wajib diisi (maksimal 150 karakter).', 422);
        }

        $stored = $this->storeUpload($this->request->getFile('file'), $nama, $err);
        if ($stored === null) {
            return $this->failWith($err, 422);
        }

        try {
            $this->dokumenModel->insert([
                'paket_id'     => (int) $paket['id'],
                'nama_dokumen' => $nama,
                'nama_file'    => $stored,
                'uploaded_by'  => (int) $this->actor()['id'],
                'selesai'      => 0,
            ]);
        } catch (\Throwable $e) {
            @unlink($this->uploadDir() . $stored);
            log_message('error', 'dokumenUpload: ' . $e->getMessage());

            return $this->failWith('Gagal menyimpan dokumen.', 500);
        }

        return $this->okWith("Dokumen '{$nama}' berhasil diunggah.");
    }

    public function dokumenDelete($id = null)
    {
        $row   = $this->dokumenModel->find((int) $id);
        $paket = $row ? $this->loadPaket((int) $row['paket_id']) : null;
        if (! $paket) {
            return $this->failWith('Dokumen tidak ditemukan.', 404);
        }
        $isMember = $this->context($paket)['isMember'];
        if (! PaketWorkflow::capabilities($paket, $this->actor(), $isMember)['dokumen']) {
            return $this->failWith('Dokumen tidak dapat dihapus pada tahap ini.', 403);
        }
        if ((int) $row['selesai'] === 1) {
            return $this->failWith('Dokumen sudah dikunci dan tidak dapat dihapus.', 403);
        }

        $this->dokumenModel->delete((int) $id);
        $path = $this->uploadDir() . basename((string) $row['nama_file']);
        if (is_file($path)) {
            @unlink($path);
        }

        return $this->okWith('Dokumen dihapus.');
    }

    public function dokumenDownload($id = null)
    {
        $row   = $this->dokumenModel->find((int) $id);
        $paket = $row ? $this->loadPaket((int) $row['paket_id']) : null;
        if (! $paket) {
            return redirect()->to('/paket')->with('error', 'Dokumen tidak ditemukan atau Anda tidak berhak mengaksesnya.');
        }

        $path = $this->uploadDir() . basename((string) $row['nama_file']);
        if (! is_file($path)) {
            return redirect()->to('/paket')->with('error', 'File fisik tidak ditemukan pada server.');
        }

        return $this->response->download($path, null)->setFileName(basename((string) $row['nama_file']));
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    /** Paket + skpd/ppk/metode RUP; null bila tidak ada atau di luar cakupan user. */
    private function loadPaket(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        $paket = $this->paketModel->select('paket.*, rup.skpd_id, rup.ppk_id, rup.metode_pemilihan_id, metode_pemilihan.name as metode_pemilihan_name, metode_pemilihan.code as metode_pemilihan_code')
            ->join('rup', 'rup.id = paket.rup_id', 'left')
            ->join('metode_pemilihan', 'metode_pemilihan.id = rup.metode_pemilihan_id', 'left')
            ->where('paket.id', $id)->first();

        return ($paket && $this->inScope($paket)) ? $paket : null;
    }

    /** @return array{isMember: bool, pokjaCount: int, latestBa: ?array} */
    private function context(array $paket): array
    {
        $paketId  = (int) $paket['id'];
        $count    = $this->pokjaModel->where('paket_id', $paketId)->countAllResults();
        $member   = $this->pokjaModel->where(['paket_id' => $paketId, 'user_id' => (int) $this->actor()['id']])->countAllResults() > 0;
        $latestBa = $this->baReviewModel->getLatestByPaketId($paketId);

        return ['isMember' => $member, 'pokjaCount' => $count, 'latestBa' => $latestBa];
    }

    private function uploadDir(): string
    {
        return WRITEPATH . 'uploads/dokumen/';
    }

    private function storeUpload($file, string $label, ?string &$error = null): ?string
    {
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            $error = 'File dokumen tidak valid atau belum dipilih.';
            return null;
        }
        if ($file->getSize() > self::MAX_FILE_BYTES) {
            $error = 'Ukuran file melebihi batas ' . (self::MAX_FILE_BYTES / 1024 / 1024) . ' MB.';
            return null;
        }

        $ext = strtolower($file->getClientExtension());
        if (! isset(self::ALLOWED_FILES[$ext])) {
            $error = 'Format file tidak diperbolehkan. Gunakan: .' . implode(', .', array_keys(self::ALLOWED_FILES));
            return null;
        }
        if (! in_array($file->getMimeType(), self::ALLOWED_FILES[$ext], true)) {
            $error = 'Isi file tidak sesuai dengan ekstensinya (.' . $ext . ').';
            return null;
        }

        $dir = $this->uploadDir();
        if (! is_dir($dir) && ! mkdir($dir, 0750, true) && ! is_dir($dir)) {
            $error = 'Direktori penyimpanan tidak dapat dibuat.';
            return null;
        }

        $slug     = substr(url_title(strtolower($label), '-', true), 0, 60) ?: 'dokumen';
        $fileName = $slug . '-' . bin2hex(random_bytes(8)) . '.' . $ext;

        try {
            $file->move($dir, $fileName);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal memindahkan upload dokumen: ' . $e->getMessage());
            $error = 'Gagal menyimpan file ke server.';
            return null;
        }

        return $fileName;
    }
}
