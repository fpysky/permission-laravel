<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1',function ($api) {
    $api->group([
        'namespace' => 'App\Http\Controllers\Admin\V1',
    ],function($api){
        //
    });
});