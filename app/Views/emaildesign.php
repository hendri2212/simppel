<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Email Design")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <div class="app-wrap">

        <?= $this->include('partials/app-header') ?>

        <?= $this->include('partials/app-sidebar') ?>

        <main class="app-body">
            <div class="app-content">

                <div class="content-wrapper">

                    <?php echo view("partials/app-pagetitle", array("pageTitle" => "Email Design", "pageSubTitle1" => "Layouts", "pageSubTitle2" => "Authentication", "pageSubText" => "Variety of email designs for different scenarios.")) ?>

                    <div class="main-content" >
                        <div class="info-container">
                            <p class="mb-0">
                                You can find your email templates inside the source directory <code>SmartAdmin/src/e-templates</code>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="card m-auto border mb-g">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        Order Confirmation
                                    </div>
                                    <div class="card-body">
                                        <img src="/img/demo/pages/email-order.webp" alt="Login Page" class="img-fluid inverse-color">
                                    </div>
                                </div>

                                <div class="card m-auto border  mb-g">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        New Device Detected
                                    </div>
                                    <div class="card-body">
                                        <img src="/img/demo/pages/new-device.webp" alt="New Device Detected" class="img-fluid inverse-color">
                                    </div>
                                </div>

                                <div class="card m-auto border">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        Verify Email
                                    </div>
                                    <div class="card-body">
                                        <img src="/img/demo/pages/verify-email.webp" alt="Verify Email" class="img-fluid inverse-color">
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="card m-auto border mb-g">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        Password Change Request
                                    </div>
                                    <div class="card-body">
                                        <img src="/img/demo/pages/password-request.webp" alt="Password Change Request" class="img-fluid inverse-color">
                                    </div>
                                </div>

                                <div class="card m-auto border">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        One Time Code
                                    </div>
                                    <div class="card-body">
                                        <img src="/img/demo/pages/password-reset.webp" alt="Password Reset" class="img-fluid inverse-color">
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