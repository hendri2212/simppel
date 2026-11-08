<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => $pageTitle ?? "Profil Pengguna")) ?>
    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>
        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">
                <div class="content-wrapper">

                    <div class="main-content layout-trimmed profile-page position-relative">

                        <!-- Profile Header Background -->
                        <div class="profile-page-header-underlay bg-primary-gradient bg-primary-600"></div>

                        <!-- Main Profile Container -->
                        <div class="container-xl position-relative">

                            <!-- Flash Notification -->
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                                    <div class="d-flex align-items-center">
                                        <svg class="sa-icon me-2 fs-lg"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                        <div><?= session()->getFlashdata('success') ?></div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                                    <div class="d-flex align-items-center">
                                        <svg class="sa-icon me-2 fs-lg"><use href="/icons/sprite.svg#alert-circle"></use></svg>
                                        <div><?= session()->getFlashdata('error') ?></div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <div id="ajaxAlertContainer"></div>

                            <?php
                            $userAvatarUrl = ! empty($user['avatar'])
                                ? base_url('uploads/avatars/' . esc($user['avatar']))
                                : base_url('img/avatar-default.png');
                            
                            $roleBadges = [
                                'ADMINISTRATOR' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                'ADMIN PPK'     => 'bg-primary-subtle text-primary border border-primary-subtle',
                                'PPK'           => 'bg-info-subtle text-info border border-info-subtle',
                                'ADMIN ULP'     => 'bg-success-subtle text-success border border-success-subtle',
                                'DISTRIBUSI'    => 'bg-warning-subtle text-warning border border-warning-subtle',
                                'KEPALA ULP'    => 'bg-purple-subtle text-purple border border-purple-subtle',
                                'POKJA'         => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                'MONEV'         => 'bg-dark-subtle text-dark border border-dark-subtle',
                            ];
                            $roleBadgeClass = $roleBadges[strtoupper($user['role_name'] ?? '')] ?? 'bg-light text-dark border';
                            ?>

                            <!-- Profile Header Card -->
                            <div class="profile-page-header rounded-3 body-bg shadow-3 mb-4">
                                <div class="d-flex flex-column flex-md-row align-items-center position-relative p-4">
                                    
                                    <!-- Profile Avatar -->
                                    <div class="profile-page-header-avatar mb-3 mb-md-0">
                                        <div class="position-relative">
                                            <img id="headerAvatarPreview" 
                                                 src="<?= $userAvatarUrl ?>" 
                                                 class="rounded-circle border border-4 border-white shadow-2 object-fit-cover" 
                                                 alt="<?= esc($user['full_name']) ?>" 
                                                 width="140" height="140"
                                                 style="object-fit: cover;">
                                            <button class="btn btn-icon position-absolute bottom-0 end-0 bg-white rounded-circle shadow-2 text-primary" 
                                                    type="button" 
                                                    id="btnTriggerAvatarUpload" 
                                                    title="Ganti Foto Profil">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#camera"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Profile Info -->
                                    <div class="profile-page-header-info ms-md-4 text-center text-md-start">
                                        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-1">
                                            <h1 class="fs-xxl fw-700 mb-0" id="headerFullName"><?= esc($user['full_name']) ?></h1>
                                            <span class="badge <?= $roleBadgeClass ?> fw-600 px-2 py-1 fs-xs">
                                                <?= esc($user['role_name'] ?? 'USER') ?>
                                            </span>
                                        </div>

                                        <p class="text-muted mb-2 fs-sm">
                                            <span class="fw-500">@<?= esc($user['username']) ?></span>
                                            <?php if (! empty($user['nip'])): ?>
                                                <span class="mx-1">•</span> NIP: <span id="headerNipText"><?= esc($user['nip']) ?></span>
                                            <?php endif; ?>
                                        </p>

                                        <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start fs-xs">
                                            <?php if (! empty($user['skpd_name'])): ?>
                                                <span class="badge bg-light text-secondary border d-inline-flex align-items-center gap-1">
                                                    <svg class="sa-icon inline-text"><use href="/icons/sprite.svg#home"></use></svg>
                                                    <span><?= esc($user['skpd_name']) ?></span>
                                                </span>
                                            <?php endif; ?>

                                            <?php if (! empty($user['ppk_name'])): ?>
                                                <span class="badge bg-light text-secondary border d-inline-flex align-items-center gap-1">
                                                    <svg class="sa-icon inline-text"><use href="/icons/sprite.svg#briefcase"></use></svg>
                                                    <span><?= esc($user['ppk_name']) ?></span>
                                                </span>
                                            <?php endif; ?>

                                            <span class="badge bg-light text-secondary border d-inline-flex align-items-center gap-1">
                                                <svg class="sa-icon inline-text"><use href="/icons/sprite.svg#mail"></use></svg>
                                                <span id="headerEmailText"><?= esc($user['email']) ?></span>
                                            </span>

                                            <?php if (! empty($user['whatsapp_number'])): ?>
                                                <span class="badge bg-light text-success border d-inline-flex align-items-center gap-1">
                                                    <svg class="sa-icon inline-text"><use href="/icons/sprite.svg#phone"></use></svg>
                                                    <span id="headerWaText"><?= esc($user['whatsapp_number']) ?></span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="profile-page-header-actions ms-md-auto mt-3 mt-md-0 d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary d-flex align-items-center" onclick="activateTab('tab-edit-profile')">
                                            <svg class="sa-icon me-1 inline-text"><use href="/icons/sprite.svg#edit-3"></use></svg>
                                            Edit Profil
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center" onclick="activateTab('tab-security')">
                                            <svg class="sa-icon me-1 inline-text"><use href="/icons/sprite.svg#shield"></use></svg>
                                            Ganti Password
                                        </button>
                                    </div>
                                </div>

                                <!-- Tab Navigation -->
                                <div class="profile-page-nav border-top">
                                    <ul class="nav nav-tabs-clean" id="profileTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active d-inline-flex align-items-center" id="tab-overview-link" data-bs-toggle="tab" href="#tab-overview" role="tab">
                                                <svg class="sa-icon me-2 inline-text"><use href="/icons/sprite.svg#user"></use></svg>
                                                <span>Ringkasan Akun</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-inline-flex align-items-center" id="tab-edit-profile-link" data-bs-toggle="tab" href="#tab-edit-profile" role="tab">
                                                <svg class="sa-icon me-2 inline-text"><use href="/icons/sprite.svg#edit"></use></svg>
                                                <span>Data Pribadi & Kepegawaian</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-inline-flex align-items-center" id="tab-security-link" data-bs-toggle="tab" href="#tab-security" role="tab">
                                                <svg class="sa-icon me-2 inline-text"><use href="/icons/sprite.svg#lock"></use></svg>
                                                <span>Keamanan & Password</span>
                                            </a>
                                        </li>
                                        <?php if (! empty($skpdDetail)): ?>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-inline-flex align-items-center" id="tab-skpd-link" data-bs-toggle="tab" href="#tab-skpd" role="tab">
                                                <svg class="sa-icon me-2 inline-text"><use href="/icons/sprite.svg#layers"></use></svg>
                                                <span>Instansi & SKPD</span>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Tab Contents -->
                            <div class="tab-content" id="profileTabContents">

                                <!-- TAB 1: RINGKASAN AKUN -->
                                <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
                                    <div class="row">
                                        
                                        <!-- Kolom Kiri: Kartu Identitas -->
                                        <div class="col-lg-8">
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Identitas</span> Pengguna</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="row g-3">
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Nama Lengkap</label>
                                                                <div class="fs-md fw-500 text-dark"><?= esc($user['full_name']) ?></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Username (Login)</label>
                                                                <div class="fs-md fw-500 text-dark">@<?= esc($user['username']) ?></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Nomor Induk Pegawai (NIP)</label>
                                                                <div class="fs-md text-dark"><?= ! empty($user['nip']) ? esc($user['nip']) : '<span class="text-muted fst-italic">Belum diisi</span>' ?></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Peran / Hak Akses</label>
                                                                <div>
                                                                    <span class="badge <?= $roleBadgeClass ?> fs-xs px-2 py-1">
                                                                        <?= esc($user['role_name'] ?? 'USER') ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Email Resmi</label>
                                                                <div class="fs-md text-dark">
                                                                    <a href="mailto:<?= esc($user['email']) ?>" class="text-decoration-none text-primary">
                                                                        <?= esc($user['email']) ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">WhatsApp / No. Telepon</label>
                                                                <div class="fs-md text-dark">
                                                                    <?php if (! empty($user['whatsapp_number'])): ?>
                                                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $user['whatsapp_number']) ?>" target="_blank" class="text-decoration-none text-success">
                                                                            <?= esc($user['whatsapp_number']) ?>
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <span class="text-muted fst-italic">Belum diisi</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-12"><hr class="my-2"></div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Satuan Kerja (SKPD)</label>
                                                                <div class="fs-md fw-500 text-dark"><?= esc($user['skpd_name'] ?? '-') ?></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Bidang / Unit PPK</label>
                                                                <div class="fs-md text-dark"><?= esc($user['ppk_name'] ?? '-') ?></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Status Akun</label>
                                                                <div>
                                                                    <?php if ((int)$user['is_active'] === 1): ?>
                                                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Nonaktif</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Terdaftar Sejak</label>
                                                                <div class="fs-sm text-muted">
                                                                    <?= ! empty($user['created_at']) ? date('d F Y, H:i', strtotime($user['created_at'])) : '-' ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card Info Petunjuk Akun -->
                                            <div class="panel mb-4">
                                                <div class="panel-container">
                                                    <div class="panel-content bg-subtlelight rounded">
                                                        <div class="d-flex align-items-start">
                                                            <div class="me-3 text-info">
                                                                <svg class="sa-icon fs-xl"><use href="/icons/sprite.svg#info"></use></svg>
                                                            </div>
                                                            <div class="fs-sm">
                                                                <div class="fw-600 text-dark mb-1">Kebijakan Data Pengguna & Keamanan Akun</div>
                                                                <p class="text-muted mb-0">
                                                                    Untuk menjaga integritas alur pengadaan barang dan jasa pada SIMPPEL, perubahan <strong>Username</strong>, <strong>Role</strong>, serta <strong>SKPD / Unit Kerja</strong> hanya dapat dilakukan oleh <em>Administrator Sistem</em>. Anda dapat memperbarui Nama Lengkap, NIP, Kontak WhatsApp, Email, Foto Profil, dan Password mandiri melalui tab yang tersedia.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kolom Kanan: Ringkasan Status & Statistik -->
                                        <div class="col-lg-4">
                                            
                                            <!-- Widget Statistik Paket -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Ringkasan</span> Tugas & Aktivitas</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                                            <div class="p-3 bg-primary-subtle text-primary rounded-3 me-3">
                                                                <svg class="sa-icon fs-lg"><use href="/icons/sprite.svg#folder"></use></svg>
                                                            </div>
                                                            <div>
                                                                <div class="fs-xs text-muted text-uppercase fw-600">Total Paket Terkait</div>
                                                                <div class="fs-xl fw-700 text-dark"><?= number_format($stats['total_paket'] ?? 0) ?></div>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                                            <div class="p-3 bg-warning-subtle text-warning rounded-3 me-3">
                                                                <svg class="sa-icon fs-lg"><use href="/icons/sprite.svg#clock"></use></svg>
                                                            </div>
                                                            <div>
                                                                <div class="fs-xs text-muted text-uppercase fw-600">Paket Dalam Proses</div>
                                                                <div class="fs-xl fw-700 text-dark"><?= number_format($stats['paket_proses'] ?? 0) ?></div>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-center">
                                                            <div class="p-3 bg-success-subtle text-success rounded-3 me-3">
                                                                <svg class="sa-icon fs-lg"><use href="/icons/sprite.svg#check-circle"></use></svg>
                                                            </div>
                                                            <div>
                                                                <div class="fs-xs text-muted text-uppercase fw-600">Paket Selesai</div>
                                                                <div class="fs-xl fw-700 text-dark"><?= number_format($stats['paket_selesai'] ?? 0) ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Shortcut Aksi -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Menu</span> Pintas</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content d-grid gap-2">
                                                        <a href="/dashboard-control-center" class="btn btn-outline-default text-start d-flex align-items-center justify-content-between">
                                                            <span class="d-inline-flex align-items-center"><svg class="sa-icon me-2 inline-text"><use href="/icons/sprite.svg#grid"></use></svg> Dashboard Pengadaan</span>
                                                            <svg class="sa-icon fs-sm text-muted"><use href="/icons/sprite.svg#chevron-right"></use></svg>
                                                        </a>
                                                        <a href="/paket" class="btn btn-outline-default text-start d-flex align-items-center justify-content-between">
                                                            <span class="d-inline-flex align-items-center"><svg class="sa-icon me-2 inline-text"><use href="/icons/sprite.svg#box"></use></svg> Daftar Paket Pekerjaan</span>
                                                            <svg class="sa-icon fs-sm text-muted"><use href="/icons/sprite.svg#chevron-right"></use></svg>
                                                        </a>
                                                        <a href="/monev" class="btn btn-outline-default text-start d-flex align-items-center justify-content-between">
                                                            <span class="d-inline-flex align-items-center"><svg class="sa-icon me-2 inline-text"><use href="/icons/sprite.svg#trending-up"></use></svg> e-Monev & Laporan</span>
                                                            <svg class="sa-icon fs-sm text-muted"><use href="/icons/sprite.svg#chevron-right"></use></svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 2: DATA PRIBADI & KEPEGAWAIAN (FORM EDIT) -->
                                <div class="tab-pane fade" id="tab-edit-profile" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Perbarui</span> Data Pribadi</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <form id="formUpdateProfile" action="/profile/update" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                                            <?= csrf_field() ?>

                                                            <!-- Hidden Avatar File Input -->
                                                            <input type="file" id="avatarFileInput" name="avatar" class="d-none" accept="image/png, image/jpeg, image/jpg, image/webp">

                                                            <!-- Avatar Upload Box -->
                                                            <div class="d-flex align-items-center p-3 mb-4 rounded border bg-light">
                                                                <img id="formAvatarPreview" 
                                                                     src="<?= $userAvatarUrl ?>" 
                                                                     class="rounded-circle border border-3 border-white shadow-1 me-3 object-fit-cover" 
                                                                     alt="Avatar Preview" 
                                                                     width="72" height="72"
                                                                     style="object-fit: cover;">
                                                                <div>
                                                                    <div class="fw-600 text-dark mb-1">Foto Profil Pengguna</div>
                                                                    <div class="fs-xs text-muted mb-2">Format: JPG, JPEG, PNG, atau WEBP. Ukuran file maksimal 2 MB.</div>
                                                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                                                        <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1" onclick="document.getElementById('avatarFileInput').click();">
                                                                            <svg class="sa-icon inline-text"><use href="/icons/sprite.svg#upload"></use></svg>
                                                                            <span>Unggah Foto Baru</span>
                                                                        </button>
                                                                        <span id="selectedFileName" class="fs-xs text-muted align-self-center fst-italic"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 1: Nama Lengkap & Username (Readonly) -->
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-md-7">
                                                                    <label for="inputFullName" class="form-label fw-500">Nama Lengkap <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="inputFullName" name="full_name" value="<?= esc($user['full_name']) ?>" required maxlength="150">
                                                                    <div class="invalid-feedback">Nama lengkap wajib diisi (minimal 3 karakter).</div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="inputUsername" class="form-label fw-500">Username</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text bg-light text-muted">@</span>
                                                                        <input type="text" class="form-control bg-light" id="inputUsername" value="<?= esc($user['username']) ?>" disabled readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 2: NIP & Email -->
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="inputNip" class="form-label fw-500">Nomor Induk Pegawai (NIP)</label>
                                                                    <input type="text" class="form-control" id="inputNip" name="nip" value="<?= esc($user['nip'] ?? '') ?>" placeholder="Misal: 198501012010011001" maxlength="30">
                                                                    <div class="form-text text-muted fs-xs">Nomor Induk Pegawai resmi instansi pemerintah.</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="inputEmail" class="form-label fw-500">Email Resmi <span class="text-danger">*</span></label>
                                                                    <input type="email" class="form-control" id="inputEmail" name="email" value="<?= esc($user['email']) ?>" required maxlength="150">
                                                                    <div class="invalid-feedback">Silakan masukkan alamat email yang valid.</div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 3: WhatsApp Number -->
                                                            <div class="row g-3 mb-4">
                                                                <div class="col-md-6">
                                                                    <label for="inputWhatsapp" class="form-label fw-500">Nomor WhatsApp / Kontak</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text bg-light text-success">
                                                                            <svg class="sa-icon"><use href="/icons/sprite.svg#phone"></use></svg>
                                                                        </span>
                                                                        <input type="tel" class="form-control" id="inputWhatsapp" name="whatsapp_number" value="<?= esc($user['whatsapp_number'] ?? '') ?>" placeholder="08xxxxxxxxxx" maxlength="20">
                                                                    </div>
                                                                    <div class="form-text text-muted fs-xs">Digunakan untuk notifikasi verifikasi berkas atau penugasan pokja.</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-500">Peran / Role</label>
                                                                    <input type="text" class="form-control bg-light" value="<?= esc($user['role_name'] ?? 'USER') ?>" disabled readonly>
                                                                    <div class="form-text text-muted fs-xs">Peran ditetapkan oleh Administrator SIMPPEL.</div>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                                                <button type="reset" class="btn btn-default" onclick="resetProfileForm()">Batal</button>
                                                                <button type="submit" class="btn btn-primary d-flex align-items-center" id="btnSaveProfile">
                                                                    <svg class="sa-icon me-1"><use href="/icons/sprite.svg#save"></use></svg>
                                                                    Simpan Perubahan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Catatan</span> Pengisian</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content fs-sm text-muted">
                                                        <ul class="ps-3 mb-0">
                                                            <li class="mb-2">Pastikan nomor <strong>WhatsApp</strong> aktif untuk menerima pesan koordinasi pengadaan barang dan jasa.</li>
                                                            <li class="mb-2">Gunakan <strong>Email resmi</strong> agar link reset password dan notifikasi berkas dapat diterima dengan aman.</li>
                                                            <li class="mb-2">Foto profil yang jelas mempermudah rekan kerja dan Pokja Pemilihan mengenali akun Anda di dalam sistem.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 3: KEAMANAN & GANTI PASSWORD -->
                                <div class="tab-pane fade" id="tab-security" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Ganti</span> Password Akun</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <form id="formUpdatePassword" action="/profile/update-password" method="POST" class="needs-validation" novalidate>
                                                            <?= csrf_field() ?>

                                                            <div class="mb-3">
                                                                <label for="currentPassword" class="form-label fw-500">Password Saat Ini <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control" id="currentPassword" name="current_password" required autocomplete="current-password">
                                                                    <button class="btn btn-outline-default toggle-password" type="button" data-target="currentPassword">
                                                                        <svg class="sa-icon"><use href="/icons/sprite.svg#eye"></use></svg>
                                                                    </button>
                                                                </div>
                                                                <div class="invalid-feedback">Password saat ini wajib diisi.</div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="newPassword" class="form-label fw-500">Password Baru <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control" id="newPassword" name="new_password" required minlength="8" autocomplete="new-password">
                                                                    <button class="btn btn-outline-default toggle-password" type="button" data-target="newPassword">
                                                                        <svg class="sa-icon"><use href="/icons/sprite.svg#eye"></use></svg>
                                                                    </button>
                                                                </div>
                                                                <div class="form-text text-muted fs-xs">Minimal 8 karakter kombinasi huruf, angka, atau simbol.</div>
                                                                <div class="invalid-feedback">Password baru minimal 8 karakter.</div>
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="confirmPassword" class="form-label fw-500">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required autocomplete="new-password">
                                                                    <button class="btn btn-outline-default toggle-password" type="button" data-target="confirmPassword">
                                                                        <svg class="sa-icon"><use href="/icons/sprite.svg#eye"></use></svg>
                                                                    </button>
                                                                </div>
                                                                <div class="invalid-feedback" id="confirmPasswordFeedback">Konfirmasi password wajib diisi dan harus cocok dengan password baru.</div>
                                                            </div>

                                                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                                                <button type="reset" class="btn btn-default">Reset</button>
                                                                <button type="submit" class="btn btn-primary d-flex align-items-center" id="btnSavePassword">
                                                                    <svg class="sa-icon me-1"><use href="/icons/sprite.svg#shield"></use></svg>
                                                                    Perbarui Password
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Tips</span> Keamanan Akun</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="d-flex align-items-start mb-3">
                                                            <div class="badge bg-primary-subtle text-primary p-2 me-3 rounded">
                                                                <svg class="sa-icon fs-sm"><use href="/icons/sprite.svg#key"></use></svg>
                                                            </div>
                                                            <div class="fs-xs">
                                                                <span class="fw-600 text-dark">Gunakan Sandi Kuat</span>
                                                                <p class="text-muted mb-0">Kombinasikan huruf kapital, huruf kecil, angka, dan karakter khusus.</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-start mb-3">
                                                            <div class="badge bg-warning-subtle text-warning p-2 me-3 rounded">
                                                                <svg class="sa-icon fs-sm"><use href="/icons/sprite.svg#lock"></use></svg>
                                                            </div>
                                                            <div class="fs-xs">
                                                                <span class="fw-600 text-dark">Jangan Bagikan Password</span>
                                                                <p class="text-muted mb-0">Akun SIMPPEL terhubung dengan tanggung jawab resmi penandatanganan dan verifikasi pengadaan.</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-start">
                                                            <div class="badge bg-success-subtle text-success p-2 me-3 rounded">
                                                                <svg class="sa-icon fs-sm"><use href="/icons/sprite.svg#shield-check"></use></svg>
                                                            </div>
                                                            <div class="fs-xs">
                                                                <span class="fw-600 text-dark">Perbarui Secara Berkala</span>
                                                                <p class="text-muted mb-0">Disarankan mengganti password secara berkala setiap 3-6 bulan.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 4: INSTANSI & SKPD (JIKA TERHUBUNG) -->
                                <?php if (! empty($skpdDetail)): ?>
                                <div class="tab-pane fade" id="tab-skpd" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Profil</span> Satuan Kerja Perangkat Daerah (SKPD)</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="row g-3">
                                                            <div class="col-sm-8">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Nama SKPD</label>
                                                                <div class="fs-lg fw-600 text-dark"><?= esc($skpdDetail['name']) ?></div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Kode / Singkatan</label>
                                                                <div>
                                                                    <span class="badge bg-primary fs-xs"><?= esc($skpdDetail['abbreviation'] ?? '-') ?></span>
                                                                    <?php if (! empty($skpdDetail['code'])): ?>
                                                                        <span class="badge bg-light text-dark border fs-xs ms-1"><?= esc($skpdDetail['code']) ?></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Alamat Kantor</label>
                                                                <div class="fs-md text-dark">
                                                                    <?= ! empty($skpdDetail['address']) ? nl2br(esc($skpdDetail['address'])) : '<span class="text-muted fst-italic">Belum ada keterangan alamat</span>' ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Kontak Telepon SKPD</label>
                                                                <div class="fs-md text-dark"><?= esc($skpdDetail['phone'] ?? '-') ?></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Email SKPD</label>
                                                                <div class="fs-md text-dark"><?= esc($skpdDetail['email'] ?? '-') ?></div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Website</label>
                                                                <div class="fs-md text-dark">
                                                                    <?php if (! empty($skpdDetail['website'])): ?>
                                                                        <a href="<?= esc($skpdDetail['website']) ?>" target="_blank" class="text-decoration-none">
                                                                            <?= esc($skpdDetail['website']) ?>
                                                                        </a>
                                                                    <?php else: ?>
                                                                        -
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="text-muted fs-xs text-uppercase fw-600 mb-1">Unit Kerja / Bidang (PPK)</label>
                                                                <div class="fs-md fw-500 text-dark"><?= esc($user['ppk_name'] ?? 'Seluruh Bidang (SKPD)') ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2><span class="fw-300">Informasi</span> Relasi</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content fs-sm text-muted">
                                                        <p class="mb-2">
                                                            Data RUP dan Paket Pengadaan yang diajukan oleh akun ini secara otomatis terhubung dengan SKPD <strong><?= esc($skpdDetail['name']) ?></strong>.
                                                        </p>
                                                        <p class="mb-0">
                                                            Jika terjadi perpindahan mutasi atau pergantian unit penugasan, silakan hubungi <em>Administrator SIMPPEL</em> untuk penyesuaian relasi SKPD & PPK.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <?= $this->include('partials/app-footer') ?>

        </main>

        <?= $this->include('partials/app-settings') ?>

    </div>

    <?= $this->include('partials/app-scripts') ?>

    <script src="scripts/pages/profile.js"></script>

</body>

</html>
