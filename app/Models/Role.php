<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public static function getAdminRoles($id){
        $adminer = Adminer::where('id','=',$id)->first();
        $adminRoles = $adminer->adminHasRole;
        $list = [];
        foreach($adminRoles as $k => $v){
            $list[] = $v['role_id'];
        }
        return ['code' => 0,'list' => $list];
    }
}
