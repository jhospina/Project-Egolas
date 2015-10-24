<?php

use \App\System\Models\Production;
use App\System\Models\Chapter;
use App\System\Library\Enum\Language;
use App\System\Models\Production\ProductionRating;

return [
    "production." . Production::ATTR_STATE . "." . Production::STATE_ACTIVE => "Activo",
    "production." . Production::ATTR_STATE . "." . Production::STATE_IN_WAIT => "En espera",
    "production." . Production::ATTR_STATE . "." . Production::STATE_COMING_SOON => "Proximamente",
    "production." . Production::ATTR_STATE . "." . Production::STATE_IN_CINEMA => "Solo en cines",
    "chapter." . Chapter::ATTR_TYPE . "." . Chapter::TYPE_MAIN => "Principal",
    "chapter." . Chapter::ATTR_TYPE . "." . Chapter::TYPE_EPISODE => "Capitulo",
    "chapter." . Chapter::ATTR_STATE . "." . Chapter::STATE_AVAILABLE => "Disponible",
    "chapter." . Chapter::ATTR_STATE . "." . Chapter::STATE_OFFLINE => "Fuera de linea",
    "chapter." . Chapter::ATTR_QUALITY . "." . Chapter::QUALITY_FULL_HD => "Alta definición (FULL HD)",
    "chapter." . Chapter::ATTR_QUALITY . "." . Chapter::QUALITY_HD => "Alta definición (HD)",
    "chapter." . Chapter::ATTR_QUALITY . "." . Chapter::QUALITY_DVD => "DVD",
    "chapter." . Chapter::ATTR_SUBTITLES . "." . Chapter::SUBTITLE_ENGLISH => "Ingles",
    "chapter." . Chapter::ATTR_SUBTITLES . "." . Chapter::SUBTITLE_SPANISH => "Español",
    "chapter." . Chapter::ATTR_SUBTITLES . "." . Chapter::SUBTITLE_PORTUGUES => "Portugues",
    "language." . Language::EN_US => "Ingles",
    "language." . Language::ES_ES => "Español España",
    "language." . Language::ES_LT => "Español Latino",
    "language." . Language::PR_BR => "Portugues",
    "production.rating." . ProductionRating::RATING_1 => "No me gusto nada",
    "production.rating." . ProductionRating::RATING_2 => "Fue decepcionante",
    "production.rating." . ProductionRating::RATING_3 => "Me parecio regular",
    "production.rating." . ProductionRating::RATING_4 => "Me gusto",
    "production.rating." . ProductionRating::RATING_5 => "Me encanto totalmente",
    "production.rating." . ProductionRating::RATING_1 . ".public" => "No gustó",
    "production.rating." . ProductionRating::RATING_2 . ".public" => "Fue decepcionante",
    "production.rating." . ProductionRating::RATING_3 . ".public" => "Fue regular",
    "production.rating." . ProductionRating::RATING_4 . ".public" => "Gustó",
    "production.rating." . ProductionRating::RATING_5 . ".public" => "Encantó",
];
