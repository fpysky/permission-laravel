<?php
namespace App\Http\controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Service\PermissionService;
use App\Http\Requests\AdminerIndexRequest;
use App\Http\Requests\AdminerStoreRequest;

class AdminerController extends Controller{

    protected $permissionService;

    public function __construct(PermissionService $permissionService){
        $this->permissionService = $permissionService;
    }

    public function index(AdminerIndexRequest $request){
        $args = $request->all();
        $args['page'] = $args['page'] ?? 1;
        $args['pSize'] = $args['pSize'] ?? 15;
        return $this->permissionService->adminers($args);
    }

    public function store(AdminerStoreRequest $request){
        $args = $request->all();
        return $this->permissionService->adminerStore($args);
    }
}