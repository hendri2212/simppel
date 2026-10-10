<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class MetodePemilihanSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $metodePemilihan = [
            [
                'id'          => 1,
                'code'        => 'E_PURCHASING',
                'name'        => 'E-purchasing',
                'description' => 'E-Purchasing (Katalog Elektronik / Toko Daring)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'code'        => 'PENGADAAN_LANGSUNG',
                'name'        => 'Pengadaan Langsung',
                'description' => 'Pengadaan Langsung (Direct Procurement)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 3,
                'code'        => 'PENUNJUKAN_LANGSUNG',
                'name'        => 'Penunjukan Langsung',
                'description' => 'Penunjukan Langsung (Direct Appointment)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 4,
                'code'        => 'TENDER_CEPAT',
                'name'        => 'Tender Cepat',
                'description' => 'Tender Cepat (Fast Tender)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 5,
                'code'        => 'TENDER',
                'name'        => 'Tender',
                'description' => 'Tender (Tender Terbuka)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 6,
                'code'        => 'SELEKSI',
                'name'        => 'Seleksi',
                'description' => 'Seleksi (Jasa Konsultansi)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 7,
                'code'        => 'DIKECUALIKAN',
                'name'        => 'Dikecualikan',
                'description' => 'Pengadaan yang Dikecualikan (Exempted Procurement)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 13,
                'code'        => 'SELEKSI_KONSULTANSI',
                'name'        => 'Seleksi (Jasa Konsultansi)',
                'description' => 'Seleksi Jasa Konsultansi (ID Metode 13 dari SiRUP)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        foreach ($metodePemilihan as $method) {
            $existing = $this->db->table('metode_pemilihan')
                ->where('id', $method['id'])
                ->orWhere('name', $method['name'])
                ->get()
                ->getRow();

            if ($existing) {
                $this->db->table('metode_pemilihan')->where('id', $existing->id)->update($method);
            } else {
                $this->db->table('metode_pemilihan')->insert($method);
            }
        }
    }
}
