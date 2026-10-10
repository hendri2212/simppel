<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SumberDanaSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $sumberDana = [
            [
                'id'          => 1,
                'code'        => 'APBD',
                'name'        => 'APBD',
                'description' => 'Anggaran Pendapatan dan Belanja Daerah',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'code'        => 'APBDP',
                'name'        => 'APBDP',
                'description' => 'Anggaran Pendapatan dan Belanja Daerah Perubahan',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 3,
                'code'        => 'APBN',
                'name'        => 'APBN',
                'description' => 'Anggaran Pendapatan dan Belanja Negara',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 4,
                'code'        => 'APBNP',
                'name'        => 'APBNP',
                'description' => 'Anggaran Pendapatan dan Belanja Negara Perubahan',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 5,
                'code'        => 'BLUD',
                'name'        => 'BLUD',
                'description' => 'Badan Layanan Umum Daerah',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 6,
                'code'        => 'BUMN',
                'name'        => 'BUMN',
                'description' => 'Badan Usaha Milik Negara',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 7,
                'code'        => 'BUMD',
                'name'        => 'BUMD',
                'description' => 'Badan Usaha Milik Daerah',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 8,
                'code'        => 'PHLN',
                'name'        => 'PHLN',
                'description' => 'Pinjaman / Hibah Luar Negeri',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 9,
                'code'        => 'PNBP',
                'name'        => 'PNBP',
                'description' => 'Penerimaan Negara Bukan Pajak',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 10,
                'code'        => 'BLU',
                'name'        => 'BLU',
                'description' => 'Badan Layanan Umum',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 11,
                'code'        => 'LAINNYA',
                'name'        => 'Lain nya',
                'description' => 'Sumber Dana Lain-lain / Lainnya',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        foreach ($sumberDana as $source) {
            $existing = $this->db->table('sumber_dana')
                ->where('id', $source['id'])
                ->orWhere('name', $source['name'])
                ->get()
                ->getRow();

            if ($existing) {
                $this->db->table('sumber_dana')->where('id', $existing->id)->update($source);
            } else {
                $this->db->table('sumber_dana')->insert($source);
            }
        }
    }
}
