<?php

namespace App\Repositories;

use App\Model\FAQTipoModel;

class FAQTipoRepository extends AbstractRepository {

    protected $model = FAQTipoModel::class;

    /**
     * Retorna todos os faqs de chefs
     *
     * @return mixed
     */
    public function getFAQChefs() {
        return $this->find([
            'ind_chef' => true
        ]);
    }

    /**
     * Retorna todos os faqs de clientes
     *
     * @return mixed
     */
    public function getFAQClientes() {
        return $this->find([
            'ind_chef' => false
        ]);
    }

}