<?php
/**
 * Created by PhpStorm.
 * User: thomasjezequel
 * Date: 16/12/2017
 * Time: 17:48
 */

namespace App;


trait Uuid
{

    protected static function boot() {
        parent::boot();

        static::creating(function($model) {
            $model->{$model->getKeyName()} = \Ramsey\Uuid\Uuid::uuid4();
        });
    }

}