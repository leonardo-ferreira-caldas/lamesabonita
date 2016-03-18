<?php

namespace App\Facades;

use App\Emails\Email as AbstractEmail;
use App\Queues\Email as FilaEmail;
use App\Formatters\Email as EmailFormatter;
use Carbon\Carbon;

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
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use DB;

class Email
{

    /**
     * Adiciona o email na fila para ser processado
     *
     * @param AbstractEmail $email
     * @see App\Emails\Email
     * @return null
     */
    private static function adicionarFila(AbstractEmail $email) {

        $variaveis = array_merge($email->getVariavies() ?: [], [
            'assunto' => $email->getAssunto()
        ]);

        $cssToInlineStyles = new CssToInlineStyles();
        $cssToInlineStyles->setHTML(view($email->getView(), $variaveis)->render());
        $cssToInlineStyles->setUseInlineStylesBlock(true);
        $corpoEmail = $cssToInlineStyles->convert();

        DB::beginTransaction();

        try {

            $idEmail = DB::table('email')->insertGetId([
                'para_email' => EmailFormatter::normalize($email->getEmail()),
                'para_nome' => $email->getNome(),
                'de_email' => config('mail.from.address'),
                'de_nome' => config('mail.from.name'),
                'assunto' => $email->getAssunto(),
                'anexos' => json_encode($email->getAnexos()),
                'corpo_email' => $corpoEmail,
                'data_criacao' => Carbon::now()->toDateTimeString()
            ]);

            FilaEmail::enfilerar($idEmail);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public static function enviarEmailConfirmacao($name, $email) {
        self::adicionarFila(new EmailConfirmacaoChef($name, $email));
    }

    public static function enviarEmailBemVindoChef($name, $email) {
        self::adicionarFila(new EmailBemVindoChef($name, $email));
    }

    public static function enviarEmailSolicitacaoSeloLMB($name, $email) {
        self::adicionarFila(new EmailSolicitacaoSeloLMB($name, $email));
    }

    public static function enviarEmailSolicitacaoAprovacao($name, $email) {
        self::adicionarFila(new EmailSolicitacaoAprovacao($name, $email));
    }

    public static function enviarEmailPerfilAprovado($name, $email) {
        self::adicionarFila(new EmailPerfilAprovado($name, $email));
    }

    public static function enviarEmailPerfilReprovado($name, $email) {
        self::adicionarFila(new EmailPerfilReprovado($name, $email));
    }

    public static function enviarEmailBemVindoDegustador($name, $email) {
        self::adicionarFila(new EmailBemVindoDegustador($name, $email));
    }

    public static function enviarEmailFormularioContato($name, $email) {
        self::adicionarFila(new EmailContato($name, $email));
    }

    public static function enviarEmailMenuReservado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailReservaMenu($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        self::adicionarFila($instanciaEmail);
    }

    public static function enviarEmailPagamentoAprovado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailPagamentoAprovado($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        self::adicionarFila($instanciaEmail);
    }

    public static function enviarEmailPagamentoReprovado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailPagamentoReprovado($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        self::adicionarFila($instanciaEmail);
    }

    public static function enviarEmailPagamentoEstornado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailPagamentoEstornado($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        self::adicionarFila($instanciaEmail);
    }

    public static function enviarEmailPagamentoReembolsado($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailPagamentoReembolsado($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        self::adicionarFila($instanciaEmail);
    }

    public static function enviarEmailChefNovaReserva($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailChefNovaReserva($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        self::adicionarFila($instanciaEmail);
    }

    public static function enviarEmailChefReservaCancelada($name, $email, ReservaModel $reservaModel) {
        $instanciaEmail = new EmailChefReservaCancelada($name, $email);
        $instanciaEmail->setReserva($reservaModel);
        self::adicionarFila($instanciaEmail);
    }

    public static function enviarEmailRecuperarSenha($name, $email, $token) {
        $instanciaEmail = new EmailRecuperarSenha($name, $email);
        $instanciaEmail->setToken($token);
        self::adicionarFila($instanciaEmail);
    }
}
