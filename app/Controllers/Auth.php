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

    /**
     * Proses autentikasi login
     */
    public function loginProcess()
    {
        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username/Email dan Password wajib diisi.');
        }

        $login    = trim((string) $this->request->getPost('login'));
        $password = (string) $this->request->getPost('password');

        $user = $this->userModel->getUserWithRole($login);

        if (! $user) {
            return redirect()->back()->withInput()->with('error', 'Akun tidak ditemukan. Periksa kembali username atau email.');
        }

        if (! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password yang Anda masukkan salah.');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator.');
        }

        // Simpan sesi login
        $sessionData = [
            'is_logged_in' => true,
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'full_name'    => $user['full_name'],
            'email'        => $user['email'],
            'role_id'      => $user['role_id'],
            'role_name'    => $user['role_name'] ?? 'USER',
        ];

        session()->set($sessionData);
        session()->setFlashdata('success', 'Selamat datang, ' . $user['full_name'] . '!');

        return redirect()->to('/');
    }

    /**
     * Proses logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
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
