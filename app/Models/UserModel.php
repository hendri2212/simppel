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
        'agency_id',
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
        return $this->select('users.*, roles.name as role_name, agencies.name as agency_name, agencies.abbreviation as agency_abbr')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('agencies', 'agencies.id = users.agency_id', 'left')
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
        return $this->select('users.*, roles.name as role_name, agencies.name as agency_name, agencies.abbreviation as agency_abbr, agencies.code as agency_code')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('agencies', 'agencies.id = users.agency_id', 'left')
            ->orderBy('users.id', 'ASC')
            ->findAll();
    }
}
