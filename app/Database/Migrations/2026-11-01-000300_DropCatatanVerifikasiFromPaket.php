<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Alasan pengembalian berkas kini disimpan di tabel `catatan`
 * (status_paket = 3), sehingga paket.catatan_verifikasi tidak diperlukan lagi.
 */
class DropCatatanVerifikasiFromPaket extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('catatan_verifikasi', 'paket')) {
            $this->forge->dropColumn('paket', 'catatan_verifikasi');
        }
    }

    public function down()
    {
        $this->forge->addColumn('paket', [
            'catatan_verifikasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'status_verifikasi',
            ],
        ]);
    }
}
