<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ChefSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function($u) {
            $chef = factory(App\Model\ChefModel::class)->make();
            $chef->id_chef = $u->id;
            $chef->save();

            $data = Carbon::now();

            for ($i = 1; $i < 20; $i++) {
                $agenda = new \App\Model\ChefAgendaModel();
                $agenda->fk_chef = $u->id;
                $agenda->data = $data->addDay()->toDateString();
                $agenda->hora_de = "08:00:00";
                $agenda->hora_ate = "22:00:00";
                $agenda->save();
            }
        });
    }
}
