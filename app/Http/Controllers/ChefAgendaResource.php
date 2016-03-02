<?php

namespace App\Http\Controllers;

use App\Facades\Autenticacao;
use App\Mappers\RepositoryMapper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Utils\Utils;
use Mockery\CountValidator\Exception;

class ChefAgendaResource extends Controller
{
    private $repository;

    public function __construct(RepositoryMapper $mapper) {
        $this->repository = $mapper;
//        $this->middleware('auth');
    }

    private function getDate($post) {
        $month = str_pad($post['month'], 2, '0', STR_PAD_LEFT);
        $day   = str_pad($post['day'], 2, '0', STR_PAD_LEFT);

        return sprintf('%s-%s-%s', $post['year'], $month, $day);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Requests\SalvarAgendaRequest $request)
    {

        $post = $request->all();
        $date = $this->getDate($post);

        if (!Utils::isValidDate($date) || $post['time_from'] >= $post['time_to'] || $date <= date('Y-m-d')) {
            abort(404, 'Não permitido');
        }

        $agenda = $this->repository->chef_agenda->getAgendaPorData(Autenticacao::getId(), $date);

        if (!empty($agenda)) {
            return $this->update($request, $agenda->id_chef_agenda);
        }

        $ChefAgendaModel = $this->repository->chef_agenda->create([
            'fk_chef'  => Autenticacao::getId(),
            'data'     => $date,
            'hora_de'  => Utils::formatTime($post['time_from']),
            'hora_ate' => Utils::formatTime($post['time_to'])
        ]);

        return $ChefAgendaModel->id_chef_agenda;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Requests\SalvarAgendaRequest $request, $idAgenda)
    {
        $post = $request->all();

        $agenda = $this->repository->chef_agenda->getAgenda($idAgenda);

        if ($agenda->fk_chef != Autenticacao::getId() || $post['time_from'] >= $post['time_to'] || $agenda->data <= date('Y-m-d')) {
            abort(403, 'Não permitido.');
        }

        $agenda->hora_de = Utils::formatTime($post['time_from']);
        $agenda->hora_ate   = Utils::formatTime($post['time_to']);
        $agenda->restore();
        $agenda->save();

        return $agenda->id_chef_agenda;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($idChefAgenda)
    {
        $agenda = $this->repository->chef_agenda->findById($idChefAgenda);

        if ($agenda->fk_chef != Autenticacao::getId()) {
            abort(403, 'Não permitido.');
        }

        $agenda->delete();
    }
}
