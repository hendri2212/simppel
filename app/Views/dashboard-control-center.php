<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Control Center - SIMPPEL")) ?>

    <?= $this->include('partials/app-head-css') ?>

    <style>
        .cc-kpi .cc-kpi-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .cc-kpi .cc-kpi-value {
            font-size: 1.55rem;
            font-weight: 700;
            line-height: 1.15;
        }
        .cc-kpi .cc-kpi-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-weight: 600;
            color: var(--bs-secondary-color);
        }
        .cc-card-title {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 0;
        }
        .cc-chart { min-height: 300px; }
        .cc-loading { opacity: 0.45; pointer-events: none; transition: opacity 0.2s; }
        .cc-queue-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid var(--bs-border-color-translucent);
            text-decoration: none;
            color: inherit;
        }
        .cc-queue-item:hover { background: var(--bs-tertiary-bg); }
        .cc-activity { max-height: 360px; overflow-y: auto; }
        .cc-activity-item { border-left: 3px solid var(--bs-primary); padding-left: 0.75rem; }
        .cc-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            color: var(--bs-secondary-color);
            font-size: 0.85rem;
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

                    <?php
                    $years       = $years ?? [(int) date('Y')];
                    $defaultYear = $defaultYear ?? (int) date('Y');
                    $skpdList    = $skpdList ?? [];
                    $isGlobal    = $isGlobal ?? false;
                    $roleName    = $roleName ?? '';
                    $fullName    = $fullName ?? '';
                    ?>

                    <?php echo view("partials/app-pagetitle", array(
                        "pageTitle"     => "Control Center",
                        "pageSubTitle1" => 'Insights',
                        "pageSubTitle2" => "Dashboard Pengadaan",
                        "pageSubText"   => "Ringkasan visual RUP, paket, alur proses UKPBJ, Pokja, dan efisiensi anggaran.",
                    )) ?>

                    <form id="ccFilter" class="d-flex flex-wrap align-items-end justify-content-start gap-2 mb-4">
                        <div>
                            <label for="ccTahun" class="form-label fs-xs fw-bold text-uppercase text-muted mb-1">Tahun Anggaran</label>
                            <select id="ccTahun" name="tahun" class="form-select form-select-sm">
                                <?php foreach ($years as $y): ?>
                                    <option value="<?= (int) $y ?>" <?= (int) $y === (int) $defaultYear ? 'selected' : '' ?>><?= (int) $y ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if ($isGlobal): ?>
                            <div>
                                <label for="ccSkpd" class="form-label fs-xs fw-bold text-uppercase text-muted mb-1">Dinas / Instansi</label>
                                <select id="ccSkpd" name="skpd_id" class="form-select form-select-sm" style="min-width: 240px;">
                                    <option value="0">Semua Instansi</option>
                                    <?php foreach ($skpdList as $s): ?>
                                        <option value="<?= (int) $s['id'] ?>"><?= esc($s['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <button type="button" id="ccRefresh" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1">
                            <svg class="sa-icon" style="width: 14px; height: 14px;"><use href="/icons/sprite.svg#refresh-cw"></use></svg>
                            <span>Muat Ulang</span>
                        </button>
                    </form>

                    <div class="main-content" id="ccRoot">

                        <div class="alert alert-danger d-none" id="ccError" role="alert"></div>

                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3 fs-xs text-muted">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Role: <?= esc($roleName ?: '-') ?></span>
                            <?php if (! $isGlobal): ?>
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Data dibatasi pada SKPD/PPK Anda</span>
                            <?php endif; ?>
                            <span class="ms-auto">Diperbarui: <span id="ccGenerated">-</span></span>
                        </div>

                        <!-- KPI -->
                        <div class="row g-3 mb-4">
                            <?php
                            $kpiCards = [
                                ['id' => 'kpiRup',     'label' => 'Total RUP',            'icon' => 'file-text',    'color' => 'primary', 'sub' => 'kpiPagu'],
                                ['id' => 'kpiMasuk',   'label' => 'Paket Masuk UKPBJ',    'icon' => 'inbox',        'color' => 'info',    'sub' => 'kpiSerapan'],
                                ['id' => 'kpiProses',  'label' => 'Dalam Proses',         'icon' => 'activity',     'color' => 'warning', 'sub' => 'kpiBelum'],
                                ['id' => 'kpiSelesai', 'label' => 'Lelang Selesai',       'icon' => 'check-circle', 'color' => 'success', 'sub' => 'kpiKontrak'],
                            ];
                            foreach ($kpiCards as $c): ?>
                                <div class="col-sm-6 col-xl-3">
                                    <div class="card border-0 shadow-sm h-100 cc-kpi">
                                        <div class="card-body d-flex align-items-center gap-3">
                                            <span class="cc-kpi-icon bg-<?= $c['color'] ?> bg-opacity-10 text-<?= $c['color'] ?>">
                                                <svg class="sa-icon" style="width: 22px; height: 22px;"><use href="/icons/sprite.svg#<?= $c['icon'] ?>"></use></svg>
                                            </span>
                                            <div class="min-w-0">
                                                <div class="cc-kpi-label"><?= $c['label'] ?></div>
                                                <div class="cc-kpi-value text-body-emphasis" id="<?= $c['id'] ?>">-</div>
                                                <div class="fs-xs text-muted text-truncate" id="<?= $c['sub'] ?>">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Tren bulanan + Efisiensi -->
                        <div class="row g-3 mb-4">
                            <div class="col-xl-8">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3 d-flex flex-wrap align-items-center gap-2">
                                        <h2 class="cc-card-title">Tren Bulanan: Rencana vs Masuk vs Selesai</h2>
                                        <div class="btn-group btn-group-sm ms-auto" role="group" aria-label="Mode tren">
                                            <input type="radio" class="btn-check" name="ccTrendMode" id="ccTrendPaket" value="paket" checked>
                                            <label class="btn btn-outline-secondary" for="ccTrendPaket">Jumlah Paket</label>
                                            <input type="radio" class="btn-check" name="ccTrendMode" id="ccTrendNilai" value="nilai">
                                            <label class="btn btn-outline-secondary" for="ccTrendNilai">Nilai (Rp)</label>
                                        </div>
                                    </div>
                                    <div class="card-body"><div id="chartTrend" class="cc-chart"></div></div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h2 class="cc-card-title">Capaian & Efisiensi</h2>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartRadial" style="min-height: 260px;"></div>
                                        <div class="row g-2 text-center mt-1">
                                            <div class="col-6">
                                                <div class="p-2 rounded-2 bg-body-tertiary border">
                                                    <div class="fs-xs text-muted text-uppercase fw-semibold">Total HPS</div>
                                                    <div class="fw-bold font-monospace" id="kpiHps">-</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-2 rounded-2 bg-body-tertiary border">
                                                    <div class="fs-xs text-muted text-uppercase fw-semibold">Hemat Anggaran</div>
                                                    <div class="fw-bold font-monospace text-success" id="kpiEfisiensi">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pipeline + Antrean saya -->
                        <div class="row g-3 mb-4">
                            <div class="col-xl-8">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h2 class="cc-card-title">Pipeline Tahapan Paket</h2>
                                        <small class="text-muted">Jumlah paket di setiap tahap alur Draft → Selesai</small>
                                    </div>
                                    <div class="card-body"><div id="chartPipeline" class="cc-chart"></div></div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3 d-flex align-items-center">
                                        <h2 class="cc-card-title">Antrean Tugas Saya</h2>
                                        <a href="/paket" class="ms-auto fs-xs">Buka Daftar Paket →</a>
                                    </div>
                                    <div class="card-body d-flex flex-column gap-2" id="ccQueue">
                                        <div class="cc-empty">Memuat…</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Komposisi RUP -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6 col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3"><h2 class="cc-card-title">Jenis Pengadaan</h2></div>
                                    <div class="card-body"><div id="chartJenis" class="cc-chart"></div></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3"><h2 class="cc-card-title">Metode Pemilihan</h2></div>
                                    <div class="card-body"><div id="chartMetode" class="cc-chart"></div></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3"><h2 class="cc-card-title">Sumber Dana (Pagu)</h2></div>
                                    <div class="card-body"><div id="chartSumber" class="cc-chart"></div></div>
                                </div>
                            </div>
                        </div>

                        <!-- Top SKPD + Umur paket -->
                        <div class="row g-3 mb-4">
                            <div class="col-xl-7">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h2 class="cc-card-title">10 Instansi dengan Pagu RUP Terbesar</h2>
                                    </div>
                                    <div class="card-body"><div id="chartSkpd" style="min-height: 360px;"></div></div>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h2 class="cc-card-title">Umur Paket Dalam Proses</h2>
                                        <small class="text-muted">Hari sejak paket diajukan ke UKPBJ</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartAging" style="min-height: 220px;"></div>
                                        <div class="fs-xs text-uppercase fw-bold text-muted mt-2 mb-1">Paket Terlama</div>
                                        <ul class="list-unstyled mb-0 fs-sm" id="ccOldest"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pokja + Aktivitas -->
                        <div class="row g-3">
                            <div class="col-xl-7">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h2 class="cc-card-title">Beban Kerja Pokja</h2>
                                        <small class="text-muted">Paket aktif dan selesai per anggota Pokja</small>
                                    </div>
                                    <div class="card-body"><div id="chartPokja" style="min-height: 340px;"></div></div>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h2 class="cc-card-title">Aktivitas & Catatan Terbaru</h2>
                                    </div>
                                    <div class="card-body cc-activity" id="ccActivity">
                                        <div class="cc-empty">Memuat…</div>
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

    <?= $this->include('partials/app-scripts') ?>

    <script src="/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="/scripts/pages/dashboard-procurement.js"></script>

</body>
</html>
