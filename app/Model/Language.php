<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 16/12/2017
 * Time: 22:59
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Uuid;


class Language extends Model {

    use Uuid;

    protected $table = 'language';

    public $incrementing = false;

    protected $fillable = ['name', 'version', 'logo_url'];

}