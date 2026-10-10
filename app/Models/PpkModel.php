<?php

namespace App\Models;

use CodeIgniter\Model;

class PpkModel extends Model
{
    protected $table            = 'ppk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'skpd_id',
        'name',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get PPK along with skpd details
     */
    public function getWithSkpd(?int $id = null)
    {
        $builder = $this->select('ppk.*, skpd.name as skpd_name, skpd.abbreviation as skpd_abbreviation')
            ->join('skpd', 'skpd.id = ppk.skpd_id', 'inner');

        if ($id !== null) {
            return $builder->where('ppk.id', $id)->first();
        }

        return $builder->findAll();
    }
}
