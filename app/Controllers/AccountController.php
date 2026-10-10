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
                    'nip'          => !empty($u['nip']) && $u['nip'] !== '-' ? $u['nip'] : '-',
                    'email'        => $u['email'] ?: '-',
                    'whatsapp'     => $u['whatsapp_number'] ?: '-',
                    'role'         => $roleName,
                    'role_badge'   => $roleBadge,
                    'agency_id'    => $u['agency_id'] ?? null,
                    'agency_name'  => $u['agency_name'] ?? null,
                    'agency_abbr'  => $u['agency_abbr'] ?? null,
                    'agency_code'  => $u['agency_code'] ?? null,
                    'status'       => $isActive ? 'Active' : 'Inactive',
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
}
