<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "SmartTables: Server-Side Mode")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "SmartTables: Multiple Tables", "pageSubTitle1" => "Data Visualization", "pageSubTitle2" => "Smart Tables", "pageSubText" => "Loading multiple tables with server side, static, and dynamic data.")) ?>
                    
                    <div class="main-content" >
                        <div class="info-container">
                            <strong>Here</strong> we use <code>mock-server.php</code> to load data via AJAX, data resets every 24 hours.
                            Configure with:
                            <code>
                                data: { type: 'ajax', source: 'API_URL', serverSide: true, method: 'GET', cacheDuration: 300000 }
                            </code>
                            Processing happens server-side; client only renders. <strong>Searched, paging, and sorting</strong> is cached for 5 minutes.
                            Test how this works by opening the browser's <strong>developer tools</strong> and going to the <strong>Network</strong> tab. <a href="smarttablesjs.html#smarttables-server-side" target="_blank">See documentation →</a>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="tab" href="#tab_direction-1" role="tab" aria-selected="true">Angepasste Spieler</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab" href="#tab_direction-2" role="tab" aria-selected="false" tabindex="-1">Gelöschte Spieler</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab" href="#tab_direction-3" role="tab" aria-selected="false" tabindex="-1">Neue Spieler</a></li>
                                </ul>
                                <div class="tab-content py-4 px-3 border-top-0 bg-white border rounded-bottom">
                                    <div class="tab-pane fade active show" id="tab_direction-1" role="tabpanel">
                                        <table id="demo-table"></table>
                                    </div>
                                    <div class="tab-pane fade" id="tab_direction-2" role="tabpanel">
                                        <table id="demo-table-2"></table>
                                    </div>
                                    <div class="tab-pane fade" id="tab_direction-3" role="tabpanel">
                                        <table id="demo-table-3"></table>
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

    <script type="module" src="scripts/pages/smarttablesmultiple.js"></script>

</body>

</html>