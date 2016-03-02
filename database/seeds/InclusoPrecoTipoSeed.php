<?php

use Illuminate\Database\Seeder;

class InclusoPrecoTipoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incluso_preco_tipo')->insert([
            ["id_incluso_preco_tipo" => '1', "descricao" => "Menu"],
            ["id_incluso_preco_tipo" => '2', "descricao" => "Curso"]
        ]);
    }
}
