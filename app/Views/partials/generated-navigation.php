<ul id="js-nav-menu" class="nav-menu">

    <li class="nav-title"><span>Insights</span></li>

    <li>
        <a href="/dashboard-control-center" title="Dashboard" data-filter-tags="dashboard insights">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#trello"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Dashboard</span>
        </a>
    </li>

    <li class="nav-title"><span>Perencanaan Pengadaan</span></li>

    <?php
    $navRoleId   = (int) session('role_id');
    $navRoleName = strtoupper(trim((string) session('role_name')));
    $isNavAdminUlp = ($navRoleId === 4 || $navRoleName === 'ADMIN ULP');
    $isNavPpkSide  = in_array($navRoleId, [2, 3], true) || in_array($navRoleName, ['ADMIN PPK', 'PPK'], true);
    ?>

    <?php if (! $isNavAdminUlp): ?>
    <li>
        <a href="/rup" title="Daftar RUP" data-filter-tags="perencanaan pengadaan rup daftar">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#file-text"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Daftar RUP</span>
        </a>
    </li>
    <?php endif; ?>

    <li>
        <a href="/paket" title="Daftar Paket" data-filter-tags="perencanaan pengadaan paket daftar">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#package"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Daftar Paket</span>
        </a>
    </li>

    <li>
        <a href="/rup/summary" title="Rekapitulasi Pagu" data-filter-tags="perencanaan pengadaan rup rekapitulasi pagu anggaran">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#bar-chart-2"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Rekapitulasi Pagu</span>
        </a>
    </li>

    <li class="nav-title"><span>e-MONEV</span></li>

    <li>
        <a href="/monev" title="Dashboard e-MONEV" data-filter-tags="emonev e-monev monitoring evaluasi dashboard">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#grid"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Dashboard e-MONEV</span>
        </a>
    </li>

    <li>
        <a href="/monev/rup" title="RUP (Paket Lelang)" data-filter-tags="emonev rup paket lelang satu">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#file-text"></use>
            </svg>
            <span class="nav-link-text" data-i18n>RUP (Paket Lelang)</span>
        </a>
    </li>

    <li>
        <a href="/monev/belum-masuk" title="Paket Lelang Belum Masuk" data-filter-tags="emonev paket belum masuk dua">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#clock"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Paket Belum Masuk</span>
        </a>
    </li>

    <li>
        <a href="/monev/rekap" title="Rekap Paket Data Lelang" data-filter-tags="emonev rekap paket data lelang tiga">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#layers"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Rekap Data Lelang</span>
        </a>
    </li>

    <?php if (! $isNavPpkSide): ?>
    <li>
        <a href="/monev/distribusi-pokja" title="Distribusi Pokja ULP" data-filter-tags="emonev distribusi pokja ulp empat">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#users"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Distribusi Pokja ULP</span>
        </a>
    </li>
    <?php endif; ?>

    <li>
        <a href="/monev/daftar-paket" title="Daftar Paket Lelang" data-filter-tags="emonev daftar paket lelang lima">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#list"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Daftar Paket Lelang</span>
        </a>
    </li>

    <li>
        <a href="/monev/grafik" title="Grafik Lelang" data-filter-tags="emonev grafik lelang enam">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#pie-chart"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Grafik Lelang</span>
        </a>
    </li>

    <li>
        <a href="/monev/paket-selesai" title="Paket Lelang Selesai" data-filter-tags="emonev paket lelang selesai tujuh">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#check-circle"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Paket Lelang Selesai</span>
        </a>
    </li>

    <li>
        <a href="/monev/paket-proses" title="Paket Lelang Dalam Proses" data-filter-tags="emonev paket dalam proses delapan">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#activity"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Paket Dalam Proses</span>
        </a>
    </li>


    <?php if ((int) session('role_id') === 1 || strtoupper((string) session('role_name')) === 'ADMINISTRATOR'): ?>
    <li class="nav-title"><span>User Management</span></li>

    <li>
        <a href="/accounts" title="Accounts" data-filter-tags="user management account accounts users">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#users"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Accounts</span>
        </a>
    </li>

    <li>
        <a href="/skpd-ppk" title="SKPD & PPK" data-filter-tags="user management master skpd ppk bidang instansi">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#briefcase"></use>
            </svg>
            <span class="nav-link-text" data-i18n>SKPD &amp; PPK</span>
        </a>
    </li>
    <?php endif; ?>

    <li class="nav-title"><span>Layouts</span></li>

    <li class="nav-item">
        <a href="#" title="Access Control" data-filter-tags>
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#slash"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Access Control</span>
        </a>

        <ul>
            <li>
                <a href="/profile">
                    <span class="nav-link-text" data-i18n>User Profile</span>
                </a>
            </li>
            <li>
                <a href="/utilities-colorpalette">
                    <span class="nav-link-text" data-i18n>Color Palette</span>
                </a>
            </li>
        </ul>
    </li>


</ul>