<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRupTable extends Migration
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
            'skpd_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID Instansi / SKPD (id_skpd)',
            ],
            'ppk_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID PPK (id_ppk)',
            ],
            'fiscal_year' => [
                'type'       => 'VARCHAR',
                'constraint' => 4,
                'comment'    => 'Tahun Anggaran',
            ],
            'activity' => [
                'type'    => 'TEXT',
                'comment' => 'Nama Kegiatan / Program',
            ],
            'package_name' => [
                'type'    => 'TEXT',
                'comment' => 'Nama Paket Pengadaan',
            ],
            'package_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'Kode Paket / Kode RUP SiRUP',
            ],
            'location' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Lokasi Pekerjaan',
            ],
            'jenis_belanja_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID Jenis Belanja (id_jbelanja)',
            ],
            'jenis_pengadaan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID Jenis Pengadaan (id_jpengadaan)',
            ],
            'volume' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Volume Pekerjaan',
            ],
            'description' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Uraian / Deskripsi Pekerjaan',
            ],
            'metode_pemilihan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'ID Metode Pemilihan (id_metode)',
            ],
            'submission_date' => [
                'type'    => 'DATE',
                'null'    => true,
                'comment' => 'Tanggal Pengajuan',
            ],
            'notes' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Keterangan Tambahan',
            ],
            'rup_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => 'Status Akses Edit RUP (1: Boleh diedit, 2: Terkunci / Tidak boleh diedit)',
            ],
            'sumber_dana_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID Sumber Dana (id_sumber)',
            ],
            'work_duration' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'comment'    => 'Waktu / Durasi Pekerjaan dalam Hari',
            ],
            'budget_ceiling' => [
                'type'       => 'DECIMAL',
                'constraint' => '17,2',
                'default'    => 0.00,
                'comment'    => 'Pagu Anggaran (Rp)',
            ],
            'account_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Mata Anggaran Kegiatan (MAK)',
            ],
            'jenis_dak_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 2,
                'comment'    => 'ID Status DAK / Non DAK (id_dak)',
            ],
            'is_synced' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => 'Status Sinkronisasi (sinkron)',
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
        $this->forge->addKey('package_code');

        // Foreign keys to referenced tables
        $this->forge->addForeignKey('skpd_id', 'skpd', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('ppk_id', 'ppk', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('jenis_belanja_id', 'jenis_belanja', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('jenis_pengadaan_id', 'jenis_pengadaan', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('sumber_dana_id', 'sumber_dana', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('metode_pemilihan_id', 'metode_pemilihan', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('jenis_dak_id', 'jenis_dak', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('rup', true);
    }

    public function down()
    {
        $this->forge->dropTable('rup', true);
    }
}
