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
     * Ambil daftar seluruh tahun anggaran yang tersedia di database + tahun berjalan.
     *
     * @return list<int>
     */
    public static function getAvailableYears(): array
    {
        $cached = session()->get('available_years');
        if (is_array($cached) && $cached !== []) {
            return $cached;
        }

        $db = db_connect();
        $yearRows = $db->table('rup')->select('DISTINCT(fiscal_year) AS fiscal_year')
            ->where('fiscal_year IS NOT NULL')->orderBy('fiscal_year', 'DESC')->get()->getResultArray();
        $years = array_filter(array_map(static fn($r) => (int) $r['fiscal_year'], $yearRows));
        $currentYear = (int) date('Y');
        $years[] = $currentYear;
        $years[] = $currentYear + 1;
        $years = array_values(array_unique($years));
        rsort($years);

        session()->set('available_years', $years);

        return $years;
    }

    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        if (session()->get('is_logged_in') || self::tryRememberLogin()) {
            return redirect()->to('/dashboard-control-center');
        }

        return view('auth/login', [
            'availableYears' => self::getAvailableYears(),
            'defaultYear'    => (int) (session('fiscal_year') ?: date('Y')),
        ]);
    }

    /**
     * Proses autentikasi login
     */
    public function loginProcess()
    {
        $rules = [
            'login'       => 'required|max_length[150]',
            'password'    => 'required|max_length[255]',
            'fiscal_year' => 'permit_empty|is_natural_no_zero|greater_than_equal_to[2000]|less_than_equal_to[2100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username/Email dan Password wajib diisi.');
        }

        $login      = strtolower(trim((string) $this->request->getPost('login')));
        $password   = (string) $this->request->getPost('password');
        $fiscalYear = (int) ($this->request->getPost('fiscal_year') ?: date('Y'));

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

        self::setUserSession($user, $fiscalYear);

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
    public static function setUserSession(array $user, ?int $fiscalYear = null): void
    {
        $year = $fiscalYear ?: (int) (session('fiscal_year') ?: date('Y'));

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
            'whatsapp_number' => $user['whatsapp_number'] ?? null,
            'nip'          => $user['nip'] ?? null,
            'avatar'       => $user['avatar'] ?? null,
            'fiscal_year'  => $year,
        ]);
    }

    /**
     * Alihkan Tahun Anggaran aktif di sesi secara cepat
     */
    public function switchYear($year = null)
    {
        $newYear = (int) ($this->request->getPost('fiscal_year') ?? $year ?? $this->request->getGet('year'));
        if ($newYear >= 2000 && $newYear <= 2100) {
            session()->set('fiscal_year', $newYear);
            session()->setFlashdata('success', "Tahun Anggaran aktif dialihkan ke {$newYear}.");
        }

        $redirect = $this->request->getGet('redirect');
        if (! empty($redirect)) {
            // Jika redirect adalah URL lengkap
            if (str_starts_with($redirect, 'http://') || str_starts_with($redirect, 'https://')) {
                $targetHost = parse_url($redirect, PHP_URL_HOST);
                $myHost     = parse_url(base_url(), PHP_URL_HOST);
                if ($targetHost === $myHost || empty($targetHost)) {
                    // Bersihkan jika URL memuat double index.php
                    $cleanUrl = preg_replace('#/index\.php/index\.php(/|$)#', '/index.php$1', $redirect);
                    return redirect()->to($cleanUrl);
                }
            } elseif (str_starts_with($redirect, '/') && ! str_starts_with($redirect, '//')) {
                // Jika path relatif, hapus prefix index.php agar site_url() tidak menggandakannya
                $path = preg_replace('#^/index\.php(/|$)#', '$1', $redirect);
                return redirect()->to(site_url(ltrim($path, '/')));
            }
        }

        $referer = $this->request->getServer('HTTP_REFERER');
        if ($referer && str_contains($referer, (string) parse_url(base_url(), PHP_URL_HOST))) {
            $cleanReferer = preg_replace('#/index\.php/index\.php(/|$)#', '/index.php$1', $referer);
            return redirect()->to($cleanReferer);
        }

        return redirect()->to(site_url('dashboard-control-center'));
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
     * Halaman Two Factor Authentication
     */
    public function twoFactor()
    {
        return view('auth/twofactor');
    }
}
