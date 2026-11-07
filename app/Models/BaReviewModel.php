<?php

namespace App\Models;

use CodeIgniter\Model;

class BaReviewModel extends Model
{
    protected $table            = 'ba_review';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'paket_id',
        'putaran',
        'nomor_ba',
        'tgl_ba',
        'hasil_pemeriksaan',
        'catatan_perbaikan',
        'perlu_perbaikan',
        'reviewer_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil seluruh riwayat Berita Acara Review untuk suatu paket secara berurutan.
     */
    public function getByPaketId(int $paketId): array
    {
        return $this->select('ba_review.*, users.full_name AS reviewer_name, users.nip AS reviewer_nip, roles.name AS reviewer_role')
            ->join('users', 'users.id = ba_review.reviewer_id', 'left')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('ba_review.paket_id', $paketId)
            ->orderBy('ba_review.putaran', 'ASC')
            ->orderBy('ba_review.id', 'ASC')
            ->findAll();
    }

    /**
     * Ambil BA Review putaran terakhir pada paket.
     */
    public function getLatestByPaketId(int $paketId): ?array
    {
        return $this->where('paket_id', $paketId)
            ->orderBy('putaran', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();
    }
}
