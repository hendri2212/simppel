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

    public const REMEMBER_COOKIE    = 'simpple_remember';
    private const REMEMBER_LIFETIME = 2592000; // 30 hari (30 * 86400 detik)

    private const MAX_ATTEMPTS_PER_ACCOUNT = 5;
    private const MAX_ATTEMPTS_PER_IP      = 30;
    private const LOCK_SECONDS             = 900;

    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        if (session()->get('is_logged_in') || self::tryRememberLogin()) {
            return redirect()->to('/dashboard-control-center');
        }

        return view('auth/login');
    }

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

        self::setUserSession($user);

        // Tangani fitur "Ingat saya" (Remember Me)
        $remember = ! empty($this->request->getPost('remember'));
        if ($remember) {
            $rawToken  = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + self::REMEMBER_LIFETIME);

            $this->userModel->update($user['id'], [
                'remember_token'      => hash('sha256', $rawToken),
                'remember_expires_at' => $expiresAt,
            ]);

            self::setRememberCookie((int) $user['id'], $rawToken);
        } else {
            $this->userModel->update($user['id'], [
                'remember_token'      => null,
                'remember_expires_at' => null,
            ]);
            self::clearRememberCookie();
        }

        session()->setFlashdata('success', 'Selamat datang, ' . $user['full_name'] . '!');

        return redirect()->to('/dashboard-control-center')->withCookies();
    }

    /**
     * Set data sesi autentikasi pengguna
     */
    public static function setUserSession(array $user): void
    {
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
    }

    /**
     * Coba pulihkan sesi login otomatis dari cookie Remember Me bila valid
     */
    public static function tryRememberLogin(): bool
    {
        $cookie = $_COOKIE[self::REMEMBER_COOKIE] ?? service('request')->getCookie(self::REMEMBER_COOKIE);
        if (! is_string($cookie) || ! str_contains($cookie, ':')) {
            return false;
        }

        [$uidStr, $rawToken] = explode(':', $cookie, 2);
        $userId              = (int) $uidStr;

        if ($userId <= 0 || strlen($rawToken) !== 64 || ! ctype_xdigit($rawToken)) {
            self::clearRememberCookie();

            return false;
        }

        $userModel = new UserModel();
        $user      = $userModel->getUserWithRoleById($userId);

        if (
            ! $user
            || (int) ($user['is_active'] ?? 0) !== 1
            || empty($user['remember_token'])
            || empty($user['remember_expires_at'])
            || strtotime((string) $user['remember_expires_at']) <= time()
            || ! hash_equals((string) $user['remember_token'], hash('sha256', $rawToken))
        ) {
            self::clearRememberCookie();

            return false;
        }

        session()->regenerate(true);
        self::setUserSession($user);

        return true;
    }

    /**
     * Simpan cookie Remember Me (HttpOnly, SameSite=Lax, berlaku 30 hari)
     */
    private static function setRememberCookie(int $userId, string $rawToken): void
    {
        $value   = $userId . ':' . $rawToken;
        $secure  = service('request')->isSecure();
        $expires = time() + self::REMEMBER_LIFETIME;

        setcookie(self::REMEMBER_COOKIE, $value, [
            'expires'  => $expires,
            'path'     => '/',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        service('response')->setCookie(
            self::REMEMBER_COOKIE,
            $value,
            self::REMEMBER_LIFETIME,
            '',
            '/',
            '',
            $secure,
            true,
            'Lax'
        );
    }

    /**
     * Hapus cookie Remember Me dari browser
     */
    public static function clearRememberCookie(): void
    {
        $secure = service('request')->isSecure();

        setcookie(self::REMEMBER_COOKIE, '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        unset($_COOKIE[self::REMEMBER_COOKIE]);
        service('response')->deleteCookie(self::REMEMBER_COOKIE, '', '/');
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
        $userId = (int) session()->get('user_id');
        if ($userId > 0) {
            $this->userModel->update($userId, [
                'remember_token'      => null,
                'remember_expires_at' => null,
            ]);
        }

        self::clearRememberCookie();

        session()->destroy();
        session()->start();
        session()->setFlashdata('success', 'Anda telah berhasil logout.');

        return redirect()->to('/login')->withCookies();
    }

    /**
     * Halaman Register
     */
    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard-control-center');
        }

        return view('auth/register');
    }

    /**
     * Halaman Lupa Password
     */
    public function forgetPassword()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard-control-center');
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
