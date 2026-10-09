<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $roles = [
            [
                'id'          => 1,
                'name'        => 'ADMINISTRATOR',
                'description' => 'Administrator dengan akses penuh sistem',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'name'        => 'ADMIN PPK',
                'description' => 'Admin Pejabat Pembuat Komitmen',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 3,
                'name'        => 'PPK',
                'description' => 'Pejabat Pembuat Komitmen',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 4,
                'name'        => 'ADMIN ULP',
                'description' => 'Admin Unit Layanan Pengadaan',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 5,
                'name'        => 'DISTRIBUSI',
                'description' => 'Tim Distribusi',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 6,
                'name'        => 'KEPALA ULP',
                'description' => 'Kepala Unit Layanan Pengadaan',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 7,
                'name'        => 'POKJA',
                'description' => 'Kelompok Kerja Pengadaan',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 8,
                'name'        => 'ADMIN AGENCY',
                'description' => 'Admin Agency',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 9,
                'name'        => 'MONEV',
                'description' => 'Monitoring dan Evaluasi',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        foreach ($roles as $role) {
            $existing = $this->db->table('roles')->where('id', $role['id'])->get()->getRow();
            if ($existing) {
                $this->db->table('roles')->where('id', $role['id'])->update($role);
            } else {
                $this->db->table('roles')->insert($role);
            }
        }
    }
}
