<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::doLogin');
$routes->get('/logout', 'Auth::logout', ['filter' => 'auth']);
$routes->get('/forgot-password', 'Auth::forgotPassword');
$routes->post('/forgot-password', 'Auth::doForgotPassword');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::doRegister');
$routes->get('/income-categories', 'IncomeCategories::index', ['filter' => 'auth']);
$routes->get('/income-categories/create', 'IncomeCategories::create', ['filter' => 'auth']);
$routes->post('/income-categories/store', 'IncomeCategories::store', ['filter' => 'auth']);
$routes->get('/income-categories/edit/(:num)', 'IncomeCategories::edit/$1', ['filter' => 'auth']);
$routes->post('/income-categories/update/(:num)', 'IncomeCategories::update/$1', ['filter' => 'auth']);
$routes->get('/income-categories/delete/(:num)', 'IncomeCategories::delete/$1', ['filter' => 'auth']);
