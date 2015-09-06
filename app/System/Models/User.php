<?php

namespace App\System\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword;

    protected $table = 'users';
    protected $fillable = ['name', "lastname", "role", 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

//Roles
    const ROLE_ADMIN = "AD";
    const ROLE_STANDAR = "ST";
    //AUTH
    const AUTH_EMAIL = "email";
    const AUTH_PASSWORD = "password";
    const AUTH_REMEMBER = "remember";

}
