<?php
namespace App\Service;

use App\Http\Resources\AdminerResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use App\Models\Adminer;
use App\Models\Permission;
use App\Models\Role;

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
        return ['aa' =>'aa'];//request()->all();
    }
}