<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCloudAccount extends Model {

    protected $table = "videocloud_accounts";
    public $timestamps = false;

    const ATTR_EMAIL = "email";
    const ATTR_TOKEN = "token";
    const ATTR_DATE = "date";
    const ATTR_END = "end";

    /** Obtiene el id de la cuenta vigente 
     * 
     * @return type
     */
    static function getCurrentAccountId() {
        return VideoCloudAccount::orderBy("id", "DESC")->take(1)->get()[0]->id;
    }

    /** Obtiene el Email de la cuenta vigente 
     * 
     * @return type
     */
    static function getCurrentAccountEmail() {
        return VideoCloudAccount::orderBy("id", "DESC")->take(1)->get()[0]->email;
    }

    /** Obtiene el email de la cuenta dado por su id
     * 
     * @param type $id
     * @return type
     */
    static function getAccountEmailById($id) {
        return VideoCloudAccount::where("id", $id)->orderBy("id", "DESC")->take(1)->get()[0]->email;
    }

}
