<?php

namespace App\Http\controllers\Erp\V1;

use App\Http\Controllers\Controller;
use App\Services\Erp\V1\AuthService;
use App\Http\Requests\Erp\V1\AuthLoginReuqest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthLoginReuqest $reuqest)
    {
        return $this->authService->login($reuqest->all());
    }

    public function user(Request $request)
    {
        return $this->authService->adminUser($request->user('admin'));
    }
}