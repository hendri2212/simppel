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
                <a href="/login" class="btn btn-link text-white border-0 text-decoration-none">Login</a>
                <a href="/auth-register" class="btn btn-link text-white border-0 text-decoration-none">Register</a>
            </div>
        </div>
    </nav>

    <!-- Login Page -->
    <section class="hero-section position-relative overflow-hidden">
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6 col-xl-4">

                    <div class="login-card p-4 p-md-5 bg-dark bg-opacity-50 translucent-dark rounded-4 text-center">
                        <div class="mb-4">
                            <img src="/img/demo/avatars/avatar-admin-xl.png" alt="User Avatar" class="rounded-circle border border-light border-opacity-25" width="72" height="72">
                        </div>
                        <h4 class="text-white mb-2">Welcome back, Sunny A.</h4>
                        <p class="text-white opacity-50 mb-4">Enter your password or 2FA code to unlock your session</p>

                        <form>
                            <div class="mb-3 text-start">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control form-control-lg text-white bg-dark border-light border-opacity-25 bg-opacity-25" id="password" placeholder="••••••••" required>
                            </div>

                            <div class="text-white opacity-50 my-2">OR</div>

                            <div class="mb-3 text-start">
                                <label for="otp" class="form-label">Authentication Code</label>
                                <input type="text" class="form-control form-control-lg text-white bg-dark border-light border-opacity-25 bg-opacity-25 text-center" id="otp" placeholder="123456" maxlength="6">
                            </div>

                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary btn-lg bg-primary bg-opacity-75">Unlock</button>
                            </div>

                            <div class="opacity-75">
                                Not you? <a href="/login" class="text-decoration-underline text-white fw-500">Switch Account</a>
                            </div>
                        </form>
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
    <script src="/scripts/pages/auth-animation.js"></script>


</body>

</html>