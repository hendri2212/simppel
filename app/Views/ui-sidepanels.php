<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Side Panels")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Side Panels", "pageSubTitle1" => "Design", "pageSubTitle2" => "UI Components", "pageSubText" => "These side panels slide out on mobile viewports and can be toggled using a button in slide in/out mode.")) ?>

                    <div class="info-container">
                        <p class="mb-0">
                            <strong>Tip:</strong> Control the width of the side panel by setting the <code>--sidepanel-width</code> variable in the <code>_sidepanels.scss</code> file, or by using the
                            <code>style="--sidepanel-width: 20rem;"</code> attribute on the <code>.slide-on-mobile</code> element.
                        </p>
                    </div>
                    <div class="main-content d-flex">
                        <!-- notice the utilities added to the wrapper below -->
                        <div class="d-flex flex-grow-1 p-0 w-100">
                            <!-- left slider panel : must have unique ID-->
                            <div id="js-slide-left" class="flex-wrap flex-shrink-0 position-relative slide-on-mobile slide-on-mobile-left bg-primary-200 pattern-0 p-3">
                                <div class="alert alert-primary">
                                    These side panels slide out on mobile view port and can be activated by a button as an "slide in/out" mode.
                                </div>
                            </div>
                            <!-- left slider panel backdrop : activated on mobile, must be place immideately after left slider closing tag -->
                            <div class="slide-backdrop" data-action="toggle-swap" data-toggleclass="slide-on-mobile-left-show" data-target="#js-slide-left"></div>
                            <!-- middle content area -->
                            <div class="d-flex flex-column flex-grow-1 flex-0 overflow-x-auto bg-faded">
                                <div class="p-3">
                                    <div class="row d-lg-none d-xl-none d-xxl-none mb-g">
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                These buttons below can be placed anywhere on your screen. Applying the responsive utility classes, you control the visibility of the buttons, for only when they are needed.
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <!-- this button is activated on mobile view and activates the left panel -->
                                            <a href="javascript:void(0);" class="btn btn-primary btn-block btn-lg" data-action="toggle-swap" data-toggleclass="slide-on-mobile-left-show" data-target="#js-slide-left">
                                                left panel
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <!-- this button is activated on mobile view and activates the right panel -->
                                            <a href="javascript:void(0);" class="btn btn-primary btn-block btn-lg" data-action="toggle-swap" data-toggleclass="slide-on-mobile-right-show" data-target="#js-slide-right">
                                                right panel
                                            </a>
                                        </div>
                                    </div>
                                    <div class="panel-tag">
                                        <p>
                                            These side panels slide out on mobile viewports and can be toggled using a button in "slide in/out" mode.
                                            To enable this functionality, apply the <code>.slide-on-mobile</code> class along with <code>.slide-on-mobile-{left,right}</code> to the panels.
                                            When activated, the <code>.slide-on-mobile-{left,right}-show</code> class is toggled to reveal the panel.
                                        </p>
                                        <p>
                                            A backdrop is automatically inserted right after the closing tag of the <code>.slide-on-mobile</code> container. Typically, this slide
                                            panel is paired with <code>.layout-trimmed</code> and <code>.set-nav-minified</code> for a clean and streamlined appearance.
                                        </p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-secondary" data-action="toggle-swap" data-toggleclass="layout-trimmed" data-target=".main-content">Trimmed Layout</a>
                                        <a href="#" class="btn btn-secondary d-none d-sm-block d-sm-none d-md-none d-lg-block" data-action="toggle-swap" data-toggleclass="set-nav-minified">Minified Nav</a>
                                    </div>

                                    <div class="d-none d-sm-block d-sm-none d-md-none d-lg-flex">
                                        <img src="/img/demo/pages/side-panel-demo.gif" alt="Side Panel Demo Animation" class="m-auto shadow rounded">
                                    </div>
                                </div>
                            </div>

                            <!-- right slider panel : must have unique ID -->
                            <div id="js-slide-right" class="flex-wrap flex-shrink-0 position-relative slide-on-mobile slide-on-mobile-right bg-primary-200 pattern-0 p-3">
                                <div class="alert alert-primary">
                                    You can place any content in these side panels, making it a secondary optional navigation panel.
                                </div>
                            </div>
                            <!-- right slider panel backdrop : activated on mobile, must be place immideately after right slider closing tag -->
                            <div class="slide-backdrop" data-action="toggle-swap" data-toggleclass="slide-on-mobile-right-show" data-target="#js-slide-right"></div>
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