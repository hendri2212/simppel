<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Collapse")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">


                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Collapse", "pageSubTitle1" => "Interactive Features", "pageSubTitle2" => "UI Components", "pageSubText" => "Toggle the visibility of content across your project with a few classes.")) ?>

                    <div class="main-content" >

                        <div class="info-container">
                            <p>
                                The collapse JavaScript plugin is used to show and hide content. Buttons or anchors are used as
                                triggers that are mapped to specific elements you toggle. Collapsing an element will animate the
                                height from its current value to 0. Given how CSS handles animations, you cannot use padding on
                                a <code>.collapse</code> element. Instead, use the class as an independent wrapping element.
                            </p>
                            <p class="mb-0">

                                Learn more about this component on bootstrap's <a href="https://getbootstrap.com/docs/5.3/components/collapse/" target="_blank">official documentation</a>.
                            </p>
                        </div>
                        <div class="row">

                            <div class="col-xl-6">
                                <div id="panel-1" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Basic <span class="fw-300"><i>example</i></span>
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
                                                The most basic example of cards with enforced width
                                            </div>
                                            <p>Click the buttons below to show or hide elements using class changes:</p>
                                            <ul class="list-spaced mt-3">
                                                <li><code>.collapse</code> hides content</li>
                                                <li><code>.collapsing</code> is applied during transitions</li>
                                                <li><code>.collapse.show</code> reveals content</li>
                                            </ul>
                                            <p>You can use a link with the <code>href</code> attribute or a button with the <code>data-bs-target</code> attribute. In both cases, <code>data-bs-toggle="collapse"</code> is required.</p>

                                            <div class="frame-wrap mt-3 mb-0 w-100">
                                                <p class="demo">
                                                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                        Link with href
                                                    </a>
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                        Button with data-target
                                                    </button>
                                                </p>
                                                <div class="collapse" id="collapseExample">
                                                    <div class="card card-body">
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-2" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Multiple <span class="fw-300"><i>Targets</i></span>
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
                                                <p>A <code>&lt;button&gt;</code> or <code>&lt;a&gt;</code> can toggle multiple elements by
                                                    referencing them with a selector in its <code>href</code> or <code>data-bs-target</code> attribute.
                                                    Multiple <code>&lt;button&gt;</code> or <code>&lt;a&gt;</code> elements can control the same element if
                                                    they each reference it with <code>href</code> or <code>data-bs-target</code>.</p>
                                            </div>
                                            <div class="frame-wrap mb-0 w-100">
                                                <p class="demo">
                                                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Toggle second element</button>
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>
                                                </p>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                                                            <div class="card card-body">
                                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="collapse multi-collapse" id="multiCollapseExample2">
                                                            <div class="card card-body">
                                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div id="panel-3" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Accordion <span class="fw-300"><i>example</i></span>
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
                                                <p>Add navigation to a card’s header (or body) using Bootstrap's built-in nav components. You can show or hide elements when a <code>.collapse</code> state changes using the <code>.collapse-reveal</code> and <code>.collapse-hidden</code> classes.</p>

                                                <p><strong>Ensure that the <code>.collapse-*</code> classes are placed inside the element with <code>data-bs-toggle="collapse"</code> or adjacent to it for proper functionality.</strong></p>
                                            </div>
                                            <div class="frame-wrap w-100">
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                Collapsible Group Item #1
                                                                <span class="ms-auto">
                                                                    <span class="collapsed-reveal">
                                                                        <i class="sa sa-minus-circle text-danger"></i>
                                                                    </span>
                                                                    <span class="collapsed-hidden">
                                                                        <i class="sa sa-plus-circle text-success"></i>
                                                                    </span>
                                                                </span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwo">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                Collapsible Group Item #2
                                                                <span class="ms-auto">
                                                                    <span class="collapsed-reveal">
                                                                        <i class="sa sa-minus-circle text-danger"></i>
                                                                    </span>
                                                                    <span class="collapsed-hidden">
                                                                        <i class="sa sa-plus-circle text-success"></i>
                                                                    </span>
                                                                </span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThree">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                Collapsible Group Item #3
                                                                <span class="ms-auto">
                                                                    <span class="collapsed-reveal">
                                                                        <i class="sa sa-minus-circle text-danger"></i>
                                                                    </span>
                                                                    <span class="collapsed-hidden">
                                                                        <i class="sa sa-plus-circle text-success"></i>
                                                                    </span>
                                                                </span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingFour">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                                Collapsible Group Item #4
                                                                <span class="ms-auto">
                                                                    <span class="collapsed-reveal">
                                                                        <i class="sa sa-minus-circle text-danger"></i>
                                                                    </span>
                                                                    <span class="collapsed-hidden">
                                                                        <i class="sa sa-plus-circle text-success"></i>
                                                                    </span>
                                                                </span>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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