<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaketPokjaTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'Relasi ke tabel users (id) untuk anggota pokja',
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Anggota',
                'comment'    => 'Peran dalam Pokja (Ketua, Sekretaris, Anggota)',
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
        $this->forge->addKey(['paket_id', 'user_id']);

        // Foreign keys
        $this->forge->addForeignKey('paket_id', 'paket', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('paket_pokja', true);
    }

    public function down()
    {
        $this->forge->dropTable('paket_pokja', true);
    }
}
