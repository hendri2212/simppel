<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "User Accounts")) ?>

    <?= $this->include('partials/app-head-css') ?>

    <!-- Select2 CSS & Bootstrap 5 Theme via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array(
                        "pageTitle" => "Accounts",
                        "pageSubTitle1" => "User Management",
                        "pageSubTitle2" => "Users",
                        "pageSubText" => "Halaman manajemen akun pengguna, hak akses, dan status keaktifan user dalam sistem."
                    )) ?>

                    <?php
                    // Data akun, SKPD, dan role disediakan oleh AccountController
                    $usersList       = $usersList ?? [];
                    $allAgencies     = $allAgencies ?? [];
                    $allRoles        = $allRoles ?? [];
                    $totalCount      = $totalCount ?? count($usersList);
                    $activeCount     = $activeCount ?? count(array_filter($usersList, fn($u) => ($u['status'] ?? '') === 'Active'));
                    $inactiveCount   = $inactiveCount ?? count(array_filter($usersList, fn($u) => ($u['status'] ?? '') === 'Inactive'));
                    $usersWithAgency = $usersWithAgency ?? count(array_filter($usersList, fn($u) => !empty($u['agency_name'])));
                    $uniqueRoles     = $uniqueRoles ?? array_unique(array_filter(array_column($usersList, 'role')));
                    ?>

                    <div class="main-content">

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                                <svg class="sa-icon text-success" style="width: 20px; height: 20px;">
                                    <use href="/icons/sprite.svg#check-circle"></use>
                                </svg>
                                <div><?= session()->getFlashdata('success') ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                                <svg class="sa-icon text-danger" style="width: 20px; height: 20px;">
                                    <use href="/icons/sprite.svg#alert-triangle"></use>
                                </svg>
                                <div><?= session()->getFlashdata('error') ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Stat Cards -->
                        <div class="row mb-4 g-3">
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#users"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total Accounts</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $totalCount ?></div>
                                            <div class="fs-xs text-muted">Seluruh pengguna sistem</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#user-check"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Active Users</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $activeCount ?></div>
                                            <div class="fs-xs text-success"><?= $totalCount > 0 ? round(($activeCount / $totalCount) * 100, 1) : 0 ?>% dari total</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-danger bg-opacity-10 text-danger me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#user-x"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Inactive Users</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $inactiveCount ?></div>
                                            <div class="fs-xs text-danger">Akun dinonaktifkan</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#briefcase"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total SKPD</div>
                                            <div class="fs-2 fw-bold text-dark"><?= count($allAgencies) ?></div>
                                            <div class="fs-xs text-info"><?= $usersWithAgency ?> akun terhubung SKPD</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel Account Table -->
                        <div id="panel-accounts" class="panel">
                            <div class="panel-hdr">
                                <h2>
                                    Daftar <span class="fw-300"><i>User Accounts</i></span>
                                </h2>
                                <div class="panel-toolbar">
                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#plus"></use>
                                        </svg>
                                        <span>Tambah Akun</span>
                                    </button>
                                </div>
                            </div>

                            <div class="panel-container show">
                                <div class="panel-content">

                                    <!-- Filter Toolbar -->
                                    <div class="row g-2 mb-3 align-items-center">
                                        <div class="col-md-5 col-lg-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-white">
                                                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                        <use href="/icons/sprite.svg#search"></use>
                                                    </svg>
                                                </span>
                                                <input type="text" id="accountSearchInput" class="form-control" placeholder="Cari nama, NIP, email, SKPD...">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <select id="roleFilter" class="form-select form-select-sm">
                                                <option value="">Semua Role</option>
                                                <?php foreach ($uniqueRoles as $r): ?>
                                                    <option value="<?= esc($r) ?>"><?= esc($r) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <select id="statusFilter" class="form-select form-select-sm">
                                                <option value="">Semua Status</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-lg-3">
                                            <div class="d-flex align-items-center gap-1 justify-content-md-end">
                                                <span class="fs-xs text-muted text-nowrap">Tampil:</span>
                                                <select id="perPageSelect" class="form-select form-select-sm" style="width: auto;">
                                                    <option value="10" selected>10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="all">Semua</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Responsive Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped align-middle mb-0" id="accountsTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 45px;">#</th>
                                                    <th style="min-width: 220px;">User</th>
                                                    <th class="text-nowrap" style="min-width: 170px;">NIP</th>
                                                    <th style="min-width: 200px;">SKPD</th>
                                                    <th class="text-nowrap">Email</th>
                                                    <th class="text-nowrap">WhatsApp</th>
                                                    <th class="text-nowrap text-center">Role</th>
                                                    <th class="text-nowrap text-center">Status</th>
                                                    <th class="text-end" style="width: 80px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($usersList as $user): ?>
                                                    <tr class="account-row"
                                                        data-name="<?= esc(strtolower($user['name'])) ?>"
                                                        data-email="<?= esc(strtolower($user['email'])) ?>"
                                                        data-username="<?= esc(strtolower($user['username'])) ?>"
                                                        data-nip="<?= esc(strtolower($user['nip'])) ?>"
                                                        data-agency="<?= esc(strtolower(($user['agency_abbr'] ?? '') . ' ' . ($user['agency_name'] ?? ''))) ?>"
                                                        data-agency-name="<?= esc($user['agency_name'] ?? '') ?>"
                                                        data-role="<?= esc($user['role']) ?>"
                                                        data-status="<?= esc($user['status']) ?>">
                                                        <td class="text-muted"><?= $user['id'] ?></td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="<?= $user['avatar'] ?>" alt="<?= esc($user['name']) ?>" class="rounded-circle me-2 flex-shrink-0" style="width: 38px; height: 38px; object-fit: cover;">
                                                                <div class="flex-grow-1" style="min-width: 0;">
                                                                    <a href="javascript:void(0);" class="fw-semibold text-dark text-break lh-sm text-decoration-none btn-view-user" data-user='<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>' title="Klik untuk lihat detail <?= esc($user['name']) ?>"><?= esc($user['name']) ?></a>
                                                                    <small class="text-muted d-block font-monospace fs-nano mt-1"><?= esc($user['username']) ?></small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <span class="font-monospace fs-xs text-dark fw-medium"><?= esc($user['nip']) ?></span>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($user['agency_name'])): ?>
                                                                <?php if (!empty($user['agency_abbr'])): ?>
                                                                    <div>
                                                                        <span class="badge bg-secondary-subtle text-dark border border-secondary-subtle mb-1"><?= esc($user['agency_abbr']) ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="fs-xs text-dark text-break" style="max-width: 280px;" title="<?= esc($user['agency_name']) ?>">
                                                                    <?= esc($user['agency_name']) ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <span class="text-muted fs-xs fst-italic">-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <span class="text-muted fs-xs"><?= esc($user['email']) ?></span>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <span class="text-muted fs-xs"><?= esc($user['whatsapp']) ?></span>
                                                        </td>
                                                        <td class="text-nowrap text-center">
                                                            <span class="badge <?= $user['role_badge'] ?>"><?= esc($user['role']) ?></span>
                                                        </td>
                                                        <td class="text-nowrap text-center">
                                                            <span class="badge <?= $user['status_badge'] ?>"><?= esc($user['status']) ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-icon btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                                        <use href="/icons/sprite.svg#more-vertical"></use>
                                                                    </svg>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                                    <li>
                                                                        <a class="dropdown-item btn-view-user" href="javascript:void(0);" data-user='<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>'>
                                                                            <i class="fal fa-eye me-2 text-primary"></i> Lihat Detail
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item btn-edit-user" href="javascript:void(0);" data-user='<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>'>
                                                                            <i class="fal fa-edit me-2 text-warning"></i> Edit Akun
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item btn-reset-password" href="javascript:void(0);" data-user='<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>'>
                                                                            <i class="fal fa-key me-2 text-danger"></i> Reset Password
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr id="noResultsRow" style="display: none;">
                                                    <td colspan="9" class="text-center py-4 text-muted">
                                                        <i class="fal fa-search me-1"></i> Tidak ada data akun yang sesuai dengan pencarian atau filter.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination Footer -->
                                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                        <div class="fs-xs text-muted" id="paginationInfo">
                                            Menampilkan 1 sampai 10 dari <?= $totalCount ?> pengguna
                                        </div>
                                        <nav aria-label="Navigasi Halaman Akun">
                                            <ul class="pagination pagination-sm mb-0" id="paginationControls">
                                                <!-- Dynamic Page Controls Generated by JS -->
                                            </ul>
                                        </nav>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <?= $this->include('partials/app-footer') ?>

        </main>

        <?= $this->include('partials/app-drawer') ?>

        <?= $this->include('partials/app-settings') ?>

    </div>

    <!-- Modal Detail Akun Pengguna -->
    <div class="modal fade" id="detailUserModal" tabindex="-1" aria-labelledby="detailUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content overflow-hidden border-0 shadow-lg">
                <!-- Cover Header Profil dengan Gradient Menarik -->
                <div class="modal-header border-0 text-white p-4 position-relative" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #0284c7 100%);">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    <div class="d-flex align-items-center gap-3 w-100 pe-4 flex-wrap flex-sm-nowrap">
                        <div class="position-relative flex-shrink-0">
                            <img id="detailModalAvatar" src="/img/demo/avatars/avatar-admin.png" alt="Avatar" class="rounded-circle border border-3 border-white shadow bg-white" style="width: 76px; height: 76px; object-fit: cover;">
                            <span id="detailModalStatusIndicator" class="position-absolute bottom-0 end-0 border border-2 border-white rounded-circle bg-success" style="width: 18px; height: 18px;" title="Status Pengguna"></span>
                        </div>
                        <div class="flex-grow-1" style="min-width: 0;">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <h4 class="mb-0 fw-bold text-white text-break" id="detailModalName">-</h4>
                                <span class="badge" id="detailModalRoleBadge">-</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="text-white-50 font-monospace fs-sm" id="detailModalUsername">@-</span>
                                <span class="badge" id="detailModalStatusBadge">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body p-4 bg-light bg-opacity-50">
                    <div class="row g-3">
                        <!-- Kartu Informasi Kepegawaian & Instansi -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white py-2 px-3 border-bottom d-flex align-items-center gap-2">
                                    <div class="rounded p-1 bg-primary bg-opacity-10 text-primary">
                                        <svg class="sa-icon" style="width: 15px; height: 15px;">
                                            <use href="/icons/sprite.svg#briefcase"></use>
                                        </svg>
                                    </div>
                                    <span class="fw-semibold text-dark fs-xs text-uppercase">Instansi & Kepegawaian</span>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label class="text-muted fs-xs text-uppercase fw-semibold mb-1 d-block">Nomor Induk Pegawai (NIP)</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="font-monospace fs-sm fw-bold text-dark" id="detailModalNip">-</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted fs-xs text-uppercase fw-semibold mb-1 d-block">Instansi / SKPD</label>
                                        <div id="detailModalAgencyContainer">
                                            <span class="badge bg-secondary-subtle text-dark border border-secondary-subtle mb-1" id="detailModalAgencyAbbr">DPUPR</span>
                                            <div class="fs-sm text-dark fw-medium text-break" id="detailModalAgencyName">-</div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-muted fs-xs text-uppercase fw-semibold mb-1 d-block">Role / Hak Akses Sistem</label>
                                        <div class="fs-sm fw-semibold text-dark" id="detailModalRole">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kartu Kontak & Akun -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white py-2 px-3 border-bottom d-flex align-items-center gap-2">
                                    <div class="rounded p-1 bg-info bg-opacity-10 text-info">
                                        <svg class="sa-icon" style="width: 15px; height: 15px;">
                                            <use href="/icons/sprite.svg#mail"></use>
                                        </svg>
                                    </div>
                                    <span class="fw-semibold text-dark fs-xs text-uppercase">Kontak & Informasi Akun</span>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label class="text-muted fs-xs text-uppercase fw-semibold mb-1 d-block">Alamat Email</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <svg class="sa-icon text-muted flex-shrink-0" style="width: 14px; height: 14px;">
                                                <use href="/icons/sprite.svg#mail"></use>
                                            </svg>
                                            <a href="#" id="detailModalEmailLink" class="fs-sm text-primary text-decoration-none fw-medium text-break">-</a>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted fs-xs text-uppercase fw-semibold mb-1 d-block">WhatsApp / Nomor Telepon</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <svg class="sa-icon text-muted flex-shrink-0" style="width: 14px; height: 14px;">
                                                <use href="/icons/sprite.svg#phone"></use>
                                            </svg>
                                            <span class="fs-sm font-monospace text-dark" id="detailModalWhatsapp">-</span>
                                            <a href="#" id="detailModalWaBtn" target="_blank" class="btn btn-xs btn-outline-success ms-auto d-none text-nowrap">
                                                <svg class="sa-icon me-1" style="width: 11px; height: 11px;">
                                                    <use href="/icons/sprite.svg#message-circle"></use>
                                                </svg>
                                                WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="text-muted fs-xs text-uppercase fw-semibold mb-1 d-block">ID Akun</label>
                                            <span class="badge bg-light text-dark border font-monospace" id="detailModalId">#1</span>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted fs-xs text-uppercase fw-semibold mb-1 d-block">Terdaftar Sejak</label>
                                            <span class="fs-xs text-dark fw-medium" id="detailModalCreatedAt">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white border-top py-2 px-4 d-flex justify-content-between align-items-center">
                    <span class="fs-xs text-muted">SIMPPLE &bull; Manajemen Pengguna</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1" id="detailModalResetPwdBtn">
                            <i class="fal fa-key me-1"></i> Reset Password
                        </button>
                        <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1" id="detailModalEditBtn">
                            <i class="fal fa-edit me-1"></i> Edit Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Akun Pengguna -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded p-2 bg-primary bg-opacity-10 text-primary">
                            <i class="fal fa-user-edit fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-0" id="editUserModalLabel">Edit Akun Pengguna</h5>
                            <small class="text-muted fs-xs">Perbarui data profil, hak akses, dan status keaktifan user</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editUserForm" action="/accounts/update" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="editUserId">

                    <div class="modal-body p-4">
                        <div id="editAlertContainer" class="d-none mb-3"></div>

                        <div class="row g-3">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="full_name" id="editUserFullName" placeholder="Nama Lengkap dengan Gelar" required>
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">@</span>
                                    <input type="text" class="form-control" name="username" id="editUserUsername" placeholder="username" required>
                                </div>
                            </div>

                            <!-- NIP -->
                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">NIP (Nomor Induk Pegawai)</label>
                                <input type="text" class="form-control font-monospace" name="nip" id="editUserNip" placeholder="18 digit NIP (jika PNS)">
                            </div>

                            <!-- SKPD / Agency Select2 -->
                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted" for="editUserAgencySelect">Instansi / SKPD</label>
                                <select class="form-select select2-edit-agency" name="agency_id" id="editUserAgencySelect" style="width: 100%;">
                                    <option value="">-- Tanpa SKPD / Instansi --</option>
                                    <?php foreach ($allAgencies as $ag): ?>
                                        <option value="<?= $ag['id'] ?>">
                                            <?= esc($ag['abbreviation'] ? $ag['abbreviation'] . ' - ' : '') ?><?= esc($ag['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">
                                        <i class="fal fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" name="email" id="editUserEmail" placeholder="nama@domain.com">
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">WhatsApp / Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">
                                        <i class="fab fa-whatsapp"></i>
                                    </span>
                                    <input type="text" class="form-control" name="whatsapp_number" id="editUserWhatsapp" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <!-- Role & Status -->
                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Role / Hak Akses <span class="text-danger">*</span></label>
                                <select class="form-select" name="role_id" id="editUserRoleId" required>
                                    <option value="">-- Pilih Role --</option>
                                    <?php foreach ($allRoles as $role): ?>
                                        <option value="<?= esc($role['id']) ?>"><?= esc($role['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Status Akun <span class="text-danger">*</span></label>
                                <select class="form-select" name="is_active" id="editUserIsActive" required>
                                    <option value="1">Active (Dapat Login)</option>
                                    <option value="0">Inactive (Dinonaktifkan)</option>
                                </select>
                            </div>

                            <!-- Password Baru (Opsional) -->
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-2 border">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="form-label fs-xs text-uppercase fw-semibold text-dark mb-0">Ubah Password Akun</label>
                                        <span class="badge bg-warning-subtle text-dark border">Opsional</span>
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white">
                                            <i class="fal fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" name="password" id="editUserPassword" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                    </div>
                                    <small class="text-muted fs-nano mt-1 d-block">Minimal 6 karakter jika ingin mengganti password baru untuk akun ini.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center gap-1" id="editUserSubmitBtn">
                            <i class="fal fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Reset Password -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fal fa-key fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fs-base fw-bold text-white mb-0" id="resetPasswordModalLabel">Reset Password Pengguna</h5>
                            <small class="text-white-50 fs-nano">Kembalikan password ke nilai bawaan sistem</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="resetPasswordForm" action="/accounts/reset-password" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="resetPasswordUserId" value="">

                    <div class="modal-body p-4">
                        <div id="resetAlertContainer" class="d-none mb-3"></div>

                        <div class="text-center mb-3">
                            <div class="avatar avatar-lg mx-auto mb-2 bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="fal fa-shield-alt fs-2 text-danger"></i>
                            </div>
                            <h6 class="fw-bold mb-1" id="resetPasswordUserName">-</h6>
                            <span class="badge bg-light text-muted border font-monospace" id="resetPasswordUserUsername">@-</span>
                        </div>

                        <div class="alert alert-warning border-warning-subtle d-flex align-items-start gap-2 mb-3">
                            <i class="fal fa-exclamation-triangle text-warning fs-5 flex-shrink-0 mt-1"></i>
                            <div class="fs-xs">
                                Anda akan mereset password akun pengguna ini. Password akan diubah menjadi nilai default sistem:
                                <div class="mt-2 p-2 bg-white rounded border text-center font-monospace fw-bold fs-sm text-dark select-all">
                                    12345678
                                </div>
                            </div>
                        </div>

                        <p class="fs-xs text-muted mb-0 text-center">
                            Pengguna dapat login kembali menggunakan password default di atas dan menggantinya setelah masuk.
                        </p>
                    </div>

                    <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1" id="resetPasswordSubmitBtn">
                            <i class="fal fa-check-circle me-1"></i> Ya, Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Akun -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dummyAddUserForm" onsubmit="event.preventDefault(); alert('Akun baru berhasil ditambahkan (simulasi dummy)!'); const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal')); modal.hide();">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Contoh: Budi Santoso" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" placeholder="budisantoso" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="addUserAgencySelect">SKPD</label>
                            <select class="form-select select2-agency" name="agency_id" id="addUserAgencySelect" style="width: 100%;">
                                <option value="">-- Pilih SKPD --</option>
                                <?php foreach ($allAgencies as $ag): ?>
                                    <option value="<?= $ag['id'] ?>">
                                        <?= esc($ag['abbreviation'] ? $ag['abbreviation'] . ' - ' : '') ?><?= esc($ag['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" placeholder="budi@simpple.id" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <select class="form-select" name="role_id" required>
                                    <option value="">-- Pilih Role --</option>
                                    <?php if (!empty($allRoles)): ?>
                                        <?php foreach ($allRoles as $role): ?>
                                            <option value="<?= esc($role['id']) ?>"><?= esc($role['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <?php foreach ($uniqueRoles as $r): ?>
                                            <option value="<?= esc($r) ?>"><?= esc($r) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Sementara</label>
                            <input type="password" class="form-control" placeholder="Minimal 8 karakter" required>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('partials/app-scripts') ?>

    <!-- jQuery & Select2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi Select2 pada dropdown SKPD dengan dropdownParent modal agar pencarian dapat difokuskan
            $('#addUserAgencySelect').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addUserModal'),
                placeholder: '-- Pilih SKPD --',
                allowClear: true,
                width: '100%'
            });

            $('#editUserAgencySelect').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#editUserModal'),
                placeholder: '-- Tanpa SKPD / Instansi --',
                allowClear: true,
                width: '100%'
            });

            // Reset Select2 ketika modal ditutup
            $('#addUserModal').on('hidden.bs.modal', function () {
                $('#addUserAgencySelect').val(null).trigger('change');
            });
            $('#editUserModal').on('hidden.bs.modal', function () {
                $('#editAlertContainer').addClass('d-none').empty();
            });
        });
    </script>

    <!-- Interactive Client-side Pagination & Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('accountSearchInput');
            const roleFilter = document.getElementById('roleFilter');
            const statusFilter = document.getElementById('statusFilter');
            const perPageSelect = document.getElementById('perPageSelect');
            const allRows = Array.from(document.querySelectorAll('.account-row'));
            const paginationInfo = document.getElementById('paginationInfo');
            const paginationControls = document.getElementById('paginationControls');
            const noResultsRow = document.getElementById('noResultsRow');

            let currentPage = 1;
            let perPage = 10;
            let filteredRows = [...allRows];

            function applyFilter() {
                const searchVal = (searchInput ? searchInput.value : '').toLowerCase().trim();
                const roleVal = roleFilter ? roleFilter.value : '';
                const statusVal = statusFilter ? statusFilter.value : '';

                filteredRows = allRows.filter(function (row) {
                    const name = row.getAttribute('data-name') || '';
                    const email = row.getAttribute('data-email') || '';
                    const username = row.getAttribute('data-username') || '';
                    const nip = row.getAttribute('data-nip') || '';
                    const agency = row.getAttribute('data-agency') || '';
                    const role = row.getAttribute('data-role') || '';
                    const status = row.getAttribute('data-status') || '';

                    const matchesSearch = !searchVal || 
                        name.includes(searchVal) || 
                        email.includes(searchVal) || 
                        username.includes(searchVal) || 
                        nip.includes(searchVal) ||
                        agency.includes(searchVal);

                    const matchesRole = !roleVal || role === roleVal;
                    const matchesStatus = !statusVal || status === statusVal;

                    return matchesSearch && matchesRole && matchesStatus;
                });

                currentPage = 1;
                renderTable();
            }

            function renderTable() {
                const totalFiltered = filteredRows.length;
                const limit = (perPage === 'all') ? totalFiltered : parseInt(perPage, 10);
                const totalPages = Math.max(1, Math.ceil(totalFiltered / (limit || 1)));

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }

                const startIndex = (currentPage - 1) * limit;
                const endIndex = (perPage === 'all') ? totalFiltered : Math.min(startIndex + limit, totalFiltered);

                // Sembunyikan semua baris
                allRows.forEach(row => { row.style.display = 'none'; });

                // Tampilkan hanya baris pada halaman aktif
                if (totalFiltered > 0) {
                    if (noResultsRow) noResultsRow.style.display = 'none';
                    for (let i = startIndex; i < endIndex; i++) {
                        if (filteredRows[i]) {
                            filteredRows[i].style.display = '';
                        }
                    }
                } else {
                    if (noResultsRow) noResultsRow.style.display = '';
                }

                // Update info pagination
                const startDisplay = totalFiltered === 0 ? 0 : startIndex + 1;
                if (paginationInfo) {
                    if (totalFiltered === allRows.length) {
                        paginationInfo.textContent = `Menampilkan ${startDisplay} sampai ${endIndex} dari ${totalFiltered} pengguna`;
                    } else {
                        paginationInfo.textContent = `Menampilkan ${startDisplay} sampai ${endIndex} dari ${totalFiltered} pengguna (disaring dari ${allRows.length} total)`;
                    }
                }

                renderPagination(totalPages, totalFiltered);
            }

            function renderPagination(totalPages, totalFiltered) {
                if (!paginationControls) return;
                paginationControls.innerHTML = '';

                if (totalPages <= 1 && perPage === 'all') {
                    return;
                }

                // Tombol Sebelumnya
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `<button class="page-link" type="button" aria-label="Sebelumnya">&lsaquo;</button>`;
                if (currentPage > 1) {
                    prevLi.querySelector('button').addEventListener('click', () => {
                        currentPage--;
                        renderTable();
                    });
                }
                paginationControls.appendChild(prevLi);

                // Smart windowing halaman
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    addPageButton(1);
                    if (startPage > 2) {
                        addEllipsis();
                    }
                }

                for (let p = startPage; p <= endPage; p++) {
                    addPageButton(p);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        addEllipsis();
                    }
                    addPageButton(totalPages);
                }

                // Tombol Selanjutnya
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === totalPages || totalFiltered === 0 ? 'disabled' : ''}`;
                nextLi.innerHTML = `<button class="page-link" type="button" aria-label="Selanjutnya">&rsaquo;</button>`;
                if (currentPage < totalPages && totalFiltered > 0) {
                    nextLi.querySelector('button').addEventListener('click', () => {
                        currentPage++;
                        renderTable();
                    });
                }
                paginationControls.appendChild(nextLi);
            }

            function addPageButton(pageNumber) {
                const li = document.createElement('li');
                li.className = `page-item ${pageNumber === currentPage ? 'active' : ''}`;
                li.innerHTML = `<button class="page-link" type="button">${pageNumber}</button>`;
                if (pageNumber !== currentPage) {
                    li.querySelector('button').addEventListener('click', () => {
                        currentPage = pageNumber;
                        renderTable();
                    });
                }
                paginationControls.appendChild(li);
            }

            function addEllipsis() {
                const li = document.createElement('li');
                li.className = 'page-item disabled';
                li.innerHTML = '<span class="page-link">&hellip;</span>';
                paginationControls.appendChild(li);
            }

            if (searchInput) searchInput.addEventListener('input', applyFilter);
            if (roleFilter) roleFilter.addEventListener('change', applyFilter);
            if (statusFilter) statusFilter.addEventListener('change', applyFilter);
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    perPage = this.value;
                    currentPage = 1;
                    renderTable();
                });
            }

            // Event Listener untuk Tombol Detail Akun Pengguna (.btn-view-user)
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-view-user');
                if (!btn) return;

                e.preventDefault();
                const rawData = btn.getAttribute('data-user');
                if (!rawData) return;

                try {
                    const u = JSON.parse(rawData);

                    document.getElementById('detailModalName').textContent = u.name || '-';
                    document.getElementById('detailModalUsername').textContent = u.username || '@-';
                    document.getElementById('detailModalId').textContent = '#' + (u.id || '-');
                    document.getElementById('detailModalNip').textContent = u.nip || '-';
                    document.getElementById('detailModalCreatedAt').textContent = u.created_at || '-';
                    document.getElementById('detailModalAvatar').src = u.avatar || '/img/demo/avatars/avatar-admin.png';

                    // Role & Badge
                    const roleBadge = document.getElementById('detailModalRoleBadge');
                    roleBadge.className = 'badge ' + (u.role_badge || 'bg-light text-dark');
                    roleBadge.textContent = u.role || 'USER';
                    document.getElementById('detailModalRole').textContent = u.role || 'USER';

                    // Status & Badge
                    const statusBadge = document.getElementById('detailModalStatusBadge');
                    const isActive = (u.status === 'Active');
                    statusBadge.className = 'badge ' + (isActive ? 'bg-success' : 'bg-secondary');
                    statusBadge.textContent = u.status || 'Inactive';

                    const statusIndicator = document.getElementById('detailModalStatusIndicator');
                    statusIndicator.className = 'position-absolute bottom-0 end-0 border border-2 border-white rounded-circle ' + (isActive ? 'bg-success' : 'bg-secondary');

                    // SKPD
                    const agencyAbbrEl = document.getElementById('detailModalAgencyAbbr');
                    const agencyNameEl = document.getElementById('detailModalAgencyName');
                    if (u.agency_name) {
                        agencyNameEl.textContent = u.agency_name;
                        if (u.agency_abbr) {
                            agencyAbbrEl.style.display = 'inline-block';
                            agencyAbbrEl.textContent = u.agency_abbr;
                        } else {
                            agencyAbbrEl.style.display = 'none';
                        }
                    } else {
                        agencyAbbrEl.style.display = 'none';
                        agencyNameEl.innerHTML = '<span class="text-muted fst-italic">Belum dihubungkan ke SKPD</span>';
                    }

                    // Email Link
                    const emailLink = document.getElementById('detailModalEmailLink');
                    if (u.email && u.email !== '-') {
                        emailLink.textContent = u.email;
                        emailLink.href = 'mailto:' + u.email;
                        emailLink.classList.remove('text-muted');
                        emailLink.classList.add('text-primary');
                    } else {
                        emailLink.textContent = '-';
                        emailLink.removeAttribute('href');
                        emailLink.classList.add('text-muted');
                        emailLink.classList.remove('text-primary');
                    }

                    // WhatsApp Link
                    const waText = document.getElementById('detailModalWhatsapp');
                    const waBtn = document.getElementById('detailModalWaBtn');
                    waText.textContent = u.whatsapp || '-';
                    if (u.whatsapp && u.whatsapp !== '-' && u.whatsapp.replace(/\D/g, '').length >= 8) {
                        let phoneClean = u.whatsapp.replace(/\D/g, '');
                        if (phoneClean.startsWith('0')) {
                            phoneClean = '62' + phoneClean.slice(1);
                        }
                        waBtn.href = 'https://wa.me/' + phoneClean;
                        waBtn.classList.remove('d-none');
                    } else {
                        waBtn.classList.add('d-none');
                    }

                    // Tombol Reset Password di Modal Detail
                    const resetPwdBtn = document.getElementById('detailModalResetPwdBtn');
                    if (resetPwdBtn) {
                        resetPwdBtn.onclick = function() {
                            const modalEl = document.getElementById('detailUserModal');
                            const modalInstance = bootstrap.Modal.getInstance(modalEl);
                            if (modalInstance) modalInstance.hide();
                            setTimeout(() => {
                                openResetPasswordModal(u);
                            }, 300);
                        };
                    }

                    // Tombol Edit di Modal Detail
                    const editBtn = document.getElementById('detailModalEditBtn');
                    editBtn.onclick = function() {
                        const modalEl = document.getElementById('detailUserModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) modalInstance.hide();
                        setTimeout(() => {
                            openEditUserModal(u);
                        }, 300);
                    };

                    const detailModal = new bootstrap.Modal(document.getElementById('detailUserModal'));
                    detailModal.show();
                } catch (err) {
                    console.error('Error parsing user data:', err);
                }
            });

            // Helper function untuk membuka Modal Reset Password
            function openResetPasswordModal(u) {
                if (!u) return;

                const alertBox = document.getElementById('resetAlertContainer');
                if (alertBox) {
                    alertBox.className = 'd-none mb-3';
                    alertBox.innerHTML = '';
                }

                document.getElementById('resetPasswordUserId').value = u.id || '';
                document.getElementById('resetPasswordUserName').textContent = u.name || 'Pengguna';
                document.getElementById('resetPasswordUserUsername').textContent = '@' + (u.raw_username || (u.username ? u.username.replace(/^@/, '') : ''));

                const submitBtn = document.getElementById('resetPasswordSubmitBtn');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fal fa-check-circle me-1"></i> Ya, Reset Password';
                }

                const resetModal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
                resetModal.show();
            }

            // Event Listener untuk Tombol Reset Password di Dropdown Tabel (.btn-reset-password)
            document.addEventListener('click', function(e) {
                const resetBtn = e.target.closest('.btn-reset-password');
                if (!resetBtn) return;

                e.preventDefault();
                const rawData = resetBtn.getAttribute('data-user');
                if (!rawData) return;

                try {
                    const u = JSON.parse(rawData);
                    openResetPasswordModal(u);
                } catch(err) {
                    console.error('Error parsing user data for reset password:', err);
                }
            });

            // AJAX Handler Form Reset Password
            const resetForm = document.getElementById('resetPasswordForm');
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('resetPasswordSubmitBtn');
                    const originalBtnHtml = submitBtn.innerHTML;
                    const alertBox = document.getElementById('resetAlertContainer');

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Memproses...';
                    alertBox.className = 'd-none mb-3';
                    alertBox.innerHTML = '';

                    const formData = new FormData(resetForm);

                    fetch('/accounts/reset-password', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json().then(data => ({ ok: response.ok, status: response.status, body: data })))
                    .then(({ ok, body }) => {
                        if (ok && body.status === 'success') {
                            alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-check-circle fs-5 flex-shrink-0"></i> <div>${body.message || 'Password berhasil direset ke default 12345678!'}</div>`;

                            // Tutup modal dan reload halaman
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnHtml;
                            alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div>${body.message || 'Terjadi kesalahan saat mereset password.'}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error resetting password:', error);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                        alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                        alertBox.innerHTML = '<i class="fal fa-exclamation-triangle fs-5 flex-shrink-0"></i> <div>Gagal menghubungi server. Silakan coba beberapa saat lagi.</div>';
                    });
                });
            }

            // Helper function untuk membuka Modal Edit Akun
            function openEditUserModal(u) {
                if (!u) return;

                const alertBox = document.getElementById('editAlertContainer');
                if (alertBox) {
                    alertBox.className = 'd-none mb-3';
                    alertBox.innerHTML = '';
                }

                // Isi data ke dalam form edit
                document.getElementById('editUserId').value = u.id || '';
                document.getElementById('editUserFullName').value = u.name || '';
                document.getElementById('editUserUsername').value = u.raw_username || (u.username ? u.username.replace(/^@/, '') : '');
                document.getElementById('editUserNip').value = u.raw_nip || (u.nip && u.nip !== '-' ? u.nip : '');
                document.getElementById('editUserEmail').value = u.raw_email || (u.email && u.email !== '-' ? u.email : '');
                document.getElementById('editUserWhatsapp').value = u.raw_whatsapp || (u.whatsapp && u.whatsapp !== '-' ? u.whatsapp : '');
                document.getElementById('editUserPassword').value = '';

                // Set Role ID
                if (u.role_id) {
                    document.getElementById('editUserRoleId').value = String(u.role_id);
                } else {
                    const roleSelect = document.getElementById('editUserRoleId');
                    for (let i = 0; i < roleSelect.options.length; i++) {
                        if (roleSelect.options[i].text.toLowerCase() === (u.role || '').toLowerCase()) {
                            roleSelect.selectedIndex = i;
                            break;
                        }
                    }
                }

                // Set Status Keaktifan
                const isActiveVal = (typeof u.is_active !== 'undefined') ? u.is_active : (u.status === 'Active' ? 1 : 0);
                document.getElementById('editUserIsActive').value = String(isActiveVal);

                // Set SKPD Select2
                const agencyVal = u.agency_id ? String(u.agency_id) : '';
                $('#editUserAgencySelect').val(agencyVal).trigger('change');

                // Buka modal
                const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editModal.show();
            }

            // Event Listener untuk Tombol Edit Akun di Dropdown Tabel (.btn-edit-user)
            document.addEventListener('click', function(e) {
                const editBtn = e.target.closest('.btn-edit-user');
                if (!editBtn) return;

                e.preventDefault();
                const rawData = editBtn.getAttribute('data-user');
                if (!rawData) return;

                try {
                    const u = JSON.parse(rawData);
                    openEditUserModal(u);
                } catch(err) {
                    console.error('Error parsing user data for edit:', err);
                }
            });

            // AJAX Handler Form Edit Akun Pengguna
            const editForm = document.getElementById('editUserForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('editUserSubmitBtn');
                    const originalBtnHtml = submitBtn.innerHTML;
                    const alertBox = document.getElementById('editAlertContainer');

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...';
                    alertBox.className = 'd-none mb-3';
                    alertBox.innerHTML = '';

                    const formData = new FormData(editForm);

                    fetch('/accounts/update', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json().then(data => ({ ok: response.ok, status: response.status, body: data })))
                    .then(({ ok, body }) => {
                        if (ok && body.status === 'success') {
                            alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-check-circle fs-5"></i> <div>${body.message || 'Data pengguna berhasil diperbarui!'}</div>`;

                            // Tutup modal dan reload agar data dan metrik tabel terupdate otomatis
                            setTimeout(() => {
                                window.location.reload();
                            }, 600);
                        } else {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnHtml;
                            alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-exclamation-triangle fs-5"></i> <div>${body.message || 'Terjadi kesalahan saat menyimpan data.'}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error updating user:', error);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnHtml;
                        alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                        alertBox.innerHTML = '<i class="fal fa-exclamation-triangle fs-5"></i> <div>Gagal menghubungi server. Silakan coba beberapa saat lagi.</div>';
                    });
                });
            }

            // Inisialisasi awal
            applyFilter();
        });
    </script>

</body>

</html>
