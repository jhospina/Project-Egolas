<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model {

    
    const ATTR_ID = "id";
    const ATTR_TAXONOMY_ID = "taxonomy_id";
    const ATTR_NAME = "name";
    const ATTR_SLUG = "slug";
    const ATTR_CREATED_AT = "created_at";
    const ATTR_UPDATED_AT = "update_at";
    
    
      /** Busca un termino por su nombre, de lo contrario retorna Null
     * 
     * @param type $name
     * @return type
     */
    static function searchByName($name) {
        $terms = Term::where(Term::ATTR_NAME, ucfirst(strtolower($name)))->get();
        if (!count($terms) > 0)
            return null;
        foreach ($terms as $term)
            return $term;
    }
    
    public function productions() {
        return $this->belongsToMany('App\System\Models\Production', "productions_terms");
    }

}
