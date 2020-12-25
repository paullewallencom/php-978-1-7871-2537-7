<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecretsTable extends Migration
{
    public function up()
    {
        Schema::create('secrets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->double('latitude');
            $table->double('longitude')->nullable();
            $table->string('location_name', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('secrets');
    }
}
