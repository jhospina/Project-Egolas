<?php

use \App\System\Models\Production;
use App\System\Models\Dealer;
use App\System\Library\Enum\Language;

return [
    "production." . Production::ATTR_STATE . "." . Production::STATE_ACTIVE => "Activo",
    "production." . Production::ATTR_STATE . "." . Production::STATE_IN_WAIT => "En espera",
    "production." . Production::ATTR_STATE . "." . Production::STATE_COMING_SOON => "Proximamente",
    "production." . Production::ATTR_STATE . "." . Production::STATE_IN_CINEMA => "Solo en cines",
    "dealer." . Dealer::ATTR_TYPE . "." . Dealer::TYPE_DOWNLOAD => "Descargar",
    "dealer." . Dealer::ATTR_TYPE . "." . Dealer::TYPE_WATCH_ONLINE => "Ver online",
    "dealer." . Dealer::ATTR_TYPE . "." . Dealer::TYPE_DOWNLOAD.".icon" => "glyphicon glyphicon-download-alt",
    "dealer." . Dealer::ATTR_TYPE . "." . Dealer::TYPE_WATCH_ONLINE.".icon" => "glyphicon glyphicon-play-circle",
    "dealer." . Dealer::ATTR_MODEL . "." . Dealer::MODEL_FREE => "Gratis",
    "dealer." . Dealer::ATTR_MODEL . "." . Dealer::MODEL_PREMIUM => "Premium",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_STATE.".".Dealer::PIVOT_PRODUCTION_STATE_AVAILABLE=>"Disponible",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_STATE.".".Dealer::PIVOT_PRODUCTION_STATE_OFFLINE=>"Fuera de linea",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_QUALITY.".".Dealer::PIVOT_PRODUCTION_QUALITY_FULL_HD=>"Alta definición (FULL HD)",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_QUALITY.".".Dealer::PIVOT_PRODUCTION_QUALITY_HD=>"Alta definición (HD)",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_QUALITY.".".Dealer::PIVOT_PRODUCTION_QUALITY_DVD=>"DVD",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_QUALITY.".".Dealer::PIVOT_PRODUCTION_QUALITY_CAM=>"CAM (Grabado en cine)",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES.".".Dealer::PIVOT_PRODUCTION_SUBTITLE_ENGLISH=>"Ingles",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES.".".Dealer::PIVOT_PRODUCTION_SUBTITLE_SPANISH=>"Español",
    "pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES.".".Dealer::PIVOT_PRODUCTION_SUBTITLE_PORTUGUES=>"Portugues",
    
    "language.".Language::EN_US=>"Ingles",
    "language.".Language::ES_ES=>"Español España",
    "language.".Language::ES_LT=>"Español Latino",
    "language.".Language::PR_BR=>"Portugues",
    
];
