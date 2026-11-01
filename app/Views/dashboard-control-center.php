<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Control Center")) ?>



    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <div class="d-flex align-items-end mb-4">
                        <div>
                            <?php echo view("partials/app-pagetitle", array("pageTitle" => "Control Center", "pageSubTitle1" => 'Insights', "pageSubTitle2" => "Dashboards")) ?>
                        </div>

                        <div class="ms-auto d-none d-sm-flex align-items-center ">
                            <div class="d-flex align-items-center">
                                <div class="d-inline-flex flex-column justify-content-center me-2">
                                    <span class="fw-500 fs-xs d-block">
                                        <small>EXPENSES</small>
                                    </span>
                                    <span class="fw-500 fs-xl d-block text-primary"> $47,000 </span>
                                </div>
                                <div class="d-none d-md-inline-flex">
                                    <span class="peity-bar d-none" data-peity='{ "fill": ["var(--primary-500)"], "height": 34, "width": "85" }'>3, 4, 3, 6, 7, 3, 3, 6, 2, 6, 4</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border border-top-0 border-bottom-0 border-end-0 ms-3 ps-3">
                                <div class="d-inline-flex flex-column justify-content-center me-2">
                                    <span class="fw-500 fs-xs d-block">
                                        <small>PROFIT</small>
                                    </span>
                                    <span class="fw-500 fs-xl d-block text-danger"> $38,500 </span>
                                </div>
                                <div class="d-none d-md-inline-flex">
                                    <span class="peity-bar d-none" data-peity='{ "fill": ["var(--danger-500)"], "height": 34, "width": "85" }'>1, 4, 3, 6, 5, 3, 9, 6, 5, 9, 7</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <!-- Live Feeds -->
                                <div id="panel-1" class="panel panel-icon panel-locked">
                                    <div class="panel-hdr">
                                        <h2> Live <span class="fw-light"><i>Feeds</i></span>
                                        </h2>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content border-faded border-end-0 border-start-0 border-top-0 pt-0">
                                            <div class="row g-0">
                                                <!-- Live Feeds -->
                                                <div class="col-lg-7 col-xl-8">
                                                    <!-- Live Feeds Chart-->
                                                    <div class="apex-charts" id="apex-chart-1"></div>
                                                </div>
                                                <!-- My Tasks -->
                                                <div class="col-lg-5 col-xl-4 ps-lg-3">
                                                    <div class="d-flex mt-2">
                                                        My Tasks
                                                        <span class="d-inline-block ms-auto">130 / 500</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-4">
                                                        <div class="progress-bar bg-fusion-400" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" aria-label="65%" aria-labelledby="My Tasks"></div>
                                                    </div>
                                                    <div class="d-flex">
                                                        Transferred
                                                        <span class="d-inline-block ms-auto">440 TB</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-4">
                                                        <div class="progress-bar bg-success-500" role="progressbar" style="width: 34%;" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100" aria-label="34%" aria-labelledby="Transferred"></div>
                                                    </div>
                                                    <div class="d-flex">
                                                        Resolved Issues
                                                        <span class="d-inline-block ms-auto">77%</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-4">
                                                        <div class="progress-bar bg-info-400" role="progressbar" style="width: 77%;" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" aria-label="77%" aria-labelledby="Resolved Issues"></div>
                                                    </div>
                                                    <div class="d-flex">
                                                        Testing Progress
                                                        <span class="d-inline-block ms-auto">7 days</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-g">
                                                        <div class="progress-bar bg-primary-300" role="progressbar" style="width: 84%;" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" aria-label="84%" aria-labelledby="Testing Progress"></div>
                                                    </div>
                                                    <div class="row no-gutters">
                                                        <div class="col-6 pe-1">
                                                            <a href="#" class="btn btn-default btn-block waves-effect waves-themed">Generate
                                                                PDF</a>
                                                        </div>
                                                        <div class="col-6 ps-1">
                                                            <a href="#" class="btn btn-default btn-block waves-effect waves-themed">Report
                                                                a Bug</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-content p-0">
                                            <div class="row row-grid g-0">
                                                <!-- SERVER LOAD -->
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                                                    <div class="p-3 d-flex align-items-center">
                                                        <div class="js-easy-pie-chart position-relative d-inline-flex align-items-center justify-content-center" style="color: var(--primary-300);" data-percent="75" data-piesize="50" data-linewidth="5" data-linecap="butt" data-scalelength="0">
                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                                                <span class="js-percent d-block text-muted"></span>
                                                            </div>
                                                        </div>
                                                        <span class="d-inline-block ms-2 text-muted">
                                                            SERVER LOAD
                                                            <i class="fal fa-caret-up color-danger-500 ms-1"></i>
                                                        </span>
                                                        <div class="ms-auto d-inline-flex align-items-center">
                                                            <span class="peity-line d-none" data-peity='{ "fill": false, "stroke": "var(--primary-500)", "height": 30, "width": "70", "strokeWidth": 1 }'>5,6,5,3,8,6,9,7,4,2</span>
                                                            <div class="d-inline-flex flex-column small ms-2">
                                                                <span class="d-inline-block badge bg-success opacity-75 text-center p-1 width-6">97%</span>
                                                                <span class="d-inline-block badge bg-fusion-300 opacity-75 text-center p-1 width-6 mt-1">44%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- DISK SPACE -->
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                                                    <div class="p-3 d-flex align-items-center">
                                                        <div class="js-easy-pie-chart text-success position-relative d-inline-flex align-items-center justify-content-center" data-percent="79" data-piesize="50" data-linewidth="5" data-linecap="butt">
                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                                                <span class="js-percent d-block text-muted"></span>
                                                            </div>
                                                        </div>
                                                        <span class="d-inline-block ms-2 text-muted">
                                                            DISK SPACE
                                                            <i class="fal fa-caret-down text-success ms-1"></i>
                                                        </span>
                                                        <div class="ms-auto d-inline-flex align-items-center">
                                                            <span class="peity-line d-none" data-peity='{ "fill": false, "stroke": "var(--success-500)", "height": 30, "width": "70", "strokeWidth": 1 }'>5,9,7,3,5,2,5,3,9,6</span>
                                                            <div class="d-inline-flex flex-column small ms-2">
                                                                <span class="d-inline-block badge bg-info opacity-75 text-center p-1 width-6">76%</span>
                                                                <span class="d-inline-block badge bg-warning-300 opacity-75 text-center p-1 width-6 mt-1">3%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- DATA TTF -->
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                                                    <div class="p-3 d-flex align-items-center">
                                                        <div class="js-easy-pie-chart text-info position-relative d-inline-flex align-items-center justify-content-center" data-percent="23" data-piesize="50" data-linewidth="5" data-linecap="butt">
                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                                                <span class="js-percent d-block text-muted"></span>
                                                            </div>
                                                        </div>
                                                        <span class="d-inline-block ms-2 text-muted">
                                                            DATA TTF
                                                            <i class="fal fa-caret-up color-success-500 ms-1"></i>
                                                        </span>
                                                        <div class="ms-auto d-inline-flex align-items-center">
                                                            <span class="peity-line d-none" data-peity='{ "fill": false, "stroke": "var(--info-500)", "height": 30, "width": "70", "strokeWidth": 1 }'>3,5,2,5,3,9,6,5,9,7</span>
                                                            <div class="d-inline-flex flex-column small ms-2">
                                                                <span class="d-inline-block badge bg-fusion-500 opacity-75 text-center p-1 width-6">10GB</span>
                                                                <span class="d-inline-block badge bg-fusion-300 opacity-75 text-center p-1 width-6 mt-1">10%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- TEMP -->
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                                                    <div class="p-3 d-flex align-items-center">
                                                        <div class="js-easy-pie-chart position-relative d-inline-flex align-items-center justify-content-center" style="color: var(--fusion-300);" data-percent="36" data-piesize="50" data-linewidth="5" data-linecap="butt">
                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                                                <span class="js-percent d-block text-muted"></span>
                                                            </div>
                                                        </div>
                                                        <span class="d-inline-block ms-2 text-muted">
                                                            TEMP.
                                                            <i class="fal fa-caret-down color-success-500 ms-1"></i>
                                                        </span>
                                                        <div class="ms-auto d-inline-flex align-items-center">
                                                            <span class="peity-line d-none" data-peity='{ "fill": false, "stroke": "var(--danger-500)", "height": 30, "width": "70", "strokeWidth": 1 }'>5,3,9,6,5,9,7,3,5,2</span>
                                                            <div class="d-inline-flex flex-column small ms-2">
                                                                <span class="d-inline-block badge bg-danger opacity-75 text-center p-1 width-6">124</span>
                                                                <span class="d-inline-block badge bg-info text-light opacity-75 text-center p-1 width-6 mt-1">40F</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <!-- My Schedule -->
                                <div id="panel-3" class="panel panel-icon">
                                    <!-- <div class="panel-hdr">
                    <h2> My <span class="fw-light"><i>Schedule</i></span></h2>
                    <div class="panel-toolbar">
                        <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                            <svg class="sa-icon">
                                <use href="/icons/sprite.svg#stop-circle"></use>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                            <svg class="sa-icon">
                                <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                            </svg>
                        </button>
                    </div>
                </div> -->
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="myCalendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <!-- Subscriptions -->
                                <div id="panel-5" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Subscriptions <span class="fw-light"><i>Hourly</i></span></h2>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="subscriptionsChart" style="max-height: 200px; min-height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Secession -->
                                <div id="panel-6" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Secession <span class="fw-light"><i>Scale</i></span></h2>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content p-0 mb-g">
                                            <div class="alert bg-success bg-opacity-10 fade show border-faded border-start-0 border-end-0 rounded-0 m-0 d-flex align-items-center py-2 fs-sm" role="alert">
                                                <p class="m-0">Last update was on <span class="js-get-date">Friday, May 2, 2025</span>
                                                    - Your logs are all up to date.</p>
                                                <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="alert" aria-label="Close">
                                                    <svg class="sa-icon sa-icon-2x sa-icon-dark">
                                                        <use href="/icons/sprite.svg#x"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="panel-content">
                                            <div class="row mb-g">
                                                <div class="col-md-6">
                                                    <div id="secessionChart" class="d-flex align-items-center"></div>
                                                </div>
                                                <div class="col-md-6 col-lg-5 me-lg-auto">
                                                    <div class="d-flex mt-2 mb-1 fs-xs text-primary">
                                                        Current Usage
                                                    </div>
                                                    <div class="progress progress-xs mb-3">
                                                        <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" aria-label="70%" aria-labelledby="Current Usage"></div>
                                                    </div>
                                                    <div class="d-flex mt-2 mb-1 fs-xs text-info">
                                                        Net Usage
                                                    </div>
                                                    <div class="progress progress-xs mb-3">
                                                        <div class="progress-bar bg-info-500" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30%" aria-labelledby="Net Usage"></div>
                                                    </div>
                                                    <div class="d-flex mt-2 mb-1 fs-xs text-warning">
                                                        Users blocked
                                                    </div>
                                                    <div class="progress progress-xs mb-3">
                                                        <div class="progress-bar bg-warning-500" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" aria-label="40%" aria-labelledby="Users blocked"></div>
                                                    </div>
                                                    <div class="d-flex mt-2 mb-1 fs-xs text-danger">
                                                        Custom cases
                                                    </div>
                                                    <div class="progress progress-xs mb-3">
                                                        <div class="progress-bar bg-danger-500" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" aria-label="15%" aria-labelledby="Custom cases"></div>
                                                    </div>
                                                    <div class="d-flex mt-2 mb-1 fs-xs text-success">
                                                        Test logs
                                                    </div>
                                                    <div class="progress progress-xs mb-3">
                                                        <div class="progress-bar bg-success-500" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" aria-label="25%" aria-labelledby="Test logs"></div>
                                                    </div>
                                                    <div class="d-flex mt-2 mb-1 fs-xs text-dark">
                                                        Uptime records
                                                    </div>
                                                    <div class="progress progress-xs mb-3">
                                                        <div class="progress-bar bg-fusion-500" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" aria-label="10%" aria-labelledby="Uptime records"></div>
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


        <?= $this->include('partials/app-settings') ?>

    </div>

    <?= $this->include('partials/app-scripts') ?>



    <script src="/plugins/fullcalendar/index.global.min.js"></script>

    <script src="/plugins/easypiechart/easypiechart.min.js"></script>

    <script src="/scripts/pages/easypiechart.js"></script>

    <script type="module" src="/scripts/pages/controlcenterdashboard.js"></script>

</body>

</html>