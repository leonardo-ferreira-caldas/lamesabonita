<?php

use Illuminate\Database\Seeder;

class DegustadorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 20)->create()->each(function($u) {
            $degustador = factory(App\Model\DegustadorModel::class)->make();
            $degustador->id_degustador = $u->id;
            $degustador->save();
        });
    }
}
