<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => ($moduleMeta['title'] ?? 'Paket Lelang') . " - e-MONEV SIMPPEL")) ?>
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
                        "pageTitle"     => "Modul " . (int) ($moduleMeta['number'] ?? 5) . ": " . ($moduleMeta['title'] ?? 'Daftar Paket Lelang'),
                        "pageSubTitle1" => "e-MONEV",
                        "pageSubTitle2" => $moduleMeta['title'] ?? 'Paket Lelang',
                        "pageSubText"   => $moduleMeta['subtitle'] ?? ''
                    )) ?>

                    <?php
                    $isSelesaiModule = ($moduleKey === 'tujuh');
                    $totalPagu       = array_sum(array_map(static fn($r) => (float) ($r['pagu_rup'] ?? 0), $rows));
                    $totalHps        = array_sum(array_map(static fn($r) => (float) ($r['nilai_hps'] ?? 0), $rows));
                    $totalKontrak    = array_sum(array_map(static fn($r) => (float) ($r['nilai_kontrak'] ?? 0), $rows));
                    $totalEfisiensi  = array_sum(array_map(static fn($r) => (float) ($r['efisiensi_rp'] ?? 0), $rows));
                    ?>

                    <div class="main-content">

                        <?= view('monev/partials/header_and_filter', [
                            'moduleKey'  => $moduleKey,
                            'modules'    => $modules,
                            'filters'    => $filters,
                            'showSearch' => true,
                            'showJenis'  => true,
                            'showPokja'  => false,
                            'showExport' => true,
                        ]) ?>

                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-body d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
                                <div>
                                    <h5 class="fw-bold mb-0" id="monevPaketTableHeading">
                                        <?= esc($moduleMeta['title']) ?> — Tahun Anggaran <?= (int) $filters['tahun'] ?>
                                    </h5>
                                    <small class="text-muted">
                                        Instansi: <strong><?= esc($filters['selected_skpd_name']) ?></strong> |
                                        Total Data: <strong><?= count($rows) ?> Paket</strong> |
                                        Total HPS: <strong class="text-primary font-monospace">Rp <?= number_format($totalHps, 0, ',', '.') ?></strong>
                                        <?php if ($isSelesaiModule): ?>
                                            | Total Efisiensi: <strong class="text-success font-monospace">Rp <?= number_format($totalEfisiensi, 0, ',', '.') ?></strong>
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="monev-table-region" tabindex="0" role="region" aria-labelledby="monevPaketTableHeading">
                                    <table class="table table-hover table-bordered align-middle table-monev">
                                        <thead>
                                            <?php if ($isSelesaiModule): ?>
                                                <tr>
                                                    <th class="text-center" style="width: 45px;">No</th>
                                                    <th style="width: 90px;">No Paket</th>
                                                    <th style="min-width: 240px;">Nama Paket</th>
                                                    <th style="min-width: 175px;">Dinas / Instansi</th>
                                                    <th style="min-width: 145px;">PPK</th>
                                                    <th class="text-end" style="width: 140px;">Pagu (Rp)</th>
                                                    <th class="text-end" style="width: 140px;">HPS (Rp)</th>
                                                    <th class="text-end" style="width: 145px;">Nilai Kontrak (Rp)</th>
                                                    <th class="text-end" style="width: 145px;">Efisiensi (Rp)</th>
                                                    <th class="text-end" style="width: 90px;">Efisiensi (%)</th>
                                                    <th style="min-width: 180px;">Nama Pemenang & Alamat</th>
                                                    <th class="text-center" style="width: 110px;">Status</th>
                                                    <th class="text-center" style="width: 80px;">Detail</th>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <th class="text-center" style="width: 45px;">No</th>
                                                    <th style="width: 95px;">No Paket</th>
                                                    <th style="min-width: 250px;">Nama Paket</th>
                                                    <th style="width: 145px;">Jenis Pekerjaan</th>
                                                    <th style="min-width: 185px;">Dinas / Instansi</th>
                                                    <th style="min-width: 155px;">PPK</th>
                                                    <th class="text-center" style="width: 120px;">Pengajuan Awal</th>
                                                    <th class="text-end" style="width: 150px;">Pagu (Rp)</th>
                                                    <th class="text-end" style="width: 150px;">HPS (Rp)</th>
                                                    <th class="text-center" style="width: 135px;">Status</th>
                                                    <th class="text-center" style="width: 95px;">DAK</th>
                                                    <th class="text-center" style="width: 85px;">Detail</th>
                                                </tr>
                                            <?php endif; ?>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($rows)): ?>
                                                <tr>
                                                    <td colspan="<?= $isSelesaiModule ? 13 : 12 ?>" class="text-center py-5 text-muted">
                                                        Tidak ada data paket pengadaan yang ditemukan untuk filter yang dipilih.
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($rows as $idx => $r):
                                                    $st = (int) ($r['status_paket'] ?? 0);
                                                    $badgeCls = $st === 14 ? 'bg-success-subtle text-success border-success-subtle'
                                                        : ($st === 15 || $st === 0 ? 'bg-danger-subtle text-danger border-danger-subtle'
                                                        : 'bg-warning-subtle text-warning-emphasis border-warning-subtle');
                                                ?>
                                                    <?php if ($isSelesaiModule): ?>
                                                        <tr>
                                                            <td class="text-center text-muted"><?= $idx + 1 ?></td>
                                                            <td class="font-monospace fw-bold text-primary"><?= esc($r['no_paket'] ?: ('#' . $r['id'])) ?></td>
                                                            <td>
                                                                <div class="fw-semibold text-body-emphasis"><?= esc($r['package_name']) ?></div>
                                                                <div class="fs-xs text-muted font-monospace">RUP: <?= esc($r['rup_code'] ?: '-') ?></div>
                                                            </td>
                                                            <td><?= esc($r['skpd_name'] ?: '-') ?></td>
                                                            <td><?= esc($r['ppk_name'] ?: '-') ?></td>
                                                            <td class="text-end font-monospace"><?= number_format((float) ($r['pagu_rup'] ?? 0), 0, ',', '.') ?></td>
                                                            <td class="text-end font-monospace"><?= number_format((float) ($r['nilai_hps'] ?? 0), 0, ',', '.') ?></td>
                                                            <td class="text-end font-monospace fw-bold text-primary"><?= number_format((float) ($r['nilai_kontrak'] ?? 0), 0, ',', '.') ?></td>
                                                            <td class="text-end font-monospace fw-bold text-success"><?= number_format((float) ($r['efisiensi_rp'] ?? 0), 0, ',', '.') ?></td>
                                                            <td class="text-end font-monospace fw-bold text-info"><?= number_format((float) ($r['efisiensi_persen'] ?? 0), 2, ',', '.') ?>%</td>
                                                            <td>
                                                                <div class="fw-semibold"><?= esc($r['nama_pemenang'] ?: '-') ?></div>
                                                                <?php if (! empty($r['alamat'])): ?>
                                                                    <div class="fs-xs text-muted"><?= esc($r['alamat']) ?></div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge border <?= $badgeCls ?>"><?= esc($r['status_label']) ?></span>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-outline-primary btn-xs px-2 py-1"
                                                                        onclick="openMonevPaketDetail(<?= (int) $r['id'] ?>)">
                                                                    Detail
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td class="text-center text-muted"><?= $idx + 1 ?></td>
                                                            <td class="font-monospace fw-bold text-primary"><?= esc($r['no_paket'] ?: ('#' . $r['id'])) ?></td>
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
                                                            <td class="text-center font-monospace fs-xs">
                                                                <?= ! empty($r['tgl_pengajuan']) ? date('d-m-Y', strtotime($r['tgl_pengajuan'])) : '-' ?>
                                                            </td>
                                                            <td class="text-end font-monospace"><?= number_format((float) ($r['pagu_rup'] ?? 0), 0, ',', '.') ?></td>
                                                            <td class="text-end font-monospace fw-bold text-primary"><?= number_format((float) ($r['nilai_hps'] ?? 0), 0, ',', '.') ?></td>
                                                            <td class="text-center">
                                                                <span class="badge border <?= $badgeCls ?>"><?= esc($r['status_label']) ?></span>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                                    <?= esc($r['jenis_dak_name'] ?: '-') ?>
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-outline-primary btn-xs px-2 py-1"
                                                                        onclick="openMonevPaketDetail(<?= (int) $r['id'] ?>)">
                                                                    Detail
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                        <?php if (! empty($rows)): ?>
                                            <tfoot class="table-light fw-bold">
                                                <?php if ($isSelesaiModule): ?>
                                                    <tr>
                                                        <td colspan="5" class="text-end">TOTAL</td>
                                                        <td class="text-end font-monospace"><?= number_format($totalPagu, 0, ',', '.') ?></td>
                                                        <td class="text-end font-monospace"><?= number_format($totalHps, 0, ',', '.') ?></td>
                                                        <td class="text-end font-monospace text-primary"><?= number_format($totalKontrak, 0, ',', '.') ?></td>
                                                        <td class="text-end font-monospace text-success"><?= number_format($totalEfisiensi, 0, ',', '.') ?></td>
                                                        <td colspan="4"></td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="7" class="text-end">TOTAL</td>
                                                        <td class="text-end font-monospace"><?= number_format($totalPagu, 0, ',', '.') ?></td>
                                                        <td class="text-end font-monospace text-primary"><?= number_format($totalHps, 0, ',', '.') ?></td>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tfoot>
                                        <?php endif; ?>
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

    <?= view('monev/partials/detail_modals') ?>
    <?= $this->include('partials/app-scripts') ?>
</body>
</html>
