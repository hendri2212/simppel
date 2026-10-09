<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "User Accounts")) ?>

    <?= $this->include('partials/app-head-css') ?>
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
                    // Ambil data users dengan relasi role dan agency
                    try {
                        $userModel = new \App\Models\UserModel();
                        $dbUsers = $userModel->getUsersWithDetails();

                        $agencyModel = new \App\Models\AgencyModel();
                        $allAgencies = $agencyModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

                        $usersList = array_map(function ($u) {
                            $roleName = $u['role_name'] ?? 'USER';
                            $isActive = (int)$u['is_active'] === 1;

                            $roleBadge = match ($roleName) {
                                'ADMINISTRATOR' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                'ADMIN PPK'     => 'bg-primary-subtle text-primary border border-primary-subtle',
                                'PPK'           => 'bg-info-subtle text-info border border-info-subtle',
                                'ADMIN ULP'     => 'bg-success-subtle text-success border border-success-subtle',
                                'DISTRIBUSI'    => 'bg-warning-subtle text-warning border border-warning-subtle',
                                'KEPALA ULP'    => 'bg-purple-subtle text-purple border border-purple-subtle',
                                'POKJA'         => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                'MONEV'         => 'bg-dark-subtle text-dark border border-dark-subtle',
                                default         => 'bg-light text-dark border',
                            };

                            return [
                                'id'              => $u['id'],
                                'name'            => $u['full_name'],
                                'username'        => '@' . ltrim($u['username'], '@'),
                                'nip'             => !empty($u['nip']) && $u['nip'] !== '-' ? $u['nip'] : '-',
                                'email'           => $u['email'] ?: '-',
                                'whatsapp'        => $u['whatsapp_number'] ?: '-',
                                'role'            => $roleName,
                                'role_badge'      => $roleBadge,
                                'agency_id'       => $u['agency_id'] ?? null,
                                'agency_name'     => $u['agency_name'] ?? null,
                                'agency_abbr'     => $u['agency_abbr'] ?? null,
                                'agency_code'     => $u['agency_code'] ?? null,
                                'status'          => $isActive ? 'Active' : 'Inactive',
                                'status_badge'    => $isActive ? 'bg-success' : 'bg-secondary',
                                'avatar'          => '/img/demo/avatars/avatar-admin.png',
                                'created_at'      => !empty($u['created_at']) ? date('d M Y', strtotime($u['created_at'])) : '-',
                            ];
                        }, $dbUsers);
                    } catch (\Throwable $e) {
                        $usersList = [];
                        $allAgencies = [];
                    }

                    $totalCount          = count($usersList);
                    $activeCount         = count(array_filter($usersList, fn($u) => $u['status'] === 'Active'));
                    $inactiveCount       = count(array_filter($usersList, fn($u) => $u['status'] === 'Inactive'));
                    $usersWithAgency     = count(array_filter($usersList, fn($u) => !empty($u['agency_name'])));
                    $uniqueRoles         = array_unique(array_filter(array_column($usersList, 'role')));
                    sort($uniqueRoles);

                    // Daftar Agency unik yang ada di list user untuk filter
                    $userAgenciesMap = [];
                    foreach ($usersList as $u) {
                        if (!empty($u['agency_name'])) {
                            $userAgenciesMap[$u['agency_name']] = [
                                'name' => $u['agency_name'],
                                'abbr' => $u['agency_abbr'],
                            ];
                        }
                    }
                    ksort($userAgenciesMap);
                    ?>

                    <div class="main-content">

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
                                        <div class="col-md-3 col-lg-3">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-white">
                                                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                        <use href="/icons/sprite.svg#search"></use>
                                                    </svg>
                                                </span>
                                                <input type="text" id="accountSearchInput" class="form-control" placeholder="Cari nama, NIP, email, SKPD...">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <select id="roleFilter" class="form-select form-select-sm">
                                                <option value="">Semua Role</option>
                                                <?php foreach ($uniqueRoles as $r): ?>
                                                    <option value="<?= esc($r) ?>"><?= esc($r) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <select id="agencyFilter" class="form-select form-select-sm">
                                                <option value="">Semua SKPD</option>
                                                <option value="__none__">-- Tanpa SKPD --</option>
                                                <?php foreach ($userAgenciesMap as $agName => $ag): ?>
                                                    <option value="<?= esc($agName) ?>">
                                                        <?= esc($ag['abbr'] ? $ag['abbr'] . ' - ' : '') ?><?= esc($agName) ?>
                                                    </option>
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
                                        <div class="col-md-2 col-lg-2">
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
                                                    <th>User</th>
                                                    <th>NIP</th>
                                                    <th>SKPD</th>
                                                    <th>Email</th>
                                                    <th>WhatsApp</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
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
                                                                <img src="<?= $user['avatar'] ?>" alt="<?= esc($user['name']) ?>" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover;">
                                                                <div>
                                                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 170px;" title="<?= esc($user['name']) ?>"><?= esc($user['name']) ?></div>
                                                                    <small class="text-muted"><?= esc($user['username']) ?></small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="font-monospace fs-xs"><?= esc($user['nip']) ?></span>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($user['agency_name'])): ?>
                                                                <?php if (!empty($user['agency_abbr'])): ?>
                                                                    <div>
                                                                        <span class="badge bg-secondary-subtle text-dark border border-secondary-subtle mb-1"><?= esc($user['agency_abbr']) ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="fs-xs text-dark text-truncate" style="max-width: 240px;" title="<?= esc($user['agency_name']) ?>">
                                                                    <?= esc($user['agency_name']) ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <span class="text-muted fs-xs fst-italic">-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted fs-xs"><?= esc($user['email']) ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted fs-xs"><?= esc($user['whatsapp']) ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="badge <?= $user['role_badge'] ?>"><?= esc($user['role']) ?></span>
                                                        </td>
                                                        <td>
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
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Detail Akun:\nNama: <?= esc(addslashes($user['name'])) ?>\nUsername: <?= esc(addslashes($user['username'])) ?>\nRole: <?= esc(addslashes($user['role'])) ?>\nSKPD: <?= esc(addslashes($user['agency_name'] ?? '-')) ?>\nEmail: <?= esc(addslashes($user['email'])) ?>\nKontak: <?= esc(addslashes($user['whatsapp'])) ?>');">
                                                                            <i class="fal fa-eye me-2"></i> Lihat Detail
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Edit akun: <?= esc(addslashes($user['name'])) ?>');">
                                                                            <i class="fal fa-edit me-2"></i> Edit Akun
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Reset Password untuk: <?= esc(addslashes($user['name'])) ?>');">
                                                                            <i class="fal fa-key me-2"></i> Reset Password
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
                            <label class="form-label">SKPD</label>
                            <select class="form-select" name="agency_id">
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
                                <select class="form-select" required>
                                    <?php foreach ($uniqueRoles as $r): ?>
                                        <option value="<?= esc($r) ?>"><?= esc($r) ?></option>
                                    <?php endforeach; ?>
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

    <!-- Interactive Client-side Pagination & Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('accountSearchInput');
            const roleFilter = document.getElementById('roleFilter');
            const agencyFilter = document.getElementById('agencyFilter');
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
                const agencyVal = agencyFilter ? agencyFilter.value : '';
                const statusVal = statusFilter ? statusFilter.value : '';

                filteredRows = allRows.filter(function (row) {
                    const name = row.getAttribute('data-name') || '';
                    const email = row.getAttribute('data-email') || '';
                    const username = row.getAttribute('data-username') || '';
                    const nip = row.getAttribute('data-nip') || '';
                    const agency = row.getAttribute('data-agency') || '';
                    const agencyName = row.getAttribute('data-agency-name') || '';
                    const role = row.getAttribute('data-role') || '';
                    const status = row.getAttribute('data-status') || '';

                    const matchesSearch = !searchVal || 
                        name.includes(searchVal) || 
                        email.includes(searchVal) || 
                        username.includes(searchVal) || 
                        nip.includes(searchVal) ||
                        agency.includes(searchVal);

                    const matchesRole = !roleVal || role === roleVal;
                    const matchesAgency = !agencyVal || 
                        (agencyVal === '__none__' ? !agencyName : agencyName === agencyVal);
                    const matchesStatus = !statusVal || status === statusVal;

                    return matchesSearch && matchesRole && matchesAgency && matchesStatus;
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
            if (agencyFilter) agencyFilter.addEventListener('change', applyFilter);
            if (statusFilter) statusFilter.addEventListener('change', applyFilter);
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    perPage = this.value;
                    currentPage = 1;
                    renderTable();
                });
            }

            // Inisialisasi awal
            applyFilter();
        });
    </script>

</body>

</html>
