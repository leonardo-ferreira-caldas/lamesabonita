<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCursoInclusoPreco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curso_incluso_preco');
    }
}
