<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'full_name',
        'email',
        'username',
        'password',
        'role_id',
        'skpd_id',
        'ppk_id',
        'nip',
        'whatsapp_number',
        'avatar',
        'is_active',
        'remember_token',
        'remember_expires_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get user by username or email along with role and skpd name
     */
    public function getUserWithRole(string $identifier)
    {
        return $this->select('users.*, roles.name as role_name, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, ppk.name as ppk_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('skpd', 'skpd.id = users.skpd_id', 'left')
            ->join('ppk', 'ppk.id = users.ppk_id', 'left')
            ->groupStart()
                ->where('users.username', $identifier)
                ->orWhere('users.email', $identifier)
            ->groupEnd()
            ->first();
    }

    /**
     * Get user by ID along with role, skpd, and ppk details
     */
    public function getUserWithRoleById(int $userId)
    {
        return $this->select('users.*, roles.name as role_name, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, ppk.name as ppk_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('skpd', 'skpd.id = users.skpd_id', 'left')
            ->join('ppk', 'ppk.id = users.ppk_id', 'left')
            ->where('users.id', $userId)
            ->first();
    }

    /**
     * Get all users with roles and skpd details (tanpa kolom password).
     */
    public function getUsersWithDetails()
    {
        return $this->select('users.id, users.full_name, users.email, users.username, users.role_id, users.skpd_id, users.ppk_id, users.nip, users.whatsapp_number, users.avatar, users.is_active, users.created_at, roles.name as role_name, skpd.name as skpd_name, skpd.abbreviation as skpd_abbr, skpd.code as skpd_code, ppk.name as ppk_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('skpd', 'skpd.id = users.skpd_id', 'left')
            ->join('ppk', 'ppk.id = users.ppk_id', 'left')
            ->orderBy('users.id', 'ASC')
            ->findAll();
    }
}
