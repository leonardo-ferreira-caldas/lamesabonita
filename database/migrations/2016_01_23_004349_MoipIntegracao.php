<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoipIntegracao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moip_integracao_logger', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->string('tipo', 40);
            $table->text('log');
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
        Schema::dropIfExists('moip_integracao_logger');
    }
}
