<?php

use Illuminate\Database\Seeder;

class ConfiguracaoSiteSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configuracao_site')->insert([
            ["chave" => 'WEBSITE_URL',           "valor" => "http://sandbox.lamesabonita.com"],
            ["chave" => 'MOIP_APP_SECRET',       "valor" => "531hjrzy9znuvmdng9v5p18ihnv0yio"],
            ["chave" => 'TAXA_SERVICO_LMB',      "valor" => "20"],
            ["chave" => 'MOIP_APP_ID',           "valor" => "APP-LMZD98WRXZBN"],
            ["chave" => 'MOIP_APP_ACCESS_TOKEN', "valor" => "bz9mp086xjswpskkairi1cn6rmvbm3q"]
        ]);
    }
}
