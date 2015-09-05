<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model {
    protected $table="taxonomies";
    public $timestamps = false;
    
    const ATTR_ID="id";
    const ATTR_NAME="name";
    const ATTR_COUNT="count";
    
    
}
