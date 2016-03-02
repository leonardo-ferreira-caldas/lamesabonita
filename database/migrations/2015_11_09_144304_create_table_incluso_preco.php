<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInclusoPreco extends Migration
{
    public function up()
    {
        Schema::create('incluso_preco_tipo', function (Blueprint $table) {
            $table->increments('id_incluso_preco_tipo');
            $table->text('descricao');
            $table->timestamps();
        });

        Schema::create('incluso_preco', function (Blueprint $table) {
            $table->increments('id_incluso_preco');
            $table->text('descricao');
            $table->unsignedInteger('fk_tipo');

            $table->foreign('fk_tipo')->references('id_incluso_preco_tipo')->on('incluso_preco_tipo');
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
        Schema::dropIfExists('incluso_preco');
        Schema::dropIfExists('incluso_preco_tipo');
    }
}
