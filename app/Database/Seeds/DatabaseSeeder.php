<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('SkpdSeeder');
        $this->call('PpkSeeder');
        $this->call('RoleSeeder');
        $this->call('JenisBelanjaSeeder');
        $this->call('JenisPengadaanSeeder');
        $this->call('SumberDanaSeeder');
        $this->call('MetodePemilihanSeeder');
        $this->call('JenisDakSeeder');
        $this->call('UserSeeder');
        $this->call('RupSeeder');
    }
}
