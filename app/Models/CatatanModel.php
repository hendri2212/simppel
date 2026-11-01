<?php

namespace App\Models;

use CodeIgniter\Model;

class CatatanModel extends Model
{
    protected $table            = 'catatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'paket_id',
        'user_id',
        'role_id',
        'status_paket',
        'isi_catatan',
        'isi_jawaban',
        'jawab_user_id',
        'jawab_role_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Daftar catatan paket beserta nama pembuat dan penjawab.
     */
    public function getByPaketId(int $paketId): array
    {
        return $this->select('catatan.*, u.full_name AS user_name, r.name AS role_name, j.full_name AS jawab_name, jr.name AS jawab_role_name')
            ->join('users u', 'u.id = catatan.user_id', 'left')
            ->join('roles r', 'r.id = catatan.role_id', 'left')
            ->join('users j', 'j.id = catatan.jawab_user_id', 'left')
            ->join('roles jr', 'jr.id = catatan.jawab_role_id', 'left')
            ->where('catatan.paket_id', $paketId)
            ->orderBy('catatan.id', 'ASC')
            ->findAll();
    }
}
