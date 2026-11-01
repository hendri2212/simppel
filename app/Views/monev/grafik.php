<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Grafik Lelang - e-MONEV SIMPPEL")) ?>
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
                        "pageTitle"     => "Modul 6: Grafik Lelang",
                        "pageSubTitle1" => "e-MONEV",
                        "pageSubTitle2" => "Visualisasi & Analitik Lelang",
                        "pageSubText"   => "Rangkaian grafik rencana vs realisasi lelang bulanan, perbandingan pengajuan, progres lelang, serta capaian per Jenis Pengadaan dan SKPD."
                    )) ?>

                    <div class="main-content">

                        <?= view('monev/partials/header_and_filter', [
                            'moduleKey'  => 'enam',
                            'modules'    => $modules,
                            'filters'    => $filters,
                            'showSearch' => false,
                            'showJenis'  => false,
                            'showPokja'  => false,
                            'showExport' => false,
                        ]) ?>

                        <!-- Baris 1: G1 (Rencana Bulanan) & G2 (Realisasi Masuk Bulanan) -->
                        <div class="row g-4 mb-4">
                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">1. Grafik Rencana Lelang Perbulan</h6>
                                        <small class="text-muted"><?= esc($filters['selected_skpd_name']) ?> — TA <?= (int) $filters['tahun'] ?></small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartG1Rencana" style="min-height: 330px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">2. Grafik Realisasi Lelang Masuk Perbulan</h6>
                                        <small class="text-muted"><?= esc($filters['selected_skpd_name']) ?> — TA <?= (int) $filters['tahun'] ?></small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartG2Realisasi" style="min-height: 330px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 2: G3 (Perbandingan Pengajuan), G4 (Progres Paket), G7 (Per Jenis Pengadaan) -->
                        <div class="row g-4 mb-4">
                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">3. Perbandingan Pengajuan Paket</h6>
                                        <small class="text-muted">Paket Diajukan vs Belum Diajukan</small>
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <div id="chartG3Pengajuan" class="w-100" style="min-height: 300px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">4. Progres Paket Lelang</h6>
                                        <small class="text-muted">Selesai, Dalam Proses, Gagal/Batal</small>
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <div id="chartG4Progres" class="w-100" style="min-height: 300px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">5. Paket Lelang Per Jenis Pengadaan</h6>
                                        <small class="text-muted">Nilai HPS & Jumlah Paket Diterima</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartG7Jenis" style="min-height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 3: G5 (Diterima Perbulan) & G6 (Selesai Perbulan) -->
                        <div class="row g-4 mb-4">
                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">6. Rekap Paket Lelang Diterima ULP Perbulan</h6>
                                        <small class="text-muted">Nilai Pagu, Nilai HPS & Jumlah Paket Diterima</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartG5Diterima" style="min-height: 330px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">7. Rekap Paket Lelang Selesai Perbulan</h6>
                                        <small class="text-muted">Nilai Pagu, Nilai Kontrak & Efisiensi (%)</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartG6Selesai" style="min-height: 330px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Baris 4: G9 (Paket Selesai Per SKPD) & G10 (RUP vs Diterima ULP Per SKPD) -->
                        <div class="row g-4">
                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">8. Paket Lelang Selesai Per SKPD</h6>
                                        <small class="text-muted">Perbandingan Pagu, Nilai Kontrak & Efisiensi (%) per Instansi</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartG9SkpdSelesai" style="min-height: 360px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase">9. Paket RUP vs Diterima ULP Per SKPD</h6>
                                        <small class="text-muted">Perbandingan Jumlah Paket RUP dan Paket Diterima ULP per Instansi</small>
                                    </div>
                                    <div class="card-body">
                                        <div id="chartG10SkpdCompare" style="min-height: 360px;"></div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof ApexCharts === 'undefined') return;

            const data = <?= json_encode($chartData ?? []) ?>;
            const rekap = data.rekap || {};
            const perJenis = data.per_jenis || [];
            const skpdStats = data.skpd_stats || [];

            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const toJuta = v => +(parseFloat(v || 0) / 1000000).toFixed(2);

            // G1: Rencana Bulanan
            const rBulan = rekap.rencana_bulan || {};
            new ApexCharts(document.querySelector('#chartG1Rencana'), {
                chart: { type: 'line', height: 330, toolbar: { show: true } },
                series: [
                    { name: 'Nilai Pagu (Juta Rp)', type: 'column', data: months.map((_, i) => toJuta((rBulan[i + 1] || {}).pagu)) },
                    { name: 'Jumlah Paket', type: 'line', data: months.map((_, i) => (rBulan[i + 1] || {}).paket || 0) }
                ],
                stroke: { width: [0, 3], curve: 'smooth' },
                colors: ['#2563eb', '#f59e0b'],
                xaxis: { categories: months },
                yaxis: [
                    { title: { text: 'Pagu (Juta Rp)' } },
                    { opposite: true, title: { text: 'Jumlah Paket' }, decimalsInFloat: 0 }
                ],
                legend: { position: 'top' }
            }).render();

            // G2: Realisasi Masuk Bulanan
            const realBulan = rekap.realisasi_bulan || {};
            new ApexCharts(document.querySelector('#chartG2Realisasi'), {
                chart: { type: 'line', height: 330, toolbar: { show: true } },
                series: [
                    { name: 'Nilai Pagu (Juta Rp)', type: 'column', data: months.map((_, i) => toJuta((realBulan[i + 1] || {}).pagu)) },
                    { name: 'Nilai HPS (Juta Rp)', type: 'column', data: months.map((_, i) => toJuta((realBulan[i + 1] || {}).hps)) },
                    { name: 'Jumlah Paket', type: 'line', data: months.map((_, i) => (realBulan[i + 1] || {}).paket || 0) }
                ],
                stroke: { width: [0, 0, 3], curve: 'smooth' },
                colors: ['#3b82f6', '#10b981', '#ef4444'],
                xaxis: { categories: months },
                yaxis: [
                    { title: { text: 'Nilai (Juta Rp)' } },
                    { show: false },
                    { opposite: true, title: { text: 'Jumlah Paket' }, decimalsInFloat: 0 }
                ],
                legend: { position: 'top' }
            }).render();

            // G3: Perbandingan Pengajuan Paket
            const rkPaket = rekap.rekap_paket || {};
            const belumMasukCnt = ((rkPaket.belum_masuk || {}).total) || 0;
            const sudahMasukCnt = (((rkPaket.proses || {}).total) || 0) +
                                  (((rkPaket.selesai || {}).total) || 0) +
                                  (((rkPaket.gagal || {}).total) || 0) +
                                  (((rkPaket.batal || {}).total) || 0);
            new ApexCharts(document.querySelector('#chartG3Pengajuan'), {
                chart: { type: 'donut', height: 300 },
                labels: ['Paket Belum Diajukan', 'Paket Sudah Diajukan'],
                series: [belumMasukCnt, sudahMasukCnt],
                colors: ['#f59e0b', '#2563eb'],
                legend: { position: 'bottom' }
            }).render();

            // G4: Progres Paket Lelang
            const selesaiCnt = ((rkPaket.selesai || {}).total) || 0;
            const prosesCnt  = ((rkPaket.proses || {}).total) || 0;
            const gagalBatal = (((rkPaket.gagal || {}).total) || 0) + (((rkPaket.batal || {}).total) || 0);
            new ApexCharts(document.querySelector('#chartG4Progres'), {
                chart: { type: 'donut', height: 300 },
                labels: ['Paket Selesai Lelang', 'Paket Dalam Proses', 'Paket Gagal / Dibatalkan'],
                series: [selesaiCnt, prosesCnt, gagalBatal],
                colors: ['#10b981', '#0ea5e9', '#ef4444'],
                legend: { position: 'bottom' }
            }).render();

            // G7: Per Jenis Pengadaan
            new ApexCharts(document.querySelector('#chartG7Jenis'), {
                chart: { type: 'line', height: 300, toolbar: { show: false } },
                series: [
                    { name: 'Nilai HPS (Juta Rp)', type: 'column', data: perJenis.map(j => toJuta(j.hps)) },
                    { name: 'Jumlah Paket', type: 'line', data: perJenis.map(j => j.paket) }
                ],
                stroke: { width: [0, 3], curve: 'smooth' },
                colors: ['#6366f1', '#f59e0b'],
                xaxis: { categories: perJenis.map(j => j.name) },
                yaxis: [
                    { title: { text: 'HPS (Juta Rp)' } },
                    { opposite: true, title: { text: 'Paket' }, decimalsInFloat: 0 }
                ],
                legend: { position: 'top' }
            }).render();

            // G5: Diterima Perbulan
            const ditBulan = rekap.diterima_bulan || {};
            new ApexCharts(document.querySelector('#chartG5Diterima'), {
                chart: { type: 'line', height: 330, toolbar: { show: true } },
                series: [
                    { name: 'Nilai Pagu (Juta Rp)', type: 'column', data: months.map((_, i) => toJuta((ditBulan[i + 1] || {}).pagu)) },
                    { name: 'Nilai HPS (Juta Rp)', type: 'column', data: months.map((_, i) => toJuta((ditBulan[i + 1] || {}).hps)) },
                    { name: 'Jumlah Paket', type: 'line', data: months.map((_, i) => (ditBulan[i + 1] || {}).paket || 0) }
                ],
                stroke: { width: [0, 0, 3], curve: 'smooth' },
                colors: ['#0ea5e9', '#8b5cf6', '#f97316'],
                xaxis: { categories: months },
                yaxis: [
                    { title: { text: 'Nilai (Juta Rp)' } },
                    { show: false },
                    { opposite: true, title: { text: 'Jumlah Paket' }, decimalsInFloat: 0 }
                ],
                legend: { position: 'top' }
            }).render();

            // G6: Selesai Perbulan
            const selBulan = rekap.selesai_bulan || {};
            new ApexCharts(document.querySelector('#chartG6Selesai'), {
                chart: { type: 'line', height: 330, toolbar: { show: true } },
                series: [
                    { name: 'Nilai Pagu (Juta Rp)', type: 'column', data: months.map((_, i) => toJuta((selBulan[i + 1] || {}).pagu)) },
                    { name: 'Nilai Kontrak (Juta Rp)', type: 'column', data: months.map((_, i) => toJuta((selBulan[i + 1] || {}).kontrak)) },
                    { name: 'Efisiensi (%)', type: 'line', data: months.map((_, i) => (selBulan[i + 1] || {}).efisiensi_persen || 0) }
                ],
                stroke: { width: [0, 0, 3], curve: 'smooth' },
                colors: ['#10b981', '#2563eb', '#ef4444'],
                xaxis: { categories: months },
                yaxis: [
                    { title: { text: 'Nilai (Juta Rp)' } },
                    { show: false },
                    { opposite: true, title: { text: 'Efisiensi (%)' } }
                ],
                legend: { position: 'top' }
            }).render();

            // G9: Paket Selesai Per SKPD
            const skpdLabels = skpdStats.map(s => s.name);
            new ApexCharts(document.querySelector('#chartG9SkpdSelesai'), {
                chart: { type: 'line', height: 360, toolbar: { show: true } },
                series: [
                    { name: 'Pagu Selesai (Juta Rp)', type: 'column', data: skpdStats.map(s => toJuta(s.selesai_pagu)) },
                    { name: 'Nilai Kontrak (Juta Rp)', type: 'column', data: skpdStats.map(s => toJuta(s.selesai_kontrak)) },
                    { name: 'Efisiensi (%)', type: 'line', data: skpdStats.map(s => s.efisiensi_persen) }
                ],
                stroke: { width: [0, 0, 3], curve: 'smooth' },
                colors: ['#3b82f6', '#10b981', '#f59e0b'],
                xaxis: { categories: skpdLabels },
                yaxis: [
                    { title: { text: 'Nilai (Juta Rp)' } },
                    { show: false },
                    { opposite: true, title: { text: 'Efisiensi (%)' } }
                ],
                legend: { position: 'top' }
            }).render();

            // G10: RUP vs Diterima ULP Per SKPD
            new ApexCharts(document.querySelector('#chartG10SkpdCompare'), {
                chart: { type: 'bar', height: 360, toolbar: { show: true } },
                series: [
                    { name: 'Paket RUP', data: skpdStats.map(s => s.rup_count) },
                    { name: 'Paket Diterima ULP', data: skpdStats.map(s => s.diterima_ulp) }
                ],
                colors: ['#6366f1', '#10b981'],
                xaxis: { categories: skpdLabels },
                yaxis: { title: { text: 'Jumlah Paket' }, decimalsInFloat: 0 },
                legend: { position: 'top' }
            }).render();
        });
    </script>
</body>
</html>
