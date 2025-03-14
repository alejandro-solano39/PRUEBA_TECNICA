<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('llantas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('fabricante');
            $table->integer('ancho');
            $table->integer('diametro_rin');
            $table->integer('presion_max');
            $table->integer('satisfaccion')->nullable();
            $table->integer('stock');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('llantas');
    }
};
