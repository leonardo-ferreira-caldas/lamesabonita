<?php

namespace App\Handlers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Emails\EmailBemVindoChef;
use App\Emails\EmailBemVindoDegustador;
use App\Emails\EmailChefNovaReserva;
use App\Emails\EmailChefReservaCancelada;
use App\Emails\EmailConfirmacaoChef;
use App\Emails\EmailContato;
use App\Emails\EmailPagamentoAprovado;
use App\Emails\EmailPagamentoEstornado;
use App\Emails\EmailPagamentoReembolsado;
use App\Emails\EmailPagamentoReprovado;
use App\Emails\EmailPerfilAprovado;
use App\Emails\EmailRecuperarSenha;
use App\Emails\EmailReservaMenu;
use App\Emails\EmailSolicitacaoAprovacao;
use App\Emails\EmailSolicitacaoSeloLMB;
use App\Emails\EmailPerfilReprovado;
use App\Jobs\EmailJob;
use App\Model\ReservaModel;

class EmailHandler {

    use DispatchesJobs;

    public function adicionarFila($email) {
        $job = (new EmailJob($email))->delay(2);

        $this->dispatch($job);
    }

    public function enviarEmailConfirmacao($name, $email) {
        $this->adicionarFila(new EmailConfirmacaoChef($name, $email));
    }

    public function enviarEmailBemVindoChef($name, $email) {
        $this->adicionarFila(new EmailBemVindoChef($name, $email));
    }

    public function enviarEmailSolicitacaoSeloLMB($name, $email) {
        $this->adicionarFila(new EmailSolicitacaoSeloLMB($name, $email));
    }

    public function enviarEmailSolicitacaoAprovacao($name, $email) {
        $this->adicionarFila(new EmailSolicitacaoAprovacao($name, $email));
    }

    public function enviarEmailPerfilAprovado($name, $email) {
        $this->adicionarFila(new EmailPerfilAprovado($name, $email));
    }

    public function enviarEmailPerfilReprovado($name, $email) {
        $this->adicionarFila(new EmailPerfilReprovado($name, $email));
    }

    public function enviarEmailBemVindoDegustador($name, $email) {
        $this->adicionarFila(new EmailBemVindoDegustador($name, $email));
    }

    public function enviarEmailFormularioContato($name, $email) {
        $this->adicionarFila(new EmailContato($name, $email));
    }

    public function enviarEmailMenuReservado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailReservaMenu($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        $this->adicionarFila($instanciaEmail);
    }

    public function enviarEmailPagamentoAprovado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailPagamentoAprovado($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        $this->adicionarFila($instanciaEmail);
    }

    public function enviarEmailPagamentoReprovado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailPagamentoReprovado($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        $this->adicionarFila($instanciaEmail);
    }

    public function enviarEmailPagamentoEstornado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailPagamentoEstornado($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        $this->adicionarFila($instanciaEmail);
    }

    public function enviarEmailPagamentoReembolsado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailPagamentoReembolsado($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        $this->adicionarFila($instanciaEmail);
    }

    public function enviarEmailChefNovaReserva($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailChefNovaReserva($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        $this->adicionarFila($instanciaEmail);
    }

    public function enviarEmailChefReservaCancelada($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailChefReservaCancelada($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        $this->adicionarFila($instanciaEmail);
    }

    public function enviarEmailRecuperarSenha($name, $email, $token) {
        $instanciaEmail = new EmailRecuperarSenha($name, $email);
        $instanciaEmail->setToken($token);
        $this->adicionarFila($instanciaEmail);
    }

}