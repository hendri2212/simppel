<?php

namespace App\Controllers\Traits;

use CodeIgniter\HTTP\ResponseInterface;

/**
 * Kontrol akses data RUP / Paket berdasarkan role dan kepemilikan (SKPD & Bidang/PPK).
 *
 * - Role pusat (ULP, Pokja, Monev & Administrator) dapat melihat seluruh data.
 * - Role penyusun (PPK, ADMIN PPK) hanya melihat/mengubah data milik kombinasi SKPD (`skpd_id`)
 *   dan Bidang/PPK (`ppk_id`) tempat akun tersebut bernaung.
 *
 * Data user selalu dibaca dari database (bukan session) agar perubahan role / SKPD / Bidang langsung berlaku.
 */
trait ProcurementScope
{
    /** Role yang dapat melihat seluruh data lintas SKPD. */
    protected const GLOBAL_ROLES = ['ADMINISTRATOR', 'ADMIN ULP', 'KEPALA ULP', 'DISTRIBUSI', 'POKJA', 'ADMIN AGENCY', 'MONEV'];

    /** Role yang boleh membuat / mengubah RUP & paket (tetap dibatasi kepemilikan). */
    public const WRITE_ROLES = ['ADMINISTRATOR', 'ADMIN PPK', 'PPK'];

    /** Role yang berhak mengeksekusi pengajuan paket ke ULP / Pokja (khusus PPK & Administrator, sesuai contoh level 3). */
    public const AJUKAN_ROLES = ['ADMINISTRATOR', 'PPK'];

    private ?array $actorCache = null;

    protected function actor(): array
    {
        if ($this->actorCache !== null) {
            return $this->actorCache;
        }

        $row = db_connect()->table('users')
            ->select('users.id, users.full_name, users.role_id, users.skpd_id, users.ppk_id, users.is_active, roles.name AS role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.id', (int) session()->get('user_id'))
            ->get()->getRowArray();

        return $this->actorCache = $row ?: [
            'id' => 0, 'full_name' => '', 'role_id' => 0, 'skpd_id' => null,
            'ppk_id' => null, 'is_active' => 0, 'role_name' => '',
        ];
    }

    protected function hasGlobalScope(): bool
    {
        return in_array(strtoupper((string) $this->actor()['role_name']), self::GLOBAL_ROLES, true);
    }

    protected function canWrite(): bool
    {
        return in_array(strtoupper((string) $this->actor()['role_name']), self::WRITE_ROLES, true);
    }

    protected function canAjukan(): bool
    {
        return in_array(strtoupper((string) $this->actor()['role_name']), self::AJUKAN_ROLES, true);
    }

    /**
     * Batasi query (model/builder) pada data milik user berdasarkan SKPD dan Bidang (PPK).
     *
     * @param object $query Model atau BaseBuilder
     */
    protected function scopeToActor(object $query, string $skpdColumn, string $ppkColumn): object
    {
        if ($this->hasGlobalScope()) {
            return $query;
        }

        $actor = $this->actor();

        if (empty($actor['skpd_id'])) {
            // Tanpa afiliasi SKPD: tidak boleh melihat data apa pun
            return $query->where('1 = 0', null, false);
        }

        $query->where($skpdColumn, (int) $actor['skpd_id']);

        if (! empty($actor['ppk_id'])) {
            $query->where($ppkColumn, (int) $actor['ppk_id']);
        }

        return $query;
    }

    /**
     * Apakah baris yang memuat skpd_id dan ppk_id berada dalam cakupan SKPD & Bidang user.
     */
    protected function inScope(array $row): bool
    {
        if ($this->hasGlobalScope()) {
            return true;
        }

        $actor = $this->actor();

        if (empty($actor['skpd_id']) || (int) ($row['skpd_id'] ?? 0) !== (int) $actor['skpd_id']) {
            return false;
        }

        if (! empty($actor['ppk_id'])) {
            return (int) ($row['ppk_id'] ?? 0) === (int) $actor['ppk_id'];
        }

        return true;
    }

    /**
     * Respons JSON (AJAX) atau redirect (non-AJAX) untuk error.
     */
    protected function failWith(string $message, int $status, string $redirectTo = '/'): ResponseInterface
    {
        if ($this->request->isAJAX()) {
            return $this->response->setStatusCode($status)->setJSON(['status' => 'error', 'message' => $message]);
        }

        return redirect()->to($redirectTo)->withInput()->with('error', $message);
    }

    protected function okWith(string $message, array $extra = [], string $redirectTo = '/'): ResponseInterface
    {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => $message] + $extra);
        }

        return redirect()->to($redirectTo)->with('success', $message);
    }
}
