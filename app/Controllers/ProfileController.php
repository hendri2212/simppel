<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SkpdModel;
use App\Models\PpkModel;
use App\Models\PaketModel;

/**
 * Controller untuk Manajemen Profil Pengguna Pribadi.
 *
 * Mengizinkan setiap user yang login untuk melihat detail akun,
 * memperbarui data pribadi (Nama Lengkap, NIP, WhatsApp, Email, Avatar),
 * serta mengganti password akun.
 *
 * Catatan penting: Username dan Relasi Organisasi (Role, SKPD, PPK)
 * dikunci untuk pengguna biasa dan hanya dapat diubah oleh Administrator.
 */
class ProfileController extends BaseController
{
    protected UserModel $userModel;
    protected SkpdModel $skpdModel;
    protected PpkModel $ppkModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->skpdModel = new SkpdModel();
        $this->ppkModel  = new PpkModel();
    }

    /**
     * Tampilkan halaman detail profil pengguna
     */
    public function index()
    {
        $userId = session('user_id');
        if (! $userId) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->getUserWithRoleById((int) $userId);
        if (! $user) {
            session()->setFlashdata('error', 'Data pengguna tidak ditemukan.');
            return redirect()->to('/login');
        }

        // Ambil info detail SKPD jika ada
        $skpdDetail = null;
        if (! empty($user['skpd_id'])) {
            $skpdDetail = $this->skpdModel->find($user['skpd_id']);
        }

        // Statistik ringkas terkait peran pengguna
        $stats = [
            'total_paket'   => 0,
            'paket_selesai' => 0,
            'paket_proses'  => 0,
        ];

        try {
            $db = \Config\Database::connect();
            $roleName = strtoupper($user['role_name'] ?? '');

            if (in_array($roleName, ['PPK', 'ADMIN PPK'], true) && ! empty($user['skpd_id'])) {
                $paketQuery = $db->table('paket')->where('skpd_id', $user['skpd_id']);
                if ($roleName === 'PPK' && ! empty($user['ppk_id'])) {
                    $paketQuery->where('ppk_id', $user['ppk_id']);
                }
                $stats['total_paket']   = (clone $paketQuery)->countAllResults();
                $stats['paket_selesai'] = (clone $paketQuery)->where('status', 'SELESAI')->countAllResults();
                $stats['paket_proses']  = max(0, $stats['total_paket'] - $stats['paket_selesai']);
            } elseif ($roleName === 'POKJA') {
                $pokjaQuery = $db->table('paket_pokja')
                    ->join('paket', 'paket.id = paket_pokja.paket_id')
                    ->where('paket_pokja.user_id', $userId);
                $stats['total_paket']   = (clone $pokjaQuery)->countAllResults();
                $stats['paket_selesai'] = (clone $pokjaQuery)->where('paket.status', 'SELESAI')->countAllResults();
                $stats['paket_proses']  = max(0, $stats['total_paket'] - $stats['paket_selesai']);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Gagal memuat statistik profil: ' . $e->getMessage());
        }

        return view('profile', [
            'pageTitle'  => 'Profil Pengguna',
            'user'       => $user,
            'skpdDetail' => $skpdDetail,
            'stats'      => $stats,
        ]);
    }

    /**
     * Update data pribadi pengguna (Full Name, Email, NIP, WhatsApp, Foto Avatar).
     * Username dan Role dikunci untuk keamanan.
     */
    public function update()
    {
        $userId = session('user_id');
        if (! $userId) {
            return $this->respondError('Sesi tidak valid, silakan login kembali.', 401);
        }

        $user = $this->userModel->find((int) $userId);
        if (! $user) {
            return $this->respondError('Data pengguna tidak ditemukan.', 404);
        }

        // Rules validasi
        $rules = [
            'full_name'       => 'required|min_length[3]|max_length[150]',
            'email'           => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'nip'             => 'permit_empty|max_length[30]',
            'whatsapp_number' => 'permit_empty|max_length[20]',
        ];

        // Validasi upload avatar jika ada file diunggah
        $avatarFile = $this->request->getFile('avatar');
        $hasNewAvatar = $avatarFile && $avatarFile->isValid() && ! $avatarFile->hasMoved();
        if ($hasNewAvatar) {
            $rules['avatar'] = [
                'rules'  => 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]',
                'errors' => [
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
                    'max_size' => 'Ukuran foto maksimal 2 MB.',
                ],
            ];
        }

        if (! $this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return $this->respondError(implode('<br>', $errors), 422, $errors);
        }

        $dataToUpdate = [
            'full_name'       => trim((string) $this->request->getPost('full_name')),
            'email'           => trim((string) $this->request->getPost('email')),
            'nip'             => trim((string) $this->request->getPost('nip')) ?: null,
            'whatsapp_number' => trim((string) $this->request->getPost('whatsapp_number')) ?: null,
        ];

        // Proses penyimpanan avatar baru
        if ($hasNewAvatar) {
            $uploadPath = FCPATH . 'uploads/avatars';
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $newAvatarName = $avatarFile->getRandomName();
            if ($avatarFile->move($uploadPath, $newAvatarName)) {
                // Hapus avatar lama jika ada file fisiknya
                if (! empty($user['avatar'])) {
                    $oldAvatarPath = $uploadPath . DIRECTORY_SEPARATOR . $user['avatar'];
                    if (is_file($oldAvatarPath)) {
                        @unlink($oldAvatarPath);
                    }
                }
                $dataToUpdate['avatar'] = $newAvatarName;
            }
        }

        try {
            $this->userModel->update($userId, $dataToUpdate);

            // Perbarui sesi aktif agar navbar & header sinkron seketika
            session()->set([
                'full_name'       => $dataToUpdate['full_name'],
                'email'           => $dataToUpdate['email'],
                'nip'             => $dataToUpdate['nip'],
                'whatsapp_number' => $dataToUpdate['whatsapp_number'],
            ]);
            if (isset($dataToUpdate['avatar'])) {
                session()->set('avatar', $dataToUpdate['avatar']);
            }

            $avatarUrl = isset($dataToUpdate['avatar'])
                ? base_url('uploads/avatars/' . $dataToUpdate['avatar'])
                : (! empty($user['avatar']) ? base_url('uploads/avatars/' . $user['avatar']) : null);

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success'    => true,
                    'message'    => 'Data profil Anda berhasil diperbarui.',
                    'avatar_url' => $avatarUrl,
                    'full_name'  => $dataToUpdate['full_name'],
                    'email'      => $dataToUpdate['email'],
                ]);
            }

            session()->setFlashdata('success', 'Data profil Anda berhasil diperbarui.');
            return redirect()->to('/profile');
        } catch (\Throwable $e) {
            log_message('error', 'Gagal memperbarui profil: ' . $e->getMessage());
            return $this->respondError('Terjadi kesalahan sistem saat menyimpan profil.', 500);
        }
    }

    /**
     * Ganti Password Pengguna
     */
    public function updatePassword()
    {
        $userId = session('user_id');
        if (! $userId) {
            return $this->respondError('Sesi tidak valid, silakan login kembali.', 401);
        }

        $user = $this->userModel->find((int) $userId);
        if (! $user) {
            return $this->respondError('Data pengguna tidak ditemukan.', 404);
        }

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]|max_length[255]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        $messages = [
            'current_password' => ['required' => 'Password saat ini wajib diisi.'],
            'new_password'     => [
                'required'   => 'Password baru wajib diisi.',
                'min_length' => 'Password baru minimal 8 karakter.',
            ],
            'confirm_password' => [
                'required' => 'Konfirmasi password baru wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok dengan password baru.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            $errors = $this->validator->getErrors();
            return $this->respondError(implode('<br>', $errors), 422, $errors);
        }

        $currentPassword = (string) $this->request->getPost('current_password');
        $newPassword     = (string) $this->request->getPost('new_password');

        if (! password_verify($currentPassword, $user['password'])) {
            return $this->respondError('Password saat ini yang Anda masukkan salah.', 422);
        }

        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $this->userModel->update($userId, ['password' => $hashedPassword]);

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Password Anda berhasil diubah.',
                ]);
            }

            session()->setFlashdata('success', 'Password Anda berhasil diubah.');
            return redirect()->to('/profile');
        } catch (\Throwable $e) {
            log_message('error', 'Gagal update password: ' . $e->getMessage());
            return $this->respondError('Terjadi kesalahan sistem saat memperbarui password.', 500);
        }
    }

    /**
     * Helper response error seragam
     */
    protected function respondError(string $message, int $statusCode = 400, array $errors = [])
    {
        if ($this->request->isAJAX()) {
            return $this->response->setStatusCode($statusCode)->setJSON([
                'success' => false,
                'message' => $message,
                'errors'  => $errors,
            ]);
        }

        session()->setFlashdata('error', $message);
        return redirect()->back()->withInput();
    }
}
