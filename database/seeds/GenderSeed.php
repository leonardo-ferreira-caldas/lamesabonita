<?php

use Illuminate\Database\Seeder;

class GenderSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Model\SexoModel::create([
            'id_sexo'   => 1,
            'descricao' => 'Masculino'
        ]);

        App\Model\SexoModel::create([
            'id_sexo'   => 2,
            'descricao' => 'Feminino'
        ]);
    }
}
