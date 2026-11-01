<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Dashboard e-MONEV - SIMPPEL")) ?>
    <?= $this->include('partials/app-head-css') ?>
    <style>
        .monev-hub-card {
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            border: 1px solid var(--bs-border-color-translucent, rgba(0,0,0,0.08));
        }
        .monev-hub-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08) !important;
        }
        .monev-hub-card.disabled-module {
            opacity: 0.65;
            background-color: var(--bs-tertiary-bg, #f8fafc);
        }
        .monev-num-badge {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
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
                        "pageTitle"     => "e-MONEV (Monitoring & Evaluasi Pengadaan)",
                        "pageSubTitle1" => "e-MONEV",
                        "pageSubTitle2" => "Dashboard Monitoring",
                        "pageSubText"   => "Pusat kendali pemantauan Rencana Umum Pengadaan (RUP), realisasi paket lelang, distribusi Pokja ULP, grafik capaian, dan efisiensi anggaran."
                    )) ?>

                    <?php
                    $formatShortRupiah = static function ($amount) {
                        $amount = (float) $amount;
                        if ($amount >= 1000000000) {
                            return 'Rp ' . number_format($amount / 1000000000, 2, ',', '.') . ' M';
                        } elseif ($amount >= 1000000) {
                            return 'Rp ' . number_format($amount / 1000000, 1, ',', '.') . ' Jt';
                        }
                        return 'Rp ' . number_format($amount, 0, ',', '.');
                    };
                    ?>

                    <div class="main-content">

                        <?= view('monev/partials/header_and_filter', [
                            'moduleKey'  => 'index',
                            'modules'    => $modules,
                            'filters'    => $filters,
                            'showSearch' => false,
                            'showJenis'  => false,
                            'showPokja'  => false,
                            'showExport' => false,
                        ]) ?>

                        <!-- Ringkasan KPI e-MONEV -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#file-text"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total RUP (TA <?= (int) $filters['tahun'] ?>)</div>
                                            <div class="fs-3 fw-bold text-body-emphasis"><?= (int) $kpi['total_rup'] ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-primary fw-semibold">Pagu: <?= $formatShortRupiah($kpi['total_pagu_rup']) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#clock"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Belum Masuk & Dalam Proses</div>
                                            <div class="fs-3 fw-bold text-warning"><?= (int) $kpi['belum_masuk'] ?> <span class="fs-xs fw-normal text-muted">Belum Masuk</span></div>
                                            <div class="fs-xs text-info fw-semibold"><?= (int) $kpi['paket_proses'] ?> Paket Sedang Proses Lelang</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#check-circle"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Paket Lelang Selesai</div>
                                            <div class="fs-3 fw-bold text-success"><?= (int) $kpi['paket_selesai'] ?> <span class="fs-sm fw-normal text-muted">Paket</span></div>
                                            <div class="fs-xs text-muted">Kontrak: <?= $formatShortRupiah($kpi['total_kontrak']) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info me-3 flex-shrink-0">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#trending-up"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Efisiensi Anggaran Lelang</div>
                                            <div class="fs-3 fw-bold text-info"><?= number_format((float) $kpi['efisiensi_persen'], 2, ',', '.') ?>%</div>
                                            <div class="fs-xs text-success fw-semibold">Hemat: <?= $formatShortRupiah($kpi['efisiensi_rp']) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 8 Kartu Modul e-MONEV (Sesuai Contoh simppel/protected/views/monev/index.php) -->
                        <div class="row g-3">
                            <?php
                            $querySuffix = ! empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '';
                            foreach ($modules as $mKey => $mod):
                                $allowed = ! empty($mod['allowed']);
                            ?>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <div class="card monev-hub-card shadow-sm h-100 <?= ! $allowed ? 'disabled-module' : '' ?>">
                                        <div class="card-body d-flex flex-column justify-content-between p-4">
                                            <div>
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <span class="monev-num-badge bg-primary bg-opacity-10 text-primary">
                                                        0<?= (int) $mod['number'] ?>
                                                    </span>
                                                    <?php if ($allowed): ?>
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Khusus UKPBJ/Pokja</span>
                                                    <?php endif; ?>
                                                </div>

                                                <h5 class="fw-bold text-body-emphasis mb-2 d-flex align-items-center gap-2">
                                                    <svg class="sa-icon text-primary flex-shrink-0" style="width: 18px; height: 18px;">
                                                        <use href="/icons/sprite.svg#<?= esc($mod['icon']) ?>"></use>
                                                    </svg>
                                                    <span><?= esc($mod['title']) ?></span>
                                                </h5>

                                                <p class="text-muted fs-sm mb-3"><?= esc($mod['subtitle']) ?></p>
                                            </div>

                                            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                                <?php if ($allowed): ?>
                                                    <a href="<?= esc($mod['url'] . $querySuffix) ?>" class="btn btn-primary btn-sm w-100 d-inline-flex align-items-center justify-content-center gap-1">
                                                        <span>Buka Modul <?= (int) $mod['number'] ?></span>
                                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                            <use href="/icons/sprite.svg#arrow-right"></use>
                                                        </svg>
                                                    </a>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" disabled>
                                                        Tidak Tersedia untuk Role <?= esc($filters['role_name']) ?>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>

            <?= $this->include('partials/app-footer') ?>
        </main>

        <?= $this->include('partials/app-settings') ?>
    </div>

    <?= $this->include('partials/app-scripts') ?>
</body>
</html>
