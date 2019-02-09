<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class AdminerStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'account' => 'required',
            'password' => 'required',
            'nick_name' => 'required',
            'roles' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'account.required' => '账户名不能为空',
            'password.required' => '密码不能为空',
            'nick_name.required' => '昵称不能为空',
            'roles.required' => '角色不能为空',
            'roles.array' => '角色应为数组',
        ];
    }
}
