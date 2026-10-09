<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Stack Generator")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Stack Generator", "pageSubTitle1" => "Design", "pageSubTitle2" => "Iconography", "pageSubText" => "Create custom, unqiue, layered icons from various libraries for projects, offering flexibility and scalability. <a href='https://youtu.be/MUXiZ15KOBM' target='_blank'> See Video Tutorial</a>")) ?>

                    <div class="main-content" >

                        <div id="stackgenerator-container" class="main-content icon-zoom-4 grid-background position-relative overflow-hidden sortable-inactive d-flex flex-column border">
                            <div class="position-absolute d-flex flex-row justify-content-between top-0 start-0 end-0 p-3">
                                <div class="d-flex flex-row gap-2">
                                    <button type="button" class="btn btn-icon btn-secondary" data-action="toggle-swap" data-target="#stackgenerator-container" data-toggleclass="grid-background-dark">
                                        <svg class="sa-icon sa-icon-2x sa-icon-light">
                                            <use href="/icons/sprite.svg#sun"></use>
                                        </svg>
                                    </button>
                                    <div class="btn-group" role="group" aria-label="Default button group">
                                        <button id="zoomInBtn" type="button" class="btn btn-icon btn-secondary">
                                            <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                <use href="/icons/sprite.svg#plus-circle"></use>
                                            </svg>
                                        </button>
                                        <button id="zoomOutBtn" type="button" class="btn btn-icon btn-secondary">
                                            <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                <use href="/icons/sprite.svg#minus-circle"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex flex-row gap-2"></div>
                            </div>
                            <div class="position-absolute d-flex flex-row justify-content-between bottom-0 start-0 end-0 p-3">
                                <div class="d-flex flex-row gap-2">
                                    <button id="copy-icon" type="button" class="btn btn-sm btn-secondary shadow-0">
                                        Copy Icon
                                    </button>
                                    <button id="reset-layers" type="button" class="btn btn-sm btn-danger shadow-0">
                                        Reset
                                    </button>
                                    <button id="save-icon" type="button" class="btn btn-sm btn-success shadow-0">
                                        Save
                                    </button>
                                </div>
                            </div>
                            <!-- Stack Control Panel -->
                            <div id="stack-control" class="panel border-secondary border-3 border-opacity-50 rounded overflow-hidden rounded">
                                <div class="panel-hdr text-white ps-3 pe-2 rounded-top-0 border-bottom">
                                    <h2 class="ps-0"> Controls</h2>
                                    <div class="panel-toolbar pe-0">
                                        <button id="add-layer" type="button" class="btn btn-xs btn-outline-secondary shadow-0 align-self-center" data-bs-toggle="modal" data-bs-target="#example-modal-backdrop-transparent">
                                            Add Layer
                                        </button>
                                    </div>
                                </div>
                                <div class="panel-container show">
                                    <div class="panel-content p-0">
                                        <!-- Layer 1 -->
                                        <div class="stack-layers d-flex flex-row border-bottom position-relative">
                                            <div class="stack-icon-preview flex-shrink-0 d-flex align-items-center justify-content-center">
                                                <svg class="sa-icon sa-icon-3x">
                                                    <use href="/icons/sprite.svg#sun"></use>
                                                </svg>
                                            </div>
                                            <div class="icon-settings flex-grow-1 border-left px-2 py-1">
                                                fal fa-car
                                                <span class="badge badge-icon">
                                                    Layer 1
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Layer 2 -->
                                        <div class="stack-layers d-flex flex-row border-bottom position-relative">
                                            <div class="stack-icon-preview flex-shrink-0 d-flex align-items-center justify-content-center">
                                                <i class="sa base-2 sa-icon-3x"></i>
                                            </div>
                                            <div class="icon-settings flex-grow-1 border-left px-2 py-1">
                                                sa base-2
                                                <span class="badge badge-icon">
                                                    Layer 2
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="stack-playground" class="flex-grow-1 d-flex align-items-center justify-content-center" style="min-height: 684px;">
                                <div id="my-icon">
                                    <div class="icon-layers">
                                        <i class="sa sa-base-2 stack-3x text-success"></i>
                                    </div>
                                    <div class="icon-layers">
                                        <i class="sa sa-base-10 stack-1x text-dark"></i>
                                    </div>
                                    <div class="icon-layers">
                                        <svg class="sa-icon sa-bold stack-1x sa-icon-danger">
                                            <use href="/icons/sprite.svg#alert-triangle"></use>
                                        </svg>
                                    </div>
                                    <div class="icon-layers">
                                        <svg class="sa-icon sa-bold sa-icon-warning stack-1x">
                                            <use href="/icons/sprite.svg#sun"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="empty-msg d-none text-center p-3 body-bg border border-2 rounded text-muted">
                                    <h4>To get started</h4>
                                    <p class="mb-0"><strong>Add Layer</strong> to your icon stack from <strong>Controls</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- modal -->
                        <div class="modal fade modal-backdrop-transparent" id="example-modal-backdrop-transparent" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Select an Icon</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">

                                        <!-- Search -->
                                        <div class="input-group p-3">
                                            <input type="text" id="searchIcons" class="form-control form-control-lg" placeholder="Search icons..." autocomplete="off">
                                            <select id="iconSetSelect" class="form-select pe-2 ps-3" aria-label="Filter Icons" style="max-width: 130px;">
                                                <option value="svg" selected="">SVG</option>
                                                <option value="base">Base</option>
                                                <option value="sa">SmartAdmin</option>
                                                <option value="fal">Light</option>
                                                <option value="far">Regular</option>
                                                <option value="fas">Solid</option>
                                                <option value="fad">Duotone</option>
                                            </select>
                                        </div>

                                        <!-- Results Count and Search History -->
                                        <div class="row mb-3 hidden-sm">
                                            <div class="col-sm-8">
                                                <div id="searchHistory" class="search-history text-sm-start d-flex flex-wrap gap-2 ps-3"></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="results-count text-muted mb-0 text-sm-end ps-3 ps-sm-0 pe-lg-3"></p>
                                            </div>
                                        </div>

                                        <!-- Suggestions -->
                                        <div id="suggestions" class="px-3"></div>

                                        <!-- Icons List -->
                                        <ul id="iconList" style="max-height: 350px;" class="stack-demo list-unstyled d-flex flex-wrap justify-content-evenly gap-2 py-1 px-2 mb-0"></ul>

                                        <!-- No Results Message -->
                                        <div class="no-results-msg pt-3">
                                            <h5 class="mb-4 px-3">
                                                No icons found. Try searching with different keywords
                                            </h5>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary waves-effect waves-themed" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary waves-effect waves-themed">Select Icon</button>
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

    <script src="scripts/pages/stackgenerator.js"></script>

    <script>
        /* Inject additional scripts dynamically */
        document.addEventListener('DOMContentLoaded', function () {
            // Load the default icon set
            loadIconSet('svg');
            // Add event listener to the icon set select
            document.getElementById('iconSetSelect').onchange = function () {
                var selectedValue = this.value; // Get the selected option's value
                loadIconSet(selectedValue); // Call the function with the value
            };
        });
    </script>

</body>

</html>