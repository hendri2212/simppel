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

                    <div class="login-card p-4 p-md-6 bg-dark bg-opacity-50 translucent-dark rounded-4">
                        <h2 class="text-center mb-4">Register</h2>
                        <p class="text-center text-white opacity-50 mb-4">Keep it all together and you'll be free</p>
                        <form>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Phone</label>
                                <input type="email" class="form-control form-control-lg text-white bg-dark border-light border-opacity-25 bg-opacity-25" id="email" required="">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg text-white bg-dark border-light border-opacity-25 bg-opacity-25" id="password" required="">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg text-white bg-dark border-light border-opacity-25 bg-opacity-25" id="password-confirm" required="">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input bg-dark border-light border-opacity-25 bg-opacity-25" type="checkbox" id="terms" required="">
                                    <label class="form-check-label" for="terms">I agree to the <a href="#!" class="text-decoration-underline text-white fw-500">Terms of Service</a> and <a href="#!" class="text-decoration-underline text-white fw-500">Privacy Policy</a></label>
                                </div>
                            </div>
                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary btn-lg bg-primary bg-opacity-75">Register</button>
                            </div>
                            <div class="opacity-75">
                                Already have an account? <a href="/login" class="text-decoration-underline text-white fw-500">Login here</a>
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