<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sewa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sewa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domain');
            $table->string('harga');
            $table->string('hargax')->nullable();
            $table->string('maxuser');
            $table->string('nope');
             $table->string('email');
            $table->string('tglmulai');
            $table->string('tglselesai');
            $table->longText('ket');
            $table->longText('key');
            $table->string('face');
            $table->string('tele');
            $table->string('lock');
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
        Schema::dropIfExists('sewa');
    }
}
