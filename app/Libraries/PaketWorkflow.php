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
            'label' => 'Ajukan Kembali ke ULP', 'roles' => self::PPK_ONLY, 'from' => [3], 'to' => 2,
            'note' => null, 'variant' => 'primary',
            'confirm' => 'Ajukan kembali paket ke Admin ULP?',
        ],
        'terima' => [
            'label' => 'Terima', 'roles' => self::ULP, 'from' => [2], 'to' => 4,
            'note' => null, 'assigned' => true, 'variant' => 'success',
            'confirm' => 'Terima berkas paket ini untuk dilanjutkan ke distribusi Pokja?',
        ],
        'saran' => [
            'label' => 'Saran Distribusi', 'roles' => self::DISTRIBUSI, 'from' => [4], 'to' => 5,
            'note' => null, 'pokja' => true, 'variant' => 'danger',
            'confirm' => 'Kirim usulan Pokja ke Kepala ULP?',
        ],
        'distribusi' => [
            'label' => 'Distribusi', 'roles' => self::KEPALA, 'from' => [5], 'to' => 6,
            'note' => null, 'pokja' => true, 'variant' => 'danger',
            'confirm' => 'Tetapkan distribusi paket ke Pokja terpilih?',
        ],
        'sarankaji' => [
            'label' => 'Saran Kaji', 'roles' => self::POKJA, 'from' => [6, 8], 'to' => 7,
            'note' => 'optional', 'member' => true, 'variant' => 'danger',
            'confirm' => 'Kembalikan paket ke PPK untuk dikaji ulang? (Catatan harus sudah diisi atau tulis di bawah ini)',
        ],
        'ajukan_kaji' => [
            'label' => 'Ajukan ke Pokja (Setelah Kaji)', 'roles' => self::PPK_ONLY, 'from' => [7], 'to' => 8,
            'note' => null, 'variant' => 'primary',
            'confirm' => 'Ajukan kembali paket ke Pokja?',
        ],
        'lelang' => [
            'label' => 'Tayangkan Paket', 'roles' => self::POKJA, 'from' => [6, 8], 'to' => 9,
            'note' => null, 'member' => true, 'variant' => 'success',
            'confirm' => 'Tayangkan paket ini (proses lelang dimulai)?',
        ],
        'saranadd' => [
            'label' => 'Saran Addendum ke PPK', 'roles' => self::POKJA, 'from' => [9, 11], 'to' => 10,
            'note' => 'optional', 'member' => true, 'variant' => 'warning',
            'confirm' => 'Kembalikan paket ke PPK untuk addendum? (Catatan harus sudah diisi atau tulis di bawah ini)',
        ],
        'ajukan_add' => [
            'label' => 'Ajukan Addendum ke Pokja', 'roles' => self::PPK_ONLY, 'from' => [10], 'to' => 11,
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
            // Langkah 1a & 2a: Admin Distribusi (status 4 & 5) dan Kepala ULP (status 5) dapat mengubah susunan Pokja
            'pokja'   => ($admin && in_array($status, [4, 5], true))
                || ($role === 'DISTRIBUSI' && in_array($status, [4, 5], true))
                || ($role === 'KEPALA ULP' && $status === 5),
            // Langkah 3b: Pokja dapat mengunggah dokumen lelang mulai saat paket terdistribusi (6, 8) hingga lelang/addendum (9, 11)
            'dokumen' => $pokjaMember && in_array($status, [6, 8, 9, 11], true),
            'hasil'   => $pokjaMember && in_array($status, [9, 11], true),
            // Langkah 3a: Admin Agency memproses Room LPSE untuk paket berstatus 6 s/d 14 yang belum lpse=1
            'lpse'    => ($admin || $role === 'ADMIN AGENCY') && (int) ($paket['is_lpse'] ?? 0) === 0 && $status >= 6 && $status <= 14,
            'catatan' => $role !== 'MONEV' && $status >= 2,
        ];
    }
}
