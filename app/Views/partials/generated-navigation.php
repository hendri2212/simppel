<ul id="js-nav-menu" class="nav-menu">

    <li class="nav-title"><span>Insights</span></li>

    <li class="nav-item">
        <a href="#" title="Dashboards" data-filter-tags>
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#trello"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Dashboards</span>
            <span class="badge bg-danger-700 badge-end">New</span>
        </a>

        <ul>
            <li>
                <a href="/dashboard-control-center">
                    <span class="nav-link-text" data-i18n>Control Center</span>
                </a>
            </li>
            <li>
                <a href="/dashboard-subscription">
                    <span class="nav-link-text" data-i18n>Subscription & Billing</span>
                </a>
            </li>
            <li>
                <a href="/dashboard-marketing">
                    <span class="nav-link-text" data-i18n>Marketing & Sales</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-title"><span>Perencanaan Pengadaan</span></li>

    <?php if ((int) session('role_id') !== 4 && strtoupper((string) session('role_name')) !== 'ADMIN ULP'): ?>
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
        </ul>
    </li>




    <li class="nav-title"><span>Design</span></li>

    <li class="nav-item">
        <a href="#" title="UI Components" data-filter-tags>
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#layers"></use>
            </svg>
            <span class="nav-link-text" data-i18n>UI Components</span>
        </a>

        <ul>
            <li>
                <a href="/ui-alerts">
                    <span class="nav-link-text" data-i18n>Alerts</span>
                </a>
            </li>
            <li>
                <a href="/ui-accordions">
                    <span class="nav-link-text" data-i18n>Accordions</span>
                </a>
            </li>
            <li>
                <a href="/ui-badges">
                    <span class="nav-link-text" data-i18n>Badges</span>
                </a>
            </li>
            <li>
                <a href="/ui-buttons">
                    <span class="nav-link-text" data-i18n>Buttons</span>
                </a>
            </li>
            <li>
                <a href="/ui-buttongroup">
                    <span class="nav-link-text" data-i18n>Button Group</span>
                </a>
            </li>
            <li>
                <a href="/ui-cards">
                    <span class="nav-link-text" data-i18n>Cards</span>
                </a>
            </li>
            <li>
                <a href="/ui-breadcrumbs">
                    <span class="nav-link-text" data-i18n>Breadcrumbs</span>
                </a>
            </li>
            <li>
                <a href="/ui-dropdowns">
                    <span class="nav-link-text" data-i18n>Dropdowns</span>
                </a>
            </li>
            <li>
                <a href="/ui-navbars">
                    <span class="nav-link-text" data-i18n>Navbars</span>
                </a>
            </li>
            <li>
                <a href="/ui-pagination">
                    <span class="nav-link-text" data-i18n>Pagination</span>
                </a>
            </li>
            <li>
                <a href="/ui-scrollspy">
                    <span class="nav-link-text" data-i18n>ScrollSpy</span>
                </a>
            </li>
            <li>
                <a href="/ui-collapse">
                    <span class="nav-link-text" data-i18n>Collapse</span>
                </a>
            </li>
            <li>
                <a href="/ui-tabs-pills">
                    <span class="nav-link-text" data-i18n>Tabs & Pills</span>
                </a>
            </li>
            <li>
                <a href="/ui-tooltips">
                    <span class="nav-link-text" data-i18n>Tooltips</span>
                </a>
            </li>
            <li>
                <a href="/ui-popovers">
                    <span class="nav-link-text" data-i18n>Popovers</span>
                </a>
            </li>
            <li>
                <a href="/ui-toasts">
                    <span class="nav-link-text" data-i18n>Toasts</span>
                </a>
            </li>
            <li>
                <a href="/ui-progressbars">
                    <span class="nav-link-text" data-i18n>Progress Bars</span>
                </a>
            </li>
            <li>
                <a href="/ui-spinners">
                    <span class="nav-link-text" data-i18n>Spinners</span>
                </a>
            </li>
            <li>
                <a href="/ui-carousels">
                    <span class="nav-link-text" data-i18n>Carousels</span>
                </a>
            </li>
            <li>
                <a href="/ui-panels">
                    <span class="nav-link-text" data-i18n>Panels</span>
                </a>
            </li>
            <li>
                <a href="/ui-list-filter">
                    <span class="nav-link-text" data-i18n>List Filter</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="#" title="System Utilities" data-filter-tags>
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#package"></use>
            </svg>
            <span class="nav-link-text" data-i18n>System Utilities</span>
        </a>

        <ul>
            <li>
                <a href="/utilities-borders">
                    <span class="nav-link-text" data-i18n>Borders</span>
                </a>
            </li>
            <li>
                <a href="/utilities-display-property">
                    <span class="nav-link-text" data-i18n>Display Property</span>
                </a>
            </li>
            <li>
                <a href="/utilities-responsivegrid">
                    <span class="nav-link-text" data-i18n>Responsive Grid</span>
                </a>
            </li>
            <li>
                <a href="/utilities-position">
                    <span class="nav-link-text" data-i18n>Position</span>
                </a>
            </li>
            <li>
                <a href="/utilities-colorpalette">
                    <span class="nav-link-text" data-i18n>Color Palette</span>
                </a>
            </li>
            <li>
                <a href="/utilities-typography">
                    <span class="nav-link-text" data-i18n>Typography</span>
                </a>
            </li>
            <li>
                <a href="/utilities-sizing">
                    <span class="nav-link-text" data-i18n>Sizing</span>
                </a>
            </li>
            <li>
                <a href="/utilities-spacing">
                    <span class="nav-link-text" data-i18n>Spacing</span>
                </a>
            </li>
            <li>
                <a href="/utilities-flexbox">
                    <span class="nav-link-text" data-i18n>Flexbox</span>
                </a>
            </li>
            <li>
                <a href="/utilities-helpers">
                    <span class="nav-link-text" data-i18n>Helpers</span>
                </a>
            </li>
            <li>
                <a href="/utilities-visibility-generator">
                    <span class="nav-link-text" data-i18n>Visibility Generator</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="#" title="Iconography" data-filter-tags>
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#heart"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Iconography</span>
        </a>

        <ul>
            <li>
                <a href="/icons-system">
                    <span class="nav-link-text" data-i18n>System Icons</span>
                </a>
            </li>
            <li>
                <a href="/icons-fontawesome">
                    <span class="nav-link-text" data-i18n>FontAwesome 5.3</span>
                </a>
            </li>
            <li>
                <a href="/icons-smartadmin">
                    <span class="nav-link-text" data-i18n>SmartAdmin Icons 1.0</span>
                </a>
            </li>
        </ul>
    </li>


    <li class="nav-item">
        <a href="#" title="Forms" data-filter-tags>
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#edit"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Forms</span>
        </a>

        <ul>
            <li>
                <a href="/forms-inputs">
                    <span class="nav-link-text" data-i18n>Inputs</span>
                </a>
            </li>
            <li>
                <a href="/forms-checkbox-radio">
                    <span class="nav-link-text" data-i18n>Checkbox & Radio</span>
                </a>
            </li>
            <li>
                <a href="/forms-groups">
                    <span class="nav-link-text" data-i18n>Groups</span>
                </a>
            </li>
            <li>
                <a href="/forms-validation">
                    <span class="nav-link-text" data-i18n>Validation</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-title"><span>Data Visualization</span></li>

    <li class="nav-item">
        <a href="#" title="Smart Tables" data-filter-tags>
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#database"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Smart Tables</span>
            <span class="badge bg-primary-500 badge-end">1.2.7</span>
        </a>

        <ul>
            <li>
                <a href="/smarttables-responsive">
                    <span class="nav-link-text" data-i18n>Responsive Settings</span>
                </a>
            </li>
            <li>
                <a href="/smarttables-importexport-data">
                    <span class="nav-link-text" data-i18n>Import & Export Data</span>
                </a>
            </li>
            <li>
                <a href="/smarttables-json-source">
                    <span class="nav-link-text" data-i18n>JSON Data Source</span>
                </a>
            </li>
            <li>
                <a href="/smarttables-manage-records">
                    <span class="nav-link-text" data-i18n>Manage Records</span>
                    <span class="badge bg-warning text-dark badge-end">New</span>
                </a>
            </li>
            <li>
                <a href="/smarttables-server-side">
                    <span class="nav-link-text" data-i18n>Server-Side Mode</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="#" title="Apex Charts" data-filter-tags>
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#pie-chart"></use>
            </svg>
            <span class="nav-link-text" data-i18n>Apex Charts</span>
        </a>

        <ul>
            <li>
                <a href="/apex-area">
                    <span class="nav-link-text" data-i18n>Area Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-bar">
                    <span class="nav-link-text" data-i18n>Bar Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-box-whisker">
                    <span class="nav-link-text" data-i18n>Box & Whisker Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-candlestick">
                    <span class="nav-link-text" data-i18n>Candlestick Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-column">
                    <span class="nav-link-text" data-i18n>Column Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-funnel">
                    <span class="nav-link-text" data-i18n>Funnel Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-line">
                    <span class="nav-link-text" data-i18n>Line Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-mixed-combo">
                    <span class="nav-link-text" data-i18n>Mixed/Combo Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-pie-donut">
                    <span class="nav-link-text" data-i18n>Pie/Donuts</span>
                </a>
            </li>
            <li>
                <a href="/apex-polar-area">
                    <span class="nav-link-text" data-i18n>Polar Area Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-radar">
                    <span class="nav-link-text" data-i18n>Radar Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-radialbars-circle">
                    <span class="nav-link-text" data-i18n>RadialBars/Circle Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-range-area">
                    <span class="nav-link-text" data-i18n>Range Area Charts</span>
                </a>
            </li>
            <li>
                <a href="/apex-sparkline">
                    <span class="nav-link-text" data-i18n>Sparklines</span>
                </a>
            </li>
            <li>
                <a href="/apex-timeline">
                    <span class="nav-link-text" data-i18n>Timeline Charts</span>
                </a>
            </li>
        </ul>
    </li>


    <li>
        <a href="/fullcalendar">
            <svg class="sa-icon">
                <use href="/icons/sprite.svg#calendar"></use>
            </svg>
            <span class="nav-link-text">Full Calendar</span>
        </a>
    </li>
</ul>