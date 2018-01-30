<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->integer('status');
            $table->dateTime('begin_time');
            $table->dateTime('end_time');
            $table->string('deploy_id');
            $table->string('step_id');
            $table->timestamps();

            $table->foreign('deploy_id')->references('id')->on('deploys');
            $table->foreign('step_id')->references('id')->on('steps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
