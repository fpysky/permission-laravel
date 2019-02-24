<?php

namespace App\Http\Requests\Erp\V1;

use Dingo\Api\Http\FormRequest;

class AuthLoginReuqest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
        ];
    }
}
