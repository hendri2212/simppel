<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketPokjaModel extends Model
{
    protected $table            = 'paket_pokja';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'paket_id',
        'user_id',
        'role',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get pokja members for specific paket
     */
    public function getMembersByPaket(int $paketId): array
    {
        return $this->select('paket_pokja.*, users.full_name, users.username, users.email')
            ->join('users', 'users.id = paket_pokja.user_id', 'left')
            ->where('paket_pokja.paket_id', $paketId)
            ->findAll();
    }
}
