<?php

namespace App\Http\Requests\Erp\V1;

use Dingo\Api\Http\FormRequest;

class AdminerRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'account' => 'required|unique:adminers,account,' . $this->get('id'),
            'nick_name' => 'required',
            'roles' => 'required|array'
        ];
        if ($this->method() == 'PUT' || $this->method() == 'UPDATE') {
            $rules['id'] = 'required|integer|not_in:0';
        } else {
            $rules['password'] = 'required|max:18|min:6';
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'account.required' => '账户名不能为空',
            'account.unique' => '账户名已存在',
            'nick_name.required' => '昵称不能为空',
            'roles.required' => '角色不能为空',
            'roles.array' => '角色应为数组',
        ];
        if ($this->method() == 'PUT' || $this->method() == 'UPDATE') {
            $messages['id.required'] = 'ID不能为空';
            $messages['id.integer'] = 'ID必须是整型';
            $messages['id.not_in'] = 'ID不能为0';
        } else {
            $messages['password.required'] = '密码不能为空';
            $messages['password.max'] = '密码最长不能超过18位';
            $messages['password.min'] = '密码最短不能小于6位';
        }
        return $messages;
    }
}
