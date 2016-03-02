<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuCulinariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_culinaria', function (Blueprint $table) {
            $table->unsignedInteger('fk_menu');
            $table->unsignedInteger('fk_culinaria');

            $table->primary(['fk_menu', 'fk_culinaria']);

            $table->foreign('fk_menu')->references('id_menu')->on('menu');
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
        Schema::dropIfExists('menu_culinaria');
    }
}
