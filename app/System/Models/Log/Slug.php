<?php

namespace App\System\Models\Log;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model {

    protected $table = 'log_slugs';
    public $timestamps = false;

    /** Agrega un nuevo registro
     * 
     * @param type $production_id
     * @param type $content
     */
    static function add($production_id, $content) {
        $slug = new Slug;
        $slug->production_id = $production_id;
        $slug->content = $content;
        $slug->save();
    }

    static function getIdProduction($slug) {
        $slugs = Slug::where("content", $slug)->get();
        return (count($slugs) > 0) ? $slugs[0]->production_id : null;
    }

}
