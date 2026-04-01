<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {

    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/articles', function (RouteBuilder $builder): void {

        $builder->connect('/', ['controller' => 'Articles', 'action' => 'index']);

        $builder->connect('/view/*', ['controller' => 'Articles', 'action' => 'view']);

        $builder->connect('/edit/*', ['controller' => 'Articles', 'action' => 'edit']);

        $builder->connect('/delete/*', ['controller' => 'Articles', 'action' => 'delete']);

        $builder->connect('/search', ['controller' => 'Articles', 'action' => 'search']);
    });

    $routes->scope('/', function (RouteBuilder $builder): void {

        $builder->connect('/', ['controller' => 'Homes', 'action' => 'home']);

        $builder->connect('/api-home', ['controller' => 'Homes', 'action' => 'apiHome']);

        $builder->connect('/dashboard', ['controller' => 'Dashboards', 'action' => 'index']);

        $builder->fallbacks();

    });

};
