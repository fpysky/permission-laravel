<?php
namespace App\Http\controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Service\PermissionService;
use App\Http\Requests\RoleIndexRequest;

class RoleController extends Controller{
    protected $permissionService;

    public function __construct(PermissionService $permissionService){
        $this->permissionService = $permissionService;
    }

    public function index(RoleIndexRequest $request){
        $args = $request->all();
        $args['page'] = $args['page'] ?? 1;
        $args['pSize'] = $args['pSize'] ?? 15;
        return $this->permissionService->roles($args);
    }
}