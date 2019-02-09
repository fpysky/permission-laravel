<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \API::error(function (\Illuminate\Validation\ValidationException $exception){
            $data =$exception->validator->getMessageBag();
            $msg = collect($data)->first();
            if(is_array($msg)){
                $msg = $msg[0];
            }
            return response()->json(['msg'=>$msg,'code' => -1], 200);
        });
        \API::error(function (\Dingo\Api\Exception\ValidationHttpException $exception){
            $errors = $exception->getErrors();
            return response()->json(['msg'=>$errors->first(),'code' => 422,'err' => $errors], 200);
        });
    }
}
