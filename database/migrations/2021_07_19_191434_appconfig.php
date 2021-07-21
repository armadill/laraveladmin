<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appconfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appconfig', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client');
            $table->string('status');
            $table->string('urlsplash');
            $table->string('durasisplash');
            $table->string('urlbase');
            $table->string('maintain');
            $table->string('info')->nullable();
            $table->string('warna')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appconfig');
    }
}
