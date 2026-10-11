<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    private const MAX_ATTEMPTS_PER_ACCOUNT = 5;
    private const MAX_ATTEMPTS_PER_IP      = 30;
    private const LOCK_SECONDS             = 900;

    /**
     * Proses autentikasi login
     */
    public function loginProcess()
    {
        $rules = [
            'login'    => 'required|max_length[150]',
            'password' => 'required|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username/Email dan Password wajib diisi.');
        }

        $login    = strtolower(trim((string) $this->request->getPost('login')));
        $password = (string) $this->request->getPost('password');

        $ip         = $this->request->getIPAddress();
        $accountKey = 'login_try_' . sha1($ip . '|' . $login);
        $ipKey      = 'login_try_ip_' . sha1($ip);

        if ($this->attempts($accountKey) >= self::MAX_ATTEMPTS_PER_ACCOUNT || $this->attempts($ipKey) >= self::MAX_ATTEMPTS_PER_IP) {
            return redirect()->back()->withInput()->with('error', 'Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.');
        }

        $user = $this->userModel->getUserWithRole($login);

        // Selalu jalankan password_verify agar waktu respons tidak membocorkan keberadaan akun
        $hash  = $user['password'] ?? '$2y$10$usesomesillystringforsaltAbcdefghijklmnopqrstuvwxyzAB';
        $valid = password_verify($password, $hash);

        // Pesan generik: tidak membedakan akun tidak ada, password salah, atau akun nonaktif
        if (! $user || ! $valid || (int) $user['is_active'] !== 1) {
            $this->hit($accountKey);
            $this->hit($ipKey);
            log_message('notice', "Login gagal untuk '{$login}' dari {$ip}");

            return redirect()->back()->withInput()
                ->with('error', 'Username/Email atau password salah, atau akun tidak aktif.');
        }

        cache()->delete($accountKey);

        if (password_needs_rehash($user['password'], PASSWORD_BCRYPT)) {
            $this->userModel->update($user['id'], ['password' => password_hash($password, PASSWORD_BCRYPT)]);
        }

        // Cegah session fixation: ganti ID sesi dan buang data sesi lama
        session()->regenerate(true);

        session()->set([
            'is_logged_in' => true,
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'full_name'    => $user['full_name'],
            'email'        => $user['email'],
            'role_id'      => $user['role_id'],
            'role_name'    => $user['role_name'] ?? 'USER',
            'skpd_id'      => $user['skpd_id'] ?? null,
            'skpd_name'    => $user['skpd_name'] ?? null,
            'skpd_abbr'    => $user['skpd_abbr'] ?? null,
            'ppk_id'       => $user['ppk_id'] ?? null,
            'ppk_name'     => $user['ppk_name'] ?? null,
        ]);
        session()->setFlashdata('success', 'Selamat datang, ' . $user['full_name'] . '!');

        return redirect()->to('/');
    }

    private function attempts(string $key): int
    {
        return (int) cache($key);
    }

    private function hit(string $key): void
    {
        cache()->save($key, $this->attempts($key) + 1, self::LOCK_SECONDS);
    }

    /**
     * Proses logout
     */
    public function logout()
    {
        session()->destroy();
        session()->start();
        session()->setFlashdata('success', 'Anda telah berhasil logout.');

        return redirect()->to('/login');
    }

    /**
     * Halaman Register
     */
    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/register');
    }

    /**
     * Halaman Lupa Password
     */
    public function forgetPassword()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/forgetpassword');
    }

    /**
     * Halaman Lock Screen
     */
    public function lockscreen()
    {
        return view('auth/lockscreen');
    }

    /**
     * Halaman Two Factor Authentication
     */
    public function twoFactor()
    {
        return view('auth/twofactor');
    }
}
