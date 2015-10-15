<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class PasswordReset extends Model {
    protected $table="password_resets";
     public $timestamps = false;
    const ATTR_ID="id";
    const ATTR_USER_ID="user_id";
    const ATTR_EMAIL="email";
    const ATTR_TOKEN="token";
    const ATTR_ACTIVE="active";
    const ATTR_CREATED_AT="created_at";
    
    
}