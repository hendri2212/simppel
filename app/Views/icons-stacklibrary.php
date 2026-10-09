<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Stack Library")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Stack Library", "pageSubTitle1" => "Icons", "pageSubTitle2" => "SmartAdmin", "pageSubText" => "Your saved stacked icons collection")) ?>

                    <div class="main-content" >
                        <div class="card">
                            <div class="card-body" style="min-height: calc(100vh - 340px);">
                                <div class="mb-3">
                                    <input type="text" id="searchIcons" class="form-control form-control-lg" placeholder="Search saved icons..." autocomplete="off">
                                </div>
                                <div id="stack-library-container">
                                    <!-- Icons will be dynamically loaded here -->
                                    <ul id="iconList" class="list-unstyled row g-4"></ul>
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

    <script src="scripts/pages/stacklibrary.js"></script>

    <script>
        /* Inject additional scripts dynamically */
        console.log('Stack Library page initialized');
    </script>

</body>

</html>