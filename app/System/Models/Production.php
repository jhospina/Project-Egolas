<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model {

    protected $fillable = ['title', "title_original", "slug", 'description', 'state', 'year', 'rating_rel', "duration"];

    const ATTR_ID = "id";
    const ATTR_TITLE = "title";
    const ATTR_TITLE_ORIGINAL = "title_original";
    const ATTR_SLUG = "slug";
    const ATTR_DESCRIPTION = "description";
    const ATTR_STATE = "state";
    const ATTR_YEAR = "year";
    const ATTR_RATING_REL = "rating_rel";
    const ATTR_DURATION = "duration";
    const ATTR_IMAGE = "image";
    const ATTR_CREATED_AT = "created_at";
    const ATTR_UPDATED_AT = "updated_at";
    //ESTADO
    const STATE_IN_WAIT = "IW"; //En espera
    const STATE_COMING_SOON = "CS"; //Proximo a estrenar
    const STATE_ACTIVE = "AC"; //Activo
    const STATE_IN_CINEMA = "IC"; // SOLO EN CINES
    //ESTADO - Distribuidores online de las producciones
    const STATE_DEALER_ACTIVE = "DA";
    const STATE_DEALER_INACTIVE = "DI";
    //TAXONOMY ID
    const TAXONOMY_ID = 1;

    /** Busca una produccion por su titulo original, de lo contrario retorna Null
     * 
     * @param type $title Titulo de la produccion a buscar
     * @return type
     */
    static function searchByTitle($title) {
        $productions = Production::where(Production::ATTR_TITLE, $title)->get();
        if (!count($productions) > 0)
            return null;
        foreach ($productions as $production)
            return $production;
    }

    public function dealers() {
        return $this->belongsToMany('App\System\Models\Dealer', "productions_dealers")
                        ->withPivot(Dealer::PIVOT_PRODUCTION_ATTR_URL)
                        ->withPivot(Dealer::PIVOT_PRODUCTION_ATTR_CONTENT)
                        ->withPivot(Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES)
                        ->withPivot(Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES)
                        ->withPivot(Dealer::PIVOT_PRODUCTION_ATTR_QUALITY)
                        ->withPivot(Dealer::PIVOT_PRODUCTION_ATTR_STATE)

        ;
    }

    public function staff() {
        return $this->belongsToMany('App\System\Models\Person', "staff")->withPivot('role');
    }

    public function terms() {
        return $this->belongsToMany('App\System\Models\Term', "productions_terms");
    }

    /** Obtiene el estilo de color representativo del estado de una produccion
     * 
     * @param type $state
     * @return string
     */
    public static function getStyleColorState($state) {
        switch ($state) {
            case Production::STATE_ACTIVE:
                return "success";
            case Production::STATE_IN_WAIT:
                return "default";
            case Production::STATE_COMING_SOON:
                return "warning";
            case Production::STATE_IN_CINEMA:
                return "danger";
        }
    }

}