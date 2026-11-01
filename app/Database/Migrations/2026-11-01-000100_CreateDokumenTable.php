<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenTable extends Migration
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
            'nama_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'comment'    => 'Nama dokumen lelang',
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Nama file tersimpan di writable/uploads/dokumen',
            ],
            'uploaded_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'User (Pokja) pengunggah',
            ],
            'selesai' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1 = terkunci (hasil lelang sudah dikirim), tidak bisa dihapus',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('paket_id');
        $this->forge->addForeignKey('paket_id', 'paket', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('uploaded_by', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('dokumen', true);
    }

    public function down()
    {
        $this->forge->dropTable('dokumen', true);
    }
}
