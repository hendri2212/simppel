<?php

namespace App\Libraries;

/**
 * Definisi alur status paket (Tender/Seleksi 13 tahapan & Pengadaan Langsung 8 tahapan)
 * beserta Berita Acara Review (BA Review) dan hak aksi per role.
 *
 * Status:
 *  0  Dibatalkan
 *  1  Draft / Belum Diajukan
 *  2  Diajukan (Verifikasi ULP)
 *  3  Dikembalikan ULP (Perbaikan Awal)
 *  4  Diterima UKPBJ
 *  5  Saran Distribusi Pokja
 *  6  Terdistribusi ke Pokja / Pejabat Pengadaan (Review Dokumen)
 *  7  Saran Kaji Ulang (Perbaikan Review oleh PPK)
 *  8  Selesai Kaji Ulang (Review Ulang Pokja / Pejabat Pengadaan)
 *  9  Proses Lelang (Tayang / Pemilihan Penyedia)
 *  10 Saran Addendum
 *  11 Selesai Addendum
 *  16 Hasil di Verifikator (Diserahkan Pokja / Pejabat Pengadaan bersama BA Review)
 *  17 Hasil di Kepala UKPBJ (Diunggah Verifikator, menunggu diteruskan ke PPK)
 *  12 Hasil Pemilihan (Diteruskan Kepala UKPBJ ke PPK)
 *  13 Lelang Ulang (Dikembalikan PPK ke Pokja)
 *  14 Selesai
 *  15 Gagal
 */
class PaketWorkflow
{
    public const ADMIN      = 'ADMINISTRATOR';
    public const PPK_SIDE   = ['PPK', 'ADMIN PPK'];
    public const PPK_ONLY   = ['PPK'];
    public const ULP        = ['ADMIN ULP'];
    public const DISTRIBUSI = ['DISTRIBUSI'];
    public const KEPALA     = ['KEPALA ULP'];
    public const POKJA      = ['POKJA'];

    /** Jumlah anggota Pokja yang diperbolehkan untuk paket Tender/Seleksi. */
    public const POKJA_SIZES = [3, 5, 7];

    /** Kode metode pemilihan yang masuk ke jalur Pengadaan Langsung (Non-Tender, 8 tahapan). */
    public const DIRECT_METHOD_CODES = [
        'PENGADAAN_LANGSUNG',
        'PENUNJUKAN_LANGSUNG',
        'E_PURCHASING',
    ];

    /** Daftar label status paket (0 s/d 17) */
    public const STATUS_LABELS = [
        0  => 'Dibatalkan',
        1  => 'Draft / Belum Diajukan',
        2  => 'Diajukan (Verifikasi ULP)',
        3  => 'Dikembalikan ULP',
        4  => 'Diterima UKPBJ',
        5  => 'Saran Distribusi Pokja',
        6  => 'Terdistribusi ke Pokja',
        7  => 'Saran Kaji Ulang',
        8  => 'Selesai Kaji Ulang',
        9  => 'Proses Lelang (Tayang)',
        10 => 'Saran Addendum',
        11 => 'Selesai Addendum',
        12 => 'Hasil Lelang',
        13 => 'Lelang Ulang',
        14 => 'Selesai Lelang',
        15 => 'Gagal Lelang',
        16 => 'Hasil di Verifikator',
        17 => 'Hasil di Kepala UKPBJ',
    ];

    /**
     * Opsi tiap aksi:
     *  roles     role yang boleh (ADMINISTRATOR selalu boleh)
     *  from      status asal
     *  to        status tujuan
     *  flow      null (semua) | 'tender' | 'pl' (khusus Pengadaan Langsung)
     *  note      null | 'optional' | 'required' => catatan ke tabel `catatan`
     *  member    true = harus anggota Pokja / Pejabat Pengadaan paket tsb
     *  assigned  true = harus Admin ULP yang mengambil paket
     *  pokja     true = anggota Pokja harus 3/5/7 (khusus tender)
     *  ba        'perlu_perbaikan' | 'sesuai' => syarat Berita Acara Review terakhir
     *  variant   kelas tombol
     */
    public const ACTIONS = [
        'pilih' => [
            'label' => 'Pilih Paket', 'roles' => self::ULP, 'from' => [2], 'to' => null,
            'note' => null, 'variant' => 'danger',
            'confirm' => 'Pilih paket ini untuk diverifikasi oleh Anda?',
        ],
        'kembalikan' => [
            'label' => 'Verifikasi (Kembalikan ke PPK)', 'roles' => self::ULP, 'from' => [2], 'to' => 3,
            'note' => 'optional', 'assigned' => true, 'variant' => 'danger',
            'confirm' => 'Kembalikan paket ke PPK untuk diperbaiki? (Catatan harus sudah diisi atau tulis di bawah ini)',
        ],
        'ajukan_kembali' => [
            'label' => 'Ajukan Kembali ke Verifikator', 'roles' => self::PPK_ONLY, 'from' => [3], 'to' => 2,
            'note' => null, 'variant' => 'primary',
            'confirm' => 'Ajukan kembali paket hasil perbaikan ke Verifikator ULP?',
        ],
        'terima' => [
            'label' => 'Terima (Dokumen Sesuai)', 'roles' => self::ULP, 'from' => [2], 'to' => 4,
            'note' => null, 'assigned' => true, 'variant' => 'success',
            'confirm' => 'Terima berkas paket ini karena dokumen telah sesuai?',
        ],
        'saran' => [
            'label' => 'Saran Distribusi', 'roles' => self::DISTRIBUSI, 'from' => [4], 'to' => 5,
            'flow' => 'tender', 'note' => null, 'pokja' => true, 'variant' => 'danger',
            'confirm' => 'Kirim usulan Pokja ke Kepala UKPBJ?',
        ],
        'distribusi' => [
            'label' => 'Distribusi & Terbitkan SK Pokja', 'roles' => self::KEPALA, 'from' => [5], 'to' => 6,
            'flow' => 'tender', 'note' => null, 'pokja' => true, 'variant' => 'danger',
            'confirm' => 'Tetapkan distribusi paket ke Pokja terpilih dan terbitkan SK Pokja?',
        ],
        'sarankaji' => [
            'label' => 'Kembalikan ke PPK (Perlu Perbaikan Review)', 'roles' => self::POKJA, 'from' => [6, 8], 'to' => 7,
            'note' => 'optional', 'member' => true, 'ba' => 'perlu_perbaikan', 'variant' => 'danger',
            'confirm' => 'Kembalikan paket ke PPK untuk diperbaiki berdasarkan Berita Acara Review?',
        ],
        'ajukan_kaji' => [
            'label' => 'Ajukan Ulang Hasil Perbaikan Review', 'roles' => self::PPK_ONLY, 'from' => [7], 'to' => 8,
            'note' => null, 'variant' => 'primary',
            'confirm' => 'Ajukan ulang dokumen yang telah diperbaiki berdasarkan Berita Acara Review?',
        ],
        'lelang' => [
            'label' => 'Proses Pemilihan (Tayangkan Paket)', 'roles' => self::POKJA, 'from' => [6, 8], 'to' => 9,
            'flow' => 'tender', 'note' => null, 'member' => true, 'ba' => 'sesuai', 'variant' => 'success',
            'confirm' => 'Mulai proses pemilihan penyedia (tayangkan paket)?',
        ],
        'saranadd' => [
            'label' => 'Saran Addendum ke PPK', 'roles' => self::POKJA, 'from' => [9, 11], 'to' => 10,
            'flow' => 'tender', 'note' => 'optional', 'member' => true, 'variant' => 'warning',
            'confirm' => 'Kembalikan paket ke PPK untuk addendum? (Catatan harus sudah diisi atau tulis di bawah ini)',
        ],
        'ajukan_add' => [
            'label' => 'Ajukan Addendum ke Pokja', 'roles' => self::PPK_ONLY, 'from' => [10], 'to' => 11,
            'flow' => 'tender', 'note' => null, 'variant' => 'primary',
            'confirm' => 'Lanjutkan proses lelang setelah addendum?',
        ],
        'serahkan_pl' => [
            'label' => 'Serahkan Dokumen & BA Review ke Verifikator', 'roles' => self::POKJA, 'from' => [6, 8], 'to' => 16,
            'flow' => 'pl', 'note' => null, 'member' => true, 'ba' => 'sesuai', 'variant' => 'success',
            'confirm' => 'Serahkan dokumen pengadaan langsung beserta Berita Acara Review ke Verifikator?',
        ],
        'hasil' => [
            'label' => 'Serahkan Hasil & BA Review ke Verifikator', 'roles' => self::POKJA, 'from' => [9, 11], 'to' => 16,
            'flow' => 'tender', 'note' => null, 'member' => true, 'ba' => 'sesuai', 'variant' => 'success',
            'confirm' => 'Serahkan hasil pemilihan dan Berita Acara Review ke Verifikator? Persyaratan dan dokumen akan dikunci.',
        ],
        'unggah_hasil' => [
            'label' => 'Unggah & Kirim Hasil ke Kepala UKPBJ', 'roles' => self::ULP, 'from' => [16], 'to' => 17,
            'note' => null, 'assigned' => true, 'variant' => 'primary',
            'confirm' => 'Kirim hasil pemilihan yang telah diunggah kepada Kepala UKPBJ?',
        ],
        'teruskan_hasil' => [
            'label' => 'Teruskan Hasil ke PPK', 'roles' => self::KEPALA, 'from' => [17], 'to' => 12,
            'note' => null, 'variant' => 'success',
            'confirm' => 'Teruskan hasil pemilihan/pengadaan kepada PPK?',
        ],
        'selesai' => [
            'label' => 'Terima Hasil Pemilihan (Selesai)', 'roles' => self::PPK_ONLY, 'from' => [12], 'to' => 14,
            'flow' => 'tender', 'note' => 'optional', 'variant' => 'success',
            'confirm' => 'Terima hasil pemilihan penyedia dan nyatakan paket SELESAI?',
        ],
        'ulang' => [
            'label' => 'Tolak Hasil — Tender Ulang', 'roles' => self::PPK_ONLY, 'from' => [12], 'to' => 6,
            'flow' => 'tender', 'note' => 'required', 'variant' => 'warning',
            'confirm' => 'Tolak hasil pemilihan dan kembalikan paket ke Pokja Pemilihan untuk TENDER ULANG (kembali ke tahap Review Pokja)? Tuliskan alasan penolakan.',
        ],
        'batal_tolak' => [
            'label' => 'Tolak Hasil — Tidak Dilanjutkan (Gagal)', 'roles' => self::PPK_ONLY, 'from' => [12], 'to' => 15,
            'flow' => 'tender', 'note' => 'required', 'variant' => 'danger',
            'confirm' => 'Tolak hasil pemilihan dan nyatakan TIDAK DILANJUTKAN (Status: GAGAL)? Wajib mengisi alasan dan mengunggah surat resmi penolakan/pembatalan.',
        ],
    ];

    /**
     * Apakah paket menggunakan jalur Pengadaan Langsung (Non-Tender, 8 tahapan).
     */
    public static function isDirectProcurement(array $paket): bool
    {
        $code = strtoupper(trim((string) ($paket['metode_pemilihan_code'] ?? '')));
        if ($code !== '' && in_array($code, self::DIRECT_METHOD_CODES, true)) {
            return true;
        }

        $name = strtolower(trim((string) ($paket['metode_pemilihan_name'] ?? '')));
        foreach (['pengadaan langsung', 'penunjukan langsung', 'e-purchasing', 'epurchasing'] as $kw) {
            if ($name !== '' && str_contains($name, $kw)) {
                return true;
            }
        }

        $methodId = (int) ($paket['metode_pemilihan_id'] ?? 0);

        return in_array($methodId, [1, 2, 3], true);
    }

    public static function roleKey(array $actor): string
    {
        return strtoupper((string) ($actor['role_name'] ?? ''));
    }

    public static function isAdmin(array $actor): bool
    {
        return self::roleKey($actor) === self::ADMIN;
    }

    /**
     * Aksi yang tersedia bagi actor untuk paket ini, berindeks kunci aksi.
     * Aksi yang syarat Pokja atau BA Review-nya belum terpenuhi diberi 'blocked' (alasan).
     */
    public static function available(array $paket, array $actor, bool $isMember, int $pokjaCount, ?array $latestBa = null): array
    {
        $status   = (int) ($paket['status_paket'] ?? 0);
        $role     = self::roleKey($actor);
        $admin    = self::isAdmin($actor);
        $isDirect = self::isDirectProcurement($paket);
        $flowKey  = $isDirect ? 'pl' : 'tender';
        $out      = [];

        foreach (self::ACTIONS as $key => $def) {
            if (! in_array($status, $def['from'], true)) {
                continue;
            }
            if (! empty($def['flow']) && $def['flow'] !== $flowKey) {
                continue;
            }
            if (! $admin && ! in_array($role, $def['roles'], true)) {
                continue;
            }
            if (! $admin && ! empty($def['member']) && ! $isMember) {
                continue;
            }

            $assignee = (int) ($paket['admin_ukpbj_id'] ?? 0);

            if ($key === 'pilih' && $assignee > 0) {
                continue;
            }
            if (! empty($def['assigned']) && ($assignee === 0 || (! $admin && $assignee !== (int) $actor['id']))) {
                continue;
            }

            $def['key']     = $key;
            $def['blocked'] = null;

            if (! empty($def['pokja']) && ! $isDirect && ! in_array($pokjaCount, self::POKJA_SIZES, true)) {
                $def['blocked'] = "Jumlah anggota Pokja harus 3, 5, atau 7 orang (saat ini {$pokjaCount}).";
            }

            if ($def['blocked'] === null && ! empty($def['ba'])) {
                $actorTitle = $isDirect ? 'Pejabat Pengadaan' : 'Pokja Pemilihan';
                if (! $latestBa) {
                    $def['blocked'] = "Harap susun Berita Acara Review (BA Review) oleh {$actorTitle} terlebih dahulu pada tab BA Review.";
                } elseif ($def['ba'] === 'perlu_perbaikan' && (int) ($latestBa['perlu_perbaikan'] ?? 0) !== 1) {
                    $def['blocked'] = 'BA Review putaran terakhir menyatakan dokumen sudah sesuai (Tidak Perlu Perbaikan). Buat BA Review baru dengan status "Perlu Perbaikan" jika ingin mengembalikan ke PPK.';
                } elseif ($def['ba'] === 'sesuai' && (int) ($latestBa['perlu_perbaikan'] ?? 0) !== 0) {
                    $def['blocked'] = 'BA Review putaran terakhir masih berstatus "Perlu Perbaikan". Susun BA Review baru dengan hasil "Tidak Perlu Perbaikan (Sesuai)" sebelum melanjutkan.';
                }
            }

            $out[$key] = $def;
        }

        return $out;
    }

    /**
     * Kemampuan non-transisi (kelola pokja, BA review, dokumen, hasil, LPSE, catatan) untuk UI & validasi.
     */
    public static function capabilities(array $paket, array $actor, bool $isMember): array
    {
        $status      = (int) ($paket['status_paket'] ?? 0);
        $role        = self::roleKey($actor);
        $admin       = self::isAdmin($actor);
        $isDirect    = self::isDirectProcurement($paket);
        $pokjaMember = $admin || ($role === 'POKJA' && $isMember);
        $isVerif     = $admin || ($role === 'ADMIN ULP' && (int) ($paket['admin_ukpbj_id'] ?? 0) === (int) ($actor['id'] ?? 0));

        return [
            'is_direct' => $isDirect,
            // Admin Distribusi (status 4 & 5) dan Kepala ULP (status 5) dapat mengubah susunan Pokja (khusus Tender)
            'pokja'     => ! $isDirect && (
                ($admin && in_array($status, [4, 5], true))
                || ($role === 'DISTRIBUSI' && in_array($status, [4, 5], true))
                || ($role === 'KEPALA ULP' && $status === 5)
            ),
            // Penyusunan Berita Acara Review oleh Pokja / Pejabat Pengadaan saat tahap Review (status 6 & 8)
            'ba_review' => $pokjaMember && in_array($status, [6, 8], true),
            // Dokumen pengadaan/lelang dapat diunggah oleh Pokja/Pejabat Pengadaan (status 6, 8, 9, 11) dan oleh Verifikator saat mengunggah hasil (status 16)
            'dokumen'   => ($pokjaMember && in_array($status, [6, 8, 9, 11], true))
                || ($isVerif && $status === 16),
            // Data hasil pemilihan dapat diisi Pokja/Pejabat Pengadaan (status 6/8 pada PL, 9/11 pada Tender) atau dilengkapi Verifikator (status 16)
            'hasil'     => ($pokjaMember && in_array($status, $isDirect ? [6, 8] : [9, 11], true))
                || ($isVerif && $status === 16),
            // Admin Agency memproses Room LPSE untuk paket Tender berstatus 6 s/d 14 yang belum lpse=1
            'lpse'      => ! $isDirect && ($admin || $role === 'ADMIN AGENCY') && (int) ($paket['is_lpse'] ?? 0) === 0 && $status >= 6 && $status <= 17,
            'catatan'   => $role !== 'MONEV' && $status >= 2,
        ];
    }
}
