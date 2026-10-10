<?php

namespace App\Controllers;

use App\Models\AgencyModel;
use App\Models\RoleModel;
use App\Models\UserModel;

class AccountController extends BaseController
{
    protected UserModel $userModel;
    protected AgencyModel $agencyModel;
    protected RoleModel $roleModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->agencyModel = new AgencyModel();
        $this->roleModel   = new RoleModel();
    }

    /**
     * Tampilkan halaman daftar akun pengguna
     */
    public function index()
    {
        try {
            $dbUsers     = $this->userModel->getUsersWithDetails();
            $allAgencies = $this->agencyModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
            $allRoles    = $this->roleModel->orderBy('id', 'ASC')->findAll();

            $usersList = array_map(function ($u) {
                $roleName = $u['role_name'] ?? 'USER';
                $isActive = (int) ($u['is_active'] ?? 0) === 1;

                $roleBadge = match ($roleName) {
                    'ADMINISTRATOR' => 'bg-danger-subtle text-danger border border-danger-subtle',
                    'ADMIN PPK'     => 'bg-primary-subtle text-primary border border-primary-subtle',
                    'PPK'           => 'bg-info-subtle text-info border border-info-subtle',
                    'ADMIN ULP'     => 'bg-success-subtle text-success border border-success-subtle',
                    'DISTRIBUSI'    => 'bg-warning-subtle text-warning border border-warning-subtle',
                    'KEPALA ULP'    => 'bg-purple-subtle text-purple border border-purple-subtle',
                    'POKJA'         => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                    'MONEV'         => 'bg-dark-subtle text-dark border border-dark-subtle',
                    default         => 'bg-light text-dark border',
                };

                return [
                    'id'           => $u['id'],
                    'name'         => $u['full_name'],
                    'username'     => '@' . ltrim($u['username'], '@'),
                    'raw_username' => ltrim($u['username'], '@'),
                    'nip'          => !empty($u['nip']) && $u['nip'] !== '-' ? $u['nip'] : '-',
                    'raw_nip'      => !empty($u['nip']) && $u['nip'] !== '-' ? $u['nip'] : '',
                    'email'        => $u['email'] ?: '-',
                    'raw_email'    => $u['email'] ?: '',
                    'whatsapp'     => $u['whatsapp_number'] ?: '-',
                    'raw_whatsapp' => $u['whatsapp_number'] ?: '',
                    'role'         => $roleName,
                    'role_id'      => $u['role_id'] ?? null,
                    'role_badge'   => $roleBadge,
                    'agency_id'    => $u['agency_id'] ?? null,
                    'agency_name'  => $u['agency_name'] ?? null,
                    'agency_abbr'  => $u['agency_abbr'] ?? null,
                    'agency_code'  => $u['agency_code'] ?? null,
                    'status'       => $isActive ? 'Active' : 'Inactive',
                    'is_active'    => $isActive ? 1 : 0,
                    'status_badge' => $isActive ? 'bg-success' : 'bg-secondary',
                    'avatar'       => '/img/demo/avatars/avatar-admin.png',
                    'created_at'   => !empty($u['created_at']) ? date('d M Y', strtotime($u['created_at'])) : '-',
                ];
            }, $dbUsers);
        } catch (\Throwable $e) {
            log_message('error', 'Error in AccountController::index: ' . $e->getMessage());
            $usersList   = [];
            $allAgencies = [];
            $allRoles    = [];
        }

        $totalCount      = count($usersList);
        $activeCount     = count(array_filter($usersList, fn($u) => $u['status'] === 'Active'));
        $inactiveCount   = count(array_filter($usersList, fn($u) => $u['status'] === 'Inactive'));
        $usersWithAgency = count(array_filter($usersList, fn($u) => !empty($u['agency_name'])));
        $uniqueRoles     = !empty($allRoles)
            ? array_column($allRoles, 'name')
            : array_unique(array_filter(array_column($usersList, 'role')));
        sort($uniqueRoles);

        return view('accounts', [
            'pageTitle'       => 'User Accounts',
            'usersList'       => $usersList,
            'allAgencies'     => $allAgencies,
            'allRoles'        => $allRoles,
            'totalCount'      => $totalCount,
            'activeCount'     => $activeCount,
            'inactiveCount'   => $inactiveCount,
            'usersWithAgency' => $usersWithAgency,
            'uniqueRoles'     => $uniqueRoles,
        ]);
    }

    /**
     * Update akun pengguna
     */
    public function update($id = null)
    {
        $id = $id ? (int) $id : (int) $this->request->getPost('id');

        if (! $id) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ID pengguna tidak valid.'])->setStatusCode(400);
            }
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        $user = $this->userModel->find($id);
        if (! $user) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Akun pengguna tidak ditemukan.'])->setStatusCode(404);
            }
            return redirect()->back()->with('error', 'Akun pengguna tidak ditemukan.');
        }

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[255]',
            'username'  => "required|min_length[3]|max_length[100]|is_unique[users.username,id,{$id}]",
            'role_id'   => 'required|is_not_unique[roles.id]',
        ];

        if (! $this->validate($rules)) {
            $errors = implode(', ', $this->validator->getErrors());
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $errors,
                    'errors'  => $this->validator->getErrors(),
                ])->setStatusCode(422);
            }
            return redirect()->back()->withInput()->with('error', $errors);
        }

        $username = trim((string) $this->request->getPost('username'));
        $username = ltrim($username, '@');

        $agencyId = $this->request->getPost('agency_id');
        $agencyId = !empty($agencyId) ? (int) $agencyId : null;

        $updateData = [
            'full_name'       => trim((string) $this->request->getPost('full_name')),
            'username'        => $username,
            'role_id'         => (int) $this->request->getPost('role_id'),
            'agency_id'       => $agencyId,
            'nip'             => trim((string) $this->request->getPost('nip')) ?: null,
            'email'           => trim((string) $this->request->getPost('email')) ?: null,
            'whatsapp_number' => trim((string) $this->request->getPost('whatsapp_number')) ?: null,
            'is_active'       => (int) ($this->request->getPost('is_active') ?? 0),
        ];

        // Jika password diisi, update password
        $password = (string) $this->request->getPost('password');
        if (!empty(trim($password))) {
            if (strlen(trim($password)) < 6) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Password minimal 6 karakter.'])->setStatusCode(422);
                }
                return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
            }
            $updateData['password'] = password_hash(trim($password), PASSWORD_BCRYPT);
        }

        try {
            $this->userModel->update($id, $updateData);

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Data akun pengguna berhasil diperbarui!',
                    'data'    => $updateData,
                ]);
            }

            return redirect()->to('/accounts')->with('success', 'Data akun pengguna berhasil diperbarui!');
        } catch (\Throwable $e) {
            log_message('error', 'Error update user: ' . $e->getMessage());
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui akun: ' . $e->getMessage()])->setStatusCode(500);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }
}
