<?php

namespace App\Controllers;

use App\Models\AgencyModel;
use App\Models\CommitmentOfficerModel;
use App\Models\ExpenseTypeModel;
use App\Models\FundingSourceModel;
use App\Models\ProcurementPlanModel;
use App\Models\ProcurementTypeModel;
use App\Models\SelectionMethodModel;
use App\Models\SpecialAllocationTypeModel;
use App\Models\UserModel;

class ProcurementPlanController extends BaseController
{
    protected ProcurementPlanModel $procurementPlanModel;
    protected AgencyModel $agencyModel;
    protected CommitmentOfficerModel $officerModel;
    protected ExpenseTypeModel $expenseTypeModel;
    protected ProcurementTypeModel $procurementTypeModel;
    protected FundingSourceModel $fundingSourceModel;
    protected SelectionMethodModel $selectionMethodModel;
    protected SpecialAllocationTypeModel $allocationTypeModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->procurementPlanModel = new ProcurementPlanModel();
        $this->agencyModel          = new AgencyModel();
        $this->officerModel         = new CommitmentOfficerModel();
        $this->expenseTypeModel     = new ExpenseTypeModel();
        $this->procurementTypeModel = new ProcurementTypeModel();
        $this->fundingSourceModel   = new FundingSourceModel();
        $this->selectionMethodModel = new SelectionMethodModel();
        $this->allocationTypeModel  = new SpecialAllocationTypeModel();
        $this->userModel            = new UserModel();
    }

    /**
     * Tampilkan halaman daftar rencana pengadaan (Procurement Plans / RUP)
     */
    public function index()
    {
        try {
            // Ambil data langsung dari tabel procurement_plans beserta relasinya
            $plansFromDb = $this->procurementPlanModel->getWithRelations();
            $plans       = array_map([$this, 'formatPlanRow'], $plansFromDb);

            // Ambil referensi master data untuk modal/filter
            $agencies         = $this->agencyModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $officers         = $this->officerModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $expenseTypes     = $this->expenseTypeModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $procurementTypes = $this->procurementTypeModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $fundingSources   = $this->fundingSourceModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $selectionMethods = $this->selectionMethodModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $allocationTypes  = $this->allocationTypeModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

            // Ambil info lengkap pengguna yang sedang login beserta Instansi/SKPD dan PPK/Bidang
            $currentUserId = session()->get('user_id');
            $currentUser   = null;
            if ($currentUserId) {
                $userObj = $this->userModel
                    ->select('users.*, roles.name as role_name, agencies.name as agency_name, agencies.abbreviation as agency_abbr, commitment_officers.name as commitment_officer_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->join('agencies', 'agencies.id = users.agency_id', 'left')
                    ->join('commitment_officers', 'commitment_officers.id = users.commitment_officer_id', 'left')
                    ->where('users.id', $currentUserId)
                    ->first();
                if ($userObj) {
                    // Fallback jika belum ter-assign commitment_officer_id tetapi ada agency_id
                    if (empty($userObj['commitment_officer_name']) && !empty($userObj['agency_id'])) {
                        $fallbackOfficer = $this->officerModel->where('agency_id', $userObj['agency_id'])->first();
                        if ($fallbackOfficer) {
                            $userObj['commitment_officer_id']   = $fallbackOfficer['id'];
                            $userObj['commitment_officer_name'] = $fallbackOfficer['name'];
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
                    'agency_id'               => session()->get('agency_id') ?? null,
                    'agency_name'             => session()->get('agency_name') ?? 'Semua SKPD / Administrator',
                    'agency_abbr'             => session()->get('agency_abbr') ?? 'SIMPPEL',
                    'commitment_officer_id'   => session()->get('commitment_officer_id') ?? null,
                    'commitment_officer_name' => session()->get('commitment_officer_name') ?? 'Admin Pengadaan',
                ];
            } elseif (empty($currentUser['agency_name'])) {
                $currentUser['agency_name']             = 'Pusat / Administrator';
                $currentUser['agency_abbr']             = 'SIMPPEL';
                $currentUser['commitment_officer_name'] = $currentUser['commitment_officer_name'] ?? 'Admin Pengadaan';
            }

        } catch (\Throwable $e) {
            log_message('error', 'Error in ProcurementPlanController::index: ' . $e->getMessage());
            $plans            = [];
            $agencies         = [];
            $officers         = [];
            $expenseTypes     = [];
            $procurementTypes = [];
            $fundingSources   = [];
            $selectionMethods = [];
            $allocationTypes  = [];
            $currentUser      = null;
        }

        // Kalkulasi Statistik dari data database
        $totalPlans     = count($plans);
        $totalBudget    = array_sum(array_column($plans, 'budget_ceiling'));
        $announcedCount = count(array_filter($plans, fn($p) => (int) ($p['rup_status'] ?? 0) >= 1));
        $syncedCount    = count(array_filter($plans, fn($p) => (int) ($p['is_synced'] ?? 0) === 1));
        $dakCount       = count(array_filter($plans, fn($p) => (int) ($p['special_allocation_type_id'] ?? 2) === 1));

        return view('procurement-plans', [
            'pageTitle'        => 'Daftar Paket RUP',
            'plans'            => $plans,
            'agencies'         => $agencies,
            'officers'         => $officers,
            'expenseTypes'     => $expenseTypes,
            'procurementTypes' => $procurementTypes,
            'fundingSources'   => $fundingSources,
            'selectionMethods' => $selectionMethods,
            'allocationTypes'  => $allocationTypes,
            'currentUser'      => $currentUser,
            'totalPlans'       => $totalPlans,
            'totalBudget'      => $totalBudget,
            'announcedCount'   => $announcedCount,
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
        $agencyId            = !empty($user['agency_id']) ? (int) $user['agency_id'] : null;
        $commitmentOfficerId = !empty($user['commitment_officer_id']) ? (int) $user['commitment_officer_id'] : null;

        // Fallback jika user belum memiliki agency_id (misal Administrator / Superadmin)
        if (! $agencyId) {
            $defaultAgency = $this->agencyModel->where('id', 16)->first() ?? $this->agencyModel->first();
            $agencyId      = $defaultAgency ? (int) $defaultAgency['id'] : 1;
        }

        // Fallback jika user belum memiliki commitment_officer_id
        if (! $commitmentOfficerId) {
            $existingOfficer = $this->officerModel->where('agency_id', $agencyId)->first();
            if ($existingOfficer) {
                $commitmentOfficerId = (int) $existingOfficer['id'];
            } else {
                $officerName = (!empty($user['full_name']) && (int) ($user['role_id'] ?? 0) === 3) ? $user['full_name'] : 'Pejabat Pembuat Komitmen (PPK)';
                $commitmentOfficerId = (int) $this->officerModel->insert([
                    'agency_id'  => $agencyId,
                    'name'       => $officerName,
                    'is_active'  => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            // Jika user terafiliasi dengan agency_id ini, perbarui akun user agar tersinkronisasi
            if (!empty($user['agency_id']) && (int) $user['agency_id'] === $agencyId) {
                $this->userModel->update($currentUserId, ['commitment_officer_id' => $commitmentOfficerId]);
            }
        }

        // Validasi input form
        $rules = [
            'fiscal_year'         => 'required|numeric',
            'activity'            => 'required|min_length[3]',
            'package_name'        => 'required|min_length[3]',
            'procurement_type_id' => 'required|numeric',
            'selection_method_id' => 'required|numeric',
            'funding_source_id'   => 'required|numeric',
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
            'agency_id'                  => $agencyId,
            'commitment_officer_id'      => $commitmentOfficerId,
            'fiscal_year'                => (int) $this->request->getPost('fiscal_year'),
            'package_code'               => $packageCode,
            'activity'                   => trim((string) $this->request->getPost('activity')),
            'package_name'               => trim((string) $this->request->getPost('package_name')),
            'expense_type_id'            => $this->request->getPost('expense_type_id') ? (int) $this->request->getPost('expense_type_id') : 1,
            'procurement_type_id'        => (int) $this->request->getPost('procurement_type_id'),
            'selection_method_id'        => (int) $this->request->getPost('selection_method_id'),
            'funding_source_id'          => (int) $this->request->getPost('funding_source_id'),
            'special_allocation_type_id' => $this->request->getPost('special_allocation_type_id') ? (int) $this->request->getPost('special_allocation_type_id') : 2,
            'budget_ceiling'             => $budgetCeiling,
            'account_code'               => trim((string) $this->request->getPost('account_code')) ?: null,
            'work_duration'              => $this->request->getPost('work_duration') ? (int) $this->request->getPost('work_duration') : null,
            'location'                   => trim((string) $this->request->getPost('location')) ?: null,
            'description'                => trim((string) $this->request->getPost('description')) ?: null,
            'volume'                     => trim((string) $this->request->getPost('volume')) ?: '1 Paket',
            'rup_status'                 => 1, // Terumumkan / Aktif
            'package_status'             => 0, // Draft
            'is_synced'                  => 0,
            'submission_date'            => date('Y-m-d H:i:s'),
        ];

        try {
            $insertId = $this->procurementPlanModel->insert($data);

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Paket Rencana Pengadaan (RUP) berhasil ditambahkan!',
                    'id'      => $insertId,
                ]);
            }

            return redirect()->to('/procurement-plans')->with('success', 'Paket Rencana Pengadaan (RUP) berhasil ditambahkan!');
        } catch (\Throwable $e) {
            log_message('error', 'Error in ProcurementPlanController::store: ' . $e->getMessage());
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
        $procType = $item['procurement_type_name'] ?? 'Barang';
        $item['proc_badge'] = match ($procType) {
            'Barang'                => 'bg-info-subtle text-info border border-info-subtle',
            'Pekerjaan Konstruksi'  => 'bg-primary-subtle text-primary border border-primary-subtle',
            'Jasa Konsultansi'      => 'bg-purple-subtle text-purple border border-purple-subtle',
            'Jasa Konsultasi'       => 'bg-purple-subtle text-purple border border-purple-subtle',
            'Jasa Lainnya'          => 'bg-warning-subtle text-warning border border-warning-subtle',
            default                 => 'bg-light text-dark border',
        };

        $item['status_badge'] = match ((int) $item['package_status']) {
            3       => 'bg-success text-white',
            2       => 'bg-info text-white',
            1       => 'bg-warning text-dark',
            default => 'bg-secondary text-white',
        };

        $item['status_label'] = match ((int) $item['package_status']) {
            3       => 'Disetujui',
            2       => 'Review',
            1       => 'Pengajuan',
            default => 'Draft',
        };

        return $item;
    }
}
