<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    
    $routes->connect('/', ['controller' => 'Paginas', 'action' => 'home']);
    $routes->connect('/dashboard', ['controller' => 'Paginas', 'action' => 'dashboard']);

    $routes->connect('/login', ['controller' => 'Usuarios', 'action' => 'login']);
    $routes->connect('/registro', ['controller' => 'Usuarios', 'action' => 'registro']);    
    $routes->connect('/recordar',     ['controller' => 'Usuarios', 'action' => 'recordarContrasenia']);
    $routes->connect('/cambiar-clave',       ['controller' => 'Usuarios', 'action' => 'cambiarPassword']);
    
    $routes->connect('/terminos', ['controller' => 'Paginas', 'action' => 'terminos']);


    $routes->fallbacks(DashedRoute::class);

});


Router::prefix('Admin', function ($routes) {

    // $routes->redirect('/', '/admin/dashboard');
    $routes->connect('/',           ['controller' => 'Pages', 'action' => 'dashboard']);
    $routes->connect('/dashboard',  ['controller' => 'Pages', 'action' => 'dashboard']);
    $routes->connect('/login',      ['controller' => 'Usuarios', 'action' => 'login']);
    $routes->connect('/logout',     ['controller' => 'Usuarios', 'action' => 'logout']);
    $routes->connect('/perfil', ['controller' => 'Usuarios', 'action' => 'perfil']);

    $routes->fallbacks(InflectedRoute::class);
    // $routes->fallbacks('InflectedRoute');
});

Plugin::routes();
