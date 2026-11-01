<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RupSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        // 4 Data RUP (ID 1-3 sudah masuk ke Paket, ID 4 belum masuk ke Paket / rup_status = 1)
        $plans = [
            [
                'id'                  => 1,
                'skpd_id'             => 16, // DPUPR
                'ppk_id'              => 5,  // Bidang Bina Marga
                'fiscal_year'         => '2026',
                'activity'            => 'PENYELENGGARAAN JALAN KABUPATEN/KOTA',
                'package_name'        => 'Jasa Konsultansi Pengawasan Peningkatan Struktur Ruas Jalan  Siayuh - Tanjung Sari',
                'package_code'        => '63002224',
                'location'            => 'Kecamatan Kelumpang Barat',
                'jenis_belanja_id'    => 2,  // Barang/Jasa
                'jenis_pengadaan_id'  => 2,  // Jasa Konsultasi
                'volume'              => '1 Paket',
                'description'         => 'Pengawasan Pekerjaan Siayuh - Tanjung Sari',
                'metode_pemilihan_id' => 13, // Seleksi (Jasa Konsultansi)
                'submission_date'     => '2026-01-21',
                'notes'               => '-',
                'rup_status'          => 2,  // Terkunci (Sudah masuk ke Paket 0001)
                'sumber_dana_id'      => 1,  // APBD
                'work_duration'       => 180,
                'budget_ceiling'      => 400000000.00,
                'account_code'        => '1.03.10.2.01.0059.5.2.04.01.001.00003.1.3.04.01.01.0003.00066',
                'jenis_dak_id'        => 2,  // NON DAK
                'is_synced'           => 0,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'id'                  => 2,
                'skpd_id'             => 16, // DPUPR
                'ppk_id'              => 5,  // Bidang Bina Marga
                'fiscal_year'         => '2026',
                'activity'            => 'PENYELENGGARAAN JALAN KABUPATEN/KOTA',
                'package_name'        => 'Jasa Konsultansi Pengawasan Peningkatan Struktur Ruas Jalan Tanjung Seloka - Berangas (Sejakah-Sungai Buah)',
                'package_code'        => '63002223',
                'location'            => 'Kecamatan Pulaulaut Kepulauan',
                'jenis_belanja_id'    => 2,  // Barang/Jasa
                'jenis_pengadaan_id'  => 2,  // Jasa Konsultasi
                'volume'              => '1 Paket',
                'description'         => 'Pengawasan Pekerjaan Tanjung Seloka - Berangas (Sejakah-Sungai Buah)',
                'metode_pemilihan_id' => 13, // Seleksi (Jasa Konsultansi)
                'submission_date'     => '2026-01-21',
                'notes'               => '-',
                'rup_status'          => 2,  // Terkunci (Sudah masuk ke Paket 0002)
                'sumber_dana_id'      => 1,  // APBD
                'work_duration'       => 180,
                'budget_ceiling'      => 400000000.00,
                'account_code'        => '1.03.10.2.01.0059.5.2.04.01.001.00003.1.3.04.01.01.0003.00066',
                'jenis_dak_id'        => 2,  // NON DAK
                'is_synced'           => 0,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'id'                  => 3,
                'skpd_id'             => 16, // DPUPR
                'ppk_id'              => 3,  // Bidang Bina Marga
                'fiscal_year'         => '2026',
                'activity'            => 'PENYELENGGARAAN JALAN KABUPATEN/KOTA',
                'package_name'        => 'Jasa Konsultansi Pengawasan Peningkatan Struktur Ruas Jalan Tanjung Seloka - Berangas (Tanjung Serudung-Labuan Mas)',
                'package_code'        => '63002222',
                'location'            => 'Kecamatan Pulaulaut Selatan',
                'jenis_belanja_id'    => 2,  // Barang/Jasa
                'jenis_pengadaan_id'  => 2,  // Jasa Konsultasi
                'volume'              => '1 Paket',
                'description'         => 'Pengawasan Pekerjaan Tanjung Seloka - Berangas (Tanjung Serudung-Labuan Mas)',
                'metode_pemilihan_id' => 13, // Seleksi (Jasa Konsultansi)
                'submission_date'     => '2026-01-22',
                'notes'               => '-',
                'rup_status'          => 2,  // Terkunci (Sudah masuk ke Paket 0003)
                'sumber_dana_id'      => 1,  // APBD
                'work_duration'       => 180,
                'budget_ceiling'      => 300000000.00,
                'account_code'        => '1.03.10.2.01.0059.5.2.04.01.001.00003.1.3.04.01.01.0003.00064',
                'jenis_dak_id'        => 2,  // NON DAK
                'is_synced'           => 0,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'id'                  => 4,
                'skpd_id'             => 16, // DPUPR
                'ppk_id'              => 3,  // Bidang Bina Marga
                'fiscal_year'         => '2026',
                'activity'            => 'REHABILITASI JALAN DAN JEMBATAN KABUPATEN',
                'package_name'        => 'Peningkatan Struktur Ruas Jalan Cantung - Batulicin Km. 10',
                'package_code'        => '63002225',
                'location'            => 'Kecamatan Kelumpang Hulu',
                'jenis_belanja_id'    => 3,  // Modal
                'jenis_pengadaan_id'  => 1,  // Pekerjaan Konstruksi
                'volume'              => '1 Paket (3.5 Km)',
                'description'         => 'Pekerjaan overlay aspal dan drainase ruas jalan Cantung - Batulicin',
                'metode_pemilihan_id' => 5,  // Tender
                'submission_date'     => '2026-02-05',
                'notes'               => 'Siap diproses pengadaannya',
                'rup_status'          => 1,  // Bisa Diedit (Belum masuk ke Paket)
                'sumber_dana_id'      => 1,  // APBD
                'work_duration'       => 150,
                'budget_ceiling'      => 1250000000.00,
                'account_code'        => '1.03.10.2.01.0059.5.2.04.01.001.00003.1.3.04.01.01.0003.00070',
                'jenis_dak_id'        => 1,  // DAK
                'is_synced'           => 1,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
        ];

        $seededIds    = array_column($plans, 'id');
        $usedByPaket  = $this->db->table('paket')->select('rup_id')->get()->getResultArray();
        $protectedIds = array_unique(array_merge($seededIds, array_map('intval', array_column($usedByPaket, 'rup_id'))));

        if (! empty($protectedIds)) {
            $this->db->table('rup')->whereNotIn('id', $protectedIds)->delete();
        }

        foreach ($plans as $plan) {
            $this->db->table('rup')->upsert($plan);
        }
    }
}
