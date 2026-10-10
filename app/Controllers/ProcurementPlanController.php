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
            'totalPlans'       => $totalPlans,
            'totalBudget'      => $totalBudget,
            'announcedCount'   => $announcedCount,
            'syncedCount'      => $syncedCount,
            'dakCount'         => $dakCount,
        ]);
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
