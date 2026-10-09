<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Tooltips")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Tooltips", "pageSubTitle1" => "Design", "pageSubTitle2" => "UI Components", "pageSubText" => "Bootstrap tooltips are small pop-up messages that appear when users hover over or focus on an element, providing additional information.")) ?>

                    <div class="main-content" >

                        <div class="row">
                            <div class="col-xl-6">
                                <div id="panel-1" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Tooltip <span class="fw-300"><i>basics</i></span>
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
                                                Hover over the links below to see tooltips:
                                            </div>
                                            <p class="text-muted">Tight pants next level keffiyeh <a href="#" class="fw-500" data-bs-toggle="tooltip" title="Default tooltip">you probably</a> haven't heard of them. Photo booth beard raw denim letterpress vegan messenger bag stumptown. Farm-to-table seitan, mcsweeney's fixie sustainable quinoa 8-bit american apparel <a href="#" class="fw-500" data-bs-toggle="tooltip" title="Another tooltip">have a</a> terry richardson vinyl chambray. Beard stumptown, cardigans banh mi lomo thundercats. Tofu biodiesel williamsburg marfa, four loko mcsweeney's cleanse vegan chambray. A really ironic artisan <a href="#" class="fw-500" data-bs-toggle="tooltip" title="Another one here too">whatever keytar</a>, scenester farm-to-table banksy Austin <a href="#" class="fw-500" data-bs-toggle="tooltip" title="The last tip!">twitter handle</a> freegan cred raw denim single-origin coffee viral.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-2" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Tooltip <span class="fw-300"><i>Placement</i></span>
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
                                                <p>How to position the tooltip - auto | top | bottom | left | right. When <code>auto</code> is specified, it will dynamically reorient the tooltip.</p>
                                                <p class="m-0">When a function is used to determine the placement, it is called with the tooltip DOM node as its first argument and the triggering element DOM node as its second. The <code>this</code> context is set to the tooltip instance.</p>
                                            </div>
                                            <div class="demo">
                                                <button type="button" class="btn btn-outline-default" data-bs-toggle="tooltip" data-bs-placement="auto" title="Tooltip on auto">Auto</button>
                                                <button type="button" class="btn btn-outline-default" data-bs-toggle="tooltip" data-bs-placement="left" title="Tooltip on left">Left</button>
                                                <button type="button" class="btn btn-outline-default" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                                                    Top</button>
                                                <button type="button" class="btn btn-outline-default" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom">Bottom</button>
                                                <button type="button" class="btn btn-outline-default" data-bs-toggle="tooltip" data-bs-placement="right" title="Tooltip on right">Right</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-3" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Tooltip <span class="fw-300"><i>animation</i></span>
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
                                                Disable the CSS fade transition to the tooltip by using <code>data-bs-animation="false"</code>
                                            </div>
                                            <div class="demo">
                                                <button type="button" class="btn btn-default" data-bs-toggle="tooltip" data-bs-placement="top" title="Animated">Animated</button>
                                                <button type="button" class="btn btn-default" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-animation="false" title="Not Animated">
                                                    Not Animated</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-4" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Tooltip <span class="fw-300"><i>Container</i></span>
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
                                                Appends the tooltip to a specific element. Example: container: 'body'. This option is particularly useful in that it allows you to position the tooltip in the flow of the document near the triggering element - which will prevent the tooltip from floating away from the triggering element during a window resize.
                                            </div>
                                            <div class="d-flex">
                                                <a href="#" class="me-auto fs-md fw-500" data-bs-container=".js-test-container" data-bs-toggle="tooltip" data-bs-placement="top" title="I am not really here...">
                                                    >> Hover to display tooltip
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-xs ms-auto" data-action="toggle-swap" data-toggleclass="d-none" data-target=".js-test-container">
                                                    hide container
                                                </a>
                                            </div>
                                            <div class="p-3 rounded bg-primary-500 text-light mt-3 js-test-container">
                                                Toolip is nested in this container but displayed on the hovered element above. Once this container is hidden the tooltip will not be visible. Try hiding the container by pressing the "hide" button above
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-5" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Delayed <span class="fw-300"><i>Tooltip</i></span>
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
                                                Delay showing and hiding the tooltip (ms) - does not apply to manual trigger type. If a number is supplied, delay is applied to both hide/show. Object structure is: <code>delay: { "show": 500, "hide": 100 }</code>
                                            </div>
                                            <div class="demo demo-h-spacing d-flex align-items-end">
                                                <a href="#" class="btn btn-lg btn-outline-default" data-bs-toggle="tooltip" data-bs-delay='{ "show": 1000, "hide": 1000 }' data-bs-original-title='{ "show": 1000, "hide": 1000 }'>1s delay</a>
                                                <a href="#" class="btn btn-outline-default" data-bs-toggle="tooltip" data-bs-delay='{ "show": 500, "hide": 500 }' data-bs-original-title='{ "show": 500, "hide": 500 }'>0.5sec delay</a>
                                                <a href="#" class="btn btn-sm btn-outline-default" data-bs-toggle="tooltip" data-bs-delay='{ "show": 0, "hide": 0 }' data-bs-original-title='{ "show": 0, "hide": 0 }'>No delay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div id="panel-7" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Adding <span class="fw-300"><i>dynamic objects</i></span>
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
                                                If a selector is provided, tooltip objects will be delegated to the specified targets. In practice, this is used to also apply tooltips to dynamically added DOM elements (jQuery.on support).
                                            </div>
                                            <p>Toggle the checkbox below and click the 'add new tooltip' button to observe the behavioral differences between using the selector option, and not using it.</p>
                                            <hr>

                                            <label id="use-selector-label" class="d-flex align-items-center mb-3">
                                                <input id="use-selector" type="checkbox">
                                                <span class="ms-2" data-bs-title="you must re-run this page to change the selector option once you've started the demo">Use selector option</span>
                                            </label>

                                            <pre id="with-selector-code">
        $('body').tooltip({
          selector: '.has-tooltip'
        });
        </pre>
                                            <pre id="without-selector-code">
        $('.has-tooltip').tooltip();
        </pre>
                                            <button type="button" class="btn btn-primary" id="add-button">
                                                Add new tooltip
                                            </button>
                                            <div id="js_buttons_tooltip_demo" style="display:none">
                                                <hr>
                                                <button type="button" class="btn btn-block btn-success has-tooltip" data-bs-title="Static" data-bs-content="This button was specified in the initial HTML document" data-bs-placement="top">
                                                    Working tooltip
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-8" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Tooltip <span class="fw-300"><i>Templating</i></span>
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
                                                Base HTML to use when creating the tooltip. The tooltip's title will be injected into the <code>.tooltip-inner</code>. The outermost wrapper element should have the <code>.tooltip</code> class and <code>role="tooltip"</code>
                                            </div>
                                            <h5 class="frame-heading">
                                                Backgrounds
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo">
                                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-primary" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Primary</button>
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-secondary" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Fusion</button>
                                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Success</button>
                                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-info" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Info</button>
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-warning" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Wraning</button>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Danger</button>
                                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Dark</button>
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-secondary" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Secondary</button>
                                                    <button type="button" class="btn btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-light" data-bs-title="This top tooltip is themed via CSS variables.">
                                                        Light</button>
                                                </div>
                                            </div>
                                            <h5 class="frame-heading">
                                                Sizing with <u>HTML</u>
                                            </h5>
                                            <div class="frame-wrap">
                                                <div class="demo demo-h-spacing d-flex align-items-end">
                                                    <button type="button" class="btn btn-outline-default btn-lg" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="<span class='fs-xl'>Large Font</span>">Large Font</button>
                                                    <button type="button" class="btn btn-outline-default btn-xs" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="<span class='fs-xs'>Small Font</span>">Small Font</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-9" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Tooltip <span class="fw-300"><i>Triggers</i></span>
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
                                                <p>How tooltip is triggered - click | hover | focus | manual. You may pass multiple triggers; separate them with a space.</p>
                                                <p><code>'manual'</code> indicates that the tooltip will be triggered programmatically via the <code>.tooltip('show')</code>, <code>.tooltip('hide')</code> and <code>.tooltip('toggle')</code> methods; this value cannot be combined with any other trigger.</p>
                                                <p><code>'hover'</code> on its own will result in tooltips that cannot be triggered via the keyboard, and should only be used if alternative methods for conveying the same information for keyboard users is present.</p>
                                            </div>
                                            <div class="demo">
                                                <button type="button" class="btn btn-outline-default" data-bs-toggle="tooltip" data-bs-trigger="click" data-bs-original-title="Displayed on click">Click event</button>
                                                <button type="button" class="btn btn-outline-default" data-bs-toggle="tooltip" data-bs-trigger="focus" data-bs-original-title="Displayed on focus">Focus event</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel-10" class="panel panel-icon">
                                    <div class="panel-hdr">
                                        <h2>
                                            Tooltips <span class="fw-300"><i>Offset</i></span>
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
                                                Offset of the tooltip relative to its target. When a function is used to determine the offset, it is called with an object containing the offset data as its first argument. The function must return an object with the same structure. The triggering element DOM node is passed as the second argument.
                                            </div>
                                            <div class="demo">
                                                <button type="button" class="btn btn-outline-default" data-bs-offset="0,25" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Offset by x=0, y=25">
                                                    Top placement (0,25)</button>
                                                <button type="button" class="btn btn-outline-default" data-bs-offset="0,25" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Offset by x=0, y=25">
                                                    Bottom placement (0,25)</button>

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

    <script>
        // Your inline JavaScript code here
        // Utility functions
        function usingSelectorOption() {
            return document.getElementById('use-selector').checked;
        }

        function updateCodeView() {
            var withSelectorCode = document.getElementById('with-selector-code');
            var withoutSelectorCode = document.getElementById('without-selector-code');

            withSelectorCode.style.display = usingSelectorOption() ? 'block' : 'none';
            withoutSelectorCode.style.display = usingSelectorOption() ? 'none' : 'block';
        }

        // Main initialization
        function initializeTooltips() {
            var startedDemo = false;

            function addButtonHandler() {
                // One-time initialization
                if (!startedDemo) {
                    if (usingSelectorOption()) {
                        // Initialize tooltips with delegation
                        document.body.addEventListener('mouseenter', function (e) {
                            if (e.target.matches('.has-tooltip')) {
                                var tooltip = new bootstrap.Tooltip(e.target);
                            }
                        }, true);
                    } else {
                        // Initialize all existing tooltips
                        var tooltipElements = document.querySelectorAll('.has-tooltip');
                        tooltipElements.forEach(function (element) {
                            new bootstrap.Tooltip(element);
                        });
                    }
                    startedDemo = true;
                }

                // Disable selector checkbox and add tooltip
                var selectorCheckbox = document.getElementById('use-selector');
                selectorCheckbox.disabled = true;

                var selectorLabel = document.querySelector('#use-selector-label span');
                new bootstrap.Tooltip(selectorLabel);

                // Show buttons panel
                var buttonsDemo = document.getElementById('js_buttons_tooltip_demo');
                buttonsDemo.style.display = 'block';

                // Create and add new button
                var button = document.createElement('button');
                button.className = usingSelectorOption() ?
                    'btn btn-block btn-success has-tooltip' :
                    'btn btn-block btn-secondary has-tooltip';
                button.setAttribute('data-bs-toggle', 'tooltip');
                button.setAttribute('data-bs-title', 'Dynamic');
                button.setAttribute('data-bs-content', 'This button was added dynamically by JavaScript');
                button.setAttribute('data-bs-placement', 'top');
                button.textContent = usingSelectorOption() ?
                    'Working dynamically added button' :
                    'Non-working dynamically added button';

                document.getElementById('js_buttons_tooltip_demo').appendChild(button);

                // Initialize tooltip for new button if not using selector option
                if (!usingSelectorOption()) {
                    new bootstrap.Tooltip(button);
                }
            }

            // Event Listeners
            document.addEventListener('DOMContentLoaded', function () {
                updateCodeView();

                var selectorCheckbox = document.getElementById('use-selector');
                selectorCheckbox.addEventListener('click', updateCodeView);

                var addButton = document.getElementById('add-button');
                addButton.addEventListener('click', addButtonHandler);
            });
        }

        // Initialize the application
        initializeTooltips();
    </script>

</body>

</html>