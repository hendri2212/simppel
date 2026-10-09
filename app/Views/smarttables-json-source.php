<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "SmartTables")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "JSON Data Source", "pageSubTitle1" => "Data Visualization", "pageSubTitle2" => "Smart Tables", "pageSubText" => "Loading the table with External JSON data source with over 1000 records.")) ?>
                    
                    <div class="main-content" >
                        <div class="info-container">
                            The <code>render</code> function allows you to manipulate data, apply <strong>custom styling</strong>,
                            implement <strong>logic</strong>, and add various functionalities. For example, you can <strong>hover over a
                                product to see its image</strong>, style emails based on mail providers, or use <strong>data matching</strong> to
                            encode badges with colors. These are just basic examples—you can do much more with the <code>render</code> function. <a href="smarttablesjs.html#smarttables-configuration" target="_blank">See Documentation →</a>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="myTable" class="table table-striped table-bordered table-hover d-none"></table>
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

    <script type="module" src="scripts/pages/smarttablesjsonsource.js"></script>

</body>

</html>