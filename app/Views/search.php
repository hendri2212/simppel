<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Search Results")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <div class="main-content layout-trimmed">
                        <!-- HEADER -->
                        <div class="px-3 px-sm-5 pt-4">
                            <!-- SUB HEADER -->
                            <h1 class="subheader-title mb-4">
                                65 Results for "SmartAdmin"
                                <small class="mb-3 text-muted">
                                    Request time (0.23 seconds)
                                </small>
                            </h1>
                            <!-- SEARCH BAR -->
                            <div class="input-group input-group-lg mb-5 shadow-1 rounded">
                                <!-- INPUT -->
                                <input type="text" class="form-control shadow-inset-2" id="filter-icon" aria-label="type 2 or more letters" placeholder="Search anything..." value="SmartAdmin">
                                <!-- SEARCH BUTTON -->
                                <button class="btn btn-primary d-none d-sm-inline-block" type="button"><i class="fa fa-search me-2"></i><span>Search</span></button>
                                <!-- DROPDOWN TOGGLE -->
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <!-- DROPDOWN MENU -->
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Image</a></li>
                                    <li><a class="dropdown-item" href="#">Users</a></li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    <li>
                                    <li><a class="dropdown-item active" href="#">Everything</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- TABS -->
                        <ul class="nav nav-tabs nav-tabs-clean px-3 px-sm-5" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active bg-transparent fs-lg fw-400" data-bs-toggle="tab" data-bs-target="#tab-all" type="button" role="tab">All</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link bg-transparent fs-lg fw-400" data-bs-toggle="tab" data-bs-target="#tab-images" type="button" role="tab">Image</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link bg-transparent fs-lg fw-400" data-bs-toggle="tab" data-bs-target="#tab-users" type="button" role="tab">Users</button>
                            </li>
                        </ul>
                        <!-- FILTERS -->
                        <div class="d-flex px-3 px-sm-5 py-4">
                            <div>
                                <span class="suggest-title text-danger fw-600 fs-lg">Did you mean?</span>
                                <span class="suggestion px-1 fw-600 fst-italic text-decoration-underline link-offset-1 link-underline link-underline-opacity-75 fs-lg">
                                    SmartNav
                                </span>
                                <span class="suggestion px-1 fw-600 fst-italic text-decoration-underline link-offset-1 link-underline link-underline-opacity-75 fs-lg">
                                    SmartTables
                                </span>
                            </div>
                        </div>
                        <!-- TABS CONTENT -->
                        <div class="px-3 px-sm-5 pb-4">
                            <div class="tab-content">
                                <!-- ALL TAB -->
                                <div class="tab-pane show active" id="tab-all" role="tabpanel" aria-labelledby="tab-all">
                                    <div class="card">
                                        <!-- LIST GROUP -->
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">SmartAdmin v5 - Jquery Free WebApp</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/themes/admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book...
                                                </div>
                                                <div class="scrolling-wrapper gap-2 d-flex flex-row mt-3">
                                                    <div class="d-block text-truncate text-truncate-lg border-faded p-2 flex-shrink-0">
                                                        <a href="javascript:void(0)" class="fs-md fw-500">Support us - WebApp</a>
                                                        <details>
                                                            <summary class="d-block text-truncate text-truncate-lg text-muted fs-xs">He consider is to vows, focuses </summary>
                                                            <p class="d-block text-truncate text-truncate-lg fs-md">Sufficiently the secure our represent on eagerly magazine where expl</p>
                                                        </details>
                                                    </div>
                                                    <div class="d-block text-truncate text-truncate-lg border-faded p-2 ms-2 flex-shrink-0">
                                                        <a href="javascript:void(0)" class="fs-md fw-500">Contact - WebApp</a>
                                                        <details>
                                                            <summary class="d-block text-truncate text-truncate-lg text-muted fs-xs">Sufficiently the secure our represent on eagerly magazine where expl</summary>
                                                            <p class="d-block text-truncate text-truncate-lg fs-md">Sufficiently the secure our represent on eagerly magazine where expl</p>
                                                        </details>
                                                    </div>
                                                    <div class="d-block text-truncate text-truncate-lg border-faded p-2 ms-2 flex-shrink-0">
                                                        <a href="javascript:void(0)" class="fs-md fw-500">About us</a>
                                                        <details>
                                                            <summary class="d-block text-truncate text-truncate-lg text-muted fs-xs">Which been italic, his based due and yet was hazar</summary>
                                                            <p class="d-block text-truncate text-truncate-lg fs-md">Sufficiently the secure our represent on eagerly magazine where expl</p>
                                                        </details>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">Develop your webapp with ease using SmartAdmin</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/themes/admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    Acquired concept to however, lots have it human its after suspicious good clock, line tall and writing be he are was increased technology be client would, and in top children peacefully. The consider is to vows, focuses completely I to proposal room. Joke. That particularly problem uniforms, burden military the to ill road, people.
                                                </div>
                                                <div class="scrolling-wrapper fs-sm d-flex align-items-center mt-3">
                                                    <a href="#" class="me-2 mt-1" title="SmartAdmin Colors">
                                                        <span class="d-block ratio ratio-16x9 width-sm" style="background-image:url('/img/search/16.webp'); background-size: cover;"></span>
                                                    </a>
                                                    <a href="#" class="me-2 mt-1" title="SmartAdmin Alerts">
                                                        <span class="d-block ratio ratio-16x9 width-sm" style="background-image:url('/img/search/18.webp'); background-size: cover;"></span>
                                                    </a>
                                                    <a href="#" class="me-2 mt-1" title="SmartAdmin Progress">
                                                        <span class="d-block ratio ratio-16x9 width-sm" style="background-image:url('/img/search/14.webp'); background-size: cover;"></span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">45,000 downloads for SmartAdmin v5</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/themes/admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    Greatest both welcoming the turn spineless, to which been italic, his based due and yet was hazardous necessary pros blind a okay. Written missions of and remedies. Have prior though point economics, real he please.
                                                </div>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">Company project Timeline Stock SmartAdmin</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/themes/admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    Once freshlybrewed of it as and big behind he sufficiently the secure our represent on eagerly magazine where explanation every he they should a go presentations.
                                                </div>
                                            </li>
                                            <!-- VIDEOS -->
                                            <li class="list-group-item py-4 px-4">
                                                <h5 class="fw-400 d-flex align-items-center gap-2" role="heading">
                                                    <svg class="sa-icon sa-thin sa-icon-2x">
                                                        <use href="/icons/sprite.svg#youtube"></use>
                                                    </svg>
                                                    Videos
                                                </h5>
                                                <div class="scrolling-wrapper">
                                                    <!-- VIDEO 1 -->
                                                    <div class="card shadow-0 d-inline-flex me-2 flex-shrink-0" style="width: 200px;">
                                                        <div class="card-img-top position-relative" style="background-image:url('/img/search/15.webp'); background-size: cover; display: block; height: 110px; max-width: 200px;">
                                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center display-3">
                                                                <div class="stack-icon">
                                                                    <div class="icon-layers">
                                                                        <i class="sa sa-base-7 stack-3x text-warning alpha-7"></i>
                                                                    </div>
                                                                    <div class="icon-layers">
                                                                        <i class="sa sa-control-play stack-1x text-light"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body py-3 px-2">
                                                            <a href="#" class="stretched-link fs-lg fw-500"> Introduction</a>
                                                            <p class="fs-xs mt-1">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                            <span class="text-success fs-xs">YouTube</span> <span class="text-muted fs-xs opacity-50">- Jul 18, 2023 </span>
                                                        </div>
                                                    </div>
                                                    <!-- VIDEO 2 -->
                                                    <div class="card shadow-0 d-inline-flex me-2 flex-shrink-0" style="width: 200px;">
                                                        <div class="card-img-top position-relative" style="background-image:url('/img/search/17.webp'); background-size: cover; display: block; height: 110px; max-width: 200px;">
                                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center display-3">
                                                                <div class="stack-icon">
                                                                    <div class="icon-layers">
                                                                        <i class="sa sa-base-7 stack-3x text-warning alpha-7"></i>
                                                                    </div>
                                                                    <div class="icon-layers">
                                                                        <i class="sa sa-control-play stack-1x text-light"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body py-3 px-2">
                                                            <a href="#" class="stretched-link fs-lg fw-500">Advanced layouts</a>
                                                            <p class="fs-xs mt-1">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                            <span class="text-success fs-xs">YouTube</span> <span class="text-muted fs-xs opacity-50">- Jan 15, 2023 </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">Online software and management toolkit using UI</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/themes/admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam laoreet turpis sed leo gravida interdum. Aliquam efficitur tempor enim ac pretium. Integer scelerisque dui sed ex laoreet congue.
                                                </div>
                                            </li>
                                            <!-- ORDERS -->
                                            <li class="list-group-item py-4 px-4">
                                                <h5 class="fw-400 d-flex align-items-center gap-2" role="heading">
                                                    <svg class="sa-icon sa-thin sa-icon-2x">
                                                        <use href="/icons/sprite.svg#shopping-cart"></use>
                                                    </svg>
                                                    Orders
                                                </h5>

                                                <table class="table table-nano table-hover table-bordered table-striped m-0" style="table-layout: fixed;">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-top-0">Items</th>
                                                            <th class="border-top-0">Status</th>
                                                            <th class="border-top-0 hidden-sm">Total</th>
                                                            <th class="border-top-0">Date</th>
                                                            <th class="border-top-0">Client</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="fw-500">Corporate Identity</span>
                                                                    <span class="text-muted ms-2 hidden-sm">Hrs: 102</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-warning">Pending</span>
                                                            </td>
                                                            <td class="hidden-sm">$5940</td>
                                                            <td>16/08/2022</td>
                                                            <td>Microsoft</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="fw-500">Logo Design</span>
                                                                    <span class="text-muted ms-2 hidden-sm">Hrs: 52</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-primary">In progress</span>
                                                            </td>
                                                            <td class="hidden-sm">$2540</td>
                                                            <td>28/10/2022</td>
                                                            <td>Microsoft</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="fw-500">Animation</span>
                                                                    <span class="text-muted ms-2 hidden-sm">Hrs: 102</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-success">Complete</span>
                                                            </td>
                                                            <td class="hidden-sm">$928.41</td>
                                                            <td>18/09/2022</td>
                                                            <td>Walmart</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <span class="fw-500">UX Review</span>
                                                                    <span class="text-muted ms-2 hidden-sm">Hrs: 75</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-success">Complete</span>
                                                            </td>
                                                            <td class="hidden-sm">$9870</td>
                                                            <td>15/08/2022</td>
                                                            <td>Bridgestone</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">Bootstrap Templates & Themes from WrapBootstrap</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/themes/admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    Been the as I have stairs familiarity he everything our except with now, there's he literature stage all the himself bed and skyline overhauls at how may maintain didn't depend train tone, sign he reassuring complete reached chance.
                                                </div>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">It impenetrable hazardous best.</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/themes/admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    Must and agency is she something sentences that italic, to would trust, a the far was for small quarter following thought, any at something over there of being me. Frequency; And cheerful, tone the at their lobby, are was the between touch have play suppliers, eye stash too the that.
                                                </div>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">Temple of appeared a somewhere, hands</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/web-app/peoples-theme</a>
                                                </div>
                                                <div class="mt-2">
                                                    Time. Reason that staple in her many a do comments less recommended. Easier just dull two harmonics. Strenuous much back to over career here. Let's of with business the completely for anger get that up software god mostly my in phase he on knowing posterity drew he or each any that brown said in and have he nonsense, evils then first wait neuter.
                                                </div>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">You did to and bed seen, documents violin to groundtem</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/templates/kiwik-rickshaw-admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    The wrong findings. Only into the considerations, stuffed puzzles was enough and how queen, and sooner person, different in to pass not. Able mellower to having as easier at live of process anger more, such, what avarice attention from warned congress, you the his o'clock enterprises then, an velocity a belong, samples copy and occasion films and day secure that dissolute by her ever the headline take what two as example, it is about but employed one in sleeping eyes the like.
                                                </div>
                                            </li>
                                            <li class="list-group-item py-4 px-4">
                                                <a href="javascript:void(0)" class="fs-lg fw-500">To she enjoying world could to</a>
                                                <div class="fs-xs mt-1">
                                                    <a href="javascript:void(0)" class="text-success">http://getwebora.com/business/admin</a>
                                                </div>
                                                <div class="mt-2">
                                                    Decades the and the of deceleration been from with key a the pass in such safe motors it abused years temple a she have rush one a yes, it hesitated of he refinements. Day into of was concise principles, those with but from behind most ideas been their explain text to their and spots present events do was, a best odd one is one in some we explains way one attempt.
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- IMAGES TAB -->
                                <div class="tab-pane" id="tab-images" role="tabpanel" aria-labelledby="tab-images">
                                    <div class="py-2">
                                        <div class="scrolling-wrapper gap-2">
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                chart
                                            </a>
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                theme
                                            </a>
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                layout
                                            </a>
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                admin dashboard
                                            </a>
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                bootstrap
                                            </a>
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                app
                                            </a>
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                header
                                            </a>
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                awesome
                                            </a>
                                            <a href="#" class="btn btn-pills btn-outline-secondary flex-shrink-0 d-inline-block js-waves-off">
                                                responsive
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="SmartAdmin Dashboard" data-img-description="Modern and clean dashboard interface" data-img-date="2023-07-15" data-img-source="smartadmin.com" data-img-category="Dashboard">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/1.webp" alt="SmartAdmin Dashboard" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Analytics Overview" data-img-description="Comprehensive analytics and statistics panel" data-img-date="2023-07-16" data-img-source="smartadmin.com" data-img-category="Analytics">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/2.webp" alt="Analytics Overview" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Form Components" data-img-description="UI components for building modern form interfaces" data-img-date="2023-06-28" data-img-source="smartadmin.com" data-img-category="Forms">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/3.webp" alt="Form Components" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Chart Library" data-img-description="Interactive data visualization charts and graphs" data-img-date="2023-07-02" data-img-source="smartadmin.com" data-img-category="Charts">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/4.webp" alt="Chart Library" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Data Tables" data-img-description="Advanced data tables with sorting and filtering capabilities" data-img-date="2023-06-18" data-img-source="smartadmin.com" data-img-category="Tables">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/5.webp" alt="Data Tables" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="User Profile" data-img-description="User profile interface with stats and activity tracking" data-img-date="2023-07-10" data-img-source="smartadmin.com" data-img-category="UI Components">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/6.webp" alt="User Profile" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Calendar View" data-img-description="Interactive calendar with event scheduling and reminders" data-img-date="2023-06-24" data-img-source="smartadmin.com" data-img-category="UI Components">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/7.webp" alt="Calendar View" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Message Center" data-img-description="Messaging interface with chat and notification system" data-img-date="2023-07-05" data-img-source="smartadmin.com" data-img-category="Communication">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/8.webp" alt="Message Center" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="File Manager" data-img-description="Document management system with cloud storage integration" data-img-date="2023-06-30" data-img-source="smartadmin.com" data-img-category="Utilities">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/9.webp" alt="File Manager" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Authentication Screen" data-img-description="Secure login and registration interface with multi-factor authentication" data-img-date="2023-07-08" data-img-source="smartadmin.com" data-img-category="Security">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/10.webp" alt="Authentication Screen" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Settings Panel" data-img-description="Comprehensive system settings with user preferences" data-img-date="2023-06-22" data-img-source="smartadmin.com" data-img-category="UI Components">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/11.webp" alt="Settings Panel" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Project Dashboard" data-img-description="Project management interface with task tracking" data-img-date="2023-07-12" data-img-source="smartadmin.com" data-img-category="Project Management">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/12.webp" alt="Project Dashboard" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Alert System" data-img-description="Notification and alert management console" data-img-date="2023-06-25" data-img-source="smartadmin.com" data-img-category="UI Components">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/13.webp" alt="Alert System" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="E-commerce Dashboard" data-img-description="Sales and inventory management dashboard" data-img-date="2023-07-03" data-img-source="smartadmin.com" data-img-category="E-commerce">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/14.webp" alt="E-commerce Dashboard" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Video Player" data-img-description="Custom video player with streaming capabilities" data-img-date="2023-06-29" data-img-source="smartadmin.com" data-img-category="Media">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/15.webp" alt="Video Player" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Color Palette" data-img-description="Customizable color scheme manager for theming" data-img-date="2023-07-14" data-img-source="smartadmin.com" data-img-category="Design">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/16.webp" alt="Color Palette" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Responsive Layout" data-img-description="Multi-device compatible grid system and layouts" data-img-date="2023-07-01" data-img-source="smartadmin.com" data-img-category="Layout">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/17.webp" alt="Responsive Layout" class="img-thumbnail">
                                            </a>
                                        </div>
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 py-2 px-2">
                                            <a href="#" class="position-relative show-child-on-hover d-block shadow-hover" data-img-title="Icon Library" data-img-description="Comprehensive collection of vector icons and graphics" data-img-date="2023-06-20" data-img-source="smartadmin.com" data-img-category="Design">
                                                <div class="position-absolute top-0 start-0 end-0 bottom-0 show-on-hover-parent">
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 opacity-20 bg-primary-500 rounded"></div>
                                                    <div class="position-absolute py-1 px-2 m-2 pos-bottom pos-right bg-primary text-white rounded opacity-90">
                                                        <small>394x222</small>
                                                    </div>
                                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center text-white">
                                                        <i class="sa sa-plus display-2 m-0 opacity-90"></i>
                                                    </div>
                                                </div>
                                                <img src="/img/search/18.webp" alt="Icon Library" class="img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- USERS TAB -->
                                <div class="tab-pane" id="tab-users" role="tabpanel" aria-labelledby="tab-users">
                                    <div class="row" id="js-contacts">
                                        <div class="col-xl-4">
                                            <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="dr john smith +13174562564 john.smith@smartadminwebapp.com developer">
                                                <div class="card-body border-faded border-top-0 border-start-0 border-end-0 rounded-top">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <span class="status status-success me-3">
                                                            <span class="rounded-circle profile-image d-block" style="background-image:url('/img/demo/avatars/avatar-a.png'); background-size: cover;"></span>
                                                        </span>
                                                        <div class="info-card-text flex-grow-1">
                                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Dr. John Smith
                                                                <i class="fal fa-angle-down d-inline-block ms-1 fs-md"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Send Email</a>
                                                                <a class="dropdown-item" href="#">Create Appointment</a>
                                                                <a class="dropdown-item" href="#">Block User</a>
                                                            </div>
                                                            <span class="d-block text-truncate text-truncate-lg">Senior Developer, Development Team</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0 collapse show">
                                                    <div class="p-3">
                                                        <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mobile-alt text-muted me-2"></i> +1 317-456-2564</a>
                                                        <a href="mailto:john.smith@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mouse-pointer text-muted me-2"></i> john.smith@smartadminwebapp.com</a>
                                                        <address class="fs-sm fw-400 mt-4 text-muted mb-0">
                                                            <i class="fal fa-map-pin me-2"></i> 15 Charist St, Detroit, MI, 48212, USA
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div id="c_2" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="sarah connor +13134611347 sarah.connor@smartadminwebapp.com designer">
                                                <div class="card-body border-faded border-top-0 border-start-0 border-end-0 rounded-top">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <span class="status status-warning me-3">
                                                            <span class="rounded-circle profile-image d-block" style="background-image:url('/img/demo/avatars/avatar-b.png'); background-size: cover;"></span>
                                                        </span>
                                                        <div class="info-card-text flex-grow-1">
                                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Sarah Connor
                                                                <i class="fal fa-angle-down d-inline-block ms-1 fs-md"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Send Email</a>
                                                                <a class="dropdown-item" href="#">Create Appointment</a>
                                                                <a class="dropdown-item" href="#">Block User</a>
                                                            </div>
                                                            <span class="d-block text-truncate text-truncate-lg">UX Designer, Design Team</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0 collapse show">
                                                    <div class="p-3">
                                                        <a href="tel:+13134611347" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mobile-alt text-muted me-2"></i> +1 313-461-1347</a>
                                                        <a href="mailto:sarah.connor@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mouse-pointer text-muted me-2"></i> sarah.connor@smartadminwebapp.com</a>
                                                        <address class="fs-sm fw-400 mt-4 text-muted mb-0">
                                                            <i class="fal fa-map-pin me-2"></i> 134 Hamtrammac, Detroit, MI, 48314, USA
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div id="c_3" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="james wilson +13137791347 james.wilson@smartadminwebapp.com manager">
                                                <div class="card-body border-faded border-top-0 border-start-0 border-end-0 rounded-top">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <span class="status status-danger me-3">
                                                            <span class="rounded-circle profile-image d-block" style="background-image:url('/img/demo/avatars/avatar-c.png'); background-size: cover;"></span>
                                                        </span>
                                                        <div class="info-card-text flex-grow-1">
                                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                                                James Wilson
                                                                <i class="fal fa-angle-down d-inline-block ms-1 fs-md"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Send Email</a>
                                                                <a class="dropdown-item" href="#">Create Appointment</a>
                                                                <a class="dropdown-item" href="#">Block User</a>
                                                            </div>
                                                            <span class="d-block text-truncate text-truncate-lg">Project Manager, Management</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0 collapse show">
                                                    <div class="p-3">
                                                        <a href="tel:+13137791347" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mobile-alt text-muted me-2"></i> +1 313-779-1347</a>
                                                        <a href="mailto:james.wilson@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mouse-pointer text-muted me-2"></i> james.wilson@smartadminwebapp.com</a>
                                                        <address class="fs-sm fw-400 mt-4 text-muted mb-0">
                                                            <i class="fal fa-map-pin me-2"></i> 55 Smyth Rd, Detroit, MI, 48341, USA
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div id="c_4" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="lisa anderson +13137793314 lisa.anderson@smartadminwebapp.com developer">
                                                <div class="card-body border-faded border-top-0 border-start-0 border-end-0 rounded-top">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <span class="status status-success me-3">
                                                            <span class="rounded-circle profile-image d-block" style="background-image:url('/img/demo/avatars/avatar-d.png'); background-size: cover;"></span>
                                                        </span>
                                                        <div class="info-card-text flex-grow-1">
                                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Lisa Anderson
                                                                <i class="fal fa-angle-down d-inline-block ms-1 fs-md"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Send Email</a>
                                                                <a class="dropdown-item" href="#">Create Appointment</a>
                                                                <a class="dropdown-item" href="#">Block User</a>
                                                            </div>
                                                            <span class="d-block text-truncate text-truncate-lg">Frontend Developer, Development Team</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0 collapse show">
                                                    <div class="p-3">
                                                        <a href="tel:+13137793314" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mobile-alt text-muted me-2"></i> +1 313-779-3314</a>
                                                        <a href="mailto:lisa.anderson@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mouse-pointer text-muted me-2"></i> lisa.anderson@smartadminwebapp.com</a>
                                                        <address class="fs-sm fw-400 mt-4 text-muted mb-0">
                                                            <i class="fal fa-map-pin me-2"></i> 134 Tasy Rd, Detroit, MI, 48212, USA
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div id="c_5" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="michael brown +13137798134 michael.brown@smartadminwebapp.com developer">
                                                <div class="card-body border-faded border-top-0 border-start-0 border-end-0 rounded-top">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <span class="status status-danger me-3">
                                                            <span class="rounded-circle profile-image d-block" style="background-image:url('/img/demo/avatars/avatar-e.png'); background-size: cover;"></span>
                                                        </span>
                                                        <div class="info-card-text flex-grow-1">
                                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Michael Brown
                                                                <i class="fal fa-angle-down d-inline-block ms-1 fs-md"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Send Email</a>
                                                                <a class="dropdown-item" href="#">Create Appointment</a>
                                                                <a class="dropdown-item" href="#">Block User</a>
                                                            </div>
                                                            <span class="d-block text-truncate text-truncate-lg">Backend Developer, Development Team</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0 collapse show">
                                                    <div class="p-3">
                                                        <a href="tel:+13137798134" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mobile-alt text-muted me-2"></i> +1 313-779-8134</a>
                                                        <a href="mailto:michael.brown@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mouse-pointer text-muted me-2"></i> michael.brown@smartadminwebapp.com</a>
                                                        <address class="fs-sm fw-400 mt-4 text-muted mb-0">
                                                            <i class="fal fa-map-pin me-2"></i> 134 Gallery St, Detroit, MI, 46214, USA
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div id="c_6" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="emma davis +13137797613 emma.davis@smartadminwebapp.com qa">
                                                <div class="card-body border-faded border-top-0 border-start-0 border-end-0 rounded-top">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <span class="status status-success me-3">
                                                            <span class="rounded-circle profile-image d-block" style="background-image:url('/img/demo/avatars/avatar-f.png'); background-size: cover;"></span>
                                                        </span>
                                                        <div class="info-card-text flex-grow-1">
                                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Emma Davis
                                                                <i class="fal fa-angle-down d-inline-block ms-1 fs-md"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Send Email</a>
                                                                <a class="dropdown-item" href="#">Create Appointment</a>
                                                                <a class="dropdown-item" href="#">Block User</a>
                                                            </div>
                                                            <span class="d-block text-truncate text-truncate-lg">QA Engineer, Testing Team</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0 collapse show">
                                                    <div class="p-3">
                                                        <a href="tel:+13137797613" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mobile-alt text-muted me-2"></i> +1 313-779-7613</a>
                                                        <a href="mailto:emma.davis@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mouse-pointer text-muted me-2"></i> emma.davis@smartadminwebapp.com</a>
                                                        <address class="fs-sm fw-400 mt-4 text-muted mb-0">
                                                            <i class="fal fa-map-pin me-2"></i> 13 Jamie Rd, Detroit, MI, 48313, USA
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div id="c_7" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="david lee +13137794314 david.lee@smartadminwebapp.com devops">
                                                <div class="card-body border-faded border-top-0 border-start-0 border-end-0 rounded-top">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <span class="status status-success me-3">
                                                            <span class="rounded-circle profile-image d-block" style="background-image:url('/img/demo/avatars/avatar-g.png'); background-size: cover;"></span>
                                                        </span>
                                                        <div class="info-card-text flex-grow-1">
                                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                                                David Lee
                                                                <i class="fal fa-angle-down d-inline-block ms-1 fs-md"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Send Email</a>
                                                                <a class="dropdown-item" href="#">Create Appointment</a>
                                                                <a class="dropdown-item" href="#">Block User</a>
                                                            </div>
                                                            <span class="d-block text-truncate text-truncate-lg">DevOps Engineer, Operations Team</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0 collapse show">
                                                    <div class="p-3">
                                                        <a href="tel:+13137794314" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mobile-alt text-muted me-2"></i> +1 313-779-4314</a>
                                                        <a href="mailto:david.lee@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mouse-pointer text-muted me-2"></i> david.lee@smartadminwebapp.com</a>
                                                        <address class="fs-sm fw-400 mt-4 text-muted mb-0">
                                                            <i class="fal fa-map-pin me-2"></i> 55 Smyth Rd, Detroit, MI, 48341, USA
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div id="c_8" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="oliver wilson +13137793347 oliver.wilson@smartadminwebapp.com designer">
                                                <div class="card-body border-faded border-top-0 border-start-0 border-end-0 rounded-top">
                                                    <div class="d-flex flex-row align-items-center">
                                                        <span class="status status-warning me-3">
                                                            <span class="rounded-circle profile-image d-block" style="background-image:url('/img/demo/avatars/avatar-h.png'); background-size: cover;"></span>
                                                        </span>
                                                        <div class="info-card-text flex-grow-1">
                                                            <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Oliver Wilson
                                                                <i class="fal fa-angle-down d-inline-block ms-1 fs-md"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Send Email</a>
                                                                <a class="dropdown-item" href="#">Create Appointment</a>
                                                                <a class="dropdown-item" href="#">Block User</a>
                                                            </div>
                                                            <span class="d-block text-truncate text-truncate-lg">UI Designer, Design Team</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0 collapse show">
                                                    <div class="p-3">
                                                        <a href="tel:+13137793347" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mobile-alt text-muted me-2"></i> +1 313-779-3347</a>
                                                        <a href="mailto:oliver.wilson@smartadminwebapp.com" class="mt-1 d-block fs-sm fw-400">
                                                            <i class="fal fa-mouse-pointer text-muted me-2"></i> oliver.wilson@smartadminwebapp.com</a>
                                                        <address class="fs-sm fw-400 mt-4 text-muted mb-0">
                                                            <i class="fal fa-map-pin me-2"></i> 798 Smyth Rd, Detroit, MI, 48341, USA
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- PAGINATION -->
                            <nav aria-label="Search results pages">
                                <ul class="pagination my-4 justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">First</span>
                                        </a>
                                    </li>
                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">6</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">Last</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
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

    <script src="scripts/pages/search.js"></script>

</body>

</html>