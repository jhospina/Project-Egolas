<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    const ATTR_ID = "id";
    const ATTR_USER_ID = "user_id";
    const ATTR_PRODUCTION_ID = "production_id";
    const ATTR_PARENT = "parent";
    const ATTR_CONTENT = "content";
    const ATTR_CREATED_AT = "created_at";
    const ATTR_UPDATED_AT = "updated_at";

    public function setContentAttribute($value) {
        if (strlen($value) > 1500)
            $value = substr($value, 0, 1500);
        $this->attributes[Comment::ATTR_CONTENT] = str_replace("\n", "</br>", preg_replace("#[\n\r]{2,}#", "\n", $value));
    }

}
