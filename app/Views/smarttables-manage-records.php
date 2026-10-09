<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "SmartTables: Manage Records")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Manage Records", "pageSubTitle1" => "Smart Tables", "pageSubTitle2" => "Data Visualization", "pageSubText" => "Functionality for managing records with full CRUD (Create, Read, Update, Delete) operations. This allows you to build interactive data management interfaces with minimal effort.")) ?>
                    
                    <div class="main-content" >
                        <div class="info-container">
                            Turn on <strong>Edit, Add, and Delete</strong> feature by using <code>addRecord: true</code> and use hooks create custom form elements.
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="clientTable" class="table table-striped table-bordered table-hover d-none">
                                </table>
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

    <script type="module" src="scripts/pages/smarttablesmanagerecords.js"></script>

</body>

</html>