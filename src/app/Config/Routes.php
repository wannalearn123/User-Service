<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- Rute User & Authentication Service ---

$routes->group('api', function($routes) {
    
    // Endpoint Publik (Login & Register) [cite: 58, 59]
    $routes->post('auth/login', 'UserService\AuthController::login');
    $routes->post('auth/register', 'UserService\AuthController::register');

    // Endpoint Terproteksi (Butuh AuthFilter) 
    // Pastikan alias 'auth' sudah didaftarkan di Config/Filters.php
    $routes->group('users', ['filter' => 'auth'], function($routes) {
        $routes->get('(:any)', 'UserService\UserController::show/$1'); // GET /api/users/{id}
    });
});
