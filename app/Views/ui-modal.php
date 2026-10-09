<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Modal")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Modal", "pageSubTitle1" => "Design", "pageSubTitle2" => "UI Components", "pageSubText" => "Modal dialogs for lightboxes, user notifications, or completely custom content")) ?>
                   
                    <div class="main-content" >

                        <div class="info-container">
                            <p>Modals are built with HTML, CSS, and JavaScript. They're positioned over everything else in the document and remove
                                scroll from the <code>body</code> so that modal content scrolls instead. Bootstrap only supports one modal window
                                at a time. Nested modals aren't supported as it is believed to be poor user experiences.
                                Modals use <code>position: fixed</code>, which can sometimes be a bit particular about its rendering.
                                Whenever possible, place your modal HTML in a top-level position to avoid potential interference from other elements.
                                You'll likely run into issues when nesting a .modal within another fixed element</p>
                            <p class="mb-0">
                                Find in-depth, guidelines, tutorials and more on Bootstrap Modals's at the
                                <a href="https://getbootstrap.com/docs/5.3/components/modal/" target="_blank">official documentation</a>.
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <!--Basic Modals-->
                                <div id="panel-1" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Basic <span class="fw-300"><i>Modals</i></span>
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
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Below is a static modal example (meaning its position and display have been overridden). Included are the modal header, modal body (required for padding), and modal footer (optional). We ask that you include modal headers with dismiss actions whenever possible, or provide another explicit dismiss action.
                                            </div>

                                            <!-- Modal Small -->
                                            <div class="modal fade" id="default-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                Modal Small
                                                            </h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Default -->
                                            <div class="modal fade" id="default-example-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                Modal Default
                                                            </h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Large -->
                                            <div class="modal fade" id="default-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modal Large</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal XL -->
                                            <div class="modal fade" id="default-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modal XL</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Small Center -->
                                            <div class="modal fade" id="default-example-modal-sm-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modal Small Center</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal center -->
                                            <div class="modal fade" id="default-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                Modal Center
                                                            </h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Large Center -->
                                            <div class="modal fade" id="default-example-modal-lg-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modal Large Center</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal XL Center -->
                                            <div class="modal fade" id="default-example-modal-xl-center" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modal XL Center</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="frame-heading">
                                                Default
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <!-- Small modal -->
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#default-example-modal-sm">
                                                        Small
                                                    </button>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#default-example-modal">
                                                        Normal
                                                    </button>
                                                    <!-- Large modal -->
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#default-example-modal-lg">
                                                        Large
                                                    </button>
                                                    <!-- XL modal -->
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#default-example-modal-xl">
                                                        XL
                                                    </button>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Centered
                                            </h5>
                                            <div class="frame-wrap mb-0">
                                                <div class="demo">
                                                    <!-- Small modal -->
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#default-example-modal-sm-center">
                                                        Small
                                                    </button>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#default-example-modal-center">
                                                        Normal
                                                    </button>
                                                    <!-- Large modal -->
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#default-example-modal-lg-center">
                                                        Large
                                                    </button>
                                                    <!-- XL modal -->
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#default-example-modal-xl-center">
                                                        XL
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Side Modals-->
                                <div id="panel-2" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Side <span class="fw-300"><i>Modals</i></span>
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
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Modals can be positioned on different sides of the page using modifier classes like <code>.modal-dialog-start</code>, <code>.modal-dialog-end</code>, <code>.modal-dialog-top</code>, and <code>.modal-dialog-bottom</code> on <code>.modal-dialog</code>. These side modals also support size classes.
                                            </div>
                                            <!-- ALL END MODALS -->
                                            <!-- Modal End -->
                                            <div class="modal fade default-example-modal-end" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-end">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4">Modal End</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal End Small -->
                                            <div class="modal fade default-example-modal-end-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-end modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4">Modal End Small</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal End Large -->
                                            <div class="modal fade default-example-modal-end-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-end modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4">Modal End Large</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal End XL -->
                                            <div class="modal fade default-example-modal-end-xl" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-end modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4">Modal End XL</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ALL START MODALS -->
                                            <!-- Modal Start -->
                                            <div class="modal fade default-example-modal-start" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-start">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4">Modal Start</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Start Small -->
                                            <div class="modal fade default-example-modal-start-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-start modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4">Modal Start Small</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Start Large -->
                                            <div class="modal fade default-example-modal-start-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-start modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4">Modal Start Large</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Start XL -->
                                            <div class="modal fade default-example-modal-start-xl" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-start modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h4">Modal Start XL</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ALL HORIZONTAL MODALS -->
                                            <!-- Modal Top -->
                                            <div class="modal fade default-example-modal-top" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Bottom -->
                                            <div class="modal fade default-example-modal-bottom" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-bottom">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="alert alert-success m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <h5 class="frame-heading">
                                                End
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-end-sm">
                                                        Small
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-end">
                                                        Normal
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-end-lg">
                                                        Large
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-end-xl">
                                                        XL
                                                    </button>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Start
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-start-sm">
                                                        Small
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-start">
                                                        Normal
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-start-lg">
                                                        Large
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-start-xl">
                                                        XL
                                                    </button>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Top & Bottom
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-top">
                                                        Top
                                                    </button>
                                                    <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target=".default-example-modal-bottom">
                                                        Bottom
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <!--Modifications-->
                                <div id="panel-3" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Modifications <span class="fw-300"><i>for modals</i></span>
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
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Modal fullscreen uses combination of utility classes and the modifier class <code>.modal-fullscreen</code>. Using the modifer class <code>.modal-backdrop-transparent</code> makes the backdrop transparent. You can also translate the modals to cast as an alert by using the modifier class <code>.modal-alert</code>
                                            </div>

                                            <h5 class="frame-heading">
                                                Fullscreen
                                            </h5>
                                            <div class="frame-wrap">
                                                <button type="button" class="btn btn-lg btn-default" data-bs-toggle="modal" data-bs-target=".example-modal-fullscreen">Modal Fullscreen</button>
                                            </div>
                                            <!-- Fullscreen Modal -->
                                            <div class="modal fade example-modal-fullscreen" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-fullscreen" role="document">
                                                    <div class="modal-dialog modal-fullscreen">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-4" id="exampleModalFullscreenLabel">Full screen modal</h1>
                                                                <button class="btn btn-system ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                    <svg class="sa-icon sa-icon-2x">
                                                                        <use href="/icons/sprite.svg#x"></use>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Another override is the option to pop up a modal that covers the user viewport, available via modifier
                                                                    classes that are placed on a <code>.modal-dialog</code>.</p>

                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Class</th>
                                                                                <th>Availability</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><code>.modal-fullscreen</code></td>
                                                                                <td>Always</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><code>.modal-fullscreen-sm-down</code></td>
                                                                                <td><code>576px</code></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><code>.modal-fullscreen-md-down</code></td>
                                                                                <td><code>768px</code></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><code>.modal-fullscreen-lg-down</code></td>
                                                                                <td><code>992px</code></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><code>.modal-fullscreen-xl-down</code></td>
                                                                                <td><code>1200px</code></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><code>.modal-fullscreen-xxl-down</code></td>
                                                                                <td><code>1400px</code></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="frame-heading">
                                                Alert
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <button type="button" class="btn btn-default btn-has-sound d-flex-inline align-items-center" data-bs-toggle="modal" data-bs-target="#example-modal-alert" data-action="playsound" data-soundpath="media/sound/" data-soundfile="error.mp3">

                                                        <i class="sa sa-bell me-1"></i>
                                                        Modal Alert (with sound)
                                                    </button>
                                                    <button type="button" class="btn btn-default d-flex-inline align-items-center" data-bs-toggle="modal" data-bs-target="#example-modal-alert-alt">
                                                        Modal Alert Alt
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- modal alert -->
                                            <div class="modal modal-alert fade" id="example-modal-alert" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content bg-dark bg-opacity-75 shadow-5 border-left-0 border-right-0 ">
                                                        <div class="modal-header border-bottom-0">
                                                            <h5 class="modal-title"><svg class="sa-icon me-2 sa-icon-warning sa-icon-2x sa-bold">
                                                                    <use href="/icons/sprite.svg#alert-triangle"></use>
                                                                </svg>Big Modal Alert</h5>
                                                        </div>
                                                        <div class="modal-body border-bottom-0 fw-300 fs-sm">
                                                            <span class="fw-bold">Warning:</span> With a bold stern warning message to get your attention.
                                                        </div>
                                                        <div class="modal-footer border-top-0">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-warning">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- modal alert alt -->
                                            <div class="modal modal-alert fade" id="example-modal-alert-alt" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content bg-success bg-opacity-75 border-left-0 border-right-0">
                                                        <div class="modal-header border-bottom-0">
                                                            <h5 class="modal-title">Modal title</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body border-bottom-0">
                                                            We use bootstrap utilities to create a cutomized alert modal
                                                        </div>
                                                        <div class="modal-footer border-top-0">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="frame-heading">
                                                No backdrops
                                            </h5>
                                            <div class="frame-wrap">
                                                <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#example-modal-backdrop-transparent">Modal No Backdrop</button>
                                            </div>

                                            <!-- Modal center Large no backdrop -->
                                            <div class="modal fade modal-backdrop-transparent" id="example-modal-backdrop-transparent" data-bs-backdrop="false" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modal title</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger">
                                                                Notice how there is no backdrop to this modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="frame-heading">
                                                Static backdrop
                                            </h5>
                                            <div class="frame-wrap">
                                                <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#example-modal-backdrop-static">Modal Static Backdrop</button>
                                            </div>

                                            <!-- Modal center Large no backdrop -->
                                            <div class="modal fade example-modal-backdrop-static" id="example-modal-backdrop-static" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modal Static Backdrop</h5>
                                                            <button type="button" class="btn btn-system ms-auto" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger">
                                                                Notice how there is a static backdrop to this modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Transparent-->
                                <div id="panel-4" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Transparent <span class="fw-300"><i>Modal (Tinted)</i></span>
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
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <div class="panel-tag">
                                                Give modals a 'transparent tinted glass' feel using only utility classes.
                                            </div>
                                            <!-- Modal Top Transparent -->
                                            <div class="modal fade example-modal-top-transparent" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top ">
                                                    <div class="modal-content bg-dark bg-opacity-75 shadow-5">
                                                        <div class="modal-body">
                                                            <div class="alert alert-primary bg-primary border-primary text-primary border-opacity-50 bg-opacity-10 m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Bottom Transparent -->
                                            <div class="modal fade example-modal-bottom-transparent" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-bottom">
                                                    <div class="modal-content bg-dark bg-opacity-75 shadow-5">
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning bg-warning border-warning text-warning border-opacity-50 bg-opacity-10 m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal End Transparent-->
                                            <div class="modal fade example-modal-end-transparent" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-end modal-sm">
                                                    <div class="modal-content bg-dark bg-opacity-75 shadow-5">
                                                        <div class="modal-header border-bottom-0">
                                                            <h4 class="modal-title text-white">
                                                                Transparent End
                                                                <small class="m-0 text-white opacity-70">
                                                                    Below is a static modal example
                                                                </small>
                                                            </h4>
                                                            <button class="btn btn-system btn-system-light ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger bg-danger border-danger text-danger border-opacity-50 bg-opacity-10">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Start Transparent-->
                                            <div class="modal fade example-modal-start-transparent" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-start modal-sm">
                                                    <div class="modal-content modal-content bg-dark bg-opacity-75 shadow-5">
                                                        <div class="modal-header border-bottom-0">
                                                            <h5 class="modal-title h4 text-white">Large start side modal</h5>
                                                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger bg-danger border-danger text-danger border-opacity-50 bg-opacity-10 m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Center Transparent -->
                                            <div class="modal fade example-modal-centered-transparent" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content bg-dark bg-opacity-75 shadow-5">
                                                        <div class="modal-header border-bottom-0">
                                                            <h4 class="modal-title text-white">
                                                                Transparent Centered
                                                                <small class="m-0 text-white opacity-70">
                                                                    Below is a static modal example
                                                                </small>
                                                            </h4>
                                                            <button class="btn btn-system btn-system-light ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-success bg-success border-success text-success border-opacity-50 bg-opacity-10 m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Default Transparent -->
                                            <div class="modal fade example-modal-default-transparent" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content bg-dark bg-opacity-75 shadow-5">
                                                        <div class="modal-header border-bottom-0">
                                                            <h4 class="modal-title text-white">
                                                                Transparent Default
                                                                <small class="m-0 text-white opacity-70">
                                                                    Below is a static modal example
                                                                </small>
                                                            </h4>
                                                            <button class="btn btn-system btn-system-light ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                <svg class="sa-icon sa-icon-2x sa-icon-light">
                                                                    <use href="/icons/sprite.svg#x"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-success bg-success border-success text-success border-opacity-50 bg-opacity-10 m-0">
                                                                This is the content area of the modal.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Default
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <button type="button" class="btn btn btn-dark" data-bs-toggle="modal" data-bs-target=".example-modal-default-transparent">
                                                        Default
                                                    </button>
                                                    <button type="button" class="btn btn btn-dark" data-bs-toggle="modal" data-bs-target=".example-modal-centered-transparent">
                                                        Centered
                                                    </button>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Start & End
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <button type="button" class="btn btn btn-dark" data-bs-toggle="modal" data-bs-target=".example-modal-start-transparent">
                                                        Start
                                                    </button>
                                                    <button type="button" class="btn btn btn-dark" data-bs-toggle="modal" data-bs-target=".example-modal-end-transparent">
                                                        End
                                                    </button>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Top & Bottom
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <button type="button" class="btn btn btn-dark" data-bs-toggle="modal" data-bs-target=".example-modal-top-transparent">
                                                        Top
                                                    </button>
                                                    <button type="button" class="btn btn btn-dark" data-bs-toggle="modal" data-bs-target=".example-modal-bottom-transparent">
                                                        Bottom
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

            </div>

            <?= $this->include('partials/app-footer') ?>

        </main>

        <?= $this->include('partials/app-drawer') ?>

        <?= $this->include('partials/app-settings') ?>

    </div>

    <?= $this->include('partials/app-scripts') ?>

</body>

</html>