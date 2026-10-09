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
$routes->setAutoRoute(true);
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
$routes->post('/login', 'Auth::loginProcess', ['filter' => 'guest']);
$routes->addRedirect('auth-login', 'login');
$routes->get('/logout', 'Auth::logout');

// Public Pages (Bypass Auth if needed, e.g. register, forgot password)
$routes->get('/register', 'Home::root/auth/register', ['filter' => 'guest']);
$routes->get('/auth-register', 'Home::root/auth/register', ['filter' => 'guest']);
$routes->get('/forgetpassword', 'Home::root/auth/forgetpassword', ['filter' => 'guest']);
$routes->get('/auth-forgetpassword', 'Home::root/auth/forgetpassword', ['filter' => 'guest']);
$routes->get('/lockscreen', 'Home::root/auth/lockscreen', ['filter' => 'guest']);
$routes->get('/auth-lockscreen', 'Home::root/auth/lockscreen', ['filter' => 'guest']);
$routes->get('/twofactor', 'Home::root/auth/twofactor', ['filter' => 'guest']);
$routes->get('/auth-twofactor', 'Home::root/auth/twofactor', ['filter' => 'guest']);

// Protected Routes (Requires Login / AuthFilter)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/account', 'Home::root/accounts');
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
