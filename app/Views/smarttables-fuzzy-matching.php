<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "ST: Fuzzy Matching")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Fuzzy Matching", "pageSubTitle1" => "Data Visualization", "pageSubTitle2" => "Smart Tables", "pageSubText" => "Fuzzy Matching allows matching text that isn't an exact match, making search more forgiving and intuitive.")) ?>

                    <div class="main-content" >
                        <div class="info-container">
                            <p class="mb-0">Adjust the settings below to see how different fuzzy matching parameters affect search results.
                                After configuring your settings, click <strong>Build Table</strong> to initialize the table with those settings.
                                To apply new settings, click <strong>Destroy Table</strong> and then <strong>Build Table</strong> again. <a href="smarttablesjs.html#smarttables-configuration" target="_blank">See Documentation →</a>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-g">
                                    <div class="card-body">
                                        <div class="row row-grid g-0 border-faded mb-g">
                                            <div class="col-sm-6 p-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="threshold">
                                                        <strong>Threshold:</strong> <span id="thresholdValue"></span>
                                                        <small class="d-block text-muted">0 = Exact match only | 1 = Maximum fuzziness</small>
                                                    </label>
                                                    <input type="range" class="form-range" id="threshold">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="minMatchLength">
                                                        <strong>Minimum Match Length:</strong> <span id="minMatchLengthValue"></span>
                                                        <small class="d-block text-muted">Minimum characters required for a match</small>
                                                    </label>
                                                    <input type="range" class="form-range" id="minMatchLength">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="multiWordThreshold">
                                                        <strong>Multi-Word Threshold:</strong> <span id="multiWordThresholdValue"></span>
                                                        <small class="d-block text-muted">0 = Match any word | 1 = Match all words</small>
                                                    </label>
                                                    <input type="range" class="form-range" id="multiWordThreshold">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="maxDistance">
                                                        <strong>Max Distance:</strong> <span id="maxDistanceValue"></span>
                                                        <small class="d-block text-muted">Maximum character mismatches allowed (typo tolerance)</small>
                                                    </label>
                                                    <input type="range" class="form-range" id="maxDistance">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="app-fob-showcase-text mb-g" data-prefix="Search Behavior">
                                            <div id="description" class="mb-2"></div>
                                            <div class="text-muted fst-italic small" id="searchExample"></div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <button id="resetSettings" type="button" class="btn btn-secondary me-auto">
                                                Balanced <span class="d-none d-sm-inline">Settings</span>
                                            </button>
                                            <button id="destroyTable" type="button" class="btn btn-danger">
                                                Destroy <span class="d-none d-sm-inline">Table</span>
                                            </button>
                                            <button id="buildTable" type="button" class="btn btn-outline-success">
                                                Build <span class="d-none d-sm-inline">Table</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="tableContainer" class="d-none mb-5">
                                    <div class="info-container mb-g">
                                        <h5 class="card-title">Try the Search</h5>
                                        <p class="mb-0">Use the search box below to test how your fuzzy search settings perform. Try partial words, typos, or multi-word searches.</p>
                                    </div>
                                    <table id="myTable" class="table table-striped table-bordered table-hover"></table>
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

    <script type="module" src="scripts/pages/smarttablesfuzzymatching.js"></script>

</body>

</html>