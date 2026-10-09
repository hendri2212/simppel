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
                                            <div class="fs-2 fw-bold text-dark">6</div>
                                            <div class="fs-xs text-success"><i class="fal fa-arrow-up"></i> +2 bulan ini</div>
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
                                            <div class="fs-2 fw-bold text-dark">4</div>
                                            <div class="fs-xs text-muted">66.7% dari total</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#clock"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Pending Verification</div>
                                            <div class="fs-2 fw-bold text-dark">1</div>
                                            <div class="fs-xs text-warning">Perlu konfirmasi</div>
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
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Inactive / Suspended</div>
                                            <div class="fs-2 fw-bold text-dark">1</div>
                                            <div class="fs-xs text-danger">Akun dinonaktifkan</div>
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
                                                <input type="text" id="accountSearchInput" class="form-control" placeholder="Cari nama, email, username...">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2">
                                            <select id="roleFilter" class="form-select form-select-sm">
                                                <option value="">Semua Role</option>
                                                <option value="Super Admin">Super Admin</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Editor">Editor</option>
                                                <option value="Staff">Staff</option>
                                                <option value="User">User</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-lg-2">
                                            <select id="statusFilter" class="form-select form-select-sm">
                                                <option value="">Semua Status</option>
                                                <option value="Active">Active</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1 col-lg-4 text-md-end">
                                            <span class="text-muted fs-xs" id="tableRecordCount">Menampilkan 6 akun</span>
                                        </div>
                                    </div>

                                    <!-- Responsive Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped align-middle mb-0" id="accountsTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px;">#</th>
                                                    <th>User</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                    <th class="text-end" style="width: 120px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $dummyUsers = [
                                                    [
                                                        'id' => 1,
                                                        'name' => 'Hendri Arifin',
                                                        'username' => '@hendri',
                                                        'email' => 'hendri.arifin@example.com',
                                                        'role' => 'Super Admin',
                                                        'role_badge' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                                        'status' => 'Active',
                                                        'status_badge' => 'bg-success',
                                                        'avatar' => '/img/demo/avatars/avatar-admin.png',
                                                        'created_at' => '12 Jan 2025'
                                                    ],
                                                    [
                                                        'id' => 2,
                                                        'name' => 'Sarah Connor',
                                                        'username' => '@sarahc',
                                                        'email' => 'sarah.connor@example.com',
                                                        'role' => 'Administrator',
                                                        'role_badge' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                                        'status' => 'Active',
                                                        'status_badge' => 'bg-success',
                                                        'avatar' => '/img/demo/avatars/avatar-c.png',
                                                        'created_at' => '03 Feb 2025'
                                                    ],
                                                    [
                                                        'id' => 3,
                                                        'name' => 'Ahmad Fauzi',
                                                        'username' => '@ahmadf',
                                                        'email' => 'ahmad.fauzi@example.com',
                                                        'role' => 'Manager',
                                                        'role_badge' => 'bg-info-subtle text-info border border-info-subtle',
                                                        'status' => 'Active',
                                                        'status_badge' => 'bg-success',
                                                        'avatar' => '/img/demo/avatars/avatar-b.png',
                                                        'created_at' => '18 Feb 2025'
                                                    ],
                                                    [
                                                        'id' => 4,
                                                        'name' => 'Jessica Lee',
                                                        'username' => '@jesslee',
                                                        'email' => 'jessica.lee@example.com',
                                                        'role' => 'Editor',
                                                        'role_badge' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                                        'status' => 'Pending',
                                                        'status_badge' => 'bg-warning text-dark',
                                                        'avatar' => '/img/demo/avatars/avatar-e.png',
                                                        'created_at' => '25 Mar 2025'
                                                    ],
                                                    [
                                                        'id' => 5,
                                                        'name' => 'Michael Brown',
                                                        'username' => '@mbrown',
                                                        'email' => 'michael.brown@example.com',
                                                        'role' => 'Staff',
                                                        'role_badge' => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                                                        'status' => 'Inactive',
                                                        'status_badge' => 'bg-secondary',
                                                        'avatar' => '/img/demo/avatars/avatar-d.png',
                                                        'created_at' => '10 Apr 2025'
                                                    ],
                                                    [
                                                        'id' => 6,
                                                        'name' => 'Siti Rahma',
                                                        'username' => '@srahma',
                                                        'email' => 'siti.rahma@example.com',
                                                        'role' => 'User',
                                                        'role_badge' => 'bg-light text-dark border',
                                                        'status' => 'Active',
                                                        'status_badge' => 'bg-success',
                                                        'avatar' => '/img/demo/avatars/avatar-f.png',
                                                        'created_at' => '02 Mei 2025'
                                                    ]
                                                ];

                                                try {
                                                    $userModel = new \App\Models\UserModel();
                                                    $dbUsers = $userModel->select('users.*, roles.name as role_name')->join('roles', 'roles.id = users.role_id', 'left')->findAll();
                                                    if (! empty($dbUsers)) {
                                                        $usersList = array_map(function ($u) {
                                                            return [
                                                                'id' => $u['id'],
                                                                'name' => $u['full_name'],
                                                                'username' => '@' . ltrim($u['username'], '@'),
                                                                'email' => $u['email'],
                                                                'role' => $u['role_name'] ?? 'ADMINISTRATOR',
                                                                'role_badge' => ($u['role_name'] === 'ADMINISTRATOR') ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-primary-subtle text-primary border border-primary-subtle',
                                                                'status' => ((int)$u['is_active'] === 1) ? 'Active' : 'Inactive',
                                                                'status_badge' => ((int)$u['is_active'] === 1) ? 'bg-success' : 'bg-secondary',
                                                                'avatar' => '/img/demo/avatars/avatar-admin.png',
                                                                'created_at' => !empty($u['created_at']) ? date('d M Y', strtotime($u['created_at'])) : date('d M Y'),
                                                            ];
                                                        }, $dbUsers);
                                                    } else {
                                                        $usersList = $dummyUsers;
                                                    }
                                                } catch (\Throwable $e) {
                                                    $usersList = $dummyUsers;
                                                }

                                                foreach ($usersList as $user): ?>
                                                    <tr class="account-row"
                                                        data-name="<?= esc(strtolower($user['name'])) ?>"
                                                        data-email="<?= esc(strtolower($user['email'])) ?>"
                                                        data-username="<?= esc(strtolower($user['username'])) ?>"
                                                        data-role="<?= esc($user['role']) ?>"
                                                        data-status="<?= esc($user['status']) ?>">
                                                        <td class="text-muted"><?= $user['id'] ?></td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="<?= $user['avatar'] ?>" alt="<?= esc($user['name']) ?>" class="rounded-circle me-3" style="width: 38px; height: 38px; object-fit: cover;">
                                                                <div>
                                                                    <div class="fw-semibold text-dark"><?= esc($user['name']) ?></div>
                                                                    <small class="text-muted"><?= esc($user['username']) ?></small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted"><?= esc($user['email']) ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="badge <?= $user['role_badge'] ?>"><?= esc($user['role']) ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="badge <?= $user['status_badge'] ?>"><?= esc($user['status']) ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted fs-xs"><?= esc($user['created_at']) ?></span>
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
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Detail akun <?= esc($user['name']) ?>');">
                                                                            <i class="fal fa-eye me-2"></i> Lihat Detail
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Edit akun <?= esc($user['name']) ?>');">
                                                                            <i class="fal fa-edit me-2"></i> Edit Akun
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="alert('Reset Password untuk <?= esc($user['name']) ?>');">
                                                                            <i class="fal fa-key me-2"></i> Reset Password
                                                                        </a>
                                                                    </li>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li>
                                                                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="if(confirm('Hapus akun <?= esc($user['name']) ?>?')) alert('Akun dihapus (dummy)');">
                                                                            <i class="fal fa-trash-alt me-2"></i> Hapus Akun
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination Footer -->
                                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                                        <div class="fs-xs text-muted">
                                            Menampilkan 1 sampai 6 dari 6 entri
                                        </div>
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
                                        </ul>
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
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" placeholder="budi@example.com" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <select class="form-select" required>
                                    <option value="User">User</option>
                                    <option value="Staff">Staff</option>
                                    <option value="Editor">Editor</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Administrator">Administrator</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Pending">Pending</option>
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

    <!-- Interactive Client-side Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('accountSearchInput');
            const roleFilter = document.getElementById('roleFilter');
            const statusFilter = document.getElementById('statusFilter');
            const rows = document.querySelectorAll('.account-row');
            const recordCount = document.getElementById('tableRecordCount');

            function filterRows() {
                const searchVal = (searchInput.value || '').toLowerCase().trim();
                const roleVal = roleFilter.value;
                const statusVal = statusFilter.value;

                let visibleCount = 0;

                rows.forEach(function (row) {
                    const name = row.getAttribute('data-name') || '';
                    const email = row.getAttribute('data-email') || '';
                    const username = row.getAttribute('data-username') || '';
                    const role = row.getAttribute('data-role') || '';
                    const status = row.getAttribute('data-status') || '';

                    const matchesSearch = !searchVal || name.includes(searchVal) || email.includes(searchVal) || username.includes(searchVal);
                    const matchesRole = !roleVal || role === roleVal;
                    const matchesStatus = !statusVal || status === statusVal;

                    if (matchesSearch && matchesRole && matchesStatus) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (recordCount) {
                    recordCount.textContent = `Menampilkan ${visibleCount} dari ${rows.length} akun`;
                }
            }

            if (searchInput) searchInput.addEventListener('input', filterRows);
            if (roleFilter) roleFilter.addEventListener('change', filterRows);
            if (statusFilter) statusFilter.addEventListener('change', filterRows);
        });
    </script>

</body>

</html>
