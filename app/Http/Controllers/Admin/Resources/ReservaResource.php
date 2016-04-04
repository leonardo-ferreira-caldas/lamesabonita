<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Mappers\RepositoryMapper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReservaResource extends Controller
{
    private $repository;

    public function __construct(RepositoryMapper $repositoryMapper)
    {
        $this->repository = $repositoryMapper;
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.reservas.listar', [
            'status_reserva' => $this->repository->reserva_status->all(),
            'status_pagamento' => $this->repository->pagamento->getPagamentoStatus()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return $this->repository->reserva->getTodasReservas();
    }

    /**
     * Carrega os detalhes de uma reserva
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetalhes($id) {
        return view('admin.reservas.detalhes', [
            'reserva' => $this->repository->reserva->getDadosReserva($id)
        ]);
    }

}
