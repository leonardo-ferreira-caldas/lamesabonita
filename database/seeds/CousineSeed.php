<?php

use Illuminate\Database\Seeder;

class CousineSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('culinaria')->insert([
            ["nome_culinaria" => "Brasileira"],
            ["nome_culinaria" => "Francesa"],
            ["nome_culinaria" => "Italiana"],
            ["nome_culinaria" => "Espanhola"],
            ["nome_culinaria" => "Japonesa"],
            ["nome_culinaria" => "Chinesa"],
            ["nome_culinaria" => "Tailandesa"],
            ["nome_culinaria" => "Indiana"],
            ["nome_culinaria" => "Mexicana"],
            ["nome_culinaria" => "Americana"],
            ["nome_culinaria" => "Churrasco"],
            ["nome_culinaria" => "Fingerfood"],
            ["nome_culinaria" => "Funcional"],
            ["nome_culinaria" => "Vegetariana"],
            ["nome_culinaria" => "Vegana"]
        ]);
    }
}
