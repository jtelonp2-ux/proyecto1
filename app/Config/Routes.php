<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');
$routes->get('lang/(:segment)', 'Language::set/$1');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::authenticate');
$routes->get('logout', 'Auth::logout');
$routes->get('signup', 'Auth::signup');
$routes->post('signup', 'Auth::register');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('profile', 'Profile::index');
    $routes->get('profile/confirm', 'Profile::confirm');
    $routes->post('profile/confirm', 'Profile::checkPassword');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/edit', 'Profile::update');
    $routes->get('profile/password', 'Profile::password');
    $routes->post('profile/password', 'Profile::updatePassword');

    $routes->get('tasks', 'Tasks::index');
    $routes->get('tasks/new', 'Tasks::new');
    $routes->post('tasks', 'Tasks::create');
    $routes->get('tasks/(:num)', 'Tasks::show/$1');
    $routes->get('tasks/(:num)/edit', 'Tasks::edit/$1');
    $routes->post('tasks/(:num)/edit', 'Tasks::update/$1');
    $routes->post('tasks/(:num)/delete', 'Tasks::delete/$1');
});
$routes->group('users', ['filter' => ['auth', 'admin']], static function ($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('new', 'Users::new');
    $routes->post('/', 'Users::create');
    $routes->get('(:num)', 'Users::show/$1');
    $routes->get('(:num)/edit', 'Users::edit/$1');
    $routes->post('(:num)/edit', 'Users::update/$1');
    $routes->post('(:num)/delete', 'Users::delete/$1');
});