<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');

$routes->post('/login/process', 'Auth::loginProcess');
$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/post-request', 'Request::create');
$routes->get('/browse-requests', 'Request::browse');
$routes->get('/request-details', 'Request::details');
$routes->get('/request-details/(:num)', 'Request::details/$1');
$routes->get('/my-requests', 'Request::myRequests');