<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('AgencySeeder');
        $this->call('PpkSeeder');
        $this->call('RoleSeeder');
        $this->call('ExpenseTypeSeeder');
        $this->call('ProcurementTypeSeeder');
        $this->call('FundingSourceSeeder');
        $this->call('SelectionMethodSeeder');
        $this->call('SpecialAllocationTypeSeeder');
        $this->call('UserSeeder');
        $this->call('ProcurementPlanSeeder');
    }
}
