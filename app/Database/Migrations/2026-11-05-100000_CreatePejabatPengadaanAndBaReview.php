<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePejabatPengadaanAndBaReview extends Migration
{
    public function up()
    {
        // 1. Tabel pivot `pejabat_pengadaan_skpd`: relasi 1 User (role POKJA) -> banyak SKPD
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'User ber-role POKJA yang bertindak sebagai Pejabat Pengadaan',
            ],
            'skpd_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'SKPD yang diampu oleh Pejabat Pengadaan tersebut',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addUniqueKey('skpd_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('skpd_id', 'skpd', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pejabat_pengadaan_skpd', true);

        // 2. Tabel `ba_review`: Berita Acara Review per putaran oleh Pokja Pemilihan / Pejabat Pengadaan
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
            'putaran' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 1,
                'comment'    => 'Putaran review ke-1, 2, dst.',
            ],
            'nomor_ba' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'comment'    => 'Nomor Berita Acara Review',
            ],
            'tgl_ba' => [
                'type'    => 'DATE',
                'null'    => true,
                'comment' => 'Tanggal Berita Acara Review',
            ],
            'hasil_pemeriksaan' => [
                'type'    => 'TEXT',
                'comment' => 'Hasil pemeriksaan dokumen pemilihan/pengadaan',
            ],
            'catatan_perbaikan' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'Catatan perbaikan untuk PPK (jika perlu perbaikan)',
            ],
            'perlu_perbaikan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1 = Perlu Perbaikan (kembali ke PPK), 0 = Tidak Perlu Perbaikan / Sesuai',
            ],
            'reviewer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'User (Pokja / Pejabat Pengadaan) penyusun BA Review',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['paket_id', 'putaran']);
        $this->forge->addForeignKey('paket_id', 'paket', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reviewer_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('ba_review', true);

        // 3. Kolom tambahan pada tabel `paket` untuk SK Pokja & Penolakan/Pembatalan PPK
        $fields = [];
        if (! $this->db->fieldExists('no_sk_pokja', 'paket')) {
            $fields['no_sk_pokja'] = [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'kepala_ukpbj_id',
                'comment'    => 'Nomor SK Pokja yang diterbitkan Kepala UKPBJ',
            ];
        }
        if (! $this->db->fieldExists('tgl_sk_pokja', 'paket')) {
            $fields['tgl_sk_pokja'] = [
                'type'    => 'DATE',
                'null'    => true,
                'after'   => 'no_sk_pokja',
                'comment' => 'Tanggal SK Pokja',
            ];
        }
        if (! $this->db->fieldExists('alasan_penolakan', 'paket')) {
            $fields['alasan_penolakan'] = [
                'type'    => 'TEXT',
                'null'    => true,
                'after'   => 'is_lpse',
                'comment' => 'Alasan resmi penolakan / pembatalan hasil pemilihan oleh PPK',
            ];
        }
        if (! $this->db->fieldExists('surat_penolakan', 'paket')) {
            $fields['surat_penolakan'] = [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'alasan_penolakan',
                'comment'    => 'File surat resmi penolakan / pembatalan dari PPK',
            ];
        }
        if ($fields !== []) {
            $this->forge->addColumn('paket', $fields);
        }
    }

    public function down()
    {
        foreach (['surat_penolakan', 'alasan_penolakan', 'tgl_sk_pokja', 'no_sk_pokja'] as $col) {
            if ($this->db->fieldExists($col, 'paket')) {
                $this->forge->dropColumn('paket', $col);
            }
        }
        $this->forge->dropTable('ba_review', true);
        $this->forge->dropTable('pejabat_pengadaan_skpd', true);
    }
}
