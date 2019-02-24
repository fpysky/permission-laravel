<?php

namespace App\Http\Requests\Erp\V1;

use Dingo\Api\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:permissions,name,' . $this->get('id'),
            'route' => 'required|unique:permissions,route,' . $this->get('id'),
            'method' => 'required',
        ];
        if ($this->method() == 'PUT' || $this->method() == 'UPDATE') {
            $rules['id'] = 'required|integer|not_in:0';
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.required' => '权限名不能为空',
            'name.unique' => '权限名已存在',
            'route.required' => '路由不能为空',
            'route.unique' => '路由已存在',
            'method.required' => '请求方法不能为空'
        ];
        if ($this->method() == 'PUT' || $this->method() == 'UPDATE') {
            $rules['id.required'] = 'ID不能为空';
        }
        return $messages;
    }
}
