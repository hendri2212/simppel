<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Alerts")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Alerts", "pageSubTitle1" => "Design", "pageSubTitle2" => "UI Components", "pageSubText" => "Provide contextual feedback messages for common user actions with a variety of customizable and flexible alert options.")) ?>

                    <div class="main-content" >

                        <div class="row" id="sortable-grid">
                            <div class="col-md-12 col-xl-6">
                                <!--Basic alerts-->
                                <div id="panel-1" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Basic <span class="fw-light"><i>Alerts</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container" id="panel1Content">
                                        <div class="panel-content">
                                            <div class="demo-v-spacing gap-3">
                                                <div class="alert alert-primary" role="alert">
                                                    <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
                                                </div>
                                                <div class="alert alert-success" role="alert">
                                                    <strong>Well Done!</strong> You successfully read this important alert message.
                                                </div>
                                                <div class="alert alert-danger" role="alert">
                                                    <strong>Oh snap!</strong> Change a few things up and try submitting again.
                                                </div>
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                                                </div>
                                                <div class="alert alert-info" role="alert">
                                                    <strong>Info!</strong> Alert for passing information to user.
                                                </div>
                                                <div class="alert alert-secondary" role="alert">
                                                    <strong>Hello World!</strong> This is default alert message box.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Dismissable Alerts-->
                                <div id="panel-2" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Dismissable <span class="fw-light"><i>Alerts</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">

                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container" id="panel2Content">
                                        <div class="panel-content">
                                            <div class="demo-v-spacing gap-3">
                                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
                                                </div>
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                    <strong>Well Done!</strong> You successfully read this important alert message.
                                                </div>
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <strong>Oh snap!</strong> Change a few things up and try submitting again.
                                                </div>
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x-square"></i>
                                                    </button>
                                                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                                                </div>
                                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                    <strong>Info!</strong> Alert for passing information to user.
                                                </div>
                                                <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x-square"></i>
                                                    </button>
                                                    <strong>Hello World!</strong> This is default alert message box.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Large Alerts-->
                                <div id="panel-3" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Large <span class="fw-light"><i>Alerts</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">

                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container show" id="panel3Content">
                                        <div class="panel-content">
                                            <div class="demo-v-spacing gap-3">
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3">
                                                            <i class="bi bi-arrow-repeat fs-4 spin"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="h6 mb-0 fw-bold">Task 55% Complete</span>
                                                            <div class="progress mt-2" style="height: 4px">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert bg-success text-white alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3">
                                                            <i class="bi bi-check-lg fs-4"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="h6 mb-0 fw-bold">Task 100% Complete</span>
                                                            <div class="progress mt-2" style="height: 4px">
                                                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert border border-info bg-transparent text-info fade show" role="alert">
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3">
                                                            <i class="bi bi-exclamation-triangle"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="h5 mb-0 fw-bold">Compilation error occured!</span>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            <button type="button" class="btn btn-info btn-sm rounded-pill">
                                                                Repair
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-dismiss="alert" aria-label="Close">
                                                                Dismiss
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert border border-danger bg-transparent text-secondary fade show" role="alert">
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3">
                                                            <div class="bg-danger rounded-circle p-2 d-flex align-items-center justify-content-center position-relative">
                                                                <svg class="sa-icon sa-icon-2x sa-bold sa-icon-light">
                                                                    <use href="/icons/sprite.svg#alert-triangle"></use>
                                                                </svg>
                                                                <span class="position-absolute border border-light top-0 start-100 translate-middle badge rounded-pill bg-fusion-500 mt-1">
                                                                    19+
                                                                    <span class="visually-hidden">9+ unread messages</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="h5 text-danger">This branch is out-of-date with the base branch</span>
                                                        </div>
                                                        <a href="#" class="btn btn-outline-danger btn-sm flex-shrink-0">Report</a>
                                                    </div>
                                                </div>
                                                <div class="alert border bg-transparent text-secondary fade show" role="alert">
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3">
                                                            <div class="bg-success rounded-circle p-2 d-flex align-items-center justify-content-center position-relative">
                                                                <svg class="sa-icon sa-icon-2x sa-bold sa-icon-light">
                                                                    <use href="/icons/sprite.svg#check-circle"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="h5 text-success">All checks have passed!</span>
                                                            <br>
                                                            2 successful checks
                                                        </div>
                                                        <a href="#" class="btn btn-outline-success btn-sm flex-shrink-0">Review</a>
                                                    </div>
                                                </div>
                                                <div class="alert bg-info text-white fade show" role="alert">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-warning rounded-circle p-2 d-flex align-items-center justify-content-center position-relative me-3">
                                                            <svg class="sa-icon sa-icon-2x sa-bold sa-icon-dark">
                                                                <use href="/icons/sprite.svg#frown"></use>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="h5">This branch is out-of-date with the base branch</span>
                                                            <br>
                                                            Some pipes failed during build.
                                                        </div>
                                                        <a href="#" class="btn btn-warning btn-sm rounded-pill px-4 flex-shrink-0">Fix</a>
                                                    </div>
                                                </div>
                                                <div class="alert bg-dark text-white border-0 fade show">
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3">
                                                            <div class="bg-success rounded-circle p-2 d-flex align-items-center justify-content-center position-relative">
                                                                <svg class="sa-icon sa-icon-2x sa-bold sa-icon-light">
                                                                    <use href="/icons/sprite.svg#check-square"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="h5">Download complete</span>
                                                            <br>
                                                            Install the latest version
                                                        </div>
                                                        <a href="#" class="btn btn-warning btn-sm fw-medium" data-bs-dismiss="alert" aria-label="Close">Install</a>
                                                    </div>
                                                </div>
                                                <div class="alert bg-warning text-dark alert-dismissible fade show">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3">
                                                            <div class="bg-info rounded-circle p-2 d-flex align-items-center justify-content-center position-relative">
                                                                <svg class="sa-icon sa-icon-4x sa-bold sa-icon-light">
                                                                    <use href="/icons/sprite.svg#database"></use>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="h5">Large Icon</span>
                                                            <br>
                                                            Custom alert background with <strong>large</strong> sized icon.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                <!--Alert outline-->
                                <div id="panel-4" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Alert <span class="fw-light"><i>Outline</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">

                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container show" id="panel4Content">
                                        <div class="panel-content">
                                            <div class="demo-v-spacing gap-3">
                                                <div class="alert border-primary bg-transparent text-primary" role="alert">
                                                    <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
                                                </div>
                                                <div class="alert border-success bg-transparent text-success" role="alert">
                                                    <strong>Well Done!</strong> You successfully read this important alert message.
                                                </div>
                                                <div class="alert border-danger bg-transparent text-danger" role="alert">
                                                    <strong>Oh snap!</strong> Change a few things up and try submitting again.
                                                </div>
                                                <div class="alert border-warning bg-transparent text-warning" role="alert">
                                                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                                                </div>
                                                <div class="alert border-info bg-transparent text-info" role="alert">
                                                    <strong>Info!</strong> Alert for passing information to user.
                                                </div>
                                                <div class="alert border-secondary bg-transparent text-secondary" role="alert">
                                                    <strong>Hello World!</strong> This is default alert message box.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Alternative Backgrounds-->
                                <div id="panel-5" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Alternative <span class="fw-light"><i>Backgrounds</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container show" id="panel5Content">
                                        <div class="panel-content">
                                            <div class="demo-v-spacing gap-3">
                                                <div class="alert bg-info text-white fade show d-flex align-items-center" role="alert">
                                                    <p class="mb-0"><strong>Info!</strong> Alert for passing information to user.</p>
                                                    <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="alert" aria-label="Close">
                                                        <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                            <use href="/icons/sprite.svg#x"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="alert bg-primary bg-opacity-25 text-primary d-flex align-items-center" role="alert">
                                                    <p class="mb-0"><strong>Heads up!</strong> This alert needs your attention, but it's not super important.</p>
                                                    <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="alert" aria-label="Close">
                                                        <svg class="sa-icon sa-icon-2x sa-icon-dark">
                                                            <use href="/icons/sprite.svg#x"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="alert bg-danger text-white fade show d-flex align-items-center" role="alert">
                                                    <p class="mb-0"><strong>Oh snap!</strong> Change a few things up and try submitting again.</p>
                                                    <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="alert" aria-label="Close">
                                                        <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                            <use href="/icons/sprite.svg#x"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="alert bg-dark text-white fade show d-flex align-items-center" role="alert">
                                                    <p class="mb-0"><strong>Hello World!</strong> This is default alert message box.</p>
                                                    <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="alert" aria-label="Close">
                                                        <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                            <use href="/icons/sprite.svg#x"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="alert bg-warning text-dark fade show d-flex align-items-center" role="alert">
                                                    <p class="mb-0"><strong>Holy guacamole!</strong> You should check in on some of those fields below.</p>
                                                    <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="alert" aria-label="Close">
                                                        <svg class="sa-icon sa-icon-2x sa-icon-dark">
                                                            <use href="/icons/sprite.svg#x"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="alert bg-success text-white fade show d-flex align-items-center" role="alert">
                                                    <p class="mb-0"><strong> Well Done!</strong> You successfully read this important alert message.</p>
                                                    <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="alert" aria-label="Close">
                                                        <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                            <use href="/icons/sprite.svg#x"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Stack Icon-->
                                <div id="panel-6" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Stack <span class="fw-light"><i>Icon</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">

                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container show" id="panel6Content">
                                        <div class="panel-content">
                                            <div class="demo-v-spacing gap-3">
                                                <div class="alert bg-primary bg-opacity-10 border-primary alert-dismissible fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3" style="width: 3rem">
                                                            <div class="stack-icon" style="font-size: 3rem;">
                                                                <div class="icon-layers">
                                                                    <i class="sa sa-base-2 stack-3x text-success"></i>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <i class="sa sa-base-10 stack-1x text-dark"></i>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <svg class="sa-icon sa-bold stack-1x sa-icon-danger">
                                                                        <use href="/icons/sprite.svg#alert-triangle"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <svg class="sa-icon sa-bold sa-icon-warning stack-1x">
                                                                        <use href="/icons/sprite.svg#sun"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <strong>Custom stack icon size! </strong> You can change the stack icon size with font-size style property.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert bg-success alert-dismissible bg-opacity-10 border-success fade show" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3" style="width: 4rem">
                                                            <div class="stack-icon" style="font-size: 4rem;">
                                                                <div class="icon-layers">
                                                                    <i class="sa sa-base-2 stack-3x text-success"></i>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <i class="sa sa-base-10 stack-1x text-dark"></i>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <svg class="sa-icon sa-bold stack-1x sa-icon-danger">
                                                                        <use href="/icons/sprite.svg#alert-triangle"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <svg class="sa-icon sa-bold sa-icon-warning stack-1x">
                                                                        <use href="/icons/sprite.svg#sun"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="h5 mb-1 fw-bold">A slightly larger icon</p> Custom alert background with <strong>small</strong> sized icon stack.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert bg-warning bg-opacity-10 border-warning alert-dismissible fade show">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3" style="width: 6rem">
                                                            <div class="stack-icon" style="font-size: 6rem;">
                                                                <div class="icon-layers">
                                                                    <i class="sa sa-base-2 stack-3x text-success"></i>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <i class="sa sa-base-10 stack-1x text-dark"></i>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <svg class="sa-icon sa-bold stack-1x sa-icon-danger">
                                                                        <use href="/icons/sprite.svg#alert-triangle"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <svg class="sa-icon sa-bold sa-icon-warning stack-1x">
                                                                        <use href="/icons/sprite.svg#sun"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 text-inverse">
                                                            <span class="h3">Large Icon Stack</span>
                                                            <br> Custom alert background with <strong>large</strong> sized icon stack.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert bg-danger bg-opacity-10 border-danger text-danger alert-dismissible fade show">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <div class="alert-icon flex-shrink-0 me-3" style="width: 8rem">
                                                            <div class="stack-icon" style="font-size: 8rem;">
                                                                <div class="icon-layers">
                                                                    <i class="sa sa-base-2 stack-3x text-success"></i>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <i class="sa sa-base-10 stack-1x text-dark"></i>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <svg class="sa-icon sa-bold stack-1x sa-icon-danger">
                                                                        <use href="/icons/sprite.svg#alert-triangle"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="icon-layers">
                                                                    <svg class="sa-icon sa-bold sa-icon-warning stack-1x">
                                                                        <use href="/icons/sprite.svg#sun"></use>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ps-2">
                                                            <span class="h2 mb-0"> Hold on there Sparky! </span>
                                                            <br> Better fix those errors before you can complete this request
                                                        </div>
                                                    </div>
                                                </div>
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

</body>

</html>