<?php

use Illuminate\Database\Seeder;

class BanksSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banco')->insert([
            ["id_banco" => "104", "nome_banco" => "Caixa Econômica Federal"],
            ["id_banco" => "001", "nome_banco" => "Banco do Brasil S.A."],
            ["id_banco" => "341", "nome_banco" => "Itaú Unibanco S.A."],
            ["id_banco" => "399", "nome_banco" => "HSBC Bank Brasil S.A. - Banco Múltiplo"],
            ["id_banco" => "237", "nome_banco" => "Banco Bradesco S.A."],
            ["id_banco" => "208", "nome_banco" => "Banco BTG Pactual S.A."],
            ["id_banco" => "422", "nome_banco" => "Banco Safra S.A."],
            ["id_banco" => "033", "nome_banco" => "Banco Santander (Brasil) S.A."],
            ["id_banco" => "655", "nome_banco" => "Banco Votorantim S.A."]
        ]);

    }
}
