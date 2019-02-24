<?php
namespace App\Http\Requests\Erp\V1;

use Dingo\Api\Http\FormRequest;

class PermissionIndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            'page' => 'numeric',
            'pSize' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'page.numeric' => '页码必须是数字',
            'pSize.numeric' => '每页显示条数必须是数字',
        ];
    }
}
