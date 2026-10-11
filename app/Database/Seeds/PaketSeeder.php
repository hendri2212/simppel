<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PaketSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $pakets = [
            [
                'id'                  => 1,
                'rup_id'              => 1,
                'no_paket'            => '0001',
                'no_rpp'              => '000.3.1/005/BID.BM/DPUPR',
                'nilai_hps'           => 399987000.00,
                'tgl_paket'           => '2026-01-21',
                'tgl_pengajuan'       => '2026-01-22',
                'tgl_distribusi'      => '2026-01-27',
                'tgl_tayang'          => '2026-02-20',
                'status_paket'        => 14,
                'admin_ukpbj_id'      => null,
                'status_verifikasi'   => 1,
                'catatan_verifikasi'  => 'Berkas RPP dan HPS lengkap disetujui',
                'admin_distribusi_id' => null,
                'kepala_ukpbj_id'     => null,
                'nama_pemenang'       => 'PT. Prisma Jasa Konsulindo',
                'npwp'                => '0954124178731000',
                'alamat'              => 'Jl. Trans Kalimantan Km. 6 No. 58 Kel. Handil Bakti Kec. Alalak Kab. Barito Kuala',
                'nama_penanggung'     => 'Drs. SYAHRANI, MT',
                'nilai_kontrak'       => 336584412.00,
                'tgl_penetapan'       => '2026-03-30',
                'no_surat'            => '-',
                'tgl_surat'           => '2026-04-14',
                'is_lpse'             => 0,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'id'                  => 2,
                'rup_id'              => 2,
                'no_paket'            => '0002',
                'no_rpp'              => '000.3.1/006/BID.BM/DPUPR',
                'nilai_hps'           => 399987000.00,
                'tgl_paket'           => '2026-01-22',
                'tgl_pengajuan'       => '2026-01-22',
                'tgl_distribusi'      => '2026-01-27',
                'tgl_tayang'          => '2026-02-20',
                'status_paket'        => 14,
                'admin_ukpbj_id'      => null,
                'status_verifikasi'   => 1,
                'catatan_verifikasi'  => 'Berkas RPP dan HPS lengkap disetujui',
                'admin_distribusi_id' => null,
                'kepala_ukpbj_id'     => null,
                'nama_pemenang'       => 'CV. TIKA KREATIF DESAIN KONSULTAN',
                'npwp'                => '0028093185711000',
                'alamat'              => 'Jl. G. Obos XV Blok D No. 6 - Palangka Raya (Kota) - Kalimantan Tengah',
                'nama_penanggung'     => 'RAHADIAN A',
                'nilai_kontrak'       => 315731952.00,
                'tgl_penetapan'       => '2026-03-30',
                'no_surat'            => '-',
                'tgl_surat'           => '2026-04-09',
                'is_lpse'             => 0,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'id'                  => 3,
                'rup_id'              => 4,
                'no_paket'            => '0003',
                'no_rpp'              => '000.3.1/007/BID.BM/DPUPR',
                'nilai_hps'           => 299999000.00,
                'tgl_paket'           => '2026-01-22',
                'tgl_pengajuan'       => '2026-01-22',
                'tgl_distribusi'      => '2026-01-27',
                'tgl_tayang'          => '2026-02-23',
                'status_paket'        => 14,
                'admin_ukpbj_id'      => null,
                'status_verifikasi'   => 1,
                'catatan_verifikasi'  => 'Berkas RPP dan HPS lengkap disetujui',
                'admin_distribusi_id' => null,
                'kepala_ukpbj_id'     => null,
                'nama_pemenang'       => 'PT. Prisma Jaya Konsulindo',
                'npwp'                => '0954124178731000',
                'alamat'              => 'Jl. Trans Kalimantan Km.6 No.58 Kel. Handil Bakti Kec.Alalak Kab.Barito Kuala',
                'nama_penanggung'     => 'Drs. SYAHRANI, MT',
                'nilai_kontrak'       => 290069862.00,
                'tgl_penetapan'       => '2026-03-30',
                'no_surat'            => '-',
                'tgl_surat'           => '2026-04-17',
                'is_lpse'             => 0,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
        ];

        foreach ($pakets as $paket) {
            $this->db->table('paket')->upsert($paket);
        }
    }
}
