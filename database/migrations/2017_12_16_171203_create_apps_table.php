<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->timestamps();
            $table->string('name');
            $table->text('description');
            $table->string('logo_url');
            $table->string('language_id');
            $table->string('framework_id');

            $table->foreign('language_id')->references('id')->on('language');
            $table->foreign('framework_id')->references('id')->on('framework');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
}
