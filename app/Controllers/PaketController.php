<?php

namespace App\Controllers;

use App\Models\PaketModel;
use App\Models\PaketPokjaModel;
use App\Models\RupModel;
use App\Models\SkpdModel;
use App\Models\SyaratModel;
use App\Models\UserModel;

class PaketController extends BaseController
{
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
        try {
            $paketsFromDb = $this->paketModel->getWithRelations();

            // Ambil anggota pokja untuk seluruh paket
            $allPokja = $this->paketPokjaModel
                ->select('paket_pokja.*, users.full_name, users.username')
                ->join('users', 'users.id = paket_pokja.user_id', 'left')
                ->findAll();

            $pokjaByPaket = [];
            foreach ($allPokja as $row) {
                $pokjaByPaket[$row['paket_id']][] = $row;
            }

            // Format data paket
            $pakets = array_map(function ($item) use ($pokjaByPaket) {
                $item['pokja_members'] = $pokjaByPaket[$item['id']] ?? [];
                return $this->formatPaketRow($item);
            }, $paketsFromDb);

            // Master SKPD untuk filter
            $skpdList = $this->skpdModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

            // Current user info
            $currentUserId = session()->get('user_id');
            $currentUser   = null;
            if ($currentUserId) {
                $currentUser = $this->userModel
                    ->select('users.*, roles.name as role_name, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, ppk.name as ppk_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->join('skpd', 'skpd.id = users.skpd_id', 'left')
                    ->join('ppk', 'ppk.id = users.ppk_id', 'left')
                    ->where('users.id', $currentUserId)
                    ->first();
            }

            // Ambil RUP yang siap dibuatkan paket:
            // 1. RUP berstatus aktif (rup_status = 1)
            // 2. Belum pernah terikat dengan paket aktif (status_paket != 0)
            $usedRupIds = $this->paketModel
                ->where('status_paket !=', 0)
                ->findColumn('rup_id') ?? [];

            $availableRupQuery = $this->rupModel
                ->select('rup.*, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, ppk.name as ppk_name, jenis_pengadaan.name as jenis_pengadaan_name')
                ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
                ->join('ppk', 'ppk.id = rup.ppk_id', 'left')
                ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
                ->where('rup.rup_status', 1);

            // Kecualikan RUP yang sudah digunakan di paket aktif
            if (!empty($usedRupIds)) {
                $availableRupQuery->whereNotIn('rup.id', $usedRupIds);
            }

            // Filter milik user yang sedang login (kecuali administrator pusat)
            if ($currentUser && ($currentUser['role_id'] ?? 0) != 1) {
                if (!empty($currentUser['ppk_id'])) {
                    $availableRupQuery->where('rup.ppk_id', $currentUser['ppk_id']);
                } elseif (!empty($currentUser['skpd_id'])) {
                    $availableRupQuery->where('rup.skpd_id', $currentUser['skpd_id']);
                }
            }

            $availableRups = $availableRupQuery->orderBy('rup.id', 'DESC')->findAll();

        } catch (\Throwable $e) {
            log_message('error', 'Error in PaketController::index: ' . $e->getMessage());
            $pakets        = [];
            $skpdList      = [];
            $availableRups = [];
            $currentUser   = null;
        }

        // Kalkulasi Statistik
        $totalPaket   = count($pakets);
        $totalHps     = array_sum(array_column($pakets, 'nilai_hps'));
        $totalKontrak = array_sum(array_column($pakets, 'nilai_kontrak'));
        $draftCount   = count(array_filter($pakets, fn($p) => (int)($p['status_paket'] ?? 0) === 1));
        $prosesCount  = count(array_filter($pakets, fn($p) => in_array((int)($p['status_paket'] ?? 0), range(2, 12))));
        $selesaiCount = count(array_filter($pakets, fn($p) => (int)($p['status_paket'] ?? 0) === 14));
        $tayangCount  = count(array_filter($pakets, fn($p) => (int)($p['status_paket'] ?? 0) === 9));

        return view('paket', [
            'pageTitle'       => 'Daftar Paket Pengadaan',
            'pakets'          => $pakets,
            'skpdList'        => $skpdList,
            'availableRups'   => $availableRups,
            'statusPaketList' => PaketModel::STATUS_PAKET,
            'currentUser'     => $currentUser,
            'totalPaket'      => $totalPaket,
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
     * - no_paket masih kosong
     * - status_paket = 1 (Draft)
     * - tgl_paket = tanggal saat ini
     */
    public function store()
    {
        $currentUserId = session()->get('user_id');
        if (! $currentUserId) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Sesi login telah kedaluwarsa. Silakan login kembali.'])->setStatusCode(401);
            }
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $rules = [
            'rup_id'    => 'required|is_not_unique[rup.id]',
            'no_rpp'    => 'required|min_length[3]',
            'nilai_hps' => 'required',
        ];

        if (! $this->validate($rules)) {
            $errors = implode('<br>', $this->validator->getErrors());
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $errors,
                    'errors'  => $this->validator->getErrors(),
                ])->setStatusCode(400);
            }
            return redirect()->back()->withInput()->with('error', $errors);
        }

        try {
            $rupId = (int) $this->request->getPost('rup_id');

            // Validasi keberadaan RUP
            $rup = $this->rupModel->find($rupId);
            if (! $rup) {
                throw new \RuntimeException('Data RUP yang dipilih tidak ditemukan.');
            }

            // Validasi apakah RUP sudah pernah dibuatkan paket
            $existing = $this->paketModel->where('rup_id', $rupId)->first();
            if ($existing) {
                throw new \RuntimeException('Paket untuk RUP ini sudah pernah dibuat sebelumnya.');
            }

            // Format nilai HPS (bersihkan karakter format Rupiah)
            $rawHps   = (string) $this->request->getPost('nilai_hps');
            $cleanHps = str_replace(['Rp', ' ', '.'], '', $rawHps);
            $cleanHps = str_replace(',', '.', $cleanHps);
            $nilaiHps = (float) $cleanHps;

            if ($nilaiHps <= 0) {
                throw new \RuntimeException('Nilai HPS harus lebih besar dari 0.');
            }

            // Data paket baru: no_paket masih kosong, status_paket = 1 (Draft)
            $dataPaket = [
                'no_paket'          => null,          // no_paket masih kosong
                'rup_id'            => $rupId,
                'no_rpp'            => trim((string) $this->request->getPost('no_rpp')),
                'nilai_hps'         => $nilaiHps,
                'tgl_paket'         => date('Y-m-d'), // otomatis tanggal saat create
                'status_paket'      => 1,             // status_paket nilai 1 (Draft)
                'status_verifikasi' => 0,             // menunggu verifikasi berkas
                'nilai_kontrak'     => 0,
                'is_lpse'           => 0,
            ];

            $insertId = $this->paketModel->insert($dataPaket);
            if (! $insertId) {
                throw new \RuntimeException('Gagal menyimpan data paket ke database.');
            }

            $msg = "Draf paket pengadaan berhasil dibuat! Silakan tinjau dan klik tombol 'Ajukan' untuk memproses paket ke UKPBJ.";

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'   => 'success',
                    'message'  => $msg,
                    'paket_id' => $insertId,
                ]);
            }

            return redirect()->to('/paket')->with('success', $msg);

        } catch (\Throwable $e) {
            log_message('error', 'Error in PaketController::store: ' . $e->getMessage());
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ])->setStatusCode(500);
            }
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Ajukan paket pengadaan:
     * - no_paket bertambah +1
     * - status_paket berubah menjadi 2 (Pengajuan)
     * - tgl_pengajuan diisi tanggal saat ini
     * - di tabel rup, field rup_status berubah menjadi 2 (Terkunci)
     */
    public function ajukan($id = null)
    {
        $currentUserId = session()->get('user_id');
        if (! $currentUserId) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Sesi login telah kedaluwarsa. Silakan login kembali.'])->setStatusCode(401);
            }
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $paket = $this->paketModel->find($id);
        if (! $paket) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data paket tidak ditemukan.'])->setStatusCode(404);
            }
            return redirect()->back()->with('error', 'Data paket tidak ditemukan.');
        }

        if ((int) $paket['status_paket'] !== 1) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Paket ini sudah diajukan sebelumnya.'])->setStatusCode(400);
            }
            return redirect()->back()->with('error', 'Paket ini sudah diajukan sebelumnya.');
        }

        // 1. Pastikan 8 syarat default sudah digenerate jika belum
        $this->syaratModel->generateDefaultSyarat((int) $id);

        // 2. Validasi kelengkapan dokumen persyaratan wajib (wajib = 1)
        $unuploadedWajib = $this->syaratModel->where('paket_id', $id)
            ->where('wajib', 1)
            ->groupStart()
                ->where('nama_file IS NULL')
                ->orWhere('nama_file', '')
            ->groupEnd()
            ->findAll();

        if (!empty($unuploadedWajib)) {
            $missingNames = array_column($unuploadedWajib, 'nama_persyaratan');
            $errMsg = 'Pengajuan gagal! Terdapat ' . count($missingNames) . ' dokumen persyaratan wajib yang belum diunggah:<br>&bull; ' . implode('<br>&bull; ', $missingNames);
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'         => 'error',
                    'message'        => $errMsg,
                    'missing_syarat' => $missingNames,
                ])->setStatusCode(422);
            }
            return redirect()->back()->with('error', $errMsg);
        }

        try {
            // Ambil nomor paket terakhir yang terisi untuk increment +1
            $latestPaket = $this->paketModel
                ->where('no_paket IS NOT NULL')
                ->where('no_paket !=', '')
                ->orderBy('CAST(no_paket AS UNSIGNED)', 'DESC')
                ->first();

            $nextNum = 1;
            if ($latestPaket && !empty($latestPaket['no_paket']) && is_numeric($latestPaket['no_paket'])) {
                $nextNum = ((int) $latestPaket['no_paket']) + 1;
            }

            $newNoPaket = sprintf('%04d', $nextNum);

            // Update paket: no_paket terisi, status_paket = 2, tgl_pengajuan hari ini
            $this->paketModel->update($id, [
                'no_paket'      => $newNoPaket,
                'status_paket'  => 2,
                'tgl_pengajuan' => date('Y-m-d'),
            ]);

            // Update di tabel rup: rup_status berubah menjadi 2 (Terkunci)
            if (!empty($paket['rup_id'])) {
                $this->rupModel->update($paket['rup_id'], [
                    'rup_status' => 2,
                ]);
            }

            $msg = "Paket berhasil diajukan dengan Nomor Paket: {$newNoPaket}! Data RUP terkait kini telah terkunci.";

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'   => 'success',
                    'message'  => $msg,
                    'no_paket' => $newNoPaket,
                ]);
            }

            return redirect()->to('/paket')->with('success', $msg);

        } catch (\Throwable $e) {
            log_message('error', 'Error in PaketController::ajukan: ' . $e->getMessage());
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengajukan paket: ' . $e->getMessage()])->setStatusCode(500);
            }
            return redirect()->back()->with('error', 'Gagal mengajukan paket: ' . $e->getMessage());
        }
    }

    /**
     * Ambil daftar dokumen persyaratan untuk suatu paket (JSON)
     */
    public function getSyarat($paketId)
    {
        try {
            $paket = $this->paketModel->find($paketId);
            if (!$paket) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Paket tidak ditemukan.'])->setStatusCode(404);
            }

            // Pastikan 8 syarat default sudah digenerate jika belum ada
            $this->syaratModel->generateDefaultSyarat((int) $paketId);

            $syaratList = $this->syaratModel->getByPaketId((int) $paketId);

            $totalWajib    = 0;
            $wajibUploaded = 0;
            $missingWajib  = [];

            foreach ($syaratList as &$s) {
                $isUploaded = !empty($s['nama_file']);
                $s['is_uploaded'] = $isUploaded;
                $s['file_url']    = $isUploaded ? base_url('uploads/syarat/' . $s['nama_file']) : null;

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
                    'can_ajukan'     => empty($missingWajib) && ((int) $paket['status_paket'] === 1),
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Error in PaketController::getSyarat: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()])->setStatusCode(500);
        }
    }

    /**
     * Upload / Ganti file dokumen persyaratan yang ada
     */
    public function uploadSyarat()
    {
        $id = $this->request->getPost('id');
        $syarat = $this->syaratModel->find($id);
        if (!$syarat) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data persyaratan tidak ditemukan.'])->setStatusCode(404);
        }

        $paket = $this->paketModel->find($syarat['paket_id']);
        if (!$paket || (int) $paket['status_paket'] !== 1) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Paket telah diajukan atau terkunci. Tidak dapat mengubah dokumen.'])->setStatusCode(403);
        }

        $file = $this->request->getFile('file');
        if (!$file || ! $file->isValid()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File dokumen tidak valid atau belum dipilih.'])->setStatusCode(400);
        }

        // Validasi ekstensi sesuai field format jika ditentukan
        $ext = strtolower($file->getClientExtension());
        if (!empty($syarat['format'])) {
            $allowed = array_map('trim', explode(',', strtolower($syarat['format'])));
            if (!in_array($ext, $allowed, true)) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => "Format file tidak sesuai! Ketentuan format untuk persyaratan ini: ." . implode(', .', $allowed),
                ])->setStatusCode(400);
            }
        }

        // Generate nama file: slug-timestamp.ext
        $cleanName = url_title(strtolower($syarat['nama_persyaratan']), '-', true);
        $fileName = $cleanName . '-' . time() . '.' . $ext;

        $uploadPath = FCPATH . 'uploads/syarat/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Hapus file lama jika ada
        if (!empty($syarat['nama_file']) && file_exists($uploadPath . $syarat['nama_file'])) {
            @unlink($uploadPath . $syarat['nama_file']);
        }

        $file->move($uploadPath, $fileName);

        $this->syaratModel->update($id, [
            'nama_file' => $fileName,
            'selesai'   => 1,
        ]);

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => "Dokumen '{$syarat['nama_persyaratan']}' berhasil diunggah!",
            'nama_file' => $fileName,
            'file_url'  => base_url('uploads/syarat/' . $fileName),
        ]);
    }

    /**
     * Upload persyaratan baru tambahan (auto = 0)
     */
    public function uploadSyaratBaru()
    {
        $paketId = $this->request->getPost('paket_id');
        $nama    = trim((string) $this->request->getPost('nama_persyaratan'));
        $hps     = (int) $this->request->getPost('hps') ? 1 : 0;

        if (!$paketId || empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama persyaratan wajib diisi.'])->setStatusCode(400);
        }

        $paket = $this->paketModel->find($paketId);
        if (!$paket || (int) $paket['status_paket'] !== 1) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Paket telah diajukan atau terkunci. Tidak dapat menambah syarat baru.'])->setStatusCode(403);
        }

        $file = $this->request->getFile('file');
        if (!$file || ! $file->isValid()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File dokumen wajib dipilih untuk diunggah.'])->setStatusCode(400);
        }

        $ext       = strtolower($file->getClientExtension());
        $cleanName = url_title(strtolower($nama), '-', true);
        $fileName  = $cleanName . '-' . time() . '.' . $ext;

        $uploadPath = FCPATH . 'uploads/syarat/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $fileName);

        $insertId = $this->syaratModel->insert([
            'paket_id'         => $paketId,
            'nama_persyaratan' => $nama,
            'nama_file'        => $fileName,
            'hps'              => $hps,
            'format'           => null, // Bebas
            'wajib'            => 0,    // Tambahan manual
            'auto'             => 0,    // Tambahan manual dari pengguna/PPK
            'selesai'          => 1,
        ]);

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
        $syarat = $this->syaratModel->find($id);
        if (!$syarat) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data persyaratan tidak ditemukan.'])->setStatusCode(404);
        }

        $paket = $this->paketModel->find($syarat['paket_id']);
        if (!$paket || (int) $paket['status_paket'] !== 1) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Paket telah diajukan. Dokumen tidak dapat dihapus.'])->setStatusCode(403);
        }

        $uploadPath = FCPATH . 'uploads/syarat/';
        if (!empty($syarat['nama_file']) && file_exists($uploadPath . $syarat['nama_file'])) {
            @unlink($uploadPath . $syarat['nama_file']);
        }

        if ((int) $syarat['auto'] === 0) {
            // Syarat tambahan (auto = 0): hapus seluruh record dari database
            $this->syaratModel->delete($id);
            $msg = "Persyaratan tambahan '{$syarat['nama_persyaratan']}' berhasil dihapus.";
        } else {
            // Syarat default (auto = 1): reset nama_file menjadi null
            $this->syaratModel->update($id, [
                'nama_file' => null,
                'selesai'   => 0,
            ]);
            $msg = "File dokumen '{$syarat['nama_persyaratan']}' berhasil dihapus.";
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => $msg,
        ]);
    }

    /**
     * Unduh file dokumen persyaratan
     */
    public function downloadSyarat($id)
    {
        $syarat = $this->syaratModel->find($id);
        if (!$syarat || empty($syarat['nama_file'])) {
            return redirect()->back()->with('error', 'Dokumen belum diunggah.');
        }

        $filePath = FCPATH . 'uploads/syarat/' . $syarat['nama_file'];
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File fisik tidak ditemukan pada server.');
        }

        return $this->response->download($filePath, null);
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
