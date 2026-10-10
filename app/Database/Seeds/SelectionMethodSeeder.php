<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SelectionMethodSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $selectionMethods = [
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
        ];

        foreach ($selectionMethods as $method) {
            $existing = $this->db->table('selection_methods')
                ->where('id', $method['id'])
                ->orWhere('name', $method['name'])
                ->get()
                ->getRow();

            if ($existing) {
                $this->db->table('selection_methods')->where('id', $existing->id)->update($method);
            } else {
                $this->db->table('selection_methods')->insert($method);
            }
        }
    }
}
