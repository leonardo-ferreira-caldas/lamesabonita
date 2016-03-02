<?php

use Illuminate\Database\Seeder;

class ChefStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chef_status')->insert([
            ["id_chef_status" => '1', "descricao" => "Ativo/Aprovado"],
            ["id_chef_status" => '2', "descricao" => "Aguardando finalização do perfil"],
            ["id_chef_status" => '3', "descricao" => "Aguardando aprovação da equipe La Mesa Bonita"],
            ["id_chef_status" => '4', "descricao" => "Reprovado"]
        ]);
    }
}
