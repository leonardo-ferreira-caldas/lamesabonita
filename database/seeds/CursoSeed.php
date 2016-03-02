<?php

use Illuminate\Database\Seeder;

class CursoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chefs = \App\Model\ChefModel::all()->lists('id_chef');

        factory(App\Model\CursoModel::class, 20)->make()->each(function($m) use ($chefs) {

            $m->fk_chef = $chefs->random();
            $m->save();

            for($i = 1; $i <= 3; $i++) {
                $cursoprice = factory(App\Model\CursoPrecoModel::class)->make();
                $cursoprice->fk_curso = $m->id_curso;
                $cursoprice->save();
            }

            for($i = 1; $i <= 5; $i++) {
                $picture = factory(App\Model\CursoImagemModel::class)->make();
                $picture->fk_curso = $m->id_curso;
                $picture->ind_capa = $i == 1 ? 1 : 0;
                $picture->save();
            }

            for($i = 1; $i <= 5; $i++) {
                $tiporefeicao = new \App\Model\CursoRefeicaoModel();
                $tiporefeicao->fk_curso = $m->id_curso;
                $tiporefeicao->fk_tipo_refeicao = $i;
                $tiporefeicao->save();
            }

            for($i = 1; $i <= 2; $i++) {
                $tiporefeicao = new \App\Model\CursoCulinariaModel();
                $tiporefeicao->fk_curso = $m->id_curso;
                $tiporefeicao->fk_culinaria = $i;
                $tiporefeicao->save();
            }

        });
    }
}
