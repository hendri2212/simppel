<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to('/dashboard-control-center');
    }

    public function root(...$segments)
    {
        $path = trim(implode('/', $segments), '/');

        if ($path === '' || $path === 'index') {
            return redirect()->to('/dashboard-control-center');
        }

        // Mencegah directory traversal dan karakter berbahaya
        if (str_contains($path, '..') || str_contains($path, '\\') || ! preg_match('/^[a-zA-Z0-9_\/-]+$/', $path)) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Blokir akses langsung ke folder parsial/auth/errors/e-templates
        $firstSegment   = explode('/', $path)[0];
        $blockedFolders = ['partials', 'auth', 'errors', 'e-templates'];
        if (in_array($firstSegment, $blockedFolders, true)) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Blokir view yang wajib melalui controller khusus berotorisasi
        $controllerViews = ['accounts', 'account', 'rup', 'paket'];
        if (in_array($path, $controllerViews, true)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $viewFile = APPPATH . 'Views/' . $path . '.php';
        $realView = realpath($viewFile);
        $realBase = realpath(APPPATH . 'Views');

        // Pastikan file benar-benar ada di dalam folder Views
        if (! $realView || ! str_starts_with($realView, $realBase . DIRECTORY_SEPARATOR) || ! is_file($realView)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view($path);
    }
}