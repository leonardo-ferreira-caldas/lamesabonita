<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoCulinariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_culinaria', function (Blueprint $table) {
            $table->unsignedInteger('fk_curso');
            $table->unsignedInteger('fk_culinaria');

            $table->primary(['fk_curso', 'fk_culinaria']);

            $table->foreign('fk_curso')->references('id_curso')->on('curso');
            $table->foreign('fk_culinaria')->references('id_culinaria')->on('culinaria');

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
        Schema::dropIfExists('curso_culinaria');
    }
}
