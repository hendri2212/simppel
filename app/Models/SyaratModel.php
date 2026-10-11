<?php

namespace App\Models;

use CodeIgniter\Model;

class SyaratModel extends Model
{
    protected $table            = 'syarat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'paket_id',
        'nama_persyaratan',
        'nama_file',
        'hps',
        'format',
        'wajib',
        'auto',
        'selesai',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Daftar 8 syarat bawaan (default) yang digenerate dari backend:
     * No | Nama Persyaratan                     | Sifat           | Ketentuan Format
     *  1 | HPS Format PDF                      | Wajib (Rahasia) | Harus .pdf
     *  2 | HPS Format Excel                    | Wajib (Rahasia) | .xls, .xlsx, .xlsm
     *  3 | Surat Pengantar RPP Format PDF      | Wajib           | Harus .pdf
     *  4 | Daftar Kuantitas Dan Harga - Kosong | Wajib           | Bebas
     *  5 | Kerangka Acuan Kerja Format PDF     | Wajib           | Harus .pdf
     *  6 | Ringkasan Data Paket Pekerjaan      | Tidak Wajib     | Bebas
     *  7 | Spesifikasi Teknis/RKS              | Tidak Wajib     | Bebas
     *  8 | Gambar                              | Tidak Wajib     | Bebas
     */
    public const DEFAULT_SYARAT = [
        [
            'nama_persyaratan' => 'HPS Format PDF',
            'hps'              => 1, // Rahasia
            'format'           => 'pdf',
            'wajib'            => 1, // Wajib
            'auto'             => 1,
            'selesai'          => 0,
        ],
        [
            'nama_persyaratan' => 'HPS Format Excel',
            'hps'              => 1, // Rahasia
            'format'           => 'xls,xlsx,xlsm',
            'wajib'            => 1, // Wajib
            'auto'             => 1,
            'selesai'          => 0,
        ],
        [
            'nama_persyaratan' => 'Surat Pengantar RPP Format PDF',
            'hps'              => 0,
            'format'           => 'pdf',
            'wajib'            => 1, // Wajib
            'auto'             => 1,
            'selesai'          => 0,
        ],
        [
            'nama_persyaratan' => 'Daftar Kuantitas Dan Harga - Kosongan',
            'hps'              => 0,
            'format'           => null, // Bebas
            'wajib'            => 1, // Wajib
            'auto'             => 1,
            'selesai'          => 0,
        ],
        [
            'nama_persyaratan' => 'Kerangka Acuan Kerja Format PDF',
            'hps'              => 0,
            'format'           => 'pdf',
            'wajib'            => 1, // Wajib
            'auto'             => 1,
            'selesai'          => 0,
        ],
        [
            'nama_persyaratan' => 'Ringkasan Data Paket Pekerjaan',
            'hps'              => 0,
            'format'           => null, // Bebas
            'wajib'            => 0, // Tidak Wajib
            'auto'             => 1,
            'selesai'          => 0,
        ],
        [
            'nama_persyaratan' => 'Spesifikasi Teknis/RKS',
            'hps'              => 0,
            'format'           => null, // Bebas
            'wajib'            => 0, // Tidak Wajib
            'auto'             => 1,
            'selesai'          => 0,
        ],
        [
            'nama_persyaratan' => 'Gambar',
            'hps'              => 0,
            'format'           => null, // Bebas
            'wajib'            => 0, // Tidak Wajib
            'auto'             => 1,
            'selesai'          => 0,
        ],
    ];

    /**
     * Generate 8 syarat default untuk sebuah paket jika belum ada
     */
    public function generateDefaultSyarat(int $paketId): int
    {
        $existing = $this->where('paket_id', $paketId)->where('auto', 1)->countAllResults();
        if ($existing > 0) {
            return 0; // Sudah pernah digenerate
        }

        $now   = date('Y-m-d H:i:s');
        $batch = [];
        foreach (self::DEFAULT_SYARAT as $item) {
            $batch[] = array_merge($item, [
                'paket_id'   => $paketId,
                'nama_file'  => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return $this->insertBatch($batch) ?: 0;
    }

    /**
     * Ambil semua syarat untuk paket tertentu
     */
    public function getByPaketId(int $paketId): array
    {
        return $this->where('paket_id', $paketId)
            ->orderBy('auto', 'DESC') // Syarat bawaan dulu, baru tambahan
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * Cek apakah semua syarat wajib sudah diupload
     */
    public function checkWajibLengkap(int $paketId): bool
    {
        $unuploadedWajib = $this->where('paket_id', $paketId)
            ->where('wajib', 1)
            ->groupStart()
                ->where('nama_file IS NULL')
                ->orWhere('nama_file', '')
            ->groupEnd()
            ->countAllResults();

        return $unuploadedWajib === 0;
    }
}
