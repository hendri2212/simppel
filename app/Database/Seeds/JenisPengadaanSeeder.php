<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class JenisPengadaanSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $jenisPengadaan = [
            [
                'id'          => 1,
                'code'        => 'BARANG',
                'name'        => 'Barang',
                'description' => 'Pengadaan Barang (Goods)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'code'        => 'JASA_KONSULTASI',
                'name'        => 'Jasa Konsultasi',
                'description' => 'Pengadaan Jasa Konsultansi (Consultancy Services)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 3,
                'code'        => 'JASA_LAINNYA',
                'name'        => 'Jasa Lainnya',
                'description' => 'Pengadaan Jasa Lainnya (Other Services)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 4,
                'code'        => 'PEKERJAAN_KONSTRUKSI',
                'name'        => 'Pekerjaan Konstruksi',
                'description' => 'Pengadaan Pekerjaan Konstruksi (Construction Works)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 5,
                'code'        => 'PEKERJAAN_TERINTEGRASI',
                'name'        => 'Pekerjaan Terintegrasi',
                'description' => 'Pengadaan Pekerjaan Konstruksi Terintegrasi (Design and Build / Integrated Works)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        foreach ($jenisPengadaan as $type) {
            $existing = $this->db->table('jenis_pengadaan')
                ->where('id', $type['id'])
                ->orWhere('name', $type['name'])
                ->get()
                ->getRow();

            if ($existing) {
                $this->db->table('jenis_pengadaan')->where('id', $existing->id)->update($type);
            } else {
                $this->db->table('jenis_pengadaan')->insert($type);
            }
        }
    }
}
