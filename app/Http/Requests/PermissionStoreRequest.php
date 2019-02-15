<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:permissions,name,' . $this->get('id'),
            'route' => 'required|unique:permissions,route,' . $this->get('id'),
            'method' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '权限名不能为空',
            'name.unique' => '权限名已存在',
            'route.required' => '路由不能为空',
            'route.unique' => '路由已存在',
            'method.required' => '请求方法不能为空'
        ];
    }
}
