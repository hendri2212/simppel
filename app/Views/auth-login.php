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
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6 col-xl-4">
                    <div id="regular-login" class="login-card p-4 p-md-6 bg-dark bg-opacity-50 translucent-dark rounded-4">
                        <h2 class="text-center mb-4">Login</h2>
                        <p class="text-center text-white opacity-50 mb-4">Keep it all together and you'll be free</p>
                        <form action="/appintel">
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
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg bg-primary bg-opacity-75">Sign In</button>
                            </div>
                            <div class="text-center mb-4">
                                <a href="/auth-forgetpassword" class="text-decoration-none small text-white">Forgot Password?</a>
                            </div>
                            <div class="divider small text-white opacity-25">or</div>
                            <div class="d-grid mb-3">
                                <button type="button" id="switchToToken" class="btn btn-dark bg-opacity-50 border-dark btn-lg">
                                    Login Using Token
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="token-login" class="login-card d-none p-4 p-md-6 bg-dark bg-opacity-50 translucent-dark rounded-4">
                        <h2 class="text-center mb-4">Login</h2>
                        <p class="text-center text-white opacity-50 mb-4">Keep it all together and you'll be free</p>
                        <form>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-lg bg-opacity-75" style="--bs-btn-bg:#4285F4; --bs-btn-border-color:#4285F4; --bs-btn-color:#FFFFFF; 
                            --bs-btn-hover-bg:#357ae8; --bs-btn-hover-border-color:#357ae8; --bs-btn-hover-color:#FFFFFF; 
                            --bs-btn-active-bg:#3367d6; --bs-btn-active-border-color:#3367d6; --bs-btn-active-color:#FFFFFF;">
                                    Sign In Using Google
                                </button>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-lg bg-opacity-75" style="--bs-btn-bg:#0078D4; --bs-btn-border-color:#0078D4; --bs-btn-color:#FFFFFF; 
                            --bs-btn-hover-bg:#005A9E; --bs-btn-hover-border-color:#005A9E; --bs-btn-hover-color:#FFFFFF; 
                            --bs-btn-active-bg:#004377; --bs-btn-active-border-color:#004377; --bs-btn-active-color:#FFFFFF;">
                                    Sign In Using Microsoft
                                </button>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-lg bg-opacity-75" style="--bs-btn-bg:#D1D1D6; --bs-btn-border-color:#D1D1D6; --bs-btn-color:#000000; 
                            --bs-btn-hover-bg:#C7C7CC; --bs-btn-hover-border-color:#C7C7CC; --bs-btn-hover-color:#000000;   
                            --bs-btn-active-bg:#BABAC0; --bs-btn-active-border-color:#BABAC0; --bs-btn-active-color:#000000;">
                                    Sign In Using Apple
                                </button>
                            </div>
                            <div class="divider small text-white opacity-25">or</div>

                            <div class="d-grid mb-3">
                                <button type="button" id="switchToRegular" class="btn btn-dark bg-opacity-50 border-dark btn-lg">
                                    Sign In Using Password
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

    <script src="scripts/pages/auth-login.js"></script>

    <!-- Animation Plugin -->
    <script src="/plugins/three/three.min.js"></script>
    <script src="/plugins/vanta/vanta.halo.min.js"></script>
    <script src="/plugins/vanta/vanta.net.min.js"></script>
    <script src="scripts/pages/auth-animation.js"></script>


</body>

</html>