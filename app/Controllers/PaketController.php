<?php

namespace App\Controllers;

use App\Controllers\Traits\ProcurementScope;
use App\Libraries\PaketWorkflow;
use App\Models\CatatanModel;
use App\Models\PaketModel;
use App\Models\PaketPokjaModel;
use App\Models\RupModel;
use App\Models\SkpdModel;
use App\Models\SyaratModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class PaketController extends BaseController
{
    use ProcurementScope;

    /** Ukuran maksimum dokumen persyaratan (byte). */
    private const MAX_FILE_BYTES = 20 * 1024 * 1024;

    /** Whitelist ekstensi => MIME hasil deteksi isi file (bukan dari klien). */
    private const ALLOWED_FILES = [
        'pdf'  => ['application/pdf'],
        'doc'  => ['application/msword', 'application/CDFV2', 'application/x-ole-storage'],
        'xls'  => ['application/vnd.ms-excel', 'application/CDFV2', 'application/x-ole-storage'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'],
        'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'],
        'xlsm' => ['application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'],
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png'  => ['image/png'],
        'zip'  => ['application/zip', 'application/x-zip-compressed'],
    ];

    /** Status saat PPK boleh mengubah dokumen persyaratan (Draft, Dikembalikan ULP, Saran-Kaji, Saran-Add). */
    private const SYARAT_EDITABLE = [1, 3, 7, 10];

    protected PaketModel $paketModel;
    protected PaketPokjaModel $paketPokjaModel;
    protected RupModel $rupModel;
    protected SkpdModel $skpdModel;
    protected SyaratModel $syaratModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->paketModel      = new PaketModel();
        $this->paketPokjaModel = new PaketPokjaModel();
        $this->rupModel        = new RupModel();
        $this->skpdModel       = new SkpdModel();
        $this->syaratModel     = new SyaratModel();
        $this->userModel       = new UserModel();
    }

    /**
     * Tampilkan halaman daftar paket pengadaan (Paket Tender & Seleksi)
     */
    public function index()
    {
        $pakets = $skpdList = $availableRups = [];
        $currentUser = null;

        try {
            // Hanya paket dalam cakupan user (SKPD/PPK) atau seluruhnya untuk role pusat
            $this->scopeToActor($this->paketModel, 'rup.skpd_id', 'rup.ppk_id');
            $paketsFromDb = $this->paketModel->getWithRelations();

            // Anggota pokja hanya untuk paket yang ditampilkan
            $pokjaByPaket = [];
            $paketIds     = array_column($paketsFromDb, 'id');
            if ($paketIds !== []) {
                $allPokja = $this->paketPokjaModel
                    ->select('paket_pokja.*, users.full_name, users.username')
                    ->join('users', 'users.id = paket_pokja.user_id', 'left')
                    ->whereIn('paket_pokja.paket_id', $paketIds)
                    ->findAll();

                foreach ($allPokja as $row) {
                    $pokjaByPaket[$row['paket_id']][] = $row;
                }
            }

            // Catatan terakhir per paket (untuk ringkasan di detail paket)
            $lastNote = [];
            if ($paketIds !== []) {
                $notes = (new CatatanModel())->select('paket_id, isi_catatan')
                    ->whereIn('paket_id', $paketIds)->orderBy('id', 'ASC')->findAll();
                foreach ($notes as $n) {
                    $lastNote[$n['paket_id']] = $n['isi_catatan'];
                }
            }

            $actor = $this->actor();

            $pakets = array_map(function ($item) use ($pokjaByPaket, $lastNote, $actor) {
                $members  = $pokjaByPaket[$item['id']] ?? [];
                $isMember = in_array((int) $actor['id'], array_map('intval', array_column($members, 'user_id')), true);

                $item['pokja_members']    = $members;
                $item['catatan_terakhir'] = $lastNote[$item['id']] ?? null;
                $item['workflow_actions'] = array_values(PaketWorkflow::available($item, $actor, $isMember, count($members)));
                $item['wf']               = PaketWorkflow::capabilities($item, $actor, $isMember);

                return $this->formatPaketRow($item);
            }, $paketsFromDb);

            $skpdList = $this->skpdModel->select('id, name, abbreviation')->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

            // Info user (tanpa hash password)
            $currentUser = $this->userModel
                ->select('users.id, users.full_name, users.username, users.email, users.nip, users.whatsapp_number, users.role_id, users.skpd_id, users.ppk_id, roles.name as role_name, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, ppk.name as ppk_name')
                ->join('roles', 'roles.id = users.role_id', 'left')
                ->join('skpd', 'skpd.id = users.skpd_id', 'left')
                ->join('ppk', 'ppk.id = users.ppk_id', 'left')
                ->where('users.id', (int) session()->get('user_id'))
                ->first();

            // RUP siap dibuatkan paket: aktif (rup_status = 1) dan belum terikat paket aktif
            if ($this->canWrite()) {
                $usedRupIds = $this->paketModel->where('status_paket !=', 0)->findColumn('rup_id') ?? [];

                $availableRupQuery = $this->rupModel
                    ->select('rup.*, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, ppk.name as ppk_name, jenis_pengadaan.name as jenis_pengadaan_name')
                    ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
                    ->join('ppk', 'ppk.id = rup.ppk_id', 'left')
                    ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
                    ->where('rup.rup_status', 1);

                if (! empty($usedRupIds)) {
                    $availableRupQuery->whereNotIn('rup.id', $usedRupIds);
                }

                $this->scopeToActor($availableRupQuery, 'rup.skpd_id', 'rup.ppk_id');
                $availableRups = $availableRupQuery->orderBy('rup.id', 'DESC')->findAll();
            }
        } catch (\Throwable $e) {
            log_message('error', 'Error in PaketController::index: ' . $e->getMessage());
            $pakets = $skpdList = $availableRups = [];
            $currentUser = null;
        }

        // Kalkulasi statistik dalam satu iterasi
        $totalHps = $totalKontrak = 0;
        $draftCount = $prosesCount = $selesaiCount = $tayangCount = 0;
        foreach ($pakets as $p) {
            $st = (int) ($p['status_paket'] ?? 0);
            $totalHps     += (float) ($p['nilai_hps'] ?? 0);
            $totalKontrak += (float) ($p['nilai_kontrak'] ?? 0);
            $draftCount   += $st === 1 ? 1 : 0;
            $prosesCount  += ($st >= 2 && $st <= 12) ? 1 : 0;
            $selesaiCount += $st === 14 ? 1 : 0;
            $tayangCount  += $st === 9 ? 1 : 0;
        }

        return view('paket', [
            'pageTitle'       => 'Daftar Paket Pengadaan',
            'pakets'          => $pakets,
            'skpdList'        => $skpdList,
            'availableRups'   => $availableRups,
            'statusPaketList' => PaketModel::STATUS_PAKET,
            'currentUser'     => $currentUser,
            'canAjukanPaket'  => $this->canAjukan(),
            'totalPaket'      => count($pakets),
            'totalHps'        => $totalHps,
            'totalKontrak'    => $totalKontrak,
            'draftCount'      => $draftCount,
            'selesaiCount'    => $selesaiCount,
            'prosesCount'     => $prosesCount,
            'tayangCount'     => $tayangCount,
        ]);
    }

    /**
     * Simpan paket pengadaan baru sebagai DRAF
     * - no_paket masih kosong, status_paket = 1 (Draft), tgl_paket = hari ini
     */
    public function store()
    {
        $rules = [
            'rup_id'    => 'required|is_natural_no_zero|is_not_unique[rup.id]',
            'no_rpp'    => 'required|min_length[3]|max_length[1000]',
            'nilai_hps' => 'required|max_length[30]',
        ];

        if (! $this->validate($rules)) {
            return $this->failWith(implode(' ', $this->validator->getErrors()), 422, '/paket');
        }

        $rupId = (int) $this->request->getPost('rup_id');

        // Format nilai HPS (bersihkan karakter format Rupiah)
        $cleanHps = str_replace(['Rp', ' ', '.'], '', (string) $this->request->getPost('nilai_hps'));
        $cleanHps = str_replace(',', '.', $cleanHps);

        if (! is_numeric($cleanHps) || (float) $cleanHps <= 0 || (float) $cleanHps >= 1e15) {
            return $this->failWith('Nilai HPS tidak valid; harus lebih besar dari 0.', 422, '/paket');
        }
        $nilaiHps = (float) $cleanHps;

        $db = db_connect();

        try {
            $db->transBegin();

            // Kunci baris RUP agar dua request bersamaan tidak membuat paket ganda
            $rup = $db->query('SELECT id, skpd_id, ppk_id, rup_status FROM rup WHERE id = ? FOR UPDATE', [$rupId])->getRowArray();

            if (! $rup || ! $this->inScope($rup)) {
                $db->transRollback();
                return $this->failWith('Data RUP yang dipilih tidak ditemukan.', 404, '/paket');
            }
            if ((int) $rup['rup_status'] !== 1) {
                $db->transRollback();
                return $this->failWith('RUP ini sudah terkunci dan tidak dapat dibuatkan paket baru.', 422, '/paket');
            }
            if ($this->paketModel->where('rup_id', $rupId)->countAllResults() > 0) {
                $db->transRollback();
                return $this->failWith('Paket untuk RUP ini sudah pernah dibuat sebelumnya.', 409, '/paket');
            }

            $insertId = $this->paketModel->insert([
                'no_paket'          => null,
                'rup_id'            => $rupId,
                'no_rpp'            => trim((string) $this->request->getPost('no_rpp')),
                'nilai_hps'         => $nilaiHps,
                'tgl_paket'         => date('Y-m-d'),
                'status_paket'      => 1,
                'status_verifikasi' => 0,
                'nilai_kontrak'     => 0,
                'is_lpse'           => 0,
            ]);

            if (! $insertId) {
                $db->transRollback();
                return $this->failWith('Gagal menyimpan data paket.', 500, '/paket');
            }

            // Kunci RUP segera setelah paket dibuat agar RUP tidak dapat diedit/dihapus
            $db->table('rup')->where('id', $rupId)->update([
                'rup_status' => 2,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();

            return $this->okWith(
                "Draf paket pengadaan berhasil dibuat! Data RUP terkait kini telah dikunci. Silakan lengkapi syarat dan klik 'Ajukan' untuk memproses paket ke UKPBJ.",
                ['paket_id' => $insertId],
                '/paket'
            );
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Error in PaketController::store: ' . $e->getMessage());

            return $this->failWith('Gagal menyimpan data paket. Silakan coba lagi.', 500, '/paket');
        }
    }

    /**
     * Perbarui data paket pengadaan (hanya selama masih berstatus Draft / status_paket == 1)
     */
    public function update($id = null)
    {
        $paket = $this->findPaketForActor((int) $id, true, $error);
        if (! $paket) {
            return $error;
        }

        if ((int) $paket['status_paket'] !== 1) {
            return $this->failWith('Paket ini sudah diajukan atau diproses sehingga tidak dapat diubah.', 422, '/paket');
        }

        $rules = [
            'no_rpp'    => 'required|min_length[3]|max_length[1000]',
            'nilai_hps' => 'required|max_length[30]',
        ];

        if (! $this->validate($rules)) {
            return $this->failWith(implode(' ', $this->validator->getErrors()), 422, '/paket');
        }

        $cleanHps = str_replace(['Rp', ' ', '.'], '', (string) $this->request->getPost('nilai_hps'));
        $cleanHps = str_replace(',', '.', $cleanHps);

        if (! is_numeric($cleanHps) || (float) $cleanHps <= 0 || (float) $cleanHps >= 1e15) {
            return $this->failWith('Nilai HPS tidak valid; harus lebih besar dari 0.', 422, '/paket');
        }
        $nilaiHps = (float) $cleanHps;

        try {
            $this->paketModel->update((int) $paket['id'], [
                'no_rpp'    => trim((string) $this->request->getPost('no_rpp')),
                'nilai_hps' => $nilaiHps,
            ]);

            return $this->okWith('Data paket pengadaan berhasil diperbarui!', ['paket_id' => (int) $paket['id']], '/paket');
        } catch (\Throwable $e) {
            log_message('error', 'Error in PaketController::update: ' . $e->getMessage());

            return $this->failWith('Gagal memperbarui data paket. Silakan coba lagi.', 500, '/paket');
        }
    }

    /**
     * Hapus paket pengadaan (hanya selama masih berstatus Draft / status_paket == 1):
     * - Menghapus seluruh dokumen persyaratan terkait (tabel syarat juga ON DELETE CASCADE) beserta file fisiknya di storage
     * - Membuka kembali kunci pada RUP terkait (rup_status = 1) agar RUP dapat diedit/dihapus atau dibuatkan paket ulang
     */
    public function delete($id = null)
    {
        $paket = $this->findPaketForActor((int) $id, true, $error);
        if (! $paket) {
            return $error;
        }

        if ((int) $paket['status_paket'] !== 1) {
            return $this->failWith('Paket yang sudah diajukan atau sedang diproses tidak dapat dihapus.', 422, '/paket');
        }

        $paketId = (int) $paket['id'];
        $rupId   = (int) ($paket['rup_id'] ?? 0);

        // Ambil daftar file fisik syarat sebelum paket dihapus
        $syaratRows    = $this->syaratModel->select('id, nama_file')->where('paket_id', $paketId)->findAll();
        $filesToRemove = array_filter(array_column($syaratRows, 'nama_file'));

        $db = db_connect();

        try {
            $db->transBegin();

            // Hapus syarat terkait (database juga dilengkapi ON DELETE CASCADE pada syarat.paket_id & paket_pokja.paket_id)
            $this->syaratModel->where('paket_id', $paketId)->delete();

            // Hapus paket
            $this->paketModel->delete($paketId);

            // Buka kembali akses edit/delete pada RUP terkait (rup_status = 1)
            if ($rupId > 0) {
                $db->table('rup')->where('id', $rupId)->update([
                    'rup_status' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Error in PaketController::delete: ' . $e->getMessage());

            return $this->failWith('Gagal menghapus paket pengadaan. Silakan coba lagi.', 500, '/paket');
        }

        // Hapus seluruh file fisik persyaratan dari direktori writable/uploads/syarat/
        foreach ($filesToRemove as $fileName) {
            $this->removeFile($fileName);
        }

        return $this->okWith(
            'Paket pengadaan beserta seluruh dokumen persyaratannya berhasil dihapus! Data RUP terkait kini kembali terbuka.',
            ['paket_id' => $paketId],
            '/paket'
        );
    }

    /**
     * Ajukan paket pengadaan:
     * - no_paket bertambah +1 (dengan penguncian agar tidak ada nomor ganda)
     * - status_paket menjadi 2 (Pengajuan), tgl_pengajuan = hari ini
     * - rup_status pada tabel rup menjadi 2 (Terkunci)
     */
    public function ajukan($id = null)
    {
        if (! $this->canAjukan()) {
            return $this->failWith('Hanya Pejabat Pembuat Komitmen (PPK) yang memiliki kewenangan untuk mengajukan paket ke UKPBJ.', 403, '/paket');
        }

        $paket = $this->findPaketForActor((int) $id, true, $error);
        if (! $paket) {
            return $error;
        }

        if ((int) $paket['status_paket'] !== 1) {
            return $this->failWith('Paket ini sudah diajukan sebelumnya.', 400, '/paket');
        }

        $paketId = (int) $paket['id'];

        // Pastikan syarat default sudah digenerate, lalu cek kelengkapan dokumen wajib
        $this->syaratModel->generateDefaultSyarat($paketId);

        $missing = $this->syaratModel->select('nama_persyaratan')
            ->where('paket_id', $paketId)
            ->where('wajib', 1)
            ->groupStart()->where('nama_file IS NULL')->orWhere('nama_file', '')->groupEnd()
            ->findAll();

        if (! empty($missing)) {
            $names = array_column($missing, 'nama_persyaratan');
            $msg   = 'Pengajuan gagal! Terdapat ' . count($names) . ' dokumen persyaratan wajib yang belum diunggah: ' . implode('; ', $names);

            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status' => 'error', 'message' => $msg, 'missing_syarat' => $names,
                ]);
            }

            return redirect()->back()->with('error', $msg);
        }

        $db     = db_connect();
        $locked = false;

        try {
            // Lock global nomor paket: mencegah dua pengajuan bersamaan memperoleh nomor yang sama
            $locked = (int) ($db->query("SELECT GET_LOCK('simpple_no_paket', 10) AS l")->getRow()->l ?? 0) === 1;
            if (! $locked) {
                return $this->failWith('Sistem sedang sibuk, silakan coba lagi.', 503, '/paket');
            }

            $db->transBegin();

            $row     = $db->query("SELECT MAX(CAST(no_paket AS UNSIGNED)) AS m FROM paket WHERE no_paket IS NOT NULL AND no_paket <> ''")->getRowArray();
            $newNo   = sprintf('%04d', ((int) ($row['m'] ?? 0)) + 1);
            $now     = date('Y-m-d H:i:s');

            // Update bersyarat: hanya jika paket masih berstatus Draft
            $db->table('paket')
                ->where('id', $paketId)
                ->where('status_paket', 1)
                ->update(['no_paket' => $newNo, 'status_paket' => 2, 'tgl_pengajuan' => date('Y-m-d'), 'updated_at' => $now]);

            if ($db->affectedRows() !== 1) {
                $db->transRollback();
                return $this->failWith('Paket ini sudah diajukan sebelumnya.', 409, '/paket');
            }

            if (! empty($paket['rup_id'])) {
                $db->table('rup')->where('id', (int) $paket['rup_id'])->update(['rup_status' => 2, 'updated_at' => $now]);
            }

            $db->transCommit();

            return $this->okWith(
                "Paket berhasil diajukan dengan Nomor Paket: {$newNo}! Data RUP terkait kini telah terkunci.",
                ['no_paket' => $newNo],
                '/paket'
            );
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Error in PaketController::ajukan: ' . $e->getMessage());

            return $this->failWith('Gagal mengajukan paket. Silakan coba lagi.', 500, '/paket');
        } finally {
            if ($locked) {
                $db->query("SELECT RELEASE_LOCK('simpple_no_paket')");
            }
        }
    }

    /**
     * Ambil daftar dokumen persyaratan untuk suatu paket (JSON)
     */
    public function getSyarat($paketId)
    {
        $paket = $this->findPaketForActor((int) $paketId, false, $error);
        if (! $paket) {
            return $error;
        }

        try {
            $paketId = (int) $paket['id'];
            $this->syaratModel->generateDefaultSyarat($paketId);
            $syaratList = $this->syaratModel->getByPaketId($paketId);

            $totalWajib = $wajibUploaded = 0;
            $missingWajib = [];

            foreach ($syaratList as &$s) {
                $isUploaded       = ! empty($s['nama_file']);
                $s['is_uploaded'] = $isUploaded;
                // Dokumen dilayani lewat route terotorisasi, bukan URL publik
                $s['file_url']    = $isUploaded ? site_url('paket/syarat/download/' . $s['id']) : null;

                if ((int) $s['wajib'] === 1) {
                    $totalWajib++;
                    if ($isUploaded) {
                        $wajibUploaded++;
                    } else {
                        $missingWajib[] = $s['nama_persyaratan'];
                    }
                }
            }
            unset($s);

            return $this->response->setJSON([
                'status'  => 'success',
                'data'    => $syaratList,
                'summary' => [
                    'total'          => count($syaratList),
                    'total_wajib'    => $totalWajib,
                    'wajib_uploaded' => $wajibUploaded,
                    'missing_wajib'  => $missingWajib,
                    'is_lengkap'     => empty($missingWajib),
                    'can_edit'       => in_array((int) $paket['status_paket'], self::SYARAT_EDITABLE, true) && $this->canWrite(),
                    'can_ajukan'     => empty($missingWajib) && (int) $paket['status_paket'] === 1 && $this->canAjukan(),
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Error in PaketController::getSyarat: ' . $e->getMessage());

            return $this->failWith('Gagal memuat dokumen persyaratan.', 500);
        }
    }

    /**
     * Upload / Ganti file dokumen persyaratan yang ada
     */
    public function uploadSyarat()
    {
        $syarat = $this->syaratModel->find((int) $this->request->getPost('id'));
        if (! $syarat) {
            return $this->failWith('Data persyaratan tidak ditemukan.', 404);
        }

        $paket = $this->findPaketForActor((int) $syarat['paket_id'], true, $error);
        if (! $paket) {
            return $error;
        }
        if (! in_array((int) $paket['status_paket'], self::SYARAT_EDITABLE, true)) {
            return $this->failWith('Paket telah diajukan atau terkunci. Tidak dapat mengubah dokumen.', 403);
        }

        $stored = $this->storeUpload($this->request->getFile('file'), (string) $syarat['nama_persyaratan'], $syarat['format'] ?? null, $err);
        if ($stored === null) {
            return $this->failWith($err, 422);
        }

        $oldFile = $syarat['nama_file'] ?? null;

        try {
            $this->syaratModel->update($syarat['id'], ['nama_file' => $stored, 'selesai' => 1]);
        } catch (\Throwable $e) {
            @unlink($this->uploadDir() . $stored);
            log_message('error', 'Error in uploadSyarat: ' . $e->getMessage());

            return $this->failWith('Gagal menyimpan dokumen.', 500);
        }

        $this->removeFile($oldFile);

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => "Dokumen '{$syarat['nama_persyaratan']}' berhasil diunggah!",
            'nama_file' => $stored,
            'file_url'  => site_url('paket/syarat/download/' . $syarat['id']),
        ]);
    }

    /**
     * Upload persyaratan baru tambahan (auto = 0)
     */
    public function uploadSyaratBaru()
    {
        $nama = trim((string) $this->request->getPost('nama_persyaratan'));
        $hps  = (int) $this->request->getPost('hps') ? 1 : 0;

        if ($nama === '' || mb_strlen($nama) > 150) {
            return $this->failWith('Nama persyaratan wajib diisi (maksimal 150 karakter).', 422);
        }

        $paket = $this->findPaketForActor((int) $this->request->getPost('paket_id'), true, $error);
        if (! $paket) {
            return $error;
        }
        if (! in_array((int) $paket['status_paket'], self::SYARAT_EDITABLE, true)) {
            return $this->failWith('Paket telah diajukan atau terkunci. Tidak dapat menambah syarat baru.', 403);
        }

        $stored = $this->storeUpload($this->request->getFile('file'), $nama, null, $err);
        if ($stored === null) {
            return $this->failWith($err, 422);
        }

        try {
            $insertId = $this->syaratModel->insert([
                'paket_id'         => (int) $paket['id'],
                'nama_persyaratan' => $nama,
                'nama_file'        => $stored,
                'hps'              => $hps,
                'format'           => null,
                'wajib'            => 0,
                'auto'             => 0,
                'selesai'          => 1,
            ]);
        } catch (\Throwable $e) {
            @unlink($this->uploadDir() . $stored);
            log_message('error', 'Error in uploadSyaratBaru: ' . $e->getMessage());

            return $this->failWith('Gagal menyimpan persyaratan tambahan.', 500);
        }

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => "Persyaratan tambahan '{$nama}' berhasil ditambahkan dan diunggah!",
            'syarat_id' => $insertId,
        ]);
    }

    /**
     * Hapus file dokumen atau syarat tambahan
     */
    public function deleteSyarat($id)
    {
        $syarat = $this->syaratModel->find((int) $id);
        if (! $syarat) {
            return $this->failWith('Data persyaratan tidak ditemukan.', 404);
        }

        $paket = $this->findPaketForActor((int) $syarat['paket_id'], true, $error);
        if (! $paket) {
            return $error;
        }
        if (! in_array((int) $paket['status_paket'], self::SYARAT_EDITABLE, true)) {
            return $this->failWith('Paket telah diajukan. Dokumen tidak dapat dihapus.', 403);
        }

        if ((int) $syarat['auto'] === 0) {
            $this->syaratModel->delete($syarat['id']);
            $msg = "Persyaratan tambahan '{$syarat['nama_persyaratan']}' berhasil dihapus.";
        } else {
            $this->syaratModel->update($syarat['id'], ['nama_file' => null, 'selesai' => 0]);
            $msg = "File dokumen '{$syarat['nama_persyaratan']}' berhasil dihapus.";
        }

        $this->removeFile($syarat['nama_file'] ?? null);

        return $this->response->setJSON(['status' => 'success', 'message' => $msg]);
    }

    /**
     * Unduh file dokumen persyaratan (hanya untuk user yang berhak atas paket tersebut)
     */
    public function downloadSyarat($id)
    {
        $syarat = $this->syaratModel->find((int) $id);
        if (! $syarat || empty($syarat['nama_file'])) {
            return redirect()->to('/paket')->with('error', 'Dokumen belum diunggah.');
        }

        $paket = $this->findPaketForActor((int) $syarat['paket_id'], false, $error);
        if (! $paket) {
            return redirect()->to('/paket')->with('error', 'Anda tidak memiliki akses ke dokumen ini.');
        }

        // basename() mencegah path traversal bila nilai di database pernah dimanipulasi
        $filePath = $this->uploadDir() . basename($syarat['nama_file']);
        if (! is_file($filePath)) {
            return redirect()->to('/paket')->with('error', 'File fisik tidak ditemukan pada server.');
        }

        return $this->response->download($filePath, null)->setFileName(basename($syarat['nama_file']));
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    /**
     * Muat paket beserta SKPD/PPK pemilik RUP-nya dan pastikan berada dalam cakupan user.
     * Untuk operasi tulis, role juga harus termasuk WRITE_ROLES.
     *
     * @param mixed $error diisi response error bila mengembalikan null
     */
    private function findPaketForActor(int $id, bool $forWrite, &$error = null): ?array
    {
        $paket = $id > 0
            ? $this->paketModel->select('paket.*, rup.skpd_id, rup.ppk_id')
                ->join('rup', 'rup.id = paket.rup_id', 'left')
                ->where('paket.id', $id)->first()
            : null;

        // Data di luar cakupan diperlakukan sama seperti tidak ada (tidak membocorkan keberadaan)
        if (! $paket || ! $this->inScope($paket)) {
            $error = $this->failWith('Data paket tidak ditemukan.', 404, '/paket');
            return null;
        }

        if ($forWrite && ! $this->canWrite()) {
            $error = $this->failWith('Anda tidak memiliki hak akses untuk mengubah data ini.', 403, '/paket');
            return null;
        }

        return $paket;
    }

    private function uploadDir(): string
    {
        // Di luar webroot: file hanya bisa diakses melalui route terotorisasi
        return WRITEPATH . 'uploads/syarat/';
    }

    private function removeFile(?string $name): void
    {
        if (! empty($name)) {
            $path = $this->uploadDir() . basename($name);
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }

    /**
     * Validasi & simpan file upload. Mengembalikan nama file tersimpan, atau null (+ $error).
     */
    private function storeUpload(?UploadedFile $file, string $label, ?string $formatRule, ?string &$error = null): ?string
    {
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            $error = 'File dokumen tidak valid atau belum dipilih.';
            return null;
        }
        if ($file->getSize() > self::MAX_FILE_BYTES) {
            $error = 'Ukuran file melebihi batas ' . (self::MAX_FILE_BYTES / 1024 / 1024) . ' MB.';
            return null;
        }

        $ext     = strtolower($file->getClientExtension());
        $allowed = array_keys(self::ALLOWED_FILES);

        if (! empty($formatRule)) {
            $allowed = array_values(array_intersect($allowed, array_map('trim', explode(',', strtolower($formatRule)))));
        }

        if (! in_array($ext, $allowed, true)) {
            $error = 'Format file tidak sesuai! Format yang diperbolehkan: .' . implode(', .', $allowed);
            return null;
        }

        // Cocokkan isi file (finfo) dengan ekstensi, agar file berbahaya tidak bisa menyamar
        if (! in_array($file->getMimeType(), self::ALLOWED_FILES[$ext], true)) {
            $error = 'Isi file tidak sesuai dengan ekstensinya (.' . $ext . ').';
            return null;
        }

        $dir = $this->uploadDir();
        if (! is_dir($dir) && ! mkdir($dir, 0750, true) && ! is_dir($dir)) {
            $error = 'Direktori penyimpanan tidak dapat dibuat.';
            return null;
        }

        // Nama file acak (tidak dapat ditebak) dengan awalan slug agar tetap mudah dikenali
        $slug     = substr(url_title(strtolower($label), '-', true), 0, 60) ?: 'dokumen';
        $fileName = $slug . '-' . bin2hex(random_bytes(8)) . '.' . $ext;

        try {
            $file->move($dir, $fileName);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal memindahkan upload: ' . $e->getMessage());
            $error = 'Gagal menyimpan file ke server.';
            return null;
        }

        return $fileName;
    }

    /**
     * Format data baris paket untuk representasi visual UI
     */
    protected function formatPaketRow(array $item): array
    {
        // Status Tahapan Paket (16 Status Resmi: 0 - 15)
        $statusInt = (int) ($item['status_paket'] ?? 1);
        $statusInfo = PaketModel::getStatusInfo($statusInt);
        $item['status_label'] = $statusInfo['name'];
        $item['status_badge'] = $statusInfo['badge'];
        $item['status_desc']  = $statusInfo['desc'];

        // Status Verifikasi Berkas UKPBJ
        $verifInt = (int) ($item['status_verifikasi'] ?? 0);
        $item['verifikasi_label'] = match ($verifInt) {
            1       => 'Disetujui',
            2       => 'Perbaikan',
            default => 'Menunggu',
        };

        $item['verifikasi_badge'] = match ($verifInt) {
            1       => 'bg-success-subtle text-success border border-success-subtle',
            2       => 'bg-danger-subtle text-danger border border-danger-subtle',
            default => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
        };

        // Jenis Pengadaan Badge
        $procType = $item['jenis_pengadaan_name'] ?? 'Barang';
        $item['proc_badge'] = match ($procType) {
            'Barang'                                => 'badge-proc-barang',
            'Pekerjaan Konstruksi'                  => 'badge-proc-konstruksi',
            'Jasa Konsultansi', 'Jasa Konsultasi'   => 'badge-proc-konsultasi',
            'Jasa Lainnya'                          => 'badge-proc-lainnya',
            'Pekerjaan Terintegrasi'                => 'badge-proc-terintegrasi',
            default                                 => 'badge-proc-default',
        };

        return $item;
    }
}
