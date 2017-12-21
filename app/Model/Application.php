<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 17/12/2017
 * Time: 13:23
 */

namespace App\Model;


use App\Uuid;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    use Uuid;

    protected $table = "apps";

    public $incrementing = false;

    protected $fillable = ['name', 'description', 'logo_url', 'language_id', 'framework_id', 'team_id'];

    function framework() {
        return $this->hasOne('App\Model\Framework');
    }

    function language() {
        return $this->hasOne('App\Model\Language');
    }

}