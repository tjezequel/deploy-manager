<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 30/01/2018
 * Time: 21:04
 */

namespace App\Model;

use App\Uuid;
use Illuminate\Database\Eloquent\Model;

class Environments extends Model {

    use Uuid;

    protected $table = 'environments';

    public $incrementing = false;

    protected $fillable = ['name', 'app_id'];

    public function application() {
        return $this->belongsTo('App\Model\Application', 'app_id');
    }

    public function deploys() {
        return $this->hasMany('App\Model\Deploy', 'environment_id');
    }

}