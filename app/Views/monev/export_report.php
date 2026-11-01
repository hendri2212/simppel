<?php
/**
 * View: Export Laporan e-MONEV (Printable PDF & Microsoft Excel .xls)
 * Mengadopsi satu_report.php s/d delapan_report.php pada aplikasi referensi simppel.
 */
$isExcel     = ($exportType ?? 'pdf') === 'excel';
$moduleKey   = $moduleKey ?? 'satu';
$reportTitle = $reportTitle ?? 'LAPORAN e-MONEV';
$filters     = $filters ?? [];
$payload     = $payload ?? [];
$rows        = $payload['rows'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($reportTitle) ?> - TA <?= (int) ($filters['tahun'] ?? date('Y')) ?></title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 16px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 16px;
            border-bottom: 2px solid #111827;
            padding-bottom: 10px;
        }
        .report-header h2, .report-header h3, .report-header h4 {
            margin: 3px 0;
        }
        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        table.report-table th, table.report-table td {
            border: 1px solid #374151;
            padding: 5px 7px;
            vertical-align: top;
        }
        table.report-table th {
            background-color: #e5e7eb;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 10px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .no-print {
            margin-bottom: 14px;
            display: flex;
            gap: 8px;
        }
        .btn-print {
            padding: 6px 14px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

<?php if (! $isExcel): ?>
    <div class="no-print">
        <button type="button" class="btn-print" onclick="window.print()">Cetak / Simpan sebagai PDF</button>
        <button type="button" class="btn-print" style="background:#64748b;" onclick="window.close()">Tutup</button>
    </div>
<?php endif; ?>

<div class="report-header">
    <h2>LAPORAN MONITORING & EVALUASI PENGADAAN (e-MONEV)</h2>
    <h3><?= esc($reportTitle) ?></h3>
    <h4>INSTANSI: <?= esc($filters['selected_skpd_name'] ?? 'SEMUA INSTANSI') ?> — TAHUN ANGGARAN <?= (int) ($filters['tahun'] ?? date('Y')) ?></h4>
</div>

<?php if (in_array($moduleKey, ['satu', 'dua'], true)): ?>
    <?php $totalPagu = 0.0; ?>
    <table class="report-table" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Paket RUP</th>
                <th>Nama Paket</th>
                <th>Jenis Pekerjaan</th>
                <th>Dinas / Instansi</th>
                <th>PPK</th>
                <th>Pagu (Rp)</th>
                <th>Waktu Pekerjaan</th>
                <th>Rencana Pengajuan</th>
                <th>DAK / Non-DAK</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $i => $r):
                $pg = (float) ($r['budget_ceiling'] ?? 0);
                $totalPagu += $pg;
            ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td class="text-center"><?= esc($r['rup_code'] ?: $r['id']) ?></td>
                    <td><?= esc($r['package_name']) ?></td>
                    <td><?= esc($r['jenis_pengadaan_name'] ?: '-') ?></td>
                    <td><?= esc($r['skpd_name'] ?: '-') ?></td>
                    <td><?= esc($r['ppk_name'] ?: '-') ?></td>
                    <td class="text-right"><?= number_format($pg, 0, ',', '.') ?></td>
                    <td class="text-center"><?= esc($r['work_duration'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($r['submission_date'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($r['jenis_dak_name'] ?: '-') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fw-bold">
                <td colspan="6" class="text-right">TOTAL PAGU ANGGARAN</td>
                <td class="text-right"><?= number_format($totalPagu, 0, ',', '.') ?></td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

<?php elseif ($moduleKey === 'tiga'): ?>
    <?php
    $bulanNames     = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];
    $rencanaBulan   = $payload['rencana_bulan'] ?? [];
    $realisasiBulan = $payload['realisasi_bulan'] ?? [];
    $rekapPaket     = $payload['rekap_paket'] ?? [];
    $rekapPagu      = $payload['rekap_pagu'] ?? [];
    $efisiensiRows  = $payload['efisiensi_rows'] ?? [];
    $jenisList      = $payload['jenis_list'] ?? [];
    ?>
    <h4>1. RENCANA LELANG PERBULAN</h4>
    <table class="report-table" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Uraian</th>
                <?php foreach ($bulanNames as $mLabel): ?><th><?= $mLabel ?></th><?php endforeach; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $sumRP = 0; $sumRPagu = 0.0; ?>
            <tr>
                <td class="text-center">1</td>
                <td>Berdasarkan Jumlah Paket</td>
                <?php for ($m = 1; $m <= 12; $m++): $v = (int) ($rencanaBulan[$m]['paket'] ?? 0); $sumRP += $v; ?>
                    <td class="text-right"><?= number_format($v, 0, ',', '.') ?></td>
                <?php endfor; ?>
                <td class="text-right fw-bold"><?= number_format($sumRP, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Berdasarkan Jumlah Pagu (Rp)</td>
                <?php for ($m = 1; $m <= 12; $m++): $p = (float) ($rencanaBulan[$m]['pagu'] ?? 0); $sumRPagu += $p; ?>
                    <td class="text-right"><?= number_format($p, 0, ',', '.') ?></td>
                <?php endfor; ?>
                <td class="text-right fw-bold"><?= number_format($sumRPagu, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <h4>2. REALISASI LELANG MASUK PERBULAN</h4>
    <table class="report-table" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Uraian</th>
                <?php foreach ($bulanNames as $mLabel): ?><th><?= $mLabel ?></th><?php endforeach; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $sumMP = 0; $sumMPagu = 0.0; $sumMHps = 0.0; ?>
            <tr>
                <td class="text-center">1</td>
                <td>Berdasarkan Jumlah Paket</td>
                <?php for ($m = 1; $m <= 12; $m++): $v = (int) ($realisasiBulan[$m]['paket'] ?? 0); $sumMP += $v; ?>
                    <td class="text-right"><?= number_format($v, 0, ',', '.') ?></td>
                <?php endfor; ?>
                <td class="text-right fw-bold"><?= number_format($sumMP, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Berdasarkan Jumlah Pagu (Rp)</td>
                <?php for ($m = 1; $m <= 12; $m++): $p = (float) ($realisasiBulan[$m]['pagu'] ?? 0); $sumMPagu += $p; ?>
                    <td class="text-right"><?= number_format($p, 0, ',', '.') ?></td>
                <?php endfor; ?>
                <td class="text-right fw-bold"><?= number_format($sumMPagu, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Berdasarkan Nilai HPS (Rp)</td>
                <?php for ($m = 1; $m <= 12; $m++): $h = (float) ($realisasiBulan[$m]['hps'] ?? 0); $sumMHps += $h; ?>
                    <td class="text-right"><?= number_format($h, 0, ',', '.') ?></td>
                <?php endfor; ?>
                <td class="text-right fw-bold"><?= number_format($sumMHps, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <h4>3. EFISIENSI LELANG SELESAI PER JENIS PEKERJAAN</h4>
    <table class="report-table" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Pekerjaan</th>
                <th>Paket Selesai</th>
                <th>Pagu (Rp)</th>
                <th>HPS (Rp)</th>
                <th>Nilai Kontrak (Rp)</th>
                <th>Efisiensi (Rp)</th>
                <th>Efisiensi (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($efisiensiRows as $ef):
                $pg  = (float) $ef['pagu'];
                $hp  = (float) $ef['hps'];
                $kt  = (float) $ef['kontrak'];
                $sel = $pg - $kt;
                $pct = $pg > 0 ? round(($sel / $pg) * 100, 2) : 0.0;
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= esc($ef['name']) ?></td>
                    <td class="text-right"><?= number_format((int) $ef['paket'], 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($pg, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($hp, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($kt, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($sel, 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($pct, 2, ',', '.') ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php elseif ($moduleKey === 'empat'): ?>
    <table class="report-table" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>No Paket</th>
                <th>Nama Paket</th>
                <th>Jenis Pekerjaan</th>
                <th>Dinas / Instansi</th>
                <th>PPK</th>
                <th>HPS (Rp)</th>
                <th>Tgl Distribusi</th>
                <th>Anggota Pokja</th>
                <th>Status</th>
                <th>Lama Proses (Hari)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $i => $r):
                $pokjaNames = array_map(static fn($m) => $m['full_name'], $r['pokja_members'] ?? []);
            ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td class="text-center"><?= esc($r['no_paket'] ?: $r['id']) ?></td>
                    <td><?= esc($r['package_name']) ?></td>
                    <td><?= esc($r['jenis_pengadaan_name'] ?: '-') ?></td>
                    <td><?= esc($r['skpd_name'] ?: '-') ?></td>
                    <td><?= esc($r['ppk_name'] ?: '-') ?></td>
                    <td class="text-right"><?= number_format((float) ($r['nilai_hps'] ?? 0), 0, ',', '.') ?></td>
                    <td class="text-center"><?= esc($r['tgl_distribusi'] ?: '-') ?></td>
                    <td><?= esc(implode(', ', $pokjaNames) ?: '-') ?></td>
                    <td class="text-center"><?= esc($r['status_label']) ?></td>
                    <td class="text-center"><?= $r['lama_proses_hari'] !== null ? ((int) $r['lama_proses_hari'] . ' hari') : '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php elseif ($moduleKey === 'tujuh'): ?>
    <table class="report-table" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>No Paket</th>
                <th>Nama Paket</th>
                <th>Dinas / Instansi</th>
                <th>PPK</th>
                <th>Pagu (Rp)</th>
                <th>HPS (Rp)</th>
                <th>Nilai Kontrak (Rp)</th>
                <th>Efisiensi (Rp)</th>
                <th>Efisiensi (%)</th>
                <th>Nama Pemenang</th>
                <th>Alamat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $i => $r): ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td class="text-center"><?= esc($r['no_paket'] ?: $r['id']) ?></td>
                    <td><?= esc($r['package_name']) ?></td>
                    <td><?= esc($r['skpd_name'] ?: '-') ?></td>
                    <td><?= esc($r['ppk_name'] ?: '-') ?></td>
                    <td class="text-right"><?= number_format((float) ($r['pagu_rup'] ?? 0), 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format((float) ($r['nilai_hps'] ?? 0), 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format((float) ($r['nilai_kontrak'] ?? 0), 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format((float) ($r['efisiensi_rp'] ?? 0), 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format((float) ($r['efisiensi_persen'] ?? 0), 2, ',', '.') ?>%</td>
                    <td><?= esc($r['nama_pemenang'] ?: '-') ?></td>
                    <td><?= esc($r['alamat'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($r['status_label']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <table class="report-table" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>No Paket</th>
                <th>Nama Paket</th>
                <th>Jenis Pekerjaan</th>
                <th>Dinas / Instansi</th>
                <th>PPK</th>
                <th>Pengajuan Awal</th>
                <th>Pagu (Rp)</th>
                <th>HPS (Rp)</th>
                <th>Status</th>
                <th>DAK / Non-DAK</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $i => $r): ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td class="text-center"><?= esc($r['no_paket'] ?: $r['id']) ?></td>
                    <td><?= esc($r['package_name']) ?></td>
                    <td><?= esc($r['jenis_pengadaan_name'] ?: '-') ?></td>
                    <td><?= esc($r['skpd_name'] ?: '-') ?></td>
                    <td><?= esc($r['ppk_name'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($r['tgl_pengajuan'] ?: '-') ?></td>
                    <td class="text-right"><?= number_format((float) ($r['pagu_rup'] ?? 0), 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format((float) ($r['nilai_hps'] ?? 0), 0, ',', '.') ?></td>
                    <td class="text-center"><?= esc($r['status_label']) ?></td>
                    <td class="text-center"><?= esc($r['jenis_dak_name'] ?: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (! $isExcel): ?>
    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
<?php endif; ?>

</body>
</html>
