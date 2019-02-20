<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1',function ($api) {
    $api->group([
        'namespace' => 'App\Http\Controllers\Admin\V1',
        'prefix' => 'admin',
    ],function($api){
        $api->resource('adminers', 'AdminerController', ['only' => ['index', 'store', 'update', 'destroy']]);
        $api->resource('roles', 'RoleController', ['only' => ['index', 'store', 'update', 'destroy']]);
        $api->resource('permissions', 'PermissionController', ['only' => ['index', 'store', 'update', 'destroy']]);
        $api->post('login','AuthController@login');
        $api->get('test',function(){
            preg_match('/http:\/\/([^\/\/]+)\//',url()->current(),$a);
            return ['a' => $a[0],'url' => url()->current()];
        });
    });
});