<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use App\System\Models\Chapter;
use Illuminate\Support\Facades\Auth;
use App\System\Models\User;
use Thujohn\Twitter\Facades\Twitter;
use Illuminate\Support\Facades\File;
use App\System\Library\Complements\Util;

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
    const ATTR_POSTER = "poster";
    const ATTR_CREATED_AT = "created_at";
    const ATTR_UPDATED_AT = "updated_at";
    //ESTADO
    const STATE_IN_WAIT = "IW"; //En espera
    const STATE_COMING_SOON = "CS"; //Proximo a estrenar
    const STATE_ACTIVE = "AC"; //Activo
    const STATE_IN_CINEMA = "IC"; // SOLO EN CINES
    const STATE_PROGRAMMED = "PR"; //PROGRAMADO
    //ESTADO - Distribuidores online de las producciones
    const STATE_DEALER_ACTIVE = "DA";
    const STATE_DEALER_INACTIVE = "DI";
    //TAXONOMY ID
    const TAXONOMY_ID = 1;

    /** Indica si la produccion tiene un video unico principal
     * 
     * @return type
     */
    public function haveVideoMain() {
        return (count($this->chapters()->where(Chapter::ATTR_TYPE, Chapter::TYPE_MAIN)->get()) > 0);
    }

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

    public function chapters() {
        return $this->hasMany('App\System\Models\Chapter', 'production_id');
    }

    public function comments() {
        return $this->hasMany('App\System\Models\Comment', 'production_id');
    }

    public function staff() {
        return $this->belongsToMany('App\System\Models\Person', "staff")->withPivot('role');
    }

    public function terms() {
        return $this->belongsToMany('App\System\Models\Term', "productions_terms");
    }

    public function ratings() {
        return $this->hasMany('App\System\Models\Production\ProductionRating', 'production_id');
    }

    public function playbacks() {
        return $this->belongsToMany("App\System\Models\User", "playbacks", "production_id", "user_id")
                        ->withPivot(User::ATTR_PLAYBACKS_PIVOT_DATE)
                        ->withPivot(User::ATTR_PLAYBACKS_PIVOT_IP)
                        ->withPivot(User::ATTR_PLAYBACKS_PIVOT_TOKEN)
                        ->withPivot(User::ATTR_PLAYBACKS_PIVOT_VALIDATE)
                        ->withPivot(User::ATTR_PLAYBACKS_PIVOT_PARENT);
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
            case Production::STATE_PROGRAMMED:
                return "warning";
        }
    }

    //MUTATORS
    public function setSlugAttribute($value) {
        if (isset($this->attributes[Production::ATTR_SLUG]))
            if ($this->attributes[Production::ATTR_SLUG] != $value)
            //Realizar un registro del antiguo slug
                Log\Slug::add($this->attributes[Production::ATTR_ID], $this->attributes[Production::ATTR_SLUG]);

        $this->attributes[Production::ATTR_SLUG] = $value;
    }

    public function setStateAttribute($value) {

        if (isset($this->attributes[Production::ATTR_STATE])) {
            //Publicacion en redes sociales
            if ($this->attributes[Production::ATTR_STATE] == Production::STATE_PROGRAMMED && $value == Production::STATE_ACTIVE) {
                //PUBLICA EN LA PAGINA DE FACEBOOK LA NUEVA PRODUCCION AGREGADA
                $page_id = "974813252592135";
                $post_url = 'https://graph.facebook.com/' . $page_id . '/feed';
                $page_access_token = 'CAAMlvU2gRHsBAPt2mZBymHkjZChELemLYpyRjMDp6VqjscjB3VwUbGfQsdyuFfNqpFaXZCnvL6ngWorbg6q2V6FP4rrcIUB5dgisdVSr4STFTzecD2zRoOCYFZCei1D6zxNEm0zHZCXr7DFtbMPTIVSioR1sitpGqcV1aTFgZBadL1CVlmbeMk';
                $data['access_token'] = $page_access_token;
                $data['link'] = url("production/" . $this->attributes[Production::ATTR_SLUG]);
                $data['message'] = "¡Hemos agregado recientemente \"" . $this->attributes[Production::ATTR_TITLE] . "\", desde ya puedes disfrutarla online y gratis!";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $post_url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_exec($ch);
                curl_close($ch);
                //PUBLIC EN TWITTER
                $url = $this->attributes[Production::ATTR_IMAGE];
                $path = public_path("assets/db/images/" . Util::fileExtractName($url) . "." . Util::fileExtractExtension($url));
                $uploaded_media = Twitter::uploadMedia(['media' => File::get($path)]);
                @Twitter::postTweet(['status' => "Hemos agregado \"".$this->attributes[Production::ATTR_TITLE]."\" ¡Disfrutalo desde ya!", 'media_ids' => $uploaded_media->media_id_string]);
            }
        }

        $this->attributes[Production::ATTR_STATE] = $value;
    }

    /**  Indica si la produccion esta en favoritos
     * 
     * @param type $production_id
     * @return type
     */
    static function inFavorites($production_id) {
        return (Auth::user()->favorites()->where("production_id", $production_id)->count() > 0);
    }

    /** Indica si una produccion esta siendo seguida por un usuario
     * 
     * @param type $production_id
     * @return type
     */
    static function isTracking($production_id) {
        return (Auth::user()->tracks()->where("production_id", $production_id)->count() > 0);
    }

    /** Obtiene un html en un formato standar para mostrar la produccion
     * 
     * @param type $production (Production) El objeto de production
     * @return type
     */
    static function getVisualHtml(Production $production) {
        $html = "<div class='production'>" .
                "<a onClick='modalProduction(\"".$production->id."\");'>" .
                "<span class='hidden' id='url-".$production->id."'>".url("production/" . $production->slug)."</span><img id='img-production-".$production->id."' title='".$production->title."' class='img-rounded";
        $html.=($production->state != Production::STATE_ACTIVE) ? " production-not-available" : "";
        $html.="' src='" . $production->image . "'><div class='over'><span class='glyphicon glyphicon-play-circle'></span>" . $production->title . "</div>" .
                "</a>" .
                "</div>";

        return $html;
    }

    static function search($query, $take = 50) {
        return Production::where(self::ATTR_TITLE, "LIKE", "%" . $query . "%")->orWhere(self::ATTR_TITLE_ORIGINAL, "LIKE", "%" . $query . "%")->orderBy(self::ATTR_STATE, "DESC")->take($take)->get();
    }

    /** Ordene una coleccion de produccion por el estado, posicionando los que estan activos en primer lugar
     * 
     * @param type $productions
     * @return array
     */
    static function sortByState($productions) {
        $actives = array();
        $others = array();
        foreach ($productions as $production) {
            if ($production->state == Production::STATE_ACTIVE)
                $actives[] = $production;
            else
                $others[] = $production;
        }

        $productions = array();

        foreach ($actives as $production) {
            $productions[] = $production;
        }

        foreach ($others as $production) {
            $productions[] = $production;
        }

        return $productions;
    }

}
