<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCatatanTable extends Migration
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
                'comment'    => 'Pembuat catatan',
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'Role pembuat saat catatan dibuat (snapshot)',
            ],
            'status_paket' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'unsigned'   => true,
                'comment'    => 'Status paket saat catatan dibuat (pengganti id_proses)',
            ],
            'isi_catatan' => [
                'type' => 'TEXT',
            ],
            'isi_jawaban' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'jawab_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Penjawab catatan',
            ],
            'jawab_role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['paket_id', 'status_paket']);
        $this->forge->addForeignKey('paket_id', 'paket', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jawab_user_id', 'users', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('catatan', true);
    }

    public function down()
    {
        $this->forge->dropTable('catatan', true);
    }
}
