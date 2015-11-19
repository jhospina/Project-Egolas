<?php

use \App\System\Models\Production;
use App\System\Models\Chapter;
use App\System\Library\Enum\Language;
use App\System\Models\Production\ProductionRating;
use App\System\Models\User;
use App\System\Models\Report;

return [
    "user.role." . User::ROLE_SUSCRIPTOR => "Gratis",
    "user.role." . User::ROLE_SUSCRIPTOR_PREMIUM => "Premium",
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
    "report.type." . Report::TYPE_GENERAL => "General",
    "report.type." . Report::TYPE_SEARCHER => "Buscador",
    "report.type." . Report::TYPE_PLAYER => "Reproductor de video",
    "report.type." . Report::TYPE_COMMENTS => "Comentarios",
    "report.type." . Report::TYPE_RATINGS => "Puntuaciones de satifacción",
    "report.type." . Report::TYPE_PRODUCTIONS => "Producciones",
    "report.type." . Report::TYPE_STAFF => "Directores, Actores y Actrices",
    "report.type." . Report::TYPE_ACCOUNT => "Cuenta de usuario",
    "report.type." . Report::TYPE_USER_INTERFACE => "Interfaz",
    "report.type." . Report::TYPE_FAVORITES => "Favoritos",
    "report.type." . Report::TYPE_PAY_SISTEM => "Sistema de pagos",
    "report.type." . Report::TYPE_OTHER => "Otros"
];
