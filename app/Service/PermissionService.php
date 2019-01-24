<?php
namespace App\Service;

use App\Http\Resources\AdminerResource;
use App\Models\Adminer;

class PermissionService extends BaseService {
    public function adminers($args){
        $where = [];
        if(isset($args['keyword']) && !empty($args['keyword'])){
            $res = $this->buildKeywordWhere($args['keyword'],['account','nick_name'],'adminers');
            if($res) $where[] = $res;
        }
        $list = Adminer::where($where)->orderBy('created_at','desc')->paginate($args['pSize']);
        $total = $list->total();
        $list = AdminerResource::collection($list);
        return ['code' => 0,'list' => $list,'total' => $total];
    }
}