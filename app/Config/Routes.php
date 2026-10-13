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
     $routes->get('profile/confirm', 'Profile::confirm');  
    $routes->post('profile/confirm', 'Profile::checkPassword');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/edit', 'Profile::update');
    $routes->get('profile/password', 'Profile::password');
    $routes->post('profile/password', 'Profile::updatePassword');
});

