<?php

namespace App\Controllers;

use App\Models\SkpdModel;
use App\Models\PpkModel;
use App\Models\JenisBelanjaModel;
use App\Models\SumberDanaModel;
use App\Models\RupModel;
use App\Models\JenisPengadaanModel;
use App\Models\MetodePemilihanModel;
use App\Models\JenisDakModel;
use App\Models\UserModel;

class RupController extends BaseController
{
    protected RupModel $rupModel;
    protected SkpdModel $skpdModel;
    protected PpkModel $officerModel;
    protected JenisBelanjaModel $jenisBelanjaModel;
    protected JenisPengadaanModel $jenisPengadaanModel;
    protected SumberDanaModel $sumberDanaModel;
    protected MetodePemilihanModel $metodePemilihanModel;
    protected JenisDakModel $jenisDakModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->rupModel = new RupModel();
        $this->skpdModel          = new SkpdModel();
        $this->officerModel         = new PpkModel();
        $this->jenisBelanjaModel     = new JenisBelanjaModel();
        $this->jenisPengadaanModel = new JenisPengadaanModel();
        $this->sumberDanaModel   = new SumberDanaModel();
        $this->metodePemilihanModel = new MetodePemilihanModel();
        $this->jenisDakModel  = new JenisDakModel();
        $this->userModel            = new UserModel();
    }

    /**
     * Tampilkan halaman daftar rencana pengadaan (Procurement Plans / RUP)
     */
    public function index()
    {
        try {
            // Ambil data langsung dari tabel rup beserta relasinya
            $plansFromDb = $this->rupModel->getWithRelations();
            $plans       = array_map([$this, 'formatPlanRow'], $plansFromDb);

            // Ambil referensi master data untuk modal/filter
            $skpd         = $this->skpdModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $officers         = $this->officerModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $jenisBelanja     = $this->jenisBelanjaModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $jenisPengadaan = $this->jenisPengadaanModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $sumberDana   = $this->sumberDanaModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $metodePemilihan = $this->metodePemilihanModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $jenisDaks  = $this->jenisDakModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

            // Ambil info lengkap pengguna yang sedang login beserta Instansi/SKPD dan PPK/Bidang
            $currentUserId = session()->get('user_id');
            $currentUser   = null;
            if ($currentUserId) {
                $userObj = $this->userModel
                    ->select('users.*, roles.name as role_name, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, ppk.name as ppk_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->join('skpd', 'skpd.id = users.skpd_id', 'left')
                    ->join('ppk', 'ppk.id = users.ppk_id', 'left')
                    ->where('users.id', $currentUserId)
                    ->first();
                if ($userObj) {
                    // Fallback jika belum ter-assign ppk_id tetapi ada skpd_id
                    if (empty($userObj['ppk_name']) && !empty($userObj['skpd_id'])) {
                        $fallbackOfficer = $this->officerModel->where('skpd_id', $userObj['skpd_id'])->first();
                        if ($fallbackOfficer) {
                            $userObj['ppk_id']   = $fallbackOfficer['id'];
                            $userObj['ppk_name'] = $fallbackOfficer['name'];
                        }
                    }
                    $currentUser = $userObj;
                }
            }

            // Fallback jika belum tersimpan di DB relasi atau Administrator
            if (!$currentUser) {
                $currentUser = [
                    'id'                      => session()->get('user_id'),
                    'full_name'               => session()->get('full_name') ?? 'Pengguna',
                    'skpd_id'               => session()->get('skpd_id') ?? null,
                    'skpd_name'             => session()->get('skpd_name') ?? 'Semua SKPD / Administrator',
                    'skpd_abbr'             => session()->get('skpd_abbr') ?? 'SIMPPEL',
                    'ppk_id'   => session()->get('ppk_id') ?? null,
                    'ppk_name' => session()->get('ppk_name') ?? 'Admin Pengadaan',
                ];
            } elseif (empty($currentUser['skpd_name'])) {
                $currentUser['skpd_name']             = 'Pusat / Administrator';
                $currentUser['skpd_abbr']             = 'SIMPPEL';
                $currentUser['ppk_name'] = $currentUser['ppk_name'] ?? 'Admin Pengadaan';
            }

        } catch (\Throwable $e) {
            log_message('error', 'Error in RupController::index: ' . $e->getMessage());
            $plans            = [];
            $skpd         = [];
            $officers         = [];
            $jenisBelanja     = [];
            $jenisPengadaan = [];
            $sumberDana   = [];
            $metodePemilihan = [];
            $jenisDaks  = [];
            $currentUser      = null;
        }

        // Kalkulasi Statistik dari data database
        $totalPlans     = count($plans);
        $totalBudget    = array_sum(array_column($plans, 'budget_ceiling'));
        $editableCount  = count(array_filter($plans, fn($p) => (int) ($p['rup_status'] ?? 1) === 1));
        $lockedCount    = count(array_filter($plans, fn($p) => (int) ($p['rup_status'] ?? 1) === 2));
        $syncedCount    = count(array_filter($plans, fn($p) => (int) ($p['is_synced'] ?? 0) === 1));
        $dakCount       = count(array_filter($plans, fn($p) => (int) ($p['jenis_dak_id'] ?? 2) === 1));

        return view('rup', [
            'pageTitle'        => 'Daftar Paket RUP',
            'plans'            => $plans,
            'skpd'             => $skpd,
            'officers'         => $officers,
            'jenisBelanja'     => $jenisBelanja,
            'jenisPengadaan'   => $jenisPengadaan,
            'sumberDana'       => $sumberDana,
            'metodePemilihan'  => $metodePemilihan,
            'jenisDaks'        => $jenisDaks,
            'currentUser'      => $currentUser,
            'totalPlans'       => $totalPlans,
            'totalBudget'      => $totalBudget,
            'editableCount'    => $editableCount,
            'lockedCount'      => $lockedCount,
            'syncedCount'      => $syncedCount,
            'dakCount'         => $dakCount,
        ]);
    }

    /**
     * Simpan paket Rencana Pengadaan (RUP) baru
     * Instansi/SKPD dan Pejabat Pembuat Komitmen (PPK) diambil otomatis dari user yang sedang login di backend.
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

        // Ambil data user yang sedang login dari database
        $user = $this->userModel->find($currentUserId);
        if (! $user) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data user tidak ditemukan di sistem.'])->setStatusCode(404);
            }
            return redirect()->back()->with('error', 'Data user tidak ditemukan di sistem.');
        }

        // Instansi / SKPD & PPK otomatis dari user login
        $skpdId            = !empty($user['skpd_id']) ? (int) $user['skpd_id'] : null;
        $ppkId = !empty($user['ppk_id']) ? (int) $user['ppk_id'] : null;

        // Fallback jika user belum memiliki skpd_id (misal Administrator / Superadmin)
        if (! $skpdId) {
            $defaultSkpd = $this->skpdModel->where('id', 16)->first() ?? $this->skpdModel->first();
            $skpdId      = $defaultSkpd ? (int) $defaultSkpd['id'] : 1;
        }

        // Fallback jika user belum memiliki ppk_id
        if (! $ppkId) {
            $existingOfficer = $this->officerModel->where('skpd_id', $skpdId)->first();
            if ($existingOfficer) {
                $ppkId = (int) $existingOfficer['id'];
            } else {
                $officerName = (!empty($user['full_name']) && (int) ($user['role_id'] ?? 0) === 3) ? $user['full_name'] : 'Pejabat Pembuat Komitmen (PPK)';
                $ppkId = (int) $this->officerModel->insert([
                    'skpd_id'  => $skpdId,
                    'name'       => $officerName,
                    'is_active'  => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            // Jika user terafiliasi dengan skpd_id ini, perbarui akun user agar tersinkronisasi
            if (!empty($user['skpd_id']) && (int) $user['skpd_id'] === $skpdId) {
                $this->userModel->update($currentUserId, ['ppk_id' => $ppkId]);
            }
        }

        // Validasi input form
        $rules = [
            'fiscal_year'         => 'required|numeric',
            'activity'            => 'required|min_length[3]',
            'package_name'        => 'required|min_length[3]',
            'jenis_pengadaan_id' => 'required|numeric',
            'metode_pemilihan_id' => 'required|numeric',
            'sumber_dana_id'   => 'required|numeric',
            'budget_ceiling'      => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            $errors = implode(', ', $this->validator->getErrors());
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $errors,
                    'errors'  => $this->validator->getErrors(),
                ])->setStatusCode(422);
            }
            return redirect()->back()->withInput()->with('error', $errors);
        }

        $packageCode = trim((string) $this->request->getPost('package_code'));
        if (empty($packageCode)) {
            $packageCode = 'RUP-' . date('Y') . '-' . mt_rand(10000000, 99999999);
        }

        $budgetCeiling = (float) $this->request->getPost('budget_ceiling');

        $data = [
            'skpd_id'                  => $skpdId,
            'ppk_id'      => $ppkId,
            'fiscal_year'                => (int) $this->request->getPost('fiscal_year'),
            'package_code'               => $packageCode,
            'activity'                   => trim((string) $this->request->getPost('activity')),
            'package_name'               => trim((string) $this->request->getPost('package_name')),
            'jenis_belanja_id'            => $this->request->getPost('jenis_belanja_id') ? (int) $this->request->getPost('jenis_belanja_id') : 1,
            'jenis_pengadaan_id'        => (int) $this->request->getPost('jenis_pengadaan_id'),
            'metode_pemilihan_id'        => (int) $this->request->getPost('metode_pemilihan_id'),
            'sumber_dana_id'          => (int) $this->request->getPost('sumber_dana_id'),
            'jenis_dak_id' => $this->request->getPost('jenis_dak_id') ? (int) $this->request->getPost('jenis_dak_id') : 2,
            'budget_ceiling'             => $budgetCeiling,
            'account_code'               => trim((string) $this->request->getPost('account_code')) ?: null,
            'work_duration'              => $this->request->getPost('work_duration') ? (int) $this->request->getPost('work_duration') : null,
            'location'                   => trim((string) $this->request->getPost('location')) ?: null,
            'description'                => trim((string) $this->request->getPost('description')) ?: null,
            'rup_status'                 => 1, // Bisa Diedit / Aktif
            'is_synced'                  => 0,
            'submission_date'            => date('Y-m-d H:i:s'),
        ];

        try {
            $insertId = $this->rupModel->insert($data);

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Paket Rencana Pengadaan (RUP) berhasil ditambahkan!',
                    'id'      => $insertId,
                ]);
            }

            return redirect()->to('/rup')->with('success', 'Paket Rencana Pengadaan (RUP) berhasil ditambahkan!');
        } catch (\Throwable $e) {
            log_message('error', 'Error in RupController::store: ' . $e->getMessage());
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal menyimpan paket RUP: ' . $e->getMessage(),
                ])->setStatusCode(500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan paket RUP: ' . $e->getMessage());
        }
    }

    /**
     * Format data baris dari DB agar memiliki atribut badge UI yang sesuai
     */
    protected function formatPlanRow(array $item): array
    {
        $procType = $item['jenis_pengadaan_name'] ?? 'Barang';
        $item['proc_badge'] = match ($procType) {
            'Barang'                                => 'badge-proc-barang',
            'Pekerjaan Konstruksi'                  => 'badge-proc-konstruksi',
            'Jasa Konsultansi', 'Jasa Konsultasi'   => 'badge-proc-konsultasi',
            'Jasa Lainnya'                          => 'badge-proc-lainnya',
            'Pekerjaan Terintegrasi'                => 'badge-proc-terintegrasi',
            default                                 => 'badge-proc-default',
        };

        // Status Akses Edit RUP (1 = Bisa Diedit, 2 = Terkunci)
        $isEditable = ((int) ($item['rup_status'] ?? 1)) === 1;
        $item['rup_status_label'] = $isEditable ? 'Bisa Diedit' : 'Terkunci';
        $item['rup_status_badge'] = $isEditable
            ? 'bg-success-subtle text-success border border-success-subtle'
            : 'bg-secondary-subtle text-secondary border border-secondary-subtle';

        return $item;
    }
}
