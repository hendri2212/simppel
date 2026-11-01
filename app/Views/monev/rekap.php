<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Rekap Paket Data Lelang - e-MONEV SIMPPEL")) ?>
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
                        "pageTitle"     => "Modul 3: Rekap Paket Data Lelang",
                        "pageSubTitle1" => "e-MONEV",
                        "pageSubTitle2" => "Rekapitulasi Pengadaan",
                        "pageSubText"   => "Rekapitulasi rencana dan realisasi paket lelang per bulan, rekap status lelang per jenis pengadaan, dan efisiensi lelang selesai."
                    )) ?>

                    <?php
                    $bulanNames = [
                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
                    ];
                    $rencanaBulan   = $rekap['rencana_bulan'] ?? [];
                    $realisasiBulan = $rekap['realisasi_bulan'] ?? [];
                    $rekapPaket     = $rekap['rekap_paket'] ?? [];
                    $rekapPagu      = $rekap['rekap_pagu'] ?? [];
                    $efisiensiRows  = $rekap['efisiensi_rows'] ?? [];
                    $jenisList      = $rekap['jenis_list'] ?? [];
                    $grandPaket     = (int) ($rekap['grand_total_paket'] ?? 0);
                    $grandPagu      = (float) ($rekap['grand_total_pagu'] ?? 0);
                    ?>

                    <div class="main-content">

                        <?= view('monev/partials/header_and_filter', [
                            'moduleKey'  => 'tiga',
                            'modules'    => $modules,
                            'filters'    => $filters,
                            'showSearch' => false,
                            'showJenis'  => false,
                            'showPokja'  => false,
                            'showExport' => true,
                        ]) ?>

                        <!-- TABEL 1: Rencana Lelang Perbulan -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-body py-3">
                                <h6 class="fw-bold mb-0 text-uppercase" id="rekapTbl1Heading">
                                    1. Rencana Lelang Perbulan — Tahun Anggaran <?= (int) $filters['tahun'] ?> (<?= esc($filters['selected_skpd_name']) ?>)
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="monev-table-region" tabindex="0" role="region" aria-labelledby="rekapTbl1Heading">
                                    <table class="table table-bordered table-hover align-middle table-monev">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 45px;">No</th>
                                                <th style="min-width: 210px;">Uraian Rencana</th>
                                                <?php foreach ($bulanNames as $mNum => $mLabel): ?>
                                                    <th class="text-end"><?= $mLabel ?></th>
                                                <?php endforeach; ?>
                                                <th class="text-end bg-primary-subtle text-primary">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totRencanaPaket = 0;
                                            $totRencanaPagu  = 0.0;
                                            ?>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="fw-semibold">Berdasarkan Jumlah Paket</td>
                                                <?php for ($m = 1; $m <= 12; $m++):
                                                    $v = (int) ($rencanaBulan[$m]['paket'] ?? 0);
                                                    $totRencanaPaket += $v;
                                                ?>
                                                    <td class="text-end font-monospace"><?= number_format($v, 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end font-monospace fw-bold bg-primary-subtle text-primary"><?= number_format($totRencanaPaket, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td class="fw-semibold">Berdasarkan Jumlah Pagu (Rp)</td>
                                                <?php for ($m = 1; $m <= 12; $m++):
                                                    $p = (float) ($rencanaBulan[$m]['pagu'] ?? 0);
                                                    $totRencanaPagu += $p;
                                                ?>
                                                    <td class="text-end font-monospace"><?= number_format($p, 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end font-monospace fw-bold bg-primary-subtle text-primary"><?= number_format($totRencanaPagu, 0, ',', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- TABEL 2: Realisasi Lelang Masuk Perbulan -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-body py-3">
                                <h6 class="fw-bold mb-0 text-uppercase" id="rekapTbl2Heading">
                                    2. Realisasi Lelang Masuk Perbulan — Tahun Anggaran <?= (int) $filters['tahun'] ?>
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="monev-table-region" tabindex="0" role="region" aria-labelledby="rekapTbl2Heading">
                                    <table class="table table-bordered table-hover align-middle table-monev">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 45px;">No</th>
                                                <th style="min-width: 210px;">Uraian Realisasi Masuk</th>
                                                <?php foreach ($bulanNames as $mNum => $mLabel): ?>
                                                    <th class="text-end"><?= $mLabel ?></th>
                                                <?php endforeach; ?>
                                                <th class="text-end bg-success-subtle text-success">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totRealPaket = 0;
                                            $totRealPagu  = 0.0;
                                            $totRealHps   = 0.0;
                                            ?>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="fw-semibold">Berdasarkan Jumlah Paket</td>
                                                <?php for ($m = 1; $m <= 12; $m++):
                                                    $v = (int) ($realisasiBulan[$m]['paket'] ?? 0);
                                                    $totRealPaket += $v;
                                                ?>
                                                    <td class="text-end font-monospace"><?= number_format($v, 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end font-monospace fw-bold bg-success-subtle text-success"><?= number_format($totRealPaket, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td class="fw-semibold">Berdasarkan Jumlah Pagu (Rp)</td>
                                                <?php for ($m = 1; $m <= 12; $m++):
                                                    $p = (float) ($realisasiBulan[$m]['pagu'] ?? 0);
                                                    $totRealPagu += $p;
                                                ?>
                                                    <td class="text-end font-monospace"><?= number_format($p, 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end font-monospace fw-bold bg-success-subtle text-success"><?= number_format($totRealPagu, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td class="fw-semibold">Berdasarkan Nilai HPS (Rp)</td>
                                                <?php for ($m = 1; $m <= 12; $m++):
                                                    $h = (float) ($realisasiBulan[$m]['hps'] ?? 0);
                                                    $totRealHps += $h;
                                                ?>
                                                    <td class="text-end font-monospace"><?= number_format($h, 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end font-monospace fw-bold bg-success-subtle text-success"><?= number_format($totRealHps, 0, ',', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <!-- TABEL 3: Rekap Lelang Berdasarkan Paket -->
                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase" id="rekapTbl3Heading">
                                            3. Rekap Lelang Berdasarkan Jumlah Paket
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="monev-table-region" tabindex="0" role="region" aria-labelledby="rekapTbl3Heading">
                                            <table class="table table-bordered table-hover align-middle table-monev">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 42px;">No</th>
                                                        <th>Status Lelang</th>
                                                        <?php foreach ($jenisList as $j): ?>
                                                            <th class="text-end"><?= esc($j['name']) ?></th>
                                                        <?php endforeach; ?>
                                                        <th class="text-end">Total</th>
                                                        <th class="text-end">%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $colSumPaket = [];
                                                    foreach ($jenisList as $j) {
                                                        $colSumPaket[(int) $j['id']] = 0;
                                                    }
                                                    $rowNo = 1;
                                                    foreach ($rekapPaket as $bKey => $bData):
                                                        $rowTot = (int) $bData['total'];
                                                        $pct    = $grandPaket > 0 ? round(($rowTot / $grandPaket) * 100, 2) : 0.0;
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $rowNo++ ?></td>
                                                            <td class="fw-semibold"><?= esc($bData['label']) ?></td>
                                                            <?php foreach ($jenisList as $j):
                                                                $jid = (int) $j['id'];
                                                                $val = (int) ($bData['by_jenis'][$jid] ?? 0);
                                                                $colSumPaket[$jid] += $val;
                                                            ?>
                                                                <td class="text-end font-monospace"><?= number_format($val, 0, ',', '.') ?></td>
                                                            <?php endforeach; ?>
                                                            <td class="text-end font-monospace fw-bold"><?= number_format($rowTot, 0, ',', '.') ?></td>
                                                            <td class="text-end font-monospace"><?= number_format($pct, 2, ',', '.') ?>%</td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot class="table-light fw-bold">
                                                    <tr>
                                                        <td colspan="2" class="text-end">TOTAL PAKET</td>
                                                        <?php foreach ($jenisList as $j): ?>
                                                            <td class="text-end font-monospace"><?= number_format($colSumPaket[(int) $j['id']], 0, ',', '.') ?></td>
                                                        <?php endforeach; ?>
                                                        <td class="text-end font-monospace text-primary"><?= number_format($grandPaket, 0, ',', '.') ?></td>
                                                        <td class="text-end font-monospace"><?= $grandPaket > 0 ? '100,00%' : '0,00%' ?></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TABEL 4: Rekap Lelang Berdasarkan Pagu -->
                            <div class="col-12 col-xl-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-body py-3">
                                        <h6 class="fw-bold mb-0 text-uppercase" id="rekapTbl4Heading">
                                            4. Rekap Lelang Berdasarkan Pagu Anggaran (Rp)
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="monev-table-region" tabindex="0" role="region" aria-labelledby="rekapTbl4Heading">
                                            <table class="table table-bordered table-hover align-middle table-monev">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 42px;">No</th>
                                                        <th>Status Lelang</th>
                                                        <?php foreach ($jenisList as $j): ?>
                                                            <th class="text-end"><?= esc($j['name']) ?></th>
                                                        <?php endforeach; ?>
                                                        <th class="text-end">Total Pagu</th>
                                                        <th class="text-end">%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $colSumPagu = [];
                                                    foreach ($jenisList as $j) {
                                                        $colSumPagu[(int) $j['id']] = 0.0;
                                                    }
                                                    $rowNo = 1;
                                                    foreach ($rekapPagu as $bKey => $bData):
                                                        $rowTot = (float) $bData['total'];
                                                        $pct    = $grandPagu > 0 ? round(($rowTot / $grandPagu) * 100, 2) : 0.0;
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $rowNo++ ?></td>
                                                            <td class="fw-semibold"><?= esc($bData['label']) ?></td>
                                                            <?php foreach ($jenisList as $j):
                                                                $jid = (int) $j['id'];
                                                                $val = (float) ($bData['by_jenis'][$jid] ?? 0);
                                                                $colSumPagu[$jid] += $val;
                                                            ?>
                                                                <td class="text-end font-monospace"><?= number_format($val, 0, ',', '.') ?></td>
                                                            <?php endforeach; ?>
                                                            <td class="text-end font-monospace fw-bold"><?= number_format($rowTot, 0, ',', '.') ?></td>
                                                            <td class="text-end font-monospace"><?= number_format($pct, 2, ',', '.') ?>%</td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot class="table-light fw-bold">
                                                    <tr>
                                                        <td colspan="2" class="text-end">TOTAL PAGU</td>
                                                        <?php foreach ($jenisList as $j): ?>
                                                            <td class="text-end font-monospace"><?= number_format($colSumPagu[(int) $j['id']], 0, ',', '.') ?></td>
                                                        <?php endforeach; ?>
                                                        <td class="text-end font-monospace text-primary"><?= number_format($grandPagu, 0, ',', '.') ?></td>
                                                        <td class="text-end font-monospace"><?= $grandPagu > 0 ? '100,00%' : '0,00%' ?></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TABEL 5: Efisiensi Lelang Selesai -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-body py-3">
                                <h6 class="fw-bold mb-0 text-uppercase" id="rekapTbl5Heading">
                                    5. Efisiensi Lelang Selesai Per Jenis Pekerjaan
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="monev-table-region" tabindex="0" role="region" aria-labelledby="rekapTbl5Heading">
                                    <table class="table table-bordered table-hover align-middle table-monev">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 48px;">No</th>
                                                <th>Jenis Pekerjaan</th>
                                                <th class="text-end">Jumlah Paket Selesai</th>
                                                <th class="text-end">Pagu Anggaran (Rp)</th>
                                                <th class="text-end">Nilai HPS (Rp)</th>
                                                <th class="text-end">Nilai Kontrak (Rp)</th>
                                                <th class="text-end">Selisih / Efisiensi (Rp)</th>
                                                <th class="text-end">Efisiensi (%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sumEfPaket   = 0;
                                            $sumEfPagu    = 0.0;
                                            $sumEfHps     = 0.0;
                                            $sumEfKontrak = 0.0;
                                            $noEf = 1;
                                            foreach ($efisiensiRows as $ef):
                                                $pg  = (float) $ef['pagu'];
                                                $hp  = (float) $ef['hps'];
                                                $kt  = (float) $ef['kontrak'];
                                                $sel = $pg - $kt;
                                                $pct = $pg > 0 ? round(($sel / $pg) * 100, 2) : 0.0;

                                                $sumEfPaket   += (int) $ef['paket'];
                                                $sumEfPagu    += $pg;
                                                $sumEfHps     += $hp;
                                                $sumEfKontrak += $kt;
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $noEf++ ?></td>
                                                    <td class="fw-semibold"><?= esc($ef['name']) ?></td>
                                                    <td class="text-end font-monospace"><?= number_format((int) $ef['paket'], 0, ',', '.') ?></td>
                                                    <td class="text-end font-monospace"><?= number_format($pg, 0, ',', '.') ?></td>
                                                    <td class="text-end font-monospace"><?= number_format($hp, 0, ',', '.') ?></td>
                                                    <td class="text-end font-monospace"><?= number_format($kt, 0, ',', '.') ?></td>
                                                    <td class="text-end font-monospace fw-bold text-success"><?= number_format($sel, 0, ',', '.') ?></td>
                                                    <td class="text-end font-monospace fw-bold text-info"><?= number_format($pct, 2, ',', '.') ?>%</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <?php
                                        $totSelisih = $sumEfPagu - $sumEfKontrak;
                                        $totPct     = $sumEfPagu > 0 ? round(($totSelisih / $sumEfPagu) * 100, 2) : 0.0;
                                        ?>
                                        <tfoot class="table-light fw-bold">
                                            <tr>
                                                <td colspan="2" class="text-end">TOTAL EFISIENSI</td>
                                                <td class="text-end font-monospace"><?= number_format($sumEfPaket, 0, ',', '.') ?></td>
                                                <td class="text-end font-monospace"><?= number_format($sumEfPagu, 0, ',', '.') ?></td>
                                                <td class="text-end font-monospace"><?= number_format($sumEfHps, 0, ',', '.') ?></td>
                                                <td class="text-end font-monospace"><?= number_format($sumEfKontrak, 0, ',', '.') ?></td>
                                                <td class="text-end font-monospace text-success"><?= number_format($totSelisih, 0, ',', '.') ?></td>
                                                <td class="text-end font-monospace text-info"><?= number_format($totPct, 2, ',', '.') ?>%</td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
</body>
</html>
