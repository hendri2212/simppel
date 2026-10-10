<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class JenisBelanjaSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $jenisBelanja = [
            [
                'id'          => 1,
                'code'        => 'MODAL',
                'name'        => 'Modal',
                'description' => 'Belanja Modal / Moda (Capital Expenditure)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'code'        => 'BARANG_JASA',
                'name'        => 'Barang/Jasa',
                'description' => 'Belanja Barang dan Jasa (Goods and Services Expenditure)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 3,
                'code'        => 'BUNGA_UTANG',
                'name'        => 'Belanja Bunga Utang',
                'description' => 'Belanja Bunga Utang (Debt Interest Expenditure)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 4,
                'code'        => 'SUBSIDI',
                'name'        => 'Belanja Subsidi',
                'description' => 'Belanja Subsidi (Subsidy Expenditure)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 5,
                'code'        => 'HIBAH',
                'name'        => 'Belanja Hibah',
                'description' => 'Belanja Hibah (Grant Expenditure)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 6,
                'code'        => 'BANSOS',
                'name'        => 'Belanja Bantuan Sosial',
                'description' => 'Belanja Bantuan Sosial (Social Assistance Expenditure)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 7,
                'code'        => 'BELUM_TERIDENTIFIKASI',
                'name'        => 'Belum Teridentifikasi',
                'description' => 'Belum Teridentifikasi (Unidentified Expenditure)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 8,
                'code'        => 'LAIN_LAIN',
                'name'        => 'Belanja Lain-lain',
                'description' => 'Belanja Lain-lain (Miscellaneous/Other Expenditure)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        foreach ($jenisBelanja as $type) {
            $existing = $this->db->table('jenis_belanja')
                ->where('id', $type['id'])
                ->orWhere('name', $type['name'])
                ->get()
                ->getRow();

            if ($existing) {
                $this->db->table('jenis_belanja')->where('id', $existing->id)->update($type);
            } else {
                $this->db->table('jenis_belanja')->insert($type);
            }
        }
    }
}
