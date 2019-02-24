<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Adminer extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findForPassport($username)
    {
        return $this->where('account', $username)->first();
    }

    public function adminHasRole()
    {
        return $this->hasMany('App\Models\AdminHasRole', 'adminer_id', 'id');
    }
}
