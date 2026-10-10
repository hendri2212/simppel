<?php

namespace App\Models;

use CodeIgniter\Model;

class CommitmentOfficerModel extends Model
{
    protected $table            = 'commitment_officers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'agency_id',
        'name',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get commitment officers along with agency details
     */
    public function getWithAgency(?int $id = null)
    {
        $builder = $this->select('commitment_officers.*, agencies.name as agency_name, agencies.abbreviation as agency_abbreviation')
            ->join('agencies', 'agencies.id = commitment_officers.agency_id', 'inner');

        if ($id !== null) {
            return $builder->where('commitment_officers.id', $id)->first();
        }

        return $builder->findAll();
    }
}
