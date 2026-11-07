<?php

namespace App\Models;

use CodeIgniter\Model;

class PejabatPengadaanSkpdModel extends Model
{
    protected $table            = 'pejabat_pengadaan_skpd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'skpd_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil seluruh daftar SKPD yang diampu oleh masing-masing user (dikelompokkan per user_id).
     *
     * @return array<int, array<int, array{skpd_id: int, skpd_name: string, skpd_abbr: string}>>
     */
    public function getGroupedByUser(): array
    {
        $rows = $this->select('pejabat_pengadaan_skpd.user_id, pejabat_pengadaan_skpd.skpd_id, skpd.name AS skpd_name, skpd.abbreviation AS skpd_abbr')
            ->join('skpd', 'skpd.id = pejabat_pengadaan_skpd.skpd_id', 'inner')
            ->orderBy('skpd.name', 'ASC')
            ->findAll();

        $out = [];
        foreach ($rows as $r) {
            $uid = (int) $r['user_id'];
            $out[$uid][] = [
                'skpd_id'   => (int) $r['skpd_id'],
                'skpd_name' => (string) $r['skpd_name'],
                'skpd_abbr' => (string) ($r['skpd_abbr'] ?? ''),
            ];
        }

        return $out;
    }

    /**
     * Cari Pejabat Pengadaan (user ber-role POKJA yang aktif) untuk SKPD tertentu.
     */
    public function findPejabatBySkpd(int $skpdId): ?array
    {
        if ($skpdId <= 0) {
            return null;
        }

        return $this->select('users.id, users.full_name, users.username, users.nip, pejabat_pengadaan_skpd.skpd_id')
            ->join('users', 'users.id = pejabat_pengadaan_skpd.user_id', 'inner')
            ->join('roles', 'roles.id = users.role_id', 'inner')
            ->where('pejabat_pengadaan_skpd.skpd_id', $skpdId)
            ->where('roles.name', 'POKJA')
            ->where('users.is_active', 1)
            ->first();
    }

    /**
     * Sinkronkan daftar SKPD yang diampu oleh user Pejabat Pengadaan (role POKJA).
     * Jika ada SKPD yang sebelumnya diampu user lain, relasinya dipindahkan ke user ini.
     *
     * @param array<int> $skpdIds
     */
    public function syncForUser(int $userId, array $skpdIds): void
    {
        $db  = db_connect();
        $now = date('Y-m-d H:i:s');

        $cleanIds = array_values(array_unique(array_filter(array_map('intval', $skpdIds), static fn (int $v) => $v > 0)));

        $db->table($this->table)->where('user_id', $userId)->delete();

        if ($cleanIds === []) {
            return;
        }

        // Hapus penugasan SKPD tersebut pada user lain agar constraint UNIQUE(skpd_id) terjaga
        $db->table($this->table)->whereIn('skpd_id', $cleanIds)->delete();

        $batch = [];
        foreach ($cleanIds as $sid) {
            $batch[] = [
                'user_id'    => $userId,
                'skpd_id'    => $sid,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $db->table($this->table)->insertBatch($batch);
    }

    /**
     * Ambil data Pejabat Pengadaan aktif untuk setiap SKPD (dikelompokkan per skpd_id).
     *
     * @return array<int, array{user_id: int, full_name: string, username: string, nip: string}>
     */
    public function getGroupedBySkpd(): array
    {
        $rows = $this->select('pejabat_pengadaan_skpd.skpd_id, users.id AS user_id, users.full_name, users.username, users.nip')
            ->join('users', 'users.id = pejabat_pengadaan_skpd.user_id', 'inner')
            ->join('roles', 'roles.id = users.role_id', 'inner')
            ->where('roles.name', 'POKJA')
            ->where('users.is_active', 1)
            ->findAll();

        $out = [];
        foreach ($rows as $r) {
            $sid = (int) $r['skpd_id'];
            $out[$sid] = [
                'user_id'   => (int) $r['user_id'],
                'full_name' => (string) $r['full_name'],
                'username'  => (string) $r['username'],
                'nip'       => (string) ($r['nip'] ?? ''),
            ];
        }

        return $out;
    }

    /**
     * Tetapkan Pejabat Pengadaan untuk sebuah SKPD. Jika userId <= 0, hapus penugasan.
     */
    public function setPejabatForSkpd(int $skpdId, int $userId): void
    {
        if ($skpdId <= 0) {
            return;
        }

        $db  = db_connect();
        $now = date('Y-m-d H:i:s');

        // Hapus penugasan eksisting untuk SKPD ini
        $db->table($this->table)->where('skpd_id', $skpdId)->delete();

        if ($userId > 0) {
            $db->table($this->table)->insert([
                'user_id'    => $userId,
                'skpd_id'    => $skpdId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
