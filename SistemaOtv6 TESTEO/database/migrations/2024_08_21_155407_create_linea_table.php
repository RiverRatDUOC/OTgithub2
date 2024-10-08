<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_linea', 100);
            $table->unsignedBigInteger('cod_subcategoria');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cod_subcategoria')->references('id')->on('subcategoria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea');
    }
}
