<?php

namespace App\Business;

use App\Repositories\FAQRepository;

class FAQBO
{
    private $repository;

    public function __construct(FAQRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Busca e agrupa todos os FAQs do Cliente
     *
     * @return array
     */
    public function getFAQCliente() {
        return $this->agruparItemsFAQ($this->repository->getFAQCliente());
    }

    /**
     * Busca e agrupa todos os FAQs do Chef
     *
     * @return array
     */
    public function getFAQChef() {
        return $this->agruparItemsFAQ($this->repository->getFAQChef());
    }

    /**
     * Agrupa os registros de FAQ por tipo
     *
     * @param array $listaFAQ
     * @return array
     */
    private function agruparItemsFAQ($listaFAQ) {
        $agrupador = [];

        foreach ($listaFAQ as $itemFAQ) {
            if (!isset($agrupador[$itemFAQ->id_faq_tipo])) {
                $agrupador[$itemFAQ->id_faq_tipo] = [
                    'label' => $itemFAQ->tipo,
                    'items' => []
                ];
            }

            $agrupador[$itemFAQ->id_faq_tipo]['items'][] = $itemFAQ;
        }

        return $agrupador;
    }

}
