<?php

namespace App\Models;

use CodeIgniter\Model;

class ProcurementPlanModel extends Model
{
    protected $table            = 'procurement_plans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'agency_id',
        'commitment_officer_id',
        'fiscal_year',
        'activity',
        'package_name',
        'package_code',
        'location',
        'expense_type_id',
        'procurement_type_id',
        'volume',
        'description',
        'selection_method_id',
        'submission_date',
        'notes',
        'rup_status',
        'funding_source_id',
        'work_duration',
        'budget_ceiling',
        'account_code',
        'special_allocation_type_id',
        'package_status',
        'is_synced',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get procurement plans with full relation details
     */
    public function getWithRelations(?int $id = null)
    {
        $builder = $this->select('
                procurement_plans.*,
                agencies.name as agency_name,
                agencies.abbreviation as agency_abbreviation,
                commitment_officers.name as commitment_officer_name,
                expense_types.name as expense_type_name,
                procurement_types.name as procurement_type_name,
                funding_sources.name as funding_source_name,
                selection_methods.name as selection_method_name,
                special_allocation_types.name as special_allocation_type_name
            ')
            ->join('agencies', 'agencies.id = procurement_plans.agency_id', 'left')
            ->join('commitment_officers', 'commitment_officers.id = procurement_plans.commitment_officer_id', 'left')
            ->join('expense_types', 'expense_types.id = procurement_plans.expense_type_id', 'left')
            ->join('procurement_types', 'procurement_types.id = procurement_plans.procurement_type_id', 'left')
            ->join('funding_sources', 'funding_sources.id = procurement_plans.funding_source_id', 'left')
            ->join('selection_methods', 'selection_methods.id = procurement_plans.selection_method_id', 'left')
            ->join('special_allocation_types', 'special_allocation_types.id = procurement_plans.special_allocation_type_id', 'left');

        if ($id !== null) {
            return $builder->where('procurement_plans.id', $id)->first();
        }

        return $builder->orderBy('procurement_plans.id', 'DESC')->findAll();
    }
}
