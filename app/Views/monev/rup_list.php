<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => ($moduleMeta['title'] ?? 'RUP e-MONEV') . " - SIMPPEL")) ?>
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
                        "pageTitle"     => "Modul " . (int) ($moduleMeta['number'] ?? 1) . ": " . ($moduleMeta['title'] ?? 'RUP'),
                        "pageSubTitle1" => "e-MONEV",
                        "pageSubTitle2" => $moduleMeta['title'] ?? 'RUP',
                        "pageSubText"   => $moduleMeta['subtitle'] ?? ''
                    )) ?>

                    <?php
                    $totalPagu = array_sum(array_map(static fn($r) => (float) ($r['budget_ceiling'] ?? 0), $rows));
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
                                    <h5 class="fw-bold mb-0" id="monevRupTableHeading">
                                        <?= esc($moduleMeta['title']) ?> — Tahun Anggaran <?= (int) $filters['tahun'] ?>
                                    </h5>
                                    <small class="text-muted">
                                        Instansi: <strong><?= esc($filters['selected_skpd_name']) ?></strong> |
                                        Total Data: <strong><?= count($rows) ?> Paket</strong> |
                                        Total Pagu: <strong class="text-primary font-monospace">Rp <?= number_format($totalPagu, 0, ',', '.') ?></strong>
                                    </small>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="monev-table-region" tabindex="0" role="region" aria-labelledby="monevRupTableHeading">
                                    <table class="table table-hover table-bordered align-middle table-monev">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 48px;">No</th>
                                                <th style="width: 115px;">ID Paket RUP</th>
                                                <th style="min-width: 260px;">Nama Paket</th>
                                                <th style="width: 145px;">Jenis Pekerjaan</th>
                                                <th style="min-width: 190px;">Dinas / Instansi</th>
                                                <th style="min-width: 165px;">PPK</th>
                                                <th class="text-end" style="width: 155px;">Pagu (Rp)</th>
                                                <th class="text-center" style="width: 120px;">Waktu Pekerjaan</th>
                                                <th class="text-center" style="width: 130px;">Rencana Pengajuan</th>
                                                <th class="text-center" style="width: 95px;">DAK</th>
                                                <th class="text-center" style="width: 85px;">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($rows)): ?>
                                                <tr>
                                                    <td colspan="11" class="text-center py-5 text-muted">
                                                        Tidak ada data RUP yang ditemukan untuk filter yang dipilih.
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($rows as $idx => $r): ?>
                                                    <tr>
                                                        <td class="text-center text-muted"><?= $idx + 1 ?></td>
                                                        <td class="font-monospace fw-semibold text-primary">
                                                            <?= esc($r['rup_code'] ?: ('#' . $r['id'])) ?>
                                                        </td>
                                                        <td>
                                                            <div class="fw-semibold text-body-emphasis"><?= esc($r['package_name']) ?></div>
                                                            <?php if (! empty($r['activity'])): ?>
                                                                <div class="fs-xs text-muted">Keg: <?= esc($r['activity']) ?></div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                                                <?= esc($r['jenis_pengadaan_name'] ?: '-') ?>
                                                            </span>
                                                        </td>
                                                        <td><?= esc($r['skpd_name'] ?: '-') ?></td>
                                                        <td>
                                                            <div class="fw-medium"><?= esc($r['ppk_name'] ?: '-') ?></div>
                                                            <?php if (! empty($r['ppk_nip'])): ?>
                                                                <div class="fs-xs text-muted font-monospace"><?= esc($r['ppk_nip']) ?></div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-end font-monospace fw-bold">
                                                            <?= number_format((float) ($r['budget_ceiling'] ?? 0), 0, ',', '.') ?>
                                                        </td>
                                                        <td class="text-center"><?= esc($r['work_duration'] ?: '-') ?></td>
                                                        <td class="text-center font-monospace fs-xs">
                                                            <?= ! empty($r['submission_date']) ? date('d-m-Y', strtotime($r['submission_date'])) : '-' ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                                <?= esc($r['jenis_dak_name'] ?: '-') ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-outline-primary btn-xs px-2 py-1"
                                                                    onclick="openMonevRupDetail(<?= (int) $r['id'] ?>)">
                                                                Detail
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                        <?php if (! empty($rows)): ?>
                                            <tfoot class="table-light fw-bold">
                                                <tr>
                                                    <td colspan="6" class="text-end">TOTAL PAGU ANGGARAN</td>
                                                    <td class="text-end font-monospace text-primary">
                                                        Rp <?= number_format($totalPagu, 0, ',', '.') ?>
                                                    </td>
                                                    <td colspan="4"></td>
                                                </tr>
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
