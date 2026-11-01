<?php

namespace App\Libraries;

/**
 * Definisi alur status paket (P3 - P13) dan hak aksi per role.
 *
 * Status: 1 Draft, 2 Diajukan, 3 Dikembalikan ULP, 4 Diterima, 5 Saran-Distribusi,
 * 6 Distribusi, 7 Saran-Kaji, 8 Kaji, 9 Proses-Lelang, 10 Saran-Add, 11 Addendum,
 * 12 Hasil, 13 Ulang, 14 Selesai, 15 Gagal.
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

    /** Jumlah anggota Pokja yang diperbolehkan. */
    public const POKJA_SIZES = [3, 5, 7];

    /**
     * Opsi tiap aksi:
     *  roles     role yang boleh (ADMINISTRATOR selalu boleh)
     *  from      status asal
     *  to        status tujuan (selesai: 14 atau 15)
     *  note      null | 'optional' | 'required' => catatan ke tabel `catatan`
     *  member    true = harus anggota Pokja paket tsb
     *  assigned  true = harus Admin ULP yang mengambil paket
     *  pokja     true = anggota Pokja harus 3/5/7
     *  variant   kelas tombol
     */
    public const ACTIONS = [
        'pilih' => [
            'label' => 'Ambil untuk Diverifikasi', 'roles' => self::ULP, 'from' => [2], 'to' => null,
            'note' => null, 'variant' => 'primary',
            'confirm' => 'Ambil paket ini untuk diverifikasi oleh Anda?',
        ],
        'kembalikan' => [
            'label' => 'Kembalikan ke PPK', 'roles' => self::ULP, 'from' => [2], 'to' => 3,
            'note' => 'required', 'assigned' => true, 'variant' => 'danger',
            'confirm' => 'Kembalikan paket ke PPK? Tuliskan alasan pengembalian.',
        ],
        'ajukan_kembali' => [
            'label' => 'Ajukan Kembali ke ULP', 'roles' => self::PPK_SIDE, 'from' => [3], 'to' => 2,
            'note' => null, 'variant' => 'primary',
            'confirm' => 'Ajukan kembali paket ke Admin ULP?',
        ],
        'terima' => [
            'label' => 'Terima Berkas', 'roles' => self::ULP, 'from' => [2], 'to' => 4,
            'note' => null, 'assigned' => true, 'variant' => 'success',
            'confirm' => 'Terima berkas paket ini?',
        ],
        'saran' => [
            'label' => 'Berikan Saran Distribusi', 'roles' => self::DISTRIBUSI, 'from' => [4], 'to' => 5,
            'note' => null, 'pokja' => true, 'variant' => 'primary',
            'confirm' => 'Kirim usulan Pokja ke Kepala ULP?',
        ],
        'distribusi' => [
            'label' => 'Tetapkan Distribusi', 'roles' => self::KEPALA, 'from' => [5], 'to' => 6,
            'note' => null, 'pokja' => true, 'variant' => 'success',
            'confirm' => 'Tetapkan distribusi paket ke Pokja terpilih?',
        ],
        'sarankaji' => [
            'label' => 'Saran Kaji Ulang ke PPK', 'roles' => self::POKJA, 'from' => [6, 8], 'to' => 7,
            'note' => 'required', 'member' => true, 'variant' => 'warning',
            'confirm' => 'Kembalikan paket ke PPK untuk dikaji ulang. Tuliskan sarannya.',
        ],
        'ajukan_kaji' => [
            'label' => 'Ajukan ke Pokja (Setelah Kaji)', 'roles' => self::PPK_SIDE, 'from' => [7], 'to' => 8,
            'note' => null, 'variant' => 'primary',
            'confirm' => 'Ajukan kembali paket ke Pokja?',
        ],
        'lelang' => [
            'label' => 'Tayangkan Lelang', 'roles' => self::POKJA, 'from' => [6, 8], 'to' => 9,
            'note' => null, 'member' => true, 'variant' => 'success',
            'confirm' => 'Tayangkan paket ini (proses lelang dimulai)?',
        ],
        'saranadd' => [
            'label' => 'Saran Addendum ke PPK', 'roles' => self::POKJA, 'from' => [9, 11], 'to' => 10,
            'note' => 'required', 'member' => true, 'variant' => 'warning',
            'confirm' => 'Kembalikan paket ke PPK untuk addendum. Tuliskan sarannya.',
        ],
        'ajukan_add' => [
            'label' => 'Ajukan Addendum ke Pokja', 'roles' => self::PPK_SIDE, 'from' => [10], 'to' => 11,
            'note' => null, 'variant' => 'primary',
            'confirm' => 'Ajukan addendum ke Pokja?',
        ],
        'lanjutkan' => [
            'label' => 'Lanjutkan Lelang', 'roles' => self::POKJA, 'from' => [11], 'to' => 9,
            'note' => null, 'member' => true, 'variant' => 'success',
            'confirm' => 'Lanjutkan proses lelang?',
        ],
        'hasil' => [
            'label' => 'Kirim Hasil Lelang', 'roles' => self::POKJA, 'from' => [9, 11], 'to' => 12,
            'note' => null, 'member' => true, 'variant' => 'success',
            'confirm' => 'Kirim hasil lelang ke PPK? Persyaratan dan dokumen akan dikunci.',
        ],
        'ulang' => [
            'label' => 'Perintahkan Lelang Ulang', 'roles' => self::PPK_ONLY, 'from' => [12], 'to' => 13,
            'note' => 'required', 'variant' => 'warning',
            'confirm' => 'Perintahkan lelang ulang? Tuliskan alasannya.',
        ],
        'lelang_ulang' => [
            'label' => 'Jalankan Lelang Ulang', 'roles' => self::POKJA, 'from' => [13], 'to' => 9,
            'note' => null, 'member' => true, 'variant' => 'success',
            'confirm' => 'Jalankan lelang ulang?',
        ],
        'selesai' => [
            'label' => 'Selesaikan Paket', 'roles' => self::PPK_ONLY, 'from' => [12], 'to' => 14,
            'note' => 'optional', 'variant' => 'success',
            'confirm' => 'Nyatakan proses lelang selesai.',
        ],
    ];

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
     * Aksi yang syarat Pokja-nya belum terpenuhi diberi 'blocked' (alasan).
     */
    public static function available(array $paket, array $actor, bool $isMember, int $pokjaCount): array
    {
        $status = (int) ($paket['status_paket'] ?? 0);
        $role   = self::roleKey($actor);
        $admin  = self::isAdmin($actor);
        $out    = [];

        foreach (self::ACTIONS as $key => $def) {
            if (! in_array($status, $def['from'], true)) {
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

            if (! empty($def['pokja']) && ! in_array($pokjaCount, self::POKJA_SIZES, true)) {
                $def['blocked'] = "Jumlah anggota Pokja harus 3, 5, atau 7 orang (saat ini {$pokjaCount}).";
            }

            $out[$key] = $def;
        }

        return $out;
    }

    /**
     * Kemampuan non-transisi (kelola pokja, dokumen, hasil, LPSE, catatan) untuk UI & validasi.
     */
    public static function capabilities(array $paket, array $actor, bool $isMember): array
    {
        $status = (int) ($paket['status_paket'] ?? 0);
        $role   = self::roleKey($actor);
        $admin  = self::isAdmin($actor);
        $pokjaMember = $admin || ($role === 'POKJA' && $isMember);

        return [
            'pokja'   => ($admin || $role === 'DISTRIBUSI') && in_array($status, [4, 5], true),
            'dokumen' => $pokjaMember && in_array($status, [9, 11], true),
            'hasil'   => $pokjaMember && in_array($status, [9, 11], true),
            'lpse'    => ($admin || $role === 'ADMIN AGENCY') && (int) ($paket['is_lpse'] ?? 0) === 0 && $status >= 6 && $status <= 13,
            'catatan' => $role !== 'MONEV' && $status >= 2,
        ];
    }
}
