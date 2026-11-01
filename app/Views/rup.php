<?php
if ((int) session()->get('role_id') === 4 || strtoupper((string) session()->get('role_name')) === 'ADMIN ULP') {
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Role ADMIN ULP tidak memiliki akses ke halaman ini.');
}
?>
<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Daftar Paket RUP - Procurement Plans")) ?>

    <?= $this->include('partials/app-head-css') ?>

    <!-- Select2 CSS & Bootstrap 5 Theme via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <style>
        /* Badge Jenis Pengadaan - Light Mode */
        .badge-proc-barang {
            background-color: var(--bs-info-bg-subtle, #cff4fc);
            color: var(--bs-info-text-emphasis, #055160) !important;
            border: 1px solid var(--bs-info-border-subtle, #9eeaf9);
        }
        .badge-proc-konstruksi {
            background-color: var(--bs-primary-bg-subtle, #cfe2ff);
            color: var(--bs-primary-text-emphasis, #084298) !important;
            border: 1px solid var(--bs-primary-border-subtle, #9ec5fe);
        }
        .badge-proc-konsultasi {
            background-color: #f3e8ff;
            color: #6b21a8 !important;
            border: 1px solid #e9d5ff;
        }
        .badge-proc-lainnya {
            background-color: var(--bs-warning-bg-subtle, #fff3cd);
            color: var(--bs-warning-text-emphasis, #664d03) !important;
            border: 1px solid var(--bs-warning-border-subtle, #ffe69c);
        }
        .badge-proc-terintegrasi {
            background-color: var(--bs-success-bg-subtle, #d1e7dd);
            color: var(--bs-success-text-emphasis, #0f5132) !important;
            border: 1px solid var(--bs-success-border-subtle, #a3cfbb);
        }
        .badge-proc-default {
            background-color: var(--bs-secondary-bg-subtle, #e2e3e5);
            color: var(--bs-secondary-text-emphasis, #41464b) !important;
            border: 1px solid var(--bs-secondary-border-subtle, #c4c8cb);
        }

        /* Badge DAK / Non DAK - Light Mode */
        .badge-dak {
            background-color: #e0f2fe;
            color: #0369a1 !important;
            border: 1px solid #bae6fd;
        }
        .badge-non-dak {
            background-color: #f1f5f9;
            color: #475569 !important;
            border: 1px solid #e2e8f0;
        }

        .table-rup th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .plan-title-cell {
            min-width: 280px;
            max-width: 360px;
        }
        .rup-meta-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.72rem;
            color: var(--bs-secondary-color, #64748b);
        }
        .detail-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--bs-secondary-color, #64748b);
            font-weight: 600;
            margin-bottom: 2px;
        }
        .detail-value {
            font-size: 0.9rem;
            color: var(--bs-body-color, #1e293b);
            font-weight: 500;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        /* ========================================================
           Baris RUP yang Dapat Diedit (Soft Emerald/Mint Tint)
           ======================================================== */
        .table-rup tbody tr.rup-row-editable > td {
            background-color: rgba(16, 185, 129, 0.055) !important;
        }
        .table-rup tbody tr.rup-row-editable:hover > td {
            background-color: rgba(16, 185, 129, 0.11) !important;
        }
        .table-rup tbody tr.rup-row-editable > td:first-child {
            border-left: 3px solid #10b981;
        }

        /* ========================================================
           DARK MODE ADAPTATIONS ([data-bs-theme="dark"])
           ======================================================== */
        [data-bs-theme="dark"] .badge-proc-barang {
            background-color: rgba(6, 182, 212, 0.18);
            color: #67e8f9 !important;
            border-color: rgba(6, 182, 212, 0.35);
        }
        [data-bs-theme="dark"] .badge-proc-konstruksi {
            background-color: rgba(59, 130, 246, 0.18);
            color: #93c5fd !important;
            border-color: rgba(59, 130, 246, 0.35);
        }
        [data-bs-theme="dark"] .badge-proc-konsultasi {
            background-color: rgba(168, 85, 247, 0.22);
            color: #d8b4fe !important;
            border-color: rgba(168, 85, 247, 0.4);
        }
        [data-bs-theme="dark"] .badge-proc-lainnya {
            background-color: rgba(245, 158, 11, 0.18);
            color: #fcd34d !important;
            border-color: rgba(245, 158, 11, 0.35);
        }
        [data-bs-theme="dark"] .badge-proc-terintegrasi {
            background-color: rgba(34, 197, 94, 0.18);
            color: #86efac !important;
            border-color: rgba(34, 197, 94, 0.35);
        }
        [data-bs-theme="dark"] .badge-proc-default {
            background-color: rgba(148, 163, 184, 0.15);
            color: #cbd5e1 !important;
            border-color: rgba(148, 163, 184, 0.3);
        }
        [data-bs-theme="dark"] .badge-dak {
            background-color: rgba(14, 165, 233, 0.2);
            color: #7dd3fc !important;
            border-color: rgba(14, 165, 233, 0.35);
        }
        [data-bs-theme="dark"] .badge-non-dak {
            background-color: rgba(148, 163, 184, 0.15);
            color: #cbd5e1 !important;
            border-color: rgba(148, 163, 184, 0.3);
        }
        [data-bs-theme="dark"] .detail-value {
            color: var(--bs-body-color, #dee2e6);
        }
        [data-bs-theme="dark"] .detail-label {
            color: var(--bs-secondary-color, #a7acb1);
        }
        [data-bs-theme="dark"] .table-light {
            --bs-table-color: var(--bs-body-color);
            --bs-table-bg: var(--bs-tertiary-bg);
            --bs-table-border-color: var(--bs-border-color);
        }
        [data-bs-theme="dark"] .table-rup tbody tr.rup-row-editable > td {
            background-color: rgba(16, 185, 129, 0.09) !important;
        }
        [data-bs-theme="dark"] .table-rup tbody tr.rup-row-editable:hover > td {
            background-color: rgba(16, 185, 129, 0.16) !important;
        }
        [data-bs-theme="dark"] .table-rup tbody tr.rup-row-editable > td:first-child {
            border-left: 3px solid #059669;
        }

        /* Styling tautan & tombol Lihat Detail RUP */
        .plan-title-link {
            color: var(--bs-body-color, #1e293b);
            text-decoration: none;
            transition: color 0.15s ease-in-out;
            cursor: pointer;
        }
        .plan-title-link:hover {
            color: var(--bs-primary, #0d6efd) !important;
            text-decoration: underline;
        }
        .plan-code-link {
            text-decoration: none;
            cursor: pointer;
            transition: opacity 0.15s ease-in-out;
        }
        .plan-code-link:hover {
            text-decoration: underline;
            opacity: 0.85;
        }
        .btn-view-plan {
            cursor: pointer;
        }

        @media print {
            @page {
                size: auto;
                margin: 10mm 12mm;
            }

            /* Sembunyikan elemen latar aplikasi dan backdrop agar tidak memakan tinggi vertikal halaman */
            body.modal-open,
            html {
                height: auto !important;
                min-height: 0 !important;
                overflow: visible !important;
                background: #ffffff !important;
                color: #000000 !important;
            }

            body.modal-open .app-wrap,
            body:has(#detailPlanModal.show) .app-wrap,
            .modal-backdrop,
            .modal:not(#detailPlanModal) {
                display: none !important;
            }

            #detailPlanModal {
                position: static !important;
                display: block !important;
                width: 100% !important;
                height: auto !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
                opacity: 1 !important;
            }

            #detailPlanModal .modal-dialog {
                max-width: 100% !important;
                width: 100% !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                transform: none !important;
                display: block !important;
            }

            /* Matikan pseudo-element 100vh milik .modal-dialog-centered yang memicu lembar ke-2 kosong */
            #detailPlanModal .modal-dialog-centered::before {
                display: none !important;
                height: 0 !important;
                content: none !important;
            }

            #detailPlanModal .modal-content {
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
            }

            #detailPlanModal .modal-header,
            #detailPlanModal .modal-footer,
            #detailPlanModal .btn-close {
                display: none !important;
            }

            #detailPlanModal .modal-body {
                padding: 0.5rem 0 !important;
                overflow: visible !important;
            }

            #detailPlanModal .card,
            #detailPlanModal .rounded-2 {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array(
                        "pageTitle" => "Daftar Paket RUP",
                        "pageSubTitle1" => "Perencanaan Pengadaan",
                        "pageSubTitle2" => "Procurement Plans",
                        "pageSubText" => "Rencana Umum Pengadaan (RUP) SiRUP LKPP, informasi pagu anggaran, metode pemilihan, dan progres paket perencanaan."
                    )) ?>

                    <?php
                    // Pastikan variabel terdefinisi
                    $plans            = $plans ?? [];
                    $skpd         = $skpd ?? [];
                    $officers         = $officers ?? [];
                    $jenisBelanja     = $jenisBelanja ?? [];
                    $jenisPengadaan = $jenisPengadaan ?? [];
                    $sumberDana   = $sumberDana ?? [];
                    $metodePemilihan = $metodePemilihan ?? [];
                    $jenisDaks  = $jenisDaks ?? [];

                    $totalPlans       = $totalPlans ?? count($plans);
                    $totalBudget      = $totalBudget ?? array_sum(array_column($plans, 'budget_ceiling'));
                    $editableCount    = $editableCount ?? count(array_filter($plans, fn($p) => (int)($p['rup_status'] ?? 1) === 1));
                    $lockedCount      = $lockedCount ?? count(array_filter($plans, fn($p) => (int)($p['rup_status'] ?? 1) === 2));
                    $syncedCount      = $syncedCount ?? count(array_filter($plans, fn($p) => (int)($p['is_synced'] ?? 0) === 1));
                    $dakCount         = $dakCount ?? count(array_filter($plans, fn($p) => (int)($p['jenis_dak_id'] ?? 2) === 1));

                    // Helper format rupiah singkat untuk stat cards
                    $formatShortRupiah = function($amount) {
                        if ($amount >= 1000000000) {
                            return 'Rp ' . number_format($amount / 1000000000, 2, ',', '.') . ' M';
                        } elseif ($amount >= 1000000) {
                            return 'Rp ' . number_format($amount / 1000000, 1, ',', '.') . ' Jt';
                        }
                        return 'Rp ' . number_format($amount, 0, ',', '.');
                    };
                    ?>

                    <div class="main-content">

                        <!-- Stat Cards Banner -->
                        <div class="row mb-4 g-3">
                            <!-- Card 1: Total Paket -->
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#file-text"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total Paket RUP</div>
                                            <div class="fs-2 fw-bold text-body-emphasis"><?= $totalPlans ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-muted">Tahun Anggaran <?= date('Y') ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Total Pagu Anggaran -->
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#dollar-sign"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total Pagu Anggaran</div>
                                            <div class="fs-2 fw-bold text-success"><?= $formatShortRupiah($totalBudget) ?></div>
                                            <div class="fs-xs text-muted" title="Rp <?= number_format($totalBudget, 2, ',', '.') ?>">
                                                Rp <?= number_format($totalBudget, 0, ',', '.') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Alokasi DAK vs Sinkronisasi -->
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#refresh-cw"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Tersinkron SiRUP</div>
                                            <div class="fs-2 fw-bold text-body-emphasis"><?= $syncedCount ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-muted"><?= $dakCount ?> paket sumber DAK</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Flash Message Alert -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3 shadow-sm" role="alert">
                                <i class="fal fa-check-circle fs-5"></i>
                                <div><?= session()->getFlashdata('success') ?></div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3 shadow-sm" role="alert">
                                <i class="fal fa-exclamation-triangle fs-5"></i>
                                <div><?= session()->getFlashdata('error') ?></div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Panel Tabel Utama Procurement Plans -->
                        <div id="panel-rup" class="panel">
                            <div class="panel-hdr">
                                <h2>
                                    Daftar <span class="fw-300"><i>Paket RUP</i></span>
                                </h2>
                                <div class="panel-toolbar d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" onclick="simulateSyncSirup()">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#refresh-cw"></use>
                                        </svg>
                                        <span>Tarik SiRUP</span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addPlanModal">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#plus"></use>
                                        </svg>
                                        <span>Tambah RUP</span>
                                    </button>
                                </div>
                            </div>

                            <div class="panel-container show">
                                <div class="panel-content">

                                    <!-- Filter Toolbar Komprehensif -->
                                    <div class="row g-2 mb-3 align-items-center">
                                        <!-- Search Box -->
                                        <div class="col-md-4 col-lg-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">
                                                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                        <use href="/icons/sprite.svg#search"></use>
                                                    </svg>
                                                </span>
                                                <input type="text" id="planSearchInput" class="form-control" placeholder="Cari paket, kode RUP, SKPD, MAK...">
                                            </div>
                                        </div>

                                        <!-- Filter Jenis Pengadaan -->
                                        <div class="col-6 col-md-3 col-lg-2">
                                            <select id="procTypeFilter" class="form-select form-select-sm">
                                                <option value="">Semua Jenis Pengadaan</option>
                                                <option value="Barang">Barang</option>
                                                <option value="Pekerjaan Konstruksi">Pekerjaan Konstruksi</option>
                                                <option value="Jasa Konsultasi">Jasa Konsultasi</option>
                                                <option value="Jasa Konsultansi">Jasa Konsultansi</option>
                                                <option value="Jasa Lainnya">Jasa Lainnya</option>
                                                <option value="Pekerjaan Terintegrasi">Pekerjaan Terintegrasi</option>
                                            </select>
                                        </div>

                                        <!-- Filter Metode Pemilihan -->
                                        <div class="col-6 col-md-3 col-lg-2">
                                            <select id="methodFilter" class="form-select form-select-sm">
                                                <option value="">Semua Metode</option>
                                                <option value="E-purchasing">E-Purchasing</option>
                                                <option value="Tender">Tender</option>
                                                <option value="Pengadaan Langsung">Pengadaan Langsung</option>
                                                <option value="Seleksi">Seleksi</option>
                                                <option value="Penunjukan Langsung">Penunjukan Langsung</option>
                                            </select>
                                        </div>

                                        <!-- Filter Sumber Dana / DAK -->
                                        <div class="col-6 col-md-2 col-lg-2">
                                            <select id="dakFilter" class="form-select form-select-sm">
                                                <option value="">Semua DAK</option>
                                                <option value="DAK">DAK</option>
                                                <option value="NON DAK">NON DAK</option>
                                            </select>
                                        </div>

                                        <!-- Per Page Selector -->
                                        <div class="col-6 col-md-12 col-lg-2 ms-auto">
                                            <div class="d-flex align-items-center gap-1 justify-content-lg-end">
                                                <span class="fs-xs text-muted text-nowrap">Tampil:</span>
                                                <select id="perPageSelect" class="form-select form-select-sm" style="width: auto;">
                                                    <option value="10" selected>10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="all">Semua</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabel RUP Responsif -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped align-middle mb-0 table-rup" id="plansTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 40px;">#</th>
                                                    <th style="min-width: 140px;">Kode RUP & TA</th>
                                                    <th class="plan-title-cell">Paket & Kegiatan</th>
                                                    <th style="min-width: 150px;">Jenis & Metode</th>
                                                    <th class="text-end" style="min-width: 160px;">Pagu Anggaran</th>
                                                    <th class="text-center" style="min-width: 90px;">Waktu</th>
                                                    <th class="text-end" style="width: 75px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($plans as $p): ?>
                                                    <?php
                                                    $planJson = htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8');
                                                    $canEdit = (int) ($p['rup_status'] ?? 1) === 1 && empty($p['paket_id']);
                                                    $isSynced = (int) ($p['is_synced'] ?? 0) === 1;
                                                    $isDak = ($p['jenis_dak_name'] ?? '') === 'DAK';
                                                    ?>
                                                    <tr class="plan-row <?= $canEdit ? 'rup-row-editable' : '' ?>"
                                                        title="<?= $canEdit ? 'Paket RUP dapat diubah/diedit' : 'Paket RUP sudah terkunci karena telah dibuatkan Paket Pengadaan' ?>"
                                                        data-id="<?= $p['id'] ?>"
                                                        data-code="<?= esc(strtolower($p['package_code'] ?? '')) ?>"
                                                        data-name="<?= esc(strtolower($p['package_name'] ?? '')) ?>"
                                                        data-activity="<?= esc(strtolower($p['activity'] ?? '')) ?>"
                                                        data-skpd="<?= esc(strtolower(($p['skpd_abbreviation'] ?? '') . ' ' . ($p['skpd_name'] ?? ''))) ?>"
                                                        data-mak="<?= esc(strtolower($p['account_code'] ?? '')) ?>"
                                                        data-proc-type="<?= esc($p['jenis_pengadaan_name'] ?? '') ?>"
                                                        data-method="<?= esc($p['metode_pemilihan_name'] ?? '') ?>"
                                                        data-rup-status="<?= $canEdit ? 1 : 2 ?>"
                                                        data-dak="<?= esc($p['jenis_dak_name'] ?? 'NON DAK') ?>"
                                                        data-year="<?= esc($p['fiscal_year'] ?? '') ?>">
                                                        
                                                        <td class="text-muted fs-xs"><?= $p['id'] ?></td>
                                                        
                                                        <!-- Kode RUP & Tahun Anggaran -->
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                                <a href="javascript:void(0);" class="font-monospace fw-semibold text-primary fs-xs plan-code-link btn-view-plan" data-plan='<?= $planJson ?>' title="Lihat Detail RUP">
                                                                    <?= esc($p['package_code'] ?: 'DRAFT-' . $p['id']) ?>
                                                                </a>
                                                                <?php if ($isSynced): ?>
                                                                    <span class="badge bg-success-subtle text-success p-1 rounded-circle" title="Tersinkronisasi SiRUP LKPP">
                                                                        <svg class="sa-icon" style="width: 10px; height: 10px;">
                                                                            <use href="/icons/sprite.svg#check"></use>
                                                                        </svg>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="rup-meta-tag">
                                                                <span class="badge bg-body-secondary text-secondary border">TA <?= esc($p['fiscal_year']) ?></span>
                                                                <span class="badge <?= $isDak ? 'badge-dak' : 'badge-non-dak' ?>">
                                                                    <?= esc($p['jenis_dak_name'] ?? 'NON DAK') ?>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <!-- Nama Paket & Program/Kegiatan -->
                                                        <td class="plan-title-cell">
                                                            <div class="mb-1" style="line-height: 1.35;">
                                                                <a href="javascript:void(0);" class="fw-semibold text-body-emphasis text-break plan-title-link btn-view-plan" data-plan='<?= $planJson ?>' title="Lihat Detail: <?= esc($p['package_name']) ?>">
                                                                    <?= esc($p['package_name']) ?>
                                                                </a>
                                                            </div>
                                                            <div class="text-muted fs-nano mb-1 text-truncate" title="<?= esc($p['activity']) ?>">
                                                                <svg class="sa-icon me-1 text-muted" style="width: 11px; height: 11px;">
                                                                    <use href="/icons/sprite.svg#layers"></use>
                                                                </svg>
                                                                <?= esc($p['activity']) ?>
                                                            </div>
                                                            <?php if (!empty($p['location'])): ?>
                                                                <div class="rup-meta-tag text-truncate" title="<?= esc($p['location']) ?>">
                                                                    <svg class="sa-icon text-muted" style="width: 10px; height: 10px;">
                                                                        <use href="/icons/sprite.svg#map-pin"></use>
                                                                    </svg>
                                                                    <?= esc($p['location']) ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>


                                                        <!-- Jenis & Metode Pemilihan -->
                                                        <td>
                                                            <div class="mb-1">
                                                                <span class="badge <?= $p['proc_badge'] ?? 'badge-proc-default' ?>">
                                                                    <?= esc($p['jenis_pengadaan_name'] ?? 'Barang') ?>
                                                                </span>
                                                            </div>
                                                            <div class="fs-xs text-secondary">
                                                                <?= esc($p['metode_pemilihan_name'] ?? '-') ?>
                                                            </div>
                                                        </td>

                                                        <!-- Pagu Anggaran & Sumber Dana -->
                                                        <td class="text-end">
                                                            <div class="fw-bold text-body-emphasis font-monospace fs-sm">
                                                                Rp <?= number_format((float) $p['budget_ceiling'], 0, ',', '.') ?>
                                                            </div>
                                                            <div class="fs-nano text-muted">
                                                                <?= esc($p['sumber_dana_name'] ?? 'APBD') ?> &bull; <?= esc($p['jenis_belanja_name'] ?? 'Modal') ?>
                                                            </div>
                                                        </td>

                                                        <!-- Waktu / Durasi -->
                                                        <td class="text-center">
                                                            <div class="badge bg-body-secondary text-body border font-monospace">
                                                                <?= (int) $p['work_duration'] ?> Hari
                                                            </div>
                                                            <?php if (!empty($p['volume'])): ?>
                                                                <div class="fs-nano text-muted mt-1 text-truncate" title="<?= esc($p['volume']) ?>">
                                                                    <?= esc($p['volume']) ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Aksi Dropdown & Tombol Detail Langsung -->
                                                        <td class="text-end">
                                                            <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                                                <button class="btn btn-sm btn-icon btn-light btn-view-plan" type="button" data-plan='<?= $planJson ?>' title="Lihat Detail RUP">
                                                                    <svg class="sa-icon text-primary" style="width: 14px; height: 14px;">
                                                                        <use href="/icons/sprite.svg#eye"></use>
                                                                    </svg>
                                                                </button>
                                                                <?php if ($canEdit): ?>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-sm btn-icon btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Opsi">
                                                                            <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                                                <use href="/icons/sprite.svg#more-vertical"></use>
                                                                            </svg>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                                            <li>
                                                                                <a class="dropdown-item btn-edit-plan" href="javascript:void(0);" data-plan='<?= $planJson ?>'>
                                                                                    <svg class="sa-icon me-2 text-secondary" style="width: 13px; height: 13px;">
                                                                                        <use href="/icons/sprite.svg#edit"></use>
                                                                                    </svg>
                                                                                    Ubah Paket
                                                                                </a>
                                                                            </li>
                                                                            <li><hr class="dropdown-divider"></li>
                                                                            <li>
                                                                                <a class="dropdown-item text-danger btn-delete-plan" href="javascript:void(0);" data-plan='<?= $planJson ?>'>
                                                                                    <svg class="sa-icon me-2 text-danger" style="width: 13px; height: 13px;">
                                                                                        <use href="/icons/sprite.svg#trash-2"></use>
                                                                                    </svg>
                                                                                    Hapus Paket
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <tr id="noResultsRow" style="display: none;">
                                                    <td colspan="7" class="text-center py-5 text-muted">
                                                        <div class="mb-2">
                                                            <svg class="sa-icon text-muted" style="width: 32px; height: 32px;">
                                                                <use href="/icons/sprite.svg#search"></use>
                                                            </svg>
                                                        </div>
                                                        <div class="fw-semibold">Tidak ada paket RUP yang ditemukan</div>
                                                        <small class="text-muted">Coba ubah kata kunci pencarian atau sesuaikan filter di atas.</small>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination Footer -->
                                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                        <div class="fs-xs text-muted" id="paginationInfo">
                                            Menampilkan 1 sampai 10 dari <?= $totalPlans ?> paket RUP
                                        </div>
                                        <nav aria-label="Navigasi Halaman RUP">
                                            <ul class="pagination pagination-sm mb-0" id="paginationControls">
                                                <!-- Dynamic pagination buttons -->
                                            </ul>
                                        </nav>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <?= $this->include('partials/app-footer') ?>

        </main>


        <?= $this->include('partials/app-settings') ?>

    </div>

    <!-- MODAL 1: Detail Paket RUP Komprehensif -->
    <div class="modal fade" id="detailPlanModal" tabindex="-1" aria-labelledby="detailPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-body-tertiary">
                    <div>
                        <span class="badge bg-primary font-monospace fs-sm" id="modalPlanCode">RUP-XXXX-XXXX</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Judul Paket & Program -->
                    <div class="border-bottom pb-3 mb-3">
                        <h5 class="fw-bold text-body-emphasis mb-1" id="modalPlanName">-</h5>
                        <div class="text-muted fs-sm" id="modalPlanActivityWrap">
                            <svg class="sa-icon me-1 text-muted" style="width: 14px; height: 14px;">
                                <use href="/icons/sprite.svg#layers"></use>
                            </svg>
                            <span id="modalPlanActivity">-</span>
                        </div>
                    </div>

                    <!-- Grid Informasi Detail 100% Berdasarkan Migration -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-body-tertiary rounded-2 h-100">
                                <h6 class="fw-bold text-body-emphasis mb-3 fs-xs text-uppercase">Informasi Satuan Kerja & PPK</h6>
                                <div class="mb-2">
                                    <div class="detail-label">Instansi / SKPD</div>
                                    <div class="detail-value" id="modalPlanSkpd">-</div>
                                </div>
                                <div class="mb-2">
                                    <div class="detail-label">Pejabat Pembuat Komitmen (PPK)</div>
                                    <div class="detail-value" id="modalPlanOfficer">-</div>
                                </div>
                                <div class="mb-2">
                                    <div class="detail-label">Lokasi Pekerjaan</div>
                                    <div class="detail-value" id="modalPlanLocation">-</div>
                                </div>
                                <div>
                                    <div class="detail-label">Volume Pekerjaan</div>
                                    <div class="detail-value" id="modalPlanVolume">-</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-body-tertiary rounded-2 h-100">
                                <h6 class="fw-bold text-body-emphasis mb-3 fs-xs text-uppercase">Pagu & Penganggaran</h6>
                                <div class="mb-2">
                                    <div class="detail-label">Total Pagu Anggaran</div>
                                    <div class="detail-value text-success fs-5 fw-bold font-monospace" id="modalPlanBudget">Rp 0</div>
                                </div>
                                <div class="mb-2">
                                    <div class="detail-label">Mata Anggaran Kegiatan (MAK)</div>
                                    <div class="detail-value font-monospace text-break" id="modalPlanMak">-</div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <div class="detail-label">Sumber Dana</div>
                                        <div class="detail-value" id="modalPlanFunding">-</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="detail-label">Status DAK</div>
                                        <div class="detail-value" id="modalPlanDak">-</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="detail-label">Jenis Belanja</div>
                                    <div class="detail-value" id="modalPlanJenisBelanja">-</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-body-tertiary rounded-2 h-100">
                                <h6 class="fw-bold text-body-emphasis mb-3 fs-xs text-uppercase">Metode & Waktu Pengadaan</h6>
                                <div class="mb-2">
                                    <div class="detail-label">Jenis Pengadaan</div>
                                    <div class="detail-value" id="modalPlanProcType">-</div>
                                </div>
                                <div class="mb-2">
                                    <div class="detail-label">Metode Pemilihan</div>
                                    <div class="detail-value" id="modalPlanMethod">-</div>
                                </div>
                                <div>
                                    <div class="detail-label">Waktu Pekerjaan</div>
                                    <div class="detail-value" id="modalPlanDuration">0 Hari</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-body-tertiary rounded-2 h-100">
                                <h6 class="fw-bold text-body-emphasis mb-3 fs-xs text-uppercase">Tahun Anggaran & Pengajuan</h6>
                                <div class="mb-2">
                                    <div class="detail-label">Tahun Anggaran</div>
                                    <div class="detail-value font-monospace fw-bold" id="modalPlanYear">2026</div>
                                </div>
                                <div>
                                    <div class="detail-label">Tanggal Rencana Pengajuan</div>
                                    <div class="detail-value" id="modalPlanDate">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Uraian Pekerjaan & Catatan -->
                        <div class="col-12">
                            <div class="p-3 border rounded-2">
                                <div class="mb-2">
                                    <div class="detail-label">Uraian / Deskripsi Pekerjaan</div>
                                    <p class="fs-sm text-body mb-0" id="modalPlanDescription">-</p>
                                </div>
                                <div class="mt-3 pt-2 border-top">
                                    <div class="detail-label">Catatan Tambahan</div>
                                    <p class="fs-xs text-muted mb-0" id="modalPlanNotes">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm px-4 d-inline-flex align-items-center justify-content-center text-nowrap gap-2" style="min-width: 180px;" onclick="printRupDetail()">
                        <svg class="sa-icon" style="width: 15px; height: 15px;">
                            <use href="/icons/sprite.svg#printer"></use>
                        </svg>
                        <span>Cetak Lembar RUP</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 2: Tambah Paket RUP Baru -->
    <div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPlanModalLabel">Tambah Paket Rencana Pengadaan (RUP)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addPlanForm" action="/rup/store" method="POST">
                        <?= csrf_field() ?>
                        <div id="addPlanAlertContainer" class="d-none mb-3"></div>

                        <!-- Info Otomatisasi SKPD & PPK Berdasarkan User Login -->
                        <div class="alert alert-info border-info-subtle bg-info-subtle bg-opacity-10 py-2 px-3 mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2 rounded-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fal fa-shield-check text-info fs-4 flex-shrink-0"></i>
                                <div>
                                    <div class="fs-xs fw-bold text-body-emphasis text-uppercase">Instansi / SKPD & PPK Terisi Otomatis</div>
                                    <small class="text-muted fs-nano">Paket ini secara otomatis dikaitkan dengan akun & instansi Anda di backend.</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="badge bg-body-secondary text-body border font-monospace fs-nano" title="Instansi / SKPD">
                                    <i class="fal fa-building text-primary me-1"></i>
                                    <?= esc(!empty($currentUser['skpd_name']) ? ($currentUser['skpd_abbr'] ? $currentUser['skpd_abbr'] . ' - ' : '') . $currentUser['skpd_name'] : 'Instansi Akun Login') ?>
                                </span>
                                <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle font-monospace fs-nano" title="Pejabat Pembuat Komitmen (PPK)">
                                    <i class="fal fa-user-tie text-info me-1"></i>
                                    <?= esc(!empty($currentUser['ppk_name']) ? $currentUser['ppk_name'] : (!empty($currentUser['full_name']) ? $currentUser['full_name'] : 'PPK Akun Login')) ?>
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="is_synced" id="addPlanIsSynced" value="0">

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted d-flex align-items-center justify-content-between">
                                    <span>Kode Paket / Kode SiRUP (INAPROC)</span>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-normal" style="font-size: 0.65rem;">Integrasi API INAPROC</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="package_code" id="addPlanPackageCode" class="form-control font-monospace" placeholder="Masukkan Kode RUP (Contoh: 62421910) lalu klik Tarik Data API">
                                    <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-1 px-3" id="btnFetchInaproc" title="Tarik data RUP dari API INAPROC Kab. Kotabaru">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#download-cloud"></use>
                                        </svg>
                                        <span>Tarik Data API</span>
                                    </button>
                                </div>
                                <div class="form-text fs-nano text-muted mt-1">
                                    Ketik Kode RUP (misal: <code class="user-select-all">62421910</code>) &amp; klik <strong>Tarik Data API</strong> untuk isi otomatis, atau kosongkan untuk kode draf.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Tahun Anggaran <span class="text-danger">*</span></label>
                                <input type="number" name="fiscal_year" class="form-control form-control-sm font-monospace" value="<?= date('Y') ?>" required>
                            </div>

                            <!-- Preview Metadata dari API INAPROC -->
                            <div class="col-12 d-none" id="inaprocApiPreview">
                                <div class="p-3 rounded-2 border border-success-subtle bg-success-subtle bg-opacity-10">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2 pb-2 border-bottom border-success-subtle">
                                        <div class="d-flex align-items-center gap-2">
                                            <svg class="sa-icon text-success flex-shrink-0" style="width: 16px; height: 16px;">
                                                <use href="/icons/sprite.svg#check-circle"></use>
                                            </svg>
                                            <span class="fs-xs fw-bold text-success-emphasis text-uppercase" id="inaprocPreviewHeader">Data API INAPROC Terhubung</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-1 flex-wrap" id="inaprocPreviewBadges"></div>
                                    </div>
                                    <div class="row g-2 fs-xs">
                                        <div class="col-md-6">
                                            <span class="text-muted d-block fs-nano text-uppercase">Satker pada SiRUP / INAPROC:</span>
                                            <span class="fw-semibold text-body-emphasis" id="inaprocPreviewSatker">-</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted d-block fs-nano text-uppercase">PPK pada SiRUP:</span>
                                            <span class="fw-semibold text-body-emphasis" id="inaprocPreviewPpk">-</span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="text-muted d-block fs-nano text-uppercase">Jadwal Kontrak:</span>
                                            <span class="font-monospace text-body-emphasis" id="inaprocPreviewKontrak">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Kegiatan / Program <span class="text-danger">*</span></label>
                                <input type="text" name="activity" class="form-control form-control-sm" placeholder="Contoh: Program Penyelenggaraan Jalan dan Jembatan" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Paket Pengadaan <span class="text-danger">*</span></label>
                                <input type="text" name="package_name" class="form-control form-control-sm" placeholder="Contoh: Pembangunan Jembatan Sei Siak Ruas Simpang Tiga" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Jenis Pengadaan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="jenis_pengadaan_id" required>
                                    <option value="">-- Pilih Jenis Pengadaan --</option>
                                    <?php if (!empty($jenisPengadaan)): ?>
                                        <?php foreach ($jenisPengadaan as $pt): ?>
                                            <option value="<?= $pt['id'] ?>" <?= $pt['name'] === 'Pekerjaan Konstruksi' ? 'selected' : '' ?>><?= esc($pt['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Barang</option>
                                        <option value="2">Jasa Konsultansi</option>
                                        <option value="3">Jasa Lainnya</option>
                                        <option value="4" selected>Pekerjaan Konstruksi</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Metode Pemilihan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="metode_pemilihan_id" required>
                                    <option value="">-- Pilih Metode Pemilihan --</option>
                                    <?php if (!empty($metodePemilihan)): ?>
                                        <?php foreach ($metodePemilihan as $sm): ?>
                                            <option value="<?= $sm['id'] ?>" <?= $sm['name'] === 'Tender' ? 'selected' : '' ?>><?= esc($sm['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">E-purchasing</option>
                                        <option value="2">Pengadaan Langsung</option>
                                        <option value="3">Penunjukan Langsung</option>
                                        <option value="4" selected>Tender</option>
                                        <option value="5">Seleksi</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                 <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Pagu Anggaran (Rp) <span class="text-danger">*</span></label>
                                 <div class="input-group input-group-sm">
                                     <span class="input-group-text">Rp</span>
                                     <input type="number" name="budget_ceiling" class="form-control font-monospace" placeholder="0" min="0" step="any" required>
                                 </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Mata Anggaran Kegiatan (MAK)</label>
                                <input type="text" name="account_code" class="form-control form-control-sm font-monospace" placeholder="Contoh: 5.2.04.01.01.0001">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Sumber Dana <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="sumber_dana_id" required>
                                    <?php if (!empty($sumberDana)): ?>
                                        <?php foreach ($sumberDana as $fs): ?>
                                            <option value="<?= $fs['id'] ?>" <?= $fs['name'] === 'APBD' ? 'selected' : '' ?>><?= esc($fs['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1" selected>APBD</option>
                                        <option value="2">APBN</option>
                                        <option value="3">DAK Fisik</option>
                                        <option value="4">BLUD</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Status DAK</label>
                                <select class="form-select form-select-sm" name="jenis_dak_id">
                                    <?php if (!empty($jenisDaks)): ?>
                                        <?php foreach ($jenisDaks as $at): ?>
                                            <option value="<?= $at['id'] ?>" <?= $at['name'] === 'NON DAK' ? 'selected' : '' ?>><?= esc($at['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="2" selected>NON DAK</option>
                                        <option value="1">DAK</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Waktu Pekerjaan (Hari)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="work_duration" class="form-control font-monospace" placeholder="90" min="1">
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Volume Pekerjaan</label>
                                <input type="text" name="volume" class="form-control form-control-sm" placeholder="Contoh: 1 Paket / 500 Meter" value="1 Paket">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Lokasi Pekerjaan</label>
                                <input type="text" name="location" class="form-control form-control-sm" placeholder="Contoh: Kec. Pulau Laut Sigam">
                            </div>

                            <div class="col-12">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Uraian / Deskripsi Pekerjaan</label>
                                <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Uraian singkat lingkup pekerjaan RUP..."></textarea>
                            </div>
                        </div>

                        <div class="modal-footer border-top py-2 px-0 mt-4 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center gap-1" id="addPlanSubmitBtn">
                                <i class="fal fa-save me-1"></i> Simpan Paket RUP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 3: Ubah Paket RUP -->
    <div class="modal fade" id="editPlanModal" tabindex="-1" aria-labelledby="editPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPlanModalLabel">Ubah Paket Rencana Pengadaan (RUP)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editPlanForm" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" id="editPlanId">
                        <div id="editPlanAlertContainer" class="d-none mb-3"></div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Tahun Anggaran <span class="text-danger">*</span></label>
                                <input type="number" name="fiscal_year" id="editPlanFiscalYear" class="form-control form-control-sm font-monospace" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Kode Paket / Kode SiRUP</label>
                                <input type="text" name="package_code" id="editPlanPackageCode" class="form-control form-control-sm font-monospace">
                            </div>

                            <div class="col-12">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Kegiatan / Program <span class="text-danger">*</span></label>
                                <input type="text" name="activity" id="editPlanActivity" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Paket Pengadaan <span class="text-danger">*</span></label>
                                <input type="text" name="package_name" id="editPlanPackageName" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Jenis Pengadaan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="jenis_pengadaan_id" id="editPlanJenisPengadaan" required>
                                    <option value="">-- Pilih Jenis Pengadaan --</option>
                                    <?php if (!empty($jenisPengadaan)): ?>
                                        <?php foreach ($jenisPengadaan as $pt): ?>
                                            <option value="<?= $pt['id'] ?>"><?= esc($pt['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Metode Pemilihan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="metode_pemilihan_id" id="editPlanMetodePemilihan" required>
                                    <option value="">-- Pilih Metode Pemilihan --</option>
                                    <?php if (!empty($metodePemilihan)): ?>
                                        <?php foreach ($metodePemilihan as $sm): ?>
                                            <option value="<?= $sm['id'] ?>"><?= esc($sm['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Pagu Anggaran (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="budget_ceiling" id="editPlanBudget" class="form-control font-monospace" min="0" step="any" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Mata Anggaran Kegiatan (MAK)</label>
                                <input type="text" name="account_code" id="editPlanMak" class="form-control form-control-sm font-monospace">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Sumber Dana <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="sumber_dana_id" id="editPlanSumberDana" required>
                                    <?php if (!empty($sumberDana)): ?>
                                        <?php foreach ($sumberDana as $fs): ?>
                                            <option value="<?= $fs['id'] ?>"><?= esc($fs['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Status DAK</label>
                                <select class="form-select form-select-sm" name="jenis_dak_id" id="editPlanJenisDak">
                                    <?php if (!empty($jenisDaks)): ?>
                                        <?php foreach ($jenisDaks as $at): ?>
                                            <option value="<?= $at['id'] ?>"><?= esc($at['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Waktu Pekerjaan (Hari)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="work_duration" id="editPlanDuration" class="form-control font-monospace" min="0">
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Volume Pekerjaan</label>
                                <input type="text" name="volume" id="editPlanVolume" class="form-control form-control-sm">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Lokasi Pekerjaan</label>
                                <input type="text" name="location" id="editPlanLocation" class="form-control form-control-sm">
                            </div>

                            <div class="col-12">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Uraian / Deskripsi Pekerjaan</label>
                                <textarea name="description" id="editPlanDescription" class="form-control form-control-sm" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer border-top py-2 px-0 mt-4 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center gap-1" id="editPlanSubmitBtn">
                                <i class="fal fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 4: Konfirmasi Hapus Paket RUP -->
    <div class="modal fade" id="deletePlanModal" tabindex="-1" aria-labelledby="deletePlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger-subtle border-danger-subtle">
                    <h5 class="modal-title text-danger-emphasis fw-bold d-flex align-items-center gap-2" id="deletePlanModalLabel">
                        <svg class="sa-icon text-danger" style="width: 18px; height: 18px;">
                            <use href="/icons/sprite.svg#trash-2"></use>
                        </svg>
                        <span>Hapus Paket RUP</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="deletePlanAlertContainer" class="d-none mb-3"></div>
                    <p class="mb-2 text-body">Apakah Anda yakin ingin menghapus paket RUP berikut?</p>
                    <div class="p-3 rounded-2 bg-body-tertiary border mb-3">
                        <div class="font-monospace fw-bold text-primary fs-xs mb-1" id="deletePlanCodeInfo">-</div>
                        <div class="fw-semibold text-body-emphasis fs-sm" id="deletePlanNameInfo">-</div>
                    </div>
                    <div class="alert alert-warning py-2 px-3 mb-0 fs-xs d-flex align-items-center gap-2">
                        <svg class="sa-icon text-warning flex-shrink-0" style="width: 15px; height: 15px;">
                            <use href="/icons/sprite.svg#alert-triangle"></use>
                        </svg>
                        <div>Data RUP yang telah dihapus tidak dapat dikembalikan.</div>
                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm px-3 d-inline-flex align-items-center gap-1" id="confirmDeletePlanBtn">
                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#trash-2"></use>
                        </svg>
                        <span>Ya, Hapus RUP</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('partials/app-scripts') ?>

    <!-- Interactive Client-side Script: Filter, Pagination & Detail Modal -->
    <script>
        // Buka modal tambah RUP dan fokus ke input Kode SiRUP / API INAPROC
        function simulateSyncSirup() {
            const modalEl = document.getElementById('addPlanModal');
            if (modalEl) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
                setTimeout(() => {
                    const codeInput = document.getElementById('addPlanPackageCode');
                    if (codeInput) codeInput.focus();
                }, 350);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('planSearchInput');
            const procTypeFilter = document.getElementById('procTypeFilter');
            const methodFilter = document.getElementById('methodFilter');
            const rupStatusFilter = document.getElementById('rupStatusFilter');
            const dakFilter = document.getElementById('dakFilter');
            const perPageSelect = document.getElementById('perPageSelect');
            const allRows = Array.from(document.querySelectorAll('.plan-row'));
            const paginationInfo = document.getElementById('paginationInfo');
            const paginationControls = document.getElementById('paginationControls');
            const noResultsRow = document.getElementById('noResultsRow');

            let currentPage = 1;
            let perPage = 10;
            let filteredRows = [...allRows];

            // Format angka ke format mata uang Rupiah
            function formatRupiah(amount) {
                return 'Rp ' + Number(amount || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
            }

            // Format tanggal (YYYY-MM-DD -> DD/MM/YYYY)
            function formatDate(str) {
                if (!str || str === '0000-00-00' || str === '0000-00-00 00:00:00') return '-';
                const datePart = str.split(' ')[0];
                const parts = datePart.split('-');
                if (parts.length === 3) {
                    return parts[2] + '/' + parts[1] + '/' + parts[0];
                }
                return str;
            }

            // Fungsi membuka dan mengisi data Modal Detail RUP
            function openPlanDetail(data) {
                if (!data) return;
                try {
                    const p = typeof data === 'string' ? JSON.parse(data) : data;
                    if (!p) return;

                    const codeEl = document.getElementById('modalPlanCode');
                    if (codeEl) codeEl.textContent = p.package_code || ('DRAFT-' + p.id);

                    const pkgName = String(p.package_name || '-').trim();
                    const actName = String(p.activity || '').trim();
                    const nameEl = document.getElementById('modalPlanName');
                    if (nameEl) nameEl.textContent = pkgName;

                    const actEl = document.getElementById('modalPlanActivity');
                    if (actEl) actEl.textContent = actName || '-';

                    const actWrap = document.getElementById('modalPlanActivityWrap');
                    if (actWrap) {
                        const isRedundant = !actName || actName === '-' || actName.toLowerCase() === pkgName.toLowerCase();
                        if (isRedundant) {
                            actWrap.classList.add('d-none');
                        } else {
                            actWrap.classList.remove('d-none');
                        }
                    }

                    const skpdEl = document.getElementById('modalPlanSkpd');
                    if (skpdEl) {
                        const skpdName = p.skpd_name || '-';
                        const skpdAbbr = p.skpd_abbreviation ? `[${p.skpd_abbreviation}] ` : '';
                        skpdEl.textContent = skpdAbbr + skpdName;
                    }

                    const officerEl = document.getElementById('modalPlanOfficer');
                    if (officerEl) officerEl.textContent = p.ppk_name || '-';

                    const locEl = document.getElementById('modalPlanLocation');
                    if (locEl) locEl.textContent = p.location || '-';

                    const volEl = document.getElementById('modalPlanVolume');
                    if (volEl) volEl.textContent = p.volume || '1 Paket';

                    const budgetEl = document.getElementById('modalPlanBudget');
                    if (budgetEl) budgetEl.textContent = formatRupiah(p.budget_ceiling || 0);

                    const makEl = document.getElementById('modalPlanMak');
                    if (makEl) makEl.textContent = p.account_code || '-';

                    const fundEl = document.getElementById('modalPlanFunding');
                    if (fundEl) fundEl.textContent = p.sumber_dana_name || '-';

                    const dakEl = document.getElementById('modalPlanDak');
                    if (dakEl) dakEl.textContent = p.jenis_dak_name || 'NON DAK';

                    const jbEl = document.getElementById('modalPlanJenisBelanja');
                    if (jbEl) jbEl.textContent = p.jenis_belanja_name || '-';

                    const procEl = document.getElementById('modalPlanProcType');
                    if (procEl) procEl.textContent = p.jenis_pengadaan_name || '-';

                    const methodEl = document.getElementById('modalPlanMethod');
                    if (methodEl) methodEl.textContent = p.metode_pemilihan_name || '-';

                    const durEl = document.getElementById('modalPlanDuration');
                    if (durEl) durEl.textContent = (p.work_duration || 0) + ' Hari Kalender';

                    const dateEl = document.getElementById('modalPlanDate');
                    if (dateEl) dateEl.textContent = formatDate(p.submission_date);

                    const yearEl = document.getElementById('modalPlanYear');
                    if (yearEl) yearEl.textContent = p.fiscal_year || '2026';

                    const descEl = document.getElementById('modalPlanDescription');
                    if (descEl) descEl.textContent = p.description || 'Tidak ada keterangan uraian spesifik.';

                    const notesEl = document.getElementById('modalPlanNotes');
                    if (notesEl) notesEl.textContent = p.notes || '-';

                    const modalElement = document.getElementById('detailPlanModal');
                    if (modalElement) {
                        const detailModal = bootstrap.Modal.getOrCreateInstance(modalElement);
                        detailModal.show();
                    }
                } catch (e) {
                    console.error('Error parsing plan detail:', e);
                }
            }

            // Global handler untuk cetak detail RUP
            window.printRupDetail = function () {
                window.print();
            };

            // Event Delegation untuk membuka modal detail RUP (klik tombol aksi, link kode, atau link judul)
            document.addEventListener('click', function (e) {
                const trigger = e.target.closest('.btn-view-plan');
                if (!trigger) return;
                e.preventDefault();

                const rawData = trigger.getAttribute('data-plan');
                if (rawData) {
                    openPlanDetail(rawData);
                }
            });

            // Fungsi filter dan search
            function applyFilter() {
                const searchVal = (searchInput ? searchInput.value : '').toLowerCase().trim();
                const procTypeVal = procTypeFilter ? procTypeFilter.value : '';
                const methodVal = methodFilter ? methodFilter.value : '';
                const rupStatusVal = rupStatusFilter ? rupStatusFilter.value : '';
                const dakVal = dakFilter ? dakFilter.value : '';

                filteredRows = allRows.filter(function (row) {
                    const code = row.getAttribute('data-code') || '';
                    const name = row.getAttribute('data-name') || '';
                    const act = row.getAttribute('data-activity') || '';
                    const ag = row.getAttribute('data-skpd') || '';
                    const mak = row.getAttribute('data-mak') || '';
                    const procType = row.getAttribute('data-proc-type') || '';
                    const method = row.getAttribute('data-method') || '';
                    const rupStatus = row.getAttribute('data-rup-status') || '';
                    const dak = row.getAttribute('data-dak') || '';

                    const matchesSearch = !searchVal ||
                        code.includes(searchVal) ||
                        name.includes(searchVal) ||
                        act.includes(searchVal) ||
                        ag.includes(searchVal) ||
                        mak.includes(searchVal);

                    const matchesProcType = !procTypeVal || procType === procTypeVal;
                    const matchesMethod = !methodVal || method === methodVal;
                    const matchesRupStatus = !rupStatusVal || String(rupStatus) === String(rupStatusVal);
                    const matchesDak = !dakVal || dak === dakVal;

                    return matchesSearch && matchesProcType && matchesMethod && matchesRupStatus && matchesDak;
                });

                currentPage = 1;
                renderPage();
            }

            // Render baris sesuai halaman pagination
            function renderPage() {
                const totalFiltered = filteredRows.length;
                allRows.forEach(row => row.style.display = 'none');

                if (totalFiltered === 0) {
                    if (noResultsRow) noResultsRow.style.display = '';
                    if (paginationInfo) paginationInfo.textContent = 'Menampilkan 0 dari 0 paket';
                    if (paginationControls) paginationControls.innerHTML = '';
                    return;
                }

                if (noResultsRow) noResultsRow.style.display = 'none';

                let startIndex = 0;
                let endIndex = totalFiltered;

                if (perPage !== 'all') {
                    const pSize = parseInt(perPage, 10);
                    const totalPages = Math.ceil(totalFiltered / pSize);
                    if (currentPage > totalPages) currentPage = totalPages;
                    if (currentPage < 1) currentPage = 1;

                    startIndex = (currentPage - 1) * pSize;
                    endIndex = Math.min(startIndex + pSize, totalFiltered);

                    renderPaginationControls(totalPages);
                } else {
                    if (paginationControls) paginationControls.innerHTML = '';
                }

                for (let i = startIndex; i < endIndex; i++) {
                    if (filteredRows[i]) {
                        filteredRows[i].style.display = '';
                    }
                }

                if (paginationInfo) {
                    paginationInfo.textContent = `Menampilkan ${startIndex + 1} sampai ${endIndex} dari ${totalFiltered} paket RUP`;
                }
            }

            function renderPaginationControls(totalPages) {
                if (!paginationControls) return;
                paginationControls.innerHTML = '';

                if (totalPages <= 1) return;

                // Tombol Prev
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `<a class="page-link" href="javascript:void(0);" aria-label="Previous">&laquo;</a>`;
                prevLi.addEventListener('click', function () {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                    }
                });
                paginationControls.appendChild(prevLi);

                // Tombol Nomor Halaman
                for (let i = 1; i <= totalPages; i++) {
                    const pageLi = document.createElement('li');
                    pageLi.className = `page-item ${currentPage === i ? 'active' : ''}`;
                    pageLi.innerHTML = `<a class="page-link" href="javascript:void(0);">${i}</a>`;
                    pageLi.addEventListener('click', (function (p) {
                        return function () {
                            currentPage = p;
                            renderPage();
                        };
                    })(i));
                    paginationControls.appendChild(pageLi);
                }

                // Tombol Next
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                nextLi.innerHTML = `<a class="page-link" href="javascript:void(0);" aria-label="Next">&raquo;</a>`;
                nextLi.addEventListener('click', function () {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                    }
                });
                paginationControls.appendChild(nextLi);
            }

            // Pasang event listener
            if (searchInput) searchInput.addEventListener('input', applyFilter);
            if (procTypeFilter) procTypeFilter.addEventListener('change', applyFilter);
            if (methodFilter) methodFilter.addEventListener('change', applyFilter);
            if (rupStatusFilter) rupStatusFilter.addEventListener('change', applyFilter);
            if (dakFilter) dakFilter.addEventListener('change', applyFilter);

            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    perPage = this.value;
                    currentPage = 1;
                    renderPage();
                });
            }

            // Inisialisasi awal
            renderPage();

            // Helper normalisasi teks untuk pencocokan dropdown master data (Jenis Pengadaan / Metode Pemilihan)
            function normalizeLabel(str) {
                return String(str || '')
                    .toLowerCase()
                    .replace(/konsultansi/g, 'konsultasi')
                    .replace(/[^a-z0-9]/g, '');
            }

            function selectOptionByText(selectEl, targetText) {
                if (!selectEl || !targetText) return false;
                const normTarget = normalizeLabel(targetText);
                if (!normTarget) return false;

                const options = Array.from(selectEl.options);
                for (const opt of options) {
                    if (!opt.value) continue;
                    if (normalizeLabel(opt.textContent) === normTarget) {
                        selectEl.value = opt.value;
                        return true;
                    }
                }
                for (const opt of options) {
                    if (!opt.value) continue;
                    const normOpt = normalizeLabel(opt.textContent);
                    if (normOpt.includes(normTarget) || normTarget.includes(normOpt)) {
                        selectEl.value = opt.value;
                        return true;
                    }
                }
                return false;
            }

            // Format tanggal ISO (YYYY-MM-DDTHH:mm:ssZ -> DD/MM/YYYY)
            function formatIsoDate(isoStr) {
                if (!isoStr) return '-';
                const clean = String(isoStr).split('T')[0];
                return formatDate(clean);
            }

            // Tarik data RUP dari API INAPROC Kab. Kotabaru: https://data-inaproc.kotabarukab.go.id/api/rup/[kode_rup]
            const addPlanForm = document.getElementById('addPlanForm');
            const btnFetchInaproc = document.getElementById('btnFetchInaproc');
            const codeInputInaproc = document.getElementById('addPlanPackageCode');
            const inaprocPreviewBox = document.getElementById('inaprocApiPreview');
            const isSyncedInput = document.getElementById('addPlanIsSynced');

            async function fetchRupFromInaproc() {
                if (!addPlanForm || !codeInputInaproc || !btnFetchInaproc) return;

                const alertBox = document.getElementById('addPlanAlertContainer');
                const rawCode = codeInputInaproc.value.trim();
                const cleanCode = rawCode.replace(/[^A-Za-z0-9_-]/g, '');

                if (!cleanCode) {
                    alertBox.className = 'alert alert-warning d-flex align-items-center gap-2 mb-3 py-2 px-3';
                    alertBox.innerHTML = '<i class="fal fa-info-circle fs-5 flex-shrink-0"></i> <div class="fs-xs">Silakan masukkan <strong>Kode RUP / Kode SiRUP</strong> terlebih dahulu (contoh: <code>62421910</code>).</div>';
                    codeInputInaproc.focus();
                    return;
                }

                const originalBtnHtml = btnFetchInaproc.innerHTML;
                btnFetchInaproc.disabled = true;
                btnFetchInaproc.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menarik API...';
                alertBox.className = 'd-none mb-3';
                alertBox.innerHTML = '';

                const directApiUrl = `https://data-inaproc.kotabarukab.go.id/api/rup/${encodeURIComponent(cleanCode)}`;
                const proxyApiUrl = `/rup/inaproc/${encodeURIComponent(cleanCode)}`;

                let payload = null;

                try {
                    // Coba panggil API INAPROC secara langsung, fallback ke endpoint proxy backend jika terkendala jaringan/CORS
                    let response;
                    try {
                        response = await fetch(directApiUrl, {
                            method: 'GET',
                            headers: { 'Accept': 'application/json' }
                        });
                    } catch (directErr) {
                        response = await fetch(proxyApiUrl, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                    }

                    payload = await response.json();

                    if (response.ok && payload && payload.status === 'success' && payload.data) {
                        const d = payload.data;

                        // 1. Kode RUP & Tahun Anggaran
                        codeInputInaproc.value = d.kd_rup || cleanCode;
                        const fiscalYearInput = addPlanForm.querySelector('input[name="fiscal_year"]');
                        if (fiscalYearInput) {
                            fiscalYearInput.value = d.tahun_anggaran || new Date().getFullYear();
                        }

                        // 2. Nama Paket & Nama Kegiatan / Program (selalu timpa nilai lama saat tarik ulang)
                        const packageNameInput = addPlanForm.querySelector('input[name="package_name"]');
                        if (packageNameInput) {
                            packageNameInput.value = String(d.nama_paket || '').trim();
                        }

                        const activityInput = addPlanForm.querySelector('input[name="activity"]');
                        if (activityInput) {
                            const apiActivity = d.nama_kegiatan || d.kegiatan || d.program || d.nama_paket || '';
                            activityInput.value = String(apiActivity).trim();
                        }

                        // 3. Jenis Pengadaan & Metode Pemilihan
                        const procTypeSelect = addPlanForm.querySelector('select[name="jenis_pengadaan_id"]');
                        if (procTypeSelect) {
                            if (!d.jenis_pengadaan || !selectOptionByText(procTypeSelect, d.jenis_pengadaan)) {
                                selectOptionByText(procTypeSelect, 'Pekerjaan Konstruksi');
                            }
                            procTypeSelect.dispatchEvent(new Event('change'));
                        }

                        const methodSelect = addPlanForm.querySelector('select[name="metode_pemilihan_id"]');
                        if (methodSelect) {
                            if (!d.metode_pengadaan || !selectOptionByText(methodSelect, d.metode_pengadaan)) {
                                selectOptionByText(methodSelect, 'Tender');
                            }
                            methodSelect.dispatchEvent(new Event('change'));
                        }

                        // 4. Pagu Anggaran & Mata Anggaran Kegiatan (MAK)
                        const budgetInput = addPlanForm.querySelector('input[name="budget_ceiling"]');
                        if (budgetInput) {
                            budgetInput.value = (d.pagu !== undefined && d.pagu !== null) ? (Number(d.pagu) || 0) : '';
                        }

                        const makInput = addPlanForm.querySelector('input[name="account_code"]');
                        if (makInput) {
                            makInput.value = String(d.mak || d.kode_mak || d.kd_mak || d.account_code || '').trim();
                        }

                        // 4b. Sumber Dana & Status DAK
                        const sumberDanaSelect = addPlanForm.querySelector('select[name="sumber_dana_id"]');
                        if (sumberDanaSelect) {
                            const apiSumber = d.sumber_dana || d.asal_dana || 'APBD';
                            if (!selectOptionByText(sumberDanaSelect, apiSumber)) {
                                selectOptionByText(sumberDanaSelect, 'APBD');
                            }
                        }

                        const jenisDakSelect = addPlanForm.querySelector('select[name="jenis_dak_id"]');
                        if (jenisDakSelect) {
                            const apiDak = d.jenis_dak || 'NON DAK';
                            if (!selectOptionByText(jenisDakSelect, apiDak)) {
                                selectOptionByText(jenisDakSelect, 'NON DAK');
                            }
                        }

                        // 5. Volume Pekerjaan (selalu timpa/reset nilai lama)
                        const volumeInput = addPlanForm.querySelector('input[name="volume"]');
                        if (volumeInput) {
                            volumeInput.value = d.volume_pekerjaan ? String(d.volume_pekerjaan).trim() : '1 Paket';
                        }

                        // 6. Waktu Pekerjaan (Hari Kalender dari tgl_awal_kontrak s/d tgl_akhir_kontrak; reset dahulu)
                        const durationInput = addPlanForm.querySelector('input[name="work_duration"]');
                        if (durationInput) {
                            durationInput.value = '';
                            if (d.tgl_awal_kontrak && d.tgl_akhir_kontrak) {
                                const startDt = new Date(d.tgl_awal_kontrak);
                                const endDt = new Date(d.tgl_akhir_kontrak);
                                if (!isNaN(startDt.getTime()) && !isNaN(endDt.getTime())) {
                                    const diffDays = Math.round((endDt.getTime() - startDt.getTime()) / (1000 * 60 * 60 * 24));
                                    if (diffDays > 0) {
                                        durationInput.value = diffDays;
                                    } else if (diffDays === 0) {
                                        durationInput.value = 1;
                                    }
                                }
                            }
                        }

                        // 7. Lokasi Pekerjaan (selalu timpa nilai lama)
                        const locationInput = addPlanForm.querySelector('input[name="location"]');
                        if (locationInput) {
                            const locVal = d.lokasi_pekerjaan || d.detail_lokasi || d.nama_klpd || '';
                            locationInput.value = String(locVal).trim();
                        }

                        // 8. Uraian / Deskripsi Pekerjaan (selalu timpa nilai lama, termasuk jika kosong pada kode baru)
                        const descInput = addPlanForm.querySelector('textarea[name="description"]');
                        if (descInput) {
                            let descVal = d.urarian_pekerjaan || d.uraian_pekerjaan || '';
                            if (!descVal && d.spesifikasi_pekerjaan && d.spesifikasi_pekerjaan !== '-') {
                                descVal = d.spesifikasi_pekerjaan;
                            }
                            descInput.value = String(descVal || '').trim();
                        }

                        // 9. Tandai status tersinkronisasi SiRUP
                        if (isSyncedInput) isSyncedInput.value = '1';

                        // 10. Tampilkan kartu preview metadata INAPROC
                        if (inaprocPreviewBox) {
                            const satkerEl = document.getElementById('inaprocPreviewSatker');
                            const ppkEl = document.getElementById('inaprocPreviewPpk');
                            const kontrakEl = document.getElementById('inaprocPreviewKontrak');
                            const badgesEl = document.getElementById('inaprocPreviewBadges');

                            if (satkerEl) {
                                const satkerCode = d.kd_satker_str ? ` (${d.kd_satker_str})` : '';
                                satkerEl.textContent = (d.nama_satker || '-') + satkerCode;
                            }
                            if (ppkEl) {
                                ppkEl.textContent = d.nama_ppk || '-';
                            }
                            if (kontrakEl) {
                                kontrakEl.textContent = `${formatIsoDate(d.tgl_awal_kontrak)} - ${formatIsoDate(d.tgl_akhir_kontrak)}`;
                            }
                            if (badgesEl) {
                                const badges = [];
                                if (d.tipe_paket) badges.push(`<span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-nano">${d.tipe_paket}</span>`);
                                if (d.status_umumkan_rup) badges.push(`<span class="badge bg-success-subtle text-success border border-success-subtle fs-nano">${d.status_umumkan_rup}</span>`);
                                if (d.status_pdn) badges.push(`<span class="badge bg-info-subtle text-info-emphasis border border-info-subtle fs-nano">${d.status_pdn}</span>`);
                                if (d.status_ukm) badges.push(`<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fs-nano">${d.status_ukm}</span>`);
                                badgesEl.innerHTML = badges.join('');
                            }
                            inaprocPreviewBox.classList.remove('d-none');
                        }

                        alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3 py-2 px-3';
                        alertBox.innerHTML = `<i class="fal fa-check-circle fs-5 flex-shrink-0"></i> <div class="fs-xs">Data RUP <strong>#${d.kd_rup || cleanCode}</strong> (<em>${d.nama_paket || '-'}</em>) berhasil ditarik dari API INAPROC. Silakan periksa kembali sebelum menyimpan.</div>`;
                    } else {
                        if (isSyncedInput) isSyncedInput.value = '0';
                        if (inaprocPreviewBox) inaprocPreviewBox.classList.add('d-none');
                        alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3 py-2 px-3';
                        alertBox.innerHTML = `<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div class="fs-xs">${(payload && payload.message) ? payload.message : `Data RUP dengan kode <strong>${cleanCode}</strong> tidak ditemukan pada API INAPROC.`}</div>`;
                    }
                } catch (err) {
                    console.error('Error fetching INAPROC API:', err);
                    if (isSyncedInput) isSyncedInput.value = '0';
                    if (inaprocPreviewBox) inaprocPreviewBox.classList.add('d-none');
                    alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3 py-2 px-3';
                    alertBox.innerHTML = '<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div class="fs-xs">Gagal menghubungi layanan API INAPROC. Periksa koneksi atau coba beberapa saat lagi.</div>';
                } finally {
                    btnFetchInaproc.disabled = false;
                    btnFetchInaproc.innerHTML = originalBtnHtml;
                }
            }

            if (btnFetchInaproc) {
                btnFetchInaproc.addEventListener('click', fetchRupFromInaproc);
            }

            if (codeInputInaproc) {
                codeInputInaproc.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        fetchRupFromInaproc();
                    }
                });
            }

            // AJAX Handler Form Tambah Paket RUP Baru
            if (addPlanForm) {
                addPlanForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('addPlanSubmitBtn');
                    const originalBtnHtml = submitBtn.innerHTML;
                    const alertBox = document.getElementById('addPlanAlertContainer');

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...';
                    alertBox.className = 'd-none mb-3';
                    alertBox.innerHTML = '';

                    const formData = new FormData(addPlanForm);

                    fetch('/rup/store', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json().then(data => ({ ok: response.ok, status: response.status, body: data })))
                    .then(({ ok, body }) => {
                        if (ok && body.status === 'success') {
                            alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-check-circle fs-5 flex-shrink-0"></i> <div>${body.message || 'Paket Rencana Pengadaan (RUP) berhasil ditambahkan!'}</div>`;

                            // Tutup modal dan reload halaman
                            setTimeout(() => {
                                window.location.reload();
                            }, 700);
                        } else {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnHtml;
                            alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div>${body.message || 'Terjadi kesalahan saat menyimpan paket RUP.'}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error adding plan:', error);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                        alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                        alertBox.innerHTML = '<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div>Gagal menghubungi server. Silakan coba beberapa saat lagi.</div>';
                    });
                });
            }

            // Handler Buka Modal Ubah Paket RUP (.btn-edit-plan)
            const editPlanForm = document.getElementById('editPlanForm');
            document.addEventListener('click', function (e) {
                const editBtn = e.target.closest('.btn-edit-plan');
                if (!editBtn) return;
                e.preventDefault();

                const rawData = editBtn.getAttribute('data-plan');
                if (!rawData) return;

                try {
                    const p = JSON.parse(rawData);
                    if (parseInt(p.rup_status, 10) !== 1 || p.paket_id) return;

                    document.getElementById('editPlanId').value = p.id || '';
                    document.getElementById('editPlanFiscalYear').value = p.fiscal_year || new Date().getFullYear();
                    document.getElementById('editPlanPackageCode').value = p.package_code || '';
                    document.getElementById('editPlanActivity').value = p.activity || '';
                    document.getElementById('editPlanPackageName').value = p.package_name || '';
                    document.getElementById('editPlanJenisPengadaan').value = p.jenis_pengadaan_id || '';
                    document.getElementById('editPlanMetodePemilihan').value = p.metode_pemilihan_id || '';
                    document.getElementById('editPlanBudget').value = p.budget_ceiling || 0;
                    document.getElementById('editPlanMak').value = p.account_code || '';
                    document.getElementById('editPlanSumberDana').value = p.sumber_dana_id || '';
                    document.getElementById('editPlanJenisDak').value = p.jenis_dak_id || 2;
                    document.getElementById('editPlanDuration').value = p.work_duration || 0;
                    document.getElementById('editPlanVolume').value = p.volume || '1 Paket';
                    document.getElementById('editPlanLocation').value = p.location || '';
                    document.getElementById('editPlanDescription').value = p.description || '';

                    const alertBox = document.getElementById('editPlanAlertContainer');
                    if (alertBox) {
                        alertBox.className = 'd-none mb-3';
                        alertBox.innerHTML = '';
                    }

                    const modalEl = document.getElementById('editPlanModal');
                    if (modalEl) {
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    }
                } catch (err) {
                    console.error('Error opening edit plan modal:', err);
                }
            });

            if (editPlanForm) {
                editPlanForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const planId = document.getElementById('editPlanId').value;
                    if (!planId) return;

                    const submitBtn = document.getElementById('editPlanSubmitBtn');
                    const originalBtnHtml = submitBtn.innerHTML;
                    const alertBox = document.getElementById('editPlanAlertContainer');

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...';
                    alertBox.className = 'd-none mb-3';
                    alertBox.innerHTML = '';

                    const formData = new FormData(editPlanForm);

                    fetch(`/rup/update/${encodeURIComponent(planId)}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json().then(data => ({ ok: response.ok, body: data })))
                    .then(({ ok, body }) => {
                        if (ok && body.status === 'success') {
                            alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-check-circle fs-5 flex-shrink-0"></i> <div>${body.message || 'Paket RUP berhasil diperbarui!'}</div>`;
                            setTimeout(() => { window.location.reload(); }, 600);
                        } else {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnHtml;
                            alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div>${body.message || 'Gagal memperbarui paket RUP.'}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error updating plan:', error);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                        alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                        alertBox.innerHTML = '<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div>Gagal menghubungi server.</div>';
                    });
                });
            }

            // Handler Buka Modal Hapus Paket RUP (.btn-delete-plan)
            let activeDeletePlanId = null;
            document.addEventListener('click', function (e) {
                const delBtn = e.target.closest('.btn-delete-plan');
                if (!delBtn) return;
                e.preventDefault();

                const rawData = delBtn.getAttribute('data-plan');
                if (!rawData) return;

                try {
                    const p = JSON.parse(rawData);
                    if (parseInt(p.rup_status, 10) !== 1 || p.paket_id) return;

                    activeDeletePlanId = p.id;
                    document.getElementById('deletePlanCodeInfo').textContent = p.package_code || ('DRAFT-' + p.id);
                    document.getElementById('deletePlanNameInfo').textContent = p.package_name || '-';

                    const alertBox = document.getElementById('deletePlanAlertContainer');
                    if (alertBox) {
                        alertBox.className = 'd-none mb-3';
                        alertBox.innerHTML = '';
                    }

                    const modalEl = document.getElementById('deletePlanModal');
                    if (modalEl) {
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    }
                } catch (err) {
                    console.error('Error opening delete plan modal:', err);
                }
            });

            const confirmDeletePlanBtn = document.getElementById('confirmDeletePlanBtn');
            if (confirmDeletePlanBtn) {
                confirmDeletePlanBtn.addEventListener('click', function () {
                    if (!activeDeletePlanId) return;

                    const originalBtnHtml = confirmDeletePlanBtn.innerHTML;
                    const alertBox = document.getElementById('deletePlanAlertContainer');

                    confirmDeletePlanBtn.disabled = true;
                    confirmDeletePlanBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menghapus...';
                    alertBox.className = 'd-none mb-3';
                    alertBox.innerHTML = '';

                    const formData = new FormData();
                    const csrfInput = document.querySelector('#addPlanForm input[type="hidden"]');
                    if (csrfInput) {
                        formData.append(csrfInput.name, csrfInput.value);
                    }

                    fetch(`/rup/delete/${encodeURIComponent(activeDeletePlanId)}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json().then(data => ({ ok: response.ok, body: data })))
                    .then(({ ok, body }) => {
                        if (ok && body.status === 'success') {
                            alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-check-circle fs-5 flex-shrink-0"></i> <div>${body.message || 'Paket RUP berhasil dihapus!'}</div>`;
                            setTimeout(() => { window.location.reload(); }, 600);
                        } else {
                            confirmDeletePlanBtn.disabled = false;
                            confirmDeletePlanBtn.innerHTML = originalBtnHtml;
                            alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div>${body.message || 'Gagal menghapus paket RUP.'}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting plan:', error);
                        confirmDeletePlanBtn.disabled = false;
                        confirmDeletePlanBtn.innerHTML = originalBtnHtml;
                        alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                        alertBox.innerHTML = '<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div>Gagal menghubungi server.</div>';
                    });
                });
            }
        });
    </script>

</body>

</html>
