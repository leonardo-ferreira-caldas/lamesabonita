<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 22/01/16
 * Time: 22:52
 */

namespace App\Business;

use App\Constants\PagamentoConstants;
use App\Facades\Email;
use App\Formatters\DataFormatter;
use App\Mappers\BusinessMapper;
use App\Repositories\PagamentoRepository;
use DB;

class PagamentoBO
{

    private $repository;
    private $bo;

    public function __construct(BusinessMapper $bmapper, PagamentoRepository $repository)
    {
        $this->repository = $repository;
        $this->bo = $bmapper;
    }

    public function ehStatusPagamento($status)
    {
        return in_array($status, [
            PagamentoConstants::MOIP_STATUS_CREATED,
            PagamentoConstants::MOIP_STATUS_WAITING,
            PagamentoConstants::MOIP_STATUS_IN_ANALYSIS,
            PagamentoConstants::MOIP_STATUS_PRE_AUTHORIZED,
            PagamentoConstants::MOIP_STATUS_AUTHORIZED,
            PagamentoConstants::MOIP_STATUS_CANCELLED,
            PagamentoConstants::MOIP_STATUS_REFUNDED,
            PagamentoConstants::MOIP_STATUS_REVERSED
        ]);
    }

    public function atualizarStatusPagamento($pagamentoID, $statusMoip)
    {

        DB::beginTransaction();

        try {

            $status = $this->repository->getStatus($statusMoip);
            $pagamento = $this->repository->findByMoipId($pagamentoID);
            $reserva = $pagamento->reserva;
            $name = $reserva->userDegustador->name;
            $email = $reserva->userDegustador->email;
            $nameChef = $reserva->user->name;
            $emailChef = $reserva->user->email;

            switch ($status) {

                case PagamentoConstants::STATUS_PAGAMENTO_APROVADO:

                    // Caso o pagamento esteja com qualquer situação diferente de aguardando aprovação
                    if ($pagamento->fk_pagamento_status != PagamentoConstants::STATUS_AGUARDANDO_APROVACAO){
                        break;
                    }

                    $this->repository->atualizarStatusPagamento($pagamento->id_pagamento, PagamentoConstants::STATUS_PAGAMENTO_APROVADO, $statusMoip);
                    $this->repository->adicionarTracking($pagamento->id_pagamento, PagamentoConstants::STATUS_PAGAMENTO_APROVADO, $statusMoip, DataFormatter::getDataHoraAtual());
                    $this->bo->chef->adicionarSaldo($reserva->user->id, $reserva->vlr_divisao_chef);
                    Email::enviarEmailPagamentoAprovado($name, $email, $reserva);
                    Email::enviarEmailChefNovaReserva($nameChef, $emailChef, $reserva);
                    break;

                case PagamentoConstants::STATUS_PAGAMENTO_REPROVADO:

                    // Caso o pagamento já esteja aprovada, não faz nada
                    if ($pagamento->fk_pagamento_status == PagamentoConstants::STATUS_PAGAMENTO_APROVADO){
                        break;
                    }

                    $this->repository->atualizarStatusPagamento($pagamento->id_pagamento, PagamentoConstants::STATUS_PAGAMENTO_REPROVADO, $statusMoip);
                    $this->repository->adicionarTracking($pagamento->id_pagamento, PagamentoConstants::STATUS_PAGAMENTO_REPROVADO, $statusMoip, DataFormatter::getDataHoraAtual());
                    $this->bo->reserva->cancelarReserva($pagamento->fk_reserva);
                    Email::enviarEmailPagamentoReprovado($name, $email, $reserva);
                    Email::enviarEmailChefReservaCancelada($name, $email, $reserva);
                    break;

                default:

                    // Caso o pagamento não esteja aprovado, nao valida estorno e reembolso
                    if ($pagamento->fk_pagamento_status != PagamentoConstants::STATUS_PAGAMENTO_APROVADO){
                        break;
                    }

                    switch ($status) {
                        case PagamentoConstants::STATUS_PAGAMENTO_ESTORNADO:
                            $this->repository->atualizarStatusPagamento($pagamento->id_pagamento, PagamentoConstants::STATUS_PAGAMENTO_ESTORNADO, $statusMoip);
                            $this->repository->adicionarTracking($pagamento->id_pagamento, PagamentoConstants::STATUS_PAGAMENTO_ESTORNADO, $statusMoip, DataFormatter::getDataHoraAtual());
                            $this->bo->reserva->cancelarReserva($pagamento->fk_reserva);
                            Email::enviarEmailPagamentoEstornado($name, $email, $reserva);
                            Email::enviarEmailChefReservaCancelada($name, $email, $reserva);
                            break;

                        case PagamentoConstants::STATUS_PAGAMENTO_REEMBOLSADO:
                            $this->repository->atualizarStatusPagamento($pagamento->id_pagamento, PagamentoConstants::STATUS_PAGAMENTO_REEMBOLSADO, $statusMoip);
                            $this->repository->adicionarTracking($pagamento->id_pagamento, PagamentoConstants::STATUS_PAGAMENTO_REEMBOLSADO, $statusMoip, DataFormatter::getDataHoraAtual());
                            $this->bo->reserva->cancelarReserva($pagamento->fk_reserva);
                            Email::enviarEmailPagamentoReembolsado($name, $email, $reserva);
                            Email::enviarEmailChefReservaCancelada($name, $email, $reserva);
                            break;

                    }

            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

}