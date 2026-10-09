<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Fontawesome Icons")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Fontawesome Icons", "pageSubTitle1" => "Design", "pageSubTitle2" => "Iconography", "pageSubText" => "Collection of over <strong>7k+</strong> icons, with a variety of styles, ranging from <strong>solid</strong>, <strong>regular</strong>, <strong>light</strong> and <strong>duotone</strong>.")) ?>

                    <div class="main-content" >
                        <div class="card">
                            <div class="card-body" style="min-height: calc(100vh - 340px);">

                                <!-- Search -->
                                <div class="input-group mb-3">
                                    <input type="text" id="searchIcons" class="form-control form-control-lg" placeholder="Search icons..." autocomplete="off">
                                    <!-- Option Selector Instead of Dropdown -->
                                    <select id="iconSetSelect" class="form-select pe-2 ps-3" aria-label="Filter Icons" style="max-width: 130px;">
                                        <option value="fal" selected>Light</option>
                                        <option value="far">Regular</option>
                                        <option value="fas">Solid</option>
                                        <option value="fad">Duotone</option>
                                    </select>
                                    <span class="input-group-text px-3">
                                        <i class="sa sa-magnifier"></i>
                                    </span>
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
        document.addEventListener('DOMContentLoaded', () => {
            const iconSelect = document.getElementById('iconSetSelect');
            iconSelect.addEventListener('change', function () {
                loadIconSet(this.value); // Use loadIconSet as in your original setup
            });
            loadIconSet('fal'); // Initial load
        });
    </script>

</body>

</html>