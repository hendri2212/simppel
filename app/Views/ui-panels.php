<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Panels")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Panels", "pageSubTitle1" => "Design", "pageSubTitle2" => "UI Components", "pageSubText" => "Panels can be used in almost any situation, helping wrap everything in a slick & lightweight container.")) ?>

                    <div class="main-content" >
                        <div class="info-container">
                            <p>
                                Display data, tables, forms, or images effortlessly with our <strong>lightweight, clean, and highly customizable panels</strong>.
                                Expand to fullscreen, collapse, or close as needed. Equiped with many <strong>interactive features</strong>, a versatile design, these panels adapt to your workflow seamlessly.
                                <strong>Auto-save keeps your layout intact</strong>, while <strong>SortableJS</strong> lets you drag and organize panels seamlessly.
                                Need to print? Just switch to fullscreen for a perfect view. All panels can be reset to their default state by clicking the button below.
                            </p>
                            <p class="m-0">
                                <button type="button" onclick="resetPanelState();" class="btn btn-outline-secondary">↻ Reset Panel States</button>
                            </p>
                        </div>
                        <div class="row" id="sortable-grid">
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <!--Default panel-->
                                <div id="panel-1" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Blank <span class="fw-light"><i>Panel</i></span>
                                        </h2>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                All panels needs to have an unique ID in order to use the panel sorting funtions.
                                            </div>
                                            <p class="mb-0">Panel content goes here...</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Collapsed panel-->
                                <div id="panel-2" class="panel panel-icon panel-collapsed">
                                    <div class="panel-hdr">
                                        <h2>
                                            Collapsed <span class="fw-light"><i>Panel</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                This panel is closed by default. To close a panel we add the class <code>.panel-collapsed</code> to <code>.panel</code>
                                            </div>
                                            <p class="mb-0">
                                                Default panel text.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--Collapsable panel-->
                                <div id="panel-3" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Collapsable <span class="fw-light"><i>Panel</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Panel is closed by using the attribute <code>data-action="panel-collapse"</code>, and can be placed anywhere inside <code>.panel</code>
                                            </div>
                                            <p>
                                                You can also place the collapse action inside the <code>.panel-content</code> as button or link
                                            </p>
                                            <button type="button" data-action="panel-collapse" class="btn btn-success me-2">collapse button</button>
                                            <a href="javascript:void(0);" data-action="panel-collapse" class="text-success">collapse link</a>
                                        </div>
                                    </div>
                                </div>
                                <!--Fullscreen panel-->
                                <div id="panel-4" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Fullscreen <span class="fw-light"><i>Panel</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Panel is closed by using the attribute <code>data-action="panel-fullscreen"</code>, and can be placed anywhere inside <code>.panel</code>
                                            </div>
                                            <p>
                                                You can also place the collapse action inside the <code>.panel-content</code> as button or link
                                            </p>
                                            <button type="button" data-action="panel-fullscreen" class="btn btn-warning me-2">fullscreen button</button>
                                            <a href="javascript:void(0);" data-action="panel-fullscreen" class="text-warning">fullscreen link</a>
                                        </div>
                                    </div>
                                </div>
                                <!--Close panel-->
                                <div id="panel-5" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Close <span class="fw-light"><i>Panel</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Panel is closed by using the attribute <code>data-action="panel-close"</code>, and can be placed anywhere inside <code>.panel</code>
                                            </div>
                                            <p>
                                                You can also place the collapse action inside the <code>.panel-content</code> as button or link
                                            </p>
                                            <button type="button" data-action="panel-close" class="btn btn-danger me-2">close button</button>
                                            <a href="javascript:void(0);" data-action="panel-close" class="text-danger">close link</a>
                                        </div>
                                    </div>
                                </div>
                                <!--Panel colors-->
                                <div id="panel-6" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Panel <span class="fw-light"><i>Colors</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                You can mix and match any color styles, below is what we were found to be an interesting match.
                                            </div>
                                            <div class="d-flex flex-wrap justify-content-evenly gap-2 mb-3">
                                                <button type="button" class="btn d-inline-block bg-primary-700 bg-success-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-700 bg-success-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-primary-500 bg-info-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-500 bg-info-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-primary-600 bg-primary-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-600 bg-primary-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-info-600 bg-primray-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-600 bg-primray-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-info-600 bg-info-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-600 bg-info-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-info-700 bg-success-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-700 bg-success-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-success-900 bg-info-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-900 bg-info-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-success-700 bg-primary-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-700 bg-primary-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-success-600 bg-success-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-600 bg-success-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-danger-900 bg-info-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-danger-900 bg-info-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-success-500 bg-danger-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-500 bg-danger-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-success-300 bg-warning-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-300 bg-warning-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-success-200 bg-fusion-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-200 bg-fusion-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-primary-800 bg-danger-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-800 bg-danger-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-primary-400 bg-warning-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-400 bg-warning-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-primary-300 bg-fusion-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-300 bg-fusion-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-info-500 bg-danger-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-500 bg-danger-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-info-800 bg-warning-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-800 bg-warning-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-info-200 bg-success-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-200 bg-success-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-danger-700 bg-primary-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-danger-700 bg-primary-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-danger-500 bg-info-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-danger-500 bg-info-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-danger-300 bg-success-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-danger-300 bg-success-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-warning-700 bg-primary-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-warning-700 bg-primary-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-warning-500 bg-info-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-warning-500 bg-info-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-warning-300 bg-danger-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-warning-300 bg-danger-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-faded bg-primary-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-faded bg-primary-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-faded bg-info-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-faded bg-info-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-faded bg-danger-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-faded bg-danger-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-fusion-400 bg-fusion-gradient width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-fusion-400 bg-fusion-gradient"></button>
                                                <button type="button" class="btn d-inline-block bg-faded width-3 height-3 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-faded"></button>

                                            </div>
                                            <div class="d-flex pt-3">
                                                <button type="button" class="btn btn-outline-secondary" data-action="panel-reset">
                                                    Reset Styles
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Master button-->
                                <div id="panel-7" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Master <span class="fw-light"><i>Button</i></span>
                                        </h2>

                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- master button needs to be the last child in .panel-hdr -->
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-toolbar-master px-0" data-bs-toggle="dropdown">
                                                <i class="ellipsis-icon"></i>
                                            </button>
                                            <!-- included a wrapper here to make the dropdown menu animate and also respond to hitting edges -->
                                            <div class="dropdown-menu-animated">
                                                <div class="dropdown-menu dropdown-menu-end rounded-top rounded-bottom">
                                                    <button type="button" class="dropdown-item" data-action="panel-refresh" data-refresh-duration="2000" data-refresh-callback="updatePanelContent"><span data-i18n="drpdwn.refreshpanel">Refresh Content</span></button>
                                                    <button type="button" class="dropdown-item" data-action="panel-toggle" data-panel-toggle="panel-locked">
                                                        <span data-i18n="drpdwn.lockpanel" class="panel-locked-text">Unlock panel</span>
                                                        <span data-i18n="drpdwn.unlockpanel" class="panel-unlock-text">Lock panel</span>
                                                    </button>
                                                    <div class="dropdown-multilevel dropdown-multilevel-left">
                                                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                                                            <span data-i18n="drpdwn.panelcolor">Panel Style</span>
                                                            <i class="sa sa-chevron-right"></i>
                                                        </div>
                                                        <div class="dropdown-menu">
                                                            <div class="d-flex flex-wrap align-items-center justify-content-center px-2 py-1 width-sm gap-1">
                                                                <button type="button" class="btn d-inline-block bg-primary-700 bg-success-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-700 bg-success-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-primary-500 bg-info-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-500 bg-info-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-primary-600 bg-primary-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-600 bg-primary-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-info-600 bg-primray-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-600 bg-primray-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-info-600 bg-info-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-600 bg-info-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-info-700 bg-success-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-700 bg-success-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-success-900 bg-info-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-900 bg-info-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-success-700 bg-primary-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-700 bg-primary-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-success-600 bg-success-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-600 bg-success-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-danger-900 bg-info-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-danger-900 bg-info-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-fusion-400 bg-fusion-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-fusion-400 bg-fusion-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-faded width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-faded"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-multilevel dropdown-multilevel-left">
                                                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                                                            <span data-i18n="drpdwn.actions">Actions</span>
                                                            <i class="sa sa-chevron-right"></i>
                                                        </div>
                                                        <div class="dropdown-menu">
                                                            <button type="button" class="dropdown-item px-3" data-action="panel-collapse">
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon sa-icon-success me-2">
                                                                        <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                                        <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                                    </svg>
                                                                    Toggle
                                                                </div>
                                                            </button>
                                                            <button type="button" class="dropdown-item px-3" data-action="panel-fullscreen">
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon sa-icon-warning me-2">
                                                                        <use href="/icons/sprite.svg#stop-circle"></use>
                                                                    </svg>
                                                                    Fullscreen
                                                                </div>
                                                            </button>
                                                            <button type="button" class="dropdown-item px-3 text-danger" data-action="panel-close">
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon sa-icon-danger me-2">
                                                                        <use href="/icons/sprite.svg#x-circle"></use>
                                                                    </svg>
                                                                    Close
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="dropdown-item"><span data-i18n="drpdwn.custombutton">Custom Button</span></button>
                                                    <button type="button" class="dropdown-item" data-action="panel-toggle" data-panel-toggle="panel-icon">
                                                        <span data-i18n="drpdwn.iconstyle">Icon Style</span>
                                                    </button>
                                                    <div class="dropdown-divider m-0"></div>
                                                    <button type="button" class="dropdown-item fw-500 text-danger" data-action="panel-reset">
                                                        <span data-i18n="drpdwn.resetpanel">Reset Panel</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                The <code>.btn-toolbar-master</code> class enhances <code>.panel-toolbar</code> by integrating dropdown functionality and additional actions while optimizing space.
                                                It supports icons, grouped actions, submenus, and input fields, making panels more interactive and organized.
                                            </div>
                                            <div class="d-flex">
                                                <div class="dropdown-menu dropdown-menu-end rounded-top rounded-bottom show position-relative border" style="box-shadow:none; width: 10rem;">
                                                    <button type="button" class="dropdown-item" data-action="panel-refresh" data-refresh-duration="2000" data-refresh-callback="updatePanelContent"><span data-i18n="drpdwn.refreshpanel">Refresh Content</span></button>
                                                    <button type="button" class="dropdown-item" data-action="panel-toggle" data-panel-toggle="panel-locked">
                                                        <span data-i18n="drpdwn.lockpanel" class="panel-locked-text">Unlock panel</span>
                                                        <span data-i18n="drpdwn.unlockpanel" class="panel-unlock-text">Lock panel</span>
                                                    </button>
                                                    <div class="dropdown-multilevel dropdown-multilevel-right">
                                                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                                                            <span data-i18n="drpdwn.panelcolor">Panel Style</span>
                                                            <i class="sa sa-chevron-right"></i>
                                                        </div>
                                                        <div class="dropdown-menu">
                                                            <div class="d-flex flex-wrap align-items-center justify-content-center px-2 py-1 width-sm gap-1">
                                                                <button type="button" class="btn d-inline-block bg-primary-700 bg-success-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-700 bg-success-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-primary-500 bg-info-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-500 bg-info-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-primary-600 bg-primary-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-primary-600 bg-primary-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-info-600 bg-primray-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-600 bg-primray-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-info-600 bg-info-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-600 bg-info-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-info-700 bg-success-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-info-700 bg-success-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-success-900 bg-info-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-900 bg-info-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-success-700 bg-primary-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-700 bg-primary-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-success-600 bg-success-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-success-600 bg-success-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-danger-900 bg-info-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-danger-900 bg-info-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-fusion-400 bg-fusion-gradient width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-fusion-400 bg-fusion-gradient"></button>
                                                                <button type="button" class="btn d-inline-block bg-faded width-2 height-2 p-0 rounded-0 hover-effect-dot" data-action="panel-style" data-panel-style="bg-faded"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-multilevel dropdown-multilevel-right">
                                                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                                                            <span data-i18n="drpdwn.actions">Actions</span>
                                                            <i class="sa sa-chevron-right"></i>
                                                        </div>
                                                        <div class="dropdown-menu">
                                                            <button type="button" class="dropdown-item px-3" data-action="panel-collapse">
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon sa-icon-success me-2">
                                                                        <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                                        <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                                    </svg>
                                                                    Toggle
                                                                </div>
                                                            </button>
                                                            <button type="button" class="dropdown-item px-3" data-action="panel-fullscreen">
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon sa-icon-warning me-2">
                                                                        <use href="/icons/sprite.svg#stop-circle"></use>
                                                                    </svg>
                                                                    Fullscreen
                                                                </div>
                                                            </button>
                                                            <button type="button" class="dropdown-item px-3 text-danger" data-action="panel-close">
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon sa-icon-danger me-2">
                                                                        <use href="/icons/sprite.svg#x-circle"></use>
                                                                    </svg>
                                                                    Close
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="dropdown-item"><span data-i18n="drpdwn.custombutton">Custom Button</span></button>
                                                    <button type="button" class="dropdown-item" data-action="panel-toggle" data-panel-toggle="panel-icon">
                                                        <span data-i18n="drpdwn.iconstyle">Icon Style</span>
                                                    </button>
                                                    <div class="dropdown-divider m-0"></div>
                                                    <button type="button" class="dropdown-item fw-500 text-danger" data-action="panel-reset">
                                                        <span data-i18n="drpdwn.resetpanel">Reset Panel</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="js-refreshed-content badge bg-primary"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <!--Panel label-->
                                <div id="panel-8" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Label <span class="fw-light"><i>Panel</i></span>
                                            <sup>
                                                <span class="badge text-bg-warning ms-2">
                                                    sup
                                                </span>
                                            </sup>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <div class="panel-toolbar">
                                                <span class="badge text-bg-primary fw-400">
                                                    Panel Badge
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                You may place badge inside <code>.panel-toolbar</code>, <code>.panel-content</code> and <code>.panel-hdr</code>.
                                                Check out the <a href="/badges" target="_blank">badges page</a> to learn more about badges
                                            </div>
                                        </div>
                                        <!-- panel footer with utility classes -->
                                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex" style="gap: 5px;">
                                            <span class="badge text-bg-danger">
                                                Footer badge
                                            </span>
                                            <span class="badge rounded-pill text-bg-success">
                                                Pill badge
                                            </span>
                                            <span class="badge rounded-pill rounded-circle text-bg-secondary ms-auto">
                                                1
                                            </span>
                                            <span class="badge text-bg-warning px-1">
                                                22
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--Form elements-->
                                <div id="panel-9" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Form <span class="fw-light"><i>elements</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <div class="form-check form-check-reverse form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Panel switch</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                You can add form elements to <code>.panel-hdr</code> and any other parts of the <code>.panel</code>
                                            </div>
                                        </div>
                                        <div class="panel-content py-2 rounded-bottom border-faded border-end-0 border-start-0 border-bottom-0 text-muted d-flex">
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Panel checkbox
                                                    <label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Form inputs-->
                                <div id="panel-10" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Form <span class="fw-light"><i>Inputs</i></span>
                                        </h2>
                                        <div class="panel-toolbar gap-2">
                                            <select class="form-select form-select-sm">
                                                <option selected="">Select</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <div class="d-flex position-relative ms-auto width-sm">
                                                <svg class="sa-icon sa-icon-1x translate-middle position-absolute top-50 ms-3">
                                                    <use href="/icons/sprite.svg#search"></use>
                                                </svg>
                                                <input type="text" class="form-control form-control-sm" placeholder="Search" style="padding-left:1.7rem">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                You can add form inputs to <code>.panel-hdr</code> with moderation. Adding too many elements may break the design on mobile viewport
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Panel buttons -->
                                <div id="panel-11" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Panel <span class="fw-light"><i>Buttons</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Small split button</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="visually-hidden">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                    <li>
                                                        <div class="dropdown-divider"></div>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Add panel buttons to <code>.panel-hdr</code> and footer area. Keep in mind of your panel title size as distortion can occur with too many buttons overflowing.
                                            </div>
                                        </div>
                                        <div class="panel-content py-2 rounded-bottom bg-faded border-faded border-start-0 border-end-0 border-bottom-0 text-muted d-flex">
                                            <ul class="pagination pagination-sm justify-content-start mb-0">
                                                <li class="page-item disabled"><a class="page-link">Prev</a></li>
                                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--Panel tabs-->
                                <div id="panel-12" class="panel panel-icon">
                                    <div class="panel-hdr border-bottom">
                                        <h2>
                                            Panel <span class="fw-light"><i>Tabs</i></span>
                                        </h2>
                                        <div class="panel-toolbar pr-3 align-self-end">
                                            <ul id="demo_panel-tabs" class="nav nav-tabs border-bottom-0 js-demo-panel-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_default-1" role="tab">Home</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_default-2" role="tab">Set</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link disabled" data-bs-toggle="tab" href="#" role="tab">Disabled</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                <p>You can easily add <code>.nav-tabs</code> to <code>.panel-hdr</code>, consider adding dropdown panel button if you have a lot of panel tabs. Check out the Tabs &amp; pills page for more details</p>
                                            </div>

                                            <div id="js_change_tab_direction" class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                <input type="radio" class="btn-check" checked="" value="nav nav-tabs" name="btnradio" id="btnradio1" autocomplete="off" checked="checked" data-action="toggle-swap" data-toggleclass="nav-tabs-clean" data-target=".js-demo-panel-tabs">
                                                <label class="btn btn-sm btn-outline-primary" for="btnradio1">Default</label>

                                                <input type="radio" class="btn-check" value="nav nav-tabs justify-content-end" name="btnradio" id="btnradio2" autocomplete="off" data-action="toggle-swap" data-toggleclass="nav-tabs-clean" data-target=".js-demo-panel-tabs">
                                                <label class="btn btn-sm btn-outline-primary" for="btnradio2">Clean</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Panel pills-->
                                <div id="panel-13" class="panel panel-icon panel-locked js-example-panel-lock">
                                    <div class="panel-hdr">
                                        <h2>
                                            Panel <span class="fw-light"><i>Locked</i></span>
                                        </h2>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">

                                            <div class="panel-tag"> This panel is locked from drag and drop. We use the class <code>.panel-locked</code> to lock the panel. Go ahead and try to drag it, it won't budge!</div>
                                            <button type="button" class="btn btn-outline-secondary me-2" data-action="panel-toggle" data-panel-toggle="panel-locked">
                                                <span class="panel-locked-text"><i class="sa sa-lock me-1"></i> Unlock panel</span>
                                                <span class="panel-unlock-text"><i class="sa sa-lock-open me-1"></i> Lock panel</span>
                                            </button>
                                            <a href="javascript:void(0);" data-action="panel-reset">Reset panel</a> will also unlock the panel.
                                        </div>
                                    </div>
                                </div>
                                <!--Panel progress bars-->
                                <div id="panel-14" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            <svg class="sa-icon panel-icon">
                                                <use href="/icons/sprite.svg#package"></use>
                                            </svg>
                                            Insert <span class="fw-light"><i>Icon</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <div class="progress bg-warning-200 width-sm">
                                                <div class="progress-bar bg-info-700 progress-bar-striped progress-bar-animated fw-700" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                                            </div>
                                        </div>
                                        <!-- <div class="panel-toolbar">
                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                <svg class="sa-icon">
                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen"data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                <svg class="sa-icon">
                                    
                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                <svg class="sa-icon">
                                    <use href="/icons/sprite.svg#x-circle"></use>
                                </svg>
                            </button>
                        </div> -->
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Insert sleek icons—with over <a href="/systemicons" target="_blank">2,500 options</a> to choose from—and dynamic progress bars to bring your panel to life, making data clearer, faster, and more engaging than ever!
                                                You can also add stylish progress bars to enhance your design.
                                            </div>
                                        </div>
                                        <div class="panel-content py-2 rounded-bottom border-faded border-start-0 border-end-0 border-bottom-0 text-muted">
                                            <div class="progress progress-sm w-100 shadow-inset-2">
                                                <div class="progress-bar bg-info-300 bg-info-gradient" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Icon panel-->
                                <div id="panel-15" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Classic <span class="fw-light"><i>Icons</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,16" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,16" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">

                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,16" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Looking for a less cluttered panel? Add <code>.panel-icon</code> class to your <code>.panel</code> to remove panel buttons and keep only the icons.
                                            </div>
                                            <button type="button" class="btn btn-outline-secondary" data-action="panel-toggle" data-panel-toggle="panel-icon">
                                                Switch Panel Icon Style
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--Refresh panel-->
                                <div id="panel-16" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Panel <span class="fw-light"><i>Refresh</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-xs btn-primary" data-action="panel-refresh" data-refresh-duration="2000" data-refresh-callback="loadRandomGraph">Refresh Panel</button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Refresh panels with a simple button. Use the <code>data-action="panel-refresh"</code> to activate the refresh feature. The <code>data-refresh-duration</code> attribute sets the refresh interval and the <code>data-refresh-callback="functionName"</code> attribute sets the callback function.
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <img id="randomGraph" src="" alt="Random Colorful Bar Graph" style="width:350px; height: 200px;">
                                            </div>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <i class="js-last-refresh fs-xs text-muted"></i>
                                                <button type="button" class="btn btn-outline-secondary" data-action="panel-refresh" data-refresh-duration="2000" data-refresh-callback="loadRandomGraph">Refresh Panel</button>
                                            </div>
                                        </div>
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

    <?= $this->include('partials/app-scripts') ?>

    <script src="scripts/pages/refresh-panel.js"></script>

</body>

</html>