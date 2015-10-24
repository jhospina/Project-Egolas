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

    const PATH_UPLOADS = "res/users/uploads/";
    const PATH_TEMPORAL = "res/users/temporal/";
    const ATTR_ID = "id";
    const ATTR_NAME = "name";
    const ATTR_LASTNAME = "lastname";
    const ATTR_STATE = "state";
    const ATTR_AVATAR = "avatar";
    const ATTR_BIRTH = "birth";
    const ATTR_CITY = "city";
    const ATTR_COUNTRY = "country";
    const ATTR_KEY_ACTIVATION = "keyActivation";
    const ATTR_ROLE = "role";
    const ATTR_EMAIL = "email";
    const ATTR_PASSWORD = "password";
    const ATTR_PREMIUM_TO = "premium_to"; //Indica hasta cuando estara sera un suscriptor premium
    //Estados
    const STATE_UNCONFIRMED_ACCOUNT = "UA"; //Cuenta sin confirmar
    const STATE_ACTIVED_ACCOUNT = "AA"; //Cuenta activada
//Roles
    const ROLE_ADMIN = "AD";
    const ROLE_SUSCRIPTOR = "SU";
    const ROLE_SUSCRIPTOR_PREMIUM = "SP";
    //AUTH
    const AUTH_EMAIL = "email";
    const AUTH_PASSWORD = "password";
    const AUTH_REMEMBER = "remember";
    //FAVORITES
    const ATTR_FAVORITES_PIVOT_DATE = "date";

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

    /** Indica si un correo electronico esta asociado a un usuario
     * 
     * @param type $email
     * @return type
     */
    static public function existEmail($email) {
        return (User::where(User::ATTR_EMAIL, $email)->count() > 0);
    }

    function getPathUploads() {
        return User::PATH_UPLOADS . $this->id . "/";
    }

    function getPathTemporal() {
        return User::PATH_TEMPORAL . $this->id . "/";
    }

    public function contributions() {
        return $this->hasMany('App\System\Models\Payment', 'user_id');
    }

    public function favorites() {
        return $this->belongsToMany("App\System\Models\Production", "production_favorites", "user_id", "production_id")->withPivot(User::ATTR_FAVORITES_PIVOT_DATE);
    }

}
