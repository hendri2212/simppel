<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $adminData = [
            'role_id'         => 1, // ADMINISTRATOR
            'full_name'       => 'Administrator Sistem',
            'username'        => 'admin',
            'email'           => 'admin@simpple.com',
            'password'        => password_hash('admin123', PASSWORD_BCRYPT),
            'nip'             => '198501012010011001',
            'whatsapp_number' => '081234567890',
            'is_active'       => 1,
            'created_at'      => $now,
            'updated_at'      => $now,
        ];

        $existingUser = $this->db->table('users')->where('username', 'admin')->get()->getRow();

        if ($existingUser) {
            $this->db->table('users')->where('id', $existingUser->id)->update($adminData);
        } else {
            $this->db->table('users')->insert($adminData);
        }
    }
}
