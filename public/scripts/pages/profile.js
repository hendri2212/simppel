/**
 * JavaScript interaktif untuk Halaman Profil Pengguna SIMPPEL
 */

function activateTab(tabId) {
    const triggerEl = document.querySelector(`a[href="#${tabId}"]`);
    if (triggerEl) {
        const tab = new bootstrap.Tab(triggerEl);
        tab.show();
        triggerEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

function showProfileAlert(message, type = 'success') {
    const container = document.getElementById('ajaxAlertContainer');
    if (!container) return;

    const icon = type === 'success' ? 'check-circle' : 'alert-circle';
    container.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <svg class="sa-icon me-2 fs-lg"><use href="/icons/sprite.svg#${icon}"></use></svg>
                <div>${message}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

document.addEventListener('DOMContentLoaded', function () {
    // 1. Trigger Avatar Upload dari tombol kamera di Header
    const btnTriggerAvatar = document.getElementById('btnTriggerAvatarUpload');
    const avatarInput = document.getElementById('avatarFileInput');
    const headerAvatarPreview = document.getElementById('headerAvatarPreview');
    const formAvatarPreview = document.getElementById('formAvatarPreview');
    const selectedFileName = document.getElementById('selectedFileName');

    if (btnTriggerAvatar && avatarInput) {
        btnTriggerAvatar.addEventListener('click', function () {
            // Arahkan juga user ke tab form agar tahu foto telah dipilih
            activateTab('tab-edit-profile');
            avatarInput.click();
        });
    }

    if (avatarInput) {
        avatarInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file foto maksimal 2 MB.');
                    this.value = '';
                    if (selectedFileName) selectedFileName.textContent = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (headerAvatarPreview) headerAvatarPreview.src = e.target.result;
                    if (formAvatarPreview) formAvatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
                if (selectedFileName) selectedFileName.textContent = file.name;
            }
        });
    }

    // 2. Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            if (targetInput) {
                const isPassword = targetInput.type === 'password';
                targetInput.type = isPassword ? 'text' : 'password';
                const iconUse = this.querySelector('use');
                if (iconUse) {
                    iconUse.setAttribute('href', isPassword ? '/icons/sprite.svg#eye-off' : '/icons/sprite.svg#eye');
                }
            }
        });
    });

    // 3. Submit Form Update Profil
    const formProfile = document.getElementById('formUpdateProfile');
    const btnSaveProfile = document.getElementById('btnSaveProfile');

    if (formProfile) {
        formProfile.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            const formData = new FormData(this);
            const originalBtnHtml = btnSaveProfile.innerHTML;
            btnSaveProfile.disabled = true;
            btnSaveProfile.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            fetch('/profile/update', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btnSaveProfile.disabled = false;
                btnSaveProfile.innerHTML = originalBtnHtml;

                if (data.success) {
                    showProfileAlert(data.message, 'success');

                    // Update UI teks langsung
                    if (data.full_name) {
                        const hFullName = document.getElementById('headerFullName');
                        if (hFullName) hFullName.textContent = data.full_name;
                    }
                    if (data.email) {
                        const hEmail = document.getElementById('headerEmailText');
                        if (hEmail) hEmail.textContent = data.email;
                    }
                    const nipVal = document.getElementById('inputNip').value;
                    const hNip = document.getElementById('headerNipText');
                    if (hNip && nipVal) hNip.textContent = nipVal;

                    const waVal = document.getElementById('inputWhatsapp').value;
                    const hWa = document.getElementById('headerWaText');
                    if (hWa && waVal) hWa.textContent = waVal;

                    // Update Avatar di navbar jika ada
                    if (data.avatar_url) {
                        document.querySelectorAll('.profile-image').forEach(img => {
                            img.src = data.avatar_url;
                        });
                    }
                } else {
                    showProfileAlert(data.message || 'Gagal memperbarui profil.', 'danger');
                }
            })
            .catch(err => {
                btnSaveProfile.disabled = false;
                btnSaveProfile.innerHTML = originalBtnHtml;
                showProfileAlert('Terjadi gangguan jaringan atau sesi berakhir. Silakan muat ulang halaman.', 'danger');
            });
        });
    }

    // 4. Submit Form Ganti Password
    const formPassword = document.getElementById('formUpdatePassword');
    const btnSavePassword = document.getElementById('btnSavePassword');
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');

    if (formPassword) {
        formPassword.addEventListener('submit', function (e) {
            e.preventDefault();

            // Verifikasi kecocokan password baru & konfirmasi
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Konfirmasi password tidak cocok.');
            } else {
                confirmPassword.setCustomValidity('');
            }

            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            const formData = new FormData(this);
            const originalBtnHtml = btnSavePassword.innerHTML;
            btnSavePassword.disabled = true;
            btnSavePassword.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            fetch('/profile/update-password', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btnSavePassword.disabled = false;
                btnSavePassword.innerHTML = originalBtnHtml;

                if (data.success) {
                    showProfileAlert(data.message, 'success');
                    formPassword.reset();
                    formPassword.classList.remove('was-validated');
                } else {
                    showProfileAlert(data.message || 'Gagal mengganti password.', 'danger');
                }
            })
            .catch(err => {
                btnSavePassword.disabled = false;
                btnSavePassword.innerHTML = originalBtnHtml;
                showProfileAlert('Terjadi gangguan jaringan atau sesi berakhir.', 'danger');
            });
        });
    }
});

function resetProfileForm() {
    const form = document.getElementById('formUpdateProfile');
    if (form) {
        form.reset();
        form.classList.remove('was-validated');
        const selectedFileName = document.getElementById('selectedFileName');
        if (selectedFileName) selectedFileName.textContent = '';
    }
}
