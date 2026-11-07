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
        'no_sk_pokja',
        'tgl_sk_pokja',
        'alasan_penolakan',
        'surat_penolakan',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Definisi resmi 16 Tahapan Status Paket Pengadaan (0 - 15)
     */
    public const STATUS_PAKET = [
        0  => [
            'name'  => 'Batal',
            'desc'  => 'Paket pengadaan dibatalkan',
            'badge' => 'bg-danger text-white',
        ],
        1  => [
            'name'  => 'Draft',
            'desc'  => 'Draf paket dibuat oleh PPK (belum diajukan ke ULP)',
            'badge' => 'bg-secondary text-white',
        ],
        2  => [
            'name'  => 'Diajukan',
            'desc'  => 'PPK telah mengajukan paket ke Admin ULP (menunggu verifikasi berkas)',
            'badge' => 'bg-warning text-dark',
        ],
        3  => [
            'name'  => 'Verifikasi',
            'desc'  => 'Berkas dikembalikan oleh Admin ULP ke PPK untuk dilengkapi/diperbaiki',
            'badge' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
        ],
        4  => [
            'name'  => 'Diterima',
            'desc'  => 'Berkas lolos verifikasi dan diterima oleh Admin ULP',
            'badge' => 'bg-info text-white',
        ],
        5  => [
            'name'  => 'Saran-Distribusi',
            'desc'  => 'Kepala ULP memproses telaah/saran pembentukan Pokja Pemilihan',
            'badge' => 'bg-info-subtle text-info-emphasis border border-info-subtle',
        ],
        6  => [
            'name'  => 'Distribusi',
            'desc'  => 'Admin Distribusi menetapkan dan mendistribusikan paket ke personil Pokja',
            'badge' => 'bg-primary-subtle text-primary-emphasis border border-primary-subtle',
        ],
        7  => [
            'name'  => 'Saran-Kaji',
            'desc'  => 'Pokja mengembalikan dokumen kaji ulang ke PPK dengan catatan saran',
            'badge' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
        ],
        8  => [
            'name'  => 'Kaji',
            'desc'  => 'Pokja dan PPK memproses kaji ulang dokumen persiapan pengadaan',
            'badge' => 'bg-info text-white',
        ],
        9  => [
            'name'  => 'Proses-Lelang',
            'desc'  => 'Paket sedang ditayangkan/ditenderkan di portal LPSE',
            'badge' => 'bg-primary text-white',
        ],
        10 => [
            'name'  => 'Saran-Add',
            'desc'  => 'Ada telaah/saran adendum',
            'badge' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
        ],
        11 => [
            'name'  => 'Addendum',
            'desc'  => 'Proses adendum berjalan',
            'badge' => 'bg-warning text-dark',
        ],
        12 => [
            'name'  => 'Hasil',
            'desc'  => 'Proses lelang selesai, penetapan pemenang diinput ke sistem',
            'badge' => 'bg-success-subtle text-success-emphasis border border-success-subtle',
        ],
        13 => [
            'name'  => 'Ulang',
            'desc'  => 'Tender dinyatakan gagal dan dilakukan lelang ulang',
            'badge' => 'bg-danger-subtle text-danger border border-danger-subtle',
        ],
        14 => [
            'name'  => 'Selesai',
            'desc'  => 'Proses pengadaan selesai (kontrak/SPK dan penanggung jawab telah diinput)',
            'badge' => 'bg-success text-white',
        ],
        15 => [
            'name'  => 'Gagal',
            'desc'  => 'Pengadaan dinyatakan gagal',
            'badge' => 'bg-danger text-white',
        ],
        16 => [
            'name'  => 'Hasil-Verifikator',
            'desc'  => 'Pokja/Pejabat Pengadaan menyerahkan hasil pemilihan dan BA Review ke Verifikator (Admin ULP)',
            'badge' => 'bg-info-subtle text-info-emphasis border border-info-subtle',
        ],
        17 => [
            'name'  => 'Hasil-Kepala',
            'desc'  => 'Verifikator mengunggah hasil pemilihan dan mengirim ke Kepala UKPBJ untuk diteruskan ke PPK',
            'badge' => 'bg-primary-subtle text-primary-emphasis border border-primary-subtle',
        ],
    ];

    /**
     * Dapatkan detail info status paket berdasarkan kode integer
     */
    public static function getStatusInfo(int $status): array
    {
        return self::STATUS_PAKET[$status] ?? [
            'name'  => 'Tahap ' . $status,
            'desc'  => 'Tahapan proses paket status ' . $status,
            'badge' => 'bg-secondary text-white',
        ];
    }

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
                metode_pemilihan.code as metode_pemilihan_code,
                rup.metode_pemilihan_id as metode_pemilihan_id,
                rup.skpd_id as skpd_id,
                rup.ppk_id as ppk_id,
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
