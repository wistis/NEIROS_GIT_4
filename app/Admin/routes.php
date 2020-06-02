<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('/widget_names',WidgetNameController::class );
    $router->resource('/tarifs',TrifsController::class );
    $router->resource('/clients',ClientsController::class );
    $router->resource('/utm',ALpParamsController::class );
});
