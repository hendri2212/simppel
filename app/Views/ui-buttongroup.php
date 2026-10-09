<?= $this->include('partials/app-html') ?>

<head>    
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Button Group")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Button Group", "pageSubTitle1" => "Design", "pageSubTitle2" => "UI Components", "pageSubText" => "Group a series of buttons together on a single line or stack them in a vertical column.")) ?>

                    <div class="main-content" >
                        <div class="info-container">
                            <p class="mb-0">
                                The <code>.btn</code> styles can be applied to other elements, such as <code>&lt;label&gt;</code>s, to provide checkbox or radio style button toggling. Add <code>data-bs-toggle="buttons"</code> to a <code>.btn-group</code> containing those modified buttons to enable their toggling behavior via JavaScript.
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <!--Sizes-->
                                <div id="panel-1" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>Sizes <span class="fw-300"><i>example</i></span></h2>
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
                                            <div class="panel-tag">
                                                Instead of applying button sizing classes to every button in a group, just add <code>.btn-group-*</code> to each <code>.btn-group</code>, including each one when nesting multiple groups.
                                            </div>
                                            <div class="demo demo-v-spacing-lg">
                                                <div class="btn-group btn-group-lg" role="group" aria-label="Large button group">
                                                    <button type="button" class="btn btn-secondary">Left</button>
                                                    <button type="button" class="btn btn-secondary">Middle</button>
                                                    <button type="button" class="btn btn-secondary">Right</button>
                                                </div>
                                                <br>
                                                <div class="btn-group" role="group" aria-label="Default button group">
                                                    <button type="button" class="btn btn-secondary">Left</button>
                                                    <button type="button" class="btn btn-secondary">Middle</button>
                                                    <button type="button" class="btn btn-secondary">Right</button>
                                                </div>
                                                <br>
                                                <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                                    <button type="button" class="btn btn-secondary">Left</button>
                                                    <button type="button" class="btn btn-secondary">Middle</button>
                                                    <button type="button" class="btn btn-secondary">Right</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Nesting-->
                                <div id="panel-2" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>Nesting <span class="fw-300"><i>example</i></span></h2>
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
                                            <div class="panel-tag">
                                                Place a <code>.btn-group</code> within another <code>.btn-group</code> when you want dropdown menus mixed with a series of buttons.
                                            </div>
                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                <button type="button" class="btn btn-secondary">1</button>
                                                <button type="button" class="btn btn-secondary">2</button>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dropdown
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                                        <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Vertical-->
                                <div id="panel-3" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>Vertical <span class="fw-300"><i>variation</i></span></h2>
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
                                            <div class="panel-tag">
                                                Make a set of buttons appear vertically stacked rather than horizontally using class <code>.btn-group-vertical</code>. <strong>Split button dropdowns are not supported here.</strong>
                                            </div>
                                            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                                <button type="button" class="btn btn-primary">Button</button>
                                                <button type="button" class="btn btn-primary">Button</button>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Dropdown
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                                        <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                                    </ul>
                                                </div>
                                                <button type="button" class="btn btn-primary">Button</button>
                                                <button type="button" class="btn btn-primary">Button</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <!--Checkbox and radio-->
                                <div id="panel-4" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>Checkbox and Radio <span class="fw-300"><i>buttons</i></span></h2>
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
                                            <div class="panel-tag">
                                                <code>.button</code> styles can be applied to other elements, such as <code><label></label></code>s, to provide checkbox or radio style button toggling. Add <code>data-toggle="buttons"</code> to a <code>.btn-group</code> containing those modified buttons to enable their toggling behavior via JavaScript and add <code>.btn-group-toggle</code> to style the <code>input</code>s within your buttons. <strong>Note that you can create single input-powered buttons or groups of them.</strong>
                                            </div>
                                            <div class="alert alert-info">
                                                The checked state for these buttons is <strong>only updated via <code>click</code> event</strong> on the button. If you use another method to update the input—e.g., with <code>input type="reset"</code> or by manually applying the input’s <code>checked</code> property—you’ll need to toggle <code>.active</code> on the <code>label</code> manually.
                                            </div>
                                            <h5 class="frame-heading">Checkbox</h5>
                                            <div class="frame-wrap">
                                                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                                    <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
                                                    <label class="btn btn-primary" for="btncheck1">Checkbox 1</label>

                                                    <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off">
                                                    <label class="btn btn-primary" for="btncheck2">Checkbox 2</label>

                                                    <input type="checkbox" class="btn-check" id="btncheck3" autocomplete="off">
                                                    <label class="btn btn-primary" for="btncheck3">Checkbox 3</label>
                                                </div>
                                            </div>

                                            <h5 class="frame-heading mt-3">Radio</h5>
                                            <div class="frame-wrap">
                                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                                                    <label class="btn btn-primary" for="btnradio1">Radio 1</label>

                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                                                    <label class="btn btn-primary" for="btnradio2">Radio 2</label>

                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                                                    <label class="btn btn-primary" for="btnradio3">Radio 3</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Toolbar-->
                                <div id="panel-5" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>Toolbar <span class="fw-300"><i>example</i></span></h2>
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
                                            <div class="panel-tag">
                                                Combine sets of button groups into button toolbars for more complex components. Use utility classes as needed to space out groups, buttons, and more.
                                            </div>
                                            <div class="btn-toolbar mb-3" role="group" aria-label="Toolbar with button groups">
                                                <div class="btn-group me-2" role="group" aria-label="First group">
                                                    <button type="button" class="btn btn-primary">1</button>
                                                    <button type="button" class="btn btn-primary">2</button>
                                                    <button type="button" class="btn btn-primary">3</button>
                                                    <button type="button" class="btn btn-primary">4</button>
                                                </div>
                                                <div class="btn-group me-2" role="group" aria-label="Second group">
                                                    <button type="button" class="btn btn-primary">5</button>
                                                    <button type="button" class="btn btn-primary">6</button>
                                                    <button type="button" class="btn btn-primary">7</button>
                                                    <button type="button" class="btn btn-primary">8</button>
                                                </div>
                                                <div class="btn-group" role="group" aria-label="Third group">
                                                    <button type="button" class="btn btn-primary">9</button>
                                                    <button type="button" class="btn btn-primary">10</button>
                                                    <button type="button" class="btn btn-primary active">11</button>
                                                    <button type="button" class="btn btn-primary">12</button>
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