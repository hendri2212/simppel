<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketModel extends Model
{
    protected $table            = 'paket';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'rup_id',
        'no_paket',
        'no_rpp',
        'nilai_hps',
        'tgl_paket',
        'tgl_pengajuan',
        'tgl_distribusi',
        'tgl_tayang',
        'status_paket',
        'admin_ukpbj_id',
        'status_verifikasi',
        'catatan_verifikasi',
        'admin_distribusi_id',
        'kepala_ukpbj_id',
        'nama_pemenang',
        'npwp',
        'alamat',
        'nama_penanggung',
        'nilai_kontrak',
        'tgl_penetapan',
        'no_surat',
        'tgl_surat',
        'is_lpse',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get paket with relation to rup, skpd, ppk, users, and masters
     */
    public function getWithRelations(?int $id = null)
    {
        $builder = $this->select('
                paket.*,
                rup.package_name,
                rup.package_code,
                rup.activity,
                rup.location,
                rup.fiscal_year,
                rup.budget_ceiling,
                rup.volume,
                rup.account_code,
                rup.work_duration,
                skpd.name as skpd_name,
                skpd.abbreviation as skpd_abbreviation,
                ppk.name as ppk_name,
                jenis_pengadaan.name as jenis_pengadaan_name,
                metode_pemilihan.name as metode_pemilihan_name,
                sumber_dana.name as sumber_dana_name,
                admin_ukpbj.full_name as admin_ukpbj_name,
                admin_distribusi.full_name as admin_distribusi_name,
                kepala_ukpbj.full_name as kepala_ukpbj_name
            ')
            ->join('rup', 'rup.id = paket.rup_id', 'left')
            ->join('skpd', 'skpd.id = rup.skpd_id', 'left')
            ->join('ppk', 'ppk.id = rup.ppk_id', 'left')
            ->join('jenis_pengadaan', 'jenis_pengadaan.id = rup.jenis_pengadaan_id', 'left')
            ->join('metode_pemilihan', 'metode_pemilihan.id = rup.metode_pemilihan_id', 'left')
            ->join('sumber_dana', 'sumber_dana.id = rup.sumber_dana_id', 'left')
            ->join('users as admin_ukpbj', 'admin_ukpbj.id = paket.admin_ukpbj_id', 'left')
            ->join('users as admin_distribusi', 'admin_distribusi.id = paket.admin_distribusi_id', 'left')
            ->join('users as kepala_ukpbj', 'kepala_ukpbj.id = paket.kepala_ukpbj_id', 'left');

        if ($id !== null) {
            return $builder->where('paket.id', $id)->first();
        }

        return $builder->orderBy('paket.id', 'DESC')->findAll();
    }
}
