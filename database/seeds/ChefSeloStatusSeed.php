<?php

use Illuminate\Database\Seeder;

class ChefSeloStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chef_selo_status')->insert([
            ["id_selo_status" => 1, "descricao" => "Não possui selo"],
            ["id_selo_status" => 2, "descricao" => "Solicitou selo"],
            ["id_selo_status" => 3, "descricao" => "Em análise"],
            ["id_selo_status" => 4, "descricao" => "Selo não aprovado"],
            ["id_selo_status" => 5, "descricao" => "Selo aprovado"]
        ]);
    }
}
