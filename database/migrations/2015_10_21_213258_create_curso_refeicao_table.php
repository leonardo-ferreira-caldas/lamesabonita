<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoRefeicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_refeicao', function (Blueprint $table) {
            $table->unsignedInteger('fk_curso');
            $table->unsignedInteger('fk_tipo_refeicao');

            $table->primary(['fk_curso', 'fk_tipo_refeicao']);
            $table->foreign('fk_curso')->references('id_curso')->on('curso');
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
        Schema::dropIfExists('curso_refeicao');
    }
}
