<?php
namespace App\Http\controllers\Admin\V1;
use App\Http\Controllers\Controller;
use App\Service\AuthService;
use App\Http\Requests\AuthLoginReuqest;

class AuthController extends Controller{
    protected $authService;
    function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function login(AuthLoginReuqest $reuqest){
        return $this->authService->login($reuqest->all());
    }
}