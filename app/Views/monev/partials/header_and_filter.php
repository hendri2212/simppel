<?php
/**
 * Partial: Navigasi Antar-Modul e-MONEV + Panel Filter Terpadu
 *
 * Variabel yang diharapkan:
 * - $moduleKey  : 'index' | 'satu' | 'dua' | 'tiga' | 'empat' | 'lima' | 'enam' | 'tujuh' | 'delapan'
 * - $modules    : array daftar 8 modul beserta flag 'allowed'
 * - $filters    : array hasil MonevController::resolveFilters()
 * - $showSearch : bool (tampilkan kolom cari nama paket/RUP)
 * - $showJenis  : bool (tampilkan dropdown jenis pengadaan)
 * - $showPokja  : bool (tampilkan dropdown personil pokja untuk modul 4)
 * - $showExport : bool (tampilkan tombol Export PDF & Export Excel)
 */
$moduleKey  = $moduleKey ?? 'index';
$modules    = $modules ?? [];
$filters    = $filters ?? [];
$showSearch = $showSearch ?? true;
$showJenis  = $showJenis ?? true;
$showPokja  = $showPokja ?? false;
$showExport = $showExport ?? true;
$pokjaUsers = $pokjaUsers ?? [];

$currentQuery = $_GET ?? [];
$pdfQuery     = array_merge($currentQuery, ['export' => 'pdf']);
$excelQuery   = array_merge($currentQuery, ['export' => 'excel']);
$currentPath  = current_url(true)->getPath();
?>

<style>
    /* Styling Responsif & Modern Web Guidance (responsive-table) untuk e-MONEV */
    .monev-table-region {
        overflow-x: auto;
        max-height: 72vh;
        -webkit-overflow-scrolling: touch;
        border-radius: 0.5rem;
    }
    .monev-table-region:focus-visible {
        outline: 2px solid var(--bs-primary, #2563eb);
        outline-offset: 2px;
    }
    .table-monev {
        margin-bottom: 0;
        font-size: 0.84rem;
    }
    .table-monev thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background-color: var(--bs-tertiary-bg, #f8fafc);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 700;
        white-space: nowrap;
        border-bottom: 2px solid var(--bs-border-color, #dee2e6);
    }
    .monev-module-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
    }
    .monev-pill-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.75rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid var(--bs-border-color, #dee2e6);
        background-color: var(--bs-body-bg, #fff);
        color: var(--bs-body-color, #334155);
        transition: all 0.15s ease;
    }
    .monev-pill-link:hover {
        border-color: var(--bs-primary, #2563eb);
        color: var(--bs-primary, #2563eb);
        background-color: var(--bs-primary-bg-subtle, #eff6ff);
    }
    .monev-pill-link.active {
        background-color: var(--bs-primary, #2563eb);
        border-color: var(--bs-primary, #2563eb);
        color: #fff !important;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .monev-pill-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        font-size: 0.68rem;
        background: rgba(0, 0, 0, 0.08);
    }
    .monev-pill-link.active .monev-pill-num {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
    }
</style>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3" role="alert">
        <div class="d-flex align-items-center gap-2">
            <svg class="sa-icon text-danger flex-shrink-0" style="width: 18px; height: 18px;">
                <use href="/icons/sprite.svg#alert-circle"></use>
            </svg>
            <div><?= esc(session()->getFlashdata('error')) ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Navigasi Cepat Antar Modul e-MONEV -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="monev-module-pills">
            <a href="/monev" class="monev-pill-link <?= $moduleKey === 'index' ? 'active' : '' ?>">
                <svg class="sa-icon" style="width: 14px; height: 14px;">
                    <use href="/icons/sprite.svg#grid"></use>
                </svg>
                <span>Dashboard e-MONEV</span>
            </a>
            <?php foreach ($modules as $mKey => $mMeta): ?>
                <?php if (! empty($mMeta['allowed'])): ?>
                    <a href="<?= esc($mMeta['url'] . (! empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '')) ?>"
                       class="monev-pill-link <?= $moduleKey === $mKey ? 'active' : '' ?>"
                       title="<?= esc($mMeta['subtitle']) ?>">
                        <span class="monev-pill-num"><?= (int) $mMeta['number'] ?></span>
                        <span><?= esc($mMeta['title']) ?></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                Role: <?= esc($filters['role_name'] ?: 'USER') ?>
            </span>
            <?php if (! empty($filters['is_skpd_locked'])): ?>
                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1" title="Cakupan data dikunci khusus SKPD Anda">
                    SKPD Terkunci
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Panel Filter & Tombol Export -->
<?php
// Mode filter lengkap (memiliki filter Jenis Pengadaan / Pokja / Pencarian)
// menggunakan layout 2 baris simetris agar 4 tombol aksi di kanan tidak terpotong/turun berantakan.
$isDetailedFilter = ($showJenis || $showPokja || $showSearch);

if ($isDetailedFilter) {
    $skpdColClass  = $showPokja ? 'col-12 col-md-6 col-xl-4' : 'col-12 col-md-4 col-xl-5';
    $tahunColClass = $showPokja ? 'col-6 col-md-2 col-xl-1'  : 'col-6 col-md-2 col-xl-2';
    $jenisColClass = $showPokja ? 'col-6 col-md-4 col-xl-2'  : 'col-6 col-md-3 col-xl-3';
    $dakColClass   = $showPokja ? 'col-6 col-md-6 col-xl-2'  : 'col-12 col-md-3 col-xl-2';
    $pokjaColClass = 'col-6 col-md-6 col-xl-3';
} else {
    $skpdColClass  = 'col-12 col-md-6 col-lg';
    $tahunColClass = 'col-6 col-md-3 col-lg-2';
    $dakColClass   = 'col-6 col-md-3 col-lg-2';
}
?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= esc($currentPath) ?>" class="row g-2 align-items-end">
            <!-- Dinas / Instansi -->
            <div class="<?= $skpdColClass ?>">
                <label class="form-label fs-xs fw-bold text-uppercase text-muted mb-1">Dinas / Instansi (SKPD)</label>
                <?php if (! empty($filters['is_skpd_locked'])): ?>
                    <input type="hidden" name="skpd_id" value="<?= (int) $filters['skpd_id'] ?>">
                    <input type="text" class="form-control form-control-sm bg-body-secondary fw-semibold" value="<?= esc($filters['selected_skpd_name']) ?>" readonly>
                <?php else: ?>
                    <select name="skpd_id" class="form-select form-select-sm">
                        <option value="0">-- SEMUA INSTANSI --</option>
                        <?php foreach ($filters['skpd_list'] as $s): ?>
                            <option value="<?= (int) $s['id'] ?>" <?= (int) $filters['skpd_id'] === (int) $s['id'] ? 'selected' : '' ?>>
                                <?= esc($s['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>

            <!-- Tahun Anggaran -->
            <div class="<?= $tahunColClass ?>">
                <label class="form-label fs-xs fw-bold text-uppercase text-muted mb-1">Tahun</label>
                <select name="tahun" class="form-select form-select-sm">
                    <?php foreach ($filters['available_years'] as $yr): ?>
                        <option value="<?= (int) $yr ?>" <?= (int) $filters['tahun'] === (int) $yr ? 'selected' : '' ?>>
                            <?= (int) $yr ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Jenis Pengadaan -->
            <?php if ($showJenis): ?>
                <div class="<?= $jenisColClass ?>">
                    <label class="form-label fs-xs fw-bold text-uppercase text-muted mb-1">Jenis Pengadaan</label>
                    <select name="jenis_pengadaan_id" class="form-select form-select-sm">
                        <option value="0">-- SEMUA JENIS --</option>
                        <?php foreach ($filters['jenis_pengadaan'] as $jp): ?>
                            <option value="<?= (int) $jp['id'] ?>" <?= (int) $filters['jenis_pengadaan_id'] === (int) $jp['id'] ? 'selected' : '' ?>>
                                <?= esc($jp['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- DAK / Non-DAK -->
            <div class="<?= $dakColClass ?>">
                <label class="form-label fs-xs fw-bold text-uppercase text-muted mb-1">DAK / Non-DAK</label>
                <select name="jenis_dak_id" class="form-select form-select-sm">
                    <option value="0">-- SEMUA --</option>
                    <?php foreach ($filters['jenis_dak'] as $jd): ?>
                        <option value="<?= (int) $jd['id'] ?>" <?= (int) $filters['jenis_dak_id'] === (int) $jd['id'] ? 'selected' : '' ?>>
                            <?= esc($jd['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filter Personil Pokja (Khusus Modul 4) -->
            <?php if ($showPokja): ?>
                <div class="<?= $pokjaColClass ?>">
                    <label class="form-label fs-xs fw-bold text-uppercase text-muted mb-1">Anggota Pokja</label>
                    <?php if (! empty($filters['is_pokja_locked'])): ?>
                        <input type="hidden" name="pokja_user_id" value="<?= (int) $filters['pokja_user_id'] ?>">
                        <input type="text" class="form-control form-control-sm bg-body-secondary fw-semibold" value="<?= esc($filters['actor']['full_name'] ?: 'Pokja Aktif') ?>" readonly>
                    <?php else: ?>
                        <select name="pokja_user_id" class="form-select form-select-sm">
                            <option value="0">-- SEMUA POKJA --</option>
                            <?php foreach ($pokjaUsers as $pu): ?>
                                <option value="<?= (int) $pu['id'] ?>" <?= (int) $filters['pokja_user_id'] === (int) $pu['id'] ? 'selected' : '' ?>>
                                    <?= esc($pu['full_name'] ?: $pu['username']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($isDetailedFilter): ?>
                <!-- Pemisah baris paksa pada layar besar agar Baris 2 (Search + 4 Button) rapi & sejajar penuh -->
                <div class="w-100 d-none d-xl-block m-0"></div>
            <?php endif; ?>

            <!-- Pencarian Nama Paket / Kode RUP -->
            <?php if ($showSearch): ?>
                <div class="col-12 col-lg">
                    <label class="form-label fs-xs fw-bold text-uppercase text-muted mb-1">Nama Paket / Kode RUP</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-body-tertiary text-muted">
                            <svg class="sa-icon" style="width: 14px; height: 14px;">
                                <use href="/icons/sprite.svg#search"></use>
                            </svg>
                        </span>
                        <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari nama paket atau kode RUP..." value="<?= esc($filters['q']) ?>">
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tombol Aksi Filter & Export -->
            <div class="col-12 col-lg-auto ms-lg-auto d-flex flex-wrap align-items-center justify-content-end gap-2 pt-1 pt-lg-0">
                <button type="submit" class="btn btn-primary btn-sm px-3 d-inline-flex align-items-center gap-1 text-nowrap">
                    <svg class="sa-icon" style="width: 14px; height: 14px;">
                        <use href="/icons/sprite.svg#filter"></use>
                    </svg>
                    <span>Tampilkan</span>
                </button>
                <a href="<?= esc($currentPath) ?>" class="btn btn-outline-secondary btn-sm px-3 text-nowrap" title="Reset Filter">
                    Reset
                </a>

                <?php if ($showExport): ?>
                    <span class="vr d-none d-sm-inline-block mx-1 my-1 opacity-25"></span>
                    <a href="<?= esc($currentPath . '?' . http_build_query($pdfQuery)) ?>" target="_blank"
                       class="btn btn-danger btn-sm px-3 d-inline-flex align-items-center gap-1 text-nowrap" title="Cetak / Export PDF">
                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#printer"></use>
                        </svg>
                        <span>Export PDF</span>
                    </a>
                    <a href="<?= esc($currentPath . '?' . http_build_query($excelQuery)) ?>"
                       class="btn btn-success btn-sm px-3 d-inline-flex align-items-center gap-1 text-nowrap" title="Download Microsoft Excel (.xls)">
                        <svg class="sa-icon" style="width: 14px; height: 14px;">
                            <use href="/icons/sprite.svg#download"></use>
                        </svg>
                        <span>Export Excel</span>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
