<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ProcurementPlanSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        // 3 Data pertama dari rup.sql yang dipetakan ke skema tabel procurement_plans
        $plans = [
            [
                'id'                          => 1,
                'skpd_id'                   => 16, // DPUPR
                'ppk_id'       => 5,  // Bidang Bina Marga
                'fiscal_year'                 => '2026',
                'activity'                    => 'PENYELENGGARAAN JALAN KABUPATEN/KOTA',
                'package_name'                => 'Jasa Konsultansi Pengawasan Peningkatan Struktur Ruas Jalan  Siayuh - Tanjung Sari',
                'package_code'                => '63002224',
                'location'                    => 'Kecamatan Kelumpang Barat',
                'expense_type_id'             => 2,  // Barang/Jasa
                'procurement_type_id'         => 2,  // Jasa Konsultasi
                'volume'                      => '1 Paket',
                'description'                 => 'Pengawasan Pekerjaan Siayuh - Tanjung Sari',
                'selection_method_id'         => 13, // Seleksi (Jasa Konsultansi)
                'submission_date'             => '2026-01-21',
                'notes'                       => '-',
                'rup_status'                  => 2,  // Terumumkan (SiRUP)
                'funding_source_id'           => 1,  // APBD
                'work_duration'               => 180,
                'budget_ceiling'              => 400000000.00,
                'account_code'                => '1.03.10.2.01.0059.5.2.04.01.001.00003.1.3.04.01.01.0003.00066',
                'special_allocation_type_id'  => 2,  // NON DAK
                'package_status'              => 1,  // Pengajuan
                'is_synced'                   => 0,
                'created_at'                  => $now,
                'updated_at'                  => $now,
            ],
            [
                'id'                          => 2,
                'skpd_id'                   => 16, // DPUPR
                'ppk_id'       => 5,  // Bidang Bina Marga
                'fiscal_year'                 => '2026',
                'activity'                    => 'PENYELENGGARAAN JALAN KABUPATEN/KOTA',
                'package_name'                => 'Jasa Konsultansi Pengawasan Peningkatan Struktur Ruas Jalan Tanjung Seloka - Berangas (Sejakah-Sungai Buah)',
                'package_code'                => '63002223',
                'location'                    => 'Kecamatan Pulaulaut Kepulauan',
                'expense_type_id'             => 2,  // Barang/Jasa
                'procurement_type_id'         => 2,  // Jasa Konsultasi
                'volume'                      => '1 Paket',
                'description'                 => 'Pengawasan Pekerjaan Tanjung Seloka - Berangas (Sejakah-Sungai Buah)',
                'selection_method_id'         => 13, // Seleksi (Jasa Konsultansi)
                'submission_date'             => '2026-01-21',
                'notes'                       => '-',
                'rup_status'                  => 2,  // Terumumkan (SiRUP)
                'funding_source_id'           => 1,  // APBD
                'work_duration'               => 180,
                'budget_ceiling'              => 400000000.00,
                'account_code'                => '1.03.10.2.01.0059.5.2.04.01.001.00003.1.3.04.01.01.0003.00066',
                'special_allocation_type_id'  => 2,  // NON DAK
                'package_status'              => 1,  // Pengajuan
                'is_synced'                   => 0,
                'created_at'                  => $now,
                'updated_at'                  => $now,
            ],
            [
                'id'                          => 4,
                'skpd_id'                   => 16, // DPUPR
                'ppk_id'       => 5,  // Bidang Bina Marga
                'fiscal_year'                 => '2026',
                'activity'                    => 'PENYELENGGARAAN JALAN KABUPATEN/KOTA',
                'package_name'                => 'Jasa Konsultansi Pengawasan Peningkatan Struktur Ruas Jalan Tanjung Seloka - Berangas (Tanjung Serudung-Labuan Mas)',
                'package_code'                => '63002222',
                'location'                    => 'Kecamatan Pulaulaut Selatan',
                'expense_type_id'             => 2,  // Barang/Jasa
                'procurement_type_id'         => 2,  // Jasa Konsultasi
                'volume'                      => '1 Paket',
                'description'                 => 'Pengawasan Pekerjaan  Tanjung Seloka - Berangas (Tanjung Serudung-Labuan Mas)',
                'selection_method_id'         => 13, // Seleksi (Jasa Konsultansi)
                'submission_date'             => '2026-01-22',
                'notes'                       => '-',
                'rup_status'                  => 2,  // Terumumkan (SiRUP)
                'funding_source_id'           => 1,  // APBD
                'work_duration'               => 180,
                'budget_ceiling'              => 300000000.00,
                'account_code'                => '1.03.10.2.01.0059.5.2.04.01.001.00003.1.3.04.01.01.0003.00064',
                'special_allocation_type_id'  => 2,  // NON DAK
                'package_status'              => 1,  // Pengajuan
                'is_synced'                   => 0,
                'created_at'                  => $now,
                'updated_at'                  => $now,
            ],
        ];

        // Kosongkan tabel procurement_plans terlebih dahulu agar bersih hanya 3 data dari rup.sql
        $this->db->table('procurement_plans')->emptyTable();

        // Masukkan 3 data dari rup.sql
        foreach ($plans as $plan) {
            $this->db->table('procurement_plans')->insert($plan);
        }
    }
}
