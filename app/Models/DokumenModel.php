<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenModel extends Model
{
    protected $table            = 'dokumen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'paket_id',
        'nama_dokumen',
        'nama_file',
        'uploaded_by',
        'selesai',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByPaketId(int $paketId): array
    {
        return $this->where('paket_id', $paketId)->orderBy('id', 'ASC')->findAll();
    }
}
