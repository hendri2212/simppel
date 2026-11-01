<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "SKPD & PPK")) ?>

    <?= $this->include('partials/app-head-css') ?>

    <!-- Select2 CSS & Bootstrap 5 Theme via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <style>
        .stat-card-filter {
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .stat-card-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 .35rem .85rem rgba(0,0,0,.08) !important;
        }
        .stat-card-filter.active-filter {
            outline: 2px solid var(--bs-primary);
        }
        .ppk-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.55rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .ppk-chip:hover {
            filter: brightness(0.95);
        }
    </style>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array(
                        "pageTitle"     => "SKPD & PPK",
                        "pageSubTitle1" => "User Management",
                        "pageSubTitle2" => "SKPD & PPK",
                        "pageSubText"   => "Kelola daftar Instansi/SKPD beserta relasi Bidang / Pejabat Pembuat Komitmen (PPK) di setiap SKPD."
                    )) ?>

                    <?php
                    $skpdList       = $skpdList ?? [];
                    $allPpk         = $allPpk ?? [];
                    $totalSkpd      = $totalSkpd ?? count($skpdList);
                    $activeSkpd     = $activeSkpd ?? 0;
                    $skpdWithPpk    = $skpdWithPpk ?? 0;
                    $skpdWithoutPpk = $skpdWithoutPpk ?? 0;
                    $totalPpk       = $totalPpk ?? count($allPpk);
                    $activePpk      = $activePpk ?? 0;
                    ?>

                    <div class="main-content">

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                                <svg class="sa-icon text-success" style="width: 20px; height: 20px;">
                                    <use href="/icons/sprite.svg#check-circle"></use>
                                </svg>
                                <div><?= esc(session()->getFlashdata('success')) ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                                <svg class="sa-icon text-danger" style="width: 20px; height: 20px;">
                                    <use href="/icons/sprite.svg#alert-triangle"></use>
                                </svg>
                                <div><?= esc(session()->getFlashdata('error')) ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Stat Cards (Bisa diklik untuk filter cepat) -->
                        <div class="row mb-4 g-3">
                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100 stat-card-filter" data-quick-filter="" title="Klik untuk menampilkan semua SKPD">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#briefcase"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total SKPD</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $totalSkpd ?></div>
                                            <div class="fs-xs text-muted"><?= $activeSkpd ?> SKPD berstatus aktif</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100 stat-card-filter" data-quick-filter="has_ppk" title="Klik untuk filter SKPD yang sudah memiliki PPK/Bidang">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#check-circle"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Memiliki PPK / Bidang</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $skpdWithPpk ?></div>
                                            <div class="fs-xs text-success"><?= $totalSkpd > 0 ? round(($skpdWithPpk / $totalSkpd) * 100, 1) : 0 ?>% SKPD sudah memiliki PPK</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100 stat-card-filter" data-quick-filter="no_ppk" title="Klik untuk filter SKPD yang belum memiliki PPK/Bidang">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#alert-triangle"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Belum Memiliki PPK</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $skpdWithoutPpk ?></div>
                                            <div class="fs-xs text-warning">Klik untuk lihat &amp; tambah PPK</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info me-3">
                                            <svg class="sa-icon" style="width: 24px; height: 24px;">
                                                <use href="/icons/sprite.svg#layers"></use>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-muted fs-xs text-uppercase fw-semibold">Total Bidang / PPK</div>
                                            <div class="fs-2 fw-bold text-dark"><?= $totalPpk ?></div>
                                            <div class="fs-xs text-info"><?= $activePpk ?> bidang aktif terdaftar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel Tabel SKPD & Relasi PPK -->
                        <div id="panel-skpd-ppk" class="panel">
                            <div class="panel-hdr">
                                <h2>
                                    Daftar <span class="fw-300"><i>SKPD &amp; Relasi Bidang (PPK)</i></span>
                                </h2>
                                <div class="panel-toolbar d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addSkpdModal">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#briefcase"></use>
                                        </svg>
                                        <span>Tambah SKPD</span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1" id="btnOpenGlobalAddPpk">
                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                            <use href="/icons/sprite.svg#plus"></use>
                                        </svg>
                                        <span>Tambah PPK / Bidang</span>
                                    </button>
                                </div>
                            </div>

                            <div class="panel-container show">
                                <div class="panel-content">

                                    <!-- Filter Toolbar -->
                                    <div class="row g-2 mb-3 align-items-center">
                                        <div class="col-md-4 col-lg-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-white">
                                                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                        <use href="/icons/sprite.svg#search"></use>
                                                    </svg>
                                                </span>
                                                <input type="text" id="skpdSearchInput" class="form-control" placeholder="Cari nama SKPD, singkatan, atau nama Bidang/PPK...">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <select id="ppkRelFilter" class="form-select form-select-sm">
                                                <option value="">Semua Status PPK / Bidang</option>
                                                <option value="has_ppk">Sudah Memiliki PPK / Bidang (<?= $skpdWithPpk ?>)</option>
                                                <option value="no_ppk">Belum Memiliki PPK / Bidang (<?= $skpdWithoutPpk ?>)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <select id="skpdStatusFilter" class="form-select form-select-sm">
                                                <option value="">Semua Status SKPD</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
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

                                    <!-- Tabel SKPD & PPK -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped align-middle mb-0" id="skpdPpkTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px;">#</th>
                                                    <th style="min-width: 260px;">SKPD / Instansi</th>
                                                    <th style="min-width: 340px;">Daftar Bidang / PPK Terdaftar</th>
                                                    <th class="text-center text-nowrap" style="width: 140px;">Keterkaitan</th>
                                                    <th class="text-center text-nowrap" style="width: 95px;">Status</th>
                                                    <th class="text-end" style="width: 145px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($skpdList as $skpd): ?>
                                                    <?php
                                                    $ppkNamesSearch = implode(' ', array_column($skpd['ppk_list'], 'name'));
                                                    $skpdJson = htmlspecialchars(json_encode($skpd, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
                                                    ?>
                                                    <tr class="skpd-row"
                                                        data-id="<?= (int) $skpd['id'] ?>"
                                                        data-search="<?= esc(strtolower($skpd['name'] . ' ' . $skpd['abbreviation'] . ' ' . $skpd['code'] . ' ' . $ppkNamesSearch)) ?>"
                                                        data-ppk-rel="<?= $skpd['has_ppk'] ? 'has_ppk' : 'no_ppk' ?>"
                                                        data-status="<?= esc($skpd['status']) ?>"
                                                        data-skpd='<?= $skpdJson ?>'>
                                                        <td class="text-muted font-monospace fs-xs"><?= (int) $skpd['id'] ?></td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                                <span class="badge bg-secondary-subtle text-dark border border-secondary-subtle font-monospace"><?= esc($skpd['abbreviation']) ?></span>
                                                                <?php if (!empty($skpd['raw_code']) && $skpd['raw_code'] !== '0'): ?>
                                                                    <span class="text-muted fs-nano font-monospace">Kode: <?= esc($skpd['code']) ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="fw-semibold text-dark lh-sm">
                                                                <a href="javascript:void(0);" class="text-dark text-decoration-none btn-manage-ppk" title="Kelola PPK/Bidang untuk <?= esc($skpd['name']) ?>">
                                                                    <?= esc($skpd['name']) ?>
                                                                </a>
                                                            </div>
                                                            <?php if (!empty($skpd['raw_address'])): ?>
                                                                <div class="text-muted fs-nano mt-1 text-truncate" style="max-width: 300px;" title="<?= esc($skpd['address']) ?>">
                                                                    <i class="fal fa-map-marker-alt me-1"></i><?= esc($skpd['address']) ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($skpd['has_ppk']): ?>
                                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                                    <span class="badge bg-success-subtle text-success border border-success-subtle fs-nano">
                                                                        <i class="fal fa-check-circle me-1"></i><?= $skpd['ppk_count'] ?> Bidang / PPK
                                                                    </span>
                                                                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none fs-xs btn-quick-add-ppk" data-skpd-id="<?= (int) $skpd['id'] ?>" data-skpd-name="<?= esc($skpd['name']) ?>">
                                                                        <i class="fal fa-plus-circle me-1"></i>Tambah Bidang
                                                                    </button>
                                                                </div>
                                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                                    <?php foreach ($skpd['ppk_list'] as $ppk): ?>
                                                                        <?php
                                                                        $ppkActive = (int) $ppk['is_active'] === 1;
                                                                        $chipClass = $ppkActive
                                                                            ? 'bg-info-subtle text-info border border-info-subtle'
                                                                            : 'bg-light text-muted border text-decoration-line-through';
                                                                        ?>
                                                                        <span class="ppk-chip <?= $chipClass ?> btn-edit-ppk-chip"
                                                                              data-ppk='<?= htmlspecialchars(json_encode($ppk, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'
                                                                              data-skpd-name="<?= esc($skpd['name']) ?>"
                                                                              title="Klik untuk mengedit Bidang: <?= esc($ppk['name']) ?> (<?= (int) $ppk['user_count'] ?> User, <?= (int) $ppk['rup_count'] ?> RUP)">
                                                                            <i class="fal fa-sitemap"></i>
                                                                            <span><?= esc($ppk['name']) ?></span>
                                                                            <?php if ((int) $ppk['user_count'] > 0 || (int) $ppk['rup_count'] > 0): ?>
                                                                                <span class="badge bg-white text-dark border ms-1" style="font-size: 0.65rem;">
                                                                                    <?= (int) $ppk['user_count'] ?>U / <?= (int) $ppk['rup_count'] ?>R
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="d-flex align-items-center justify-content-between p-2 rounded bg-warning bg-opacity-10 border border-warning-subtle">
                                                                    <div class="d-flex align-items-center gap-2 text-warning-emphasis fs-xs">
                                                                        <i class="fal fa-exclamation-circle"></i>
                                                                        <span>Belum memiliki PPK / Bidang</span>
                                                                    </div>
                                                                    <button type="button" class="btn btn-warning btn-xs py-1 px-2 fs-nano fw-semibold btn-quick-add-ppk" data-skpd-id="<?= (int) $skpd['id'] ?>" data-skpd-name="<?= esc($skpd['name']) ?>">
                                                                        <i class="fal fa-plus me-1"></i>Tambah PPK
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-inline-flex flex-column gap-1 align-items-center">
                                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle w-100" title="Jumlah akun user pada SKPD ini">
                                                                    <i class="fal fa-users me-1"></i><?= (int) $skpd['user_count'] ?> Akun
                                                                </span>
                                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle w-100" title="Jumlah RUP pada SKPD ini">
                                                                    <i class="fal fa-file-alt me-1"></i><?= (int) $skpd['rup_count'] ?> RUP
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge <?= esc($skpd['status_badge'], 'attr') ?>"><?= esc($skpd['status']) ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="d-inline-flex align-items-center gap-1">
                                                                <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2 fs-xs btn-manage-ppk" title="Kelola daftar Bidang/PPK pada SKPD ini">
                                                                    <i class="fal fa-sitemap me-1"></i>Bidang
                                                                </button>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-sm btn-icon btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                                                                            <use href="/icons/sprite.svg#more-vertical"></use>
                                                                        </svg>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                                        <li>
                                                                            <a class="dropdown-item btn-manage-ppk" href="javascript:void(0);">
                                                                                <i class="fal fa-sitemap me-2 text-primary"></i> Kelola Bidang / PPK
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item btn-quick-add-ppk" href="javascript:void(0);" data-skpd-id="<?= (int) $skpd['id'] ?>" data-skpd-name="<?= esc($skpd['name']) ?>">
                                                                                <i class="fal fa-plus-circle me-2 text-success"></i> Tambah Bidang / PPK
                                                                            </a>
                                                                        </li>
                                                                        <li><hr class="dropdown-divider"></li>
                                                                        <li>
                                                                            <a class="dropdown-item btn-edit-skpd" href="javascript:void(0);">
                                                                                <i class="fal fa-edit me-2 text-warning"></i> Edit Data SKPD
                                                                            </a>
                                                                        </li>
                                                                        <?php if ((int) $skpd['ppk_count'] === 0 && (int) $skpd['user_count'] === 0 && (int) $skpd['rup_count'] === 0): ?>
                                                                            <li>
                                                                                <a class="dropdown-item text-danger btn-delete-skpd" href="javascript:void(0);">
                                                                                    <i class="fal fa-trash-alt me-2 text-danger"></i> Hapus SKPD
                                                                                </a>
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr id="noResultsRow" style="display: none;">
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        Tidak ada data SKPD / Bidang PPK yang sesuai dengan kriteria pencarian.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination Footer -->
                                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 mt-3 pt-2 border-top">
                                        <div class="fs-xs text-muted" id="tablePaginationInfo">
                                            Menampilkan 0 - 0 dari 0 SKPD
                                        </div>
                                        <nav aria-label="Navigasi Halaman SKPD">
                                            <ul class="pagination pagination-sm mb-0" id="tablePaginationControls"></ul>
                                        </nav>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </main>

        <?= $this->include('partials/app-footer') ?>

    </div>

    <!-- =====================================================================
         MODAL 1: KELOLA DAFTAR PPK / BIDANG PADA SKPD TERPILIH
    ====================================================================== -->
    <div class="modal fade" id="managePpkModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white py-3">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="fal fa-sitemap me-2"></i>Kelola Bidang / PPK
                        </h5>
                        <div class="fs-xs text-white-50 mt-1" id="managePpkSkpdSubtitle">-</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="managePpkAlertContainer" class="d-none mb-3"></div>

                    <!-- Form Tambah Cepat Bidang / PPK ke SKPD Ini -->
                    <form id="inlineAddPpkForm" class="card bg-light border-0 mb-4">
                        <?= csrf_field() ?>
                        <input type="hidden" name="skpd_id" id="inlineAddPpkSkpdId">
                        <input type="hidden" name="is_active" value="1">
                        <div class="card-body p-3">
                            <label class="form-label fs-xs text-uppercase fw-semibold text-muted mb-2">
                                <i class="fal fa-plus-circle text-primary me-1"></i>Tambah Bidang / PPK Baru ke SKPD Ini
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" id="inlineAddPpkName" placeholder="Contoh: Sekretariat / Bidang Bina Marga..." required minlength="2" maxlength="255">
                                <button class="btn btn-primary d-flex align-items-center gap-1" type="submit" id="inlineAddPpkSubmitBtn">
                                    <i class="fal fa-plus"></i>
                                    <span>Tambah Bidang</span>
                                </button>
                            </div>
                            <small class="text-muted fs-nano">Bidang yang ditambahkan akan langsung tersedia pada pilihan akun PPK dan RUP untuk SKPD ini.</small>
                        </div>
                    </form>

                    <!-- Daftar Bidang / PPK pada SKPD Ini -->
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="fw-semibold mb-0 fs-sm">Daftar Bidang / PPK Terdaftar</h6>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle" id="managePpkCountBadge">0 Bidang</span>
                    </div>

                    <div class="table-responsive border rounded">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 55px;">ID</th>
                                    <th>Nama Bidang / PPK</th>
                                    <th class="text-center" style="width: 120px;">Penggunaan</th>
                                    <th class="text-center" style="width: 90px;">Status</th>
                                    <th class="text-end" style="width: 110px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="managePpkTableBody">
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada Bidang / PPK pada SKPD ini.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-2 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         MODAL 2: TAMBAH PPK / BIDANG BARU (DENGAN PILIHAN SKPD)
    ====================================================================== -->
    <div class="modal fade" id="addPpkModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="addPpkForm" action="/skpd-ppk/ppk/store" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white py-3">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="fal fa-plus-circle me-2"></i>Tambah Bidang / PPK Baru
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div id="addPpkAlertContainer" class="d-none mb-3"></div>

                        <div class="mb-3">
                            <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Pilih SKPD / Instansi <span class="text-danger">*</span></label>
                            <select class="form-select" name="skpd_id" id="addPpkSkpdSelect" required>
                                <option value="">-- Pilih SKPD --</option>
                                <?php foreach ($skpdList as $s): ?>
                                    <option value="<?= (int) $s['id'] ?>">
                                        <?= esc($s['abbreviation']) ?> - <?= esc($s['name']) ?><?= ! $s['has_ppk'] ? ' (Belum ada PPK)' : ' (' . $s['ppk_count'] . ' PPK)' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Bidang / PPK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="addPpkNameInput" placeholder="Contoh: Sekretariat / Bidang Perumahan Rakyat" required minlength="2" maxlength="255">
                        </div>

                        <div class="mb-1">
                            <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Status Keaktifan</label>
                            <select class="form-select" name="is_active" id="addPpkIsActive">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="addPpkSubmitBtn">
                            <i class="fal fa-save me-1"></i> Simpan Bidang / PPK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         MODAL 3: EDIT PPK / BIDANG
    ====================================================================== -->
    <div class="modal fade" id="editPpkModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="editPpkForm" action="/skpd-ppk/ppk/update" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="editPpkId">
                    <div class="modal-header bg-warning-subtle border-bottom py-3">
                        <h5 class="modal-title fw-bold text-dark mb-0">
                            <i class="fal fa-edit me-2 text-warning"></i>Edit Bidang / PPK
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div id="editPpkAlertContainer" class="d-none mb-3"></div>

                        <div class="mb-3">
                            <label class="form-label fs-xs text-uppercase fw-semibold text-muted">SKPD / Instansi <span class="text-danger">*</span></label>
                            <select class="form-select" name="skpd_id" id="editPpkSkpdSelect" required>
                                <?php foreach ($skpdList as $s): ?>
                                    <option value="<?= (int) $s['id'] ?>"><?= esc($s['abbreviation']) ?> - <?= esc($s['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Bidang / PPK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="editPpkNameInput" required minlength="2" maxlength="255">
                        </div>

                        <div class="mb-1">
                            <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Status Keaktifan</label>
                            <select class="form-select" name="is_active" id="editPpkIsActive">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-danger btn-sm d-none" id="btnDeletePpkFromEditModal">
                            <i class="fal fa-trash-alt me-1"></i> Hapus Bidang
                        </button>
                        <div class="ms-auto d-flex gap-2">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="editPpkSubmitBtn">
                                <i class="fal fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         MODAL 4: TAMBAH SKPD BARU
    ====================================================================== -->
    <div class="modal fade" id="addSkpdModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="addSkpdForm" action="/skpd-ppk/skpd/store" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white py-3">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="fal fa-briefcase me-2"></i>Tambah SKPD / Instansi Baru
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div id="addSkpdAlertContainer" class="d-none mb-3"></div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Lengkap SKPD <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Contoh: Dinas Pekerjaan Umum dan Penataan Ruang" required minlength="3" maxlength="255">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Singkatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="abbreviation" placeholder="Contoh: DPUPR" required minlength="2" maxlength="50">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Kode Satker / SKPD</label>
                                <input type="text" class="form-control" name="code" placeholder="Contoh: 299728">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Kontak / Telepon</label>
                                <input type="text" class="form-control" name="contact" placeholder="Contoh: (0518) 21234">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Status SKPD</label>
                                <select class="form-select" name="is_active">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Alamat</label>
                                <input type="text" class="form-control" name="address" placeholder="Alamat kantor SKPD...">
                            </div>
                            <div class="col-12">
                                <div class="p-3 rounded bg-light border">
                                    <label class="form-label fs-xs text-uppercase fw-semibold text-primary mb-1">
                                        <i class="fal fa-sitemap me-1"></i>Bidang / PPK Awal (Opsional)
                                    </label>
                                    <input type="text" class="form-control" name="initial_ppk_name" placeholder="Contoh: Sekretariat (Kosongkan jika ingin ditambah nanti)">
                                    <small class="text-muted fs-nano">Jika diisi, sistem otomatis membuatkan Bidang/PPK pertama untuk SKPD baru ini.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="addSkpdSubmitBtn">
                            <i class="fal fa-save me-1"></i> Simpan SKPD Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         MODAL 5: EDIT SKPD
    ====================================================================== -->
    <div class="modal fade" id="editSkpdModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="editSkpdForm" action="/skpd-ppk/skpd/update" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="editSkpdId">
                    <div class="modal-header bg-warning-subtle border-bottom py-3">
                        <h5 class="modal-title fw-bold text-dark mb-0">
                            <i class="fal fa-edit me-2 text-warning"></i>Edit Data SKPD
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div id="editSkpdAlertContainer" class="d-none mb-3"></div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Nama Lengkap SKPD <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="editSkpdName" required minlength="3" maxlength="255">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Singkatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="abbreviation" id="editSkpdAbbr" required minlength="2" maxlength="50">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Kode Satker / SKPD</label>
                                <input type="text" class="form-control" name="code" id="editSkpdCode">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Kontak / Telepon</label>
                                <input type="text" class="form-control" name="contact" id="editSkpdContact">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Status SKPD</label>
                                <select class="form-select" name="is_active" id="editSkpdIsActive">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fs-xs text-uppercase fw-semibold text-muted">Alamat</label>
                                <input type="text" class="form-control" name="address" id="editSkpdAddress">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="editSkpdSubmitBtn">
                            <i class="fal fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         MODAL 6: KONFIRMASI HAPUS (SKPD / BIDANG PPK)
    ====================================================================== -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form id="deleteConfirmForm" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="deleteConfirmId">
                    <div class="modal-header bg-danger text-white py-3">
                        <h5 class="modal-title fw-bold mb-0" id="deleteConfirmTitle">
                            <i class="fal fa-trash-alt me-2"></i>Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div id="deleteConfirmAlertContainer" class="d-none mb-3"></div>
                        <p class="mb-2 text-dark" id="deleteConfirmMessage">Apakah Anda yakin ingin menghapus data ini?</p>
                        <div class="p-3 rounded bg-light border font-monospace fw-semibold text-dark" id="deleteConfirmTargetName">-</div>
                    </div>
                    <div class="modal-footer bg-light border-top py-2 px-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm" id="deleteConfirmSubmitBtn">
                            <i class="fal fa-trash-alt me-1"></i> Ya, Hapus Permanen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $this->include('partials/app-scripts') ?>

    <!-- jQuery & Select2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const escapeHtml = (str) => String(str ?? '').replace(/[&<>"']/g, s => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[s]));

            // Sinkronisasi token CSRF baru di seluruh form
            function syncCsrf(body) {
                if (!body || !body.csrf_name || !body.csrf_hash) return;
                document.querySelectorAll(`input[name="${body.csrf_name}"]`).forEach(el => {
                    el.value = body.csrf_hash;
                });
            }

            // Inisialisasi Select2
            $('#addPpkSkpdSelect').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addPpkModal'),
                placeholder: '-- Pilih SKPD --',
                width: '100%'
            });

            $('#editPpkSkpdSelect').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#editPpkModal'),
                width: '100%'
            });

            // =========================================================================
            // FILTER & PAGINATION TABEL SKPD
            // =========================================================================
            const searchInput    = document.getElementById('skpdSearchInput');
            const ppkRelFilter   = document.getElementById('ppkRelFilter');
            const statusFilter   = document.getElementById('skpdStatusFilter');
            const perPageSelect  = document.getElementById('perPageSelect');
            const rows           = Array.from(document.querySelectorAll('#skpdPpkTable tbody tr.skpd-row'));
            const noResultsRow   = document.getElementById('noResultsRow');
            const pageInfoEl     = document.getElementById('tablePaginationInfo');
            const pageControlsEl = document.getElementById('tablePaginationControls');

            let currentPage  = 1;
            let filteredRows = [...rows];

            function applyFilter() {
                const q   = (searchInput.value || '').trim().toLowerCase();
                const rel = ppkRelFilter.value;
                const st  = statusFilter.value;

                filteredRows = rows.filter(row => {
                    const matchSearch = !q || (row.getAttribute('data-search') || '').includes(q);
                    const matchRel    = !rel || row.getAttribute('data-ppk-rel') === rel;
                    const matchStatus = !st || row.getAttribute('data-status') === st;
                    return matchSearch && matchRel && matchStatus;
                });

                // Highlight stat card aktif
                document.querySelectorAll('.stat-card-filter').forEach(card => {
                    card.classList.toggle('active-filter', card.getAttribute('data-quick-filter') === rel && rel !== '');
                });

                currentPage = 1;
                renderPage();
            }

            function renderPage() {
                const total = filteredRows.length;
                const perPageVal = perPageSelect.value;
                const perPage = perPageVal === 'all' ? Math.max(total, 1) : parseInt(perPageVal, 10) || 10;
                const totalPages = Math.max(1, Math.ceil(total / perPage));

                if (currentPage > totalPages) currentPage = totalPages;

                const startIdx = (currentPage - 1) * perPage;
                const endIdx   = Math.min(startIdx + perPage, total);

                rows.forEach(r => r.style.display = 'none');
                for (let i = startIdx; i < endIdx; i++) {
                    filteredRows[i].style.display = '';
                }

                if (noResultsRow) {
                    noResultsRow.style.display = total === 0 ? '' : 'none';
                }

                if (pageInfoEl) {
                    pageInfoEl.textContent = total === 0
                        ? 'Menampilkan 0 data SKPD'
                        : `Menampilkan ${startIdx + 1} - ${endIdx} dari ${total} SKPD`;
                }

                renderPaginationControls(totalPages);
            }

            function renderPaginationControls(totalPages) {
                if (!pageControlsEl) return;
                pageControlsEl.innerHTML = '';
                if (totalPages <= 1) return;

                const addPageItem = (label, page, disabled = false, active = false) => {
                    const li = document.createElement('li');
                    li.className = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
                    const a = document.createElement('a');
                    a.className = 'page-link';
                    a.href = 'javascript:void(0);';
                    a.innerHTML = label;
                    if (!disabled && !active) {
                        a.addEventListener('click', () => {
                            currentPage = page;
                            renderPage();
                        });
                    }
                    li.appendChild(a);
                    pageControlsEl.appendChild(li);
                };

                addPageItem('&laquo;', currentPage - 1, currentPage === 1);
                for (let p = 1; p <= totalPages; p++) {
                    if (p === 1 || p === totalPages || Math.abs(p - currentPage) <= 2) {
                        addPageItem(String(p), p, false, p === currentPage);
                    } else if (Math.abs(p - currentPage) === 3) {
                        addPageItem('...', p, true, false);
                    }
                }
                addPageItem('&raquo;', currentPage + 1, currentPage === totalPages);
            }

            searchInput.addEventListener('input', applyFilter);
            ppkRelFilter.addEventListener('change', applyFilter);
            statusFilter.addEventListener('change', applyFilter);
            perPageSelect.addEventListener('change', () => { currentPage = 1; renderPage(); });

            // Klik Stat Card untuk filter cepat
            document.querySelectorAll('.stat-card-filter').forEach(card => {
                card.addEventListener('click', function () {
                    const targetFilter = this.getAttribute('data-quick-filter') || '';
                    ppkRelFilter.value = (ppkRelFilter.value === targetFilter && targetFilter !== '') ? '' : targetFilter;
                    applyFilter();
                });
            });

            // =========================================================================
            // HELPER AJAX FORM SUBMIT
            // =========================================================================
            function bindAjaxForm(formId, submitBtnId, alertContainerId) {
                const form = document.getElementById(formId);
                if (!form) return;

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById(submitBtnId);
                    const alertBox  = document.getElementById(alertContainerId);
                    const origHtml  = submitBtn ? submitBtn.innerHTML : '';

                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
                    }
                    if (alertBox) {
                        alertBox.className = 'd-none mb-3';
                        alertBox.innerHTML = '';
                    }

                    fetch(form.getAttribute('action'), {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(r => r.json().catch(() => ({})).then(data => ({ ok: r.ok, body: data })))
                    .then(({ ok, body }) => {
                        syncCsrf(body);
                        if (ok && body.status === 'success') {
                            if (alertBox) {
                                alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                                alertBox.innerHTML = `<i class="fal fa-check-circle fs-5"></i> <div>${escapeHtml(body.message || 'Berhasil disimpan!')}</div>`;
                            }
                            setTimeout(() => window.location.reload(), 550);
                        } else {
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = origHtml;
                            }
                            if (alertBox) {
                                alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                                alertBox.innerHTML = `<i class="fal fa-exclamation-triangle fs-5"></i> <div>${escapeHtml(body.message || 'Terjadi kesalahan.')}</div>`;
                            }
                        }
                    })
                    .catch(() => {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = origHtml;
                        }
                        if (alertBox) {
                            alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = '<i class="fal fa-exclamation-triangle fs-5"></i> <div>Gagal menghubungi server.</div>';
                        }
                    });
                });
            }

            bindAjaxForm('addPpkForm', 'addPpkSubmitBtn', 'addPpkAlertContainer');
            bindAjaxForm('editPpkForm', 'editPpkSubmitBtn', 'editPpkAlertContainer');
            bindAjaxForm('addSkpdForm', 'addSkpdSubmitBtn', 'addSkpdAlertContainer');
            bindAjaxForm('editSkpdForm', 'editSkpdSubmitBtn', 'editSkpdAlertContainer');
            bindAjaxForm('deleteConfirmForm', 'deleteConfirmSubmitBtn', 'deleteConfirmAlertContainer');

            // Form tambah cepat PPK di dalam modal Kelola Bidang (#managePpkModal)
            const inlineForm = document.getElementById('inlineAddPpkForm');
            if (inlineForm) {
                inlineForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('inlineAddPpkSubmitBtn');
                    const alertBox  = document.getElementById('managePpkAlertContainer');
                    const origHtml  = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                    alertBox.className = 'd-none mb-3';

                    fetch('/skpd-ppk/ppk/store', {
                        method: 'POST',
                        body: new FormData(inlineForm),
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(r => r.json().catch(() => ({})).then(data => ({ ok: r.ok, body: data })))
                    .then(({ ok, body }) => {
                        syncCsrf(body);
                        if (ok && body.status === 'success') {
                            alertBox.className = 'alert alert-success d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-check-circle fs-5"></i> <div>${escapeHtml(body.message)}</div>`;
                            setTimeout(() => window.location.reload(), 500);
                        } else {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = origHtml;
                            alertBox.className = 'alert alert-danger d-flex align-items-center gap-2 mb-3';
                            alertBox.innerHTML = `<i class="fal fa-exclamation-triangle fs-5"></i> <div>${escapeHtml(body.message || 'Gagal menambah Bidang.')}</div>`;
                        }
                    })
                    .catch(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = origHtml;
                    });
                });
            }

            // =========================================================================
            // HANDLER BUKA MODAL KELOLA BIDANG / PPK (#managePpkModal)
            // =========================================================================
            function openManagePpkModal(skpd) {
                if (!skpd) return;

                document.getElementById('managePpkSkpdSubtitle').textContent = `${skpd.abbreviation} — ${skpd.name}`;
                document.getElementById('inlineAddPpkSkpdId').value = skpd.id;
                document.getElementById('inlineAddPpkName').value = '';
                document.getElementById('managePpkAlertContainer').className = 'd-none mb-3';

                const ppks = skpd.ppk_list || [];
                document.getElementById('managePpkCountBadge').textContent = `${ppks.length} Bidang`;

                const tbody = document.getElementById('managePpkTableBody');
                tbody.innerHTML = '';

                if (ppks.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fal fa-info-circle me-1"></i>SKPD ini belum memiliki Bidang / PPK. Silakan tambahkan menggunakan form di atas.
                            </td>
                        </tr>`;
                } else {
                    ppks.forEach(p => {
                        const isActive = parseInt(p.is_active, 10) === 1;
                        const canDel   = parseInt(p.rup_count || 0, 10) === 0;
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="text-muted font-monospace fs-xs">${p.id}</td>
                            <td class="fw-semibold text-dark">${escapeHtml(p.name)}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border fs-nano">${p.user_count || 0} User &bull; ${p.rup_count || 0} RUP</span>
                            </td>
                            <td class="text-center">
                                <span class="badge ${isActive ? 'bg-success' : 'bg-secondary'}">${isActive ? 'Active' : 'Inactive'}</span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-xs btn-outline-warning py-1 px-2 btn-modal-edit-ppk" title="Edit Bidang">
                                    <i class="fal fa-edit"></i>
                                </button>
                                ${canDel ? `
                                <button type="button" class="btn btn-xs btn-outline-danger py-1 px-2 ms-1 btn-modal-del-ppk" title="Hapus Bidang">
                                    <i class="fal fa-trash-alt"></i>
                                </button>` : ''}
                            </td>
                        `;

                        tr.querySelector('.btn-modal-edit-ppk').addEventListener('click', () => {
                            bootstrap.Modal.getInstance(document.getElementById('managePpkModal'))?.hide();
                            openEditPpkModal(p);
                        });

                        const delBtn = tr.querySelector('.btn-modal-del-ppk');
                        if (delBtn) {
                            delBtn.addEventListener('click', () => {
                                bootstrap.Modal.getInstance(document.getElementById('managePpkModal'))?.hide();
                                openDeleteConfirmModal({
                                    action: `/skpd-ppk/ppk/delete/${p.id}`,
                                    id: p.id,
                                    title: 'Hapus Bidang / PPK',
                                    message: 'Apakah Anda yakin ingin menghapus Bidang / PPK berikut dari SKPD ini?',
                                    targetName: `${p.name} (${skpd.abbreviation})`
                                });
                            });
                        }

                        tbody.appendChild(tr);
                    });
                }

                bootstrap.Modal.getOrCreateInstance(document.getElementById('managePpkModal')).show();
            }

            // =========================================================================
            // HANDLER BUKA MODAL TAMBAH / EDIT / HAPUS
            // =========================================================================
            function openAddPpkModal(skpdId = '') {
                document.getElementById('addPpkAlertContainer').className = 'd-none mb-3';
                document.getElementById('addPpkNameInput').value = '';
                document.getElementById('addPpkIsActive').value = '1';
                $('#addPpkSkpdSelect').val(skpdId ? String(skpdId) : '').trigger('change');
                bootstrap.Modal.getOrCreateInstance(document.getElementById('addPpkModal')).show();
            }

            function openEditPpkModal(ppk) {
                if (!ppk) return;
                document.getElementById('editPpkAlertContainer').className = 'd-none mb-3';
                document.getElementById('editPpkId').value = ppk.id;
                document.getElementById('editPpkNameInput').value = ppk.name || '';
                document.getElementById('editPpkIsActive').value = String(ppk.is_active ?? 1);
                $('#editPpkSkpdSelect').val(String(ppk.skpd_id)).trigger('change');

                const delBtn = document.getElementById('btnDeletePpkFromEditModal');
                if (delBtn) {
                    if (parseInt(ppk.rup_count || 0, 10) === 0) {
                        delBtn.classList.remove('d-none');
                        delBtn.onclick = () => {
                            bootstrap.Modal.getInstance(document.getElementById('editPpkModal'))?.hide();
                            openDeleteConfirmModal({
                                action: `/skpd-ppk/ppk/delete/${ppk.id}`,
                                id: ppk.id,
                                title: 'Hapus Bidang / PPK',
                                message: 'Apakah Anda yakin ingin menghapus Bidang / PPK ini?',
                                targetName: ppk.name
                            });
                        };
                    } else {
                        delBtn.classList.add('d-none');
                    }
                }

                bootstrap.Modal.getOrCreateInstance(document.getElementById('editPpkModal')).show();
            }

            function openEditSkpdModal(skpd) {
                if (!skpd) return;
                document.getElementById('editSkpdAlertContainer').className = 'd-none mb-3';
                document.getElementById('editSkpdId').value = skpd.id;
                document.getElementById('editSkpdName').value = skpd.name || '';
                document.getElementById('editSkpdAbbr').value = skpd.raw_abbr || '';
                document.getElementById('editSkpdCode').value = skpd.raw_code || '';
                document.getElementById('editSkpdContact').value = skpd.raw_contact || '';
                document.getElementById('editSkpdAddress').value = skpd.raw_address || '';
                document.getElementById('editSkpdIsActive').value = String(skpd.is_active ?? 1);
                bootstrap.Modal.getOrCreateInstance(document.getElementById('editSkpdModal')).show();
            }

            function openDeleteConfirmModal({ action, id, title, message, targetName }) {
                const form = document.getElementById('deleteConfirmForm');
                form.setAttribute('action', action);
                document.getElementById('deleteConfirmId').value = id;
                document.getElementById('deleteConfirmTitle').innerHTML = `<i class="fal fa-trash-alt me-2"></i>${escapeHtml(title)}`;
                document.getElementById('deleteConfirmMessage').textContent = message;
                document.getElementById('deleteConfirmTargetName').textContent = targetName;
                document.getElementById('deleteConfirmAlertContainer').className = 'd-none mb-3';
                bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteConfirmModal')).show();
            }

            // Tombol Header "+ Tambah PPK / Bidang"
            document.getElementById('btnOpenGlobalAddPpk')?.addEventListener('click', () => openAddPpkModal(''));

            // Delegasi klik pada tabel SKPD
            document.addEventListener('click', function (e) {
                const manageBtn = e.target.closest('.btn-manage-ppk');
                if (manageBtn) {
                    e.preventDefault();
                    const row = manageBtn.closest('tr.skpd-row');
                    if (row) {
                        openManagePpkModal(JSON.parse(row.getAttribute('data-skpd')));
                    }
                    return;
                }

                const quickAddBtn = e.target.closest('.btn-quick-add-ppk');
                if (quickAddBtn) {
                    e.preventDefault();
                    openAddPpkModal(quickAddBtn.getAttribute('data-skpd-id'));
                    return;
                }

                const chipBtn = e.target.closest('.btn-edit-ppk-chip');
                if (chipBtn) {
                    e.preventDefault();
                    openEditPpkModal(JSON.parse(chipBtn.getAttribute('data-ppk')));
                    return;
                }

                const editSkpdBtn = e.target.closest('.btn-edit-skpd');
                if (editSkpdBtn) {
                    e.preventDefault();
                    const row = editSkpdBtn.closest('tr.skpd-row');
                    if (row) {
                        openEditSkpdModal(JSON.parse(row.getAttribute('data-skpd')));
                    }
                    return;
                }

                const delSkpdBtn = e.target.closest('.btn-delete-skpd');
                if (delSkpdBtn) {
                    e.preventDefault();
                    const row = delSkpdBtn.closest('tr.skpd-row');
                    if (row) {
                        const s = JSON.parse(row.getAttribute('data-skpd'));
                        openDeleteConfirmModal({
                            action: `/skpd-ppk/skpd/delete/${s.id}`,
                            id: s.id,
                            title: 'Hapus Data SKPD',
                            message: 'Apakah Anda yakin ingin menghapus SKPD berikut secara permanen?',
                            targetName: `${s.abbreviation} - ${s.name}`
                        });
                    }
                }
            });

            // Inisialisasi tampilan tabel
            applyFilter();
        });
    </script>

</body>

</html>
