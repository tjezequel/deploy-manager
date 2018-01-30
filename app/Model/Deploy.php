<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 30/01/2018
 * Time: 21:40
 */

namespace App\Model;

use App\Uuid;
use Illuminate\Database\Eloquent\Model;

class Deploy extends Model {

    use Uuid;

    protected $table = 'deploys';

    public $incrementing = false;

    protected $fillable = ['name', 'environment_id'];

    public function environment() {
        $this->belongsTo('App\Model\Environment');
    }

}