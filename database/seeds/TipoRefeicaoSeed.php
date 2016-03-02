<?php

use Illuminate\Database\Seeder;

class TipoRefeicaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_refeicao')->insert([
            ["nome_tipo_refeicao" => "Café da manhã"],
            ["nome_tipo_refeicao" => "Brunch"],
            ["nome_tipo_refeicao" => "Almoço"],
            ["nome_tipo_refeicao" => "Café da tarde"],
            ["nome_tipo_refeicao" => "Coquetel"],
            ["nome_tipo_refeicao" => "Jantar"]
        ]);
    }
}
