<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSyaratTable extends Migration
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
            'paket_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'Relasi ke tabel paket (id)',
            ],
            'nama_persyaratan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'comment'    => 'Nama dokumen persyaratan pengadaan',
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
                'comment'    => 'Nama file fisik yang tersimpan di sistem saat diupload',
            ],
            'hps' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1 = Rahasia (HPS), 0 = Terbuka / Biasa',
            ],
            'format' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'default'    => null,
                'comment'    => 'Ketentuan format ekstensi file yang diizinkan (cth: pdf, xls,xlsx,xlsm, atau null untuk bebas)',
            ],
            'wajib' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1 = Wajib diupload sebelum paket diajukan, 0 = Tidak Wajib',
            ],
            'auto' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1 = Syarat default otomatis dari sistem (8 syarat), 0 = Syarat tambahan manual dari PPK/Pengguna (dapat dihapus)',
            ],
            'selesai' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => 'Status kelengkapan / verifikasi syarat: 1 = Selesai, 0 = Belum',
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
        $this->forge->addKey('paket_id');
        $this->forge->addKey(['paket_id', 'wajib']);
        $this->forge->addKey(['paket_id', 'auto']);

        // Relasi foreign key ke tabel paket
        $this->forge->addForeignKey('paket_id', 'paket', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('syarat', true);
    }

    public function down()
    {
        $this->forge->dropTable('syarat', true);
    }
}
