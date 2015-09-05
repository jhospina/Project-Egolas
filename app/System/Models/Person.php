<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

    protected $table = "persons";

    const ATTR_ID = "id";
    const ATTR_NAME = "name";
    const ATTR_SLUG = "slug";
    const ATTR_BIOGRAPHY = "biography";
    const ATTR_IMAGE = "image";
    const ATTR_PIVOT_ROLE="role";
    //Roles de personas
    const ROLE_DIRECTOR = "DI";
    const ROLE_ACTOR = "AC";

    /** Busca una persona por su nombre, de lo contrario retorna Null
     * 
     * @param type $name
     * @return type
     */
    static function searchByName($name) {
        $persons = Person::where(Person::ATTR_NAME, $name)->get();
        if (!count($persons) > 0)
            return null;
        foreach ($persons as $person)
            return $person;
    }

    public function productions() {
        return $this->belongsToMany('App\System\Models\Production', "staff")->withPivot('role');
    }

}
