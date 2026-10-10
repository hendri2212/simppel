<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCommitmentOfficerIdToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'commitment_officer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'agency_id',
                'comment'    => 'ID Pejabat Pembuat Komitmen / Bidang (commitment_officers)',
            ],
        ]);

        $this->db->query('ALTER TABLE `users` ADD CONSTRAINT `fk_users_commitment_officer_id` FOREIGN KEY (`commitment_officer_id`) REFERENCES `commitment_officers`(`id`) ON UPDATE CASCADE ON DELETE SET NULL');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `users` DROP FOREIGN KEY `fk_users_commitment_officer_id`');
        $this->forge->dropColumn('users', 'commitment_officer_id');
    }
}
