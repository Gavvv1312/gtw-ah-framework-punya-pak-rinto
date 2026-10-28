<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('home/tambah', 'Home::tambah');
$routes->post('home/edit', 'Home::edit');
$routes->post('home/hapus/(:num)', 'Home::hapus/$1');