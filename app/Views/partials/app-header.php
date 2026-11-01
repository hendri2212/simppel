<header class="app-header">
    <!-- Collapse icon -->
    <div class="d-flex flex-grow-1 w-100 me-auto align-items-center">

        <!-- App logo -->
        <?= $this->include('partials/app-logo') ?>

        <button class="mobile-menu-icon me-2 d-flex d-sm-flex d-md-flex d-lg-none flex-shrink-0" data-action="toggle-swap" data-toggleclass="app-mobile-menu-open" aria-label="Toggle Mobile Menu">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#menu"></use>
            </svg>
        </button>

        <!-- Collapse icon -->
        <button type="button" class="collapse-icon me-3 d-none d-lg-inline-flex d-xl-inline-flex d-xxl-inline-flex" data-action="toggle" data-class="set-nav-minified" aria-label="Toggle Navigation Size">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5 8">
                <polygon fill="#878787" points="4.5,1 3.8,0.2 0,4 3.8,7.8 4.5,7 1.5,4" />
            </svg>
        </button>

        <form class="app-search" role="search" action="/search" autocomplete="off">
            <input type="text" class="form-control" placeholder="Search for anything">
        </form>
    </div>

    <!-- Settings -->
    <button type="button" class="btn btn-system hidden-mobile" data-action="toggle-swap" data-toggleclass="open" data-target="aside.js-drawer-settings" aria-label="Open Settings">
        <svg class="sa-icon sa-icon-2x">
            <use href="/icons/sprite.svg#settings"></use>
        </svg>
    </button>

    <!-- Theme modes -->
    <button type="button" class="btn btn-system" data-action="toggle-theme" aria-label="Toggle Dark Mode" aria-pressed="false">
        <svg class="sa-icon sa-icon-2x sa-mode-light">
            <use href="/icons/sprite.svg#sun"></use>
        </svg>
        <svg class="sa-icon sa-icon-2x sa-mode-dark">
            <use href="/icons/sprite.svg#moon"></use>
        </svg>
    </button>


    <!-- Full Screen Mode -->
    <button type="button" class="btn btn-system d-none d-sm-block d-sm-none d-md-none d-lg-block" data-action="app-fullscreen" aria-label="Toggle Dark Mode" aria-pressed="false">
        <svg class="sa-icon sa-icon-2x sa-fullscreen-on">
            <use href="/icons/sprite.svg#minimize"></use>
        </svg>
        <svg class="sa-icon sa-icon-2x sa-fullscreen-off">
            <use href="/icons/sprite.svg#maximize"></use>
        </svg>
    </button>


    <!-- Profile -->
    <button type="button" data-bs-toggle="dropdown" title="drlantern@getwebora.com" class="btn-system bg-transparent d-flex flex-shrink-0 align-items-center justify-content-center" aria-label="Open Profile Dropdown">
        <img src="/img/demo/avatars/avatar-admin.png" class="profile-image profile-image-md rounded-circle" alt="Sunny A.">
    </button>

    <!-- Profile dropdown -->
    <div class="dropdown-menu dropdown-menu-animated">
        <div class="notification-header rounded-top mb-2">
            <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                <span class="status status-success d-inline-block me-2">
                    <img src="/img/demo/avatars/avatar-admin.png" class="profile-image rounded-circle" alt="Sunny A.">
                </span>
                <div class="info-card-text">
                    <div class="fs-lg text-truncate text-truncate-lg"><?= esc(session('full_name') ?? 'Administrator') ?></div>
                    <span class="text-truncate text-truncate-md opacity-80 fs-sm"><?= esc(session('email') ?? 'admin@simpple.com') ?></span>
                </div>
            </div>
        </div>

        <div class="dropdown-divider m-0"></div>

        <a href="#" class="dropdown-item" data-action="app-reset" role="button">
            <span data-i18n="drpdwn.reset_layout">Reset Layout</span>
        </a>
        <a href="#" class="dropdown-item" data-action="toggle-swap" data-toggleclass="open" data-target="aside.js-drawer-settings" role="button">
            <span data-i18n="drpdwn.settings">Settings</span>
        </a>

        <div class="dropdown-divider m-0"></div>

        <form action="/logout" method="POST" class="m-0">
            <?= csrf_field() ?>
            <button type="submit" class="dropdown-item py-3 fw-500 d-flex justify-content-between">
                <span class="text-danger" data-i18n="drpdwn.page-logout">Logout</span>
                <span class="d-block text-truncate text-truncate-sm">@<?= esc(session('username') ?? 'admin') ?></span>
            </button>
        </form>
    </div>
</header>