<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Profile")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <div class="main-content layout-trimmed profile-page position-relative">

                        <!-- Edit Profile Modal -->
                        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="needs-validation" novalidate="">
                                            <div class="row mb-g">
                                                <div class="col-md-12">
                                                    <h6 class="mb-3 text-muted">Personal Information</h6>
                                                    <div class="mb-3">
                                                        <label for="fullName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="fullName" value="John Doe" required="">
                                                        <div class="invalid-feedback"> Please provide your full name. </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="profession" class="form-label">Profession <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="profession" value="Senior Software Engineer at TechCorp" required="">
                                                        <div class="invalid-feedback"> Please provide your profession. </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="skills" class="form-label">Skills (comma separated) <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="skills" value="JavaScript, React, Node.js, UI/UX" required="">
                                                        <div class="invalid-feedback"> Please provide at least one skill. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 class="mb-3 text-muted">Contact Information</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email" value="john.doe@example.com" required="">
                                                    <div class="invalid-feedback"> Please provide a valid email address. </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control" id="phone" value="+1 (555) 123-4567" required="">
                                                    <div class="invalid-feedback"> Please provide a phone number. </div>
                                                </div>
                                            </div>
                                            <div class="mb-g">
                                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="location" value="San Francisco, CA" required="">
                                                <div class="invalid-feedback"> Please provide your location. </div>
                                            </div>
                                            <h6 class="mb-3 text-muted">About Me</h6>
                                            <div class="mb-3 mb-g">
                                                <label for="aboutMe" class="form-label">Bio <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="aboutMe" rows="4" required="">Experienced Software Engineer with a demonstrated history of working in the computer software industry. Skilled in JavaScript, React.js, Node.js, and UI/UX Design. Strong engineering professional with a Bachelor's degree focused in Computer Science.</textarea>
                                                <div class="invalid-feedback"> Please provide a bio. </div>
                                            </div>
                                            <h6 class="mb-3 text-muted">Social Media</h6>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="linkedin" class="form-label">LinkedIn</label>
                                                    <input type="url" class="form-control" id="linkedin" placeholder="LinkedIn profile URL">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="github" class="form-label">GitHub</label>
                                                    <input type="url" class="form-control" id="github" placeholder="GitHub profile URL">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="twitter" class="form-label">Twitter</label>
                                                    <input type="url" class="form-control" id="twitter" placeholder="Twitter profile URL">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="submitProfileForm">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add News Modal -->
                        <div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addNewsModalLabel">Create News Update</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="needs-validation" novalidate>
                                            <div class="mb-3">
                                                <label for="newsTitle" class="form-label">Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="newsTitle" placeholder="Add a title for your news" required>
                                                <div class="invalid-feedback">
                                                    Please provide a title for your news update.
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="newsContent" class="form-label">Content <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="newsContent" rows="4" placeholder="Write your news update..." required></textarea>
                                                <div class="invalid-feedback">
                                                    Please provide content for your news update.
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="newsImage" class="form-label">Image (Optional)</label>
                                                <input type="file" class="form-control" id="newsImage" accept="image/*">
                                                <div class="form-text">Recommended image size: 1200x630 pixels</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Visibility <span class="text-danger">*</span></label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="newsVisibility" id="newsPublic" checked required>
                                                    <label class="form-check-label" for="newsPublic">
                                                        Public - Anyone can see this news update
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="newsVisibility" id="newsConnections" required>
                                                    <label class="form-check-label" for="newsConnections">
                                                        Connections only - Only your connections can see this news update
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="submitNewsForm">Post Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Project Modal -->
                        <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="needs-validation" novalidate>
                                            <div class="mb-3">
                                                <label for="projectTitle" class="form-label">Project Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="projectTitle" placeholder="Enter project title" required>
                                                <div class="invalid-feedback">
                                                    Please provide a project title.
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="projectType" class="form-label">Project Type <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="projectType" required>
                                                        <option value="">Select type</option>
                                                        <option value="website">Website</option>
                                                        <option value="mobile">Mobile App</option>
                                                        <option value="desktop">Desktop App</option>
                                                        <option value="library">Library/Framework</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a project type.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="projectStatus" class="form-label">Status <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="projectStatus" required>
                                                        <option value="">Select status</option>
                                                        <option value="ongoing">Ongoing</option>
                                                        <option value="completed">Completed</option>
                                                        <option value="planned">Planned</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a project status.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectDescription" class="form-label">Description <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="projectDescription" rows="3" placeholder="Describe your project" required></textarea>
                                                <div class="invalid-feedback">
                                                    Please provide a project description.
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectTechnologies" class="form-label">Technologies Used <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="projectTechnologies" placeholder="E.g., React, Node.js, MongoDB" required>
                                                <div class="invalid-feedback">
                                                    Please list the technologies used.
                                                </div>
                                                <div class="form-text">Separate technologies with commas</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="projectImage" class="form-label">Featured Image</label>
                                                <input type="file" class="form-control" id="projectImage" accept="image/*">
                                                <div class="form-text">Recommended image size: 1200x630 pixels</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="projectLink" class="form-label">Project URL (Optional)</label>
                                                    <input type="url" class="form-control" id="projectLink" placeholder="https://example.com">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="projectRepo" class="form-label">Repository URL (Optional)</label>
                                                    <input type="url" class="form-control" id="projectRepo" placeholder="https://github.com/example">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="submitProjectForm">Save Project</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Header Background -->
                        <div class="profile-page-header-underlay bg-info-gradient bg-info-500"></div>

                        <!-- Main Profile Content -->
                        <div class="container-xl position-relative">
                            <!-- Profile Header Section -->
                            <div class="profile-page-header rounded-3 body-bg shadow-3 mb-4">
                                <div class="d-flex flex-column flex-md-row align-items-center position-relative p-4">
                                    <!-- Profile Avatar -->
                                    <div class="profile-page-header-avatar mb-3 mb-md-0">
                                        <div class="position-relative">
                                            <img src="/img/demo/avatars/avatar-admin-xl.png" class="rounded-circle border border-3 border-white shadow-2" alt="John Doe" width="160" height="160">
                                            <button class="btn btn-icon position-absolute bottom-0 end-0 bg-white rounded-circle shadow-2" type="button" title="Edit Profile">
                                                <svg class="sa-icon">
                                                    <use href="/icons/sprite.svg#camera"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Profile Info -->
                                    <div class="profile-page-header-info ms-md-4 text-center text-md-start">
                                        <h1 class="fs-xxl fw-700 mb-2">John Doe</h1>
                                        <p class="text-muted mb-2">Senior Software Engineer at TechCorp</p>
                                        <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                                            <span class="badge bg-primary-100 text-primary">JavaScript</span>
                                            <span class="badge bg-primary-100 text-primary">React</span>
                                            <span class="badge bg-primary-100 text-primary">Node.js</span>
                                            <span class="badge bg-primary-100 text-primary">UI/UX</span>
                                        </div>
                                    </div>

                                    <!-- Profile Actions -->
                                    <div class="profile-page-header-actions ms-md-auto mt-3 mt-md-0 d-flex">
                                        <a href="#" class="btn btn-outline-default me-2 d-flex" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                            <svg class="sa-icon me-2 inline-text">
                                                <use href="/icons/sprite.svg#edit-3"></use>
                                            </svg> Edit Profile
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-outline-default d-flex">
                                            <svg class="sa-icon me-2 inline-block">
                                                <use href="/icons/sprite.svg#share-2"></use>
                                            </svg> Share
                                        </a>
                                    </div>
                                </div>

                                <!-- Profile Navigation -->
                                <div class="profile-page-nav border-top">
                                    <ul class="nav nav-tabs-clean">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#profile-about" data-bs-toggle="tab">
                                                <svg class="sa-icon me-2">
                                                    <use href="/icons/sprite.svg#user"></use>
                                                </svg>
                                                About
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#profile-news" data-bs-toggle="tab">
                                                <svg class="sa-icon me-2">
                                                    <use href="/icons/sprite.svg#rss"></use>
                                                </svg>
                                                News
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#profile-projects" data-bs-toggle="tab">
                                                <svg class="sa-icon me-2">
                                                    <use href="/icons/sprite.svg#folder"></use>
                                                </svg>
                                                Projects
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#profile-contact" data-bs-toggle="tab">
                                                <svg class="sa-icon me-2">
                                                    <use href="/icons/sprite.svg#mail"></use>
                                                </svg>
                                                Contact
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Profile Content -->
                            <div class="tab-content">
                                <!-- About Tab -->
                                <div class="tab-pane fade show active" id="profile-about">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <!-- About Me Section -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>About Me</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <!-- View Mode -->
                                                        <div class="profile-view-mode">
                                                            <p class="mb-4">Experienced Software Engineer with a demonstrated history of working in the computer software industry. Skilled in JavaScript, React.js, Node.js, and UI/UX Design. Strong engineering professional with a Bachelor's degree focused in Computer Science.</p>

                                                            <h5 class="mb-3">Contact Information</h5>
                                                            <div class="d-flex flex-column gap-2">
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon me-2">
                                                                        <use href="/icons/sprite.svg#mail"></use>
                                                                    </svg>
                                                                    john.doe@example.com
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon me-2">
                                                                        <use href="/icons/sprite.svg#phone"></use>
                                                                    </svg>
                                                                    +1 (555) 123-4567
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon me-2">
                                                                        <use href="/icons/sprite.svg#map-pin"></use>
                                                                    </svg>
                                                                    San Francisco, CA
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Edit Mode -->
                                                        <div class="profile-edit-mode d-none">
                                                            <form>
                                                                <div class="mb-3">
                                                                    <label class="form-label">About Me</label>
                                                                    <textarea class="form-control" rows="4">Experienced Software Engineer with a demonstrated history of working in the computer software industry. Skilled in JavaScript, React.js, Node.js, and UI/UX Design. Strong engineering professional with a Bachelor's degree focused in Computer Science.</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Email</label>
                                                                    <input type="email" class="form-control" value="john.doe@example.com">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Phone</label>
                                                                    <input type="tel" class="form-control" value="+1 (555) 123-4567">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Location</label>
                                                                    <input type="text" class="form-control" value="San Francisco, CA">
                                                                </div>
                                                                <div class="d-flex gap-2">
                                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                    <button type="button" class="btn btn-default" data-action="toggle" data-class="profile-edit-mode">Cancel</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Experience Section -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>Experience</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="timeline">
                                                            <div class="timeline-item">
                                                                <div class="timeline-marker bg-primary-500"></div>
                                                                <div class="timeline-content">
                                                                    <h5 class="mb-2">Senior Software Engineer</h5>
                                                                    <p class="text-muted mb-2">TechCorp • 2020 - Present</p>
                                                                    <p>Lead developer for enterprise web applications using React and Node.js.</p>
                                                                </div>
                                                            </div>
                                                            <div class="timeline-item">
                                                                <div class="timeline-marker bg-success-500"></div>
                                                                <div class="timeline-content">
                                                                    <h5 class="mb-2">Software Engineer</h5>
                                                                    <p class="text-muted mb-2">InnovateTech • 2018 - 2020</p>
                                                                    <p>Developed and maintained multiple client-facing applications.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <!-- Skills Section -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>Skills</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <span class="badge bg-primary">JavaScript</span>
                                                            <span class="badge bg-primary">React.js</span>
                                                            <span class="badge bg-primary">Node.js</span>
                                                            <span class="badge bg-primary">TypeScript</span>
                                                            <span class="badge bg-primary">HTML5</span>
                                                            <span class="badge bg-primary">CSS3</span>
                                                            <span class="badge bg-primary">Git</span>
                                                            <span class="badge bg-primary">AWS</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Education Section -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>Education</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="timeline">
                                                            <div class="timeline-item">
                                                                <div class="timeline-marker bg-fusion-500"></div>
                                                                <div class="timeline-content">
                                                                    <h5 class="mb-2">BS in Computer Science</h5>
                                                                    <p class="text-muted mb-2">University of Technology • 2014 - 2018</p>
                                                                    <p>Major in Software Engineering</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- News Tab -->
                                <div class="tab-pane fade" id="profile-news" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="panel mb-4">
                                                <div class="panel-hdr d-flex justify-content-between align-items-center pe-3">
                                                    <h2>Latest Updates</h2>
                                                    <button class="btn btn-outline-default btn-xs px-2" type="button" data-bs-toggle="modal" data-bs-target="#addNewsModal">
                                                        Add News
                                                    </button>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <!-- News Items -->
                                                        <div class="d-flex flex-column gap-4">
                                                            <!-- News Item 1 -->
                                                            <div class="border-bottom pb-4">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <img src="/img/demo/avatars/avatar-admin.png" class="profile-image profile-image-md rounded-circle me-2" alt="John Doe">
                                                                    <div>
                                                                        <h6 class="mb-0">John Doe</h6>
                                                                        <small class="text-muted">Posted 2 days ago</small>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-3">Excited to announce that our latest project has been successfully launched! 🚀</p>
                                                                <img src="/img/demo/peace-full.jpg" class="img-fluid rounded mb-3" alt="Project Launch">
                                                                <div class="d-flex gap-2 mb-3">
                                                                    <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#heart"></use>
                                                                        </svg>
                                                                    </button>
                                                                    <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#message-square"></use>
                                                                        </svg>
                                                                    </button>
                                                                    <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#share-2"></use>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <!-- Comments Section -->
                                                                <div class="comments-section mt-3">
                                                                    <div class="d-flex gap-2 mb-4 align-items-center">
                                                                        <img src="/img/demo/avatars/avatar-admin.png" class="profile-image profile-image-md rounded-circle me-2" alt="John Doe">
                                                                        <div class="flex-grow-1">
                                                                            <div class="comment-input-wrapper position-relative">
                                                                                <input type="text" class="form-control rounded-pill" placeholder="Add a comment...">
                                                                                <div class="comment-actions position-absolute end-0 top-50 translate-middle-y me-2 d-none">
                                                                                    <button type="button" class="btn btn-icon btn-sm">
                                                                                        <svg class="sa-icon">
                                                                                            <use href="/icons/sprite.svg#image"></use>
                                                                                        </svg>
                                                                                    </button>
                                                                                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-3">Post</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Most relevant dropdown -->
                                                                    <div class="dropdown mb-3">
                                                                        <button class="btn btn-link dropdown-toggle p-0 text-muted" type="button" data-bs-toggle="dropdown"> Most relevant </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li><a class="dropdown-item active" href="#">Most relevant</a></li>
                                                                            <li><a class="dropdown-item" href="#">Most recent</a></li>
                                                                        </ul>
                                                                    </div>
                                                                    <!-- Comments List -->
                                                                    <div class="comments-list">
                                                                        <!-- Comment 1 -->
                                                                        <div class="comment-thread mb-4">
                                                                            <div class="d-flex gap-2">
                                                                                <img src="/img/demo/avatars/avatar-g.png" class="profile-image profile-image-md rounded-circle me-2 mt-3" width="40" height="40" alt="Iftekhar Ahmed">
                                                                                <div class="flex-grow-1">
                                                                                    <div class="comment-content body-bg rounded-3 p-3 ps-0">
                                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                            <h6 class="mb-0 fw-bold">Iftekhar Ahmed</h6>
                                                                                            <div class="dropdown">
                                                                                                <button type="button" class="btn btn-icon btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                                    <svg class="sa-icon">
                                                                                                        <use href="/icons/sprite.svg#more-horizontal"></use>
                                                                                                    </svg>
                                                                                                </button>
                                                                                                <ul class="dropdown-menu">
                                                                                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                                                                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                                                                                    <li><a class="dropdown-item" href="#">Report</a></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                        <p class="text-muted small mb-2">Marketing Professional • 3rd+</p>
                                                                                        <p class="mb-2">Job well done!</p>
                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                            <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                                                <svg class="sa-icon">
                                                                                                    <use href="/icons/sprite.svg#thumbs-up"></use>
                                                                                                </svg>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                                                <svg class="sa-icon">
                                                                                                    <use href="/icons/sprite.svg#message-square"></use>
                                                                                                </svg>
                                                                                            </button>
                                                                                            <span class="text-muted small">1 week ago</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Nested Reply -->
                                                                                    <div class="comment-thread mt-3">
                                                                                        <div class="d-flex gap-2">
                                                                                            <img src="/img/demo/avatars/avatar-h.png" class="profile-image profile-image-md rounded-circle me-2 mt-3" width="40" height="40" alt="SAFAYET DOZZA">
                                                                                            <div class="flex-grow-1">
                                                                                                <div class="comment-content body-bg rounded-3 p-3 ps-0">
                                                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                                        <h6 class="mb-0 fw-bold">SAFAYET DOZZA</h6>
                                                                                                        <div class="dropdown">
                                                                                                            <button type="button" class="btn btn-icon btn-sm" data-bs-toggle="dropdown">
                                                                                                                <svg class="sa-icon">
                                                                                                                    <use href="/icons/sprite.svg#more-horizontal"></use>
                                                                                                                </svg>
                                                                                                            </button>
                                                                                                            <ul class="dropdown-menu">
                                                                                                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                                                                                                <li><a class="dropdown-item" href="#">Delete</a></li>
                                                                                                                <li><a class="dropdown-item" href="#">Report</a></li>
                                                                                                            </ul>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <p class="text-muted small mb-2">Merchandising Strategist • 3rd+</p>
                                                                                                    <p class="mb-2">This is a really great project, loved it also!</p>
                                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                                        <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                                                            <svg class="sa-icon">
                                                                                                                <use href="/icons/sprite.svg#thumbs-up"></use>
                                                                                                            </svg>
                                                                                                        </button>
                                                                                                        <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                                                            <svg class="sa-icon">
                                                                                                                <use href="/icons/sprite.svg#message-square"></use>
                                                                                                            </svg>
                                                                                                        </button>
                                                                                                        <span class="text-muted small">1 week ago</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Load more replies button -->
                                                                                        <button type="button" class="btn btn-link text-muted mt-2 p-0">Load more replies</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Load more comments button -->
                                                                        <button type="button" class="btn btn-light rounded-pill w-100">Load more comments</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- News Item 2 -->
                                                            <div class="border-bottom pb-4">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <img src="/img/demo/avatars/avatar-admin.png" class="profile-image profile-image-md rounded-circle me-2" alt="John Doe">
                                                                    <div>
                                                                        <h6 class="mb-0">John Doe</h6>
                                                                        <small class="text-muted">Posted 1 week ago</small>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-3">Just completed a certification in Advanced React Development! 📚</p>
                                                                <div class="d-flex gap-2 mb-3">
                                                                    <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#heart"></use>
                                                                        </svg>
                                                                    </button>
                                                                    <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#message-square"></use>
                                                                        </svg>
                                                                    </button>
                                                                    <button type="button" class="btn btn-icon btn-default rounded-circle">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#share-2"></use>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <!-- Profile Views -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>Profile Views</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="d-flex flex-column gap-3">
                                                            <div class="d-flex align-items-center">
                                                                <img src="/img/demo/avatars/avatar-c.png" class="rounded-circle me-3" width="48" height="48" alt="Emily Chen">
                                                                <div>
                                                                    <h6 class="mb-0">Emily Chen</h6>
                                                                    <small class="text-muted">Senior UX Designer</small>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/img/demo/avatars/avatar-b.png" class="rounded-circle me-3" width="48" height="48" alt="Michael Smith">
                                                                <div>
                                                                    <h6 class="mb-0">Michael Smith</h6>
                                                                    <small class="text-muted">Tech Lead at Google</small>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/img/demo/avatars/avatar-d.png" class="rounded-circle me-3" width="48" height="48" alt="Lisa Wong">
                                                                <div>
                                                                    <h6 class="mb-0">Lisa Wong</h6>
                                                                    <small class="text-muted">Product Manager</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- People You Might Know -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>People You Might Know</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="d-flex flex-column gap-3">
                                                            <div class="d-flex align-items-center">
                                                                <img src="/img/demo/avatars/avatar-e.png" class="rounded-circle me-3" width="48" height="48" alt="David Kim">
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-0">David Kim</h6>
                                                                    <small class="text-muted">Frontend Developer at Meta</small>
                                                                </div>
                                                                <button type="button" class="btn btn-xs btn-primary d-flex"> Connect </button>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/img/demo/avatars/avatar-f.png" class="rounded-circle me-3" width="48" height="48" alt="Rachel Green">
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-0">Rachel Green</h6>
                                                                    <small class="text-muted">UI Designer at Apple</small>
                                                                </div>
                                                                <button type="button" class="btn btn-xs btn-primary d-flex"> Connect </button>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <img src="/img/demo/avatars/avatar-g.png" class="rounded-circle me-3" width="48" height="48" alt="Tom Wilson">
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-0">Tom Wilson</h6>
                                                                    <small class="text-muted">Backend Developer at Amazon</small>
                                                                </div>
                                                                <button type="button" class="btn btn-xs btn-primary d-flex"> Connect </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Projects Tab -->
                                <div class="tab-pane fade" id="profile-projects">
                                    <div class="row">
                                        <!-- Project Carousel -->
                                        <div class="col-12 mb-4">
                                            <div class="panel">
                                                <div class="panel-hdr d-flex justify-content-between align-items-center pe-3">
                                                    <h2>Featured Projects</h2>
                                                    <button type="button" class="btn btn-outline-default btn-xs px-2" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                                                        Add Project
                                                    </button>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div id="projectCarousel" class="carousel slide" data-bs-ride="carousel">
                                                            <div class="carousel-indicators">
                                                                <button type="button" data-bs-target="#projectCarousel" data-bs-slide-to="0" class="active"></button>
                                                                <button type="button" data-bs-target="#projectCarousel" data-bs-slide-to="1"></button>
                                                                <button type="button" data-bs-target="#projectCarousel" data-bs-slide-to="2"></button>
                                                            </div>
                                                            <div class="carousel-inner">
                                                                <div class="carousel-item active">
                                                                    <img src="/img/profile/project-3.png" class="d-block w-100" alt="Project 1">
                                                                    <div class="carousel-caption">
                                                                        <h5>E-Commerce Platform</h5>
                                                                        <p>A modern shopping experience built with React and Node.js</p>
                                                                    </div>
                                                                </div>
                                                                <div class="carousel-item">
                                                                    <img src="/img/profile/project-1.png" class="d-block w-100" alt="Project 2">
                                                                    <div class="carousel-caption">
                                                                        <h5>Task Management App</h5>
                                                                        <p>Streamline your workflow with our intuitive task manager</p>
                                                                    </div>
                                                                </div>
                                                                <div class="carousel-item">
                                                                    <img src="/img/profile/project-4.png" class="d-block w-100" alt="Project 3">
                                                                    <div class="carousel-caption">
                                                                        <h5>Social Media Dashboard</h5>
                                                                        <p>Analytics and management tools for social media professionals</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="carousel-control-prev" type="button" data-bs-target="#projectCarousel" data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon"></span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </button>
                                                            <button type="button" class="carousel-control-next" type="button" data-bs-target="#projectCarousel" data-bs-slide="next">
                                                                <span class="carousel-control-next-icon"></span>
                                                                <span class="visually-hidden">Next</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Project Grid -->
                                        <div class="col-md-6 col-xl-4 mb-4">
                                            <div class="panel h-100">
                                                <div class="panel-container">
                                                    <div class="panel-content p-0">
                                                        <div class="position-relative">
                                                            <div class="w-100 height-sm bg-placeholder rounded-top overflow-hidden" style="--body-bg: #b19e97; --gp-color-1: #6d5c53;"></div>
                                                            <div class="position-absolute bottom-0 start-0 w-100 p-3 text-white">
                                                                <h5 class="mb-1">E-Commerce Platform</h5>
                                                                <p class="mb-0 small">React • Node.js • MongoDB</p>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <p class="mb-3">A full-featured e-commerce platform with real-time inventory management and analytics.</p>
                                                            <a href="#" class="btn btn-default btn-sm">View Project</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-4 mb-4">
                                            <div class="panel h-100">
                                                <div class="panel-container">
                                                    <div class="panel-content p-0">
                                                        <div class="position-relative">
                                                            <div class="w-100 height-sm bg-placeholder rounded-top overflow-hidden" style="--body-bg: #262a33; --gp-color-1: #a3a5ad;"></div>
                                                            <div class="position-absolute bottom-0 start-0 w-100 p-3 text-white">
                                                                <h5 class="mb-1">Task Management App</h5>
                                                                <p class="mb-0 small">Vue.js • Express • PostgreSQL</p>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <p class="mb-3">Intuitive task management application with team collaboration features.</p>
                                                            <a href="#" class="btn btn-default btn-sm">View Project</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-4 mb-4">
                                            <div class="panel h-100">
                                                <div class="panel-container">
                                                    <div class="panel-content p-0">
                                                        <div class="position-relative">
                                                            <div class="w-100 height-sm bg-placeholder rounded-top overflow-hidden" style="--body-bg: #18a2c2; --gp-color-1: #624492;"></div>
                                                            <div class="position-absolute bottom-0 start-0 w-100 p-3 text-white">
                                                                <h5 class="mb-1">Social Media Dashboard</h5>
                                                                <p class="mb-0 small">Angular • Firebase • Chart.js</p>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <p class="mb-3">Comprehensive social media analytics and management dashboard.</p>
                                                            <a href="#" class="btn btn-default btn-sm">View Project</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Tab -->
                                <div class="tab-pane fade" id="profile-contact">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <!-- Contacts List -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>My Contacts</h2>
                                                    <div class="panel-toolbar">
                                                        <div class="input-group mt-3">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Search contacts...">
                                                            <button type="button" class="btn btn-outline-default btn-sm">
                                                                <svg class="sa-icon">
                                                                    <use href="/icons/sprite.svg#search"></use>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="d-flex flex-column gap-4">
                                                            <!-- Contact Categories -->
                                                            <div class="d-flex gap-2 border-bottom pb-3">
                                                                <button type="button" class="btn btn-sm btn-light active">All</button>
                                                                <button type="button" class="btn btn-sm btn-light">Favorites</button>
                                                                <button type="button" class="btn btn-sm btn-light">Recent</button>
                                                            </div>

                                                            <!-- Contact List -->
                                                            <div class="list-group">
                                                                <div class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                                                                    <img src="/img/demo/avatars/avatar-d.png" class="rounded-circle" width="48" height="48" alt="Sarah Johnson">
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-0">Sarah Johnson</h6>
                                                                        <small class="text-muted">Senior UX Designer at Adobe</small>
                                                                    </div>
                                                                    <div class="d-flex gap-2">
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#message-square"></use>
                                                                            </svg>
                                                                        </button>
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#star"></use>
                                                                            </svg>
                                                                        </button>
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#more-vertical"></use>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <div class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                                                                    <img src="/img/demo/avatars/avatar-e.png" class="rounded-circle" width="48" height="48" alt="Michael Smith">
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-0">Michael Smith</h6>
                                                                        <small class="text-muted">Tech Lead at Google</small>
                                                                    </div>
                                                                    <div class="d-flex gap-2">
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#message-square"></use>
                                                                            </svg>
                                                                        </button>
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#star"></use>
                                                                            </svg>
                                                                        </button>
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#more-vertical"></use>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <div class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                                                                    <img src="/img/demo/avatars/avatar-f.png" class="rounded-circle" width="48" height="48" alt="Emily Chen">
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-0">Emily Chen</h6>
                                                                        <small class="text-muted">Product Manager at Microsoft</small>
                                                                    </div>
                                                                    <div class="d-flex gap-2">
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#message-square"></use>
                                                                            </svg>
                                                                        </button>
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#star"></use>
                                                                            </svg>
                                                                        </button>
                                                                        <button type="button" class="btn btn-icon btn-light">
                                                                            <svg class="sa-icon">
                                                                                <use href="/icons/sprite.svg#more-vertical"></use>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <!-- Contact Information -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>Contact Information</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="d-flex flex-column gap-4">
                                                            <div>
                                                                <h6 class="mb-2">Email</h6>
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon me-2">
                                                                        <use href="/icons/sprite.svg#mail"></use>
                                                                    </svg>
                                                                    john.doe@example.com
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-2">Phone</h6>
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon me-2">
                                                                        <use href="/icons/sprite.svg#phone"></use>
                                                                    </svg>
                                                                    +1 (555) 123-4567
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-2">Location</h6>
                                                                <div class="d-flex align-items-center">
                                                                    <svg class="sa-icon me-2">
                                                                        <use href="/icons/sprite.svg#map-pin"></use>
                                                                    </svg>
                                                                    San Francisco, CA
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-2">Social Media</h6>
                                                                <div class="d-flex gap-2">
                                                                    <a href="#" class="btn btn-icon btn-light">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#linkedin"></use>
                                                                        </svg>
                                                                    </a>
                                                                    <a href="#" class="btn btn-icon btn-light">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#github"></use>
                                                                        </svg>
                                                                    </a>
                                                                    <a href="#" class="btn btn-icon btn-light">
                                                                        <svg class="sa-icon">
                                                                            <use href="/icons/sprite.svg#twitter"></use>
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Office Hours -->
                                            <div class="panel mb-4">
                                                <div class="panel-hdr">
                                                    <h2>Office Hours</h2>
                                                </div>
                                                <div class="panel-container">
                                                    <div class="panel-content">
                                                        <div class="d-flex flex-column gap-2">
                                                            <div class="d-flex justify-content-between">
                                                                <span>Monday - Friday</span>
                                                                <span>9:00 AM - 5:00 PM</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span>Saturday</span>
                                                                <span>10:00 AM - 2:00 PM</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span>Sunday</span>
                                                                <span>Closed</span>
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

    <script src="scripts/pages/profile.js"></script>

</body>

</html>