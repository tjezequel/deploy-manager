<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 17/12/2017
 * Time: 00:26
 */

namespace App\Model;
use App\Uuid;
use Illuminate\Database\Eloquent\Model;

class Framework extends Model
{

    use Uuid;

    protected $table = 'framework';

    protected $fillable = ['name', 'version', 'logo_url'];

    public $incrementing = false;

}