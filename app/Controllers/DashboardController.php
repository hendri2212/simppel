<?php

namespace App\Controllers;

use App\Controllers\Traits\ProcurementScope;
use App\Libraries\PaketWorkflow;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Dashboard Control Center SIMPPEL.
 *
 * - index(): render halaman dashboard (kerangka + filter).
 * - data():  endpoint JSON berisi seluruh dataset grafik, sudah dibatasi
 *            sesuai cakupan role (PPK/ADMIN PPK hanya SKPD/PPK miliknya).
 */
class DashboardController extends BaseController
{
    use ProcurementScope;

    /** Kelompok status paket untuk visualisasi pipeline. */
    private const STAGES = [
        'draft'      => ['label' => 'Draft',               'status' => [1]],
        'verifikasi' => ['label' => 'Verifikasi ULP',      'status' => [2, 3]],
        'distribusi' => ['label' => 'Diterima/Distribusi', 'status' => [4, 5, 6]],
        'kaji'       => ['label' => 'Kaji Ulang',          'status' => [7, 8]],
        'lelang'     => ['label' => 'Proses Lelang',       'status' => [9, 10, 11, 13]],
        'hasil'      => ['label' => 'Hasil Lelang',        'status' => [12]],
        'selesai'    => ['label' => 'Selesai',             'status' => [14]],
        'gagal'      => ['label' => 'Gagal/Batal',         'status' => [0, 15]],
    ];

    public function index()
    {
        $db    = db_connect();
        $actor = $this->actor();

        $years = array_map(
            static fn ($r) => (int) $r['fiscal_year'],
            $db->table('rup')->select('DISTINCT(fiscal_year) AS fiscal_year')
                ->where('fiscal_year IS NOT NULL')->orderBy('fiscal_year', 'DESC')
                ->get()->getResultArray()
        );
        if (! in_array((int) date('Y'), $years, true)) {
            $years[] = (int) date('Y');
            rsort($years);
        }

        $skpdList = $this->hasGlobalScope()
            ? $db->table('skpd')->select('id, name')->where('is_active', 1)->orderBy('name')->get()->getResultArray()
            : [];

        return view('dashboard-control-center', [
            'years'       => $years,
            'defaultYear' => $years[0] ?? (int) date('Y'),
            'skpdList'    => $skpdList,
            'isGlobal'    => $this->hasGlobalScope(),
            'roleName'    => strtoupper((string) $actor['role_name']),
            'fullName'    => (string) $actor['full_name'],
        ]);
    }

    /**
     * GET /dashboard-control-center/data?tahun=2026&skpd_id=0
     */
    public function data(): ResponseInterface
    {
        $tahun  = (int) ($this->request->getGet('tahun') ?: date('Y'));
        $skpdId = $this->hasGlobalScope() ? (int) ($this->request->getGet('skpd_id') ?? 0) : 0;

        $rups   = $this->loadRups($tahun, $skpdId);
        $pakets = $this->loadPakets($tahun, $skpdId);

        return $this->response->setJSON([
            'status'    => 'success',
            'generated' => date('Y-m-d H:i:s'),
            'filter'    => ['tahun' => $tahun, 'skpd_id' => $skpdId],
            'kpi'       => $this->buildKpi($rups, $pakets),
            'monthly'   => $this->buildMonthly($rups, $pakets),
            'pipeline'  => $this->buildPipeline($pakets),
            'jenis'     => $this->groupBy($rups, 'jenis_pengadaan_name'),
            'metode'    => $this->groupBy($rups, 'metode_pemilihan_name'),
            'sumber'    => $this->groupBy($rups, 'sumber_dana_name'),
            'topSkpd'   => array_slice($this->groupBy($rups, 'skpd_name', 'pagu'), 0, 10),
            'aging'     => $this->buildAging($pakets),
            'pokja'     => $this->buildPokjaLoad($pakets),
            'myQueue'   => $this->buildMyQueue($pakets),
            'activity'  => $this->buildActivity(array_column($pakets, 'id')),
        ]);
    }

    // ---------------------------------------------------------------------
    // Loader data (sudah dibatasi cakupan role)
    // ---------------------------------------------------------------------

    private function loadRups(int $tahun, int $skpdId): array
    {
        $b = db_connect()->table('rup')
            ->select('rup.id, rup.skpd_id, rup.ppk_id, rup.budget_ceiling, rup.submission_date, rup.rup_status,
                      skpd.name AS skpd_name, jenis_pengadaan.name AS jenis_pengadaan_name,
                      metode_pemilihan.name AS metode_pemilihan_name, sumber_dana.name AS sumber_dana_name')
            ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
            ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
            ->join('metode_pemilihan', 'metode_pemilihan.id = rup.metode_pemilihan_id', 'left')
            ->join('sumber_dana', 'sumber_dana.id = rup.sumber_dana_id', 'left')
            ->where('rup.fiscal_year', $tahun);

        if ($skpdId > 0) {
            $b->where('rup.skpd_id', $skpdId);
        }
        $this->scopeToActor($b, 'rup.skpd_id', 'rup.ppk_id');

        return $b->get()->getResultArray();
    }

    private function loadPakets(int $tahun, int $skpdId): array
    {
        $b = db_connect()->table('paket')
            ->select('paket.id, paket.no_paket, paket.status_paket, paket.nilai_hps, paket.nilai_kontrak,
                      paket.tgl_pengajuan, paket.tgl_paket, paket.tgl_penetapan, paket.updated_at, paket.created_at,
                      paket.admin_ukpbj_id, paket.is_lpse,
                      rup.package_name, rup.budget_ceiling, rup.skpd_id, rup.ppk_id')
            ->join('rup', 'rup.id = paket.rup_id', 'inner')
            ->where('rup.fiscal_year', $tahun);

        if ($skpdId > 0) {
            $b->where('rup.skpd_id', $skpdId);
        }
        $this->scopeToActor($b, 'rup.skpd_id', 'rup.ppk_id');

        $rows = $b->get()->getResultArray();
        if ($rows === []) {
            return [];
        }

        // Lampirkan anggota Pokja per paket
        $members = [];
        $pp = db_connect()->table('paket_pokja')
            ->select('paket_pokja.paket_id, paket_pokja.user_id, users.full_name')
            ->join('users', 'users.id = paket_pokja.user_id', 'left')
            ->whereIn('paket_pokja.paket_id', array_column($rows, 'id'))
            ->get()->getResultArray();
        foreach ($pp as $m) {
            $members[(int) $m['paket_id']][] = ['id' => (int) $m['user_id'], 'name' => (string) $m['full_name']];
        }
        foreach ($rows as &$r) {
            $r['pokja'] = $members[(int) $r['id']] ?? [];
        }
        unset($r);

        return $rows;
    }

    // ---------------------------------------------------------------------
    // Builder dataset
    // ---------------------------------------------------------------------

    private function buildKpi(array $rups, array $pakets): array
    {
        $totalPagu   = array_sum(array_map(static fn ($r) => (float) $r['budget_ceiling'], $rups));
        $submitted   = array_filter($pakets, static fn ($p) => (int) $p['status_paket'] !== 1);
        $selesai     = array_filter($pakets, static fn ($p) => (int) $p['status_paket'] === 14);
        $proses      = array_filter($pakets, static fn ($p) => ! in_array((int) $p['status_paket'], [0, 1, 14, 15], true));
        $paguSelesai = array_sum(array_map(static fn ($p) => (float) $p['budget_ceiling'], $selesai));
        $kontrak     = array_sum(array_map(static fn ($p) => (float) $p['nilai_kontrak'], $selesai));
        $hps         = array_sum(array_map(static fn ($p) => (float) $p['nilai_hps'], $submitted));
        $belumMasuk  = count(array_filter($rups, static fn ($r) => (int) $r['rup_status'] === 1));

        return [
            'total_rup'        => count($rups),
            'total_pagu'       => $totalPagu,
            'belum_masuk'      => $belumMasuk,
            'paket_masuk'      => count($submitted),
            'paket_proses'     => count($proses),
            'paket_selesai'    => count($selesai),
            'total_hps'        => $hps,
            'total_kontrak'    => $kontrak,
            'efisiensi_rp'     => max(0, $paguSelesai - $kontrak),
            'efisiensi_persen' => $paguSelesai > 0 ? round(($paguSelesai - $kontrak) / $paguSelesai * 100, 2) : 0,
            'serapan_persen'   => count($rups) > 0 ? round(count($submitted) / count($rups) * 100, 1) : 0,
            'selesai_persen'   => count($submitted) > 0 ? round(count($selesai) / count($submitted) * 100, 1) : 0,
        ];
    }

    private function buildMonthly(array $rups, array $pakets): array
    {
        $empty = array_fill(1, 12, 0);
        $out   = [
            'rencana_paket' => $empty, 'rencana_pagu' => $empty,
            'masuk_paket'   => $empty, 'masuk_hps'    => $empty,
            'selesai_paket' => $empty, 'kontrak'      => $empty,
        ];

        foreach ($rups as $r) {
            if ($m = $this->month($r['submission_date'] ?? null)) {
                $out['rencana_paket'][$m]++;
                $out['rencana_pagu'][$m] += (float) $r['budget_ceiling'];
            }
        }
        foreach ($pakets as $p) {
            $st = (int) $p['status_paket'];
            if ($st !== 1 && ($m = $this->month($p['tgl_pengajuan'] ?: $p['tgl_paket']))) {
                $out['masuk_paket'][$m]++;
                $out['masuk_hps'][$m] += (float) $p['nilai_hps'];
            }
            if ($st === 14 && ($m = $this->month($p['tgl_penetapan'] ?: $p['updated_at']))) {
                $out['selesai_paket'][$m]++;
                $out['kontrak'][$m] += (float) $p['nilai_kontrak'];
            }
        }

        return array_map('array_values', $out);
    }

    private function buildPipeline(array $pakets): array
    {
        $out = [];
        foreach (self::STAGES as $key => $def) {
            $rows  = array_filter($pakets, static fn ($p) => in_array((int) $p['status_paket'], $def['status'], true));
            $out[] = [
                'key'   => $key,
                'label' => $def['label'],
                'count' => count($rows),
                'hps'   => array_sum(array_map(static fn ($p) => (float) $p['nilai_hps'], $rows)),
            ];
        }

        // Rincian per status (0-15) untuk tooltip/tabel
        $detail = [];
        foreach (PaketWorkflow::STATUS_LABELS as $code => $label) {
            $detail[] = [
                'code'  => $code,
                'label' => $label,
                'count' => count(array_filter($pakets, static fn ($p) => (int) $p['status_paket'] === $code)),
            ];
        }

        return ['stages' => $out, 'detail' => $detail];
    }

    /**
     * Kelompokkan RUP per kolom: jumlah paket & total pagu, urut menurun.
     */
    private function groupBy(array $rows, string $field, string $sortBy = 'count'): array
    {
        $g = [];
        foreach ($rows as $r) {
            $k = trim((string) ($r[$field] ?? '')) ?: 'Tidak Diketahui';
            $g[$k] ??= ['label' => $k, 'count' => 0, 'pagu' => 0.0];
            $g[$k]['count']++;
            $g[$k]['pagu'] += (float) $r['budget_ceiling'];
        }
        usort($g, static fn ($a, $b) => $b[$sortBy] <=> $a[$sortBy]);

        return array_values($g);
    }

    /**
     * Umur paket yang masih berjalan (hari sejak diajukan).
     */
    private function buildAging(array $pakets): array
    {
        $buckets = ['0-7 hari' => 0, '8-14 hari' => 0, '15-30 hari' => 0, '31-60 hari' => 0, '> 60 hari' => 0];
        $oldest  = [];
        $today   = new \DateTimeImmutable('today');

        foreach ($pakets as $p) {
            if (in_array((int) $p['status_paket'], [0, 1, 14, 15], true)) {
                continue;
            }
            $start = $p['tgl_pengajuan'] ?: ($p['tgl_paket'] ?: $p['created_at']);
            if (! $start) {
                continue;
            }
            try {
                $days = (int) (new \DateTimeImmutable(substr((string) $start, 0, 10)))->diff($today)->format('%a');
            } catch (\Throwable) {
                continue;
            }

            $key = match (true) {
                $days <= 7  => '0-7 hari',
                $days <= 14 => '8-14 hari',
                $days <= 30 => '15-30 hari',
                $days <= 60 => '31-60 hari',
                default     => '> 60 hari',
            };
            $buckets[$key]++;

            $oldest[] = [
                'id'     => (int) $p['id'],
                'name'   => (string) $p['package_name'],
                'no'     => (string) $p['no_paket'],
                'status' => PaketWorkflow::STATUS_LABELS[(int) $p['status_paket']] ?? '-',
                'days'   => $days,
            ];
        }
        usort($oldest, static fn ($a, $b) => $b['days'] <=> $a['days']);

        return [
            'labels' => array_keys($buckets),
            'values' => array_values($buckets),
            'oldest' => array_slice($oldest, 0, 5),
        ];
    }

    /**
     * Beban kerja Pokja: paket aktif vs selesai per anggota.
     */
    private function buildPokjaLoad(array $pakets): array
    {
        $load = [];
        foreach ($pakets as $p) {
            $st = (int) $p['status_paket'];
            foreach ($p['pokja'] as $m) {
                $load[$m['id']] ??= ['name' => $m['name'] ?: ('User #' . $m['id']), 'aktif' => 0, 'selesai' => 0];
                if ($st === 14) {
                    $load[$m['id']]['selesai']++;
                } elseif (! in_array($st, [0, 15], true)) {
                    $load[$m['id']]['aktif']++;
                }
            }
        }
        usort($load, static fn ($a, $b) => ($b['aktif'] + $b['selesai']) <=> ($a['aktif'] + $a['selesai']));

        return array_slice(array_values($load), 0, 12);
    }

    /**
     * Antrean tugas sesuai role user yang login (selaras dengan pill di halaman paket).
     */
    private function buildMyQueue(array $pakets): array
    {
        $actor = $this->actor();
        $role  = strtoupper((string) $actor['role_name']);
        $uid   = (int) $actor['id'];

        $count = static fn (callable $fn) => count(array_filter($pakets, $fn));
        $st    = static fn ($p) => (int) $p['status_paket'];
        $isMember = static fn ($p) => in_array($uid, array_column($p['pokja'], 'id'), true);

        $items = match ($role) {
            'PPK', 'ADMIN PPK' => [
                ['label' => 'Draft belum diajukan', 'count' => $count(fn ($p) => $st($p) === 1), 'color' => 'secondary'],
                ['label' => 'Dikembalikan ULP',     'count' => $count(fn ($p) => $st($p) === 3), 'color' => 'danger'],
                ['label' => 'Saran Kaji Ulang',     'count' => $count(fn ($p) => $st($p) === 7), 'color' => 'warning'],
                ['label' => 'Saran Addendum',       'count' => $count(fn ($p) => $st($p) === 10), 'color' => 'warning'],
                ['label' => 'Hasil Lelang (perlu keputusan)', 'count' => $count(fn ($p) => $st($p) === 12), 'color' => 'success'],
            ],
            'ADMIN ULP' => [
                ['label' => 'Paket baru belum dipilih', 'count' => $count(fn ($p) => $st($p) === 2 && (int) $p['admin_ukpbj_id'] === 0), 'color' => 'danger'],
                ['label' => 'Sedang saya verifikasi',   'count' => $count(fn ($p) => $st($p) === 2 && (int) $p['admin_ukpbj_id'] === $uid), 'color' => 'warning'],
                ['label' => 'Dikembalikan ke PPK',      'count' => $count(fn ($p) => $st($p) === 3 && (int) $p['admin_ukpbj_id'] === $uid), 'color' => 'secondary'],
                ['label' => 'Diterima oleh saya',       'count' => $count(fn ($p) => $st($p) >= 4 && (int) $p['admin_ukpbj_id'] === $uid), 'color' => 'success'],
            ],
            'DISTRIBUSI' => [
                ['label' => 'Diterima, perlu usulan Pokja', 'count' => $count(fn ($p) => $st($p) === 4), 'color' => 'danger'],
                ['label' => 'Menunggu Kepala ULP',          'count' => $count(fn ($p) => $st($p) === 5), 'color' => 'warning'],
                ['label' => 'Sudah terdistribusi',          'count' => $count(fn ($p) => $st($p) >= 6), 'color' => 'success'],
            ],
            'KEPALA ULP' => [
                ['label' => 'Usulan distribusi perlu ditetapkan', 'count' => $count(fn ($p) => $st($p) === 5), 'color' => 'danger'],
                ['label' => 'Proses lelang berjalan',             'count' => $count(fn ($p) => $st($p) === 9), 'color' => 'info'],
                ['label' => 'Selesai',                            'count' => $count(fn ($p) => $st($p) === 14), 'color' => 'success'],
            ],
            'POKJA' => [
                ['label' => 'Distribusi baru',      'count' => $count(fn ($p) => $isMember($p) && $st($p) === 6), 'color' => 'danger'],
                ['label' => 'Selesai kaji ulang',   'count' => $count(fn ($p) => $isMember($p) && $st($p) === 8), 'color' => 'warning'],
                ['label' => 'Proses lelang',        'count' => $count(fn ($p) => $isMember($p) && in_array($st($p), [9, 11, 13], true)), 'color' => 'info'],
                ['label' => 'Hasil / selesai',      'count' => $count(fn ($p) => $isMember($p) && in_array($st($p), [12, 14, 15], true)), 'color' => 'success'],
            ],
            'ADMIN AGENCY' => [
                ['label' => 'Belum diproses Room LPSE', 'count' => $count(fn ($p) => $st($p) >= 6 && $st($p) <= 14 && (int) $p['is_lpse'] === 0), 'color' => 'danger'],
                ['label' => 'Sudah diproses LPSE',      'count' => $count(fn ($p) => (int) $p['is_lpse'] === 1), 'color' => 'success'],
            ],
            default => [
                ['label' => 'Verifikasi ULP',  'count' => $count(fn ($p) => in_array($st($p), [2, 3], true)), 'color' => 'warning'],
                ['label' => 'Distribusi',      'count' => $count(fn ($p) => in_array($st($p), [4, 5, 6], true)), 'color' => 'info'],
                ['label' => 'Proses lelang',   'count' => $count(fn ($p) => in_array($st($p), [7, 8, 9, 10, 11, 12, 13], true)), 'color' => 'primary'],
                ['label' => 'Selesai',         'count' => $count(fn ($p) => $st($p) === 14), 'color' => 'success'],
            ],
        };

        return ['role' => $role, 'items' => $items];
    }

    /**
     * 8 catatan/aktivitas terbaru pada paket dalam cakupan.
     */
    private function buildActivity(array $paketIds): array
    {
        if ($paketIds === []) {
            return [];
        }

        $rows = db_connect()->table('catatan')
            ->select('catatan.id, catatan.paket_id, catatan.status_paket, catatan.isi_catatan, catatan.created_at,
                      users.full_name, roles.name AS role_name, rup.package_name')
            ->join('users', 'users.id = catatan.user_id', 'left')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('paket', 'paket.id = catatan.paket_id', 'left')
            ->join('rup', 'rup.id = paket.rup_id', 'left')
            ->whereIn('catatan.paket_id', $paketIds)
            ->orderBy('catatan.created_at', 'DESC')
            ->limit(8)
            ->get()->getResultArray();

        return array_map(static fn ($r) => [
            'user'    => (string) $r['full_name'],
            'role'    => (string) $r['role_name'],
            'paket'   => (string) $r['package_name'],
            'status'  => PaketWorkflow::STATUS_LABELS[(int) $r['status_paket']] ?? '-',
            'note'    => mb_strimwidth(strip_tags((string) $r['isi_catatan']), 0, 140, '…'),
            'time'    => (string) $r['created_at'],
        ], $rows);
    }

    private function month(?string $date): int
    {
        if (empty($date)) {
            return 0;
        }
        $ts = strtotime($date);

        return $ts ? (int) date('n', $ts) : 0;
    }
}
