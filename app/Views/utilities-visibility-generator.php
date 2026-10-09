<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Visibility Generator")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Visibility Generator", "pageSubTitle1" => "Design", "pageSubTitle2" => "System Utilities", "pageSubText" => "Create responsive visibility classes for elements across screen sizes.")) ?>

                    <div class="main-content" >

                        <div class="alert alert-info">
                            <h5 class="alert-heading d-flex align-items-center"><i class="sa sa-info me-2"></i>About Visibility Classes</h5>
                            <p class="mb-0">Bootstrap provides utility classes to control the visibility and display properties of elements based on screen size.
                                This tool helps you generate the classes you need for responsive design. Combine display types with breakpoints to create
                                elements that show or hide at specific screen sizes.</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-5">
                                <div class="option-card">
                                    <div class="option-title">Visibility Mode</div>
                                    <div class="form-section">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="visibilityHidden" name="visibilityMode" value="hidden" checked>
                                            <label class="form-check-label" for="visibilityHidden">Hidden</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="visibilityVisible" name="visibilityMode" value="visible">
                                            <label class="form-check-label" for="visibilityVisible">Visible</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-card" id="displayTypeSection">
                                    <div class="option-title">Display Type</div>
                                    <div class="form-section">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="block" name="displayType" value="block" checked>
                                            <label class="form-check-label" for="block">Block</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="flex" name="displayType" value="flex">
                                            <label class="form-check-label" for="flex">Flex</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="inline" name="displayType" value="inline">
                                            <label class="form-check-label" for="inline">Inline</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-card">
                                    <div class="option-title">
                                        <span>Breakpoints</span>
                                        <small class="float-end text-muted">Current: <span id="currentBreakpoint">...</span></small>
                                    </div>

                                    <div class="mb-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="all" value="all">
                                            <label class="form-check-label fw-bold" for="all">All Breakpoints</label>
                                        </div>
                                    </div>

                                    <div class="bp-grid">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input breakpoint-checkbox" id="xs" value="xs">
                                            <label class="form-check-label" for="xs">XS (≤576px)</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input breakpoint-checkbox" id="sm" value="sm">
                                            <label class="form-check-label" for="sm">SM (≥576px)</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input breakpoint-checkbox" id="md" value="md">
                                            <label class="form-check-label" for="md">MD (≥768px)</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input breakpoint-checkbox" id="lg" value="lg">
                                            <label class="form-check-label" for="lg">LG (≥992px)</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input breakpoint-checkbox" id="xl" value="xl">
                                            <label class="form-check-label" for="xl">XL (≥1200px)</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input breakpoint-checkbox" id="xxl" value="xxl">
                                            <label class="form-check-label" for="xxl">XXL (≥1400px)</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input breakpoint-checkbox" id="xxxl" value="xxxl">
                                            <label class="form-check-label" for="xxxl">XXXL (≥1600px)</label>
                                        </div>
                                    </div>

                                    <button id="generateBtn" type="button" class="btn btn-primary w-100 mt-3">
                                        <i class="fal fa-code me-1"></i> Generate Classes
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="output-section" id="output">
                                    <h5 class="mb-3 fw-bold">Generated Classes <small class="text-muted">(Copy these)</small></h5>
                                    <div class="class-list position-relative mb-3" id="classOutput">
                                        <span class="fst-italic text-muted">Select options and click "Generate Classes" to see the result.</span>
                                        <button id="copyClasses" type="button" class="copy-button d-none">
                                            <i class="fal fa-copy me-1"></i> Copy
                                        </button>
                                    </div>

                                    <div class="app-fob-showcase-text" data-prefix="Preview">
                                        <div id="breakpointIndicators" class="mb-2">
                                            <span class="breakpoint-indicator" data-bp="xs">xs</span>
                                            <span class="breakpoint-indicator" data-bp="sm">sm</span>
                                            <span class="breakpoint-indicator" data-bp="md">md</span>
                                            <span class="breakpoint-indicator" data-bp="lg">lg</span>
                                            <span class="breakpoint-indicator" data-bp="xl">xl</span>
                                            <span class="breakpoint-indicator" data-bp="xxl">xxl</span>
                                        </div>
                                        <div id="testDiv">
                                            <div>This element will update based on your selections</div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <a class="btn btn-link btn-sm p-0" data-bs-toggle="collapse" href="#cssEquivalent" role="button" aria-expanded="false">
                                            <i class="fal fa-code me-1"></i> Show CSS Equivalent
                                        </a>
                                        <div class="collapse mt-2" id="cssEquivalent">
                                            <div class="position-relative">
                                                <div class="css-output" id="cssOutput">
                                                    <span class="fst-italic text-muted">/* CSS will appear here */</span>
                                                </div>
                                                <button id="copyCSS" type="button" class="copy-button d-none">
                                                    <i class="fal fa-copy me-1"></i> Copy
                                                </button>
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

    <script src="scripts/pages/visibilitygenerator.js"></script>

</body>

</html>