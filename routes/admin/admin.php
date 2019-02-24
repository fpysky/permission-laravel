<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1',function ($api) {
    $api->group([
        'namespace' => 'App\Http\Controllers\Erp\V1',
        'prefix' => 'admin',
    ],function($api){
        $api->resource('adminers', 'AdminerController', ['only' => ['index', 'store', 'update', 'destroy']]);
        $api->resource('roles', 'RoleController', ['only' => ['index', 'store', 'update', 'destroy']]);
        $api->resource('permissions', 'PermissionController', ['only' => ['index', 'store', 'update', 'destroy']]);
        $api->post('login','AuthController@login');
        $api->get('test',function(){});
    });

    $api->group([
        'namespace' => 'App\Http\Controllers\Erp\V1',
        'prefix' => 'admin',
        'middleware' => 'auth:admin',
    ],function($api){
        $api->get('user','AuthController@user');
    });
});