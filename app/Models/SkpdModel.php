<?php

namespace App\Models;

use CodeIgniter\Model;

class SkpdModel extends Model
{
    protected $table            = 'skpd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'abbreviation',
        'code',
        'address',
        'contact',
        'work_unit_id',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
