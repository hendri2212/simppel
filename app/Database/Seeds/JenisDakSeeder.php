<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class JenisDakSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $types = [
            [
                'id'          => 1,
                'code'        => 'DAK',
                'name'        => 'DAK',
                'description' => 'Dana Alokasi Khusus (Special Allocation Fund)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'code'        => 'NON_DAK',
                'name'        => 'NON DAK',
                'description' => 'Non Dana Alokasi Khusus (General / Regular Fund)',
                'is_active'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        foreach ($types as $type) {
            $existing = $this->db->table('jenis_dak')
                ->where('id', $type['id'])
                ->orWhere('name', $type['name'])
                ->get()
                ->getRow();

            if ($existing) {
                $this->db->table('jenis_dak')->where('id', $existing->id)->update($type);
            } else {
                $this->db->table('jenis_dak')->insert($type);
            }
        }
    }
}
