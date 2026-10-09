<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "SmartTables: Import & Export Data")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">

            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Import & Export Data", "pageSubTitle1" => "Smart Tables", "pageSubTitle2" => "Data Visualization", "pageSubText" => "No manual processing, no hassle\u2014just smooth, efficient data management built for developers. \ud83d\ude80")) ?>

                    <div class="main-content" >
                        <div id="hide-import-data">
                            <div class="info-container">
                                <p class="mb-0">
                                    The <strong>SmartTables Import</strong> feature streamlines your workflow by
                                    <strong>automatically</strong> or <strong>conditionally</strong> importing
                                    <code>JSON</code> and <code>CSV</code> files (with more formats coming soon).
                                    Imported data is instantly <strong>sorted and listed</strong>, ready for you to explore.
                                    Need to share or transform your data? <strong>Effortlessly export</strong> it
                                    in multiple formats with just a click.
                                </p>
                            </div>
                            <button id="importBtn" type="button" class="btn btn-default btn-lg d-flex align-items-center mb-2">
                                <svg class="sa-icon sa-icon-success sa-thin sa-icon-4x me-2">
                                    <use href="/icons/sprite.svg#upload-cloud"></use>
                                </svg>
                                Import Data
                            </button>
                            <small>
                                <strong>Note:</strong>
                                The import feature is currently limited to CSV and JSON files. Download sample files <a href="./json/MOCK_DATA.json" target="_blank">here</a>.
                            </small>
                        </div>

                        <div id="errorContainer" class="alert alert-danger d-none">
                            <h4 class="alert-heading">Error</h4>
                            <p>Could not open the import modal. Please try refreshing the page or check the console for errors.</p>
                        </div>

                        <div id="tableContainer" class="d-none">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table id="myTable" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <!-- Data will be populated by SmartTables -->
                                        </thead>
                                        <tbody>
                                            <!-- Data will be populated by SmartTables -->
                                        </tbody>
                                    </table>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <script type="module" src="scripts/pages/smarttablesimportexportdata.js"></script>

</body>

</html>