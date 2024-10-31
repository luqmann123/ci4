<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Base route for the home page
$routes->get('/', 'Home::index');

// Authentication routes
$routes->get('admin/login', 'Admin\Admin::login'); // GET form login
$routes->post('admin/login', 'Admin\Admin::loginProcess'); // POST login form
$routes->get('admin/logout', 'Admin\Admin::logout'); // Route for logout

// Dashboard routes
$routes->get('admin/dashboard', 'Admin\Dashboard::index'); // Dashboard page
$routes->get('admin/dashboard/tambah', 'Admin\Dashboard::tambah'); // Page to add new data
$routes->post('admin/dashboard/tambah', 'Admin\Dashboard::tambah'); // POST to save new data

// Edit routes
$routes->get('admin/dashboard/edit/(:num)', 'Admin\Dashboard::edit/$1'); // Page to edit with ID
$routes->post('admin/dashboard/edit/(:num)', 'Admin\Dashboard::edit/$1'); // POST to save edit changes

// Delete route
$routes->post('admin/dashboard/delete/(:num)', 'Admin\Dashboard::delete/$1'); // Route to delete post
$routes->get('admin/akun', 'Admin\Akun::index'); // Adjust the controller and method if needed
$routes->post('admin/akun', 'Admin\Akun::index'); // Adjust the controller and method if needed
$routes->get('admin/page', 'Admin\Page::index'); // Adjust the controller and method if needed
$routes->post('admin/page', 'Admin\Page::index'); // Adjust the controller and method if needed
$routes->get('admin/page/tambah', 'Admin\Page::tambah'); // Adjust the controller and method if needed
$routes->post('admin/page/tambah', 'Admin\Page::tambah'); // Adjust the controller and method if needed
$routes->get('admin/socials', 'Admin\Socials::index'); // Adjust the controller and method if needed
$routes->post('admin/socials', 'Admin\Socials::index'); // Adjust the controller and method if needed


