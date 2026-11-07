<?php

namespace App\Controllers;

use App\Models\SkpdModel;
use App\Models\PpkModel;
use App\Models\PejabatPengadaanSkpdModel;
use App\Models\RoleModel;
use App\Models\UserModel;

/**
 * Manajemen akun pengguna.
 *
 * Akses dibatasi ke ADMINISTRATOR melalui filter route (lihat Config/Routes.php);
 * seluruh route mutasi juga dilindungi filter CSRF.
 */
class AccountController extends BaseController
{
    private const ROLE_BADGES = [
        'ADMINISTRATOR' => 'bg-danger-subtle text-danger border border-danger-subtle',
        'ADMIN PPK'     => 'bg-primary-subtle text-primary border border-primary-subtle',
        'PPK'           => 'bg-info-subtle text-info border border-info-subtle',
        'ADMIN ULP'     => 'bg-success-subtle text-success border border-success-subtle',
        'DISTRIBUSI'    => 'bg-warning-subtle text-warning border border-warning-subtle',
        'KEPALA ULP'    => 'bg-purple-subtle text-purple border border-purple-subtle',
        'POKJA'         => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
        'MONEV'         => 'bg-dark-subtle text-dark border border-dark-subtle',
    ];

    private const DEFAULT_BADGE = 'bg-light text-dark border';

    protected UserModel $userModel;
    protected SkpdModel $skpdModel;
    protected RoleModel $roleModel;
    protected PpkModel $ppkModel;
    protected PejabatPengadaanSkpdModel $pejabatSkpdModel;

    public function __construct()
    {
        $this->userModel        = new UserModel();
        $this->skpdModel        = new SkpdModel();
        $this->roleModel        = new RoleModel();
        $this->ppkModel         = new PpkModel();
        $this->pejabatSkpdModel = new PejabatPengadaanSkpdModel();
    }

    /**
     * Tampilkan halaman daftar akun pengguna
     */
    public function index()
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $usersList = $allSkpd = $allRoles = $ppkList = [];

        try {
            $allSkpd      = $this->skpdModel->select('id, name, abbreviation')->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $allRoles     = $this->roleModel->select('id, name')->orderBy('id', 'ASC')->findAll();
            $ppkList      = $this->ppkModel->select('id, name, skpd_id')->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $pejabatSkpds = $this->pejabatSkpdModel->getGroupedByUser();

            foreach ($this->userModel->getUsersWithDetails() as $u) {
                $roleName = $u['role_name'] ?? 'USER';
                $isActive = (int) ($u['is_active'] ?? 0) === 1;
                $nip      = ! empty($u['nip']) && $u['nip'] !== '-' ? $u['nip'] : '';
                $username = ltrim((string) $u['username'], '@');
                $uid      = (int) $u['id'];
                $pSkpd    = $pejabatSkpds[$uid] ?? [];

                $usersList[] = [
                    'id'                => $uid,
                    'name'              => $u['full_name'],
                    'username'          => '@' . $username,
                    'raw_username'      => $username,
                    'nip'               => $nip !== '' ? $nip : '-',
                    'raw_nip'           => $nip,
                    'email'             => $u['email'] ?: '-',
                    'raw_email'         => $u['email'] ?: '',
                    'whatsapp'          => $u['whatsapp_number'] ?: '-',
                    'raw_whatsapp'      => $u['whatsapp_number'] ?: '',
                    'role'              => $roleName,
                    'role_id'           => $u['role_id'] ?? null,
                    'role_badge'        => self::ROLE_BADGES[$roleName] ?? self::DEFAULT_BADGE,
                    'skpd_id'           => $u['skpd_id'] ?? null,
                    'skpd_name'         => $u['skpd_name'] ?? null,
                    'skpd_abbr'         => $u['skpd_abbr'] ?? null,
                    'skpd_code'         => $u['skpd_code'] ?? null,
                    'ppk_id'            => $u['ppk_id'] ?? null,
                    'ppk_name'          => $u['ppk_name'] ?? null,
                    'pejabat_skpds'     => $pSkpd,
                    'pejabat_skpd_ids'  => array_column($pSkpd, 'skpd_id'),
                    'status'            => $isActive ? 'Active' : 'Inactive',
                    'is_active'         => $isActive ? 1 : 0,
                    'status_badge'      => $isActive ? 'bg-success' : 'bg-secondary',
                    'avatar'            => '/img/demo/avatars/avatar-admin.png',
                    'created_at'        => ! empty($u['created_at']) ? date('d M Y', strtotime($u['created_at'])) : '-',
                ];
            }
        } catch (\Throwable $e) {
            log_message('error', 'Error in AccountController::index: ' . $e->getMessage());
            $usersList = $allSkpd = $allRoles = $ppkList = [];
        }

        // Satu kali iterasi untuk semua statistik
        $activeCount   = 0;
        $usersWithSkpd = 0;
        foreach ($usersList as $u) {
            $activeCount   += $u['is_active'];
            $usersWithSkpd += (! empty($u['skpd_name']) || ! empty($u['pejabat_skpds'])) ? 1 : 0;
        }
        $totalCount = count($usersList);

        $uniqueRoles = array_column($allRoles, 'name');
        sort($uniqueRoles);

        return view('accounts', [
            'pageTitle'     => 'User Accounts',
            'usersList'     => $usersList,
            'allSkpd'       => $allSkpd,
            'allRoles'      => $allRoles,
            'ppkList'       => $ppkList,
            'totalCount'    => $totalCount,
            'activeCount'   => $activeCount,
            'inactiveCount' => $totalCount - $activeCount,
            'usersWithSkpd' => $usersWithSkpd,
            'uniqueRoles'   => $uniqueRoles,
        ]);
    }

    /**
     * API: Ambil daftar PPK / Bidang (PPK) berdasarkan SKPD (skpd_id)
     */
    public function getPpk($skpdId = null)
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $skpdId = (int) ($skpdId ?? $this->request->getGet('skpd_id'));

        if ($skpdId <= 0) {
            return $this->respond(['status' => 'success', 'data' => []]);
        }

        try {
            $officers = $this->ppkModel
                ->select('id, name, skpd_id')
                ->where('skpd_id', $skpdId)
                ->where('is_active', 1)
                ->orderBy('name', 'ASC')
                ->findAll();

            return $this->respond(['status' => 'success', 'data' => $officers]);
        } catch (\Throwable $e) {
            log_message('error', 'Error in getPpk: ' . $e->getMessage());

            return $this->respond(['status' => 'error', 'message' => 'Gagal mengambil data PPK/Bidang.'], 500);
        }
    }

    /**
     * Tambah akun pengguna baru
     */
    public function store()
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $data  = $this->collectInput();
        $rules = $this->rules(null, true);

        if (! $this->validateData($data, $rules)) {
            return $this->validationFailed();
        }

        if ($error = $this->checkPpkBelongsToSkpd($data['skpd_id'], $data['ppk_id'])) {
            return $this->fail($error, 422);
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        try {
            $insertId = $this->userModel->insert($data);

            if ((int) $data['role_id'] === 7) {
                $pejabatSkpdIds = (array) $this->request->getPost('pejabat_skpd_ids');
                $this->pejabatSkpdModel->syncForUser((int) $insertId, $pejabatSkpdIds);
            }

            return $this->done('Akun pengguna baru berhasil ditambahkan!', ['id' => $insertId]);
        } catch (\Throwable $e) {
            log_message('error', 'Error store user: ' . $e->getMessage());

            return $this->fail('Gagal menambahkan akun. Silakan coba lagi.', 500);
        }
    }

    /**
     * Update akun pengguna
     */
    public function update($id = null)
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $id = $id ? (int) $id : (int) $this->request->getPost('id');

        if ($id <= 0) {
            return $this->fail('ID pengguna tidak valid.', 400);
        }

        if (! $this->userModel->select('id')->find($id)) {
            return $this->fail('Akun pengguna tidak ditemukan.', 404);
        }

        $data  = $this->collectInput();
        $rules = $this->rules($id, false);

        if (! $this->validateData($data, $rules)) {
            return $this->validationFailed();
        }

        if ($error = $this->checkPpkBelongsToSkpd($data['skpd_id'], $data['ppk_id'])) {
            return $this->fail($error, 422);
        }

        // Cegah administrator mengunci dirinya sendiri atau menurunkan hak aksesnya sendiri
        if ($id === (int) session()->get('user_id')) {
            if ($data['is_active'] !== 1) {
                return $this->fail('Anda tidak dapat menonaktifkan akun Anda sendiri.', 422);
            }
            if ($data['role_id'] !== (int) session()->get('role_id')) {
                return $this->fail('Anda tidak dapat mengubah role akun Anda sendiri.', 422);
            }
        }

        if ($data['password'] !== '') {
            $data['password']            = password_hash($data['password'], PASSWORD_BCRYPT);
            $data['remember_token']      = null;
            $data['remember_expires_at'] = null;
        } else {
            unset($data['password']);
            if ($data['is_active'] !== 1) {
                $data['remember_token']      = null;
                $data['remember_expires_at'] = null;
            }
        }

        try {
            $this->userModel->update($id, $data);

            if ((int) $data['role_id'] === 7) {
                $pejabatSkpdIds = (array) $this->request->getPost('pejabat_skpd_ids');
                $this->pejabatSkpdModel->syncForUser((int) $id, $pejabatSkpdIds);
            } else {
                $this->pejabatSkpdModel->syncForUser((int) $id, []);
            }

            return $this->done('Data akun pengguna berhasil diperbarui!');
        } catch (\Throwable $e) {
            log_message('error', 'Error update user: ' . $e->getMessage());

            return $this->fail('Gagal memperbarui akun. Silakan coba lagi.', 500);
        }
    }

    /**
     * Reset password user ke password sementara acak (ditampilkan satu kali).
     */
    public function resetPassword($id = null)
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $id = (int) ($id ?? $this->request->getPost('id'));

        if ($id <= 0) {
            return $this->fail('ID pengguna tidak valid.', 400);
        }

        $user = $this->userModel->select('id, full_name, username')->find($id);
        if (! $user) {
            return $this->fail('Pengguna tidak ditemukan.', 404);
        }

        $tempPassword = $this->generatePassword();

        try {
            $this->userModel->update($id, [
                'password'            => password_hash($tempPassword, PASSWORD_BCRYPT),
                'remember_token'      => null,
                'remember_expires_at' => null,
            ]);

            $userName = $user['full_name'] ?: $user['username'];

            return $this->done("Password untuk {$userName} berhasil direset.", [
                'temp_password' => $tempPassword,
                'user_id'       => $id,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Error reset password user: ' . $e->getMessage());

            return $this->fail('Gagal mereset password. Silakan coba lagi.', 500);
        }
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    /**
     * Ambil & normalisasi input form.
     */
    private function collectInput(): array
    {
        $post     = $this->request;
        $username = ltrim(trim((string) $post->getPost('username')), '@');
        $email    = trim((string) $post->getPost('email'));

        return [
            'full_name'       => trim((string) $post->getPost('full_name')),
            'username'        => $username,
            // Kolom email bersifat NOT NULL + UNIQUE; isi placeholder unik bila kosong.
            'email'           => $email !== '' ? strtolower($email) : $username . '@simpple.local',
            'role_id'         => (int) $post->getPost('role_id'),
            'skpd_id'         => (int) $post->getPost('skpd_id') ?: null,
            'ppk_id'          => (int) $post->getPost('ppk_id') ?: null,
            'nip'             => trim((string) $post->getPost('nip')) ?: null,
            'whatsapp_number' => trim((string) $post->getPost('whatsapp_number')) ?: null,
            'is_active'       => (string) $post->getPost('is_active') === '0' ? 0 : 1,
            'password'        => (string) $post->getPost('password'),
        ];
    }

    private function rules(?int $id, bool $passwordRequired): array
    {
        $ignore = $id !== null ? ",id,{$id}" : '';

        return [
            'full_name'       => 'required|min_length[3]|max_length[150]',
            'username'        => "required|min_length[3]|max_length[50]|regex_match[/^[A-Za-z0-9._-]+\$/]|is_unique[users.username{$ignore}]",
            'email'           => "required|valid_email|max_length[150]|is_unique[users.email{$ignore}]",
            'role_id'         => 'required|is_natural_no_zero|is_not_unique[roles.id]',
            'skpd_id'         => 'permit_empty|is_natural_no_zero|is_not_unique[skpd.id]',
            'ppk_id'          => 'permit_empty|is_natural_no_zero|is_not_unique[ppk.id]',
            'nip'             => 'permit_empty|max_length[30]|regex_match[/^[0-9]+$/]',
            'whatsapp_number' => 'permit_empty|max_length[20]|regex_match[/^\+?[0-9 \-]+$/]',
            'is_active'       => 'in_list[0,1]',
            'password'        => ($passwordRequired ? 'required' : 'permit_empty') . '|min_length[8]|max_length[72]',
        ];
    }

    /**
     * PPK yang dipilih harus berada di bawah SKPD yang dipilih.
     */
    private function checkPpkBelongsToSkpd(?int $skpdId, ?int $ppkId): ?string
    {
        if ($ppkId === null) {
            return null;
        }

        $ppk = $this->ppkModel->select('skpd_id')->find($ppkId);

        if (! $ppk || $skpdId === null || (int) $ppk['skpd_id'] !== $skpdId) {
            return 'PPK / Bidang tidak sesuai dengan SKPD yang dipilih.';
        }

        return null;
    }

    /**
     * Password sementara acak (tanpa karakter yang mudah tertukar).
     */
    private function generatePassword(int $length = 12): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
        $max      = strlen($alphabet) - 1;
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $alphabet[random_int(0, $max)];
        }

        return $password;
    }

    private function validationFailed()
    {
        $errors = $this->validator->getErrors();

        return $this->fail(implode(' ', $errors), 422, ['errors' => $errors]);
    }

    /**
     * Pertahanan ganda: pastikan hanya ADMINISTRATOR yang dapat mengakses fitur manajemen akun.
     */
    private function ensureAdministrator()
    {
        $roleId   = (int) session()->get('role_id');
        $roleName = strtoupper((string) session()->get('role_name'));

        if ($roleId !== 1 && $roleName !== 'ADMINISTRATOR') {
            if ($this->request->isAJAX()) {
                return $this->fail('Anda tidak memiliki hak akses ke fitur ini.', 403);
            }

            return redirect()->to('/')->with('error', 'Hanya Administrator yang memiliki akses ke halaman Manajemen Akun.');
        }

        return null;
    }

    private function done(string $message, array $extra = [])
    {
        if ($this->request->isAJAX()) {
            return $this->respond(['status' => 'success', 'message' => $message] + $extra);
        }

        return redirect()->to('/accounts')->with('success', $message);
    }

    private function fail(string $message, int $status, array $extra = [])
    {
        if ($this->request->isAJAX()) {
            return $this->respond(['status' => 'error', 'message' => $message] + $extra, $status);
        }

        return redirect()->back()->withInput()->with('error', $message);
    }

    /**
     * JSON response. Menyertakan token CSRF terbaru karena token diregenerasi
     * di setiap request (Security::$regenerate), agar klien bisa memakainya kembali.
     */
    private function respond(array $payload, int $status = 200)
    {
        $payload['csrf'] = csrf_hash();

        return $this->response->setStatusCode($status)->setJSON($payload);
    }
}
