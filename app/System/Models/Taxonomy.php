<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use App\System\Models\Term;

class Taxonomy extends Model {

    protected $table = "taxonomies";
    public $timestamps = false;

    const ATTR_ID = "id";
    const ATTR_NAME = "name";
    const ATTR_COUNT = "count";

    /** Obtiene todos los terminos de una taxonomida dada por el id de la taxonomia
     * 
     * @param type $taxonomy_id
     * @return type
     */
    public static function getAllTerms($taxonomy_id) {
        return (is_numeric($taxonomy_id)) ? Term::where(Term::ATTR_TAXONOMY_ID, $taxonomy_id)->get() : null;
    }

}
