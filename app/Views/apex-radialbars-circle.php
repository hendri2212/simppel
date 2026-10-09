<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Apex RadialBars/Circle Chart")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Apex RadialBars/Circle Chart", "pageSubTitle1" => "Data Visualization", "pageSubTitle2" => "Apex Charts", "pageSubText" => "Encapsulate your objectives with this chart\u2014ideal for monitoring progress with precision.")) ?>

                    <div class="main-content" >
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Basic RadialBars -->
                                <div id="panel-1" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Basic <span class="fw-light"><i>RadialBars</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="basic-radialbar-chart"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Custom Angle Circle -->
                                <div id="panel-3" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Custom Angle Circle <span class="fw-light"><i>RadialBars</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="custom-angle-circle-chart"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Radialbars with Image -->
                                <div id="panel-5" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Radialbars with Image <span class="fw-light"><i>RadialBars</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="radialbar-with-image-chart"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Semi Circle Gauge -->
                                <div id="panel-7" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Semi Circle Gauge <span class="fw-light"><i>RadialBars</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="semi-circle-gauge-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <!-- Multiple RadialBars -->
                                <div id="panel-2" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Multiple <span class="fw-light"><i>RadialBars</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="multiple-radialbar-chart"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gradient RadialBars -->
                                <div id="panel-4" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Gradient <span class="fw-light"><i>RadialBars</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="gradient-radialbar-chart"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stroked Gauge -->
                                <div id="panel-6" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2> Stroked Gauge <span class="fw-light"><i>RadialBars</i></span>
                                        </h2>
                                        <div class="panel-toolbar">
                                            <button type="button" class="btn btn-panel" data-action="panel-collapse" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Toggle">
                                                <svg class="sa-icon">
                                                    <use class="panel-collapsed-icon" href="/img/sprite.svg#minus-circle"></use>
                                                    <use class="panel-expand-icon" href="/img/sprite.svg#plus-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-fullscreen" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Fullscreen">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#stop-circle"></use>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-panel" data-action="panel-close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,10" data-bs-original-title="Close">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#x-circle"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-container">
                                        <div class="panel-content">
                                            <div id="stroked-gauge-chart"></div>
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

    <script type="module" src="scripts/pages/apexradialbarscirclechart.js"></script>

</body>

</html>