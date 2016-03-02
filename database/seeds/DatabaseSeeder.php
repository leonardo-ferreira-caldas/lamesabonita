<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(GeographicSeed::class);
        $this->call(GenderSeed::class);
        $this->call(BanksSeed::class);
        $this->call(CousineSeed::class);
        $this->call(TipoRefeicaoSeed::class);
        $this->call(ChefStatusSeed::class);
        $this->call(ChefSeloStatusSeed::class);
        $this->call(InclusoPrecoTipoSeed::class);
        $this->call(InclusoPrecoSeed::class);
        $this->call(ConfiguracaoSiteSeed::class);

        $this->call(ChefSeed::class);
        $this->call(MenuSeed::class);
        $this->call(CursoSeed::class);

        Model::reguard();
    }
}
