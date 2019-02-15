<?php
namespace App\Service;

use App\Http\Resources\AdminerResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use App\Models\Adminer;
use App\Models\AdminHasRole;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;
use DB;

class PermissionService extends BaseService {
    public function adminers($args){
        $where = [];
        if(isset($args['keyword']) && !empty($args['keyword'])){
            $res = $this->buildKeywordWhere($args['keyword'],['account','nick_name'],'adminers');
            if($res) $where[] = $res;
        }
        if(isset($args['stime']) && !empty($args['stime'])){
            $where[] = ['created_at','>=',$args['stime']];
        }
        if(isset($args['etime']) && !empty($args['etime'])){
            $where[] = ['created_at','<',$args['etime']];
        }
        $list = Adminer::where($where)->orderBy('created_at','desc')->paginate($args['pSize']);
        $list = AdminerResource::collection($list);
        return ['code' => 0,'list' => $list,'total' => $list->total()];
    }

    public function roles($args){
        $where = [];
        if(isset($args['keyword']) && !empty($args['keyword'])){
            $res = $this->buildKeywordWhere($args['keyword'],['name','desc'],'roles');
            if($res) $where[] = $res;
        }
        if(isset($args['stime']) && !empty($args['stime'])){
            $where[] = ['created_at','>=',$args['stime']];
        }
        if(isset($args['etime']) && !empty($args['etime'])){
            $where[] = ['created_at','<',$args['etime']];
        }
        $list = Role::where($where)->orderBy('created_at','desc')->paginate($args['pSize']);
        $list = RoleResource::collection($list);
        return ['code' => 0,'list' => $list,'total' => $list->total()];
    }

    public function permissions($args){
        $where = [];
        if(isset($args['keyword']) && !empty($args['keyword'])){
            $res = $this->buildKeywordWhere($args['keyword'],['name','desc','router','icon'],'permissions');
            if($res) $where[] = $res;
        }
        if(isset($args['stime']) && !empty($args['stime'])){
            $where[] = ['created_at','>=',$args['stime']];
        }
        if(isset($args['etime']) && !empty($args['etime'])){
            $where[] = ['created_at','<',$args['etime']];
        }
        $list = Permission::where($where)->orderBy('created_at','desc')->paginate($args['pSize']);
        $list = PermissionResource::collection($list);
        return ['code' => 0,'list' => $list,'total' => $list->total()];
    }

    public function storeAdminer($args){
        DB::beginTransaction();
        try{
            $isUpdate = (isset($args['id']) && $args['id'] != 0 && is_numeric($args['id']))?true:false;
            if($isUpdate){
                $adminer = Adminer::find($args['id']);
            }else{
                $adminer = new Adminer();
                $adminer->password = bcrypt($args['password']);
            }
            $adminer->account = $args['account'];
            $adminer->nick_name = $args['nick_name'];
            $adminer->avatar = $args['avatar'] ?? '';
            $adminer->save();

            if($isUpdate){
                $oldRoles = AdminHasRole::where('adminer_id','=',$adminer->id);
                if($oldRoles->count()){
                    $oldRoles->delete();
                }
            }

            if(is_array($args['roles']) && count($args['roles']) != 0){
                foreach($args['roles'] as $v){
                    if(!is_numeric($v)){
                        throw new \Exception('roles数组里面必须是数字值');
                    }
                    $adminHasRole = new AdminHasRole();
                    $adminHasRole->adminer_id = $adminer->id;
                    $adminHasRole->role_id = $v;
                    $adminHasRole->save();
                }
            }else{
                throw new \Exception('roles必须是数组');
            }

            DB::commit();
            return ['code' => 0,'msg' => ''];
        }catch (\Exception $e){
            DB::rollback();
            if($e->getCode() == 23000){
                return ['code' => 1,'msg' => '角色ID数组中含有不存在的角色ID'];
            }else{
                return ['code' => 1,'msg' => $e->getMessage()];
            }
        }
    }

    public function permissionStore($args){
        $permission = new Permission();
        $permission->name = $args['name'];
        $permission->route = $args['route'];
        $permission->method = $args['method'];
        $permission->desc = $args['desc'] ?? '';
        $permission->icon = $args['icon'] ?? '';
        $permission->save();
        return ['code' => 0,'msg' => ''];
    }

    public function roleStore($args){
        DB::beginTransaction();
        try{
            $role = new Role();
            $role->name = $args['name'];
            $role->desc = $args['desc'] ?? '';
            $role->save();

            if(is_array($args['permissions']) && count($args['permissions']) != 0){
                foreach($args['permissions'] as $v){
                    if(!is_numeric($v)){
                        throw new \Exception('permissions数组里面必须是数字值');
                    }
                    $roleHasPermission = new RoleHasPermission();
                    $roleHasPermission->role_id = $role->id;
                    $roleHasPermission->permission_id = $v;
                    $roleHasPermission->save();
                }
            }else{
                throw new \Exception('permissions必须是数组');
            }

            DB::commit();
            return ['code' => 0,'msg' => ''];
        }catch (\Exception $e){
            DB::rollback();
            if($e->getCode() == 23000){
                return ['code' => 1,'msg' => '角色ID数组中含有不存在的角色ID'];
            }else{
                return ['code' => 1,'msg' => $e->getMessage()];
            }
        }
    }
}