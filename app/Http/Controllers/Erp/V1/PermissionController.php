<?php
namespace App\Http\controllers\Erp\V1;

use App\Http\Controllers\Controller;
use App\Service\Erp\V1\PermissionService;
use App\Http\Requests\Erp\V1\PermissionRequest;
use App\Http\Requests\Erp\V1\PermissionIndexRequest;

class PermissionController extends Controller{
    protected $permissionService;

    public function __construct(PermissionService $permissionService){
        $this->permissionService = $permissionService;
    }

    public function index(PermissionIndexRequest $request){
        $args = $request->all();
        $args['page'] = $args['page'] ?? 1;
        $args['pSize'] = $args['pSize'] ?? 15;
        return $this->permissionService->permissions($args);
    }

    public function store(PermissionRequest $request){
        return $this->permissionService->permissionStore($request->all());
    }

    public function update(PermissionRequest $request){
        return $this->permissionService->permissionStore($request->all());
    }

    public function destroy($id){
        return $this->permissionService->PermissionDelete($id);
    }
}