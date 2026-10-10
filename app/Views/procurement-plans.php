<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Daftar Paket RUP - Procurement Plans")) ?>

    <?= $this->include('partials/app-head-css') ?>

    <!-- Select2 CSS & Bootstrap 5 Theme via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <style>
        .badge-dak {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }
        .badge-non-dak {
            background-color: #f1f5f9;
            color: #475569;
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
            color: #64748b;
        }
        .detail-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 2px;
        }
        .detail-value {
            font-size: 0.9rem;
            color: #1e293b;
            font-weight: 500;
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
                    $agencies         = $agencies ?? [];
                    $officers         = $officers ?? [];
                    $expenseTypes     = $expenseTypes ?? [];
                    $procurementTypes = $procurementTypes ?? [];
                    $fundingSources   = $fundingSources ?? [];
                    $selectionMethods = $selectionMethods ?? [];
                    $allocationTypes  = $allocationTypes ?? [];

                    $totalPlans       = $totalPlans ?? count($plans);
                    $totalBudget      = $totalBudget ?? array_sum(array_column($plans, 'budget_ceiling'));
                    $announcedCount   = $announcedCount ?? count(array_filter($plans, fn($p) => (int)($p['rup_status'] ?? 0) === 1));
                    $syncedCount      = $syncedCount ?? count(array_filter($plans, fn($p) => (int)($p['is_synced'] ?? 0) === 1));
                    $dakCount         = $dakCount ?? count(array_filter($plans, fn($p) => (int)($p['special_allocation_type_id'] ?? 2) === 1));

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
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#file-text"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total Paket RUP</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $totalPlans ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-muted">Tahun Anggaran <?= date('Y') ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Total Pagu Anggaran -->
                            <div class="col-sm-6 col-xl-3">
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

                            <!-- Card 3: Terumumkan di SiRUP -->
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#check-circle"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Terumumkan SiRUP</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $announcedCount ?> <span class="fs-sm fw-normal text-muted">/ <?= $totalPlans ?></span></div>
                                            <div class="fs-xs text-info">
                                                <?= $totalPlans > 0 ? round(($announcedCount / $totalPlans) * 100, 1) : 0 ?>% paket terumumkan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4: Alokasi DAK vs Sinkronisasi -->
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#refresh-cw"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Tersinkron SiRUP</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $syncedCount ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-muted"><?= $dakCount ?> paket sumber DAK</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel Tabel Utama Procurement Plans -->
                        <div id="panel-procurement-plans" class="panel">
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
                                        <span>Tambah Paket RUP</span>
                                    </button>
                                </div>
                            </div>

                            <div class="panel-container show">
                                <div class="panel-content">

                                    <!-- Filter Toolbar Komprehensif -->
                                    <div class="row g-2 mb-3 align-items-center">
                                        <!-- Search Box -->
                                        <div class="col-md-4 col-lg-3">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-white">
                                                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                        <use href="/icons/sprite.svg#search"></use>
                                                    </svg>
                                                </span>
                                                <input type="text" id="planSearchInput" class="form-control" placeholder="Cari paket, kode RUP, SKPD, MAK...">
                                            </div>
                                        </div>

                                        <!-- Filter Jenis Pengadaan -->
                                        <div class="col-6 col-md-2 col-lg-2">
                                            <select id="procTypeFilter" class="form-select form-select-sm">
                                                <option value="">Semua Jenis Pengadaan</option>
                                                <option value="Barang">Barang</option>
                                                <option value="Pekerjaan Konstruksi">Pekerjaan Konstruksi</option>
                                                <option value="Jasa Konsultansi">Jasa Konsultansi</option>
                                                <option value="Jasa Lainnya">Jasa Lainnya</option>
                                            </select>
                                        </div>

                                        <!-- Filter Metode Pemilihan -->
                                        <div class="col-6 col-md-2 col-lg-2">
                                            <select id="methodFilter" class="form-select form-select-sm">
                                                <option value="">Semua Metode</option>
                                                <option value="E-purchasing">E-Purchasing</option>
                                                <option value="Tender">Tender</option>
                                                <option value="Pengadaan Langsung">Pengadaan Langsung</option>
                                                <option value="Seleksi">Seleksi</option>
                                                <option value="Penunjukan Langsung">Penunjukan Langsung</option>
                                            </select>
                                        </div>

                                        <!-- Filter Status RUP -->
                                        <div class="col-6 col-md-2 col-lg-2">
                                            <select id="rupStatusFilter" class="form-select form-select-sm">
                                                <option value="">Semua Status RUP</option>
                                                <option value="1">Terumumkan</option>
                                                <option value="0">Draf</option>
                                            </select>
                                        </div>

                                        <!-- Filter Sumber Dana / DAK -->
                                        <div class="col-6 col-md-2 col-lg-1">
                                            <select id="dakFilter" class="form-select form-select-sm">
                                                <option value="">Semua DAK</option>
                                                <option value="DAK">DAK</option>
                                                <option value="NON DAK">NON DAK</option>
                                            </select>
                                        </div>

                                        <!-- Per Page Selector -->
                                        <div class="col-12 col-md-12 col-lg-2 ms-auto">
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
                                                    <th style="min-width: 180px;">Instansi & PPK</th>
                                                    <th style="min-width: 150px;">Jenis & Metode</th>
                                                    <th class="text-end" style="min-width: 160px;">Pagu Anggaran</th>
                                                    <th class="text-center" style="min-width: 90px;">Waktu</th>
                                                    <th class="text-center" style="min-width: 110px;">Status RUP</th>
                                                    <th class="text-end" style="width: 75px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($plans as $p): ?>
                                                    <?php
                                                    $planJson = htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8');
                                                    $isAnnounced = (int) ($p['rup_status'] ?? 0) === 1;
                                                    $isSynced = (int) ($p['is_synced'] ?? 0) === 1;
                                                    $isDak = ($p['special_allocation_type_name'] ?? '') === 'DAK';
                                                    ?>
                                                    <tr class="plan-row"
                                                        data-id="<?= $p['id'] ?>"
                                                        data-code="<?= esc(strtolower($p['package_code'] ?? '')) ?>"
                                                        data-name="<?= esc(strtolower($p['package_name'] ?? '')) ?>"
                                                        data-activity="<?= esc(strtolower($p['activity'] ?? '')) ?>"
                                                        data-agency="<?= esc(strtolower(($p['agency_abbreviation'] ?? '') . ' ' . ($p['agency_name'] ?? ''))) ?>"
                                                        data-mak="<?= esc(strtolower($p['account_code'] ?? '')) ?>"
                                                        data-proc-type="<?= esc($p['procurement_type_name'] ?? '') ?>"
                                                        data-method="<?= esc($p['selection_method_name'] ?? '') ?>"
                                                        data-rup-status="<?= (int) ($p['rup_status'] ?? 0) ?>"
                                                        data-dak="<?= esc($p['special_allocation_type_name'] ?? 'NON DAK') ?>"
                                                        data-year="<?= esc($p['fiscal_year'] ?? '') ?>">
                                                        
                                                        <td class="text-muted fs-xs"><?= $p['id'] ?></td>
                                                        
                                                        <!-- Kode RUP & Tahun Anggaran -->
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                                <span class="font-monospace fw-semibold text-primary fs-xs">
                                                                    <?= esc($p['package_code'] ?: 'DRAFT-' . $p['id']) ?>
                                                                </span>
                                                                <?php if ($isSynced): ?>
                                                                    <span class="badge bg-success-subtle text-success p-1 rounded-circle" title="Tersinkronisasi SiRUP LKPP">
                                                                        <svg class="sa-icon" style="width: 10px; height: 10px;">
                                                                            <use href="/icons/sprite.svg#check"></use>
                                                                        </svg>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="rup-meta-tag">
                                                                <span class="badge bg-light text-secondary border">TA <?= esc($p['fiscal_year']) ?></span>
                                                                <span class="badge <?= $isDak ? 'badge-dak' : 'badge-non-dak' ?>">
                                                                    <?= esc($p['special_allocation_type_name'] ?? 'NON DAK') ?>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <!-- Nama Paket & Program/Kegiatan -->
                                                        <td class="plan-title-cell">
                                                            <div class="fw-semibold text-dark mb-1 text-break" style="line-height: 1.35;">
                                                                <?= esc($p['package_name']) ?>
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

                                                        <!-- Instansi / SKPD & PPK -->
                                                        <td>
                                                            <div>
                                                                <?php if (!empty($p['agency_abbreviation'])): ?>
                                                                    <span class="badge bg-secondary-subtle text-dark border border-secondary-subtle me-1 mb-1">
                                                                        <?= esc($p['agency_abbreviation']) ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                                <span class="fs-xs text-dark fw-medium d-block" title="<?= esc($p['agency_name']) ?>">
                                                                    <?= esc($p['agency_name']) ?>
                                                                </span>
                                                            </div>
                                                            <div class="fs-nano text-muted mt-1">
                                                                <svg class="sa-icon me-1 text-muted" style="width: 10px; height: 10px;">
                                                                    <use href="/icons/sprite.svg#user"></use>
                                                                </svg>
                                                                <?= esc($p['commitment_officer_name'] ?? 'Belum ditentukan') ?>
                                                            </div>
                                                        </td>

                                                        <!-- Jenis & Metode Pemilihan -->
                                                        <td>
                                                            <div class="mb-1">
                                                                <span class="badge <?= $p['proc_badge'] ?? 'bg-light text-dark border' ?>">
                                                                    <?= esc($p['procurement_type_name'] ?? 'Barang') ?>
                                                                </span>
                                                            </div>
                                                            <div class="fs-xs text-secondary">
                                                                <?= esc($p['selection_method_name'] ?? '-') ?>
                                                            </div>
                                                        </td>

                                                        <!-- Pagu Anggaran & Sumber Dana -->
                                                        <td class="text-end">
                                                            <div class="fw-bold text-dark font-monospace fs-sm">
                                                                Rp <?= number_format((float) $p['budget_ceiling'], 0, ',', '.') ?>
                                                            </div>
                                                            <div class="fs-nano text-muted">
                                                                <?= esc($p['funding_source_name'] ?? 'APBD') ?> &bull; <?= esc($p['expense_type_name'] ?? 'Modal') ?>
                                                            </div>
                                                            <?php if (!empty($p['account_code'])): ?>
                                                                <div class="font-monospace fs-nano text-muted text-truncate" title="MAK: <?= esc($p['account_code']) ?>">
                                                                    <?= esc($p['account_code']) ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Waktu / Durasi -->
                                                        <td class="text-center">
                                                            <div class="badge bg-light text-dark border font-monospace">
                                                                <?= (int) $p['work_duration'] ?> Hari
                                                            </div>
                                                            <?php if (!empty($p['volume'])): ?>
                                                                <div class="fs-nano text-muted mt-1 text-truncate" title="<?= esc($p['volume']) ?>">
                                                                    <?= esc($p['volume']) ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Status RUP & Status Paket -->
                                                        <td class="text-center">
                                                            <div class="mb-1">
                                                                <?php if ($isAnnounced): ?>
                                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                                        Terumumkan
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                                        Draf
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div>
                                                                <span class="badge <?= $p['status_badge'] ?? 'bg-secondary' ?>" style="font-size: 0.68rem;">
                                                                    <?= esc($p['status_label'] ?? 'Draft') ?>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <!-- Aksi Dropdown -->
                                                        <td class="text-end">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-icon btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                                        <use href="/icons/sprite.svg#more-vertical"></use>
                                                                    </svg>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                                    <li>
                                                                        <a class="dropdown-item btn-view-plan" href="javascript:void(0);" data-plan='<?= $planJson ?>'>
                                                                            <svg class="sa-icon me-2 text-primary" style="width: 13px; height: 13px;">
                                                                                <use href="/icons/sprite.svg#eye"></use>
                                                                            </svg>
                                                                            Lihat Detail RUP
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Buka form ubah untuk: <?= esc(addslashes($p['package_code'])) ?>');">
                                                                            <svg class="sa-icon me-2 text-secondary" style="width: 13px; height: 13px;">
                                                                                <use href="/icons/sprite.svg#edit"></use>
                                                                            </svg>
                                                                            Ubah Paket
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Cetak ringkasan paket: <?= esc(addslashes($p['package_code'])) ?>');">
                                                                            <svg class="sa-icon me-2 text-info" style="width: 13px; height: 13px;">
                                                                                <use href="/icons/sprite.svg#printer"></use>
                                                                            </svg>
                                                                            Cetak Lembar RUP
                                                                        </a>
                                                                    </li>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li>
                                                                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="if(confirm('Yakin ingin menghapus draf RUP ini?')) alert('Draf RUP berhasil dihapus.');">
                                                                            <svg class="sa-icon me-2 text-danger" style="width: 13px; height: 13px;">
                                                                                <use href="/icons/sprite.svg#trash-2"></use>
                                                                            </svg>
                                                                            Hapus Paket
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <tr id="noResultsRow" style="display: none;">
                                                    <td colspan="9" class="text-center py-5 text-muted">
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

        <?= $this->include('partials/app-drawer') ?>

        <?= $this->include('partials/app-settings') ?>

    </div>

    <!-- MODAL 1: Detail Paket RUP Komprehensif -->
    <div class="modal fade" id="detailPlanModal" tabindex="-1" aria-labelledby="detailPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <div>
                        <span class="badge bg-primary me-2 font-monospace" id="modalPlanCode">RUP-XXXX-XXXX</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle" id="modalPlanRupStatus">Terumumkan</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Judul Paket & Program -->
                    <div class="border-bottom pb-3 mb-3">
                        <h5 class="fw-bold text-dark mb-1" id="modalPlanName">-</h5>
                        <div class="text-muted fs-sm">
                            <svg class="sa-icon me-1 text-muted" style="width: 14px; height: 14px;">
                                <use href="/icons/sprite.svg#layers"></use>
                            </svg>
                            <span id="modalPlanActivity">-</span>
                        </div>
                    </div>

                    <!-- Grid Informasi Detail 100% Berdasarkan Migration -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-2 h-100">
                                <h6 class="fw-bold text-dark mb-3 fs-xs text-uppercase">Informasi Satuan Kerja & PPK</h6>
                                <div class="mb-2">
                                    <div class="detail-label">Instansi / SKPD</div>
                                    <div class="detail-value" id="modalPlanAgency">-</div>
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
                            <div class="p-3 bg-light rounded-2 h-100">
                                <h6 class="fw-bold text-dark mb-3 fs-xs text-uppercase">Pagu & Penganggaran</h6>
                                <div class="mb-2">
                                    <div class="detail-label">Total Pagu Anggaran</div>
                                    <div class="detail-value text-success fs-5 fw-bold font-monospace" id="modalPlanBudget">Rp 0</div>
                                </div>
                                <div class="mb-2">
                                    <div class="detail-label">Mata Anggaran Kegiatan (MAK)</div>
                                    <div class="detail-value font-monospace" id="modalPlanMak">-</div>
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
                                    <div class="detail-value" id="modalPlanExpenseType">-</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-2 h-100">
                                <h6 class="fw-bold text-dark mb-3 fs-xs text-uppercase">Metode & Waktu Pengadaan</h6>
                                <div class="mb-2">
                                    <div class="detail-label">Jenis Pengadaan</div>
                                    <div class="detail-value" id="modalPlanProcType">-</div>
                                </div>
                                <div class="mb-2">
                                    <div class="detail-label">Metode Pemilihan</div>
                                    <div class="detail-value" id="modalPlanMethod">-</div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="detail-label">Waktu / Durasi</div>
                                        <div class="detail-value" id="modalPlanDuration">0 Hari</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="detail-label">Tanggal Pengajuan</div>
                                        <div class="detail-value" id="modalPlanDate">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-2 h-100">
                                <h6 class="fw-bold text-dark mb-3 fs-xs text-uppercase">Status SiRUP LKPP & Sinkronisasi</h6>
                                <div class="mb-2">
                                    <div class="detail-label">Status Paket</div>
                                    <div class="detail-value" id="modalPlanPackageStatus">-</div>
                                </div>
                                <div class="mb-2">
                                    <div class="detail-label">Status Sinkronisasi SiRUP</div>
                                    <div class="detail-value" id="modalPlanSyncStatus">-</div>
                                </div>
                                <div>
                                    <div class="detail-label">Tahun Anggaran</div>
                                    <div class="detail-value" id="modalPlanYear">2026</div>
                                </div>
                            </div>
                        </div>

                        <!-- Uraian Pekerjaan & Catatan -->
                        <div class="col-12">
                            <div class="p-3 border rounded-2">
                                <div class="mb-2">
                                    <div class="detail-label">Uraian / Deskripsi Pekerjaan</div>
                                    <p class="fs-sm text-dark mb-0" id="modalPlanDescription">-</p>
                                </div>
                                <div class="mt-3 pt-2 border-top">
                                    <div class="detail-label">Catatan Tambahan</div>
                                    <p class="fs-xs text-muted mb-0" id="modalPlanNotes">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="alert('Mencetak lembar RUP...');">
                        <svg class="sa-icon me-1" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#printer"></use>
                        </svg>
                        Cetak Lembar RUP
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
                <div class="modal-body">
                    <form id="dummyAddPlanForm" onsubmit="event.preventDefault(); alert('Paket RUP baru berhasil disimpan ke sistem (simulasi)!'); const modal = bootstrap.Modal.getInstance(document.getElementById('addPlanModal')); modal.hide();">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tahun Anggaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" value="2026" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Kode Paket / Kode SiRUP</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Contoh: RUP-2026-99182310 (opsional)">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Instansi / SKPD <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" required>
                                    <option value="">-- Pilih SKPD --</option>
                                    <?php if (!empty($agencies)): ?>
                                        <?php foreach ($agencies as $ag): ?>
                                            <option value="<?= $ag['id'] ?>"><?= esc($ag['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Dinas Pekerjaan Umum dan Penataan Ruang</option>
                                        <option value="2">Dinas Kesehatan</option>
                                        <option value="3">Dinas Pendidikan</option>
                                        <option value="4">Dinas Komunikasi, Informatika dan Statistik</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pejabat Pembuat Komitmen (PPK) <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" required>
                                    <option value="">-- Pilih PPK --</option>
                                    <?php if (!empty($officers)): ?>
                                        <?php foreach ($officers as $off): ?>
                                            <option value="<?= $off['id'] ?>"><?= esc($off['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Ir. Hendra Gunawan, S.T., M.T.</option>
                                        <option value="2">drg. Ratna Juwita, M.Kes.</option>
                                        <option value="3">Drs. Ahmad Fauzi, M.Pd.</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Nama Kegiatan / Program <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" placeholder="Contoh: Program Penyelenggaraan Jalan dan Jembatan" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Nama Paket Pengadaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" placeholder="Contoh: Pembangunan Jembatan Sei Siak Ruas Simpang Tiga" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jenis Pengadaan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Jenis Pengadaan --</option>
                                    <option value="1">Barang</option>
                                    <option value="2">Jasa Konsultansi</option>
                                    <option value="3">Jasa Lainnya</option>
                                    <option value="4" selected>Pekerjaan Konstruksi</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Metode Pemilihan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Metode Pemilihan --</option>
                                    <option value="1">E-purchasing</option>
                                    <option value="2">Pengadaan Langsung</option>
                                    <option value="3">Penunjukan Langsung</option>
                                    <option value="4" selected>Tender</option>
                                    <option value="5">Seleksi</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pagu Anggaran (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" placeholder="0" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mata Anggaran Kegiatan (MAK)</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Contoh: 5.2.04.01.01.0001">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Sumber Dana <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" required>
                                    <option value="1" selected>APBD</option>
                                    <option value="2">APBN</option>
                                    <option value="3">DAK Fisik</option>
                                    <option value="4">BLUD</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status DAK</label>
                                <select class="form-select form-select-sm">
                                    <option value="2" selected>NON DAK</option>
                                    <option value="1">DAK</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Waktu Pekerjaan (Hari)</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control" placeholder="90" min="1">
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Lokasi Pekerjaan</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Contoh: Kota Pekanbaru">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Uraian / Deskripsi Pekerjaan</label>
                                <textarea class="form-control form-control-sm" rows="2" placeholder="Uraian singkat lingkup pekerjaan..."></textarea>
                            </div>
                        </div>

                        <div class="text-end mt-4 pt-2 border-top">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Paket RUP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('partials/app-scripts') ?>

    <!-- Interactive Client-side Script: Filter, Pagination & Detail Modal -->
    <script>
        // Simulasi Sinkronisasi SiRUP LKPP
        function simulateSyncSirup() {
            const btn = event.currentTarget;
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menghubungkan SiRUP...';
            
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                alert('Sinkronisasi SiRUP Berhasil!\n10 Paket RUP telah diperbarui statusnya dari portal LKPP.');
            }, 1200);
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
                return 'Rp ' + Number(amount).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
            }

            // Pasang event listener tombol detail
            document.querySelectorAll('.btn-view-plan').forEach(btn => {
                btn.addEventListener('click', function () {
                    const rawData = this.getAttribute('data-plan');
                    if (!rawData) return;
                    try {
                        const p = JSON.parse(rawData);
                        document.getElementById('modalPlanCode').textContent = p.package_code || ('DRAFT-' + p.id);
                        document.getElementById('modalPlanRupStatus').textContent = (parseInt(p.rup_status) === 1) ? 'Terumumkan' : 'Draf';
                        document.getElementById('modalPlanRupStatus').className = (parseInt(p.rup_status) === 1) 
                            ? 'badge bg-success-subtle text-success border border-success-subtle'
                            : 'badge bg-warning-subtle text-warning border border-warning-subtle';

                        document.getElementById('modalPlanName').textContent = p.package_name || '-';
                        document.getElementById('modalPlanActivity').textContent = p.activity || '-';

                        document.getElementById('modalPlanAgency').textContent = p.agency_name || '-';
                        document.getElementById('modalPlanOfficer').textContent = p.commitment_officer_name || '-';
                        document.getElementById('modalPlanLocation').textContent = p.location || '-';
                        document.getElementById('modalPlanVolume').textContent = p.volume || '-';

                        document.getElementById('modalPlanBudget').textContent = formatRupiah(p.budget_ceiling || 0);
                        document.getElementById('modalPlanMak').textContent = p.account_code || '-';
                        document.getElementById('modalPlanFunding').textContent = p.funding_source_name || '-';
                        document.getElementById('modalPlanDak').textContent = p.special_allocation_type_name || 'NON DAK';
                        document.getElementById('modalPlanExpenseType').textContent = p.expense_type_name || '-';

                        document.getElementById('modalPlanProcType').textContent = p.procurement_type_name || '-';
                        document.getElementById('modalPlanMethod').textContent = p.selection_method_name || '-';
                        document.getElementById('modalPlanDuration').textContent = (p.work_duration || 0) + ' Hari Kalender';
                        document.getElementById('modalPlanDate').textContent = p.submission_date || '-';

                        document.getElementById('modalPlanPackageStatus').textContent = p.status_label || 'Draft';
                        document.getElementById('modalPlanSyncStatus').textContent = (parseInt(p.is_synced) === 1) ? 'Tersinkron SiRUP LKPP' : 'Belum Sinkron';
                        document.getElementById('modalPlanYear').textContent = p.fiscal_year || '2026';

                        document.getElementById('modalPlanDescription').textContent = p.description || 'Tidak ada keterangan uraian spesifik.';
                        document.getElementById('modalPlanNotes').textContent = p.notes || '-';

                        const detailModal = new bootstrap.Modal(document.getElementById('detailPlanModal'));
                        detailModal.show();
                    } catch (e) {
                        console.error('Error parsing plan detail:', e);
                    }
                });
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
                    const ag = row.getAttribute('data-agency') || '';
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
                    const matchesRupStatus = !rupStatusVal || rupStatus === rupStatusVal;
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
        });
    </script>

</body>

</html>
