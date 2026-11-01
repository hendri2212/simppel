<?php

namespace App\Controllers;

use App\Controllers\Traits\ProcurementScope;
use App\Libraries\PaketWorkflow;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller e-MONEV (Monitoring & Evaluasi Pengadaan Barang/Jasa).
 *
 * Mengadopsi 8 modul e-MONEV dari aplikasi referensi simppel:
 * 1. RUP (Paket Lelang)          - /monev/rup (/monev/satu)
 * 2. Paket Lelang Belum Masuk    - /monev/belum-masuk (/monev/dua)
 * 3. Rekap Paket Data Lelang     - /monev/rekap (/monev/tiga & /rup/summary)
 * 4. Distribusi Pokja ULP        - /monev/distribusi-pokja (/monev/empat) [Khusus Role Pusat & Pokja]
 * 5. Daftar Paket Lelang         - /monev/daftar-paket (/monev/lima)
 * 6. Grafik Lelang               - /monev/grafik (/monev/enam)
 * 7. Paket Lelang Selesai        - /monev/paket-selesai (/monev/tujuh)
 * 8. Paket Lelang Dalam Proses   - /monev/paket-proses (/monev/delapan)
 */
class MonevController extends BaseController
{
    use ProcurementScope;

    /** Daftar definisi 8 modul e-MONEV */
    public const MODULES = [
        'satu' => [
            'number'   => 1,
            'key'      => 'satu',
            'slug'     => 'rup',
            'url'      => '/monev/rup',
            'title'    => 'RUP (Paket Lelang)',
            'subtitle' => 'Daftar seluruh Rencana Umum Pengadaan (RUP) paket lelang sesuai tahun anggaran dan instansi.',
            'icon'     => 'file-text',
            'color'    => 'primary',
        ],
        'dua' => [
            'number'   => 2,
            'key'      => 'dua',
            'slug'     => 'belum-masuk',
            'url'      => '/monev/belum-masuk',
            'title'    => 'Paket Belum Masuk',
            'subtitle' => 'Daftar paket pada RUP yang belum diajukan/masuk ke UKPBJ untuk proses pemilihan.',
            'icon'     => 'clock',
            'color'    => 'warning',
        ],
        'tiga' => [
            'number'   => 3,
            'key'      => 'tiga',
            'slug'     => 'rekap',
            'url'      => '/monev/rekap',
            'title'    => 'Rekap Paket Data Lelang',
            'subtitle' => 'Rekapitulasi rencana & realisasi lelang per bulan, rekap per jenis pengadaan, dan efisiensi lelang.',
            'icon'     => 'layers',
            'color'    => 'info',
        ],
        'empat' => [
            'number'   => 4,
            'key'      => 'empat',
            'slug'     => 'distribusi-pokja',
            'url'      => '/monev/distribusi-pokja',
            'title'    => 'Distribusi Pokja ULP',
            'subtitle' => 'Monitoring pembagian tugas anggota Pokja Pemilihan, lama proses lelang, dan grafik beban kerja/performa Pokja.',
            'icon'     => 'users',
            'color'    => 'purple',
        ],
        'lima' => [
            'number'   => 5,
            'key'      => 'lima',
            'slug'     => 'daftar-paket',
            'url'      => '/monev/daftar-paket',
            'title'    => 'Daftar Paket Lelang',
            'subtitle' => 'Daftar seluruh paket pengadaan yang telah diajukan ke UKPBJ lintas tahapan proses.',
            'icon'     => 'list',
            'color'    => 'indigo',
        ],
        'enam' => [
            'number'   => 6,
            'key'      => 'enam',
            'slug'     => 'grafik',
            'url'      => '/monev/grafik',
            'title'    => 'Grafik Lelang',
            'subtitle' => 'Visualisasi grafik rencana vs realisasi, perbandingan pengajuan, progres lelang, dan capaian per SKPD.',
            'icon'     => 'pie-chart',
            'color'    => 'danger',
        ],
        'tujuh' => [
            'number'   => 7,
            'key'      => 'tujuh',
            'slug'     => 'paket-selesai',
            'url'      => '/monev/paket-selesai',
            'title'    => 'Paket Lelang Selesai',
            'subtitle' => 'Daftar paket lelang yang telah selesai (penetapan pemenang), nilai kontrak, dan selisih efisiensi anggaran.',
            'icon'     => 'check-circle',
            'color'    => 'success',
        ],
        'delapan' => [
            'number'   => 8,
            'key'      => 'delapan',
            'slug'     => 'paket-proses',
            'url'      => '/monev/paket-proses',
            'title'    => 'Paket Dalam Proses',
            'subtitle' => 'Daftar paket lelang yang sedang berjalan di UKPBJ / Pokja Pemilihan (verifikasi, kaji ulang, tayang, evaluasi).',
            'icon'     => 'activity',
            'color'    => 'teal',
        ],
    ];

    /**
     * Cek apakah role saat ini memiliki akses ke modul e-MONEV tertentu.
     * Sesuai tabel user_monev pada simppel:
     * - Role Pusat & Pokja & Monev (GLOBAL_ROLES) memiliki akses ke seluruh 8 modul.
     * - Role PPK & ADMIN PPK memiliki akses ke 7 modul (kecuali Modul 4: Distribusi Pokja ULP).
     */
    protected function canAccessModule(string $moduleKey): bool
    {
        if ($moduleKey === 'empat') {
            return $this->hasGlobalScope();
        }

        return true;
    }

    /**
     * Daftar modul yang disertai status akses untuk user aktif.
     */
    protected function getAccessibleModules(): array
    {
        $modules = [];
        foreach (self::MODULES as $key => $meta) {
            $meta['allowed'] = $this->canAccessModule($key);
            $modules[$key]   = $meta;
        }

        return $modules;
    }

    /**
     * Ambil filter umum dari query string, sekaligus menerapkan penguncian SKPD bagi PPK / ADMIN PPK.
     */
    protected function resolveFilters(): array
    {
        $db    = db_connect();
        $actor = $this->actor();
        $role  = strtoupper(trim((string) ($actor['role_name'] ?? '')));

        // Daftar tahun anggaran yang tersedia di tabel RUP
        $yearRows = $db->table('rup')
            ->select('DISTINCT(fiscal_year) AS fiscal_year')
            ->where('fiscal_year IS NOT NULL')
            ->orderBy('fiscal_year', 'DESC')
            ->get()->getResultArray();
        $availableYears = array_map( static fn($r) => (int) $r['fiscal_year'], $yearRows);
        $currentYear    = (int) date('Y');
        if (! in_array($currentYear, $availableYears, true)) {
            $availableYears[] = $currentYear;
            rsort($availableYears);
        }
        $defaultYear = $availableYears[0] ?? $currentYear;

        $tahunReq = $this->request->getGet('tahun');
        $tahun    = ($tahunReq !== null && $tahunReq !== '') ? (int) $tahunReq : $defaultYear;

        // Penguncian SKPD untuk PPK & ADMIN PPK (sesuai MonevController di simppel)
        $isSkpdLocked = ! $this->hasGlobalScope();
        if ($isSkpdLocked) {
            $skpdId = (int) ($actor['skpd_id'] ?? 0);
            // Bila akun PPK belum memiliki skpd_id langsung tetapi terhubung ke ppk_id, ambil skpd_id dari tabel ppk
            if ($skpdId === 0 && ! empty($actor['ppk_id'])) {
                $ppkRow = $db->table('ppk')->select('skpd_id')->where('id', (int) $actor['ppk_id'])->get()->getRowArray();
                $skpdId = (int) ($ppkRow['skpd_id'] ?? 0);
            }
        } else {
            $skpdId = (int) ($this->request->getGet('skpd_id') ?? 0);
        }

        $jenisPengadaanId = (int) ($this->request->getGet('jenis_pengadaan_id') ?? 0);
        $jenisDakId       = (int) ($this->request->getGet('jenis_dak_id') ?? 0);
        $search           = trim((string) ($this->request->getGet('q') ?? ''));
        $pokjaUserId      = (int) ($this->request->getGet('pokja_user_id') ?? 0);

        // Jika role adalah POKJA (role 7), pada modul 4 default terfilter ke personil Pokja tersebut
        $isPokjaLocked = ($role === 'POKJA');
        if ($isPokjaLocked && $pokjaUserId === 0) {
            $pokjaUserId = (int) ($actor['id'] ?? 0);
        }

        // Data referensi untuk dropdown filter
        $skpdBuilder = $db->table('skpd')->where('is_active', 1)->orderBy('name', 'ASC');
        if ($isSkpdLocked && $skpdId > 0) {
            $skpdBuilder->where('id', $skpdId);
        }
        $skpdList = $skpdBuilder->get()->getResultArray();

        $selectedSkpdName = 'SEMUA INSTANSI';
        if ($skpdId > 0) {
            foreach ($skpdList as $s) {
                if ((int) $s['id'] === $skpdId) {
                    $selectedSkpdName = (string) $s['name'];
                    break;
                }
            }
        }

        $jenisPengadaanList = $db->table('jenis_pengadaan')->orderBy('id', 'ASC')->get()->getResultArray();
        $jenisDakList       = $db->table('jenis_dak')->orderBy('id', 'ASC')->get()->getResultArray();

        return [
            'actor'              => $actor,
            'role_name'          => $role,
            'is_skpd_locked'     => $isSkpdLocked,
            'is_pokja_locked'    => $isPokjaLocked,
            'skpd_id'            => $skpdId,
            'selected_skpd_name' => $selectedSkpdName,
            'tahun'              => $tahun,
            'available_years'    => $availableYears,
            'jenis_pengadaan_id' => $jenisPengadaanId,
            'jenis_dak_id'       => $jenisDakId,
            'q'                  => $search,
            'pokja_user_id'      => $pokjaUserId,
            'skpd_list'          => $skpdList,
            'jenis_pengadaan'    => $jenisPengadaanList,
            'jenis_dak'          => $jenisDakList,
        ];
    }

    /**
     * Terapkan filter SKPD (dan PPK jika diperlukan) pada query RUP/Paket.
     */
    protected function applyCommonRupFilters(object $builder, array $filters, string $rupAlias = 'rup'): void
    {
        if ($filters['tahun'] > 0) {
            $builder->where("{$rupAlias}.fiscal_year", $filters['tahun']);
        }

        if ($filters['is_skpd_locked']) {
            if ($filters['skpd_id'] > 0) {
                $builder->where("{$rupAlias}.skpd_id", $filters['skpd_id']);
            } else {
                $builder->where('1 = 0', null, false);
            }
        } elseif ($filters['skpd_id'] > 0) {
            $builder->where("{$rupAlias}.skpd_id", $filters['skpd_id']);
        }

        if ($filters['jenis_pengadaan_id'] > 0) {
            $builder->where("{$rupAlias}.jenis_pengadaan_id", $filters['jenis_pengadaan_id']);
        }

        if ($filters['jenis_dak_id'] > 0) {
            $builder->where("{$rupAlias}.jenis_dak_id", $filters['jenis_dak_id']);
        }

        if ($filters['q'] !== '') {
            $builder->groupStart()
                ->like("{$rupAlias}.package_name", $filters['q'])
                ->orLike("{$rupAlias}.package_code", $filters['q'])
                ->orLike("{$rupAlias}.activity", $filters['q'])
                ->groupEnd();
        }
    }

    /**
     * Dashboard Utama e-MONEV (/monev)
     * Menampilkan 8 kartu modul e-MONEV beserta ringkasan KPI pengadaan.
     */
    public function index()
    {
        $filters = $this->resolveFilters();
        $db      = db_connect();

        // Hitung KPI ringkas sesuai cakupan SKPD & Tahun Anggaran
        $rupBuilder = $db->table('rup');
        $this->applyCommonRupFilters($rupBuilder, $filters, 'rup');
        $rupRows = $rupBuilder->select('id, budget_ceiling, rup_status')->get()->getResultArray();

        $totalRupCount   = count($rupRows);
        $totalPaguRup    = array_sum(array_map(static fn($r) => (float) ($r['budget_ceiling'] ?? 0), $rupRows));
        $belumMasukCount = count(array_filter($rupRows, static fn($r) => (int) ($r['rup_status'] ?? 1) === 1));

        // Paket yang sudah diajukan (status_paket != 1)
        $paketBuilder = $db->table('paket')
            ->select('paket.id, paket.status_paket, paket.nilai_hps, paket.nilai_kontrak, rup.budget_ceiling AS pagu_rup')
            ->join('rup', 'rup.id = paket.rup_id', 'inner')
            ->where('paket.status_paket !=', 1);
        $this->applyCommonRupFilters($paketBuilder, $filters, 'rup');
        $paketRows = $paketBuilder->get()->getResultArray();

        $totalPaketMasuk = count($paketRows);
        $paketProses     = 0;
        $paketSelesai    = 0;
        $totalPaguSelesai = 0.0;
        $totalKontrak     = 0.0;

        foreach ($paketRows as $p) {
            $st = (int) ($p['status_paket'] ?? 0);
            if ($st === 14) {
                $paketSelesai++;
                $totalPaguSelesai += (float) ($p['pagu_rup'] ?? 0);
                $totalKontrak     += (float) ($p['nilai_kontrak'] ?? 0);
            } elseif (! in_array($st, [0, 1, 14, 15], true)) {
                $paketProses++;
            }
        }

        $efisiensiRp      = max(0.0, $totalPaguSelesai - $totalKontrak);
        $efisiensiPercent = $totalPaguSelesai > 0 ? round(($efisiensiRp / $totalPaguSelesai) * 100, 2) : 0.0;

        return view('monev/index', [
            'modules' => $this->getAccessibleModules(),
            'filters' => $filters,
            'kpi'     => [
                'total_rup'         => $totalRupCount,
                'total_pagu_rup'    => $totalPaguRup,
                'belum_masuk'       => $belumMasukCount,
                'total_paket_masuk' => $totalPaketMasuk,
                'paket_proses'      => $paketProses,
                'paket_selesai'     => $paketSelesai,
                'total_kontrak'     => $totalKontrak,
                'efisiensi_rp'      => $efisiensiRp,
                'efisiensi_persen'  => $efisiensiPercent,
            ],
        ]);
    }

    /**
     * Modul 1: RUP (Paket Lelang) - /monev/rup
     */
    public function rup()
    {
        $filters = $this->resolveFilters();
        $rows    = $this->queryRupRows($filters, false);

        $export = strtolower((string) $this->request->getGet('export'));
        if (in_array($export, ['excel', 'pdf'], true)) {
            return $this->renderExport('satu', 'RENCANA UMUM PENGADAAN (PAKET LELANG)', $filters, ['rows' => $rows], $export);
        }

        return view('monev/rup_list', [
            'moduleKey'  => 'satu',
            'moduleMeta' => self::MODULES['satu'],
            'modules'    => $this->getAccessibleModules(),
            'filters'    => $filters,
            'rows'       => $rows,
        ]);
    }

    /**
     * Modul 2: Paket Lelang Belum Masuk - /monev/belum-masuk
     */
    public function belumMasuk()
    {
        $filters = $this->resolveFilters();
        $rows    = $this->queryRupRows($filters, true);

        $export = strtolower((string) $this->request->getGet('export'));
        if (in_array($export, ['excel', 'pdf'], true)) {
            return $this->renderExport('dua', 'PAKET LELANG BELUM MASUK', $filters, ['rows' => $rows], $export);
        }

        return view('monev/rup_list', [
            'moduleKey'  => 'dua',
            'moduleMeta' => self::MODULES['dua'],
            'modules'    => $this->getAccessibleModules(),
            'filters'    => $filters,
            'rows'       => $rows,
        ]);
    }

    /**
     * Query data RUP untuk Modul 1 (semua RUP) dan Modul 2 (khusus RUP yang belum masuk / belum diajukan ke UKPBJ).
     */
    protected function queryRupRows(array $filters, bool $onlyBelumMasuk): array
    {
        $db      = db_connect();
        $builder = $db->table('rup')
            ->select(
                'rup.*, rup.package_code AS rup_code, ' .
                'skpd.name AS skpd_name, skpd.abbreviation AS skpd_abbr, ' .
                'ppk.name AS ppk_name, ' .
                'jenis_pengadaan.name AS jenis_pengadaan_name, ' .
                'jenis_belanja.name AS jenis_belanja_name, ' .
                'metode_pemilihan.name AS metode_pemilihan_name, ' .
                'sumber_dana.name AS sumber_dana_name, ' .
                'jenis_dak.name AS jenis_dak_name, ' .
                'paket.id AS paket_id, paket.no_paket, paket.status_paket, paket.tgl_pengajuan AS paket_tgl_pengajuan'
            )
            ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
            ->join('ppk', 'ppk.id = rup.ppk_id', 'left')
            ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
            ->join('jenis_belanja', 'jenis_belanja.id = rup.jenis_belanja_id', 'left')
            ->join('metode_pemilihan', 'metode_pemilihan.id = rup.metode_pemilihan_id', 'left')
            ->join('sumber_dana', 'sumber_dana.id = rup.sumber_dana_id', 'left')
            ->join('jenis_dak', 'jenis_dak.id = rup.jenis_dak_id', 'left')
            ->join('paket', 'paket.rup_id = rup.id', 'left');

        $this->applyCommonRupFilters($builder, $filters, 'rup');

        if ($onlyBelumMasuk) {
            // Sesuai simppel Modul 2: RUP dengan status = 1 (belum diajukan menjadi paket lelang ke ULP)
            $builder->groupStart()
                ->where('rup.rup_status', 1)
                ->orWhere('paket.id IS NULL')
                ->orWhere('paket.status_paket', 1)
                ->groupEnd();
        }

        return $builder
            ->orderBy('skpd.name', 'ASC')
            ->orderBy('rup.submission_date', 'ASC')
            ->orderBy('rup.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Modul 3: Rekap Paket Data Lelang - /monev/rekap & /rup/summary
     * Menyajikan 5 tabel rekapitulasi komprehensif sesuai simppel (tiga.php):
     * 1. Rencana Lelang Perbulan (Jan-Des) Berdasarkan Jumlah Paket & Pagu
     * 2. Realisasi Lelang Masuk Perbulan (Jan-Des) Berdasarkan Jumlah Paket, Pagu & HPS
     * 3. Rekap Lelang Berdasarkan Paket (Per Jenis Pengadaan: Belum Masuk, Proses, Selesai, Gagal, Batal)
     * 4. Rekap Lelang Berdasarkan Pagu (Per Jenis Pengadaan: Belum Masuk, Proses, Selesai, Gagal, Batal)
     * 5. Efisiensi Lelang Selesai (Per Jenis Pengadaan: Pagu, HPS, Nilai Kontrak, Selisih/Efisiensi Rp & %)
     */
    public function rekap()
    {
        $filters   = $this->resolveFilters();
        $rekapData = $this->buildRekapData($filters);

        $export = strtolower((string) $this->request->getGet('export'));
        if (in_array($export, ['excel', 'pdf'], true)) {
            return $this->renderExport('tiga', 'REKAP PAKET DATA LELANG', $filters, $rekapData, $export);
        }

        return view('monev/rekap', [
            'moduleKey'  => 'tiga',
            'moduleMeta' => self::MODULES['tiga'],
            'modules'    => $this->getAccessibleModules(),
            'filters'    => $filters,
            'rekap'      => $rekapData,
        ]);
    }

    /**
     * Bangun struktur data 5 tabel rekapitulasi untuk Modul 3 & Modul 6.
     */
    protected function buildRekapData(array $filters): array
    {
        $db = db_connect();

        // 1. Seluruh RUP sesuai filter
        $rupBuilder = $db->table('rup')
            ->select('rup.id, rup.skpd_id, rup.jenis_pengadaan_id, rup.budget_ceiling, rup.submission_date, rup.rup_status, paket.id AS paket_id, paket.status_paket')
            ->join('paket', 'paket.rup_id = rup.id', 'left');
        $this->applyCommonRupFilters($rupBuilder, $filters, 'rup');
        $rupRows = $rupBuilder->get()->getResultArray();

        // 2. Seluruh Paket (status_paket != 1) sesuai filter
        $paketBuilder = $db->table('paket')
            ->select('paket.id, paket.rup_id, paket.status_paket, paket.nilai_hps, paket.nilai_kontrak, paket.tgl_pengajuan, paket.tgl_paket, paket.tgl_penetapan, paket.updated_at, rup.jenis_pengadaan_id, rup.budget_ceiling, rup.skpd_id')
            ->join('rup', 'rup.id = paket.rup_id', 'inner')
            ->where('paket.status_paket !=', 1);
        $this->applyCommonRupFilters($paketBuilder, $filters, 'rup');
        $paketRows = $paketBuilder->get()->getResultArray();

        // Tabel 1: Rencana Lelang Perbulan (1..12)
        $rencanaBulan = [];
        for ($m = 1; $m <= 12; $m++) {
            $rencanaBulan[$m] = ['paket' => 0, 'pagu' => 0.0];
        }
        foreach ($rupRows as $r) {
            $dateStr = $r['submission_date'] ?? '';
            $m = $dateStr ? (int) date('n', strtotime($dateStr)) : 0;
            if ($m >= 1 && $m <= 12) {
                $rencanaBulan[$m]['paket']++;
                $rencanaBulan[$m]['pagu'] += (float) ($r['budget_ceiling'] ?? 0);
            }
        }

        // Tabel 2: Realisasi Lelang Masuk Perbulan (1..12) untuk paket.status_paket != 1
        $realisasiBulan = [];
        $diterimaBulan  = [];
        $selesaiBulan   = [];
        for ($m = 1; $m <= 12; $m++) {
            $realisasiBulan[$m] = ['paket' => 0, 'pagu' => 0.0, 'hps' => 0.0];
            $diterimaBulan[$m]  = ['paket' => 0, 'pagu' => 0.0, 'hps' => 0.0];
            $selesaiBulan[$m]   = ['paket' => 0, 'pagu' => 0.0, 'kontrak' => 0.0, 'efisiensi_persen' => 0.0];
        }

        foreach ($paketRows as $p) {
            $st      = (int) ($p['status_paket'] ?? 0);
            $dateStr = $p['tgl_pengajuan'] ?: ($p['tgl_paket'] ?? '');
            $m       = $dateStr ? (int) date('n', strtotime($dateStr)) : 0;
            $pagu    = (float) ($p['budget_ceiling'] ?? 0);
            $hps     = (float) ($p['nilai_hps'] ?? 0);
            $kontrak = (float) ($p['nilai_kontrak'] ?? 0);

            if ($m >= 1 && $m <= 12) {
                $realisasiBulan[$m]['paket']++;
                $realisasiBulan[$m]['pagu'] += $pagu;
                $realisasiBulan[$m]['hps']  += $hps;

                if ($st >= 4 && $st !== 15) {
                    $diterimaBulan[$m]['paket']++;
                    $diterimaBulan[$m]['pagu'] += $pagu;
                    $diterimaBulan[$m]['hps']  += $hps;
                }
            }

            if ($st === 14) {
                $doneDate = $p['tgl_penetapan'] ?: ($p['updated_at'] ?: $dateStr);
                $mDone    = $doneDate ? (int) date('n', strtotime($doneDate)) : $m;
                if ($mDone >= 1 && $mDone <= 12) {
                    $selesaiBulan[$mDone]['paket']++;
                    $selesaiBulan[$mDone]['pagu']    += $pagu;
                    $selesaiBulan[$mDone]['kontrak'] += $kontrak;
                }
            }
        }

        for ($m = 1; $m <= 12; $m++) {
            $pg = $selesaiBulan[$m]['pagu'];
            $kt = $selesaiBulan[$m]['kontrak'];
            $selesaiBulan[$m]['efisiensi_persen'] = $pg > 0 ? round((($pg - $kt) / $pg) * 100, 2) : 0.0;
        }

        // Tabel 3, 4, 5: Per Jenis Pengadaan
        $jenisList = $filters['jenis_pengadaan'];
        $statusBuckets = [
            'belum_masuk' => 'Lelang Belum Masuk',
            'proses'      => 'Lelang Dalam Proses',
            'selesai'     => 'Lelang Selesai',
            'gagal'       => 'Lelang Gagal',
            'batal'       => 'Lelang Batal',
        ];

        $rekapPaket = [];
        $rekapPagu  = [];
        foreach ($statusBuckets as $bKey => $bLabel) {
            $rekapPaket[$bKey] = ['label' => $bLabel, 'by_jenis' => [], 'total' => 0];
            $rekapPagu[$bKey]  = ['label' => $bLabel, 'by_jenis' => [], 'total' => 0.0];
            foreach ($jenisList as $j) {
                $jid = (int) $j['id'];
                $rekapPaket[$bKey]['by_jenis'][$jid] = 0;
                $rekapPagu[$bKey]['by_jenis'][$jid]  = 0.0;
            }
        }

        $efisiensiRows = [];
        foreach ($jenisList as $j) {
            $jid = (int) $j['id'];
            $efisiensiRows[$jid] = [
                'id'      => $jid,
                'name'    => $j['name'],
                'paket'   => 0,
                'pagu'    => 0.0,
                'hps'     => 0.0,
                'kontrak' => 0.0,
            ];
        }

        // Hitung "Lelang Belum Masuk" dari RUP yang belum diajukan
        foreach ($rupRows as $r) {
            $jid  = (int) ($r['jenis_pengadaan_id'] ?? 0);
            $pagu = (float) ($r['budget_ceiling'] ?? 0);
            $isBelumMasuk = ((int) ($r['rup_status'] ?? 1) === 1)
                || empty($r['paket_id'])
                || ((int) ($r['status_paket'] ?? 1) === 1);

            if ($isBelumMasuk && isset($rekapPaket['belum_masuk']['by_jenis'][$jid])) {
                $rekapPaket['belum_masuk']['by_jenis'][$jid]++;
                $rekapPaket['belum_masuk']['total']++;
                $rekapPagu['belum_masuk']['by_jenis'][$jid] += $pagu;
                $rekapPagu['belum_masuk']['total']          += $pagu;
            }
        }

        // Hitung Proses, Selesai, Gagal, Batal dari tabel Paket (status != 1)
        foreach ($paketRows as $p) {
            $jid     = (int) ($p['jenis_pengadaan_id'] ?? 0);
            $st      = (int) ($p['status_paket'] ?? 0);
            $pagu    = (float) ($p['budget_ceiling'] ?? 0);
            $hps     = (float) ($p['nilai_hps'] ?? 0);
            $kontrak = (float) ($p['nilai_kontrak'] ?? 0);

            if ($st === 14) {
                $bucket = 'selesai';
            } elseif ($st === 15) {
                $bucket = 'gagal';
            } elseif ($st === 0) {
                $bucket = 'batal';
            } else {
                $bucket = 'proses';
            }

            if (isset($rekapPaket[$bucket]['by_jenis'][$jid])) {
                $rekapPaket[$bucket]['by_jenis'][$jid]++;
                $rekapPaket[$bucket]['total']++;
                $rekapPagu[$bucket]['by_jenis'][$jid] += $pagu;
                $rekapPagu[$bucket]['total']          += $pagu;
            }

            if ($st === 14 && isset($efisiensiRows[$jid])) {
                $efisiensiRows[$jid]['paket']++;
                $efisiensiRows[$jid]['pagu']    += $pagu;
                $efisiensiRows[$jid]['hps']     += $hps;
                $efisiensiRows[$jid]['kontrak'] += $kontrak;
            }
        }

        $grandTotalPaket = array_sum(array_column($rekapPaket, 'total'));
        $grandTotalPagu  = array_sum(array_column($rekapPagu, 'total'));

        return [
            'rencana_bulan'     => $rencanaBulan,
            'realisasi_bulan'   => $realisasiBulan,
            'diterima_bulan'    => $diterimaBulan,
            'selesai_bulan'     => $selesaiBulan,
            'rekap_paket'       => $rekapPaket,
            'rekap_pagu'        => $rekapPagu,
            'grand_total_paket' => $grandTotalPaket,
            'grand_total_pagu'  => $grandTotalPagu,
            'efisiensi_rows'    => $efisiensiRows,
            'jenis_list'        => $jenisList,
        ];
    }

    /**
     * Modul 4: Distribusi Pokja ULP - /monev/distribusi-pokja
     * Khusus Role Pusat & Pokja (PPK & ADMIN PPK tidak memiliki akses, sesuai user_monev.empat = 0 di simppel).
     */
    public function distribusiPokja()
    {
        if (! $this->canAccessModule('empat')) {
            return redirect()->to('/monev')->with('error', 'Akses ditolak: Modul Distribusi Pokja ULP khusus untuk peran UKPBJ/Pusat, Pokja, dan Monev.');
        }

        $filters = $this->resolveFilters();
        $db      = db_connect();

        // Daftar seluruh user ber-role POKJA (role_id = 7) untuk filter & grafik alokasi/performa Pokja
        $pokjaUsers = $db->table('users')
            ->select('users.id, users.full_name, users.username, users.nip')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.is_active', 1)
            ->groupStart()
                ->where('users.role_id', 7)
                ->orWhere('UPPER(roles.name)', 'POKJA')
            ->groupEnd()
            ->orderBy('users.full_name', 'ASC')
            ->get()->getResultArray();

        $rows = $this->queryPaketRows($filters, 'empat');

        // Hitung data Grafik 1 (Alokasi Paket ke Pokja) & Grafik 2 (Performa Lelang Selesai Pokja)
        $pokjaStats = [];
        foreach ($pokjaUsers as $u) {
            $uid = (int) $u['id'];
            $pokjaStats[$uid] = [
                'id'              => $uid,
                'name'            => $u['full_name'] ?: $u['username'],
                'total_paket'     => 0,
                'total_pagu'      => 0.0,
                'total_hps'       => 0.0,
                'selesai_paket'   => 0,
                'selesai_pagu'    => 0.0,
                'selesai_kontrak' => 0.0,
                'efisiensi_persen'=> 0.0,
            ];
        }

        // Ambil seluruh penugasan paket_pokja yang sesuai filter SKPD & Tahun Anggaran untuk grafik
        $statBuilder = $db->table('paket_pokja')
            ->select('paket_pokja.user_id, paket.status_paket, paket.nilai_hps, paket.nilai_kontrak, rup.budget_ceiling')
            ->join('paket', 'paket.id = paket_pokja.paket_id', 'inner')
            ->join('rup', 'rup.id = paket.rup_id', 'inner')
            ->where('paket.status_paket >=', 6);
        $this->applyCommonRupFilters($statBuilder, $filters, 'rup');
        $assignRows = $statBuilder->get()->getResultArray();

        foreach ($assignRows as $ar) {
            $uid = (int) $ar['user_id'];
            if (! isset($pokjaStats[$uid])) {
                continue;
            }
            $st      = (int) ($ar['status_paket'] ?? 0);
            $pagu    = (float) ($ar['budget_ceiling'] ?? 0);
            $hps     = (float) ($ar['nilai_hps'] ?? 0);
            $kontrak = (float) ($ar['nilai_kontrak'] ?? 0);

            $pokjaStats[$uid]['total_paket']++;
            $pokjaStats[$uid]['total_pagu'] += $pagu;
            $pokjaStats[$uid]['total_hps']  += $hps;

            if ($st === 14) {
                $pokjaStats[$uid]['selesai_paket']++;
                $pokjaStats[$uid]['selesai_pagu']    += $pagu;
                $pokjaStats[$uid]['selesai_kontrak'] += $kontrak;
            }
        }

        foreach ($pokjaStats as &$ps) {
            if ($ps['selesai_pagu'] > 0) {
                $ps['efisiensi_persen'] = round((($ps['selesai_pagu'] - $ps['selesai_kontrak']) / $ps['selesai_pagu']) * 100, 2);
            }
        }
        unset($ps);

        $export = strtolower((string) $this->request->getGet('export'));
        if (in_array($export, ['excel', 'pdf'], true)) {
            return $this->renderExport('empat', 'DISTRIBUSI POKJA ULP', $filters, [
                'rows'       => $rows,
                'pokjaStats' => array_values($pokjaStats),
            ], $export);
        }

        return view('monev/distribusi_pokja', [
            'moduleKey'  => 'empat',
            'moduleMeta' => self::MODULES['empat'],
            'modules'    => $this->getAccessibleModules(),
            'filters'    => $filters,
            'pokjaUsers' => $pokjaUsers,
            'pokjaStats' => array_values($pokjaStats),
            'rows'       => $rows,
        ]);
    }

    /**
     * Modul 5: Daftar Paket Lelang - /monev/daftar-paket
     */
    public function daftarPaket()
    {
        $filters = $this->resolveFilters();
        $rows    = $this->queryPaketRows($filters, 'lima');

        $export = strtolower((string) $this->request->getGet('export'));
        if (in_array($export, ['excel', 'pdf'], true)) {
            return $this->renderExport('lima', 'DAFTAR PAKET LELANG', $filters, ['rows' => $rows], $export);
        }

        return view('monev/paket_list', [
            'moduleKey'  => 'lima',
            'moduleMeta' => self::MODULES['lima'],
            'modules'    => $this->getAccessibleModules(),
            'filters'    => $filters,
            'rows'       => $rows,
        ]);
    }

    /**
     * Modul 6: Grafik Lelang - /monev/grafik
     * Menampilkan rangkaian grafik analitik e-MONEV (G1 s/d G10 pada simppel).
     */
    protected function buildChartData(array $filters): array
    {
        $rekap = $this->buildRekapData($filters);
        $db    = db_connect();

        // Hitung data per Jenis Pengadaan (G7) untuk paket diterima/masuk
        $perJenis = [];
        foreach ($filters['jenis_pengadaan'] as $j) {
            $jid = (int) $j['id'];
            $perJenis[$jid] = [
                'name'  => $j['name'],
                'paket' => 0,
                'pagu'  => 0.0,
                'hps'   => 0.0,
            ];
        }

        $paketBuilder = $db->table('paket')
            ->select('paket.status_paket, paket.nilai_hps, paket.nilai_kontrak, rup.jenis_pengadaan_id, rup.budget_ceiling, rup.skpd_id')
            ->join('rup', 'rup.id = paket.rup_id', 'inner')
            ->where('paket.status_paket !=', 1);
        $this->applyCommonRupFilters($paketBuilder, $filters, 'rup');
        $paketRows = $paketBuilder->get()->getResultArray();

        foreach ($paketRows as $p) {
            $jid = (int) ($p['jenis_pengadaan_id'] ?? 0);
            $st  = (int) ($p['status_paket'] ?? 0);
            if ($st >= 4 && isset($perJenis[$jid])) {
                $perJenis[$jid]['paket']++;
                $perJenis[$jid]['pagu'] += (float) ($p['budget_ceiling'] ?? 0);
                $perJenis[$jid]['hps']  += (float) ($p['nilai_hps'] ?? 0);
            }
        }

        // Hitung data per SKPD (G9: Paket Selesai per SKPD & G10: RUP vs Diterima ULP per SKPD)
        $skpdStats = [];
        foreach ($filters['skpd_list'] as $s) {
            $sid = (int) $s['id'];
            $skpdStats[$sid] = [
                'id'            => $sid,
                'name'          => $s['abbreviation'] ?: $s['name'],
                'full_name'     => $s['name'],
                'rup_count'     => 0,
                'diterima_ulp'  => 0,
                'selesai_count' => 0,
                'selesai_pagu'  => 0.0,
                'selesai_kontrak' => 0.0,
                'efisiensi_persen'=> 0.0,
            ];
        }

        $rupBuilder = $db->table('rup')->select('skpd_id, COUNT(*) AS cnt')->groupBy('skpd_id');
        $this->applyCommonRupFilters($rupBuilder, $filters, 'rup');
        foreach ($rupBuilder->get()->getResultArray() as $rr) {
            $sid = (int) $rr['skpd_id'];
            if (isset($skpdStats[$sid])) {
                $skpdStats[$sid]['rup_count'] = (int) $rr['cnt'];
            }
        }

        foreach ($paketRows as $p) {
            $sid = (int) ($p['skpd_id'] ?? 0);
            $st  = (int) ($p['status_paket'] ?? 0);
            if (! isset($skpdStats[$sid])) {
                continue;
            }
            if ($st >= 4) {
                $skpdStats[$sid]['diterima_ulp']++;
            }
            if ($st === 14) {
                $skpdStats[$sid]['selesai_count']++;
                $skpdStats[$sid]['selesai_pagu']    += (float) ($p['budget_ceiling'] ?? 0);
                $skpdStats[$sid]['selesai_kontrak'] += (float) ($p['nilai_kontrak'] ?? 0);
            }
        }

        // Hanya tampilkan SKPD yang memiliki RUP atau Paket agar grafik bersih dan informatif
        $activeSkpdStats = [];
        foreach ($skpdStats as $stRow) {
            if ($stRow['selesai_pagu'] > 0) {
                $stRow['efisiensi_persen'] = round((($stRow['selesai_pagu'] - $stRow['selesai_kontrak']) / $stRow['selesai_pagu']) * 100, 2);
            }
            if ($stRow['rup_count'] > 0 || $stRow['diterima_ulp'] > 0 || $filters['skpd_id'] > 0) {
                $activeSkpdStats[] = $stRow;
            }
        }

        return [
            'rekap'      => $rekap,
            'per_jenis'  => array_values($perJenis),
            'skpd_stats' => $activeSkpdStats,
        ];
    }

    public function grafik()
    {
        $filters   = $this->resolveFilters();
        $chartData = $this->buildChartData($filters);

        return view('monev/grafik', [
            'moduleKey'  => 'enam',
            'moduleMeta' => self::MODULES['enam'],
            'modules'    => $this->getAccessibleModules(),
            'filters'    => $filters,
            'chartData'  => $chartData,
        ]);
    }

    /**
     * Modul 7: Paket Lelang Selesai - /monev/paket-selesai
     */
    public function paketSelesai()
    {
        $filters = $this->resolveFilters();
        $rows    = $this->queryPaketRows($filters, 'tujuh');

        $export = strtolower((string) $this->request->getGet('export'));
        if (in_array($export, ['excel', 'pdf'], true)) {
            return $this->renderExport('tujuh', 'PAKET LELANG SELESAI', $filters, ['rows' => $rows], $export);
        }

        return view('monev/paket_list', [
            'moduleKey'  => 'tujuh',
            'moduleMeta' => self::MODULES['tujuh'],
            'modules'    => $this->getAccessibleModules(),
            'filters'    => $filters,
            'rows'       => $rows,
        ]);
    }

    /**
     * Modul 8: Paket Lelang Dalam Proses - /monev/paket-proses
     */
    public function paketProses()
    {
        $filters = $this->resolveFilters();
        $rows    = $this->queryPaketRows($filters, 'delapan');

        $export = strtolower((string) $this->request->getGet('export'));
        if (in_array($export, ['excel', 'pdf'], true)) {
            return $this->renderExport('delapan', 'PAKET LELANG DALAM PROSES', $filters, ['rows' => $rows], $export);
        }

        return view('monev/paket_list', [
            'moduleKey'  => 'delapan',
            'moduleMeta' => self::MODULES['delapan'],
            'modules'    => $this->getAccessibleModules(),
            'filters'    => $filters,
            'rows'       => $rows,
        ]);
    }

    /**
     * Query daftar paket untuk Modul 4, 5, 7, dan 8.
     */
    protected function queryPaketRows(array $filters, string $moduleKey): array
    {
        $db = db_connect();

        $builder = $db->table('paket')
            ->select(
                'paket.*, ' .
                'rup.package_code AS rup_code, rup.package_name, rup.activity, rup.fiscal_year, rup.location, ' .
                'rup.volume, rup.description AS rup_description, rup.budget_ceiling AS pagu_rup, ' .
                'rup.submission_date AS rencana_pengajuan, rup.work_duration, rup.skpd_id, rup.ppk_id, ' .
                'rup.jenis_pengadaan_id, rup.jenis_dak_id, ' .
                'skpd.name AS skpd_name, skpd.abbreviation AS skpd_abbr, ' .
                'ppk.name AS ppk_name, ' .
                'jenis_pengadaan.name AS jenis_pengadaan_name, ' .
                'metode_pemilihan.name AS metode_pemilihan_name, ' .
                'sumber_dana.name AS sumber_dana_name, ' .
                'jenis_dak.name AS jenis_dak_name, ' .
                'u_ulp.full_name AS admin_ulp_name'
            )
            ->join('rup', 'rup.id = paket.rup_id', 'inner')
            ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
            ->join('ppk', 'ppk.id = rup.ppk_id', 'left')
            ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
            ->join('metode_pemilihan', 'metode_pemilihan.id = rup.metode_pemilihan_id', 'left')
            ->join('sumber_dana', 'sumber_dana.id = rup.sumber_dana_id', 'left')
            ->join('jenis_dak', 'jenis_dak.id = rup.jenis_dak_id', 'left')
            ->join('users u_ulp', 'u_ulp.id = paket.admin_ukpbj_id', 'left');

        $this->applyCommonRupFilters($builder, $filters, 'rup');

        if ($moduleKey === 'empat') {
            // Modul 4: Paket yang sudah masuk tahapan distribusi / Pokja (atau seluruh paket yang sudah diajukan)
            $builder->where('paket.status_paket !=', 1);
            if ($filters['pokja_user_id'] > 0) {
                $uid = (int) $filters['pokja_user_id'];
                $builder->where("EXISTS (SELECT 1 FROM paket_pokja pp WHERE pp.paket_id = paket.id AND pp.user_id = {$uid})", null, false);
            }
        } elseif ($moduleKey === 'lima') {
            // Modul 5: Seluruh Paket Lelang yang sudah diajukan (status_paket != 1)
            $builder->where('paket.status_paket !=', 1);
        } elseif ($moduleKey === 'tujuh') {
            // Modul 7: Paket Lelang Selesai (status 14, serta tampilkan 0/15 sesuai simppel tujuh.php)
            $builder->whereIn('paket.status_paket', [0, 14, 15]);
        } elseif ($moduleKey === 'delapan') {
            // Modul 8: Paket Lelang Dalam Proses (status 2 s/d 13, yaitu bukan 0, 1, 14, 15)
            $builder->whereNotIn('paket.status_paket', [0, 1, 14, 15]);
        }

        $rows = $builder
            ->orderBy('paket.id', 'DESC')
            ->get()
            ->getResultArray();

        if (empty($rows)) {
            return [];
        }

        // Lampirkan daftar anggota Pokja dan perhitungan lama proses / efisiensi
        $paketIds = array_map(static fn($r) => (int) $r['id'], $rows);
        $pokjaMap = [];
        $pokjaRows = $db->table('paket_pokja')
            ->select('paket_pokja.paket_id, paket_pokja.user_id, users.full_name, users.username, users.nip')
            ->join('users', 'users.id = paket_pokja.user_id', 'left')
            ->whereIn('paket_pokja.paket_id', $paketIds)
            ->orderBy('paket_pokja.id', 'ASC')
            ->get()->getResultArray();

        foreach ($pokjaRows as $pr) {
            $pid = (int) $pr['paket_id'];
            $pokjaMap[$pid][] = [
                'user_id'   => (int) $pr['user_id'],
                'full_name' => $pr['full_name'] ?: $pr['username'],
                'nip'       => $pr['nip'] ?? '',
            ];
        }

        $today = new \DateTimeImmutable('today');
        foreach ($rows as &$row) {
            $pid = (int) $row['id'];
            $st  = (int) ($row['status_paket'] ?? 0);
            $row['pokja_members'] = $pokjaMap[$pid] ?? [];
            $row['status_label']  = PaketWorkflow::STATUS_LABELS[$st] ?? ('Status #' . $st);

            // Hitung efisiensi (Rp & %)
            $pagu    = (float) ($row['pagu_rup'] ?? 0);
            $kontrak = (float) ($row['nilai_kontrak'] ?? 0);
            $selisih = ($st === 14 && $kontrak > 0) ? ($pagu - $kontrak) : 0.0;
            $row['efisiensi_rp']     = $selisih;
            $row['efisiensi_persen'] = ($st === 14 && $pagu > 0 && $kontrak > 0)
                ? round(($selisih / $pagu) * 100, 2)
                : 0.0;

            // Hitung lama proses (hari) sesuai simppel empat.php
            $startStr = $row['tgl_pengajuan'] ?: ($row['tgl_paket'] ?? '');
            $endStr   = in_array($st, [0, 14, 15], true)
                ? ($row['tgl_penetapan'] ?: ($row['updated_at'] ?? 'now'))
                : 'now';

            $days = null;
            if (! empty($startStr)) {
                try {
                    $dStart = new \DateTimeImmutable(substr((string) $startStr, 0, 10));
                    $dEnd   = $endStr === 'now' ? $today : new \DateTimeImmutable(substr((string) $endStr, 0, 10));
                    $days   = max(0, (int) $dStart->diff($dEnd)->format('%a'));
                } catch (\Throwable $e) {
                    $days = null;
                }
            }
            $row['lama_proses_hari'] = $days;
        }
        unset($row);

        return $rows;
    }

    /**
     * Endpoint JSON Detail RUP untuk Modal e-MONEV (/monev/detail-rup/(:num))
     */
    public function detailRup(int $id): ResponseInterface
    {
        $db  = db_connect();
        $row = $db->table('rup')
            ->select(
                'rup.*, rup.package_code AS rup_code, ' .
                'skpd.name AS skpd_name, ' .
                'ppk.name AS ppk_name, ' .
                'jenis_pengadaan.name AS jenis_pengadaan_name, ' .
                'jenis_belanja.name AS jenis_belanja_name, ' .
                'metode_pemilihan.name AS metode_pemilihan_name, ' .
                'sumber_dana.name AS sumber_dana_name, ' .
                'jenis_dak.name AS jenis_dak_name'
            )
            ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
            ->join('ppk', 'ppk.id = rup.ppk_id', 'left')
            ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
            ->join('jenis_belanja', 'jenis_belanja.id = rup.jenis_belanja_id', 'left')
            ->join('metode_pemilihan', 'metode_pemilihan.id = rup.metode_pemilihan_id', 'left')
            ->join('sumber_dana', 'sumber_dana.id = rup.sumber_dana_id', 'left')
            ->join('jenis_dak', 'jenis_dak.id = rup.jenis_dak_id', 'left')
            ->where('rup.id', $id)
            ->get()->getRowArray();

        if (! $row) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Data RUP tidak ditemukan.']);
        }

        if (! $this->hasGlobalScope()) {
            $actor = $this->actor();
            if ((int) ($actor['skpd_id'] ?? 0) !== (int) ($row['skpd_id'] ?? -1)) {
                return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'message' => 'Akses ditolak.']);
            }
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $row]);
    }

    /**
     * Endpoint JSON Detail Paket + Pokja + Catatan/Riwayat untuk Modal e-MONEV (/monev/detail-paket/(:num))
     */
    public function detailPaket(int $id): ResponseInterface
    {
        $db  = db_connect();
        $row = $db->table('paket')
            ->select(
                'paket.*, ' .
                'rup.package_code AS rup_code, rup.package_name, rup.activity, rup.fiscal_year, rup.location, ' .
                'rup.volume, rup.description AS rup_description, rup.budget_ceiling AS pagu_rup, ' .
                'rup.submission_date AS rencana_pengajuan, rup.work_duration, rup.skpd_id, rup.ppk_id, ' .
                'skpd.name AS skpd_name, ' .
                'ppk.name AS ppk_name, ' .
                'jenis_pengadaan.name AS jenis_pengadaan_name, ' .
                'metode_pemilihan.name AS metode_pemilihan_name, ' .
                'sumber_dana.name AS sumber_dana_name, ' .
                'jenis_dak.name AS jenis_dak_name, ' .
                'u_ulp.full_name AS admin_ulp_name'
            )
            ->join('rup', 'rup.id = paket.rup_id', 'inner')
            ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
            ->join('ppk', 'ppk.id = rup.ppk_id', 'left')
            ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
            ->join('metode_pemilihan', 'metode_pemilihan.id = rup.metode_pemilihan_id', 'left')
            ->join('sumber_dana', 'sumber_dana.id = rup.sumber_dana_id', 'left')
            ->join('jenis_dak', 'jenis_dak.id = rup.jenis_dak_id', 'left')
            ->join('users u_ulp', 'u_ulp.id = paket.admin_ukpbj_id', 'left')
            ->where('paket.id', $id)
            ->get()->getRowArray();

        if (! $row) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Data Paket tidak ditemukan.']);
        }

        if (! $this->hasGlobalScope()) {
            $actor = $this->actor();
            if ((int) ($actor['skpd_id'] ?? 0) !== (int) ($row['skpd_id'] ?? -1)) {
                return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'message' => 'Akses ditolak.']);
            }
        }

        $st = (int) ($row['status_paket'] ?? 0);
        $row['status_label'] = PaketWorkflow::STATUS_LABELS[$st] ?? ('Status #' . $st);

        $pokja = $db->table('paket_pokja')
            ->select('users.id, users.full_name, users.username, users.nip, users.email')
            ->join('users', 'users.id = paket_pokja.user_id', 'left')
            ->where('paket_pokja.paket_id', $id)
            ->orderBy('paket_pokja.id', 'ASC')
            ->get()->getResultArray();

        $catatan = $db->table('catatan')
            ->select('catatan.*, catatan.isi_catatan AS catatan, catatan.isi_jawaban AS jawaban, u1.full_name AS pengirim_name, r1.name AS pengirim_role, u2.full_name AS penjawab_name')
            ->join('users u1', 'u1.id = catatan.user_id', 'left')
            ->join('roles r1', 'r1.id = u1.role_id', 'left')
            ->join('users u2', 'u2.id = catatan.jawab_user_id', 'left')
            ->where('catatan.paket_id', $id)
            ->orderBy('catatan.id', 'DESC')
            ->get()->getResultArray();

        return $this->response->setJSON([
            'status'  => 'success',
            'data'    => $row,
            'pokja'   => $pokja,
            'catatan' => $catatan,
        ]);
    }

    /**
     * Render laporan Export Excel (.xls) atau Printable PDF (sesuai satu_report.php .. delapan_report.php di simppel).
     */
    protected function renderExport(string $moduleKey, string $reportTitle, array $filters, array $payload, string $exportType)
    {
        $html = view('monev/export_report', [
            'moduleKey'   => $moduleKey,
            'reportTitle' => $reportTitle,
            'filters'     => $filters,
            'payload'     => $payload,
            'exportType'  => $exportType,
        ]);

        if ($exportType === 'excel') {
            $filename = 'eMONEV_' . strtoupper($moduleKey) . '_' . $filters['tahun'] . '_' . date('Ymd_His') . '.xls';
            return $this->response
                ->setHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Cache-Control', 'max-age=0')
                ->setBody($html);
        }

        return $this->response->setBody($html);
    }
}
