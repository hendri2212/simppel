<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "SmartAdmin v5 - Modern Admin Dashboard")) ?>

    <?= $this->include('partials/app-head-css') ?>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark position-fixed w-100 py-3" style="z-index: 1000;">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/img/logo-light.svg" alt="logo">
            </a>
            <div class="ms-auto d-flex gap-2">
                <a href="/auth-login" class="btn btn-link text-white border-0 text-decoration-none">Login</a>
                <a href="/auth-register" class="btn btn-link text-white border-0 text-decoration-none">Register</a>
            </div>
        </div>
    </nav>

    <section class="hero-section position-relative overflow-hidden">
        <div class="container position-relative z-1">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6 col-xl-6">

                    <div id="regular-login" class="login-card p-4 p-md-6 bg-dark bg-opacity-50 translucent-dark rounded-4">
                        <h2 class="text-center mb-4">Forgot Password</h2>
                        <p class="text-center text-white opacity-50 mb-4">Confirmation email will be sent to your email address</p>
                        <form action="/appintel">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Phone</label>
                                <input type="email" class="form-control form-control-lg text-white bg-dark border-light border-opacity-25 bg-opacity-25" id="email" required="">
                            </div>
                            <div class="text-end">
                                <button type="button" id="switchToToken" class="btn btn-warning bg-opacity-50 border-dark btn-lg">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="token-login" class="login-card d-none p-4 p-md-6 bg-dark bg-opacity-50 translucent-dark rounded-4">
                        <div class="d-flex flex-column align-items-center justify-content-center gap-3">
                            <h2 class="text-center mb-4">Sent Email</h2>
                            <p class="text-center text-white mb-4">Please check your email for the reset password link</p>
                            <div class="d-grid">
                                <a href="/auth-login" class="btn btn-dark bg-opacity-50 border-dark btn-lg">
                                    Back to Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="net"></div>

    </section>

    <script src="/plugins/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- Animation Plugin -->
    <script src="/plugins/three/three.min.js"></script>
    <script src="/plugins/vanta/vanta.halo.min.js"></script>
    <script src="/plugins/vanta/vanta.net.min.js"></script>
    <script src="scripts/pages/auth-animation.js"></script>

</body>

</html>