<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('is_logged_in')) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
            return redirect()->to('/login');
        }

        // Sesi dianggap tidak valid bila akun sudah dihapus atau dinonaktifkan
        $active = db_connect()->table('users')->select('is_active')
            ->where('id', (int) session()->get('user_id'))->get()->getRowArray();

        if (! $active || (int) $active['is_active'] !== 1) {
            session()->destroy();
            session()->start();
            session()->setFlashdata('error', 'Sesi Anda telah berakhir. Silakan login kembali.');

            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
