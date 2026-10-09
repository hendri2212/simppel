<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Spinners")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Spinners", "pageSubTitle1" => "Design", "pageSubTitle2" => "UI Components", "pageSubText" => "Bootstrap spinners are animated loading indicators used to show that a process is ongoing, available in various styles and sizes.")) ?>

                    <div class="main-content" >

                        <div class="info-container">
                            CSS "spinners" can be used to show the loading state in your projects. They're built only with HTML and CSS,
                            meaning you don't need any JavaScript to create them. You will, however, need some custom JavaScript to toggle
                            their visibility. Their appearance, alignment, and sizing can be easily customized with our amazing utility classes.
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div id="panel-1" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Border <span class="fw-300"><i>spinner</i></span>
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
                                                Use the border spinners for a lightweight loading indicator
                                            </div>
                                            <div class="spinner-border" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-2" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Color <span class="fw-300"><i>spinners</i></span>
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
                                                The border spinner uses <code>currentColor</code> for its <code>border-color</code>, meaning you can customize the color with <a href="#" target="_blank">text color utilities</a>. You can use any of our text color utilities on the standard spinner
                                            </div>
                                            <div class="demo">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border text-secondary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border text-success" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border text-danger" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border text-warning" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border text-info" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border text-light" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border text-dark" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-3" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Spinner <span class="fw-300"><i>Alignment</i></span>
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

                                            </div>
                                            <h5 class="frame-heading">
                                                Flex
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="border p-3">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Float
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="border p-3">
                                                    <div class="d-flex align-items-center">
                                                        <strong>Loading...</strong>
                                                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Text align
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="border p-3">
                                                    <div class="text-start">
                                                        <div class="spinner-border" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="panel-4" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Spinner <span class="fw-300"><i>sizes</i></span>
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
                                                Add <code>.spinner-border-sm</code> to make a smaller spinner that can quickly be used within other components. Or, use custom CSS or inline styles to change the dimensions as needed.
                                            </div>
                                            <div class="demo-h-spacing">

                                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border spinner-border-sm" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="panel-5" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Shape <span class="fw-300"><i>changes</i></span>
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
                                                Change the shape of your spinner using border utilities
                                            </div>
                                            <div class="demo-h-spacing">
                                                <div class="spinner-border rounded-0 text-primary" style="width: 3rem; height: 3rem;" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border rounded-0 text-danger" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-border rounded-0 text-info spinner-border-sm" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="panel-6" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Spinner <span class="fw-300"><i>nested</i></span>
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
                                                Use spinners within buttons to indicate an action is currently processing or taking place. You may also swap the text out of the spinner element and utilize button text as needed.
                                            </div>
                                            <div class="demo">
                                                <button class="btn btn-success btn-icon rounded-circle" type="button" disabled>
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Loading...</span>
                                                </button>
                                                <button class="btn btn-primary" type="button" disabled>
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Loading...</span>
                                                </button>
                                                <button class="btn btn-info" type="button" disabled>
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    Loading...
                                                </button>
                                                <button class="btn btn-danger rounded-pill" type="button" disabled>
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    Loading...
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div id="panel-7" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Growing <span class="fw-300"><i>spinner</i></span>
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
                                                If you don't fancy a border spinner, switch to the grow spinner
                                            </div>
                                            <div class="spinner-grow" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-8" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Growing <span class="fw-300"><i>spinner colors</i></span>
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
                                                Once again, this spinner is built with <code>currentColor</code>, so you can easily change its appearance with <a href="#" target="_blank">text color utilities</a>
                                            </div>
                                            <div class="demo">
                                                <div class="spinner-grow text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-secondary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-success" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-danger" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-warning" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-info" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-light" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow text-dark" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-9" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Growing <span class="fw-300"><i>spinner alignment</i></span>
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

                                            </div>
                                            <h5 class="frame-heading">
                                                Flex
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="border p-3">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="spinner-grow" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Float
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="border p-3">
                                                    <div class="d-flex align-items-center">
                                                        <strong>Loading...</strong>
                                                        <div class="spinner-grow ms-auto" role="status" aria-hidden="true"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Text align
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="border p-3">
                                                    <div class="text-start">
                                                        <div class="spinner-grow" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="panel-10" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Growing <span class="fw-300"><i>spinner sizes</i></span>
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
                                                Add <code>.spinner-grow-sm</code> to make a smaller spinner that can quickly be used within other components. Or, use custom CSS or inline styles to change the dimensions as needed.
                                            </div>
                                            <div class="demo-h-spacing">
                                                <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow spinner-grow-sm" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="panel-11" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Shape <span class="fw-300"><i>shifting</i></span>
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
                                                Change the shape of your growing spinner using border utilities
                                            </div>
                                            <div class="demo-h-spacing">
                                                <div class="spinner-grow rounded-0 text-primary" style="width: 3rem; height: 3rem;" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow rounded-0 text-danger" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div class="spinner-grow spinner-grow-sm rounded-0 text-info" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="panel-12" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Growing <span class="fw-300"><i>spinner nested</i></span>
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
                                                Use spinners within buttons to indicate an action is currently processing or taking place. You may also swap the text out of the spinner element and utilize button text as needed.
                                            </div>
                                            <div class="demo">
                                                <button class="btn btn-success btn-icon rounded-circle" type="button" disabled>
                                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Loading...</span>
                                                </button>
                                                <button class="btn btn-primary" type="button" disabled>
                                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Loading...</span>
                                                </button>
                                                <button class="btn btn-info" type="button" disabled>
                                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                    Loading...
                                                </button>
                                                <button class="btn btn-danger rounded-pill" type="button" disabled>
                                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                    Loading...
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

</body>

</html>