<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProcurementPlansTable extends Migration
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
            'agency_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID Instansi / SKPD (id_skpd)',
            ],
            'commitment_officer_id' => [
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
            'expense_type_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID Jenis Belanja (id_jbelanja)',
            ],
            'procurement_type_id' => [
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
            'selection_method_id' => [
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
                'comment'    => 'Status RUP',
            ],
            'funding_source_id' => [
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
            'special_allocation_type_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 2,
                'comment'    => 'ID Status DAK / Non DAK (id_dak)',
            ],
            'package_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => 'Status Paket (status_paket2)',
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
        $this->forge->addForeignKey('agency_id', 'agencies', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('commitment_officer_id', 'commitment_officers', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('expense_type_id', 'expense_types', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('procurement_type_id', 'procurement_types', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('funding_source_id', 'funding_sources', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('selection_method_id', 'selection_methods', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('special_allocation_type_id', 'special_allocation_types', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('procurement_plans', true);
    }

    public function down()
    {
        $this->forge->dropTable('procurement_plans', true);
    }
}
