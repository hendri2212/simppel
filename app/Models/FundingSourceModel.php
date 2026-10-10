<?php

namespace App\Models;

use CodeIgniter\Model;

class FundingSourceModel extends Model
{
    protected $table            = 'funding_sources';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get active funding sources
     */
    public function getActiveSources()
    {
        return $this->where('is_active', 1)->orderBy('id', 'ASC')->findAll();
    }
}
