<?php

namespace App\Repositories;

use App\Model\CidadeModel;
use App\Model\EstadoModel;
use App\Model\PaisModel;

class GeoRepository {

    private $pais;
    private $cidade;
    private $estado;

    public function __construct(PaisModel $pais, EstadoModel $estado, CidadeModel $cidade)
    {
        $this->cidade  = $cidade;
        $this->estado  = $estado;
        $this->pais    = $pais;
    }

    public function listarEstados() {
        return $this->estado->all();
    }

    public function listarPaises() {
        return $this->pais->all();
    }

    public function listarCidades() {
        return $this->cidade->all();
    }

    public function filtrarCidades($idEstado) {
        return $this->cidade->where('fk_estado', $idEstado)->get();
    }

    public function paisExiste($codigoPais) {
        return $this->pais->where("id_pais", $codigoPais)->count();
    }

    public function estadoExiste($codigoEstado) {
        return $this->estado->where("id_estado", $codigoEstado)->count();
    }

    public function cidadeExiste($codigoCidade) {
        return $this->cidade->where("id_cidade", $codigoCidade)->count();
    }

    public function getCidade($idCidade) {
        return $this->cidade->findOrFail($idCidade);
    }

    /**
     * Retorna o ID da cidade usando o nome como filtro
     *
     * @param string $nomeCidade
     * @return int
     */
    public function getIdCidadeByNome($nomeCidade) {
        $cidade = $this->cidade->where('nome_cidade', $nomeCidade)->firstOrFail();
        return $cidade->id_cidade;
    }

}