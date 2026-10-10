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
            // Ambil data dari database jika ada
            $plansFromDb = $this->procurementPlanModel->getWithRelations();

            if (!empty($plansFromDb)) {
                $plans = array_map([$this, 'formatPlanRow'], $plansFromDb);
            } else {
                // Gunakan dummy data komprehensif berdasarkan tabel procurement_plans
                $plans = $this->getDummyProcurementPlans();
            }

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
            $plans            = $this->getDummyProcurementPlans();
            $agencies         = [];
            $officers         = [];
            $expenseTypes     = [];
            $procurementTypes = [];
            $fundingSources   = [];
            $selectionMethods = [];
            $allocationTypes  = [];
        }

        // Kalkulasi Statistik
        $totalPlans     = count($plans);
        $totalBudget    = array_sum(array_column($plans, 'budget_ceiling'));
        $announcedCount = count(array_filter($plans, fn($p) => (int) $p['rup_status'] === 1));
        $syncedCount    = count(array_filter($plans, fn($p) => (int) $p['is_synced'] === 1));
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
     * Format data baris dari DB agar memiliki atribut UI lengkap
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

    /**
     * Dummy data sesuai skema tabel 2026-10-10-040501_CreateProcurementPlansTable.php
     */
    protected function getDummyProcurementPlans(): array
    {
        $raw = [
            [
                'id'                          => 1,
                'agency_id'                   => 1,
                'agency_name'                 => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'agency_abbreviation'         => 'PUPR',
                'commitment_officer_id'       => 1,
                'commitment_officer_name'     => 'Ir. Hendra Gunawan, S.T., M.T.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Program Penyelenggaraan Jalan dan Jembatan',
                'package_name'                => 'Pembangunan Jembatan Sei Siak Ruas Simpang Tiga',
                'package_code'                => 'RUP-2026-39182910',
                'location'                    => 'Kecamatan Tenayan Raya, Kota Pekanbaru',
                'expense_type_id'             => 1,
                'expense_type_name'           => 'Modal',
                'procurement_type_id'         => 4,
                'procurement_type_name'       => 'Pekerjaan Konstruksi',
                'volume'                      => '1 Jembatan (Bentang 60m)',
                'description'                 => 'Pekerjaan struktur bawah jembatan, rangka baja bentang 60 meter, dan pengaspalan oprit jembatan.',
                'selection_method_id'         => 4,
                'selection_method_name'       => 'Tender',
                'submission_date'             => '2026-02-10',
                'notes'                       => 'Prioritas RKPD Tahun 2026, dokumen DED sudah selesai',
                'rup_status'                  => 1,
                'funding_source_id'           => 1,
                'funding_source_name'         => 'APBD',
                'work_duration'               => 240,
                'budget_ceiling'              => 8750000000.00,
                'account_code'                => '5.2.04.01.01.0001',
                'special_allocation_type_id'  => 2,
                'special_allocation_type_name'=> 'NON DAK',
                'package_status'              => 3,
                'is_synced'                   => 1,
                'created_at'                  => '2026-02-10 09:30:00',
                'updated_at'                  => '2026-02-12 14:15:00',
            ],
            [
                'id'                          => 2,
                'agency_id'                   => 2,
                'agency_name'                 => 'Dinas Kesehatan',
                'agency_abbreviation'         => 'DINKES',
                'commitment_officer_id'       => 2,
                'commitment_officer_name'     => 'drg. Ratna Juwita, M.Kes.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Program Peningkatan Pelayanan Fasilitas Kesehatan Primer',
                'package_name'                => 'Pengadaan Alat Kesehatan Ruang ICU dan Bedah Terpadu',
                'package_code'                => 'RUP-2026-48192004',
                'location'                    => 'RSUD Petala Bumi, Pekanbaru',
                'expense_type_id'             => 1,
                'expense_type_name'           => 'Modal',
                'procurement_type_id'         => 1,
                'procurement_type_name'       => 'Barang',
                'volume'                      => '1 Paket (18 Unit Instrumen Medis)',
                'description'                 => 'Pengadaan ventilator elektrik, bed side monitor multiparameter, defibrillator, dan lampu operasi ganda.',
                'selection_method_id'         => 1,
                'selection_method_name'       => 'E-purchasing',
                'submission_date'             => '2026-01-20',
                'notes'                       => 'Produk terdaftar di E-Katalog Nasional LKPP dengan standar TKDN > 40%',
                'rup_status'                  => 1,
                'funding_source_id'           => 3,
                'funding_source_name'         => 'DAK Fisik',
                'work_duration'               => 60,
                'budget_ceiling'              => 3450000000.00,
                'account_code'                => '5.2.02.08.01.0003',
                'special_allocation_type_id'  => 1,
                'special_allocation_type_name'=> 'DAK',
                'package_status'              => 3,
                'is_synced'                   => 1,
                'created_at'                  => '2026-01-20 10:00:00',
                'updated_at'                  => '2026-01-22 16:00:00',
            ],
            [
                'id'                          => 3,
                'agency_id'                   => 3,
                'agency_name'                 => 'Dinas Pendidikan',
                'agency_abbreviation'         => 'DISDIK',
                'commitment_officer_id'       => 3,
                'commitment_officer_name'     => 'Drs. Ahmad Fauzi, M.Pd.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Program Pengelolaan Pendidikan Menengah Kejuruan',
                'package_name'                => 'Pembangunan Gedung RKB dan Lab Komputer SMKN 1',
                'package_code'                => 'RUP-2026-55091238',
                'location'                    => 'SMKN 1 Minas, Kabupaten Siak',
                'expense_type_id'             => 1,
                'expense_type_name'           => 'Modal',
                'procurement_type_id'         => 4,
                'procurement_type_name'       => 'Pekerjaan Konstruksi',
                'volume'                      => '1 Gedung (2 Lantai, 6 RKB)',
                'description'                 => 'Konstruksi fisik gedung bertingkat 2 lantai, instalasi kelistrikan, tata udara, dan sanitasi lengkap.',
                'selection_method_id'         => 4,
                'selection_method_name'       => 'Tender',
                'submission_date'             => '2026-02-18',
                'notes'                       => 'Menggunakan metode pascakualifikasi satu file sistem gugur',
                'rup_status'                  => 1,
                'funding_source_id'           => 3,
                'funding_source_name'         => 'DAK Fisik',
                'work_duration'               => 150,
                'budget_ceiling'              => 2150000000.00,
                'account_code'                => '5.2.03.01.01.0005',
                'special_allocation_type_id'  => 1,
                'special_allocation_type_name'=> 'DAK',
                'package_status'              => 2,
                'is_synced'                   => 1,
                'created_at'                  => '2026-02-18 11:15:00',
                'updated_at'                  => '2026-02-20 08:45:00',
            ],
            [
                'id'                          => 4,
                'agency_id'                   => 4,
                'agency_name'                 => 'Dinas Komunikasi, Informatika dan Statistik',
                'agency_abbreviation'         => 'DISKOMINFO',
                'commitment_officer_id'       => 4,
                'commitment_officer_name'     => 'Bambang Eko Prasetyo, S.Kom., M.T.I.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Program Pengembangan SPBE dan Smart City Terintegrasi',
                'package_name'                => 'Pengembangan Sistem Cloud Data Center dan Keamanan Cyber',
                'package_code'                => 'RUP-2026-61928374',
                'location'                    => 'Pusat Komando (Command Center) Pemprov',
                'expense_type_id'             => 2,
                'expense_type_name'           => 'Barang/Jasa',
                'procurement_type_id'         => 3,
                'procurement_type_name'       => 'Jasa Lainnya',
                'volume'                      => '1 Layanan Komputasi Cloud (12 Bulan)',
                'description'                 => 'Langganan infrastruktur cloud Tier-3 nasional, backup replication, firewall WAF, dan SOC monitoring 24/7.',
                'selection_method_id'         => 1,
                'selection_method_name'       => 'E-purchasing',
                'submission_date'             => '2026-01-15',
                'notes'                       => 'Katalog Elektronik Sektoral Kominfo LKPP',
                'rup_status'                  => 1,
                'funding_source_id'           => 1,
                'funding_source_name'         => 'APBD',
                'work_duration'               => 365,
                'budget_ceiling'              => 1450000000.00,
                'account_code'                => '5.1.02.02.01.0042',
                'special_allocation_type_id'  => 2,
                'special_allocation_type_name'=> 'NON DAK',
                'package_status'              => 3,
                'is_synced'                   => 1,
                'created_at'                  => '2026-01-15 14:00:00',
                'updated_at'                  => '2026-01-18 10:20:00',
            ],
            [
                'id'                          => 5,
                'agency_id'                   => 1,
                'agency_name'                 => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'agency_abbreviation'         => 'PUPR',
                'commitment_officer_id'       => 1,
                'commitment_officer_name'     => 'Ir. Hendra Gunawan, S.T., M.T.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Program Penyelenggaraan Jalan dan Jembatan',
                'package_name'                => 'Jasa Konsultansi Pengawasan Pembangunan Jembatan Sei Siak',
                'package_code'                => 'RUP-2026-39182911',
                'location'                    => 'Kecamatan Tenayan Raya, Kota Pekanbaru',
                'expense_type_id'             => 2,
                'expense_type_name'           => 'Barang/Jasa',
                'procurement_type_id'         => 2,
                'procurement_type_name'       => 'Jasa Konsultansi',
                'volume'                      => '1 Dokumen Pengawasan Mutu & Teknis',
                'description'                 => 'Supervisi dan pengawasan teknis independen pelaksanaan konstruksi fisik jembatan.',
                'selection_method_id'         => 5,
                'selection_method_name'       => 'Seleksi',
                'submission_date'             => '2026-02-12',
                'notes'                       => 'Seleksi jasa konsultansi badan usaha prakualifikasi',
                'rup_status'                  => 1,
                'funding_source_id'           => 1,
                'funding_source_name'         => 'APBD',
                'work_duration'               => 240,
                'budget_ceiling'              => 420000000.00,
                'account_code'                => '5.1.02.02.08.0012',
                'special_allocation_type_id'  => 2,
                'special_allocation_type_name'=> 'NON DAK',
                'package_status'              => 2,
                'is_synced'                   => 1,
                'created_at'                  => '2026-02-12 10:30:00',
                'updated_at'                  => '2026-02-14 11:00:00',
            ],
            [
                'id'                          => 6,
                'agency_id'                   => 5,
                'agency_name'                 => 'Dinas Lingkungan Hidup dan Kehutanan',
                'agency_abbreviation'         => 'DLHK',
                'commitment_officer_id'       => 5,
                'commitment_officer_name'     => 'Dra. Hj. Nurhidayah, M.Si.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Program Pengelolaan Kebersihan dan Pengolahan Sampah',
                'package_name'                => 'Pengadaan Truk Armroll dan Kontainer Sampah TPS 3R',
                'package_code'                => 'RUP-2026-72819033',
                'location'                    => 'Wilayah Kota Pekanbaru dan TPA Muara Fajar',
                'expense_type_id'             => 1,
                'expense_type_name'           => 'Modal',
                'procurement_type_id'         => 1,
                'procurement_type_name'       => 'Barang',
                'volume'                      => '4 Unit Truk + 12 Unit Kontainer 6m3',
                'description'                 => 'Truk armroll kapasitas 6-8 ton Euro 4 diesel dan kontainer sampah baja plat tahan korosi.',
                'selection_method_id'         => 1,
                'selection_method_name'       => 'E-purchasing',
                'submission_date'             => '2026-02-25',
                'notes'                       => 'Pembelian melalui E-Katalog otomotif LKPP',
                'rup_status'                  => 1,
                'funding_source_id'           => 1,
                'funding_source_name'         => 'APBD',
                'work_duration'               => 45,
                'budget_ceiling'              => 2850000000.00,
                'account_code'                => '5.2.02.03.01.0007',
                'special_allocation_type_id'  => 2,
                'special_allocation_type_name'=> 'NON DAK',
                'package_status'              => 1,
                'is_synced'                   => 1,
                'created_at'                  => '2026-02-25 08:00:00',
                'updated_at'                  => '2026-02-25 09:15:00',
            ],
            [
                'id'                          => 7,
                'agency_id'                   => 6,
                'agency_name'                 => 'Dinas Perhubungan',
                'agency_abbreviation'         => 'DISHUB',
                'commitment_officer_id'       => 6,
                'commitment_officer_name'     => 'Faisal Abidin, S.Si.T., M.M.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Program Peningkatan Keselamatan Lalu Lintas Angkutan Jalan',
                'package_name'                => 'Pemeliharaan dan Perbaikan Rambu serta Lampu PJU Tenaga Surya',
                'package_code'                => 'RUP-2026-80927162',
                'location'                    => 'Jalan Lintas Riau - Sumbar Km 15-45',
                'expense_type_id'             => 2,
                'expense_type_name'           => 'Barang/Jasa',
                'procurement_type_id'         => 3,
                'procurement_type_name'       => 'Jasa Lainnya',
                'volume'                      => '120 Titik PJU Solar Cell',
                'description'                 => 'Penggantian baterai lithium LiFePO4, modul LED 100W, perbaikan tiang octagonal, dan pengecatan ulang.',
                'selection_method_id'         => 2,
                'selection_method_name'       => 'Pengadaan Langsung',
                'submission_date'             => '2026-03-01',
                'notes'                       => 'Pengadaan langsung badan usaha lokal terverifikasi SPSE',
                'rup_status'                  => 1,
                'funding_source_id'           => 1,
                'funding_source_name'         => 'APBD',
                'work_duration'               => 30,
                'budget_ceiling'              => 185000000.00,
                'account_code'                => '5.1.02.03.03.0019',
                'special_allocation_type_id'  => 2,
                'special_allocation_type_name'=> 'NON DAK',
                'package_status'              => 1,
                'is_synced'                   => 0,
                'created_at'                  => '2026-03-01 13:20:00',
                'updated_at'                  => '2026-03-01 13:20:00',
            ],
            [
                'id'                          => 8,
                'agency_id'                   => 7,
                'agency_name'                 => 'RSUD Petala Bumi',
                'agency_abbreviation'         => 'RSUD-PB',
                'commitment_officer_id'       => 7,
                'commitment_officer_name'     => 'dr. H. Zulkifli, Sp.B.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Pelayanan Penunjang Medis dan Farmasi Rumah Sakit',
                'package_name'                => 'Pengadaan Bahan Medis Habis Pakai (BMHP) dan Obat Esensial',
                'package_code'                => 'RUP-2026-91827401',
                'location'                    => 'Instalasi Farmasi RSUD Petala Bumi',
                'expense_type_id'             => 2,
                'expense_type_name'           => 'Barang/Jasa',
                'procurement_type_id'         => 1,
                'procurement_type_name'       => 'Barang',
                'volume'                      => '1 Paket Kebutuhan Semester I (45 Item)',
                'description'                 => 'Pengadaan jarum suntik, infus set, kassa steril, cairan infus NaCl, dan antibiotik generik sesuai formularium.',
                'selection_method_id'         => 1,
                'selection_method_name'       => 'E-purchasing',
                'submission_date'             => '2026-01-10',
                'notes'                       => 'Menggunakan dana operasional BLUD RSUD Petala Bumi',
                'rup_status'                  => 1,
                'funding_source_id'           => 4,
                'funding_source_name'         => 'BLUD',
                'work_duration'               => 180,
                'budget_ceiling'              => 1150000000.00,
                'account_code'                => '5.1.02.01.01.0055',
                'special_allocation_type_id'  => 2,
                'special_allocation_type_name'=> 'NON DAK',
                'package_status'              => 3,
                'is_synced'                   => 1,
                'created_at'                  => '2026-01-10 11:00:00',
                'updated_at'                  => '2026-01-12 15:30:00',
            ],
            [
                'id'                          => 9,
                'agency_id'                   => 8,
                'agency_name'                 => 'Badan Pendapatan Daerah',
                'agency_abbreviation'         => 'BAPENDA',
                'commitment_officer_id'       => 8,
                'commitment_officer_name'     => 'H. Syamsul Bahri, S.E., M.Si.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Pengelolaan dan Peningkatan Penerimaan Pajak Daerah',
                'package_name'                => 'Pengadaan Mesin Cetak Dokumen SPPT PBB-P2 dan Surat Ketetapan',
                'package_code'                => 'RUP-2026-10293847',
                'location'                    => 'Kantor Bapenda Gedung B Lt. 2',
                'expense_type_id'             => 1,
                'expense_type_name'           => 'Modal',
                'procurement_type_id'         => 1,
                'procurement_type_name'       => 'Barang',
                'volume'                      => '2 Unit Mesin Cetak High-Speed Laser Duplex',
                'description'                 => 'Printer line continuous format untuk pencetakan massal SPPT PBB daerah se-provinsi.',
                'selection_method_id'         => 1,
                'selection_method_name'       => 'E-purchasing',
                'submission_date'             => '2026-03-05',
                'notes'                       => 'Garansi resmi 3 tahun on-site service',
                'rup_status'                  => 0,
                'funding_source_id'           => 1,
                'funding_source_name'         => 'APBD',
                'work_duration'               => 30,
                'budget_ceiling'              => 275000000.00,
                'account_code'                => '5.2.02.10.01.0002',
                'special_allocation_type_id'  => 2,
                'special_allocation_type_name'=> 'NON DAK',
                'package_status'              => 0,
                'is_synced'                   => 0,
                'created_at'                  => '2026-03-05 09:00:00',
                'updated_at'                  => '2026-03-05 09:00:00',
            ],
            [
                'id'                          => 10,
                'agency_id'                   => 3,
                'agency_name'                 => 'Dinas Pendidikan',
                'agency_abbreviation'         => 'DISDIK',
                'commitment_officer_id'       => 3,
                'commitment_officer_name'     => 'Drs. Ahmad Fauzi, M.Pd.',
                'fiscal_year'                 => '2026',
                'activity'                    => 'Peningkatan Kualitas Sarana Belajar Siswa Disabilitas',
                'package_name'                => 'Pengadaan Alat Peraga Edukatif dan Buku Braille SLB Negeri',
                'package_code'                => 'RUP-2026-44910283',
                'location'                    => 'SLB Negeri Pembina, Pekanbaru',
                'expense_type_id'             => 2,
                'expense_type_name'           => 'Barang/Jasa',
                'procurement_type_id'         => 1,
                'procurement_type_name'       => 'Barang',
                'volume'                      => '1 Paket Sarana Khusus',
                'description'                 => 'Buku bacaan braille berstandar Diknas, alat peraga tactual matematika & sains untuk siswa tuna netra.',
                'selection_method_id'         => 2,
                'selection_method_name'       => 'Pengadaan Langsung',
                'submission_date'             => '2026-02-28',
                'notes'                       => 'Prioritas pemenuhan hak belajar inklusif',
                'rup_status'                  => 1,
                'funding_source_id'           => 1,
                'funding_source_name'         => 'APBD',
                'work_duration'               => 40,
                'budget_ceiling'              => 145000000.00,
                'account_code'                => '5.1.02.01.01.0089',
                'special_allocation_type_id'  => 2,
                'special_allocation_type_name'=> 'NON DAK',
                'package_status'              => 2,
                'is_synced'                   => 1,
                'created_at'                  => '2026-02-28 14:10:00',
                'updated_at'                  => '2026-03-01 10:00:00',
            ],
        ];

        return array_map([$this, 'formatPlanRow'], $raw);
    }
}
