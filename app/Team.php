<?php

namespace App;

use Laratrust\Models\LaratrustTeam;

class Team extends LaratrustTeam
{
    function apps() {
        return $this->hasMany('App\Model\Application');
    }
}
