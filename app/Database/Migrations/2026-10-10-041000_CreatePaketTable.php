<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaketTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'rup_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'Relasi ke tabel rup (id)',
            ],
            'no_paket' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'default'    => null,
                'comment'    => 'Nomor Urut Paket Pengadaan (cth: 0001, kosong saat draft)',
            ],
            'no_rpp' => [
                'type'    => 'TEXT',
                'comment' => 'Nomor Rencana Pelaksanaan Pengadaan (RPP)',
            ],
            'nilai_hps' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'comment'    => 'Nilai Harga Perkiraan Sendiri (HPS)',
            ],
            'tgl_paket' => [
                'type'    => 'DATE',
                'comment' => 'Tanggal Pembuatan Paket',
            ],
            'tgl_pengajuan' => [
                'type'    => 'DATE',
                'null'    => true,
                'comment' => 'Tanggal Pengajuan Berkas RPP ke UKPBJ',
            ],
            'tgl_distribusi' => [
                'type'    => 'DATE',
                'null'    => true,
                'comment' => 'Tanggal Distribusi ke Pokja Pemilihan',
            ],
            'tgl_tayang' => [
                'type'    => 'DATE',
                'null'    => true,
                'comment' => 'Tanggal Tayang Pengumuman Tender/Seleksi',
            ],
            'status_paket' => [
                'type'       => 'INT',
                'constraint' => 2,
                'default'    => 1,
                'comment'    => 'Status Tahapan Paket (0: Batal, 1: Draft, 2: Diajukan, 3: Verifikasi, 4: Diterima, 5: Saran-Distribusi, 6: Distribusi, 7: Saran-Kaji, 8: Kaji, 9: Proses-Lelang, 10: Saran-Add, 11: Addendum, 12: Hasil, 13: Ulang, 14: Selesai, 15: Gagal)',
            ],
            'admin_ukpbj_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'ID User Admin UKPBJ / Verifikator Berkas',
            ],
            'status_verifikasi' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => 'Hasil Verifikasi Berkas (0: Belum, 1: Lengkap/Disetujui, 2: Perlu Perbaikan)',
            ],
            'catatan_verifikasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Catatan / Keterangan Verifikasi Admin UKPBJ',
            ],
            'admin_distribusi_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'ID User Petugas yang Mendistribusikan Paket',
            ],
            'kepala_ukpbj_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'ID User Kepala UKPBJ',
            ],
            'nama_pemenang' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Nama Perusahaan / Penyedia Pemenang',
            ],
            'npwp' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'NPWP Penyedia Pemenang',
            ],
            'alamat' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Alamat Penyedia Pemenang',
            ],
            'nama_penanggung' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Nama Penanggung Jawab / Direktur Penyedia',
            ],
            'nilai_kontrak' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0.00,
                'comment'    => 'Nilai Kontrak / Realisasi Pemenang',
            ],
            'tgl_penetapan' => [
                'type'    => 'DATE',
                'null'    => true,
                'comment' => 'Tanggal Penetapan Pemenang',
            ],
            'no_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'Nomor Surat Penetapan / BA Hasil Pemilihan',
            ],
            'tgl_surat' => [
                'type'    => 'DATE',
                'null'    => true,
                'comment' => 'Tanggal Surat Penetapan / BA Hasil Pemilihan',
            ],
            'is_lpse' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => 'Status Sinkronisasi / Publikasi ke LPSE (0 / 1)',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('rup_id');
        $this->forge->addUniqueKey('no_paket');

        // Foreign keys
        $this->forge->addForeignKey('rup_id', 'rup', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('admin_ukpbj_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('admin_distribusi_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('kepala_ukpbj_id', 'users', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('paket', true);
    }

    public function down()
    {
        $this->forge->dropTable('paket', true);
    }
}
