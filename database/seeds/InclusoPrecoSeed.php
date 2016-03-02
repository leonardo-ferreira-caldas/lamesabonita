<?php

use Illuminate\Database\Seeder;

class InclusoPrecoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incluso_preco')->insert([
            ["descricao" => "A preparação do seu menu (o que inclui o pré-preparo antes de ir ao local do evento e a finalização na casa do degustador)", "fk_tipo" => '1'],
            ["descricao" => "Todos os ingredientes (inclusive sal, pimenta, óleo e pão, por exemplo)", "fk_tipo" => '1'],
            ["descricao" => "Seu deslocamento até o local", "fk_tipo" => '1'],
            ["descricao" => "O serviço (incluindo a eventual contratação de um ajudante ou garçom quando necessário)", "fk_tipo" => '1'],
            ["descricao" => "A limpeza da cozinha", "fk_tipo" => '1'],
            ["descricao" => "O valor da comissão devida ao site La Mesa Bonita", "fk_tipo" => '1'],
            ["descricao" => "Todos os ingredientes necessários (inclusive sal, pimenta, óleo e pão, por exemplo)", "fk_tipo" => '2'],
            ["descricao" => "O mise en place", "fk_tipo" => '2'],
            ["descricao" => "Toda manipulação e preparo de alimentos", "fk_tipo" => '2'],
            ["descricao" => "Seu deslocamento até o local", "fk_tipo" => '2'],
            ["descricao" => "O serviço (incluindo a eventual contratação de um ajudante quando necessário)", "fk_tipo" => '2'],
            ["descricao" => "A limpeza da cozinha", "fk_tipo" => '2'],
            ["descricao" => "O valor da comissão devida ao site La Mesa Bonita.", "fk_tipo" => '2']
        ]);
    }
}
