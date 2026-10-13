<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->post('login','Auth::authenticate');
$routes->get('logout', 'Auth::logout');
$routes->get('signup','Auth::signup');
$routes->post('signup', 'Auth::register');
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('profile', 'Profile::index');
});