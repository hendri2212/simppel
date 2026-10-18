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
use App\Controllers\Traits\ProcurementScope;
use CodeIgniter\HTTP\ResponseInterface;

class RupController extends BaseController
{
    use ProcurementScope;

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
     * Pastikan role ADMIN ULP tidak memiliki akses ke fitur dan data RUP.
     */
    private function denyAdminUlp(): ?ResponseInterface
    {
        $actor    = $this->actor();
        $roleName = strtoupper((string) ($actor['role_name'] ?? ''));
        $roleId   = (int) ($actor['role_id'] ?? 0);

        if ($roleId === 4 || $roleName === 'ADMIN ULP') {
            return $this->failWith('Role ADMIN ULP tidak memiliki akses ke data dan fitur RUP.', 403, '/');
        }

        return null;
    }

    /**
     * Tampilkan halaman daftar rencana pengadaan (Procurement Plans / RUP)
     */
    public function index()
    {
        if ($deny = $this->denyAdminUlp()) {
            return $deny;
        }
        try {
            // Ambil data langsung dari tabel rup beserta relasinya
            // Hanya RUP dalam cakupan user (SKPD/PPK), atau seluruhnya untuk role pusat
            $this->scopeToActor($this->rupModel, 'rup.skpd_id', 'rup.ppk_id');
            $plansFromDb = $this->rupModel->getWithRelations();
            $plans       = array_map([$this, 'formatPlanRow'], $plansFromDb);

            // Ambil referensi master data untuk modal/filter
            $skpd         = $this->skpdModel->select('id, name, abbreviation')->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $officers         = $this->officerModel->select('id, name, skpd_id')->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
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
                    ->select('users.id, users.full_name, users.username, users.email, users.nip, users.whatsapp_number, users.role_id, users.skpd_id, users.ppk_id, roles.name as role_name, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, ppk.name as ppk_name')
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

        // Kalkulasi statistik dalam satu iterasi
        $totalBudget = 0;
        $editableCount = $lockedCount = $syncedCount = $dakCount = 0;
        foreach ($plans as $p) {
            $totalBudget   += (float) ($p['budget_ceiling'] ?? 0);
            $status         = (int) ($p['rup_status'] ?? 1);
            $editableCount += $status === 1 ? 1 : 0;
            $lockedCount   += $status === 2 ? 1 : 0;
            $syncedCount   += (int) ($p['is_synced'] ?? 0) === 1 ? 1 : 0;
            $dakCount      += (int) ($p['jenis_dak_id'] ?? 2) === 1 ? 1 : 0;
        }
        $totalPlans = count($plans);

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
        if ($deny = $this->denyAdminUlp()) {
            return $deny;
        }

        if (! $this->canWrite()) {
            return $this->failWith('Anda tidak memiliki hak akses untuk membuat RUP.', 403, '/rup');
        }

        // Data user dibaca dari database (bukan dari input klien)
        $user = $this->userModel->select('id, full_name, role_id, skpd_id, ppk_id')->find((int) session()->get('user_id'));
        if (! $user) {
            return $this->failWith('Data user tidak ditemukan di sistem.', 404, '/rup');
        }

        // Validasi input form (termasuk keberadaan data master)
        $rules = [
            'fiscal_year'         => 'required|is_natural_no_zero|greater_than_equal_to[2000]|less_than_equal_to[2100]',
            'activity'            => 'required|min_length[3]|max_length[2000]',
            'package_name'        => 'required|min_length[3]|max_length[2000]',
            'package_code'        => 'permit_empty|max_length[50]|regex_match[/^[A-Za-z0-9._\/-]+$/]',
            'jenis_belanja_id'    => 'permit_empty|is_natural_no_zero|is_not_unique[jenis_belanja.id]',
            'jenis_pengadaan_id'  => 'required|is_natural_no_zero|is_not_unique[jenis_pengadaan.id]',
            'metode_pemilihan_id' => 'required|is_natural_no_zero|is_not_unique[metode_pemilihan.id]',
            'sumber_dana_id'      => 'required|is_natural_no_zero|is_not_unique[sumber_dana.id]',
            'jenis_dak_id'        => 'permit_empty|is_natural_no_zero|is_not_unique[jenis_dak.id]',
            'budget_ceiling'      => 'required|numeric|greater_than[0]|less_than[1000000000000000]',
            'account_code'        => 'permit_empty|max_length[255]',
            'work_duration'       => 'permit_empty|is_natural_no_zero|less_than_equal_to[3650]',
            'volume'              => 'permit_empty|max_length[255]',
            'location'            => 'permit_empty|max_length[2000]',
            'description'         => 'permit_empty|max_length[5000]',
        ];

        if (! $this->validate($rules)) {
            return $this->failWith(implode(' ', $this->validator->getErrors()), 422, '/rup');
        }

        $db = db_connect();

        try {
            $db->transBegin();

            // Instansi / SKPD & PPK otomatis dari user login
            $skpdId = ! empty($user['skpd_id']) ? (int) $user['skpd_id'] : null;
            $ppkId  = ! empty($user['ppk_id']) ? (int) $user['ppk_id'] : null;

            // Fallback jika user belum memiliki skpd_id (misal Administrator / Superadmin)
            if (! $skpdId) {
                $defaultSkpd = $this->skpdModel->select('id')->where('id', 16)->first() ?? $this->skpdModel->select('id')->first();
                $skpdId      = $defaultSkpd ? (int) $defaultSkpd['id'] : 1;
            }

            // Fallback jika user belum memiliki ppk_id
            if (! $ppkId) {
                $existingOfficer = $this->officerModel->select('id')->where('skpd_id', $skpdId)->first();
                if ($existingOfficer) {
                    $ppkId = (int) $existingOfficer['id'];
                } else {
                    $officerName = (! empty($user['full_name']) && (int) ($user['role_id'] ?? 0) === 3) ? $user['full_name'] : 'Pejabat Pembuat Komitmen (PPK)';
                    $ppkId = (int) $this->officerModel->insert([
                        'skpd_id'    => $skpdId,
                        'name'       => $officerName,
                        'is_active'  => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }

                // Jika user terafiliasi dengan skpd_id ini, perbarui akun user agar tersinkronisasi
                if (! empty($user['skpd_id']) && (int) $user['skpd_id'] === $skpdId) {
                    $this->userModel->update($user['id'], ['ppk_id' => $ppkId]);
                }
            }

            $post        = $this->request;
            $packageCode = trim((string) $post->getPost('package_code'));
            if ($packageCode === '') {
                $packageCode = 'RUP-' . date('Y') . '-' . random_int(10000000, 99999999);
            }

            $insertId = $this->rupModel->insert([
                'skpd_id'             => $skpdId,
                'ppk_id'              => $ppkId,
                'fiscal_year'         => (int) $post->getPost('fiscal_year'),
                'package_code'        => $packageCode,
                'activity'            => trim((string) $post->getPost('activity')),
                'package_name'        => trim((string) $post->getPost('package_name')),
                'jenis_belanja_id'    => (int) $post->getPost('jenis_belanja_id') ?: 1,
                'jenis_pengadaan_id'  => (int) $post->getPost('jenis_pengadaan_id'),
                'metode_pemilihan_id' => (int) $post->getPost('metode_pemilihan_id'),
                'sumber_dana_id'      => (int) $post->getPost('sumber_dana_id'),
                'jenis_dak_id'        => (int) $post->getPost('jenis_dak_id') ?: 2,
                'budget_ceiling'      => (float) $post->getPost('budget_ceiling'),
                'account_code'        => trim((string) $post->getPost('account_code')) ?: null,
                'work_duration'       => (int) $post->getPost('work_duration') ?: null,
                'volume'              => trim((string) $post->getPost('volume')) ?: '1 Paket',
                'location'            => trim((string) $post->getPost('location')) ?: null,
                'description'         => trim((string) $post->getPost('description')) ?: null,
                'rup_status'          => 1, // Bisa Diedit / Aktif
                'is_synced'           => (int) $post->getPost('is_synced') === 1 ? 1 : 0,
                'submission_date'     => date('Y-m-d H:i:s'),
            ]);

            $db->transCommit();

            return $this->okWith('Paket Rencana Pengadaan (RUP) berhasil ditambahkan!', ['id' => $insertId], '/rup');
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Error in RupController::store: ' . $e->getMessage());

            return $this->failWith('Gagal menyimpan paket RUP. Silakan coba lagi.', 500, '/rup');
        }
    }

    /**
     * Perbarui data paket RUP (hanya bisa jika belum dibuatkan Paket Pengadaan / rup_status == 1)
     */
    public function update($id = null)
    {
        if ($deny = $this->denyAdminUlp()) {
            return $deny;
        }

        if (! $this->canWrite()) {
            return $this->failWith('Anda tidak memiliki hak akses untuk mengubah RUP.', 403, '/rup');
        }

        $rupId = (int) $id;
        $rup   = $rupId > 0 ? $this->rupModel->getWithRelations($rupId) : null;

        if (! $rup || ! $this->inScope($rup)) {
            return $this->failWith('Data RUP tidak ditemukan.', 404, '/rup');
        }

        if (! empty($rup['paket_id']) || (int) ($rup['rup_status'] ?? 1) !== 1) {
            return $this->failWith('Paket RUP ini sudah terkunci karena sudah dibuatkan Paket Pengadaan dan tidak dapat diubah.', 422, '/rup');
        }

        $rules = [
            'fiscal_year'         => 'required|is_natural_no_zero|greater_than_equal_to[2000]|less_than_equal_to[2100]',
            'activity'            => 'required|min_length[3]|max_length[2000]',
            'package_name'        => 'required|min_length[3]|max_length[2000]',
            'package_code'        => 'permit_empty|max_length[50]|regex_match[/^[A-Za-z0-9._\/-]+$/]',
            'jenis_belanja_id'    => 'permit_empty|is_natural_no_zero|is_not_unique[jenis_belanja.id]',
            'jenis_pengadaan_id'  => 'required|is_natural_no_zero|is_not_unique[jenis_pengadaan.id]',
            'metode_pemilihan_id' => 'required|is_natural_no_zero|is_not_unique[metode_pemilihan.id]',
            'sumber_dana_id'      => 'required|is_natural_no_zero|is_not_unique[sumber_dana.id]',
            'jenis_dak_id'        => 'permit_empty|is_natural_no_zero|is_not_unique[jenis_dak.id]',
            'budget_ceiling'      => 'required|numeric|greater_than[0]|less_than[1000000000000000]',
            'account_code'        => 'permit_empty|max_length[255]',
            'work_duration'       => 'permit_empty|is_natural_no_zero|less_than_equal_to[3650]',
            'volume'              => 'permit_empty|max_length[255]',
            'location'            => 'permit_empty|max_length[2000]',
            'description'         => 'permit_empty|max_length[5000]',
        ];

        if (! $this->validate($rules)) {
            return $this->failWith(implode(' ', $this->validator->getErrors()), 422, '/rup');
        }

        $post        = $this->request;
        $packageCode = trim((string) $post->getPost('package_code'));
        if ($packageCode === '') {
            $packageCode = $rup['package_code'] ?: ('RUP-' . date('Y') . '-' . random_int(10000000, 99999999));
        }

        try {
            $this->rupModel->update($rupId, [
                'fiscal_year'         => (int) $post->getPost('fiscal_year'),
                'package_code'        => $packageCode,
                'activity'            => trim((string) $post->getPost('activity')),
                'package_name'        => trim((string) $post->getPost('package_name')),
                'jenis_pengadaan_id'  => (int) $post->getPost('jenis_pengadaan_id'),
                'metode_pemilihan_id' => (int) $post->getPost('metode_pemilihan_id'),
                'sumber_dana_id'      => (int) $post->getPost('sumber_dana_id'),
                'jenis_dak_id'        => (int) $post->getPost('jenis_dak_id') ?: 2,
                'budget_ceiling'      => (float) $post->getPost('budget_ceiling'),
                'account_code'        => trim((string) $post->getPost('account_code')) ?: null,
                'work_duration'       => (int) $post->getPost('work_duration') ?: 0,
                'volume'              => trim((string) $post->getPost('volume')) ?: '1 Paket',
                'location'            => trim((string) $post->getPost('location')) ?: null,
                'description'         => trim((string) $post->getPost('description')) ?: null,
            ]);

            return $this->okWith('Paket Rencana Pengadaan (RUP) berhasil diperbarui!', ['id' => $rupId], '/rup');
        } catch (\Throwable $e) {
            log_message('error', 'Error in RupController::update: ' . $e->getMessage());

            return $this->failWith('Gagal memperbarui paket RUP. Silakan coba lagi.', 500, '/rup');
        }
    }

    /**
     * Hapus data paket RUP (hanya bisa jika belum dibuatkan Paket Pengadaan / rup_status == 1)
     */
    public function delete($id = null)
    {
        if ($deny = $this->denyAdminUlp()) {
            return $deny;
        }

        if (! $this->canWrite()) {
            return $this->failWith('Anda tidak memiliki hak akses untuk menghapus RUP.', 403, '/rup');
        }

        $rupId = (int) $id;
        $rup   = $rupId > 0 ? $this->rupModel->getWithRelations($rupId) : null;

        if (! $rup || ! $this->inScope($rup)) {
            return $this->failWith('Data RUP tidak ditemukan.', 404, '/rup');
        }

        if (! empty($rup['paket_id']) || (int) ($rup['rup_status'] ?? 1) !== 1) {
            return $this->failWith('Paket RUP ini sudah terkunci karena sudah dibuatkan Paket Pengadaan dan tidak dapat dihapus.', 422, '/rup');
        }

        try {
            $this->rupModel->delete($rupId);

            return $this->okWith('Paket Rencana Pengadaan (RUP) berhasil dihapus!', ['id' => $rupId], '/rup');
        } catch (\Throwable $e) {
            log_message('error', 'Error in RupController::delete: ' . $e->getMessage());

            return $this->failWith('Gagal menghapus paket RUP. Silakan coba lagi.', 500, '/rup');
        }
    }

    /**
     * Ambil data RUP dari API INAPROC Kabupaten Kotabaru
     * Endpoint: https://data-inaproc.kotabarukab.go.id/api/rup/[kode_rup]
     */
    public function fetchInaproc(?string $kodeRup = null)
    {
        if ($deny = $this->denyAdminUlp()) {
            return $deny;
        }

        $cleanCode = preg_replace('/[^A-Za-z0-9_-]/', '', trim((string) $kodeRup));
        if ($cleanCode === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Kode RUP wajib diisi dan harus berupa angka/karakter valid.',
            ]);
        }

        $apiUrl = 'https://data-inaproc.kotabarukab.go.id/api/rup/' . rawurlencode($cleanCode);

        try {
            $ch = curl_init($apiUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT        => 12,
                CURLOPT_CONNECTTIMEOUT => 6,
                CURLOPT_HTTPHEADER     => [
                    'Accept: application/json',
                    'User-Agent: SIMPPEL-Kotabaru/1.0',
                ],
            ]);

            $rawBody  = curl_exec($ch);
            $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlErr  = curl_error($ch);
            curl_close($ch);

            if ($rawBody === false || $rawBody === '') {
                return $this->response->setStatusCode(502)->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal menghubungi server API INAPROC: ' . ($curlErr ?: 'Respon kosong'),
                ]);
            }

            $decoded = json_decode($rawBody, true);
            if (! is_array($decoded)) {
                return $this->response->setStatusCode(502)->setJSON([
                    'status'  => 'error',
                    'message' => 'Format respon dari API INAPROC tidak valid.',
                ]);
            }

            return $this->response->setStatusCode($httpCode >= 200 && $httpCode < 600 ? $httpCode : 200)->setJSON($decoded);
        } catch (\Throwable $e) {
            log_message('error', 'Error in RupController::fetchInaproc: ' . $e->getMessage());

            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menarik data dari API INAPROC.',
            ]);
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

        // Jika sudah dibuatkan Paket Pengadaan (paket_id tidak kosong), paksa status RUP menjadi Terkunci (2)
        if (! empty($item['paket_id'])) {
            $item['rup_status'] = 2;
        }

        // Status Akses Edit RUP (1 = Bisa Diedit, 2 = Terkunci)
        $isEditable = ((int) ($item['rup_status'] ?? 1)) === 1;
        $item['rup_status_label'] = $isEditable ? 'Bisa Diedit' : 'Terkunci';
        $item['rup_status_badge'] = $isEditable
            ? 'bg-success-subtle text-success border border-success-subtle'
            : 'bg-secondary-subtle text-secondary border border-secondary-subtle';

        return $item;
    }
}
