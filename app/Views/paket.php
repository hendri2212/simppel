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

        /* Modal Peringatan Dokumen Persyaratan Belum Lengkap & Konfirmasi Pengajuan / Aksi */
        #modalSyaratBelumLengkap,
        #modalKonfirmasiAjukanPaket,
        #wfConfirmActionModal {
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
        .modal-ajukan-icon-wrap {
            width: 74px;
            height: 74px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.14) 0%, rgba(16, 185, 129, 0.14) 100%);
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            position: relative;
            box-shadow: 0 0 0 8px rgba(37, 99, 235, 0.06);
            animation: pulse-syarat-alert 2.2s ease-in-out infinite;
        }
        .modal-ajukan-success-icon-wrap {
            width: 74px;
            height: 74px;
            background: rgba(16, 185, 129, 0.14);
            color: #10b981;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            position: relative;
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0.07);
            animation: pulse-syarat-alert 2s ease-in-out infinite;
        }
        .ajukan-step-badge {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            flex-shrink: 0;
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
        /* Status Pipeline Filter Pills */
        .status-pills-wrapper {
            background-color: var(--bs-tertiary-bg, rgba(0, 0, 0, 0.02));
            border-radius: 0.5rem;
            padding: 0.6rem 0.8rem;
            border: 1px solid var(--bs-border-color-translucent, #e2e8f0);
        }
        .status-pill-btn {
            font-size: 0.8rem;
            font-weight: 500;
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            border: 1px solid var(--bs-border-color, #cbd5e1);
            background-color: var(--bs-body-bg, #ffffff);
            color: var(--bs-body-color, #334155);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.18s ease-in-out;
            cursor: pointer;
            text-decoration: none;
            user-select: none;
            white-space: nowrap;
        }
        .status-pill-btn:hover {
            border-color: var(--bs-primary, #0d6efd);
            color: var(--bs-primary, #0d6efd);
            transform: translateY(-1px);
        }
        .status-pill-btn.active {
            background-color: var(--bs-primary, #0d6efd);
            border-color: var(--bs-primary, #0d6efd);
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(13, 110, 253, 0.25);
        }
        .status-pill-btn.active .badge-count {
            background-color: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
        }
        .status-pill-btn .badge-count {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.15rem 0.45rem;
            border-radius: 1rem;
        }
        .status-pill-btn.is-zero {
            opacity: 0.55;
        }
        .status-pill-btn.is-zero:hover {
            opacity: 1;
        }
        .status-pill-btn.pill-danger {
            border-color: rgba(220, 53, 69, 0.35);
        }
        .status-pill-btn.pill-danger:hover {
            border-color: #dc3545;
            color: #dc3545;
        }
        .status-pill-btn.pill-danger.active {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .status-pill-btn.pill-warning {
            border-color: rgba(255, 193, 7, 0.45);
        }
        .status-pill-btn.pill-warning:hover {
            border-color: #d97706;
            color: #b45309;
        }
        .status-pill-btn.pill-warning.active {
            background-color: #d97706;
            border-color: #d97706;
        }
        .status-pill-btn.pill-success {
            border-color: rgba(25, 135, 84, 0.35);
        }
        .status-pill-btn.pill-success:hover {
            border-color: #198754;
            color: #198754;
        }
        .status-pill-btn.pill-success.active {
            background-color: #198754;
            border-color: #198754;
        }
        .status-pill-btn.pill-info {
            border-color: rgba(13, 202, 240, 0.35);
        }
        .status-pill-btn.pill-info:hover {
            border-color: #0891b2;
            color: #0891b2;
        }
        .status-pill-btn.pill-info.active {
            background-color: #0891b2;
            border-color: #0891b2;
        }
        .status-pill-btn.pill-purple {
            border-color: rgba(147, 51, 234, 0.35);
        }
        .status-pill-btn.pill-purple:hover {
            border-color: #7e22ce;
            color: #7e22ce;
        }
        .status-pill-btn.pill-purple.active {
            background-color: #7e22ce;
            border-color: #7e22ce;
        }

        [data-bs-theme="dark"] .status-pills-wrapper {
            background-color: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.1);
        }
        [data-bs-theme="dark"] .status-pill-btn {
            background-color: var(--bs-body-bg, #1e293b);
            border-color: rgba(255, 255, 255, 0.12);
            color: #e2e8f0;
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
            body:has(#detailPaketModal.show) .app-wrap,
            .modal-backdrop,
            .modal:not(#detailPaketModal) {
                display: none !important;
            }

            #detailPaketModal {
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

            #detailPaketModal .modal-dialog {
                max-width: 100% !important;
                width: 100% !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                transform: none !important;
                display: block !important;
            }

            /* Matikan pseudo-element 100vh milik .modal-dialog-centered yang memicu lembar ke-2 kosong */
            #detailPaketModal .modal-dialog-centered::before {
                display: none !important;
                height: 0 !important;
                content: none !important;
            }

            #detailPaketModal .modal-content {
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
            }

            #detailPaketModal .modal-header,
            #detailPaketModal .modal-footer,
            #detailPaketModal .btn-close,
            #detailPaketTabs {
                display: none !important;
            }

            #detailPaketModal .modal-body {
                padding: 0.5rem 0 !important;
                overflow: visible !important;
            }

            #detailPaketModal .tab-content > .tab-pane:not(.active) {
                display: none !important;
            }

            #detailPaketModal .tab-content > .tab-pane.active {
                display: block !important;
            }

            #detailPaketModal .card,
            #detailPaketModal .rounded-2,
            #detailPaketModal #modalWinnerSection {
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

                    // Deteksi Role Pengguna saat ini
                    $currentUserId = (int) (session()->get('user_id') ?? ($currentUser['id'] ?? 0));
                    $currentRoleId = (int) (session()->get('role_id') ?? ($currentUser['role_id'] ?? 0));
                    $currentRoleName = strtoupper(trim((string) (session()->get('role_name') ?? ($currentUser['role_name'] ?? ''))));
                    
                    // Kategori Role: apakah Admin ULP / Pusat atau PPK
                    $isStrictAdminUlp = ($currentRoleId === 4 || $currentRoleName === 'ADMIN ULP');
                    $isAdminUlp = in_array($currentRoleName, ['ADMIN ULP', 'ADMINISTRATOR', 'KEPALA ULP', 'DISTRIBUSI'], true);
                    $isPpk = in_array($currentRoleName, ['PPK', 'ADMIN PPK'], true) || !$isAdminUlp;
                    $canWritePaket = ! $isStrictAdminUlp && in_array($currentRoleName, \App\Controllers\PaketController::WRITE_ROLES, true);
                    $canAjukanPaket = $canAjukanPaket ?? in_array($currentRoleName, ['ADMINISTRATOR', 'PPK'], true);
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
                                <?php if (! $isStrictAdminUlp): ?>
                                <div class="panel-toolbar d-flex align-items-center gap-2">
                                    <?php if ($canWritePaket): ?>
                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addPaketModal">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#plus"></use>
                                        </svg>
                                        <span>Tambah Paket</span>
                                    </button>
                                    <?php endif; ?>
                                    <a href="/rup" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#arrow-left"></use>
                                        </svg>
                                        <span>Lihat RUP</span>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="panel-container show">
                                <div class="panel-content">

                                    <!-- Status Pipeline Filter Pills (Role-Based Quick Status & Count) -->
                                    <div class="status-pills-wrapper mb-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <svg class="sa-icon text-primary" style="width: 16px; height: 16px;">
                                                    <use href="/icons/sprite.svg#filter"></use>
                                                </svg>
                                                <span class="fs-xs fw-bold text-uppercase text-secondary" style="letter-spacing: 0.5px;">
                                                    Filter Cepat Antrean (<?= esc($currentRoleName ?: 'Pengguna') ?>)
                                                </span>
                                            </div>
                                            <div class="fs-nano text-muted">
                                                Klik untuk memfilter instan &bull; Angka menunjukkan total paket
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2 align-items-center" id="statusPillsContainer">
                                            <!-- Pill: Semua Paket -->
                                            <button type="button" class="status-pill-btn active" data-filter-type="all">
                                                <span>Semua Paket</span>
                                                <span class="badge bg-secondary badge-count" id="countPillAll"><?= count($pakets) ?></span>
                                            </button>

                                            <?php if (in_array($currentRoleName, ['ADMIN ULP', 'ADMINISTRATOR'], true)): ?>
                                                <!-- 5 Tab Antrean Admin ULP -->
                                                <button type="button" class="status-pill-btn pill-warning" data-filter-type="ulp_daftar" title="Antrean bersama paket baru dari PPK yang belum diambil Admin ULP (status = 2, admin_ulp = kosong)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#inbox"></use></svg>
                                                    <span>Daftar</span>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis badge-count" id="countPillUlpDaftar">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-purple" data-filter-type="ulp_verifikasi" data-user-id="<?= $currentUserId ?>" title="Paket yang sedang diperiksa oleh Anda (status = 2, admin_ulp = Anda)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#user-check"></use></svg>
                                                    <span>Verifikasi</span>
                                                    <span class="badge bg-purple-subtle text-purple badge-count" id="countPillUlpVerifikasi" style="background-color: rgba(147, 51, 234, 0.2); color: #7e22ce;">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-danger" data-filter-type="ulp_dikembalikan" data-user-id="<?= $currentUserId ?>" title="Paket yang dikembalikan ke PPK karena berkas belum lengkap / perlu revisi">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#corner-up-left"></use></svg>
                                                    <span>Dikembalikan</span>
                                                    <span class="badge bg-danger-subtle text-danger badge-count" id="countPillUlpDikembalikan">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-success" data-filter-type="ulp_diterima" data-user-id="<?= $currentUserId ?>" title="Paket yang sudah lolos verifikasi Admin ULP (status >= 4)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                                    <span>Diterima</span>
                                                    <span class="badge bg-success-subtle text-success badge-count" id="countPillUlpDiterima">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-info" data-filter-type="status" data-status-codes="0,9,12,14,15" title="Pemantauan paket tayang lelang atau hasil/selesai lelang">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#award"></use></svg>
                                                    <span>Hasil Lelang</span>
                                                    <span class="badge bg-info-subtle text-info badge-count" id="countPillUlpLelang">0</span>
                                                </button>

                                            <?php elseif ($currentRoleName === 'DISTRIBUSI'): ?>
                                                <!-- 5 Tab Antrean Admin Distribusi (submenu5) -->
                                                <button type="button" class="status-pill-btn" data-filter-type="status" data-status-codes="2,3,4,5,6,7,8,9,10,11,12,13,14,15" title="Semua paket yang sudah diajukan (status != 1)">
                                                    <span>Daftar</span>
                                                    <span class="badge bg-secondary badge-count" id="countPillDistDaftar">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-warning" data-filter-type="status" data-status-codes="4" title="Antrean kerja utama Admin Distribusi: Paket diterima Admin ULP & menunggu pemilihan Pokja (status = 4)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#users"></use></svg>
                                                    <span>Diterima</span>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis badge-count" id="countPillDistDiterima">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-purple" data-filter-type="status" data-status-codes="5" title="Paket yang sudah disarankan Pokjanya dan menunggu penetapan Kepala ULP (status = 5)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#send"></use></svg>
                                                    <span>Saran Distribusi</span>
                                                    <span class="badge bg-purple-subtle text-purple badge-count" id="countPillDistSaran" style="background-color: rgba(147, 51, 234, 0.2); color: #7e22ce;">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-success" data-filter-type="status" data-status-codes="6,7,8,9,10,11,12,13,14,15" title="Paket yang sudah terdistribusi ke Pokja (status >= 6)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                                    <span>Distribusi</span>
                                                    <span class="badge bg-success-subtle text-success badge-count" id="countPillDistTerdistribusi">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-info" data-filter-type="status" data-status-codes="12,14" title="Paket dengan hasil lelang / selesai (status 12, 14)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#award"></use></svg>
                                                    <span>Hasil Lelang</span>
                                                    <span class="badge bg-info-subtle text-info badge-count" id="countPillDistHasil">0</span>
                                                </button>

                                            <?php elseif ($currentRoleName === 'KEPALA ULP'): ?>
                                                <!-- 5 Tab Antrean Kepala ULP (submenu6) -->
                                                <button type="button" class="status-pill-btn" data-filter-type="status" data-status-codes="2,3,4,5,6,7,8,9,10,11,12,13,14,15" title="Semua paket yang sudah diajukan (status != 1)">
                                                    <span>Daftar</span>
                                                    <span class="badge bg-secondary badge-count" id="countPillDistDaftar">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-warning" data-filter-type="status" data-status-codes="5" title="Antrean kerja utama Kepala ULP: Usulan Pokja dari Admin Distribusi yang menunggu penetapan (status = 5)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#user-check"></use></svg>
                                                    <span>Saran Distribusi</span>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis badge-count" id="countPillDistSaran">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-success" data-filter-type="status" data-status-codes="6,7,8,9,10,11,12,13,14,15" title="Paket yang telah ditetapkan distribusinya (status >= 6)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                                    <span>Distribusi</span>
                                                    <span class="badge bg-success-subtle text-success badge-count" id="countPillDistTerdistribusi">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-purple" data-filter-type="status" data-status-codes="9" title="Paket yang sedang tayang lelang (status = 9)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#activity"></use></svg>
                                                    <span>Lelang</span>
                                                    <span class="badge bg-purple-subtle text-purple badge-count" id="countPillKulpLelang" style="background-color: rgba(147, 51, 234, 0.2); color: #7e22ce;">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-info" data-filter-type="status" data-status-codes="12,14" title="Paket dengan hasil lelang / selesai (status 12, 14)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#award"></use></svg>
                                                    <span>Hasil Lelang</span>
                                                    <span class="badge bg-info-subtle text-info badge-count" id="countPillDistHasil">0</span>
                                                </button>

                                            <?php elseif ($currentRoleName === 'POKJA'): ?>
                                                <!-- Tab Antrean Pokja (submenu7) - khusus paket yang menugaskan personil Pokja ini -->
                                                <button type="button" class="status-pill-btn pill-warning" data-filter-type="pokja_status" data-status-codes="6" title="Paket baru terdistribusi ke Pokja Anda untuk dikaji ulang / ditayangkan (status = 6)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#inbox"></use></svg>
                                                    <span>Distribusi</span>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis badge-count" id="countPillPokjaDistribusi">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-danger" data-filter-type="pokja_status" data-status-codes="7" title="Paket yang dikembalikan Pokja ke PPK untuk kaji ulang (status = 7)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#corner-up-left"></use></svg>
                                                    <span>Saran Kaji</span>
                                                    <span class="badge bg-danger-subtle text-danger badge-count" id="countPillPokjaSaranKaji">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-purple" data-filter-type="pokja_status" data-status-codes="8" title="Paket yang diajukan kembali oleh PPK pasca kaji ulang (status = 8)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#refresh-cw"></use></svg>
                                                    <span>Kaji Ulang</span>
                                                    <span class="badge bg-purple-subtle text-purple badge-count" id="countPillPokjaKaji" style="background-color: rgba(147, 51, 234, 0.2); color: #7e22ce;">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-info" data-filter-type="pokja_status" data-status-codes="9,10,11,13" title="Paket yang sedang dalam proses lelang / addendum / lelang ulang (status 9, 10, 11, 13)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#activity"></use></svg>
                                                    <span>Proses Lelang</span>
                                                    <span class="badge bg-info-subtle text-info badge-count" id="countPillPokjaLelang">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-success" data-filter-type="pokja_status" data-status-codes="12,14,15" title="Paket yang hasil lelangnya sudah dikirim / selesai (status 12, 14, 15)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#award"></use></svg>
                                                    <span>Hasil & Selesai</span>
                                                    <span class="badge bg-success-subtle text-success badge-count" id="countPillPokjaHasil">0</span>
                                                </button>

                                            <?php elseif ($currentRoleName === 'ADMIN AGENCY'): ?>
                                                <!-- 2 Tab Antrean Admin Agency (submenu8) -->
                                                <button type="button" class="status-pill-btn pill-warning" data-filter-type="agency_baru" title="Paket terdistribusi (status 6-14) yang belum dibuatkan Room LPSE (is_lpse = 0)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#inbox"></use></svg>
                                                    <span>Baru (Belum Room LPSE)</span>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis badge-count" id="countPillAgencyBaru">0</span>
                                                </button>
                                                <button type="button" class="status-pill-btn pill-success" data-filter-type="agency_sudah" title="Paket yang sudah diproses Room LPSE (is_lpse = 1)">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                                    <span>Sudah Proses (LPSE)</span>
                                                    <span class="badge bg-success-subtle text-success badge-count" id="countPillAgencySudah">0</span>
                                                </button>

                                            <?php else: /* TAMPILAN ROLE PPK / ADMIN PPK */ ?>

                                                <!-- Pill: Draft (Status 1) -->
                                                <button type="button" class="status-pill-btn pill-warning" data-filter-type="status" data-status-codes="1" title="Draf paket yang belum diajukan ke ULP">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#edit-3"></use></svg>
                                                    <span>Draft</span>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis badge-count" id="countPillDraft">0</span>
                                                </button>

                                                <!-- Pill: Dikembalikan (Status 3) -->
                                                <button type="button" class="status-pill-btn pill-danger" data-filter-type="status" data-status-codes="3" title="Berkas dikembalikan oleh Admin ULP untuk diperbaiki">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#corner-up-left"></use></svg>
                                                    <span>Dikembalikan</span>
                                                    <span class="badge bg-danger-subtle text-danger badge-count" id="countPillDikembalikan">0</span>
                                                </button>

                                                <!-- Pill: Saran Kaji Ulang (Status 7) -->
                                                <button type="button" class="status-pill-btn pill-warning" data-filter-type="status" data-status-codes="7" title="Catatan kaji ulang dari Pokja ke PPK">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#alert-circle"></use></svg>
                                                    <span>Saran Kaji Ulang</span>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis badge-count" id="countPillSaranKaji">0</span>
                                                </button>

                                                <!-- Pill: Saran Addendum (Status 10) -->
                                                <button type="button" class="status-pill-btn pill-warning" data-filter-type="status" data-status-codes="10" title="Ada telaah / saran adendum">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#file-text"></use></svg>
                                                    <span>Saran Addendum</span>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis badge-count" id="countPillSaranAdd">0</span>
                                                </button>

                                                <!-- Pill: Sedang Diproses (Status 2, 4, 5, 6, 8, 9, 11, 13) -->
                                                <button type="button" class="status-pill-btn pill-info" data-filter-type="status" data-status-codes="2,4,5,6,8,9,11,13" title="Sedang berjalan di UKPBJ / Pokja / Tayang Lelang">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#activity"></use></svg>
                                                    <span>Sedang Diproses</span>
                                                    <span class="badge bg-info-subtle text-info badge-count" id="countPillProses">0</span>
                                                </button>

                                                <!-- Pill: Hasil Lelang (Status 12) -->
                                                <button type="button" class="status-pill-btn pill-purple" data-filter-type="status" data-status-codes="12" title="Lelang tuntas, siap proses kontrak">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#award"></use></svg>
                                                    <span>Hasil Lelang</span>
                                                    <span class="badge bg-purple-subtle text-purple badge-count" id="countPillHasil" style="background-color: rgba(147, 51, 234, 0.2); color: #7e22ce;">0</span>
                                                </button>

                                                <!-- Pill: Paket Selesai (Status 14) -->
                                                <button type="button" class="status-pill-btn pill-success" data-filter-type="status" data-status-codes="14" title="Kontrak / SPK telah diinput dan pengadaan tuntas">
                                                    <svg class="sa-icon" style="width: 13px; height: 13px;"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                                    <span>Paket Selesai</span>
                                                    <span class="badge bg-success-subtle text-success badge-count" id="countPillSelesai">0</span>
                                                </button>

                                            <?php endif; ?>
                                        </div>
                                    </div>

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
                                                    <th class="text-end" style="width: 100px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pakets as $p): ?>
                                                    <?php
                                                    $paketJson = htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8');
                                                    $hasWinner = !empty($p['nama_pemenang']);
                                                    $canModifyPaket = $canWritePaket && (int) ($p['status_paket'] ?? 0) === 1;
                                                    $pokjaUserIdsCsv = implode(',', array_map('intval', array_column($p['pokja_members'] ?? [], 'user_id')));
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
                                                        data-status-verifikasi="<?= (int) ($p['status_verifikasi'] ?? 0) ?>"
                                                        data-admin-ukpbj-id="<?= (int) ($p['admin_ukpbj_id'] ?? 0) ?>"
                                                        data-is-lpse="<?= (int) ($p['is_lpse'] ?? 0) ?>"
                                                        data-pokja-users="<?= esc($pokjaUserIdsCsv) ?>">

                                                        <!-- No. Paket -->
                                                        <td>
                                                            <?php if (!empty($p['no_paket']) && (int) ($p['status_paket'] ?? 0) !== 1): ?>
                                                                <div class="font-monospace fw-bold text-primary fs-sm">
                                                                    <?= esc($p['no_paket']) ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-muted font-monospace fs-sm">-</div>
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
                                                            <div class="d-flex justify-content-end gap-1">
                                                                <button type="button" class="btn btn-sm btn-icon btn-light btn-view-paket" data-paket='<?= $paketJson ?>' title="Lihat Detail & Kelola Paket">
                                                                    <svg class="sa-icon text-primary" style="width: 14px; height: 14px;">
                                                                        <use href="/icons/sprite.svg#eye"></use>
                                                                    </svg>
                                                                </button>
                                                                <?php if (!empty($p['workflow_actions']) || $canModifyPaket): ?>
                                                                <div class="dropdown">
                                                                    <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-toggle="dropdown" aria-expanded="false" title="Pilihan Aksi">
                                                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                                            <use href="/icons/sprite.svg#more-horizontal"></use>
                                                                        </svg>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end fs-xs">
                                                                        <?php foreach (($p['workflow_actions'] ?? []) as $wa): ?>
                                                                            <li>
                                                                                <a class="dropdown-item d-flex align-items-center gap-2 btn-wf text-<?= esc($wa['variant']) ?><?= !empty($wa['blocked']) ? ' disabled' : '' ?>" href="javascript:void(0);"
                                                                                    data-id="<?= (int) $p['id'] ?>" data-action="<?= esc($wa['key']) ?>" data-label="<?= esc($wa['label']) ?>"
                                                                                    data-note="<?= esc((string) ($wa['note'] ?? '')) ?>" data-confirm="<?= esc($wa['confirm']) ?>"
                                                                                    data-paket='<?= $paketJson ?>'
                                                                                    <?php if (!empty($wa['blocked'])): ?>title="<?= esc($wa['blocked']) ?>"<?php endif; ?>>
                                                                                    <span><?= esc($wa['label']) ?></span>
                                                                                </a>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                        <?php if (!empty($p['workflow_actions']) && $canModifyPaket): ?><li><hr class="dropdown-divider"></li><?php endif; ?>
                                                                        <?php if ($canModifyPaket): ?>
                                                                            <li>
                                                                                <a class="dropdown-item d-flex align-items-center gap-2 btn-edit-paket" href="javascript:void(0);" data-paket='<?= $paketJson ?>'>
                                                                                    <svg class="sa-icon text-info" style="width: 14px; height: 14px;">
                                                                                        <use href="/icons/sprite.svg#edit-3"></use>
                                                                                    </svg>
                                                                                    <span>Ubah Paket</span>
                                                                                </a>
                                                                            </li>
                                                                            <li><hr class="dropdown-divider"></li>
                                                                            <li>
                                                                                <a class="dropdown-item text-danger d-flex align-items-center gap-2 btn-delete-paket" href="javascript:void(0);" data-paket='<?= $paketJson ?>'>
                                                                                    <svg class="sa-icon text-danger" style="width: 14px; height: 14px;">
                                                                                        <use href="/icons/sprite.svg#trash-2"></use>
                                                                                    </svg>
                                                                                    <span>Hapus Paket</span>
                                                                                </a>
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
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
                        <div class="text-muted fs-sm" id="modalPaketActivityWrap">
                            <svg class="sa-icon me-1 text-muted" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#layers"></use></svg>
                            <span id="modalPaketActivity">-</span>
                        </div>
                    </div>

                    <!-- Tabulasi Detail Paket: Rincian Paket, Dokumen Persyaratan, Catatan, Pokja, Dokumen Lelang, Hasil Lelang -->
                    <ul class="nav nav-tabs nav-tabs-clean border-0 gap-2 flex-wrap" id="detailPaketTabs" role="tablist">
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
                        <li class="nav-item d-none" role="presentation" id="navItemCatatanDetail">
                            <button class="nav-link fw-semibold d-flex align-items-center gap-2 px-3 py-2" id="tab-catatan-link" data-bs-toggle="tab" data-bs-target="#tabCatatanContent" type="button" role="tab" aria-controls="tabCatatanContent" aria-selected="false">
                                <svg class="sa-icon" style="width: 15px; height: 15px;"><use href="/icons/sprite.svg#message-square"></use></svg>
                                <span>Catatan</span>
                                <span class="badge bg-secondary rounded-pill fs-nano ms-1 d-none" id="badgeCatatanCount">0</span>
                            </button>
                        </li>
                        <li class="nav-item d-none" role="presentation" id="navItemPokjaDetail">
                            <button class="nav-link fw-semibold d-flex align-items-center gap-2 px-3 py-2" id="tab-pokja-link" data-bs-toggle="tab" data-bs-target="#tabPokjaContent" type="button" role="tab" aria-controls="tabPokjaContent" aria-selected="false">
                                <svg class="sa-icon" style="width: 15px; height: 15px;"><use href="/icons/sprite.svg#users"></use></svg>
                                <span>Pokja</span>
                                <span class="badge bg-secondary rounded-pill fs-nano ms-1 d-none" id="badgePokjaCount">0</span>
                            </button>
                        </li>
                        <li class="nav-item d-none" role="presentation" id="navItemDokumenDetail">
                            <button class="nav-link fw-semibold d-flex align-items-center gap-2 px-3 py-2" id="tab-dokumen-link" data-bs-toggle="tab" data-bs-target="#tabDokumenContent" type="button" role="tab" aria-controls="tabDokumenContent" aria-selected="false">
                                <svg class="sa-icon" style="width: 15px; height: 15px;"><use href="/icons/sprite.svg#folder"></use></svg>
                                <span>Dokumen Lelang</span>
                                <span class="badge bg-secondary rounded-pill fs-nano ms-1 d-none" id="badgeDokumenCount">0</span>
                            </button>
                        </li>
                        <li class="nav-item d-none" role="presentation" id="navItemHasilDetail">
                            <button class="nav-link fw-semibold d-flex align-items-center gap-2 px-3 py-2" id="tab-hasil-link" data-bs-toggle="tab" data-bs-target="#tabHasilContent" type="button" role="tab" aria-controls="tabHasilContent" aria-selected="false">
                                <svg class="sa-icon" style="width: 15px; height: 15px;"><use href="/icons/sprite.svg#award"></use></svg>
                                <span>Hasil Lelang</span>
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

                        <!-- TABULASI 3: CATATAN VERIFIKASI / REVISI -->
                        <div class="tab-pane fade" id="tabCatatanContent" role="tabpanel" aria-labelledby="tab-catatan-link">
                            <div class="alert alert-info py-2 px-3 mb-3 fs-xs d-flex align-items-center gap-2">
                                <svg class="sa-icon text-info flex-shrink-0" style="width: 16px; height: 16px;"><use href="/icons/sprite.svg#info"></use></svg>
                                <div>
                                    Tuliskan alasan pengembalian atau catatan kaji ulang di sini sebelum mengembalikan paket ke PPK. PPK dapat menjawab catatan ini setelah memperbaiki berkas.
                                </div>
                            </div>
                            <div class="alert d-none py-2 px-3 mb-3 fs-xs" id="detailCatatanAlert"></div>
                            <div id="detailCatatanBox" class="fs-sm">
                                <div class="text-muted">Memuat catatan...</div>
                            </div>
                        </div>

                        <!-- TABULASI 4: ANGGOTA POKJA PEMILIHAN -->
                        <div class="tab-pane fade" id="tabPokjaContent" role="tabpanel" aria-labelledby="tab-pokja-link">
                            <div class="alert alert-info py-2 px-3 mb-3 fs-xs d-flex align-items-center gap-2">
                                <svg class="sa-icon text-info flex-shrink-0" style="width: 16px; height: 16px;"><use href="/icons/sprite.svg#info"></use></svg>
                                <div>
                                    Pilih <strong>3, 5, atau 7 orang</strong> personil Kelompok Kerja (Pokja) beserta jabatannya sebelum menekan tombol <strong>Saran Distribusi</strong> (Admin Distribusi) atau <strong>Distribusi</strong> (Kepala ULP).
                                </div>
                            </div>
                            <div class="alert d-none py-2 px-3 mb-3 fs-xs" id="detailPokjaAlert"></div>
                            <div id="detailPokjaBox" class="fs-sm">
                                <div class="text-muted">Memuat susunan Pokja...</div>
                            </div>
                        </div>

                        <!-- TABULASI 5: DOKUMEN LELANG (POKJA) -->
                        <div class="tab-pane fade" id="tabDokumenContent" role="tabpanel" aria-labelledby="tab-dokumen-link">
                            <div class="alert alert-info py-2 px-3 mb-3 fs-xs d-flex align-items-center gap-2">
                                <svg class="sa-icon text-info flex-shrink-0" style="width: 16px; height: 16px;"><use href="/icons/sprite.svg#info"></use></svg>
                                <div>
                                    Unggah dokumen lelang oleh Pokja Pemilihan. Dokumen akan dikunci otomatis setelah hasil lelang dikirim ke PPK.
                                </div>
                            </div>
                            <div class="alert d-none py-2 px-3 mb-3 fs-xs" id="detailDokumenAlert"></div>
                            <div id="detailDokumenBox" class="fs-sm">
                                <div class="text-muted">Memuat dokumen lelang...</div>
                            </div>
                        </div>

                        <!-- TABULASI 6: INPUT HASIL LELANG / PEMENANG -->
                        <div class="tab-pane fade" id="tabHasilContent" role="tabpanel" aria-labelledby="tab-hasil-link">
                            <div class="alert d-none py-2 px-3 mb-3 fs-xs" id="detailHasilAlert"></div>
                            <div id="detailHasilBox" class="fs-sm"></div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="d-flex flex-wrap gap-2" id="modalWorkflowActionButtons"></div>
                    <div class="d-flex flex-wrap gap-2 ms-auto">
                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary btn-sm px-4 d-none align-items-center gap-1" id="modalBtnAjukan">
                            <svg class="sa-icon" style="width: 14px; height: 14px;">
                                <use href="/icons/sprite.svg#send"></use>
                            </svg>
                            <span>Ajukan Paket</span>
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm px-3 d-inline-flex align-items-center justify-content-center text-nowrap gap-2" onclick="printPaketDetail()">
                            <svg class="sa-icon" style="width: 15px; height: 15px;">
                                <use href="/icons/sprite.svg#printer"></use>
                            </svg>
                            <span>Cetak Lembar Paket</span>
                        </button>
                    </div>
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

    <!-- MODAL: Konfirmasi & Notifikasi Sukses Pengajuan Paket ke UKPBJ -->
    <div class="modal fade" id="modalKonfirmasiAjukanPaket" tabindex="-1" aria-labelledby="modalKonfirmasiAjukanPaketLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg overflow-hidden">
                <!-- Strip Aksen Gradien Biru-Emerald -->
                <div id="modalAjukanTopStrip" style="height: 5px; background: linear-gradient(90deg, #2563eb 0%, #0ea5e9 50%, #10b981 100%);"></div>

                <!-- STATE 1: KONFIRMASI PENGAJUAN -->
                <div class="modal-body p-4 text-center" id="ajukanConfirmBody">
                    <div class="modal-ajukan-icon-wrap mb-3">
                        <svg class="sa-icon text-primary" style="width: 34px; height: 34px;">
                            <use href="/icons/sprite.svg#send"></use>
                        </svg>
                    </div>

                    <div class="mb-2">
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fs-nano fw-semibold d-inline-flex align-items-center gap-1" id="modalAjukanSyaratBadge">
                            <svg class="sa-icon text-success" style="width: 12px; height: 12px;">
                                <use href="/icons/sprite.svg#check-circle"></use>
                            </svg>
                            <span>Seluruh Dokumen Wajib Lengkap</span>
                        </span>
                    </div>

                    <h5 class="modal-title fw-bold text-body-emphasis mb-1" id="modalKonfirmasiAjukanPaketLabel">
                        Ajukan Paket Pengadaan ke UKPBJ?
                    </h5>
                    <p class="text-secondary fs-sm mb-3 px-1">
                        Pastikan seluruh data dan dokumen persyaratan telah sesuai sebelum paket dikirimkan ke Admin UKPBJ.
                    </p>

                    <!-- Ringkasan Paket yang Akan Diajukan -->
                    <div class="card border bg-body-tertiary bg-opacity-50 rounded-3 mb-3 text-start shadow-2xs">
                        <div class="card-body p-3">
                            <div class="fs-nano text-uppercase text-muted fw-bold mb-1">Nama Paket Pengadaan</div>
                            <div class="fw-bold text-body-emphasis fs-sm mb-2" id="modalAjukanPaketName">-</div>
                            <div class="row g-2 pt-2 border-top">
                                <div class="col-6">
                                    <div class="fs-nano text-uppercase text-muted fw-semibold">Nomor RPP</div>
                                    <div class="font-monospace fs-xs fw-semibold text-body-emphasis text-truncate" id="modalAjukanPaketRpp">-</div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="fs-nano text-uppercase text-muted fw-semibold">Nilai HPS</div>
                                    <div class="font-monospace fs-xs fw-bold text-primary" id="modalAjukanPaketHps">Rp 0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tahapan Otomatis Setelah Diajukan -->
                    <div class="card border border-primary-subtle bg-primary-subtle bg-opacity-10 rounded-3 mb-0 text-start overflow-hidden">
                        <div class="card-header bg-primary-subtle bg-opacity-25 border-primary-subtle py-2 px-3 d-flex align-items-center gap-2">
                            <svg class="sa-icon text-primary" style="width: 14px; height: 14px;">
                                <use href="/icons/sprite.svg#shield"></use>
                            </svg>
                            <span class="fs-xs fw-bold text-primary-emphasis text-uppercase">Konsekuensi Setelah Paket Diajukan</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <span class="ajukan-step-badge bg-primary text-white">1</span>
                                <div class="fs-xs text-body">
                                    <strong>Nomor Paket Otomatis:</strong> Sistem akan menerbitkan nomor urut paket baru secara otomatis (<code>+1</code>).
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <span class="ajukan-step-badge bg-primary text-white">2</span>
                                <div class="fs-xs text-body">
                                    <strong>Perubahan Status:</strong> Status paket berubah menjadi <span class="badge bg-warning text-dark fs-nano">Diajukan (2)</span> untuk diverifikasi UKPBJ.
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <span class="ajukan-step-badge bg-primary text-white">3</span>
                                <div class="fs-xs text-body">
                                    <strong>Penguncian Data RUP:</strong> Data RUP terkait dan berkas persyaratan akan dikunci (<code>rup_status = 2</code>).
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Error Pengajuan (jika terjadi kendala) -->
                    <div class="alert alert-danger d-none py-2 px-3 mt-3 mb-0 fs-xs text-start" id="modalAjukanAlertError"></div>
                </div>

                <!-- STATE 2: PENGAJUAN BERHASIL -->
                <div class="modal-body p-4 text-center d-none" id="ajukanSuccessBody">
                    <div class="modal-ajukan-success-icon-wrap mb-3">
                        <svg class="sa-icon text-success" style="width: 36px; height: 36px;">
                            <use href="/icons/sprite.svg#check-circle"></use>
                        </svg>
                    </div>

                    <h5 class="modal-title fw-bold text-body-emphasis mb-1">
                        Paket Berhasil Diajukan!
                    </h5>
                    <p class="text-secondary fs-sm mb-3 px-2" id="modalAjukanSuccessMessage">
                        Paket pengadaan telah resmi diajukan ke UKPBJ dan data RUP terkait kini telah terkunci.
                    </p>

                    <div class="p-3 rounded-3 border border-success-subtle bg-success-subtle bg-opacity-10 mb-2">
                        <div class="fs-nano text-uppercase text-muted fw-bold mb-1">Nomor Paket Terbit</div>
                        <div class="fs-3 fw-bold font-monospace text-success" id="modalAjukanNewNoPaket">-</div>
                    </div>
                </div>

                <!-- FOOTER STATE 1: KONFIRMASI -->
                <div class="modal-footer bg-body-tertiary border-top py-2 px-4 d-flex justify-content-between align-items-center" id="ajukanConfirmFooter">
                    <button type="button" class="btn btn-secondary btn-sm px-3" id="btnCancelAjukanModal" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary btn-sm px-4 d-inline-flex align-items-center gap-2 shadow-xs" id="btnConfirmAjukanPaket">
                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#send"></use>
                        </svg>
                        <span>Ya, Ajukan Sekarang</span>
                    </button>
                </div>

                <!-- FOOTER STATE 2: SUKSES -->
                <div class="modal-footer bg-body-tertiary border-top py-2 px-4 d-none justify-content-center" id="ajukanSuccessFooter">
                    <button type="button" class="btn btn-success btn-sm px-4 d-inline-flex align-items-center gap-2 shadow-xs" id="btnReloadAfterAjukan">
                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#check"></use>
                        </svg>
                        <span>Selesai & Muat Ulang</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php if (! $isStrictAdminUlp && $canWritePaket): ?>
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
    <?php endif; ?>

    <!-- MODAL: Ubah Paket Pengadaan -->
    <div class="modal fade" id="editPaketModal" tabindex="-1" aria-labelledby="editPaketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-body-tertiary">
                    <h5 class="modal-title fw-bold" id="editPaketModalLabel">
                        <svg class="sa-icon me-2 text-info" style="width: 18px; height: 18px;">
                            <use href="/icons/sprite.svg#edit-3"></use>
                        </svg>
                        Ubah Data Paket Pengadaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPaketForm">
                    <?= csrf_field() ?>
                    <input type="hidden" id="editPaketId" name="id">
                    <div class="modal-body p-4">
                        <div class="alert alert-danger d-none py-2 px-3 mb-3 fs-xs" id="editPaketAlert" role="alert"></div>

                        <!-- Info Paket RUP Terkait (Read-only) -->
                        <div class="p-3 bg-body-tertiary rounded-2 border mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace fs-nano mb-1" id="editInfoRupCode">RUP: -</span>
                                    <h6 class="fw-bold text-body-emphasis mb-0" id="editInfoPaketName">-</h6>
                                </div>
                                <span class="badge bg-secondary-subtle text-secondary font-monospace" id="editInfoPaketId">#0</span>
                            </div>
                            <div class="row g-2 fs-xs mt-1">
                                <div class="col-sm-6">
                                    <span class="text-muted d-block">Program / Kegiatan:</span>
                                    <span class="fw-semibold text-body" id="editInfoRupKegiatan">-</span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block">Pagu Anggaran RUP:</span>
                                    <span class="fw-bold text-success font-monospace fs-sm" id="editInfoRupPagu">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nomor RPP -->
                        <div class="mb-3">
                            <label for="editInputNoRpp" class="form-label fw-semibold">
                                Nomor RPP (Rencana Pelaksanaan Pengadaan) <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editInputNoRpp" name="no_rpp" placeholder="Contoh: 000.3.1/005/BID.BM/DPUPR" required>
                        </div>

                        <!-- Nilai HPS -->
                        <div class="mb-3">
                            <label for="editInputNilaiHps" class="form-label fw-semibold">
                                Nilai HPS (Harga Perkiraan Sendiri) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text font-monospace fw-semibold">Rp</span>
                                <input type="text" class="form-control font-monospace fw-bold" id="editInputNilaiHps" name="nilai_hps" placeholder="Contoh: 399.987.000" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div class="form-text fs-xs text-muted">
                                    Nilai HPS idealnya tidak melebihi Pagu Anggaran RUP.
                                </div>
                                <button type="button" class="btn btn-link btn-xs p-0 text-decoration-none fs-nano" id="btnEditSalinPagu">
                                    Samakan Nilai dengan Pagu
                                </button>
                            </div>
                            <div class="text-danger fs-xs fw-semibold mt-1 d-none" id="editHpsExceedWarning">
                                <svg class="sa-icon me-1 text-danger" style="width: 12px; height: 12px;"><use href="/icons/sprite.svg#alert-triangle"></use></svg>
                                Perhatian: Nilai HPS melebihi Pagu Anggaran RUP!
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-body-tertiary">
                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 d-inline-flex align-items-center gap-1" id="btnUpdatePaket">
                            <svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#check"></use></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL: Konfirmasi Hapus Paket Pengadaan -->
    <div class="modal fade" id="deletePaketModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg overflow-hidden">
                <div style="height: 5px; background: linear-gradient(90deg, #dc2626 0%, #ef4444 100%);"></div>
                <div class="modal-header bg-danger-subtle text-danger border-0">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                        <svg class="sa-icon text-danger" style="width: 20px; height: 20px;">
                            <use href="/icons/sprite.svg#trash-2"></use>
                        </svg>
                        <span>Hapus Paket Pengadaan</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-danger d-none py-2 px-3 mb-3 fs-xs" id="deletePaketAlert"></div>
                    <input type="hidden" id="deletePaketId">
                    <p class="mb-2 text-body">Apakah Anda yakin ingin menghapus Paket Pengadaan berikut?</p>
                    <div class="p-3 bg-body-tertiary rounded-2 border mb-3">
                        <div class="fw-bold text-body-emphasis mb-1" id="deletePaketName">-</div>
                        <div class="fs-xs text-muted font-monospace mb-1" id="deletePaketRpp">No. RPP: -</div>
                        <div class="fs-xs fw-bold text-primary font-monospace" id="deletePaketHps">HPS: Rp 0</div>
                    </div>
                    <div class="alert alert-warning border-warning-subtle bg-warning-subtle bg-opacity-25 py-2 px-3 mb-0 fs-xs">
                        <div class="fw-bold text-warning-emphasis mb-1 d-flex align-items-center gap-1">
                            <svg class="sa-icon text-warning-emphasis" style="width: 14px; height: 14px;">
                                <use href="/icons/sprite.svg#alert-triangle"></use>
                            </svg>
                            <span>Dampak Penghapusan (Cascade):</span>
                        </div>
                        <ul class="mb-0 ps-3 text-body">
                            <li>Seluruh daftar <strong>Dokumen Persyaratan (Syarat)</strong> beserta file fisik yang sudah diunggah pada paket ini akan <strong>ikut terhapus permanen</strong>.</li>
                            <li>Status paket RUP terkait akan dibuka kembali (<code>Draft / Belum Diajukan</code>) sehingga RUP dapat di-edit, dihapus, atau dibuatkan paket ulang.</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm px-4 d-inline-flex align-items-center gap-1" id="confirmDeletePaketBtn">
                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#trash-2"></use>
                        </svg>
                        <span>Ya, Hapus Paket & Syarat</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('partials/app-scripts') ?>

    <?= $this->include('partials/paket-workflow') ?>
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

            // Global handler untuk cetak detail Paket
            window.printPaketDetail = function () {
                const tabDetailLink = document.getElementById('tab-detail-link');
                if (tabDetailLink && !tabDetailLink.classList.contains('active')) {
                    const bsTab = bootstrap.Tab.getOrCreateInstance(tabDetailLink);
                    bsTab.show();
                }
                window.print();
            };

            // Event listener modal detail
            document.querySelectorAll('.btn-view-paket').forEach(btn => {
                btn.addEventListener('click', function () {
                    const rawData = this.getAttribute('data-paket');
                    if (!rawData) return;
                    try {
                        const p = JSON.parse(rawData);
                        if (p.no_paket && String(p.no_paket).trim() !== '' && parseInt(p.status_paket) !== 1) {
                            document.getElementById('modalPaketNo').textContent = p.no_paket;
                            document.getElementById('modalPaketNo').className = 'badge bg-primary me-2 font-monospace';
                        } else {
                            document.getElementById('modalPaketNo').textContent = 'Belum Ada No';
                            document.getElementById('modalPaketNo').className = 'badge bg-secondary-subtle text-secondary border border-secondary-subtle me-2 font-monospace';
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
                            if (currentPaketStatus === 1 && canUserAjukan) {
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

                        const pkgName = String(p.package_name || ('Paket #' + p.id)).trim();
                        const actName = String(p.activity || '').trim();
                        document.getElementById('modalPaketTitle').textContent = pkgName;

                        const actEl = document.getElementById('modalPaketActivity');
                        if (actEl) actEl.textContent = actName || '-';

                        const actWrap = document.getElementById('modalPaketActivityWrap');
                        if (actWrap) {
                            const isRedundant = !actName || actName === '-' || actName.toLowerCase() === pkgName.toLowerCase();
                            if (isRedundant) {
                                actWrap.classList.add('d-none');
                            } else {
                                actWrap.classList.remove('d-none');
                            }
                        }

                        document.getElementById('modalPaketNoRpp').textContent = p.no_rpp || '-';
                        document.getElementById('modalPaketHps').textContent = formatRupiah(p.nilai_hps || 0);
                        document.getElementById('modalPaketPagu').textContent = p.budget_ceiling ? formatRupiah(p.budget_ceiling) : '-';
                        document.getElementById('modalPaketSkpd').textContent = p.skpd_name || '-';
                        document.getElementById('modalPaketPpk').textContent = p.ppk_name || '-';

                        document.getElementById('modalPaketTglPaket').textContent = formatDate(p.tgl_paket);
                        document.getElementById('modalPaketTglPengajuan').textContent = formatDate(p.tgl_pengajuan);
                        document.getElementById('modalPaketTglDistribusi').textContent = formatDate(p.tgl_distribusi);
                        document.getElementById('modalPaketTglTayang').textContent = formatDate(p.tgl_tayang);
                        document.getElementById('modalPaketCatatanVerif').textContent = p.catatan_terakhir || 'Tidak ada catatan khusus.';
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

                        // Beri tahu modul workflow bahwa modal detail paket dibuka
                        document.dispatchEvent(new CustomEvent('paket:detail-opened', { detail: p }));

                        const modal = new bootstrap.Modal(document.getElementById('detailPaketModal'));
                        modal.show();
                    } catch (e) {
                        console.error('Error parse paket detail:', e);
                    }
                });
            });

            // State status pill filter
            let activePillFilterType = 'all';
            let activePillStatusCodes = [];
            let activePillUserId = null;
            const currentUserIdNum = <?= json_encode($currentUserId) ?>;
            const isStrictAdminUlp = <?= json_encode($currentRoleName === 'ADMIN ULP') ?>;
            const canUserAjukan = <?= json_encode($canAjukanPaket) ?>;

            // Update badge hitungan di masing-masing pill berdasarkan data
            function updatePillCounters() {
                const searchVal = (searchInput ? searchInput.value : '').toLowerCase().trim();
                const verifVal = verifFilter ? verifFilter.value : '';
                const skpdVal = skpdFilter ? skpdFilter.value : '';

                // Baris yang lolos filter sekunder (pencarian, verifikasi, SKPD)
                const baseRows = allRows.filter(function (row) {
                    const noPaket = row.getAttribute('data-no-paket') || '';
                    const pkgName = row.getAttribute('data-package-name') || '';
                    const act = row.getAttribute('data-activity') || '';
                    const rpp = row.getAttribute('data-no-rpp') || '';
                    const skpd = row.getAttribute('data-skpd') || '';
                    const winner = row.getAttribute('data-winner') || '';
                    const stVerif = row.getAttribute('data-status-verifikasi') || '';

                    const matchesSearch = !searchVal ||
                        noPaket.includes(searchVal) ||
                        pkgName.includes(searchVal) ||
                        act.includes(searchVal) ||
                        rpp.includes(searchVal) ||
                        skpd.includes(searchVal) ||
                        winner.includes(searchVal);

                    const matchesVerif = !verifVal || String(stVerif) === String(verifVal);
                    const matchesSkpd = !skpdVal || skpd.includes(skpdVal);

                    return matchesSearch && matchesVerif && matchesSkpd;
                });

                // Hitung jumlah per kategori
                const counts = {
                    all: baseRows.length,
                    draft: 0,
                    dikembalikan: 0,
                    saranKaji: 0,
                    saranAdd: 0,
                    proses: 0,
                    hasil: 0,
                    selesai: 0,
                    ulpDaftar: 0,
                    ulpVerifikasi: 0,
                    ulpDikembalikan: 0,
                    ulpDiterima: 0,
                    ulpLelang: 0,
                    distDaftar: 0,
                    distDiterima: 0,
                    distSaran: 0,
                    distTerdistribusi: 0,
                    distHasil: 0,
                    kulpLelang: 0,
                    pokjaDistribusi: 0,
                    pokjaSaranKaji: 0,
                    pokjaKaji: 0,
                    pokjaLelang: 0,
                    pokjaHasil: 0,
                    agencyBaru: 0,
                    agencySudah: 0,
                };

                baseRows.forEach(row => {
                    const st = parseInt(row.getAttribute('data-status-paket') || '0', 10);
                    const adminUkpbjId = parseInt(row.getAttribute('data-admin-ukpbj-id') || '0', 10);
                    const isLpse = parseInt(row.getAttribute('data-is-lpse') || '0', 10);
                    const pokjaUsers = (row.getAttribute('data-pokja-users') || '')
                        .split(',').map(s => parseInt(s.trim(), 10)).filter(n => !isNaN(n));
                    const isPokjaMember = currentUserIdNum && pokjaUsers.includes(currentUserIdNum);
                    const isMineOrAdmin = !isStrictAdminUlp || (currentUserIdNum && adminUkpbjId === currentUserIdNum);

                    if (st === 1) counts.draft++;
                    if (st === 3) counts.dikembalikan++;
                    if (st === 7) counts.saranKaji++;
                    if (st === 10) counts.saranAdd++;
                    if ([2, 4, 5, 6, 8, 9, 11, 13].includes(st)) counts.proses++;
                    if (st === 12) counts.hasil++;
                    if (st === 14) counts.selesai++;

                    // 5 Tab Antrean Admin ULP
                    if (st === 2 && adminUkpbjId === 0) counts.ulpDaftar++;
                    if (st === 2 && adminUkpbjId > 0 && isMineOrAdmin) counts.ulpVerifikasi++;
                    if (st === 3 && isMineOrAdmin) counts.ulpDikembalikan++;
                    if (st >= 4 && isMineOrAdmin) counts.ulpDiterima++;
                    if ([0, 9, 12, 14, 15].includes(st)) counts.ulpLelang++;

                    // Antrean Admin Distribusi & Kepala ULP
                    if (st >= 2) counts.distDaftar++;
                    if (st === 4) counts.distDiterima++;
                    if (st === 5) counts.distSaran++;
                    if (st >= 6) counts.distTerdistribusi++;
                    if ([12, 14].includes(st)) counts.distHasil++;
                    if (st === 9) counts.kulpLelang++;

                    // Antrean Pokja (khusus paket di mana user terdaftar sebagai anggota Pokja)
                    if (isPokjaMember) {
                        if (st === 6) counts.pokjaDistribusi++;
                        if (st === 7) counts.pokjaSaranKaji++;
                        if (st === 8) counts.pokjaKaji++;
                        if ([9, 10, 11, 13].includes(st)) counts.pokjaLelang++;
                        if ([12, 14, 15].includes(st)) counts.pokjaHasil++;
                    }

                    // Antrean Admin Agency (Room LPSE)
                    if (st >= 6 && st <= 14 && isLpse === 0) counts.agencyBaru++;
                    if (isLpse === 1) counts.agencySudah++;
                });

                // Update teks badge di DOM
                const setElCount = (id, count) => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.textContent = count;
                        const parentBtn = el.closest('.status-pill-btn');
                        if (parentBtn) {
                            if (count === 0 && !parentBtn.classList.contains('active')) {
                                parentBtn.classList.add('is-zero');
                            } else {
                                parentBtn.classList.remove('is-zero');
                            }
                        }
                    }
                };

                setElCount('countPillAll', counts.all);
                setElCount('countPillDraft', counts.draft);
                setElCount('countPillDikembalikan', counts.dikembalikan);
                setElCount('countPillSaranKaji', counts.saranKaji);
                setElCount('countPillSaranAdd', counts.saranAdd);
                setElCount('countPillProses', counts.proses);
                setElCount('countPillHasil', counts.hasil);
                setElCount('countPillSelesai', counts.selesai);
                setElCount('countPillUlpDaftar', counts.ulpDaftar);
                setElCount('countPillUlpVerifikasi', counts.ulpVerifikasi);
                setElCount('countPillUlpDikembalikan', counts.ulpDikembalikan);
                setElCount('countPillUlpDiterima', counts.ulpDiterima);
                setElCount('countPillUlpLelang', counts.ulpLelang);
                setElCount('countPillDistDaftar', counts.distDaftar);
                setElCount('countPillDistDiterima', counts.distDiterima);
                setElCount('countPillDistSaran', counts.distSaran);
                setElCount('countPillDistTerdistribusi', counts.distTerdistribusi);
                setElCount('countPillDistHasil', counts.distHasil);
                setElCount('countPillKulpLelang', counts.kulpLelang);
                setElCount('countPillPokjaDistribusi', counts.pokjaDistribusi);
                setElCount('countPillPokjaSaranKaji', counts.pokjaSaranKaji);
                setElCount('countPillPokjaKaji', counts.pokjaKaji);
                setElCount('countPillPokjaLelang', counts.pokjaLelang);
                setElCount('countPillPokjaHasil', counts.pokjaHasil);
                setElCount('countPillAgencyBaru', counts.agencyBaru);
                setElCount('countPillAgencySudah', counts.agencySudah);
            }

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
                    const stPaket = parseInt(row.getAttribute('data-status-paket') || '0', 10);
                    const stVerif = row.getAttribute('data-status-verifikasi') || '';
                    const adminUkpbjId = parseInt(row.getAttribute('data-admin-ukpbj-id') || '0', 10);

                    const matchesSearch = !searchVal ||
                        noPaket.includes(searchVal) ||
                        pkgName.includes(searchVal) ||
                        act.includes(searchVal) ||
                        rpp.includes(searchVal) ||
                        skpd.includes(searchVal) ||
                        winner.includes(searchVal);

                    // Cocokkan dropdown status (jika dipilih)
                    const matchesDropdownStatus = !statusVal || String(stPaket) === String(statusVal);

                    // Cocokkan pill status aktif
                    const isLpse = parseInt(row.getAttribute('data-is-lpse') || '0', 10);
                    const pokjaUsers = (row.getAttribute('data-pokja-users') || '')
                        .split(',').map(s => parseInt(s.trim(), 10)).filter(n => !isNaN(n));
                    const isPokjaMember = currentUserIdNum && pokjaUsers.includes(currentUserIdNum);
                    const isMineOrAdmin = !isStrictAdminUlp || (currentUserIdNum && adminUkpbjId === currentUserIdNum);
                    let matchesPill = true;
                    if (activePillFilterType === 'status') {
                        matchesPill = activePillStatusCodes.includes(stPaket);
                    } else if (activePillFilterType === 'ulp_daftar') {
                        matchesPill = stPaket === 2 && adminUkpbjId === 0;
                    } else if (activePillFilterType === 'ulp_verifikasi') {
                        matchesPill = stPaket === 2 && adminUkpbjId > 0 && isMineOrAdmin;
                    } else if (activePillFilterType === 'ulp_dikembalikan') {
                        matchesPill = stPaket === 3 && isMineOrAdmin;
                    } else if (activePillFilterType === 'ulp_diterima') {
                        matchesPill = stPaket >= 4 && isMineOrAdmin;
                    } else if (activePillFilterType === 'pokja_status') {
                        matchesPill = isPokjaMember && activePillStatusCodes.includes(stPaket);
                    } else if (activePillFilterType === 'agency_baru') {
                        matchesPill = stPaket >= 6 && stPaket <= 14 && isLpse === 0;
                    } else if (activePillFilterType === 'agency_sudah') {
                        matchesPill = isLpse === 1;
                    }

                    const matchesVerif = !verifVal || String(stVerif) === String(verifVal);
                    const matchesSkpd = !skpdVal || skpd.includes(skpdVal);

                    return matchesSearch && matchesDropdownStatus && matchesPill && matchesVerif && matchesSkpd;
                });

                currentPage = 1;
                renderPage();
                updatePillCounters();
            }

            // Inisialisasi Event Listener Status Pills
            const statusPills = document.querySelectorAll('#statusPillsContainer .status-pill-btn');
            statusPills.forEach(pill => {
                pill.addEventListener('click', function () {
                    statusPills.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');

                    const type = this.getAttribute('data-filter-type') || 'all';
                    activePillFilterType = type;

                    if (type === 'status' || type === 'pokja_status') {
                        const rawCodes = this.getAttribute('data-status-codes') || '';
                        activePillStatusCodes = rawCodes.split(',').map(s => parseInt(s.trim(), 10)).filter(n => !isNaN(n));
                    } else if (type === 'my_assigned') {
                        activePillUserId = this.getAttribute('data-user-id');
                    } else {
                        activePillStatusCodes = [];
                        activePillUserId = null;
                    }

                    // Reset dropdown status jika pill diklik agar tidak bertentangan
                    if (statusFilter && type !== 'all') {
                        statusFilter.value = '';
                    }

                    applyFilter();
                });
            });

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
            if (statusFilter) {
                statusFilter.addEventListener('change', function () {
                    // Jika dropdown manual diubah, non-aktifkan active state di pills kecuali bila kembali ke ""
                    if (this.value !== '') {
                        statusPills.forEach(p => p.classList.remove('active'));
                        activePillFilterType = 'all';
                        activePillStatusCodes = [];
                        activePillUserId = null;
                    } else {
                        // Kembali ke pill 'all'
                        const allPill = document.querySelector('#statusPillsContainer .status-pill-btn[data-filter-type="all"]');
                        if (allPill) {
                            statusPills.forEach(p => p.classList.remove('active'));
                            allPill.classList.add('active');
                            activePillFilterType = 'all';
                        }
                    }
                    applyFilter();
                });
            }
            if (verifFilter) verifFilter.addEventListener('change', applyFilter);
            if (skpdFilter) skpdFilter.addEventListener('change', applyFilter);
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    perPage = this.value;
                    currentPage = 1;
                    renderPage();
                });
            }

            // Inisialisasi hitungan pill & render halaman pertama kali
            updatePillCounters();
            renderPage();

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

                        const canEditSyarat = Boolean(currentSyaratSummary && currentSyaratSummary.can_edit);

                        // Sembunyikan form tambah syarat jika user tidak berhak mengubah syarat
                        if (tfootSyarat) {
                            if (canEditSyarat) {
                                tfootSyarat.classList.remove('d-none');
                            } else {
                                tfootSyarat.classList.add('d-none');
                            }
                        }

                        // Tampilkan tombol Ajukan hanya jika user berhak mengajukan
                        const modalBtnAjukan = document.getElementById('modalBtnAjukan');
                        if (modalBtnAjukan) {
                            if (currentSyaratSummary && currentSyaratSummary.can_ajukan && canUserAjukan) {
                                modalBtnAjukan.classList.remove('d-none');
                                modalBtnAjukan.classList.add('d-inline-flex');
                            } else {
                                modalBtnAjukan.classList.add('d-none');
                                modalBtnAjukan.classList.remove('d-inline-flex');
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
                                if (canEditSyarat) {
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

            // Modal Konfirmasi & Sukses Pengajuan Paket
            const modalAjukanEl = document.getElementById('modalKonfirmasiAjukanPaket');
            let bsModalConfirmAjukan = null;
            let pendingAjukanPaketId = null;
            let pendingAjukanPaketName = '';

            if (modalAjukanEl) {
                modalAjukanEl.addEventListener('show.bs.modal', function () {
                    modalAjukanEl.style.zIndex = '1065';
                    setTimeout(() => {
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        if (backdrops.length > 1) {
                            backdrops[backdrops.length - 1].style.zIndex = '1060';
                        }
                    }, 10);
                });

                modalAjukanEl.addEventListener('hidden.bs.modal', function () {
                    const detailModal = document.getElementById('detailPaketModal');
                    if (detailModal && detailModal.classList.contains('show')) {
                        document.body.classList.add('modal-open');
                    }
                });
            }

            const btnConfirmAjukanPaket = document.getElementById('btnConfirmAjukanPaket');
            const btnReloadAfterAjukan = document.getElementById('btnReloadAfterAjukan');

            if (btnReloadAfterAjukan) {
                btnReloadAfterAjukan.addEventListener('click', function () {
                    window.location.reload();
                });
            }

            function openModalKonfirmasiAjukan(paketId, paketName) {
                if (!modalAjukanEl) return;

                pendingAjukanPaketId = paketId;
                pendingAjukanPaketName = paketName || 'Paket Pengadaan';

                const confirmBody = document.getElementById('ajukanConfirmBody');
                const successBody = document.getElementById('ajukanSuccessBody');
                const confirmFooter = document.getElementById('ajukanConfirmFooter');
                const successFooter = document.getElementById('ajukanSuccessFooter');
                const topStrip = document.getElementById('modalAjukanTopStrip');
                const alertError = document.getElementById('modalAjukanAlertError');
                const btnCancel = document.getElementById('btnCancelAjukanModal');

                if (confirmBody) confirmBody.classList.remove('d-none');
                if (successBody) successBody.classList.add('d-none');
                if (confirmFooter) {
                    confirmFooter.classList.remove('d-none');
                    confirmFooter.classList.add('d-flex');
                }
                if (successFooter) {
                    successFooter.classList.add('d-none');
                    successFooter.classList.remove('d-flex');
                }
                if (topStrip) {
                    topStrip.style.background = 'linear-gradient(90deg, #2563eb 0%, #0ea5e9 50%, #10b981 100%)';
                }
                if (alertError) {
                    alertError.classList.add('d-none');
                    alertError.innerHTML = '';
                }
                if (btnCancel) btnCancel.disabled = false;
                if (btnConfirmAjukanPaket) {
                    btnConfirmAjukanPaket.disabled = false;
                    btnConfirmAjukanPaket.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#send"></use></svg> <span>Ya, Ajukan Sekarang</span>';
                }

                const nameEl = document.getElementById('modalAjukanPaketName');
                if (nameEl) nameEl.textContent = pendingAjukanPaketName;

                const rppEl = document.getElementById('modalAjukanPaketRpp');
                const modalNoRpp = document.getElementById('modalPaketNoRpp');
                if (rppEl) rppEl.textContent = modalNoRpp ? modalNoRpp.textContent : '-';

                const hpsEl = document.getElementById('modalAjukanPaketHps');
                const modalHps = document.getElementById('modalPaketHps');
                if (hpsEl) hpsEl.textContent = modalHps ? modalHps.textContent : 'Rp 0';

                const syaratBadge = document.getElementById('modalAjukanSyaratBadge');
                if (syaratBadge && currentSyaratSummary) {
                    syaratBadge.innerHTML = `
                        <svg class="sa-icon text-success" style="width: 12px; height: 12px;">
                            <use href="/icons/sprite.svg#check-circle"></use>
                        </svg>
                        <span>Dokumen Wajib Lengkap (${currentSyaratSummary.wajib_uploaded}/${currentSyaratSummary.total_wajib})</span>`;
                }

                if (!bsModalConfirmAjukan) {
                    bsModalConfirmAjukan = new bootstrap.Modal(modalAjukanEl);
                }
                bsModalConfirmAjukan.show();
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

                openModalKonfirmasiAjukan(paketId, paketName);
            }

            if (btnConfirmAjukanPaket) {
                btnConfirmAjukanPaket.addEventListener('click', function () {
                    if (!pendingAjukanPaketId) return;

                    const alertError = document.getElementById('modalAjukanAlertError');
                    const btnCancel = document.getElementById('btnCancelAjukanModal');
                    const modalBtnAjukan = document.getElementById('modalBtnAjukan');

                    if (alertError) {
                        alertError.classList.add('d-none');
                        alertError.innerHTML = '';
                    }
                    if (btnCancel) btnCancel.disabled = true;

                    btnConfirmAjukanPaket.disabled = true;
                    btnConfirmAjukanPaket.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses Pengajuan...';

                    if (modalBtnAjukan) {
                        modalBtnAjukan.disabled = true;
                        modalBtnAjukan.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...';
                    }

                    fetch(`/paket/ajukan/${pendingAjukanPaketId}`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                    .then(res => {
                        if (res.status === 200 && res.body.status === 'success') {
                            const confirmBody = document.getElementById('ajukanConfirmBody');
                            const successBody = document.getElementById('ajukanSuccessBody');
                            const confirmFooter = document.getElementById('ajukanConfirmFooter');
                            const successFooter = document.getElementById('ajukanSuccessFooter');
                            const topStrip = document.getElementById('modalAjukanTopStrip');
                            const successMsg = document.getElementById('modalAjukanSuccessMessage');
                            const newNoEl = document.getElementById('modalAjukanNewNoPaket');

                            if (topStrip) {
                                topStrip.style.background = 'linear-gradient(90deg, #10b981 0%, #059669 100%)';
                            }
                            if (successMsg) {
                                successMsg.textContent = res.body.message || 'Paket pengadaan berhasil diajukan ke UKPBJ!';
                            }
                            if (newNoEl) {
                                newNoEl.textContent = res.body.no_paket || 'TERBIT';
                            }
                            if (confirmBody) confirmBody.classList.add('d-none');
                            if (successBody) successBody.classList.remove('d-none');
                            if (confirmFooter) {
                                confirmFooter.classList.add('d-none');
                                confirmFooter.classList.remove('d-flex');
                            }
                            if (successFooter) {
                                successFooter.classList.remove('d-none');
                                successFooter.classList.add('d-flex');
                            }

                            setTimeout(() => {
                                window.location.reload();
                            }, 1800);
                        } else {
                            if (btnCancel) btnCancel.disabled = false;
                            btnConfirmAjukanPaket.disabled = false;
                            btnConfirmAjukanPaket.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#send"></use></svg> <span>Ya, Ajukan Sekarang</span>';

                            if (modalBtnAjukan) {
                                modalBtnAjukan.disabled = false;
                                modalBtnAjukan.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#send"></use></svg> <span>Ajukan Paket</span>';
                            }

                            // Jika gagal karena syarat belum lengkap (HTTP 422)
                            if (res.status === 422) {
                                if (bsModalConfirmAjukan) bsModalConfirmAjukan.hide();
                                const missingList = res.body.missing_syarat || (currentSyaratSummary ? currentSyaratSummary.missing_wajib : []);
                                openModalSyaratBelumLengkap(missingList, pendingAjukanPaketName);

                                const tabSyaratLink = document.getElementById('tab-syarat-link');
                                if (tabSyaratLink) {
                                    const bsTab = bootstrap.Tab.getOrCreateInstance(tabSyaratLink);
                                    bsTab.show();
                                }
                                showSyaratAlert('error', res.body.message);
                            } else if (alertError) {
                                alertError.textContent = res.body.message || 'Gagal mengajukan paket pengadaan.';
                                alertError.classList.remove('d-none');
                            }
                        }
                    })
                    .catch(err => {
                        console.error('Ajukan error:', err);
                        if (btnCancel) btnCancel.disabled = false;
                        btnConfirmAjukanPaket.disabled = false;
                        btnConfirmAjukanPaket.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#send"></use></svg> <span>Ya, Ajukan Sekarang</span>';

                        if (modalBtnAjukan) {
                            modalBtnAjukan.disabled = false;
                            modalBtnAjukan.innerHTML = '<svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#send"></use></svg> <span>Ajukan Paket</span>';
                        }
                        if (alertError) {
                            alertError.textContent = 'Terjadi kesalahan jaringan atau server saat mengajukan paket.';
                            alertError.classList.remove('d-none');
                        }
                    });
                });
            }

            // =========================================================================
            // UBAH & HAPUS PAKET PENGADAAN
            // =========================================================================
            const editPaketModalEl = document.getElementById('editPaketModal');
            const editPaketForm = document.getElementById('editPaketForm');
            const editPaketAlert = document.getElementById('editPaketAlert');
            const editInputNilaiHps = document.getElementById('editInputNilaiHps');
            const btnEditSalinPagu = document.getElementById('btnEditSalinPagu');
            const editHpsExceedWarning = document.getElementById('editHpsExceedWarning');
            let currentEditPaketPagu = 0;

            function checkEditHpsVsPagu() {
                if (!editInputNilaiHps || !editHpsExceedWarning) return;
                const rawHps = parseFloat(editInputNilaiHps.value.replace(/[^0-9]/g, '')) || 0;
                if (currentEditPaketPagu > 0 && rawHps > currentEditPaketPagu) {
                    editHpsExceedWarning.classList.remove('d-none');
                } else {
                    editHpsExceedWarning.classList.add('d-none');
                }
            }

            if (editInputNilaiHps) {
                editInputNilaiHps.addEventListener('input', function () {
                    const raw = this.value.replace(/[^0-9]/g, '');
                    if (raw === '') {
                        this.value = '';
                    } else {
                        this.value = Number(raw).toLocaleString('id-ID');
                    }
                    checkEditHpsVsPagu();
                });
            }

            if (btnEditSalinPagu && editInputNilaiHps) {
                btnEditSalinPagu.addEventListener('click', function () {
                    if (currentEditPaketPagu > 0) {
                        editInputNilaiHps.value = Number(currentEditPaketPagu).toLocaleString('id-ID');
                        checkEditHpsVsPagu();
                    }
                });
            }

            document.querySelectorAll('.btn-edit-paket').forEach(btn => {
                btn.addEventListener('click', function () {
                    const rawData = this.getAttribute('data-paket');
                    if (!rawData) return;
                    try {
                        const p = JSON.parse(rawData);
                        if (editPaketAlert) {
                            editPaketAlert.classList.add('d-none');
                            editPaketAlert.innerHTML = '';
                        }
                        document.getElementById('editPaketId').value = p.id;
                        document.getElementById('editInfoPaketId').textContent = '#' + p.id;
                        document.getElementById('editInfoRupCode').textContent = 'RUP: ' + (p.package_code || ('DRAFT-' + p.rup_id));
                        document.getElementById('editInfoPaketName').textContent = p.package_name || '-';
                        document.getElementById('editInfoRupKegiatan').textContent = p.activity || '-';
                        currentEditPaketPagu = parseFloat(p.budget_ceiling || 0);
                        document.getElementById('editInfoRupPagu').textContent = formatRupiah(currentEditPaketPagu);

                        document.getElementById('editInputNoRpp').value = p.no_rpp || '';
                        const hpsVal = Math.round(parseFloat(p.nilai_hps || 0));
                        editInputNilaiHps.value = hpsVal > 0 ? hpsVal.toLocaleString('id-ID') : '';
                        checkEditHpsVsPagu();

                        const modal = bootstrap.Modal.getOrCreateInstance(editPaketModalEl);
                        modal.show();
                    } catch (err) {
                        console.error('Error parsing paket data for edit:', err);
                    }
                });
            });

            if (editPaketForm) {
                editPaketForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const id = document.getElementById('editPaketId').value;
                    if (!id) return;

                    if (editPaketAlert) {
                        editPaketAlert.classList.add('d-none');
                        editPaketAlert.innerHTML = '';
                    }

                    const btnUpdate = document.getElementById('btnUpdatePaket');
                    const origHtml = btnUpdate.innerHTML;
                    btnUpdate.disabled = true;
                    btnUpdate.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

                    const formData = new FormData(editPaketForm);

                    fetch('/paket/update/' + id, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(r => r.json().then(body => ({ status: r.status, body })))
                    .then(res => {
                        if (res.status === 200 && res.body.status === 'success') {
                            window.location.reload();
                        } else {
                            let errMsg = res.body.message || 'Gagal memperbarui paket pengadaan.';
                            if (res.body.errors) {
                                const list = Object.values(res.body.errors).map(e => `<li>${e}</li>`).join('');
                                errMsg += `<ul class="mb-0 mt-1 ps-3">${list}</ul>`;
                            }
                            if (editPaketAlert) {
                                editPaketAlert.innerHTML = errMsg;
                                editPaketAlert.classList.remove('d-none');
                            }
                            btnUpdate.disabled = false;
                            btnUpdate.innerHTML = origHtml;
                        }
                    })
                    .catch(err => {
                        console.error('Error updating paket:', err);
                        if (editPaketAlert) {
                            editPaketAlert.textContent = 'Terjadi kesalahan jaringan saat menyimpan perubahan.';
                            editPaketAlert.classList.remove('d-none');
                        }
                        btnUpdate.disabled = false;
                        btnUpdate.innerHTML = origHtml;
                    });
                });
            }

            const deletePaketModalEl = document.getElementById('deletePaketModal');
            const deletePaketAlert = document.getElementById('deletePaketAlert');
            const confirmDeletePaketBtn = document.getElementById('confirmDeletePaketBtn');

            document.querySelectorAll('.btn-delete-paket').forEach(btn => {
                btn.addEventListener('click', function () {
                    const rawData = this.getAttribute('data-paket');
                    if (!rawData) return;
                    try {
                        const p = JSON.parse(rawData);
                        if (deletePaketAlert) {
                            deletePaketAlert.classList.add('d-none');
                            deletePaketAlert.textContent = '';
                        }
                        document.getElementById('deletePaketId').value = p.id;
                        document.getElementById('deletePaketName').textContent = p.package_name || ('Paket #' + p.id);
                        document.getElementById('deletePaketRpp').textContent = 'No. RPP: ' + (p.no_rpp || '-');
                        document.getElementById('deletePaketHps').textContent = 'Nilai HPS: ' + formatRupiah(p.nilai_hps || 0);

                        const modal = bootstrap.Modal.getOrCreateInstance(deletePaketModalEl);
                        modal.show();
                    } catch (err) {
                        console.error('Error parsing paket data for delete:', err);
                    }
                });
            });

            if (confirmDeletePaketBtn) {
                confirmDeletePaketBtn.addEventListener('click', function () {
                    const id = document.getElementById('deletePaketId').value;
                    if (!id) return;

                    if (deletePaketAlert) {
                        deletePaketAlert.classList.add('d-none');
                        deletePaketAlert.textContent = '';
                    }

                    const origHtml = confirmDeletePaketBtn.innerHTML;
                    confirmDeletePaketBtn.disabled = true;
                    confirmDeletePaketBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';

                    const formData = new FormData();
                    const csrfInput = editPaketForm ? editPaketForm.querySelector('input[type="hidden"][name^="csrf"]') : null;
                    if (csrfInput) {
                        formData.append(csrfInput.name, csrfInput.value);
                    }

                    fetch('/paket/delete/' + id, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(r => r.json().then(body => ({ status: r.status, body })))
                    .then(res => {
                        if (res.status === 200 && res.body.status === 'success') {
                            window.location.reload();
                        } else {
                            if (deletePaketAlert) {
                                deletePaketAlert.textContent = res.body.message || 'Gagal menghapus paket pengadaan.';
                                deletePaketAlert.classList.remove('d-none');
                            }
                            confirmDeletePaketBtn.disabled = false;
                            confirmDeletePaketBtn.innerHTML = origHtml;
                        }
                    })
                    .catch(err => {
                        console.error('Error deleting paket:', err);
                        if (deletePaketAlert) {
                            deletePaketAlert.textContent = 'Terjadi kesalahan jaringan saat menghapus paket.';
                            deletePaketAlert.classList.remove('d-none');
                        }
                        confirmDeletePaketBtn.disabled = false;
                        confirmDeletePaketBtn.innerHTML = origHtml;
                    });
                });
            }

            renderPage();
        });
    </script>
</body>
</html>
