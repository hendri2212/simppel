<?php

namespace App\Controllers;

use App\Models\PpkModel;
use App\Models\SkpdModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Manajemen SKPD dan Relasi PPK / Bidang.
 *
 * Akses dibatasi ke ADMINISTRATOR melalui filter route (lihat Config/Routes.php);
 * seluruh route mutasi juga dilindungi filter CSRF.
 */
class SkpdPpkController extends BaseController
{
    protected SkpdModel $skpdModel;
    protected PpkModel $ppkModel;

    public function __construct()
    {
        $this->skpdModel = new SkpdModel();
        $this->ppkModel  = new PpkModel();
    }

    /**
     * Tampilkan halaman Manajemen SKPD & PPK (Bidang)
     */
    public function index()
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $skpdList = [];
        $allPpk   = [];

        try {
            $db = db_connect();

            // Ambil semua SKPD
            $rawSkpd = $this->skpdModel->orderBy('name', 'ASC')->findAll();

            // Ambil semua PPK / Bidang
            $rawPpk = $this->ppkModel->orderBy('name', 'ASC')->findAll();

            // Hitung jumlah user per SKPD dan per PPK
            $userBySkpd = [];
            $userByPpk  = [];
            $userRows   = $db->table('users')
                ->select('skpd_id, ppk_id, COUNT(*) AS total')
                ->where('skpd_id IS NOT NULL')
                ->groupBy('skpd_id, ppk_id')
                ->get()->getResultArray();

            foreach ($userRows as $r) {
                $sid = (int) $r['skpd_id'];
                $pid = (int) ($r['ppk_id'] ?? 0);
                $cnt = (int) $r['total'];
                $userBySkpd[$sid] = ($userBySkpd[$sid] ?? 0) + $cnt;
                if ($pid > 0) {
                    $userByPpk[$pid] = ($userByPpk[$pid] ?? 0) + $cnt;
                }
            }

            // Hitung jumlah RUP per SKPD dan per PPK
            $rupBySkpd = [];
            $rupByPpk  = [];
            $rupRows   = $db->table('rup')
                ->select('skpd_id, ppk_id, COUNT(*) AS total')
                ->groupBy('skpd_id, ppk_id')
                ->get()->getResultArray();

            foreach ($rupRows as $r) {
                $sid = (int) $r['skpd_id'];
                $pid = (int) ($r['ppk_id'] ?? 0);
                $cnt = (int) $r['total'];
                $rupBySkpd[$sid] = ($rupBySkpd[$sid] ?? 0) + $cnt;
                if ($pid > 0) {
                    $rupByPpk[$pid] = ($rupByPpk[$pid] ?? 0) + $cnt;
                }
            }

            // Kelompokkan PPK berdasarkan skpd_id
            $ppkBySkpd = [];
            foreach ($rawPpk as $p) {
                $pid  = (int) $p['id'];
                $sid  = (int) $p['skpd_id'];
                $item = [
                    'id'         => $pid,
                    'skpd_id'    => $sid,
                    'name'       => $p['name'],
                    'is_active'  => (int) ($p['is_active'] ?? 1) === 1 ? 1 : 0,
                    'user_count' => $userByPpk[$pid] ?? 0,
                    'rup_count'  => $rupByPpk[$pid] ?? 0,
                ];
                $ppkBySkpd[$sid][] = $item;
                $allPpk[]          = $item;
            }

            foreach ($rawSkpd as $s) {
                $sid      = (int) $s['id'];
                $isActive = (int) ($s['is_active'] ?? 1) === 1;
                $ppks     = $ppkBySkpd[$sid] ?? [];

                $skpdList[] = [
                    'id'           => $sid,
                    'name'         => $s['name'],
                    'abbreviation' => $s['abbreviation'] ?: '-',
                    'raw_abbr'     => $s['abbreviation'] ?: '',
                    'code'         => $s['code'] ?: '-',
                    'raw_code'     => $s['code'] ?: '',
                    'address'      => $s['address'] ?: '-',
                    'raw_address'  => $s['address'] ?: '',
                    'contact'      => $s['contact'] ?: '-',
                    'raw_contact'  => $s['contact'] ?: '',
                    'work_unit_id' => (int) ($s['work_unit_id'] ?? 0),
                    'is_active'    => $isActive ? 1 : 0,
                    'status'       => $isActive ? 'Active' : 'Inactive',
                    'status_badge' => $isActive ? 'bg-success' : 'bg-secondary',
                    'ppk_list'     => $ppks,
                    'ppk_count'    => count($ppks),
                    'has_ppk'      => count($ppks) > 0,
                    'user_count'   => $userBySkpd[$sid] ?? 0,
                    'rup_count'    => $rupBySkpd[$sid] ?? 0,
                ];
            }
        } catch (\Throwable $e) {
            log_message('error', 'Error in SkpdPpkController::index: ' . $e->getMessage());
            $skpdList = $allPpk = [];
        }

        // Statistik ringkas
        $totalSkpd      = count($skpdList);
        $activeSkpd     = 0;
        $skpdWithPpk    = 0;
        $skpdWithoutPpk = 0;

        foreach ($skpdList as $s) {
            $activeSkpd += $s['is_active'];
            if ($s['has_ppk']) {
                $skpdWithPpk++;
            } else {
                $skpdWithoutPpk++;
            }
        }

        $totalPpk  = count($allPpk);
        $activePpk = count(array_filter($allPpk, static fn($p) => $p['is_active'] === 1));

        return view('skpd_ppk', [
            'pageTitle'      => 'SKPD & PPK',
            'skpdList'       => $skpdList,
            'allPpk'         => $allPpk,
            'totalSkpd'      => $totalSkpd,
            'activeSkpd'     => $activeSkpd,
            'skpdWithPpk'    => $skpdWithPpk,
            'skpdWithoutPpk' => $skpdWithoutPpk,
            'totalPpk'       => $totalPpk,
            'activePpk'      => $activePpk,
        ]);
    }

    /**
     * Tambah SKPD baru (beserta opsional Bidang/PPK awal)
     */
    public function storeSkpd()
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $post = $this->request;
        $data = [
            'name'         => trim((string) $post->getPost('name')),
            'abbreviation' => trim((string) $post->getPost('abbreviation')),
            'code'         => trim((string) $post->getPost('code')) ?: '0',
            'address'      => trim((string) $post->getPost('address')) ?: null,
            'contact'      => trim((string) $post->getPost('contact')) ?: null,
            'work_unit_id' => (int) ($post->getPost('work_unit_id') ?: 0),
            'is_active'    => (string) $post->getPost('is_active') === '0' ? 0 : 1,
        ];

        $rules = [
            'name'         => 'required|min_length[3]|max_length[255]',
            'abbreviation' => 'required|min_length[2]|max_length[50]',
            'code'         => 'permit_empty|max_length[50]',
            'address'      => 'permit_empty|max_length[255]',
            'contact'      => 'permit_empty|max_length[100]',
            'is_active'    => 'in_list[0,1]',
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->fail(implode(' ', $this->validator->getErrors()), 422);
        }

        $initialPpkName = trim((string) $post->getPost('initial_ppk_name'));

        $db = db_connect();

        try {
            $db->transBegin();

            $skpdId = (int) $this->skpdModel->insert($data);
            if (! $skpdId) {
                $db->transRollback();
                return $this->fail('Gagal menyimpan data SKPD.', 500);
            }

            if ($initialPpkName !== '') {
                $this->ppkModel->insert([
                    'skpd_id'   => $skpdId,
                    'name'      => $initialPpkName,
                    'is_active' => 1,
                ]);
            }

            $db->transCommit();

            return $this->done('Data SKPD baru berhasil ditambahkan!', ['id' => $skpdId]);
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Error storeSkpd: ' . $e->getMessage());

            return $this->fail('Gagal menambahkan SKPD. Silakan coba lagi.', 500);
        }
    }

    /**
     * Perbarui data SKPD
     */
    public function updateSkpd($id = null)
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $id = $id ? (int) $id : (int) $this->request->getPost('id');
        if ($id <= 0 || ! $this->skpdModel->find($id)) {
            return $this->fail('Data SKPD tidak ditemukan.', 404);
        }

        $post = $this->request;
        $data = [
            'name'         => trim((string) $post->getPost('name')),
            'abbreviation' => trim((string) $post->getPost('abbreviation')),
            'code'         => trim((string) $post->getPost('code')) ?: '0',
            'address'      => trim((string) $post->getPost('address')) ?: null,
            'contact'      => trim((string) $post->getPost('contact')) ?: null,
            'work_unit_id' => (int) ($post->getPost('work_unit_id') ?: 0),
            'is_active'    => (string) $post->getPost('is_active') === '0' ? 0 : 1,
        ];

        $rules = [
            'name'         => 'required|min_length[3]|max_length[255]',
            'abbreviation' => 'required|min_length[2]|max_length[50]',
            'code'         => 'permit_empty|max_length[50]',
            'address'      => 'permit_empty|max_length[255]',
            'contact'      => 'permit_empty|max_length[100]',
            'is_active'    => 'in_list[0,1]',
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->fail(implode(' ', $this->validator->getErrors()), 422);
        }

        try {
            $this->skpdModel->update($id, $data);

            return $this->done('Data SKPD berhasil diperbarui!');
        } catch (\Throwable $e) {
            log_message('error', 'Error updateSkpd: ' . $e->getMessage());

            return $this->fail('Gagal memperbarui data SKPD. Silakan coba lagi.', 500);
        }
    }

    /**
     * Hapus SKPD (hanya jika belum memiliki relasi PPK, User, atau RUP)
     */
    public function deleteSkpd($id = null)
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $id = $id ? (int) $id : (int) $this->request->getPost('id');
        if ($id <= 0 || ! $this->skpdModel->find($id)) {
            return $this->fail('Data SKPD tidak ditemukan.', 404);
        }

        $db = db_connect();
        $ppkCount  = $db->table('ppk')->where('skpd_id', $id)->countAllResults();
        $userCount = $db->table('users')->where('skpd_id', $id)->countAllResults();
        $rupCount  = $db->table('rup')->where('skpd_id', $id)->countAllResults();

        if ($ppkCount > 0 || $userCount > 0 || $rupCount > 0) {
            return $this->fail(
                "SKPD tidak dapat dihapus karena masih terhubung dengan {$ppkCount} Bidang/PPK, {$userCount} Akun Pengguna, dan {$rupCount} data RUP. Nonaktifkan status SKPD jika tidak digunakan lagi.",
                422
            );
        }

        try {
            $this->skpdModel->delete($id);

            return $this->done('Data SKPD berhasil dihapus!');
        } catch (\Throwable $e) {
            log_message('error', 'Error deleteSkpd: ' . $e->getMessage());

            return $this->fail('Gagal menghapus SKPD.', 500);
        }
    }

    /**
     * Tambah PPK / Bidang baru pada SKPD tertentu
     */
    public function storePpk()
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $post = $this->request;
        $data = [
            'skpd_id'   => (int) $post->getPost('skpd_id'),
            'name'      => trim((string) $post->getPost('name')),
            'is_active' => (string) $post->getPost('is_active') === '0' ? 0 : 1,
        ];

        $rules = [
            'skpd_id'   => 'required|is_natural_no_zero|is_not_unique[skpd.id]',
            'name'      => 'required|min_length[2]|max_length[255]',
            'is_active' => 'in_list[0,1]',
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->fail(implode(' ', $this->validator->getErrors()), 422);
        }

        // Cegah duplikasi nama bidang yang sama persis di dalam SKPD yang sama
        $duplicate = $this->ppkModel
            ->where('skpd_id', $data['skpd_id'])
            ->where('LOWER(name)', strtolower($data['name']))
            ->first();

        if ($duplicate) {
            return $this->fail('Nama Bidang / PPK tersebut sudah terdaftar pada SKPD ini.', 422);
        }

        try {
            $insertId = (int) $this->ppkModel->insert($data);

            return $this->done('Bidang / PPK baru berhasil ditambahkan ke SKPD!', [
                'ppk' => [
                    'id'         => $insertId,
                    'skpd_id'    => $data['skpd_id'],
                    'name'       => $data['name'],
                    'is_active'  => $data['is_active'],
                    'user_count' => 0,
                    'rup_count'  => 0,
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Error storePpk: ' . $e->getMessage());

            return $this->fail('Gagal menambahkan Bidang / PPK. Silakan coba lagi.', 500);
        }
    }

    /**
     * Perbarui data PPK / Bidang
     */
    public function updatePpk($id = null)
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $id  = $id ? (int) $id : (int) $this->request->getPost('id');
        $ppk = $id > 0 ? $this->ppkModel->find($id) : null;
        if (! $ppk) {
            return $this->fail('Data Bidang / PPK tidak ditemukan.', 404);
        }

        $post   = $this->request;
        $skpdId = (int) ($post->getPost('skpd_id') ?: $ppk['skpd_id']);
        $data   = [
            'skpd_id'   => $skpdId,
            'name'      => trim((string) $post->getPost('name')),
            'is_active' => (string) $post->getPost('is_active') === '0' ? 0 : 1,
        ];

        $rules = [
            'skpd_id'   => 'required|is_natural_no_zero|is_not_unique[skpd.id]',
            'name'      => 'required|min_length[2]|max_length[255]',
            'is_active' => 'in_list[0,1]',
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->fail(implode(' ', $this->validator->getErrors()), 422);
        }

        $duplicate = $this->ppkModel
            ->where('skpd_id', $data['skpd_id'])
            ->where('LOWER(name)', strtolower($data['name']))
            ->where('id !=', $id)
            ->first();

        if ($duplicate) {
            return $this->fail('Nama Bidang / PPK tersebut sudah digunakan pada SKPD ini.', 422);
        }

        try {
            $this->ppkModel->update($id, $data);

            // Jika skpd_id pada PPK dipindahkan, sinkronkan users yang terhubung ke ppk_id ini
            if ((int) $ppk['skpd_id'] !== $data['skpd_id']) {
                db_connect()->table('users')
                    ->where('ppk_id', $id)
                    ->update(['skpd_id' => $data['skpd_id']]);
            }

            return $this->done('Data Bidang / PPK berhasil diperbarui!');
        } catch (\Throwable $e) {
            log_message('error', 'Error updatePpk: ' . $e->getMessage());

            return $this->fail('Gagal memperbarui Bidang / PPK. Silakan coba lagi.', 500);
        }
    }

    /**
     * Hapus PPK / Bidang (hanya jika belum digunakan pada tabel RUP)
     */
    public function deletePpk($id = null)
    {
        if ($deny = $this->ensureAdministrator()) {
            return $deny;
        }

        $id  = $id ? (int) $id : (int) $this->request->getPost('id');
        $ppk = $id > 0 ? $this->ppkModel->find($id) : null;
        if (! $ppk) {
            return $this->fail('Data Bidang / PPK tidak ditemukan.', 404);
        }

        $db       = db_connect();
        $rupCount = $db->table('rup')->where('ppk_id', $id)->countAllResults();

        if ($rupCount > 0) {
            return $this->fail(
                "Bidang / PPK ini tidak dapat dihapus karena sudah terhubung dengan {$rupCount} paket RUP. Anda dapat mengubah namanya atau menonaktifkannya.",
                422
            );
        }

        try {
            $db->transBegin();

            // Lepaskan relasi ppk_id pada akun user yang mengacu ke bidang ini (SET NULL)
            $db->table('users')->where('ppk_id', $id)->update(['ppk_id' => null]);

            $this->ppkModel->delete($id);

            $db->transCommit();

            return $this->done('Bidang / PPK berhasil dihapus!');
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Error deletePpk: ' . $e->getMessage());

            return $this->fail('Gagal menghapus Bidang / PPK.', 500);
        }
    }

    private function ensureAdministrator(): ?ResponseInterface
    {
        $roleId   = (int) session()->get('role_id');
        $roleName = strtoupper((string) session()->get('role_name'));

        if ($roleId !== 1 && $roleName !== 'ADMINISTRATOR') {
            if ($this->request->isAJAX()) {
                return $this->fail('Anda tidak memiliki hak akses ke fitur ini.', 403);
            }

            return redirect()->to('/')->with('error', 'Hanya Administrator yang memiliki akses ke halaman Manajemen SKPD & PPK.');
        }

        return null;
    }

    private function done(string $message, array $extra = []): ResponseInterface
    {
        if ($this->request->isAJAX()) {
            return $this->respond(['status' => 'success', 'message' => $message] + $extra);
        }

        return redirect()->to('/skpd-ppk')->with('success', $message);
    }

    private function fail(string $message, int $status, array $extra = []): ResponseInterface
    {
        if ($this->request->isAJAX()) {
            return $this->respond(['status' => 'error', 'message' => $message] + $extra, $status);
        }

        return redirect()->to('/skpd-ppk')->withInput()->with('error', $message);
    }

    private function respond(array $payload, int $status = 200): ResponseInterface
    {
        $payload['csrf_name'] = csrf_token();
        $payload['csrf_hash'] = csrf_hash();

        return $this->response->setStatusCode($status)->setJSON($payload);
    }
}
