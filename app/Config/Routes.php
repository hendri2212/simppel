<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
        require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/login', 'Auth::index', ['filter' => 'noauth']);
// $routes->post('/loginCheck', 'Auth::loginCheck');

// Authentication Routes (Guest Only)
$routes->get('/login', 'Auth::login', ['filter' => 'guest']);
$routes->post('/login', 'Auth::loginProcess', ['filter' => ['guest', 'csrf']]);
$routes->get('/auth-login', 'Auth::login', ['filter' => 'guest']);
$routes->post('/logout', 'Auth::logout', ['filter' => 'csrf']);

// Public Pages (Bypass Auth if needed, e.g. register, forgot password)
$routes->get('/register', 'Auth::register', ['filter' => 'guest']);
$routes->get('/auth-register', 'Auth::register', ['filter' => 'guest']);
$routes->get('/forgetpassword', 'Auth::forgetPassword', ['filter' => 'guest']);
$routes->get('/auth-forgetpassword', 'Auth::forgetPassword', ['filter' => 'guest']);
$routes->get('/lockscreen', 'Auth::lockscreen');
$routes->get('/auth-lockscreen', 'Auth::lockscreen');
$routes->get('/twofactor', 'Auth::twoFactor');
$routes->get('/auth-twofactor', 'Auth::twoFactor');

// Manajemen Akun (khusus ADMINISTRATOR, mutasi dilindungi CSRF)
$routes->group('', ['filter' => ['auth', 'role:ADMINISTRATOR']], static function ($routes) {
    // Filter per-route menimpa filter group, jadi seluruhnya disebut ulang di sini
    $mutate = ['filter' => ['auth', 'role:ADMINISTRATOR', 'csrf']];

    $routes->get('/accounts', 'AccountController::index');
    $routes->get('/account', 'AccountController::index');
    $routes->get('/accounts/ppk', 'AccountController::getPpk');
    $routes->get('/accounts/ppk/(:num)', 'AccountController::getPpk/$1');
    $routes->post('/accounts/store', 'AccountController::store', $mutate);
    $routes->post('/accounts/update/(:num)', 'AccountController::update/$1', $mutate);
    $routes->post('/accounts/update', 'AccountController::update', $mutate);
    $routes->post('/accounts/reset-password/(:num)', 'AccountController::resetPassword/$1', $mutate);
    $routes->post('/accounts/reset-password', 'AccountController::resetPassword', $mutate);
});

// Protected Routes (Requires Login / AuthFilter)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Filter per-route menimpa filter group, jadi auth disebut ulang di sini
    $writeMutate = ['filter' => ['auth', 'role:ADMINISTRATOR,ADMIN PPK,PPK,ADMIN AGENCY', 'csrf']];
    // Semua role proses (kecuali MONEV); hak aksi sebenarnya dicek per paket di PaketWorkflow
    $writeAny = ['filter' => ['auth', 'role:!MONEV', 'csrf']];

    $routes->get('/', 'Home::index');
    $routes->get('/rup', 'RupController::index', ['filter' => ['auth', 'role:!ADMIN ULP']]);
    $routes->get('/rup/inaproc/(:segment)', 'RupController::fetchInaproc/$1', ['filter' => ['auth', 'role:!ADMIN ULP']]);
    $routes->post('/rup/store', 'RupController::store', $writeMutate);
    $routes->post('/rup/update/(:num)', 'RupController::update/$1', $writeMutate);
    $routes->post('/rup/delete/(:num)', 'RupController::delete/$1', $writeMutate);
    $routes->get('/paket', 'PaketController::index');
    $routes->post('/paket/store', 'PaketController::store', $writeMutate);
    $routes->post('/paket/update/(:num)', 'PaketController::update/$1', $writeMutate);
    $routes->post('/paket/delete/(:num)', 'PaketController::delete/$1', $writeMutate);
    $routes->post('/paket/ajukan/(:num)', 'PaketController::ajukan/$1', $writeMutate);

    // Manajemen Dokumen Persyaratan Paket
    $routes->get('/paket/syarat/(:num)', 'PaketController::getSyarat/$1');
    $routes->post('/paket/syarat/upload', 'PaketController::uploadSyarat', $writeMutate);
    $routes->post('/paket/syarat/upload2', 'PaketController::uploadSyaratBaru', $writeMutate);
    $routes->post('/paket/syarat/delete/(:num)', 'PaketController::deleteSyarat/$1', $writeMutate);
    $routes->get('/paket/syarat/download/(:num)', 'PaketController::downloadSyarat/$1');

    // Tahapan paket setelah diajukan (verifikasi ULP, Pokja, lelang, hasil, selesai)
    $routes->post('/paket/aksi/(:segment)/(:num)', 'PaketWorkflowController::transition/$1/$2', $writeAny);
    $routes->get('/paket/pokja/(:num)', 'PaketWorkflowController::pokja/$1');
    $routes->post('/paket/pokja/store', 'PaketWorkflowController::pokjaStore', $writeAny);
    $routes->post('/paket/pokja/delete/(:num)', 'PaketWorkflowController::pokjaDelete/$1', $writeAny);
    $routes->get('/paket/catatan/(:num)', 'PaketWorkflowController::catatan/$1');
    $routes->post('/paket/catatan/store', 'PaketWorkflowController::catatanStore', $writeAny);
    $routes->post('/paket/catatan/jawab/(:num)', 'PaketWorkflowController::catatanJawab/$1', $writeAny);
    $routes->post('/paket/hasil/(:num)', 'PaketWorkflowController::simpanHasil/$1', $writeAny);
    $routes->post('/paket/lpse/(:num)', 'PaketWorkflowController::lpse/$1', $writeAny);
    $routes->get('/paket/dokumen/(:num)', 'PaketWorkflowController::dokumen/$1');
    $routes->post('/paket/dokumen/upload', 'PaketWorkflowController::dokumenUpload', $writeAny);
    $routes->post('/paket/dokumen/delete/(:num)', 'PaketWorkflowController::dokumenDelete/$1', $writeAny);
    $routes->get('/paket/dokumen/download/(:num)', 'PaketWorkflowController::dokumenDownload/$1');

    $routes->get('/(:any)', 'Home::root/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
        require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
