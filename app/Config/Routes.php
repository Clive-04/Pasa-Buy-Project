<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::process');

$routes->post('/login/process', 'Auth::loginProcess');
$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/post-request', 'Request::create');
$routes->post('/request/process', 'Request::process');
$routes->post('/request/accept/(:num)', 'Request::accept/$1');
$routes->get('/browse-requests', 'Request::browse');
$routes->get('/request-details', 'Request::details');
$routes->get('/request-details/(:num)', 'Request::details/$1');
$routes->get('/my-requests', 'Request::myRequests');

$routes->get('/messages', 'Message::index');

$routes->get('/about', 'Navbar::about');
$routes->get('/contact', 'Navbar::contact');

$routes->get('/profile', 'Profile::index');
$routes->post('profile/update', 'Profile::updateProfile');
$routes->post('profile/rate-website', 'Profile::rateWebsite');
$routes->post('profile/refer-friend', 'Profile::referFriend');