<?php
namespace App\Service\Erp\V1;

use Illuminate\Support\Facades\DB;

class BaseService{
    public function buildKeywordWhere($keyword,$field,$table){
        if(empty($keyword)) return false;
        if(is_string($field)) $field = [$field];
        $wheres = [];
        foreach($field as $k => $v){
            $wheres[][] = [$v,'like','%' . $keyword . '%'];
        }
        $i = 0;
        while(isset($wheres[$i])){
            $res = DB::table($table)->where($wheres[$i])->count();
            if($res){
                return $wheres[$i][0];
            }else{
                $i++;
            }
        }
        return $wheres[0][0];
    }
}