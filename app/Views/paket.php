<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Daftar Paket Pengadaan - SIMPPEL")) ?>

    <?= $this->include('partials/app-head-css') ?>

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

        .table-paket th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .paket-title-cell {
            min-width: 280px;
            max-width: 380px;
        }
        .detail-label {
            font-size: 0.75rem;
            text-transform: uppercase;
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

        /* Dark mode adaptations */
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
        [data-bs-theme="dark"] .detail-value {
            color: var(--bs-body-color, #dee2e6);
        }
        [data-bs-theme="dark"] .detail-label {
            color: var(--bs-secondary-color, #a7acb1);
        }

        /* Modal Peringatan Dokumen Persyaratan Belum Lengkap */
        #modalSyaratBelumLengkap {
            z-index: 1065;
        }
        .modal-syarat-icon-wrap {
            width: 74px;
            height: 74px;
            background: rgba(239, 68, 68, 0.12);
            color: #dc3545;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            position: relative;
            box-shadow: 0 0 0 8px rgba(239, 68, 68, 0.06);
            animation: pulse-syarat-alert 2s ease-in-out infinite;
        }
        @keyframes pulse-syarat-alert {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .syarat-missing-item {
            transition: background-color 0.15s ease-in-out;
        }
        .syarat-missing-item:hover {
            background-color: var(--bs-tertiary-bg, rgba(0, 0, 0, 0.03));
        }
        [data-bs-theme="dark"] .modal-syarat-icon-wrap {
            background: rgba(239, 68, 68, 0.2);
            box-shadow: 0 0 0 8px rgba(239, 68, 68, 0.1);
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
                        "pageTitle" => "Daftar Paket Pengadaan",
                        "pageSubTitle1" => "Proses Pengadaan",
                        "pageSubTitle2" => "Paket Tender & Seleksi",
                        "pageSubText" => "Daftar paket pengadaan tender dan seleksi, pemantauan alur verifikasi berkas UKPBJ, penugasan Pokja, dan hasil penetapan pemenang."
                    )) ?>

                    <?php
                    $pakets        = $pakets ?? [];
                    $skpdList      = $skpdList ?? [];
                    $availableRups = $availableRups ?? [];
                    $totalPaket    = $totalPaket ?? count($pakets);
                    $totalHps      = $totalHps ?? array_sum(array_column($pakets, 'nilai_hps'));
                    $totalKontrak  = $totalKontrak ?? array_sum(array_column($pakets, 'nilai_kontrak'));
                    $draftCount    = $draftCount ?? count(array_filter($pakets, fn($p) => (int)($p['status_paket'] ?? 0) === 1));
                    $prosesCount   = $prosesCount ?? count(array_filter($pakets, fn($p) => in_array((int)($p['status_paket'] ?? 0), range(2, 12))));
                    $selesaiCount  = $selesaiCount ?? count(array_filter($pakets, fn($p) => (int)($p['status_paket'] ?? 0) === 14));

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
                                                <use href="/icons/sprite.svg#package"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total Paket Pengadaan</div>
                                            <div class="fs-2 fw-bold text-body-emphasis"><?= $totalPaket ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-muted">Terdaftar di Sistem</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Total HPS -->
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#dollar-sign"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total Nilai HPS</div>
                                            <div class="fs-2 fw-bold text-success"><?= $formatShortRupiah($totalHps) ?></div>
                                            <div class="fs-xs text-muted" title="Rp <?= number_format($totalHps, 2, ',', '.') ?>">
                                                Rp <?= number_format($totalHps, 0, ',', '.') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Proses Berjalan -->
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#activity"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Proses Tender Berjalan</div>
                                            <div class="fs-2 fw-bold text-body-emphasis"><?= $prosesCount ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-info">Tahap Verifikasi s/d Penetapan</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4: Selesai / Kontrak -->
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#check-circle"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Selesai / Kontrak</div>
                                            <div class="fs-2 fw-bold text-body-emphasis"><?= $selesaiCount ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-muted" title="Total Nilai Kontrak: Rp <?= number_format($totalKontrak, 2, ',', '.') ?>">
                                                Nilai: <?= $formatShortRupiah($totalKontrak) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Flash Message Alert -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3 shadow-sm" role="alert">
                                <svg class="sa-icon text-success flex-shrink-0" style="width: 18px; height: 18px;"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                <div><?= session()->getFlashdata('success') ?></div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3 shadow-sm" role="alert">
                                <svg class="sa-icon text-danger flex-shrink-0" style="width: 18px; height: 18px;"><use href="/icons/sprite.svg#alert-circle"></use></svg>
                                <div><?= session()->getFlashdata('error') ?></div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Panel Table Paket -->
                        <div class="panel">
                            <div class="panel-hdr">
                                <h2>
                                    <span class="fw-bold">Daftar Paket Tender & Seleksi</span>
                                    <span class="fw-300 ms-1 text-muted fs-xs">(Tabel Paket)</span>
                                </h2>
                                <div class="panel-toolbar d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addPaketModal">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#plus"></use>
                                        </svg>
                                        <span>Tambah Paket</span>
                                    </button>
                                    <a href="/rup" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#arrow-left"></use>
                                        </svg>
                                        <span>Lihat RUP</span>
                                    </a>
                                </div>
                            </div>

                            <div class="panel-container show">
                                <div class="panel-content">

                                    <!-- Filter Toolbar -->
                                    <div class="row g-2 mb-3 align-items-center">
                                        <!-- Search Box -->
                                        <div class="col-md-4 col-lg-3">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">
                                                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                        <use href="/icons/sprite.svg#search"></use>
                                                    </svg>
                                                </span>
                                                <input type="text" id="paketSearchInput" class="form-control" placeholder="Cari no paket, RPP, nama paket, pemenang, SKPD...">
                                            </div>
                                        </div>

                                        <!-- Filter Status Tahapan Paket (0 - 15) -->
                                        <div class="col-6 col-md-3 col-lg-2">
                                            <select id="statusPaketFilter" class="form-select form-select-sm">
                                                <option value="">Semua Tahapan Paket</option>
                                                <?php 
                                                $stMap = $statusPaketList ?? \App\Models\PaketModel::STATUS_PAKET;
                                                foreach ($stMap as $code => $st): 
                                                ?>
                                                    <option value="<?= $code ?>">
                                                        <?= $code ?> - <?= esc($st['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Filter Verifikasi UKPBJ -->
                                        <div class="col-6 col-md-2 col-lg-2">
                                            <select id="verifikasiFilter" class="form-select form-select-sm">
                                                <option value="">Semua Status Verifikasi</option>
                                                <option value="1">Disetujui</option>
                                                <option value="0">Menunggu</option>
                                                <option value="2">Perlu Perbaikan</option>
                                            </select>
                                        </div>

                                        <!-- Filter SKPD -->
                                        <div class="col-6 col-md-2 col-lg-2">
                                            <select id="skpdFilter" class="form-select form-select-sm">
                                                <option value="">Semua SKPD</option>
                                                <?php foreach ($skpdList as $s): ?>
                                                    <option value="<?= esc(strtolower($s['abbreviation'] ?: $s['name'])) ?>">
                                                        <?= esc($s['abbreviation'] ?: $s['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Per Page Selector -->
                                        <div class="col-12 col-md-12 col-lg-3 ms-auto">
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

                                    <!-- Tabel Paket Responsif -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped align-middle mb-0 table-paket" id="paketTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 100px;">No. Paket</th>
                                                    <th class="paket-title-cell">Paket Pengadaan & SKPD</th>
                                                    <th style="min-width: 180px;">No. RPP & Tanggal</th>
                                                    <th class="text-end" style="min-width: 160px;">Nilai HPS</th>
                                                    <th class="text-center" style="min-width: 130px;">Status Tahapan</th>
                                                    <th class="text-center" style="min-width: 110px;">Verifikasi</th>
                                                    <th style="min-width: 200px;">Pemenang & Kontrak</th>
                                                    <th class="text-end" style="width: 75px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pakets as $p): ?>
                                                    <?php
                                                    $paketJson = htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8');
                                                    $hasWinner = !empty($p['nama_pemenang']);
                                                    ?>
                                                    <tr class="paket-row"
                                                        data-id="<?= $p['id'] ?>"
                                                        data-no-paket="<?= esc(strtolower($p['no_paket'] ?? '')) ?>"
                                                        data-package-name="<?= esc(strtolower($p['package_name'] ?? '')) ?>"
                                                        data-activity="<?= esc(strtolower($p['activity'] ?? '')) ?>"
                                                        data-no-rpp="<?= esc(strtolower($p['no_rpp'] ?? '')) ?>"
                                                        data-skpd="<?= esc(strtolower(($p['skpd_abbreviation'] ?? '') . ' ' . ($p['skpd_name'] ?? ''))) ?>"
                                                        data-winner="<?= esc(strtolower($p['nama_pemenang'] ?? '')) ?>"
                                                        data-status-paket="<?= (int) ($p['status_paket'] ?? 0) ?>"
                                                        data-status-verifikasi="<?= (int) ($p['status_verifikasi'] ?? 0) ?>">

                                                        <!-- No. Paket -->
                                                        <td>
                                                            <?php if (!empty($p['no_paket'])): ?>
                                                                <div class="font-monospace fw-bold text-primary fs-sm">
                                                                    <?= esc($p['no_paket']) ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle font-monospace fs-nano">
                                                                    DRAFT
                                                                </span>
                                                            <?php endif; ?>
                                                            <div class="fs-nano text-muted">
                                                                ID: #<?= $p['id'] ?>
                                                            </div>
                                                        </td>

                                                        <!-- Paket Pengadaan & SKPD -->
                                                        <td class="paket-title-cell">
                                                            <div class="fw-semibold text-body-emphasis mb-1" title="<?= esc($p['package_name'] ?? 'Paket #' . $p['id']) ?>">
                                                                <?= esc($p['package_name'] ?? 'Paket #' . $p['id']) ?>
                                                            </div>
                                                            <div class="fs-xs text-secondary mb-1">
                                                                <svg class="sa-icon me-1 text-muted" style="width: 12px; height: 12px;">
                                                                    <use href="/icons/sprite.svg#layers"></use>
                                                                </svg>
                                                                <?= esc($p['activity'] ?? '-') ?>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-1 flex-wrap">
                                                                <span class="badge bg-body-secondary text-secondary border fs-nano">
                                                                    <?= esc($p['skpd_abbreviation'] ?: ($p['skpd_name'] ?? 'SKPD')) ?>
                                                                </span>
                                                                <?php if (!empty($p['fiscal_year'])): ?>
                                                                    <span class="badge bg-body-secondary text-secondary border fs-nano">TA <?= esc($p['fiscal_year']) ?></span>
                                                                <?php endif; ?>
                                                                <span class="badge <?= $p['proc_badge'] ?? 'badge-proc-default' ?> fs-nano">
                                                                    <?= esc($p['jenis_pengadaan_name'] ?? 'Barang') ?>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <!-- No. RPP & Tanggal -->
                                                        <td>
                                                            <div class="font-monospace fs-xs text-body-emphasis mb-1" title="<?= esc($p['no_rpp']) ?>">
                                                                <?= esc($p['no_rpp'] ?: '-') ?>
                                                            </div>
                                                            <div class="fs-nano text-muted">
                                                                Tgl Paket: <?= !empty($p['tgl_paket']) ? date('d/m/Y', strtotime($p['tgl_paket'])) : '-' ?>
                                                            </div>
                                                            <?php if (!empty($p['tgl_tayang'])): ?>
                                                                <div class="fs-nano text-info">
                                                                    Tayang: <?= date('d/m/Y', strtotime($p['tgl_tayang'])) ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Nilai HPS -->
                                                        <td class="text-end">
                                                            <div class="fw-bold text-body-emphasis font-monospace fs-sm">
                                                                Rp <?= number_format((float) $p['nilai_hps'], 0, ',', '.') ?>
                                                            </div>
                                                            <?php if (!empty($p['budget_ceiling'])): ?>
                                                                <div class="fs-nano text-muted" title="Pagu RUP">
                                                                    Pagu: Rp <?= number_format((float) $p['budget_ceiling'], 0, ',', '.') ?>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="fs-nano text-secondary">
                                                                <?= esc($p['metode_pemilihan_name'] ?? '-') ?>
                                                            </div>
                                                        </td>

                                                        <!-- Status Tahapan Paket -->
                                                        <td class="text-center">
                                                            <span class="badge <?= $p['status_badge'] ?? 'bg-secondary' ?>" style="font-size: 0.72rem;" title="<?= esc($p['status_desc'] ?? '') ?>">
                                                                <?= esc($p['status_label'] ?? 'Draft') ?>
                                                            </span>
                                                            <?php if (!empty($p['is_lpse'])): ?>
                                                                <div class="mt-1">
                                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-nano">
                                                                        LPSE
                                                                    </span>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Verifikasi UKPBJ -->
                                                        <td class="text-center">
                                                            <span class="badge <?= $p['verifikasi_badge'] ?? 'bg-warning-subtle text-warning-emphasis' ?>" style="font-size: 0.7rem;">
                                                                <?= esc($p['verifikasi_label'] ?? 'Menunggu') ?>
                                                            </span>
                                                        </td>

                                                        <!-- Pemenang & Kontrak -->
                                                        <td>
                                                            <?php if ($hasWinner): ?>
                                                                <div class="fw-semibold text-body-emphasis fs-xs mb-1 text-truncate" style="max-width: 220px;" title="<?= esc($p['nama_pemenang']) ?>">
                                                                    <?= esc($p['nama_pemenang']) ?>
                                                                </div>
                                                                <div class="font-monospace text-success fw-bold fs-xs">
                                                                    Rp <?= number_format((float) $p['nilai_kontrak'], 0, ',', '.') ?>
                                                                </div>
                                                                <?php if (!empty($p['tgl_penetapan'])): ?>
                                                                    <div class="fs-nano text-muted">
                                                                        Penetapan: <?= date('d/m/Y', strtotime($p['tgl_penetapan'])) ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="text-muted fs-xs fst-italic">Belum ada pemenang</span>
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Aksi -->
                                                        <td class="text-end">
                                                            <button type="button" class="btn btn-sm btn-icon btn-light btn-view-paket" data-paket='<?= $paketJson ?>' title="Lihat Detail Paket">
                                                                <svg class="sa-icon text-primary" style="width: 14px; height: 14px;">
                                                                    <use href="/icons/sprite.svg#eye"></use>
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <tr id="noResultsRow" style="display: none;">
                                                    <td colspan="8" class="text-center py-5 text-muted">
                                                        <div class="mb-2">
                                                            <svg class="sa-icon text-muted" style="width: 32px; height: 32px;">
                                                                <use href="/icons/sprite.svg#search"></use>
                                                            </svg>
                                                        </div>
                                                        <div class="fw-semibold">Tidak ada paket pengadaan yang ditemukan</div>
                                                        <small class="text-muted">Coba ubah kata kunci pencarian atau sesuaikan filter di atas.</small>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination Footer -->
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 pt-3 border-top gap-2" id="paginationControls">
                                        <div class="fs-xs text-muted" id="showingInfo">
                                            Menampilkan <span id="showingStart">1</span>-<span id="showingEnd"><?= count($pakets) ?></span> dari <span id="showingTotal"><?= count($pakets) ?></span> paket
                                        </div>
                                        <nav aria-label="Navigasi Halaman Paket">
                                            <ul class="pagination pagination-sm mb-0" id="paginationList">
                                                <!-- Generate via JS -->
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

    <!-- MODAL: Detail Paket Pengadaan Komprehensif (2 Tab: Details & Syarat) -->
    <div class="modal fade" id="detailPaketModal" tabindex="-1" aria-labelledby="detailPaketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-body-tertiary">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <span class="badge bg-primary font-monospace fs-sm" id="modalPaketNo">0001</span>
                        <span class="badge bg-info text-white" id="modalPaketStatus">Tayang Tender</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle" id="modalPaketVerif">Disetujui</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Header Modal: Judul Paket & Navigasi Tab -->
                <div class="px-4 pt-3 pb-0 border-bottom bg-body">
                    <div class="mb-3">
                        <h5 class="fw-bold text-body-emphasis mb-1" id="modalPaketTitle">-</h5>
                        <div class="text-muted fs-sm">
                            <svg class="sa-icon me-1 text-muted" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#layers"></use></svg>
                            <span id="modalPaketActivity">-</span>
                        </div>
                    </div>

                    <!-- 2 Tabulasi: Rincian Paket & Dokumen Persyaratan -->
                    <ul class="nav nav-tabs nav-tabs-clean border-0 gap-2" id="detailPaketTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold d-flex align-items-center gap-2 px-3 py-2" id="tab-detail-link" data-bs-toggle="tab" data-bs-target="#tabDetailContent" type="button" role="tab" aria-controls="tabDetailContent" aria-selected="true">
                                <svg class="sa-icon" style="width: 15px; height: 15px;"><use href="/icons/sprite.svg#file-text"></use></svg>
                                <span>Rincian Paket</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold d-flex align-items-center gap-2 px-3 py-2" id="tab-syarat-link" data-bs-toggle="tab" data-bs-target="#tabSyaratContent" type="button" role="tab" aria-controls="tabSyaratContent" aria-selected="false">
                                <svg class="sa-icon" style="width: 15px; height: 15px;"><use href="/icons/sprite.svg#paperclip"></use></svg>
                                <span>Dokumen Persyaratan</span>
                                <span class="badge bg-danger rounded-pill fs-nano ms-1 d-none" id="badgeSyaratPending">0 Belum</span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fs-nano ms-1 d-none" id="badgeSyaratLengkap">Lengkap</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="modal-body p-4">
                    <div class="tab-content" id="detailPaketTabContent">

                        <!-- TABULASI 1: RINCIAN PAKET (DETAILS) -->
                        <div class="tab-pane fade show active" id="tabDetailContent" role="tabpanel" aria-labelledby="tab-detail-link">
                            <div class="row g-3">
                                <!-- Kolom Kiri: Data RPP & HPS -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-body-tertiary rounded-2 h-100">
                                        <h6 class="fw-bold text-body-emphasis mb-3 fs-xs text-uppercase">Data RPP & Anggaran</h6>
                                        <div class="mb-2">
                                            <div class="detail-label">Nomor RPP</div>
                                            <div class="detail-value font-monospace" id="modalPaketNoRpp">-</div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="detail-label">Nilai HPS</div>
                                            <div class="detail-value fw-bold text-primary font-monospace" id="modalPaketHps">-</div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="detail-label">Pagu Anggaran RUP</div>
                                            <div class="detail-value font-monospace" id="modalPaketPagu">-</div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="detail-label">SKPD / Satuan Kerja</div>
                                            <div class="detail-value" id="modalPaketSkpd">-</div>
                                        </div>
                                        <div>
                                            <div class="detail-label">Pejabat Pembuat Komitmen (PPK)</div>
                                            <div class="detail-value" id="modalPaketPpk">-</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom Kanan: Tanggal Alur Paket -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-body-tertiary rounded-2 h-100">
                                        <h6 class="fw-bold text-body-emphasis mb-3 fs-xs text-uppercase">Tahapan & Waktu Pengadaan</h6>
                                        <div class="row g-2 mb-2">
                                            <div class="col-6">
                                                <div class="detail-label">Tgl Pembuatan</div>
                                                <div class="detail-value" id="modalPaketTglPaket">-</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="detail-label">Tgl Pengajuan</div>
                                                <div class="detail-value" id="modalPaketTglPengajuan">-</div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2">
                                            <div class="col-6">
                                                <div class="detail-label">Tgl Distribusi</div>
                                                <div class="detail-value" id="modalPaketTglDistribusi">-</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="detail-label">Tgl Tayang Tender</div>
                                                <div class="detail-value" id="modalPaketTglTayang">-</div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="detail-label">Catatan Verifikasi UKPBJ</div>
                                            <div class="detail-value fst-italic" id="modalPaketCatatanVerif">-</div>
                                        </div>
                                        <div>
                                            <div class="detail-label">Status Sinkronisasi LPSE</div>
                                            <div class="detail-value" id="modalPaketLpse">-</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Pemenang & Kontrak (Jika Ada) -->
                                <div class="col-12" id="modalWinnerSection">
                                    <div class="p-3 border border-success-subtle bg-success bg-opacity-10 rounded-2">
                                        <h6 class="fw-bold text-success mb-3 fs-xs text-uppercase d-flex align-items-center gap-1">
                                            <svg class="sa-icon" style="width: 16px; height: 16px;">
                                                <use href="/icons/sprite.svg#award"></use>
                                            </svg>
                                            <span>Pemenang Pengadaan & Nilai Kontrak</span>
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <div class="detail-label">Nama Perusahaan / Penyedia</div>
                                                    <div class="detail-value fw-bold" id="modalWinnerName">-</div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="detail-label">NPWP</div>
                                                    <div class="detail-value font-monospace" id="modalWinnerNpwp">-</div>
                                                </div>
                                                <div>
                                                    <div class="detail-label">Alamat Penyedia</div>
                                                    <div class="detail-value fs-xs" id="modalWinnerAddress">-</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <div class="detail-label">Penanggung Jawab / Direktur</div>
                                                    <div class="detail-value" id="modalWinnerLeader">-</div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="detail-label">Nilai Kontrak / Realisasi</div>
                                                    <div class="detail-value fw-bold text-success font-monospace fs-5" id="modalWinnerContract">-</div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <div class="detail-label">No. Surat Penetapan</div>
                                                        <div class="detail-value font-monospace fs-xs" id="modalWinnerLetterNo">-</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="detail-label">Tgl Penetapan</div>
                                                        <div class="detail-value" id="modalWinnerDate">-</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TABULASI 2: DOKUMEN PERSYARATAN (SYARAT) -->
                        <div class="tab-pane fade" id="tabSyaratContent" role="tabpanel" aria-labelledby="tab-syarat-link">
                            
                            <!-- Alert Notifikasi / Syarat Info -->
                            <div class="alert alert-info py-2 px-3 mb-3 fs-xs d-flex align-items-center gap-2" id="syaratInfoAlert">
                                <svg class="sa-icon text-info flex-shrink-0" style="width: 16px; height: 16px;"><use href="/icons/sprite.svg#info"></use></svg>
                                <div id="syaratInfoText">
                                    Dokumen persyaratan bertanda <strong>Wajib</strong> harus diunggah seluruhnya sebelum paket dapat diajukan ke UKPBJ. Format dokumen wajib sesuai dengan ketentuan.
                                </div>
                            </div>

                            <!-- Alert Feedback (Error / Success) -->
                            <div class="alert alert-danger d-none py-2 px-3 mb-3 fs-xs" id="syaratActionAlertError"></div>
                            <div class="alert alert-success d-none py-2 px-3 mb-3 fs-xs" id="syaratActionAlertSuccess"></div>

                            <!-- Loading Spinner Syarat -->
                            <div class="text-center py-4 d-none" id="syaratLoading">
                                <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                                <span class="fs-xs text-muted">Memuat daftar dokumen persyaratan...</span>
                            </div>

                            <!-- Tabel Dokumen Persyaratan -->
                            <div class="table-responsive border rounded-2" id="syaratTableWrapper">
                                <table class="table table-hover align-middle mb-0" id="tableSyarat">
                                    <thead class="table-light fs-xs text-uppercase fw-semibold">
                                        <tr>
                                            <th style="width: 45px;" class="text-center">No</th>
                                            <th style="min-width: 250px;">Nama Persyaratan</th>
                                            <th style="width: 130px;" class="text-center">Sifat</th>
                                            <th style="width: 150px;">Ketentuan Format</th>
                                            <th style="min-width: 220px;">File Dokumen</th>
                                            <th style="width: 130px;" class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodySyarat" class="fs-xs">
                                        <!-- Diisi dinamis via JS -->
                                    </tbody>
                                    <tfoot id="tfootSyarat" class="bg-body-tertiary border-top">
                                        <!-- Kolom Isian Tambah Syarat Baru Manual (auto = 0) -->
                                        <tr>
                                            <td class="text-center fw-bold text-muted">+</td>
                                            <td colspan="2">
                                                <div class="mb-1">
                                                    <input type="text" class="form-control form-control-sm" id="inputNewSyaratName" placeholder="Ketik Nama Persyaratan Tambahan..." maxlength="100">
                                                </div>
                                                <div class="form-check form-check-inline fs-nano mb-0">
                                                    <input class="form-check-input" type="checkbox" id="checkNewSyaratHps" value="1">
                                                    <label class="form-check-label text-danger fw-semibold" for="checkNewSyaratHps">
                                                        Rahasia
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary border fs-nano">Bebas</span>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control form-control-sm" id="inputNewSyaratFile">
                                                <div class="fs-nano text-muted mt-1">Pilih file untuk langsung diunggah</div>
                                            </td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 text-nowrap" id="btnUploadNewSyarat">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#upload"></use></svg>
                                                    <span>Upload</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Hidden file input untuk upload ganti per baris -->
                            <input type="file" id="inputUploadSingleSyarat" class="d-none">

                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm px-4 d-none align-items-center gap-1" id="modalBtnAjukan">
                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#send"></use>
                        </svg>
                        <span>Ajukan Paket</span>
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm px-3 d-inline-flex align-items-center justify-content-center text-nowrap gap-2" onclick="alert('Mencetak lembar paket pengadaan...');">
                        <svg class="sa-icon" style="width: 15px; height: 15px;">
                            <use href="/icons/sprite.svg#printer"></use>
                        </svg>
                        <span>Cetak Lembar Paket</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Notifikasi Dokumen Persyaratan Belum Lengkap (Pengajuan Gagal) -->
    <div class="modal fade" id="modalSyaratBelumLengkap" tabindex="-1" aria-labelledby="modalSyaratBelumLengkapLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg overflow-hidden">
                <!-- Strip Aksen Warna Merah/Oranye Gradien -->
                <div style="height: 5px; background: linear-gradient(90deg, #ef4444 0%, #f97316 100%);"></div>

                <div class="modal-body p-4 text-center">
                    <!-- Icon Menarik dengan Efek Lembut -->
                    <div class="modal-syarat-icon-wrap mb-3">
                        <svg class="sa-icon text-danger" style="width: 36px; height: 36px;">
                            <use href="/icons/sprite.svg#alert-triangle"></use>
                        </svg>
                    </div>

                    <h5 class="modal-title fw-bold text-body-emphasis mb-1" id="modalSyaratBelumLengkapLabel">
                        Pengajuan Paket Belum Lengkap!
                    </h5>
                    <p class="text-secondary fs-sm mb-3 px-1">
                        Paket <strong class="text-body-emphasis font-monospace" id="modalSyaratPaketName">Paket Pengadaan</strong> belum dapat diajukan ke UKPBJ karena masih ada dokumen persyaratan wajib yang belum diunggah.
                    </p>

                    <!-- Summary Card Dokumen Belum Diunggah -->
                    <div class="card border border-danger-subtle bg-danger-subtle bg-opacity-10 rounded-3 mb-3 text-start overflow-hidden">
                        <div class="card-header bg-danger-subtle bg-opacity-25 border-danger-subtle py-2 px-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <svg class="sa-icon text-danger" style="width: 14px; height: 14px;">
                                    <use href="/icons/sprite.svg#file-text"></use>
                                </svg>
                                <span class="fs-xs fw-bold text-danger text-uppercase">Dokumen Wajib yang Belum Diunggah</span>
                            </div>
                            <span class="badge bg-danger rounded-pill font-monospace fs-nano" id="modalSyaratCountBadge">0 Belum Diunggah</span>
                        </div>
                        <div class="card-body p-0" style="max-height: 220px; overflow-y: auto;">
                            <div class="list-group list-group-flush" id="modalSyaratMissingList">
                                <!-- Rendered dynamically via JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Petunjuk / Action Notice -->
                    <div class="alert alert-info border-info-subtle bg-info-subtle bg-opacity-25 d-flex align-items-start gap-2 fs-xs text-start mb-0 rounded-2 py-2 px-3">
                        <svg class="sa-icon text-info flex-shrink-0 mt-1" style="width: 16px; height: 16px;">
                            <use href="/icons/sprite.svg#info"></use>
                        </svg>
                        <div>
                            <strong>Langkah Selanjutnya:</strong> Silakan unggah dokumen bertanda <em>Wajib</em> pada tab <strong>"Dokumen Persyaratan"</strong>. Tombol <em>Ajukan Paket</em> akan aktif setelah seluruh berkas lengkap.
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-body-tertiary border-top py-2 px-4 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="button" class="btn btn-primary btn-sm px-3 d-inline-flex align-items-center gap-2 shadow-xs" id="btnGoToUploadSyarat">
                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#upload"></use>
                        </svg>
                        <span>Lengkapi Dokumen Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Tambah Paket Pengadaan Baru -->
    <div class="modal fade" id="addPaketModal" tabindex="-1" aria-labelledby="addPaketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-body-tertiary">
                    <h5 class="modal-title fw-bold" id="addPaketModalLabel">
                        <svg class="sa-icon me-2 text-primary" style="width: 18px; height: 18px;">
                            <use href="/icons/sprite.svg#plus-circle"></use>
                        </svg>
                        Tambah Paket Pengadaan Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPaketForm" action="/paket/store" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-body p-4">
                        
                        <!-- Alert Error Form -->
                        <div class="alert alert-danger d-none" id="addPaketAlert" role="alert"></div>

                        <!-- 1. Dropdown Paket RUP yang Tersedia -->
                        <div class="mb-3">
                            <label for="selectRupId" class="form-label fw-semibold">
                                Paket Rencana Umum Pengadaan (RUP) <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="selectRupId" name="rup_id" required>
                                <?php if (empty($availableRups)): ?>
                                    <option value="" disabled selected>-- Tidak ada paket RUP yang tersedia untuk dibuatkan paket --</option>
                                <?php else: ?>
                                    <option value="" disabled selected>-- Pilih Paket RUP --</option>
                                    <?php foreach ($availableRups as $rup): ?>
                                        <option value="<?= $rup['id'] ?>"
                                            data-code="<?= esc($rup['package_code'] ?: 'DRAFT-' . $rup['id']) ?>"
                                            data-name="<?= esc($rup['package_name']) ?>"
                                            data-activity="<?= esc($rup['activity']) ?>"
                                            data-skpd="<?= esc($rup['skpd_name'] ?? '') ?>"
                                            data-ppk="<?= esc($rup['ppk_name'] ?? '') ?>"
                                            data-pagu="<?= (float) $rup['budget_ceiling'] ?>"
                                            data-jenis="<?= esc($rup['jenis_pengadaan_name'] ?? '') ?>">
                                            [<?= esc($rup['package_code'] ?: 'DRAFT-' . $rup['id']) ?>] <?= esc($rup['package_name']) ?> &mdash; Pagu: Rp <?= number_format((float) $rup['budget_ceiling'], 0, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text fs-xs text-muted">
                                Menampilkan paket RUP aktif milik instansi / PPK Anda yang belum pernah dibuatkan paket pengadaan.
                            </div>
                        </div>

                        <!-- Box Info RUP Terpilih -->
                        <div class="p-3 bg-body-tertiary rounded-2 border mb-3 d-none" id="rupInfoBox">
                            <div class="row g-2 fs-xs">
                                <div class="col-sm-6">
                                    <span class="text-muted d-block">Program / Kegiatan:</span>
                                    <span class="fw-semibold text-body" id="infoRupKegiatan">-</span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block">SKPD & PPK:</span>
                                    <span class="fw-semibold text-body" id="infoRupSkpdPpk">-</span>
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <span class="text-muted d-block">Jenis Pengadaan:</span>
                                    <span class="badge bg-secondary-subtle text-secondary" id="infoRupJenis">-</span>
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <span class="text-muted d-block">Pagu Anggaran RUP:</span>
                                    <span class="fw-bold text-success font-monospace fs-sm" id="infoRupPagu">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Nomor RPP -->
                        <div class="mb-3">
                            <label for="inputNoRpp" class="form-label fw-semibold">
                                Nomor RPP (Rencana Pelaksanaan Pengadaan) <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="inputNoRpp" name="no_rpp" placeholder="Contoh: 000.3.1/005/BID.BM/DPUPR" required>
                            <div class="form-text fs-xs text-muted">
                                Masukkan nomor dokumen RPP resmi dari PPK yang diajukan ke UKPBJ.
                            </div>
                        </div>

                        <!-- 3. Nilai HPS -->
                        <div class="mb-3">
                            <label for="inputNilaiHps" class="form-label fw-semibold">
                                Nilai HPS (Harga Perkiraan Sendiri) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text font-monospace fw-semibold">Rp</span>
                                <input type="text" class="form-control font-monospace fw-bold" id="inputNilaiHps" name="nilai_hps" placeholder="Contoh: 399.987.000" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div class="form-text fs-xs text-muted" id="hpsHint">
                                    Nilai HPS idealnya tidak melebihi Pagu Anggaran RUP.
                                </div>
                                <button type="button" class="btn btn-link btn-xs p-0 text-decoration-none fs-nano d-none" id="btnSalinPagu">
                                    Samakan Nilai dengan Pagu
                                </button>
                            </div>
                            <div class="text-danger fs-xs fw-semibold mt-1 d-none" id="hpsExceedWarning">
                                <svg class="sa-icon me-1 text-danger" style="width: 12px; height: 12px;"><use href="/icons/sprite.svg#alert-triangle"></use></svg>
                                Perhatian: Nilai HPS melebihi Pagu Anggaran RUP!
                            </div>
                        </div>

                        <!-- Info Otomatis System -->
                        <div class="alert alert-info py-2 px-3 mb-0 fs-xs d-flex align-items-center gap-2">
                            <svg class="sa-icon text-info flex-shrink-0" style="width: 16px; height: 16px;"><use href="/icons/sprite.svg#info"></use></svg>
                            <div>
                                <strong>Tanggal Paket:</strong> Otomatis diisi hari ini (<code><?= date('d/m/Y') ?></code>) &bull; 
                                <strong>Status Tahapan:</strong> Tersimpan sebagai <code>Draf (1)</code>. Nomor paket akan digenerate saat Anda menekan tombol <strong>Ajukan</strong>.
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-body-tertiary">
                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 d-inline-flex align-items-center gap-1" id="btnSubmitPaket">
                            <svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#check"></use></svg>
                            <span>Simpan Draf Paket</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $this->include('partials/app-scripts') ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('paketTable');
            if (!table) return;

            const allRows = Array.from(table.querySelectorAll('tbody tr.paket-row'));
            const searchInput = document.getElementById('paketSearchInput');
            const statusFilter = document.getElementById('statusPaketFilter');
            const verifFilter = document.getElementById('verifikasiFilter');
            const skpdFilter = document.getElementById('skpdFilter');
            const perPageSelect = document.getElementById('perPageSelect');

            const noResultsRow = document.getElementById('noResultsRow');
            const paginationControls = document.getElementById('paginationControls');
            const paginationList = document.getElementById('paginationList');
            const showingStart = document.getElementById('showingStart');
            const showingEnd = document.getElementById('showingEnd');
            const showingTotal = document.getElementById('showingTotal');

            let currentPage = 1;
            let perPage = 10;
            let filteredRows = [...allRows];

            // State aktif modal detail & dokumen persyaratan
            let currentPaketId = null;
            let currentPaketStatus = null;
            let currentPaketName = '';
            let currentSyaratSummary = null;
            let activeUploadSyaratId = null;

            function formatRupiah(amount) {
                return 'Rp ' + Number(amount).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
            }

            function formatDate(str) {
                if (!str || str === '0000-00-00') return '-';
                const parts = str.split('-');
                if (parts.length === 3) {
                    return parts[2] + '/' + parts[1] + '/' + parts[0];
                }
                return str;
            }

            // Event listener modal detail
            document.querySelectorAll('.btn-view-paket').forEach(btn => {
                btn.addEventListener('click', function () {
                    const rawData = this.getAttribute('data-paket');
                    if (!rawData) return;
                    try {
                        const p = JSON.parse(rawData);
                        if (p.no_paket && String(p.no_paket).trim() !== '') {
                            document.getElementById('modalPaketNo').textContent = p.no_paket;
                            document.getElementById('modalPaketNo').className = 'badge bg-primary me-2 font-monospace';
                        } else {
                            document.getElementById('modalPaketNo').textContent = 'DRAFT (Belum Ada No)';
                            document.getElementById('modalPaketNo').className = 'badge bg-secondary me-2 font-monospace';
                        }
                        document.getElementById('modalPaketStatus').textContent = p.status_label || 'Draft';
                        document.getElementById('modalPaketStatus').title = p.status_desc || '';
                        document.getElementById('modalPaketStatus').className = 'badge me-2 ' + (p.status_badge || 'bg-secondary text-white');
                        document.getElementById('modalPaketVerif').textContent = p.verifikasi_label || 'Menunggu';
                        document.getElementById('modalPaketVerif').className = 'badge ' + (p.verifikasi_badge || 'bg-warning-subtle text-warning');

                        // Global reference paket yang sedang dibuka di modal
                        currentPaketId = p.id;
                        currentPaketStatus = parseInt(p.status_paket);
                        currentPaketName = p.package_name || ('Paket #' + p.id);

                        const modalBtnAjukan = document.getElementById('modalBtnAjukan');
                        if (modalBtnAjukan) {
                            if (currentPaketStatus === 1) {
                                modalBtnAjukan.classList.remove('d-none');
                                modalBtnAjukan.classList.add('d-inline-flex');
                                modalBtnAjukan.onclick = function () {
                                    handleAjukanPaket(currentPaketId, currentPaketName);
                                };
                            } else {
                                modalBtnAjukan.classList.add('d-none');
                                modalBtnAjukan.classList.remove('d-inline-flex');
                                modalBtnAjukan.onclick = null;
                            }
                        }

                        document.getElementById('modalPaketTitle').textContent = p.package_name || ('Paket #' + p.id);
                        document.getElementById('modalPaketActivity').textContent = p.activity || '-';

                        document.getElementById('modalPaketNoRpp').textContent = p.no_rpp || '-';
                        document.getElementById('modalPaketHps').textContent = formatRupiah(p.nilai_hps || 0);
                        document.getElementById('modalPaketPagu').textContent = p.budget_ceiling ? formatRupiah(p.budget_ceiling) : '-';
                        document.getElementById('modalPaketSkpd').textContent = p.skpd_name || '-';
                        document.getElementById('modalPaketPpk').textContent = p.ppk_name || '-';

                        document.getElementById('modalPaketTglPaket').textContent = formatDate(p.tgl_paket);
                        document.getElementById('modalPaketTglPengajuan').textContent = formatDate(p.tgl_pengajuan);
                        document.getElementById('modalPaketTglDistribusi').textContent = formatDate(p.tgl_distribusi);
                        document.getElementById('modalPaketTglTayang').textContent = formatDate(p.tgl_tayang);
                        document.getElementById('modalPaketCatatanVerif').textContent = p.catatan_verifikasi || 'Tidak ada catatan khusus.';
                        document.getElementById('modalPaketLpse').textContent = (parseInt(p.is_lpse) === 1) ? 'Sudah Dipublikasikan ke LPSE' : 'Belum / Non-LPSE';

                        // Winner section
                        const winnerSec = document.getElementById('modalWinnerSection');
                        if (p.nama_pemenang && p.nama_pemenang.trim() !== '') {
                            winnerSec.style.display = '';
                            document.getElementById('modalWinnerName').textContent = p.nama_pemenang;
                            document.getElementById('modalWinnerNpwp').textContent = p.npwp || '-';
                            document.getElementById('modalWinnerAddress').textContent = p.alamat || '-';
                            document.getElementById('modalWinnerLeader').textContent = p.nama_penanggung || '-';
                            document.getElementById('modalWinnerContract').textContent = formatRupiah(p.nilai_kontrak || 0);
                            document.getElementById('modalWinnerLetterNo').textContent = p.no_surat || '-';
                            document.getElementById('modalWinnerDate').textContent = formatDate(p.tgl_penetapan || p.tgl_surat);
                        } else {
                            winnerSec.style.display = 'none';
                        }

                        // Reset ke Tab 1 (Rincian Paket) saat membuka modal
                        const tabDetailLink = document.getElementById('tab-detail-link');
                        if (tabDetailLink) {
                            const bsTab = bootstrap.Tab.getOrCreateInstance(tabDetailLink);
                            bsTab.show();
                        }

                        // Muat daftar dokumen persyaratan untuk paket ini
                        loadSyarat(currentPaketId, currentPaketStatus);

                        const modal = new bootstrap.Modal(document.getElementById('detailPaketModal'));
                        modal.show();
                    } catch (e) {
                        console.error('Error parse paket detail:', e);
                    }
                });
            });

            // Filter logic
            function applyFilter() {
                const searchVal = (searchInput ? searchInput.value : '').toLowerCase().trim();
                const statusVal = statusFilter ? statusFilter.value : '';
                const verifVal = verifFilter ? verifFilter.value : '';
                const skpdVal = skpdFilter ? skpdFilter.value : '';

                filteredRows = allRows.filter(function (row) {
                    const noPaket = row.getAttribute('data-no-paket') || '';
                    const pkgName = row.getAttribute('data-package-name') || '';
                    const act = row.getAttribute('data-activity') || '';
                    const rpp = row.getAttribute('data-no-rpp') || '';
                    const skpd = row.getAttribute('data-skpd') || '';
                    const winner = row.getAttribute('data-winner') || '';
                    const stPaket = row.getAttribute('data-status-paket') || '';
                    const stVerif = row.getAttribute('data-status-verifikasi') || '';

                    const matchesSearch = !searchVal ||
                        noPaket.includes(searchVal) ||
                        pkgName.includes(searchVal) ||
                        act.includes(searchVal) ||
                        rpp.includes(searchVal) ||
                        skpd.includes(searchVal) ||
                        winner.includes(searchVal);

                    const matchesStatus = !statusVal || String(stPaket) === String(statusVal);
                    const matchesVerif = !verifVal || String(stVerif) === String(verifVal);
                    const matchesSkpd = !skpdVal || skpd.includes(skpdVal);

                    return matchesSearch && matchesStatus && matchesVerif && matchesSkpd;
                });

                currentPage = 1;
                renderPage();
            }

            // Pagination renderer
            function renderPage() {
                const totalFiltered = filteredRows.length;
                allRows.forEach(row => row.style.display = 'none');

                if (totalFiltered === 0) {
                    if (noResultsRow) noResultsRow.style.display = '';
                    if (paginationControls) paginationControls.style.display = 'none';
                    return;
                }

                if (noResultsRow) noResultsRow.style.display = 'none';
                if (paginationControls) paginationControls.style.display = '';

                let limit = (perPage === 'all') ? totalFiltered : parseInt(perPage);
                let totalPages = Math.ceil(totalFiltered / limit);
                if (currentPage > totalPages) currentPage = totalPages || 1;

                let startIndex = (currentPage - 1) * limit;
                let endIndex = Math.min(startIndex + limit, totalFiltered);

                for (let i = startIndex; i < endIndex; i++) {
                    if (filteredRows[i]) {
                        filteredRows[i].style.display = '';
                    }
                }

                if (showingStart) showingStart.textContent = totalFiltered ? (startIndex + 1) : 0;
                if (showingEnd) showingEnd.textContent = endIndex;
                if (showingTotal) showingTotal.textContent = totalFiltered;

                renderPaginationButtons(totalPages);
            }

            function renderPaginationButtons(totalPages) {
                if (!paginationList) return;
                paginationList.innerHTML = '';
                if (totalPages <= 1) return;

                const prevLi = document.createElement('li');
                prevLi.className = 'page-item ' + (currentPage === 1 ? 'disabled' : '');
                prevLi.innerHTML = `<a class="page-link" href="javascript:void(0);" aria-label="Previous">&laquo;</a>`;
                prevLi.addEventListener('click', function () {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                    }
                });
                paginationList.appendChild(prevLi);

                for (let p = 1; p <= totalPages; p++) {
                    if (totalPages > 7) {
                        if (p > 1 && p < currentPage - 1 && p !== 2) continue;
                        if (p < totalPages && p > currentPage + 1 && p !== totalPages - 1) continue;
                    }
                    const li = document.createElement('li');
                    li.className = 'page-item ' + (p === currentPage ? 'active' : '');
                    li.innerHTML = `<a class="page-link" href="javascript:void(0);">${p}</a>`;
                    li.addEventListener('click', function () {
                        currentPage = p;
                        renderPage();
                    });
                    paginationList.appendChild(li);
                }

                const nextLi = document.createElement('li');
                nextLi.className = 'page-item ' + (currentPage === totalPages ? 'disabled' : '');
                nextLi.innerHTML = `<a class="page-link" href="javascript:void(0);" aria-label="Next">&raquo;</a>`;
                nextLi.addEventListener('click', function () {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                    }
                });
                paginationList.appendChild(nextLi);
            }

            if (searchInput) searchInput.addEventListener('input', applyFilter);
            if (statusFilter) statusFilter.addEventListener('change', applyFilter);
            if (verifFilter) verifFilter.addEventListener('change', applyFilter);
            if (skpdFilter) skpdFilter.addEventListener('change', applyFilter);
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    perPage = this.value;
                    currentPage = 1;
                    renderPage();
                });
            }

            // Logika Form Tambah Paket Baru
            const selectRup = document.getElementById('selectRupId');
            const rupInfoBox = document.getElementById('rupInfoBox');
            const infoRupKegiatan = document.getElementById('infoRupKegiatan');
            const infoRupSkpdPpk = document.getElementById('infoRupSkpdPpk');
            const infoRupJenis = document.getElementById('infoRupJenis');
            const infoRupPagu = document.getElementById('infoRupPagu');
            const inputNilaiHps = document.getElementById('inputNilaiHps');
            const btnSalinPagu = document.getElementById('btnSalinPagu');
            const hpsExceedWarning = document.getElementById('hpsExceedWarning');
            const addPaketForm = document.getElementById('addPaketForm');
            const addPaketAlert = document.getElementById('addPaketAlert');
            const btnSubmitPaket = document.getElementById('btnSubmitPaket');

            let currentSelectedPagu = 0;

            function formatNumberRupiahInput(value) {
                const numbers = value.replace(/\D/g, '');
                if (!numbers) return '';
                return Number(numbers).toLocaleString('id-ID');
            }

            if (selectRup) {
                selectRup.addEventListener('change', function () {
                    const opt = this.options[this.selectedIndex];
                    if (!opt || !opt.value) {
                        if (rupInfoBox) rupInfoBox.classList.add('d-none');
                        if (btnSalinPagu) btnSalinPagu.classList.add('d-none');
                        currentSelectedPagu = 0;
                        return;
                    }

                    const pagu = parseFloat(opt.getAttribute('data-pagu') || 0);
                    currentSelectedPagu = pagu;

                    if (infoRupKegiatan) infoRupKegiatan.textContent = opt.getAttribute('data-activity') || '-';
                    if (infoRupSkpdPpk) infoRupSkpdPpk.textContent = (opt.getAttribute('data-skpd') || '-') + ' / ' + (opt.getAttribute('data-ppk') || '-');
                    if (infoRupJenis) infoRupJenis.textContent = opt.getAttribute('data-jenis') || 'Barang/Jasa';
                    if (infoRupPagu) infoRupPagu.textContent = formatRupiah(pagu);

                    if (rupInfoBox) rupInfoBox.classList.remove('d-none');
                    if (btnSalinPagu) btnSalinPagu.classList.remove('d-none');

                    checkHpsExceed();
                });
            }

            if (btnSalinPagu) {
                btnSalinPagu.addEventListener('click', function () {
                    if (currentSelectedPagu > 0 && inputNilaiHps) {
                        inputNilaiHps.value = Number(currentSelectedPagu).toLocaleString('id-ID');
                        checkHpsExceed();
                    }
                });
            }

            function checkHpsExceed() {
                if (!inputNilaiHps || !hpsExceedWarning) return;
                const hpsVal = parseFloat(inputNilaiHps.value.replace(/\D/g, '') || 0);
                if (currentSelectedPagu > 0 && hpsVal > currentSelectedPagu) {
                    hpsExceedWarning.classList.remove('d-none');
                    inputNilaiHps.classList.add('is-invalid');
                } else {
                    hpsExceedWarning.classList.add('d-none');
                    inputNilaiHps.classList.remove('is-invalid');
                }
            }

            if (inputNilaiHps) {
                inputNilaiHps.addEventListener('input', function () {
                    this.value = formatNumberRupiahInput(this.value);
                    checkHpsExceed();
                });
            }

            if (addPaketForm) {
                addPaketForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    if (addPaketAlert) {
                        addPaketAlert.classList.add('d-none');
                        addPaketAlert.innerHTML = '';
                    }

                    const formData = new FormData(this);
                    if (btnSubmitPaket) {
                        btnSubmitPaket.disabled = true;
                        btnSubmitPaket.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...';
                    }

                    fetch('/paket/store', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                    .then(res => {
                        if (res.status === 200 && res.body.status === 'success') {
                            window.location.reload();
                        } else {
                            if (addPaketAlert) {
                                addPaketAlert.innerHTML = res.body.message || 'Terjadi kesalahan saat menyimpan paket.';
                                addPaketAlert.classList.remove('d-none');
                            }
                            if (btnSubmitPaket) {
                                btnSubmitPaket.disabled = false;
                                btnSubmitPaket.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#check"></use></svg> <span>Simpan Draf Paket</span>';
                            }
                        }
                    })
                    .catch(err => {
                        console.error('Submit error:', err);
                        addPaketForm.submit();
                    });
                });
            }

            // ==========================================
            // LOGIKA TABULASI DOKUMEN PERSYARATAN (SYARAT)
            // ==========================================
            const tbodySyarat = document.getElementById('tbodySyarat');
            const tfootSyarat = document.getElementById('tfootSyarat');
            const syaratLoading = document.getElementById('syaratLoading');
            const syaratTableWrapper = document.getElementById('syaratTableWrapper');
            const badgeSyaratPending = document.getElementById('badgeSyaratPending');
            const badgeSyaratLengkap = document.getElementById('badgeSyaratLengkap');
            const syaratActionAlertError = document.getElementById('syaratActionAlertError');
            const syaratActionAlertSuccess = document.getElementById('syaratActionAlertSuccess');
            const inputUploadSingleSyarat = document.getElementById('inputUploadSingleSyarat');
            const btnUploadNewSyarat = document.getElementById('btnUploadNewSyarat');
            const inputNewSyaratName = document.getElementById('inputNewSyaratName');
            const inputNewSyaratFile = document.getElementById('inputNewSyaratFile');
            const checkNewSyaratHps = document.getElementById('checkNewSyaratHps');

            function resetSyaratAlerts() {
                if (syaratActionAlertError) {
                    syaratActionAlertError.classList.add('d-none');
                    syaratActionAlertError.innerHTML = '';
                }
                if (syaratActionAlertSuccess) {
                    syaratActionAlertSuccess.classList.add('d-none');
                    syaratActionAlertSuccess.innerHTML = '';
                }
            }

            function showSyaratAlert(type, message) {
                resetSyaratAlerts();
                if (type === 'error' && syaratActionAlertError) {
                    syaratActionAlertError.innerHTML = message;
                    syaratActionAlertError.classList.remove('d-none');
                } else if (type === 'success' && syaratActionAlertSuccess) {
                    syaratActionAlertSuccess.innerHTML = message;
                    syaratActionAlertSuccess.classList.remove('d-none');
                }
            }

            function loadSyarat(paketId, statusPaket) {
                if (!paketId) return;
                resetSyaratAlerts();

                if (syaratLoading) syaratLoading.classList.remove('d-none');
                if (syaratTableWrapper) syaratTableWrapper.classList.add('d-none');

                fetch('/paket/syarat/' + paketId)
                    .then(response => response.json())
                    .then(res => {
                        if (syaratLoading) syaratLoading.classList.add('d-none');
                        if (syaratTableWrapper) syaratTableWrapper.classList.remove('d-none');

                        if (res.status !== 'success') {
                            showSyaratAlert('error', res.message || 'Gagal memuat dokumen persyaratan.');
                            return;
                        }

                        currentSyaratSummary = res.summary || null;
                        const data = res.data || [];

                        // Update indikator badge pada tab
                        if (currentSyaratSummary) {
                            if (currentSyaratSummary.is_lengkap) {
                                if (badgeSyaratPending) badgeSyaratPending.classList.add('d-none');
                                if (badgeSyaratLengkap) {
                                    badgeSyaratLengkap.classList.remove('d-none');
                                    badgeSyaratLengkap.textContent = `Lengkap (${currentSyaratSummary.wajib_uploaded}/${currentSyaratSummary.total_wajib})`;
                                }
                            } else {
                                if (badgeSyaratLengkap) badgeSyaratLengkap.classList.add('d-none');
                                if (badgeSyaratPending) {
                                    badgeSyaratPending.classList.remove('d-none');
                                    badgeSyaratPending.textContent = `${currentSyaratSummary.missing_wajib.length} Wajib Belum Upload`;
                                }
                            }
                        }

                        // Sembunyikan form tambah syarat jika status paket sudah diajukan (bukan draf / 1)
                        if (tfootSyarat) {
                            if (statusPaket === 1) {
                                tfootSyarat.classList.remove('d-none');
                            } else {
                                tfootSyarat.classList.add('d-none');
                            }
                        }

                        // Render baris tabel
                        if (tbodySyarat) {
                            tbodySyarat.innerHTML = '';
                            if (data.length === 0) {
                                tbodySyarat.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">Belum ada dokumen persyaratan.</td></tr>`;
                                return;
                            }

                            data.forEach((item, index) => {
                                const isWajib = parseInt(item.wajib) === 1;
                                const isHps = parseInt(item.hps) === 1;
                                const isAuto = parseInt(item.auto) === 1;
                                const isUploaded = item.is_uploaded && item.nama_file;

                                const tr = document.createElement('tr');
                                if (isWajib && !isUploaded) {
                                    tr.className = 'table-warning bg-opacity-25';
                                }

                                // Kolom No
                                const tdNo = `<td class="text-center fw-semibold text-muted">${index + 1}</td>`;

                                // Kolom Nama Persyaratan & Badges
                                let badgeSifat = isWajib 
                                    ? `<span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-nano">Wajib</span>` 
                                    : `<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fs-nano">Tidak Wajib</span>`;
                                
                                let badgeHps = isHps 
                                    ? `<span class="badge bg-danger text-white border fs-nano ms-1" title="Dokumen ini bersifat rahasia">Rahasia</span>` 
                                    : '';

                                const tdNama = `
                                    <td>
                                        <div class="fw-semibold text-body-emphasis mb-1">${escapeHtml(item.nama_persyaratan)}</div>
                                        <div class="d-flex align-items-center gap-1 flex-wrap">
                                            ${badgeSifat}
                                            ${badgeHps}
                                            ${!isAuto ? `<span class="badge bg-info-subtle text-info border border-info-subtle fs-nano">Tambahan PPK</span>` : ''}
                                        </div>
                                    </td>`;

                                // Kolom Sifat Text
                                const tdSifat = `
                                    <td class="text-center">
                                        <span class="fs-xs fw-semibold ${isWajib ? 'text-danger' : 'text-muted'}">
                                            ${isWajib ? 'Wajib' : 'Opsional'}
                                        </span>
                                    </td>`;

                                // Kolom Format
                                let formatText = '<span class="text-muted">Bebas</span>';
                                if (item.format && item.format.trim() !== '') {
                                    const fmtArray = item.format.split(',').map(f => '.' + f.trim());
                                    formatText = `<span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-nano font-monospace">${fmtArray.join(', ')}</span>`;
                                }
                                const tdFormat = `<td>${formatText}</td>`;

                                // Kolom File Terunggah
                                let fileContent = '';
                                if (isUploaded) {
                                    fileContent = `
                                        <div>
                                            <a href="/paket/syarat/download/${item.id}" target="_blank" class="fw-bold font-monospace text-primary text-decoration-none d-inline-flex align-items-center gap-1 text-break" title="Unduh / Buka Dokumen">
                                                <svg class="sa-icon text-primary flex-shrink-0" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#file-text"></use></svg>
                                                <span>${escapeHtml(item.nama_file)}</span>
                                            </a>
                                            <div class="fs-nano text-success mt-1">
                                                <svg class="sa-icon text-success me-1" style="width: 11px; height: 11px;"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                                Terunggah
                                            </div>
                                        </div>`;
                                } else {
                                    fileContent = `
                                        <div class="text-muted fst-italic">
                                            <span class="badge ${isWajib ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary'} border fs-nano">
                                                Belum Ada File
                                            </span>
                                        </div>`;
                                }
                                const tdFile = `<td>${fileContent}</td>`;

                                // Kolom Aksi
                                let actionButtons = '';
                                if (statusPaket === 1) {
                                    if (isUploaded) {
                                        actionButtons = `
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <button type="button" class="btn btn-xs btn-outline-primary btn-ganti-syarat" data-id="${item.id}" data-name="${escapeHtml(item.nama_persyaratan)}" data-format="${escapeHtml(item.format || '')}" title="Ganti File">
                                                    Ganti
                                                </button>
                                                <button type="button" class="btn btn-xs btn-outline-danger btn-hapus-syarat" data-id="${item.id}" data-name="${escapeHtml(item.nama_persyaratan)}" data-auto="${item.auto}" title="Hapus File Dokumen">
                                                    <svg class="sa-icon" style="width: 11px; height: 11px;"><use href="/icons/sprite.svg#trash-2"></use></svg>
                                                </button>
                                            </div>`;
                                    } else {
                                        actionButtons = `
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <button type="button" class="btn btn-xs btn-primary btn-upload-single-syarat d-inline-flex align-items-center gap-1" data-id="${item.id}" data-name="${escapeHtml(item.nama_persyaratan)}" data-format="${escapeHtml(item.format || '')}">
                                                    <svg class="sa-icon" style="width: 12px; height: 12px;"><use href="/icons/sprite.svg#upload"></use></svg>
                                                    <span>Upload</span>
                                                </button>
                                                ${!isAuto ? `
                                                <button type="button" class="btn btn-xs btn-outline-danger btn-hapus-syarat" data-id="${item.id}" data-name="${escapeHtml(item.nama_persyaratan)}" data-auto="${item.auto}" title="Hapus Persyaratan Tambahan">
                                                    <svg class="sa-icon" style="width: 11px; height: 11px;"><use href="/icons/sprite.svg#trash-2"></use></svg>
                                                </button>` : ''}
                                            </div>`;
                                    }
                                } else {
                                    if (isUploaded) {
                                        actionButtons = `
                                            <a href="/paket/syarat/download/${item.id}" target="_blank" class="btn btn-xs btn-outline-primary d-inline-flex align-items-center gap-1">
                                                <svg class="sa-icon" style="width: 12px; height: 12px;"><use href="/icons/sprite.svg#download"></use></svg>
                                                Unduh
                                            </a>`;
                                    } else {
                                        actionButtons = `<span class="fs-nano text-muted">Terkunci</span>`;
                                    }
                                }
                                const tdAksi = `<td class="text-end text-nowrap">${actionButtons}</td>`;

                                tr.innerHTML = tdNo + tdNama + tdSifat + tdFormat + tdFile + tdAksi;
                                tbodySyarat.appendChild(tr);
                            });

                            attachSyaratActionListeners();
                        }
                    })
                    .catch(err => {
                        console.error('loadSyarat error:', err);
                        if (syaratLoading) syaratLoading.classList.add('d-none');
                        if (syaratTableWrapper) syaratTableWrapper.classList.remove('d-none');
                        showSyaratAlert('error', 'Terjadi kesalahan jaringan saat memuat daftar dokumen persyaratan.');
                    });
            }

            function escapeHtml(str) {
                if (!str) return '';
                return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            }

            function attachSyaratActionListeners() {
                // Tombol Upload / Ganti file per baris
                document.querySelectorAll('.btn-upload-single-syarat, .btn-ganti-syarat').forEach(btn => {
                    btn.addEventListener('click', function () {
                        activeUploadSyaratId = this.getAttribute('data-id');
                        const format = this.getAttribute('data-format') || '';
                        if (inputUploadSingleSyarat) {
                            if (format) {
                                const acceptExts = format.split(',').map(f => '.' + f.trim()).join(',');
                                inputUploadSingleSyarat.setAttribute('accept', acceptExts);
                            } else {
                                inputUploadSingleSyarat.removeAttribute('accept');
                            }
                            inputUploadSingleSyarat.value = '';
                            inputUploadSingleSyarat.click();
                        }
                    });
                });

                // Tombol Hapus file / syarat
                document.querySelectorAll('.btn-hapus-syarat').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const id = this.getAttribute('data-id');
                        const name = this.getAttribute('data-name');
                        const isAuto = parseInt(this.getAttribute('data-auto')) === 1;

                        const confirmPrompt = isAuto
                            ? `Hapus file dokumen terunggah untuk "${name}"?`
                            : `Hapus seluruh persyaratan tambahan "${name}"?`;

                        if (!confirm(confirmPrompt)) return;

                        fetch(`/paket/syarat/delete/${id}`, {
                            method: 'POST',
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(r => r.json())
                        .then(res => {
                            if (res.status === 'success') {
                                showSyaratAlert('success', res.message || 'Dokumen berhasil dihapus.');
                                loadSyarat(currentPaketId, currentPaketStatus);
                            } else {
                                showSyaratAlert('error', res.message || 'Gagal menghapus dokumen.');
                            }
                        })
                        .catch(err => {
                            console.error('Delete error:', err);
                            showSyaratAlert('error', 'Terjadi kesalahan server saat menghapus dokumen.');
                        });
                    });
                });
            }

            // Event listener saat file dipilih untuk upload baris tertentu
            if (inputUploadSingleSyarat) {
                inputUploadSingleSyarat.addEventListener('change', function () {
                    if (!this.files || this.files.length === 0 || !activeUploadSyaratId) return;

                    const file = this.files[0];
                    const formData = new FormData();
                    formData.append('id', activeUploadSyaratId);
                    formData.append('file', file);

                    showSyaratAlert('success', '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Sedang mengunggah dokumen...');

                    fetch('/paket/syarat/upload', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                    .then(res => {
                        if (res.status === 200 && res.body.status === 'success') {
                            showSyaratAlert('success', res.body.message || 'Dokumen berhasil diunggah.');
                            loadSyarat(currentPaketId, currentPaketStatus);
                        } else {
                            showSyaratAlert('error', res.body.message || 'Gagal mengunggah dokumen.');
                        }
                    })
                    .catch(err => {
                        console.error('Upload error:', err);
                        showSyaratAlert('error', 'Terjadi kesalahan jaringan atau server saat mengunggah file.');
                    });
                });
            }

            // Event listener Upload Syarat Tambahan (auto = 0)
            if (btnUploadNewSyarat) {
                btnUploadNewSyarat.addEventListener('click', function () {
                    const name = inputNewSyaratName ? inputNewSyaratName.value.trim() : '';
                    const file = inputNewSyaratFile && inputNewSyaratFile.files ? inputNewSyaratFile.files[0] : null;
                    const isHps = checkNewSyaratHps && checkNewSyaratHps.checked ? 1 : 0;

                    if (!name) {
                        alert('Silakan ketik Nama Persyaratan Tambahan terlebih dahulu.');
                        if (inputNewSyaratName) inputNewSyaratName.focus();
                        return;
                    }

                    if (!file) {
                        alert('Silakan pilih file dokumen persyaratan yang ingin diunggah.');
                        if (inputNewSyaratFile) inputNewSyaratFile.focus();
                        return;
                    }

                    const formData = new FormData();
                    formData.append('paket_id', currentPaketId);
                    formData.append('nama_persyaratan', name);
                    formData.append('hps', isHps);
                    formData.append('file', file);

                    btnUploadNewSyarat.disabled = true;
                    btnUploadNewSyarat.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Mengunggah...';

                    fetch('/paket/syarat/upload2', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                    .then(res => {
                        btnUploadNewSyarat.disabled = false;
                        btnUploadNewSyarat.innerHTML = '<svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#upload"></use></svg> <span>Upload</span>';

                        if (res.status === 200 && res.body.status === 'success') {
                            if (inputNewSyaratName) inputNewSyaratName.value = '';
                            if (inputNewSyaratFile) inputNewSyaratFile.value = '';
                            if (checkNewSyaratHps) checkNewSyaratHps.checked = false;

                            showSyaratAlert('success', res.body.message || 'Persyaratan baru berhasil ditambahkan.');
                            loadSyarat(currentPaketId, currentPaketStatus);
                        } else {
                            showSyaratAlert('error', res.body.message || 'Gagal menambahkan persyaratan.');
                        }
                    })
                    .catch(err => {
                        console.error('Upload2 error:', err);
                        btnUploadNewSyarat.disabled = false;
                        btnUploadNewSyarat.innerHTML = '<svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#upload"></use></svg> <span>Upload</span>';
                        showSyaratAlert('error', 'Terjadi kesalahan saat mengunggah persyaratan baru.');
                    });
                });
            }

            // Modal Warning Persyaratan Belum Lengkap
            const modalSyaratEl = document.getElementById('modalSyaratBelumLengkap');
            let bsModalSyaratIncomplete = null;

            if (modalSyaratEl) {
                // Konfigurasi z-index agar tampil mulus di atas detailPaketModal
                modalSyaratEl.addEventListener('show.bs.modal', function () {
                    modalSyaratEl.style.zIndex = '1065';
                    setTimeout(() => {
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        if (backdrops.length > 1) {
                            backdrops[backdrops.length - 1].style.zIndex = '1060';
                        }
                    }, 10);
                });

                modalSyaratEl.addEventListener('hidden.bs.modal', function () {
                    // Pastikan detailPaketModal tetap interaktif dan body tetap modal-open
                    const detailModal = document.getElementById('detailPaketModal');
                    if (detailModal && detailModal.classList.contains('show')) {
                        document.body.classList.add('modal-open');
                    }
                });

                // Tombol "Lengkapi Dokumen Sekarang" di modal peringatan
                const btnGoToUpload = document.getElementById('btnGoToUploadSyarat');
                if (btnGoToUpload) {
                    btnGoToUpload.addEventListener('click', function () {
                        // Tutup modal peringatan
                        const modalInstance = bootstrap.Modal.getInstance(modalSyaratEl);
                        if (modalInstance) {
                            modalInstance.hide();
                        }

                        // Pindah ke Tab Dokumen Persyaratan pada detailPaketModal
                        const tabSyaratLink = document.getElementById('tab-syarat-link');
                        if (tabSyaratLink) {
                            const bsTab = bootstrap.Tab.getOrCreateInstance(tabSyaratLink);
                            bsTab.show();
                        }

                        // Berikan efek highlight visual pada dokumen yang belum diunggah
                        highlightMissingSyaratRows();
                    });
                }
            }

            function openModalSyaratBelumLengkap(missingList, paketTitle) {
                if (!modalSyaratEl) return;

                const nameEl = document.getElementById('modalSyaratPaketName');
                if (nameEl) {
                    nameEl.textContent = paketTitle || 'Paket Pengadaan';
                }

                const countBadge = document.getElementById('modalSyaratCountBadge');
                const listEl = document.getElementById('modalSyaratMissingList');

                const totalMissing = missingList ? missingList.length : 0;
                if (countBadge) {
                    countBadge.textContent = `${totalMissing} Belum Diunggah`;
                }

                if (listEl) {
                    listEl.innerHTML = '';
                    if (totalMissing === 0) {
                        listEl.innerHTML = `
                            <div class="p-3 text-center text-muted fs-sm">
                                Tidak ada dokumen wajib yang terdeteksi belum diunggah.
                            </div>`;
                    } else {
                        missingList.forEach((item) => {
                            const itemName = typeof item === 'string' ? item : (item.nama_persyaratan || 'Dokumen Persyaratan');
                            const div = document.createElement('div');
                            div.className = 'list-group-item syarat-missing-item d-flex align-items-center justify-content-between py-2 px-3 bg-transparent border-bottom';
                            div.innerHTML = `
                                <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                                    <div class="text-danger flex-shrink-0">
                                        <svg class="sa-icon text-danger" style="width: 15px; height: 15px;">
                                            <use href="/icons/sprite.svg#x-circle"></use>
                                        </svg>
                                    </div>
                                    <div class="text-truncate">
                                        <div class="fw-semibold text-body-emphasis fs-sm text-truncate" title="${escapeHtml(itemName)}">
                                            ${escapeHtml(itemName)}
                                        </div>
                                        <div class="fs-nano text-muted">Dokumen Persyaratan Wajib PPK</div>
                                    </div>
                                </div>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-nano flex-shrink-0">
                                    Belum Ada File
                                </span>`;
                            listEl.appendChild(div);
                        });
                    }
                }

                if (!bsModalSyaratIncomplete) {
                    bsModalSyaratIncomplete = new bootstrap.Modal(modalSyaratEl);
                }
                bsModalSyaratIncomplete.show();
            }

            function highlightMissingSyaratRows() {
                const warningRows = document.querySelectorAll('#tbodySyarat tr.table-warning');
                warningRows.forEach(row => {
                    row.classList.add('row-syarat-highlight');
                    setTimeout(() => {
                        row.classList.remove('row-syarat-highlight');
                    }, 3000);
                });
            }

            // Handler Tombol Ajukan Paket (Hanya dari Modal Detail)
            function handleAjukanPaket(paketId, paketName) {
                if (!paketId) return;

                // VALIDASI SYARAT WAJIB LENGKAP
                if (currentSyaratSummary && !currentSyaratSummary.is_lengkap) {
                    const missingList = currentSyaratSummary.missing_wajib || [];
                    
                    // Tampilkan modal yang menarik (bukan alert native browser)
                    openModalSyaratBelumLengkap(missingList, paketName);

                    // Beri alert juga di dalam tab Dokumen Persyaratan
                    showSyaratAlert('error', `<strong>Pengajuan Gagal!</strong> Harap lengkapi ${missingList.length} dokumen wajib berikut sebelum mengajukan:<br>&bull; ` + missingList.join('<br>&bull; '));
                    return;
                }

                const confirmText = `Seluruh dokumen persyaratan wajib telah lengkap diunggah.\n\nApakah Anda yakin ingin mengajukan paket pengadaan ini ke UKPBJ?\n\n"${paketName || 'Paket Pengadaan'}"\n\nSetelah diajukan:\n1. Nomor paket baru akan digenerate otomatis (+1).\n2. Status paket berubah menjadi Diajukan (2).\n3. Data RUP terkait akan dikunci (rup_status = 2).`;

                if (!confirm(confirmText)) {
                    return;
                }

                const modalBtnAjukan = document.getElementById('modalBtnAjukan');
                if (modalBtnAjukan) {
                    modalBtnAjukan.disabled = true;
                    modalBtnAjukan.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...';
                }

                fetch(`/paket/ajukan/${paketId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.status === 200 && res.body.status === 'success') {
                        alert(res.body.message || 'Paket pengadaan berhasil diajukan ke UKPBJ!');
                        window.location.reload();
                    } else {
                        if (modalBtnAjukan) {
                            modalBtnAjukan.disabled = false;
                            modalBtnAjukan.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#send"></use></svg> <span>Ajukan Paket</span>';
                        }
                        // Jika gagal karena syarat belum lengkap (HTTP 422)
                        if (res.status === 422) {
                            const missingList = res.body.missing_syarat || (currentSyaratSummary ? currentSyaratSummary.missing_wajib : []);
                            openModalSyaratBelumLengkap(missingList, paketName);

                            const tabSyaratLink = document.getElementById('tab-syarat-link');
                            if (tabSyaratLink) {
                                const bsTab = bootstrap.Tab.getOrCreateInstance(tabSyaratLink);
                                bsTab.show();
                            }
                            showSyaratAlert('error', res.body.message);
                        } else {
                            alert(res.body.message || 'Gagal mengajukan paket pengadaan.');
                        }
                    }
                })
                .catch(err => {
                    console.error('Ajukan error:', err);
                    alert('Terjadi kesalahan jaringan atau server saat mengajukan paket.');
                    if (modalBtnAjukan) {
                        modalBtnAjukan.disabled = false;
                        modalBtnAjukan.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#send"></use></svg> <span>Ajukan Paket</span>';
                    }
                });
            }

            renderPage();
        });
    </script>
</body>
</html>
