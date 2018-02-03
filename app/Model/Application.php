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

    public function framework() {
        return $this->belongsTo('App\Model\Framework');
    }

    public function language() {
        return $this->belongsTo('App\Model\Language');
    }

    public function team() {
        return $this->belongsTo('App\Team');
    }

    public function environments() {
        return $this->hasMany('App\Model\Environment', 'app_id');
    }

}