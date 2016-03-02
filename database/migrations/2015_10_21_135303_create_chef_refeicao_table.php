<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChefRefeicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_refeicao', function (Blueprint $table) {
            $table->unsignedInteger('fk_menu');
            $table->unsignedInteger('fk_tipo_refeicao');

            $table->primary(['fk_menu', 'fk_tipo_refeicao']);
            $table->foreign('fk_menu')->references('id_menu')->on('menu');
            $table->foreign('fk_tipo_refeicao')->references('id_tipo_refeicao')->on('tipo_refeicao');

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
        Schema::dropIfExists('menu_refeicao');
    }
}
