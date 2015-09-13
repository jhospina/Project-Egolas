<?php

namespace App\System\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    static public function editPassword($current, $new) {

        $user = User::find(Auth::user()->id);

        //Obtiene la contraseña actual del usuario almacenada en la base de datos
        $currentPassDB = $user->password;

        //Verifica si la contraseña actual ingresada por el usuario es la misma que el la almacenada en la base de datos
        if (Hash::check($current, $currentPassDB)) {
            $user->password = bcrypt($new);
            return $user->save();
        } else {
            return false;
        }
    }

}
