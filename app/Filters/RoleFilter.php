<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Otorisasi berbasis role. Pemakaian di route: ['filter' => 'role:ADMINISTRATOR']
 *
 * Role dan status aktif diverifikasi ulang dari database (bukan hanya dari session)
 * sehingga akun yang dinonaktifkan atau diturunkan haknya langsung kehilangan akses.
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userId = (int) session()->get('user_id');

        $row = $userId > 0
            ? db_connect()->table('users')
                ->select('users.is_active, roles.name AS role_name')
                ->join('roles', 'roles.id = users.role_id', 'left')
                ->where('users.id', $userId)
                ->get()->getRowArray()
            : null;

        if (! $row || (int) $row['is_active'] !== 1) {
            session()->destroy();

            return $this->deny($request, 401, 'Sesi tidak valid. Silakan login kembali.', '/login');
        }

        $allowed = array_map('strtoupper', (array) $arguments);
        if ($allowed !== [] && ! in_array(strtoupper((string) $row['role_name']), $allowed, true)) {
            return $this->deny($request, 403, 'Anda tidak memiliki hak akses ke halaman ini.', '/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    private function deny(RequestInterface $request, int $status, string $message, string $redirect)
    {
        if ($request->isAJAX()) {
            return service('response')->setStatusCode($status)->setJSON([
                'status'  => 'error',
                'message' => $message,
            ]);
        }

        return redirect()->to($redirect)->with('error', $message);
    }
}
