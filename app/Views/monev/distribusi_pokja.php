<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Distribusi Pokja ULP - e-MONEV SIMPPEL")) ?>
    <?= $this->include('partials/app-head-css') ?>
</head>

<body>
    <div class="app-wrap">
        <?= $this->include('partials/app-header') ?>
        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">
                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array(
                        "pageTitle"     => "Modul 4: Distribusi Pokja ULP",
                        "pageSubTitle1" => "e-MONEV",
                        "pageSubTitle2" => "Distribusi & Performa Pokja",
                        "pageSubText"   => "Monitoring pembagian tugas anggota Pokja Pemilihan, lama proses lelang (hari), serta grafik alokasi beban kerja dan performa efisiensi Pokja."
                    )) ?>

                    <?php
                    $totalHps = array_sum(array_map(static fn($r) => (float) ($r['nilai_hps'] ?? 0), $rows));
                    ?>

                    <div class="main-content">

                        <?= view('monev/partials/header_and_filter', [
                            'moduleKey'  => 'empat',
                            'modules'    => $modules,
                            'filters'    => $filters,
                            'pokjaUsers' => $pokjaUsers ?? [],
                            'showSearch' => true,
                            'showJenis'  => true,
                            'showPokja'  => true,
                            'showExport' => true,
                        ]) ?>

                        <!-- Tabel Distribusi Pokja ULP -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-body d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
                                <div>
                                    <h5 class="fw-bold mb-0" id="distribusiPokjaTableHeading">
                                        Daftar Distribusi Paket Ke Pokja ULP — Tahun Anggaran <?= (int) $filters['tahun'] ?>
                                    </h5>
                                    <small class="text-muted">
                                        Instansi: <strong><?= esc($filters['selected_skpd_name']) ?></strong> |
                                        Total Paket: <strong><?= count($rows) ?> Paket</strong> |
                                        Total HPS: <strong class="text-primary font-monospace">Rp <?= number_format($totalHps, 0, ',', '.') ?></strong>
                                    </small>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="monev-table-region" tabindex="0" role="region" aria-labelledby="distribusiPokjaTableHeading">
                                    <table class="table table-hover table-bordered align-middle table-monev">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 45px;">No</th>
                                                <th style="width: 95px;">No Paket</th>
                                                <th style="min-width: 240px;">Nama Paket</th>
                                                <th style="width: 140px;">Jenis Pekerjaan</th>
                                                <th style="min-width: 180px;">Dinas / Instansi</th>
                                                <th style="min-width: 150px;">PPK</th>
                                                <th class="text-end" style="width: 150px;">HPS (Rp)</th>
                                                <th class="text-center" style="width: 115px;">Tgl Distribusi</th>
                                                <th style="min-width: 200px;">Anggota Pokja</th>
                                                <th class="text-center" style="width: 135px;">Status</th>
                                                <th class="text-center" style="width: 110px;">Lama Proses</th>
                                                <th class="text-center" style="width: 85px;">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($rows)): ?>
                                                <tr>
                                                    <td colspan="12" class="text-center py-5 text-muted">
                                                        Tidak ada data distribusi paket untuk filter yang dipilih.
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($rows as $idx => $r): ?>
                                                    <tr>
                                                        <td class="text-center text-muted"><?= $idx + 1 ?></td>
                                                        <td class="font-monospace fw-bold text-primary">
                                                            <?= esc($r['no_paket'] ?: ('#' . $r['id'])) ?>
                                                        </td>
                                                        <td>
                                                            <div class="fw-semibold text-body-emphasis"><?= esc($r['package_name']) ?></div>
                                                            <div class="fs-xs text-muted font-monospace">RUP: <?= esc($r['rup_code'] ?: '-') ?></div>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                                                <?= esc($r['jenis_pengadaan_name'] ?: '-') ?>
                                                            </span>
                                                        </td>
                                                        <td><?= esc($r['skpd_name'] ?: '-') ?></td>
                                                        <td><?= esc($r['ppk_name'] ?: '-') ?></td>
                                                        <td class="text-end font-monospace fw-bold">
                                                            <?= number_format((float) ($r['nilai_hps'] ?? 0), 0, ',', '.') ?>
                                                        </td>
                                                        <td class="text-center font-monospace fs-xs">
                                                            <?= ! empty($r['tgl_distribusi']) ? date('d-m-Y', strtotime($r['tgl_distribusi'])) : '-' ?>
                                                        </td>
                                                        <td>
                                                            <?php if (empty($r['pokja_members'])): ?>
                                                                <span class="text-muted fs-xs fst-italic">Belum ditugaskan</span>
                                                            <?php else: ?>
                                                                <div class="d-flex flex-wrap gap-1">
                                                                    <?php foreach ($r['pokja_members'] as $pm): ?>
                                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                                            <?= esc($pm['full_name']) ?>
                                                                        </span>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                            $st = (int) ($r['status_paket'] ?? 0);
                                                            $badgeCls = $st === 14 ? 'bg-success-subtle text-success border-success-subtle'
                                                                : ($st === 15 || $st === 0 ? 'bg-danger-subtle text-danger border-danger-subtle'
                                                                : 'bg-warning-subtle text-warning-emphasis border-warning-subtle');
                                                            ?>
                                                            <span class="badge border <?= $badgeCls ?>">
                                                                <?= esc($r['status_label']) ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-center font-monospace">
                                                            <?php if ($r['lama_proses_hari'] !== null): ?>
                                                                <span class="fw-bold"><?= (int) $r['lama_proses_hari'] ?></span> <small class="text-muted">hari</small>
                                                            <?php else: ?>
                                                                <span class="text-muted">-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-outline-primary btn-xs px-2 py-1"
                                                                    onclick="openMonevPaketDetail(<?= (int) $r['id'] ?>)">
                                                                Detail
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- 2 Grafik Pokja ULP (Sesuai empat_g1.php & empat_g2.php di simppel) -->
                        <div class="row g-4">
                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">Grafik 1: Alokasi Paket Ke Anggota Pokja</h6>
                                        <small class="text-muted">Perbandingan Nilai Pagu, Nilai HPS, dan Jumlah Paket yang ditangani per personil Pokja</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartPokjaAlokasi" style="min-height: 360px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">Grafik 2: Performa Lelang Selesai Pokja</h6>
                                        <small class="text-muted">Perbandingan Pagu Selesai, Nilai Kontrak, Jumlah Paket Selesai, dan Efisiensi (%)</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartPokjaPerforma" style="min-height: 360px;"></div>
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

    <?= view('monev/partials/detail_modals') ?>
    <?= $this->include('partials/app-scripts') ?>
    <script src="/plugins/apexcharts/apexcharts.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pokjaStats = <?= json_encode($pokjaStats ?? []) ?>;
            const labels = pokjaStats.map(s => s.name);

            if (typeof ApexCharts !== 'undefined' && labels.length > 0) {
                // Grafik 1: Alokasi Paket ke Pokja (empat_g1)
                const optAlokasi = {
                    chart: { type: 'line', height: 360, toolbar: { show: true } },
                    series: [
                        { name: 'Nilai Pagu (Juta Rp)', type: 'column', data: pokjaStats.map(s => +(s.total_pagu / 1000000).toFixed(2)) },
                        { name: 'Nilai HPS (Juta Rp)', type: 'column', data: pokjaStats.map(s => +(s.total_hps / 1000000).toFixed(2)) },
                        { name: 'Jumlah Paket', type: 'line', data: pokjaStats.map(s => s.total_paket) }
                    ],
                    stroke: { width: [0, 0, 3], curve: 'smooth' },
                    colors: ['#2563eb', '#0ea5e9', '#f59e0b'],
                    xaxis: { categories: labels },
                    yaxis: [
                        { title: { text: 'Nilai (Juta Rp)' } },
                        { show: false },
                        { opposite: true, title: { text: 'Jumlah Paket' }, decimalsInFloat: 0 }
                    ],
                    legend: { position: 'top' }
                };
                new ApexCharts(document.querySelector('#chartPokjaAlokasi'), optAlokasi).render();

                // Grafik 2: Performa Lelang Pokja (empat_g2)
                const optPerforma = {
                    chart: { type: 'line', height: 360, toolbar: { show: true } },
                    series: [
                        { name: 'Pagu Lelang Selesai (Juta Rp)', type: 'column', data: pokjaStats.map(s => +(s.selesai_pagu / 1000000).toFixed(2)) },
                        { name: 'Nilai Kontrak (Juta Rp)', type: 'column', data: pokjaStats.map(s => +(s.selesai_kontrak / 1000000).toFixed(2)) },
                        { name: 'Efisiensi (%)', type: 'line', data: pokjaStats.map(s => s.efisiensi_persen) }
                    ],
                    stroke: { width: [0, 0, 3], curve: 'smooth' },
                    colors: ['#10b981', '#6366f1', '#ef4444'],
                    xaxis: { categories: labels },
                    yaxis: [
                        { title: { text: 'Nilai (Juta Rp)' } },
                        { show: false },
                        { opposite: true, title: { text: 'Efisiensi (%)' } }
                    ],
                    legend: { position: 'top' }
                };
                new ApexCharts(document.querySelector('#chartPokjaPerforma'), optPerforma).render();
            }
        });
    </script>
</body>
</html>
