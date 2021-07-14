<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tokencekout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokencekout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('orderid');
            $table->string('sewa_id');
            $table->string('tanggal');
            $table->string('jumlah');
            $table->string('status');
            $table->string('jenispay')->nullable();
            $table->string('token')->nullable();
            $table->string('statuscron')->nullable();
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
        Schema::dropIfExists('tokencekout');
    }
}
