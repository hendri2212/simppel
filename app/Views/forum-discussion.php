<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Forum: Discussion")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Forum: Discussion", "pageSubTitle1" => "Layouts", "pageSubTitle2" => "Miscellaneous", "pageSubText" => "Discussion view with short and long reply action buttons, jump to dropdown, pagination, likes and star rating system.")) ?>

                    <div class="main-content" >
                        <div class="row">
                            <div class="col-xl-12">

                                <div class="input-group input-group-lg mb-g">
                                    <input type="text" class="form-control shadow-inset-2" placeholder="Search Discussion">
                                    <button class="btn btn-outline-default" type="button">
                                        <i class="fal fa-search"></i>
                                    </button>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <div class="h5 mb-0 d-inline-block">
                                        <a href="/forum-threads">Account information & Security</a> / Package location
                                    </div>
                                    <div class="dropdown ms-auto">
                                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="jumpToRepliesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            Jump to...
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="jumpToRepliesDropdown">
                                            <li><a class="dropdown-item" href="#post-1">Sunny A. (Thread Owner)</a></li>
                                            <li><a class="dropdown-item" href="#post-2">Oliver Kopyov</a></li>
                                            <li><a class="dropdown-item" href="#post-3">Dr. John Cook PhD</a></li>
                                            <li><a class="dropdown-item" href="#post-4">Sarah McBrook</a></li>
                                            <li>
                                                <div class="dropdown-divider"></div>
                                            </li>
                                            <li><a class="dropdown-item" href="#mainReplyForm">Post a New Reply</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- post -->
                                <div class="card mb-g border shadow-0" id="post-1">
                                    <div class="card-header p-0">
                                        <div class="d-flex align-items-center justify-content-between p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="d-block flex-shrink-0">
                                                    <img src="/img/demo/avatars/avatar-admin.png" class="img-fluid img-thumbnail" alt="">
                                                </div>
                                                <div class="d-block ms-2">
                                                    <a href="javascript:void(0);" class="fs-sm h6 fw-500 mb-0 d-block">Sunny A. <span class="badge bg-primary">Thread Owner</span> </a>
                                                    <div class="d-flex mt-1 text-warning align-items-center">
                                                        <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                            <use href="/icons/sprite.svg#star"></use>
                                                        </svg>
                                                        <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                            <use href="/icons/sprite.svg#star"></use>
                                                        </svg>
                                                        <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                            <use href="/icons/sprite.svg#star"></use>
                                                        </svg>
                                                        <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                            <use href="/icons/sprite.svg#star"></use>
                                                        </svg>
                                                        <svg class="sa-icon me-1">
                                                            <use href="/icons/sprite.svg#star"></use>
                                                        </svg>
                                                        <span class="text-muted fs-xs font-italic">
                                                            (140 votes)
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-inline-flex align-items-center ms-auto align-self-start cursor-pointer">
                                                <span>55</span><i class="fas fa-heart ms-1 text-danger"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <p>
                                            Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus quis sem diam. Sed commodo metus in ultrices consequat. Vestibulum eu orci ante. Mauris vel tincidunt mauris. Cras finibus, purus eu pharetra molestie, orci felis lacinia orci, ac congue quam turpis a nibh
                                        </p>
                                        <p>
                                            Nam viverra diam magna, eget lobortis orci tincidunt sed. Donec et lobortis est. Morbi eget massa est. In iaculis odio lectus, sed efficitur nunc viverra non. Nullam molestie eros magna, eu posuere mauris posuere sit amet. Pellentesque hendrerit condimentum ipsum, euismod ornare lectus pharetra eget. Praesent semper est erat, commodo mollis arcu efficitur vitae. Maecenas gravida sit amet nisi vel interdum.
                                        </p>
                                        <p>
                                            Vestibulum molestie, ipsum vitae feugiat lacinia, nisi magna accumsan velit, ac semper nisi felis vitae augue. Vivamus mattis quis erat eu gravida. Integer venenatis risus vitae ullamcorper cursus. Proin sodales odio sed aliquet pulvinar. Duis ipsum erat, ultricies a dolor non, tempor dictum ante. Morbi vel metus lectus
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex align-items-center">
                                            <span class="text-sm text-muted font-italic"><i class="fal fa-clock me-1"></i> Posted 1 week ago</span>
                                            <a href="javascript:void(0);" class="flex-shrink-0 ms-auto" data-bs-toggle="collapse" data-bs-target="#reply-box-1">Reply <i class="fal fa-reply ms-2"></i> </a>
                                        </div>
                                        <div class="collapse mt-3" id="reply-box-1">
                                            <textarea class="form-control" placeholder="Quick reply..." rows="3"></textarea>
                                            <div class="text-end pt-2"><button class="btn btn-success" type="button">Quick Post</button></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- post -end -->

                                <!-- post -->
                                <div class="card mb-g border shadow-0" id="post-2">
                                    <div class="card-header p-0">
                                        <div class="p-3 d-flex align-items-center">
                                            <div class="d-block flex-shrink-0">
                                                <img src="/img/demo/avatars/avatar-b.png" class="img-fluid img-thumbnail" alt="">
                                            </div>
                                            <div class="d-block ms-2">
                                                <span class="h6 fw-bold d-block m-0">RE: Package location</span>
                                                <a href="javascript:void(0);" class="fs-sm h6 fw-500 mb-0 d-block">Oliver Kopyov</a>
                                                <div class="d-flex mt-1 text-warning align-items-center">
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon me-1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon me-1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <span class="text-muted fs-xs font-italic">
                                                        (90 votes)
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-inline-flex align-items-center ms-auto align-self-start cursor-pointer">
                                                <i class="fal fa-heart ms-1 text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <blockquote class="font-italic fw-sm border border-top-0 border-end-0 border-bottom-0 p-3">
                                            Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus quis sem diam. Sed commodo metus in ultrices consequat. Vestibulum eu orci ante. Mauris vel tincidunt mauris. Cras finibus, purus eu pharetra molestie, orci felis lacinia orci, ac congue quam turpis a nibh...
                                        </blockquote>
                                        <p>
                                            Proin vehicula nibh a nisl porta laoreet. Etiam quis massa quam. Etiam elementum nunc accumsan ullamcorper viverra. Sed aliquam ligula eu porta posuere. Nullam in dictum lacus. Nulla auctor hendrerit purus, sit amet lacinia tellus placerat nec. Nunc condimentum urna sit amet blandit egestas. Nam non placerat nisi. Sed sit amet massa porta, porttitor tellus porttitor, sagittis ex. Duis vitae dolor sit amet sem mattis molestie. Aliquam id pharetra leo.
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex align-items-center">
                                            <span class="text-sm text-muted font-italic"><i class="fal fa-clock me-1"></i> Posted 4 days ago</span>
                                            <a href="javascript:void(0);" class="flex-shrink-0 ms-auto" data-bs-toggle="collapse" data-bs-target="#reply-box-2">Reply <i class="fal fa-reply ms-2"></i> </a>
                                        </div>
                                        <div class="collapse mt-3" id="reply-box-2">
                                            <textarea class="form-control" placeholder="Quick reply..." rows="3"></textarea>
                                            <div class="text-end pt-2"><button class="btn btn-success" type="button">Quick Post</button></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- post -end -->

                                <!-- post -->
                                <div class="card mb-g border shadow-0" id="post-3">
                                    <div class="card-header p-0">
                                        <div class="p-3 d-flex align-items-center">
                                            <div class="d-block flex-shrink-0">
                                                <img src="/img/demo/avatars/avatar-e.png" class="img-fluid img-thumbnail" alt="">
                                            </div>
                                            <div class="d-block ms-2">
                                                <div class="h6 mb-0">Replying to <a href="javascript:void(0);">Oliver Kopyov</a></div>
                                                <a href="javascript:void(0);" class="fs-sm h6 fw-500 mb-0 d-block">Dr. John Cook PhD</a>
                                                <div class="d-flex mt-1 text-warning align-items-center">
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <span class="text-muted fs-xs font-italic">
                                                        (77 votes)
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-inline-flex align-items-center ms-auto align-self-start cursor-pointer">
                                                <i class="fal fa-heart ms-1 text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <p>
                                            Proin vehicula nibh a nisl porta laoreet. Etiam quis massa quam. Etiam elementum nunc accumsan ullamcorper viverra. Sed aliquam ligula eu porta posuere. Nullam in dictum lacus. Nulla auctor hendrerit purus, sit amet lacinia tellus placerat nec. Nunc condimentum urna sit amet blandit egestas. Nam non placerat nisi. Sed sit amet massa porta, porttitor tellus porttitor, sagittis ex. Duis vitae dolor sit amet sem mattis molestie. Aliquam id pharetra leo.
                                        </p>
                                        <p>
                                            Vivamus at sapien eget lorem suscipit laoreet. Donec tincidunt augue auctor, ullamcorper urna ac, bibendum odio. Donec ac facilisis mauris. Quisque egestas quam libero, in vulputate purus accumsan vitae
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex align-items-center">
                                            <span class="text-sm text-muted font-italic"><i class="fal fa-clock me-1"></i> Posted 2 days ago</span>
                                            <a href="javascript:void(0);" class="flex-shrink-0 ms-auto" data-bs-toggle="collapse" data-bs-target="#reply-box-3">Reply <i class="fal fa-reply ms-2"></i> </a>
                                        </div>
                                        <div class="collapse mt-3" id="reply-box-3">
                                            <textarea class="form-control" placeholder="Quick reply..." rows="3"></textarea>
                                            <div class="text-end pt-2"><button class="btn btn-success" type="button">Quick Post</button></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- post -end -->

                                <!-- post -->
                                <div class="card mb-g border shadow-0" id="post-4">
                                    <div class="card-header p-0">
                                        <div class="p-3 d-flex align-items-center">
                                            <div class="d-block flex-shrink-0">
                                                <img src="/img/demo/avatars/avatar-h.png" class="img-fluid img-thumbnail" alt="">
                                            </div>
                                            <div class="d-block ms-2">
                                                <span class="h6 d-block m-0">RE: Package location</span>
                                                <a href="javascript:void(0);" class="fs-sm h6 fw-500 mb-0 d-block">Sarah McBrook</a>
                                                <div class="d-flex mt-1 text-warning align-items-center">
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <svg class="sa-icon sa-icon-warning me-1" style="--sa-fill-opacity: 1">
                                                        <use href="/icons/sprite.svg#star"></use>
                                                    </svg>
                                                    <span class="text-muted fs-xs font-italic">
                                                        (146 votes)
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-inline-flex align-items-center ms-auto align-self-start cursor-pointer">
                                                <span>3</span><i class="fas fa-heart ms-1 text-danger"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <p>
                                            Curabitur sollicitudin eros eget nibh commodo posuere. Aenean non diam at massa accumsan elementum eget in arcu. Cras vestibulum ornare nulla, vel porttitor turpis tristique at. In laoreet eleifend dolor, ac eleifend nunc porttitor et. Praesent volutpat risus in metus lacinia porttitor
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex align-items-center">
                                            <span class="text-sm text-muted font-italic"><i class="fal fa-clock me-1"></i> Posted 1 hour ago</span>
                                            <a href="javascript:void(0);" class="flex-shrink-0 ms-auto" data-bs-toggle="collapse" data-bs-target="#reply-box-4">Reply <i class="fal fa-reply ms-2"></i> </a>
                                        </div>
                                        <div class="collapse mt-3" id="reply-box-4">
                                            <textarea class="form-control" placeholder="Quick reply..." rows="3"></textarea>
                                            <div class="text-end pt-2"><button class="btn btn-success" type="button">Quick Post</button></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- post -end -->

                                <!-- Pagination -->
                                <ul class="pagination pagination-sm mt-3 mb-g">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="First">
                                            First
                                        </a>
                                    </li>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            Prev
                                        </a>
                                    </li>
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">
                                            1
                                            <span class="sr-only">(current)</span>
                                        </span>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="paginate_button page-item disabled px-0">…</li>
                                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                                    <li class="page-item"><a class="page-link" href="#">8</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            Next
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Last">
                                            Last
                                        </a>
                                    </li>
                                </ul>

                                <!-- Reply button -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#mainReplyForm">
                                        Reply to this thread
                                    </button>
                                </div>

                                <!-- Reply form -->
                                <div class="collapse" id="mainReplyForm">
                                    <div class="card mb-g border shadow-0">
                                        <div class="card-header">
                                            <h5 class="mb-0 fw-bold">Post a Reply</h5>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="row mb-3">
                                                    <div class="col-lg-8">
                                                        <div class="d-flex mb-2">
                                                            <div class="btn-group me-2">
                                                                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fal fa-bold"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fal fa-italic"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fal fa-underline"></i></button>
                                                            </div>
                                                            <div class="btn-group me-2">
                                                                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fal fa-list-ul"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fal fa-list-ol"></i></button>
                                                                <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fal fa-link"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-control p-3 mb-3" id="quotePreview" style="display: none;">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="fw-bold">Quoting <span id="quoteName">Sarah McBrook</span></span>
                                                            <button type="button" class="btn-close" aria-label="Close" onclick="document.getElementById('quotePreview').style.display = 'none';"></button>
                                                        </div>
                                                        <blockquote class="font-italic p-2 border-start border-3 border-primary ps-3">
                                                            <p class="mb-0">Curabitur sollicitudin eros eget nibh commodo posuere. Aenean non diam at
                                                                massa accumsan elementum eget in arcu...</p>
                                                        </blockquote>
                                                    </div>
                                                    <textarea class="form-control" rows="6" placeholder="Type your reply here..."></textarea>
                                                </div>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <button type="button" class="btn btn-outline-secondary me-2">Save Draft</button>
                                                    <button type="submit" class="btn btn-success">Post</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Reply form -->


                            </div>
                        </div>
                    </div>

                    <!-- New Thread Modal -->
                    <div class="modal fade" id="newThreadModal" tabindex="-1" aria-labelledby="newThreadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="newThreadModalLabel">Create New Thread</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3">
                                            <label for="threadTitle" class="form-label">Thread Title</label>
                                            <input type="text" class="form-control" id="threadTitle" placeholder="Enter a descriptive title for your thread">
                                        </div>

                                        <div class="mb-3">
                                            <label for="threadCategory" class="form-label">Category</label>
                                            <select class="form-select" id="threadCategory">
                                                <option selected>Account information &amp; Security</option>
                                                <option>General Discussion</option>
                                                <option>Troubleshooting</option>
                                                <option>Feature Requests</option>
                                                <option>Product Announcements</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="threadTags" class="form-label">Tags</label>
                                            <input type="text" class="form-control" id="threadTags" placeholder="Add tags separated by commas">
                                            <div class="form-text">Optional tags to help categorize your thread</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="threadContent" class="form-label">Thread Content</label>
                                            <!-- <div class="btn-toolbar mb-2" role="toolbar">
                                <div class="btn-group me-2" role="group">
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-bold"></i></button>
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-italic"></i></button>
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-underline"></i></button>
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-strikethrough"></i></button>
                                </div>
                                <div class="btn-group me-2" role="group">
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-list-ul"></i></button>
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-list-ol"></i></button>
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-indent"></i></button>
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-outdent"></i></button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-link"></i></button>
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-image"></i></button>
                                    <button type="button" class="btn btn-outline-secondary"><i class="fal fa-code"></i></button>
                                </div>
                            </div> -->
                                            <textarea class="form-control" id="threadContent" rows="8" placeholder="Describe your topic in detail"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="threadAttachments" class="form-label">Attachments</label>
                                            <input class="form-control" type="file" id="threadAttachments" multiple>
                                            <div class="form-text">Max file size: 2MB. Allowed formats: jpg, png, gif, pdf, doc, zip</div>
                                        </div>

                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="notifyReplies">
                                            <label class="form-check-label" for="notifyReplies">Notify me when someone replies</label>
                                        </div>

                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="stickyThread">
                                            <label class="form-check-label" for="stickyThread">Make this thread sticky</label>
                                            <div class="form-text">Admin approval required</div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-success">Create Thread</button>
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