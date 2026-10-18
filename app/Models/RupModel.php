<?php

namespace App\Models;

use CodeIgniter\Model;

class RupModel extends Model
{
    protected $table            = 'rup';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'skpd_id',
        'ppk_id',
        'fiscal_year',
        'activity',
        'package_name',
        'package_code',
        'location',
        'jenis_belanja_id',
        'jenis_pengadaan_id',
        'volume',
        'description',
        'metode_pemilihan_id',
        'submission_date',
        'notes',
        'rup_status',
        'sumber_dana_id',
        'work_duration',
        'budget_ceiling',
        'account_code',
        'jenis_dak_id',
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
                rup.*,
                skpd.name as skpd_name,
                skpd.abbreviation as skpd_abbreviation,
                ppk.name as ppk_name,
                jenis_belanja.name as jenis_belanja_name,
                jenis_pengadaan.name as jenis_pengadaan_name,
                sumber_dana.name as sumber_dana_name,
                metode_pemilihan.name as metode_pemilihan_name,
                jenis_dak.name as jenis_dak_name,
                paket.id as paket_id,
                paket.no_paket as paket_no,
                paket.status_paket as paket_status
            ')
            ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
            ->join('ppk', 'ppk.id = rup.ppk_id', 'left')
            ->join('jenis_belanja', 'jenis_belanja.id = rup.jenis_belanja_id', 'left')
            ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
            ->join('sumber_dana', 'sumber_dana.id = rup.sumber_dana_id', 'left')
            ->join('metode_pemilihan', 'metode_pemilihan.id = rup.metode_pemilihan_id', 'left')
            ->join('jenis_dak', 'jenis_dak.id = rup.jenis_dak_id', 'left')
            ->join('paket', 'paket.rup_id = rup.id', 'left');

        if ($id !== null) {
            return $builder->where('rup.id', $id)->first();
        }

        return $builder->orderBy('rup.id', 'DESC')->findAll();
    }
}
