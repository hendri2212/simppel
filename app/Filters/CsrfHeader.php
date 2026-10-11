<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Mengirim token CSRF terbaru lewat header respons.
 *
 * Token diregenerasi di setiap request yang divalidasi (Security::$regenerate),
 * sehingga klien AJAX perlu mengetahui token terbaru untuk request berikutnya
 * (lihat wrapper fetch di partials/app-scripts.php).
 */
class CsrfHeader implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if ($request->isAJAX()) {
            $response->setHeader('X-CSRF-TOKEN', csrf_hash());
        }
    }
}
