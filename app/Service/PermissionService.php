<?php
namespace App\Service;

use App\Http\Resources\AdminerResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use App\Models\Adminer;
use App\Models\AdminHasRole;
use App\Models\Permission;
use App\Models\Role;
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

    public function adminerStore($args){
        DB::beginTransaction();
        try{
            $adminer = new Adminer();
            $adminer->account = $args['account'];
            $adminer->password = bcrypt($args['password']);
            $adminer->nick_name = $args['nick_name'];
            $adminer->avatar = $args['avatar'] ?? '';
            $adminer->save();

            if(is_array($args['roles']) && count($args['roles']) != 0){
                foreach($args['roles'] as $v){
                    if(!is_numeric($v)){
                        throw new \Exception('role数组里面必须是数字值');
                    }
                    $adminHasRole = new AdminHasRole();
                    $adminHasRole->adminer_id = $adminer->id;
                    $adminHasRole->role_id = $v;
                    $adminHasRole->save();
                }
            }else{
                throw new \Exception('role必须是数组');
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