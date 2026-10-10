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
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get user by username or email along with role and agency name
     */
    public function getUserWithRole(string $identifier)
    {
        return $this->select('users.*, roles.name as role_name, agencies.name as agency_name, agencies.abbreviation as agency_abbr, ppk.name as ppk_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('agencies', 'agencies.id = users.skpd_id', 'left')
            ->join('ppk', 'ppk.id = users.ppk_id', 'left')
            ->groupStart()
                ->where('users.username', $identifier)
                ->orWhere('users.email', $identifier)
            ->groupEnd()
            ->first();
    }

    /**
     * Get all users with roles and agency details
     */
    public function getUsersWithDetails()
    {
        return $this->select('users.*, roles.name as role_name, agencies.name as agency_name, agencies.abbreviation as agency_abbr, agencies.code as agency_code, ppk.name as ppk_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('agencies', 'agencies.id = users.skpd_id', 'left')
            ->join('ppk', 'ppk.id = users.ppk_id', 'left')
            ->orderBy('users.id', 'ASC')
            ->findAll();
    }
}
