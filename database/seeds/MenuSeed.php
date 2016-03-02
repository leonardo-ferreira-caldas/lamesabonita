<?php

use Illuminate\Database\Seeder;

class MenuSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chefs = \App\Model\ChefModel::all()->lists('id_chef');

        factory(App\Model\MenuModel::class, 50)->make()->each(function($m) use ($chefs) {

            $m->fk_chef = $chefs->random();
            $m->save();

            for($i = 1; $i <= 3; $i++) {
                $menuprice = factory(App\Model\MenuPrecoModel::class)->make();
                $menuprice->fk_menu = $m->id_menu;
                $menuprice->save();
            }

            for($i = 1; $i <= 5; $i++) {
                $picture = factory(App\Model\MenuImagemModel::class)->make();
                $picture->fk_menu = $m->id_menu;
                $picture->ind_capa = $i == 1 ? 1 : 0;
                $picture->save();
            }

            for($i = 1; $i <= 5; $i++) {
                $tiporefeicao = new \App\Model\MenuRefeicaoModel();
                $tiporefeicao->fk_menu = $m->id_menu;
                $tiporefeicao->fk_tipo_refeicao = $i;
                $tiporefeicao->save();
            }

            for($i = 1; $i <= 2; $i++) {
                $tiporefeicao = new \App\Model\MenuCulinariaModel();
                $tiporefeicao->fk_menu = $m->id_menu;
                $tiporefeicao->fk_culinaria = $i;
                $tiporefeicao->save();
            }

        });
    }
}
