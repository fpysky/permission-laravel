<?php
namespace App\Http\Requests\Erp\V1;

use Dingo\Api\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name,' . $this->get('id'),
            'permissions' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '角色不能为空',
            'name.unique' => '角色已存在',
            'permissions.required' => '角色权限不能为空',
            'permissions.array' => '角色权限必须是数组',
        ];
    }
}
