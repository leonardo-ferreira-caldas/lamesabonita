<?php

namespace App\Repositories;

use App\Constants\FAQConstants;
use App\Facades\Query;
use App\Model\FAQModel;

class FAQRepository extends AbstractRepository {

    protected $model = FAQModel::class;

    public function getFAQCliente() {
        return Query::fetch("Paginas/FAQ/QryBuscarFAQ", [
            "ind_chef" => false
        ]);
    }

    public function getFAQChef() {
        return Query::fetch("Paginas/FAQ/QryBuscarFAQ", [
            "ind_chef" => true
        ]);
    }

    /**
     * Insere uma novo FAQ
     *
     * @param string $pergunta
     * @param string $resposta
     * @param int $idTipo
     * @return Model/FAQModel
     */
    public function inserir($pergunta, $resposta, $idTipo) {
        return $this->create([
            'pergunta' => $pergunta,
            'resposta' => $resposta,
            'fk_tipo' => $idTipo,
        ]);
    }

    /**
     * Atualiza um FAQ
     *
     * @param string $pergunta
     * @param string $resposta
     * @param int $idTipo
     * @return Model/FAQModel
     */
    public function atualizar($idFAQ, $pergunta, $resposta, $idTipo) {
        return $this->updateById($idFAQ, [
            'pergunta' => $pergunta,
            'resposta' => $resposta,
            'fk_tipo' => $idTipo,
        ]);
    }

}