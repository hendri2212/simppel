<?= $this->include('partials/app-html') ?>

<head>
    <?php echo view("partials/app-meta-title", array("pageTitle" => "Login - SIMPPLE")) ?>

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

    <section class="hero-section position-relative overflow-hidden">
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6 col-xl-4">
                    <div id="regular-login" class="login-card p-4 p-md-5 bg-dark bg-opacity-50 translucent-dark rounded-4">
                        <h2 class="text-center mb-2 text-white">Login</h2>
                        <p class="text-center text-white opacity-50 mb-4">Masuk untuk mengakses aplikasi SIMPPLE</p>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger bg-danger bg-opacity-75 border-0 text-white alert-dismissible fade show fs-sm mb-3" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success bg-success bg-opacity-75 border-0 text-white alert-dismissible fade show fs-sm mb-3" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="/login" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="login" class="form-label text-white">Username atau Email</label>
                                <input type="text" name="login" class="form-control form-control-lg text-white bg-dark border-light border-opacity-25 bg-opacity-25" id="login" value="<?= esc(old('login')) ?>" placeholder="admin / admin@simpple.com" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-white">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control form-control-lg text-white bg-dark border-light border-opacity-25 bg-opacity-25" id="password" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                    <label class="form-check-label text-white opacity-75 small" for="rememberMe">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="/auth-forgetpassword" class="text-decoration-none small text-white opacity-75">Lupa Password?</a>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg bg-primary bg-opacity-75">Sign In</button>
                            </div>

                            <div class="divider small text-white opacity-25">atau</div>

                            <div class="d-grid mb-2">
                                <button type="button" id="switchToToken" class="btn btn-dark bg-opacity-50 border-dark btn-lg">
                                    Login Menggunakan Token / SSO
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="token-login" class="login-card d-none p-4 p-md-5 bg-dark bg-opacity-50 translucent-dark rounded-4">
                        <h2 class="text-center mb-4 text-white">Login SSO</h2>
                        <p class="text-center text-white opacity-50 mb-4">Masuk menggunakan akun terintegrasi</p>
                        <form>
                            <div class="d-grid mb-3">
                                <button type="button" class="btn btn-lg bg-opacity-75" style="--bs-btn-bg:#4285F4; --bs-btn-border-color:#4285F4; --bs-btn-color:#FFFFFF; 
                            --bs-btn-hover-bg:#357ae8; --bs-btn-hover-border-color:#357ae8; --bs-btn-hover-color:#FFFFFF; 
                            --bs-btn-active-bg:#3367d6; --bs-btn-active-border-color:#3367d6; --bs-btn-active-color:#FFFFFF;">
                                    Sign In Using Google
                                </button>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="button" class="btn btn-lg bg-opacity-75" style="--bs-btn-bg:#0078D4; --bs-btn-border-color:#0078D4; --bs-btn-color:#FFFFFF; 
                            --bs-btn-hover-bg:#005A9E; --bs-btn-hover-border-color:#005A9E; --bs-btn-hover-color:#FFFFFF; 
                            --bs-btn-active-bg:#004377; --bs-btn-active-border-color:#004377; --bs-btn-active-color:#FFFFFF;">
                                    Sign In Using Microsoft
                                </button>
                            </div>
                            <div class="divider small text-white opacity-25">atau</div>

                            <div class="d-grid mb-3">
                                <button type="button" id="switchToRegular" class="btn btn-dark bg-opacity-50 border-dark btn-lg">
                                    Kembali ke Form Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="net"></div>
    </section>

    <script src="/plugins/bootstrap/bootstrap.bundle.min.js"></script>

    <script src="/scripts/pages/auth-login.js"></script>

    <!-- Animation Plugin -->
    <script src="/plugins/three/three.min.js"></script>
    <script src="/plugins/vanta/vanta.halo.min.js"></script>
    <script src="/plugins/vanta/vanta.net.min.js"></script>
    <script src="/scripts/pages/auth-animation.js"></script>

</body>

</html>
