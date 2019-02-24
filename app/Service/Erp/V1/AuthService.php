<?php

namespace App\Service\Erp\V1;

use App\Models\OauthClient;
use App\Models\Role;
use HttpCurl;

class AuthService
{
    public function login($args)
    {
        $url = config('app.url');
        if (!$url) {
            $arr = [];
            $res = preg_match('/http:\/\/([^\/\/]+)/', url()->current(), $arr);
            if ($res) {
                $url = $arr[0];
            } else {
                return ['code' => 1, 'msg' => '系统错误:未找到登录URL！'];
            }
        }
        $url .= '/oauth/token';
        $args['grant_type'] = 'password';
        $args['scope'] = '';
        $args['provider'] = 'adminers';
        $oauthClient = OauthClient::where('password_client', '=', 1)->first();
        if ($oauthClient) {
            $args['client_id'] = $oauthClient->id;
            $args['client_secret'] = $oauthClient->secret;
        } else {
            return ['code' => 1, 'msg' => '系统错误:未找到PASSPORT客户端，请先生成PASSPORT客户端！'];
        }
        $res = HttpCurl::post($url, $args, [], 20);
        if ($res[0] != '') {
            $res[0] = json_decode($res[0], true);
        } else {
            return ['code' => 1, 'msg' => '系统错误:请求接口出错！'];
        }
        if ($res[1]['http_code'] == 200) {
            $res = $res[0];
            $res['code'] = 0;
            $res['msg'] = '登录成功';
            return $res;
        } else {
            $result['code'] = 1;
            $result['msg'] = '登录失败,用户名或密码错误';
            $result['err'] = $res[0]['error'];
            return $result;
        }
    }

    public function adminUser($user)
    {
        $id = $user->id;
        $roles = Role::whereIn('id', function ($query) use ($id) {
            $query->select(['role_id'])->from('admin_has_roles')->where('adminer_id', '=', $id);
        })->pluck('name')->toArray();
        return ['code' => 0, 'msg' => '', 'user' => $user, 'roles' => $roles];
    }
}