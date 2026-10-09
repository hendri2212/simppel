<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "System Icons")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "System Icons", "pageSubTitle1" => "Icons", "pageSubTitle2" => "Design", "pageSubText" => "Fully customizable system icons with a variety of weights, colors, and styles.")) ?>

                    <div class="main-content" >
                        <div class="card">
                            <div class="card-body" style="min-height: calc(100vh - 340px);">

                                <!-- Search -->
                                <div class="input-group mb-3">
                                    <input type="text" id="searchIcons" class="form-control form-control-lg" placeholder="Search icons..." autocomplete="off">
                                    <!-- Option Selector Instead of Dropdown -->
                                    <select id="iconSetSelect" class="form-select pe-2 ps-3" aria-label="Filter Icons" style="max-width: 110px;">
                                        <option value="sa-thin" selected>Thin</option>
                                        <option value="sa-regular">Normal</option>
                                        <option value="sa-medium">Medium</option>
                                        <option value="sa-bold">Bold</option>
                                    </select>
                                    <div class="input-group-text px-3">
                                        <input type="checkbox" id="fillIcons" class="form-check-input mt-0">
                                        <label for="fillIcons" class="form-check-label ps-2">No Fill</label>
                                    </div>
                                </div>

                                <!-- Results Count and Search History -->
                                <div class="row mb-3">
                                    <div id="searchHistory" class="search-history col-sm-6 text-sm-start d-flex flex-wrap gap-2"></div>
                                    <p class="results-count text-muted mb-0 col-sm-6 text-sm-end"></p>
                                </div>

                                <!-- Suggestions -->
                                <div id="suggestions"></div>

                                <!-- Icons List -->
                                <ul id="iconList" class="list-unstyled row g-4"></ul>

                                <!-- No Results Message -->
                                <div class="no-results-msg pt-3">
                                    <h5 class="mb-4">
                                        No icons found. Try searching with different keywords
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <!-- Toast -->
                        <div class="toast-container position-fixed top-0 end-0 p-3">
                            <div id="liveToast" class="toast hide align-items-center border-0 py-2 px-3" style="--bs-toast-max-width: auto;" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 11">
                                <div class="d-flex">
                                    <div class="toast-body d-flex align-items-center justify-content-center"></div>
                                    <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="toast" aria-label="Close">
                                        <svg class="sa-icon">
                                            <use href="/icons/sprite.svg#x"></use>
                                        </svg>
                                    </button>
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

    <!-- Page Specific scripts -->
    <script src="scripts/pages/iconography.js"></script>

    <script>
        /* Inject additional scripts dynamically */
        // Initialize when DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            function initializeSvgControls() {
                const weightSelect = document.getElementById('iconSetSelect');
                const noFillCheckbox = document.getElementById('fillIcons');
                weightSelect.addEventListener('change', () => {
                    currentSvgWeight = weightSelect.value;
                    if (currentIconSet === 'svg') {
                        updateSvgClasses();
                    }
                });
                noFillCheckbox.addEventListener('change', () => {
                    isNoFill = noFillCheckbox.checked;
                    if (currentIconSet === 'svg') {
                        updateSvgClasses();
                    }
                });
            }
            // Initialize SVG controls for weight and fill
            initializeSvgControls();
            loadIconSet('svg');
        });
    </script>

</body>

</html>