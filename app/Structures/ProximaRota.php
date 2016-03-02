<?php

namespace App\Structures;

use App\Business\ChefBO;
use App\Formatters\Vector;
use App\Helpers\AjaxResponse;

class ProximaRota
{
    private $successMessage = [];
    private $redirect = null;
    private $redirectFallback = [];
    private $isAjax = false;
    private $cjef;

    public function __construct($successMessage, $redirectFallback = null)
    {
        $this->successMessage[] = $successMessage;
        $this->redirectFallback = $redirectFallback;
        $this->chef = app(ChefBO::class);
        $this->identificarProximaRota();
    }

    /**
     * Identifica se a requisição foi feito usando AJAX
     *
     * @return void
     */
    public function setAjax($bool) {
        $this->isAjax = $bool;
    }

    /**
     * Identfica qual será a proxima rota
     */
    private function identificarProximaRota() {

        $status = $this->chef->getStatusPreenchimentoPerfilChefLogado();
        $finalizouPerfil = true;

        if (!$status['informacoes_pessoais']) {
            $this->successMessage[] = 'Agora preencha suas informações pessoais.';
            $this->redirect = 'chef.informacoes_pessoais';

        } else if (!$status['contas_bancarias']) {
            $this->successMessage[] = 'Agora preencha seus dados bancários.';
            $this->redirect = 'chef.dados_bancarios';

        } else if (!$status['localizacao']) {
            $this->successMessage[] = 'Agora preencha sua localização.';
            $this->redirect = 'chef.localizacao';

        } else if (($status['menu'] + $status['curso']) < 2) {
            $this->successMessage[] = 'Cadastre pelo menos dois menus e/ou dois cursos para poder solicitar aprovação do seu perfil.';
            $this->redirect = 'menus.listar';

        } else if (!$status['foto_capa']) {
            $this->successMessage[] = 'Agora altere sua foto de capa/fundo do seu perfil.';
            $this->redirect = 'chef.visao_geral';

        } else if (!$status['avatar']) {
            $this->successMessage[] = 'Agora altere sua foto de perfil.';
            $this->redirect = 'chef.visao_geral';

        } else if ($this->chef->perfilAguardandoCadastro()) {
            $this->successMessage[] = 'Você terminou de preencher todos os dados do seu perfil. Você agora pode solicitar a aprovação do seu perfil.';
        }

    }

    /**
     * Estrutura a resposta que será enviada de volta ao usuario
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function getResponse() {
        if ($this->isAjax) {
            if (!empty($this->redirect)) {
                return AjaxResponse::successWithRedirect($this->successMessage, 'Continuar cadastrando meu perfil', route($this->redirect));
            }

            return AjaxResponse::success($this->successMessage);
        }

        $response = redirectWithAlertSuccess(Vector::joinBy($this->successMessage, '\n\n'));

        if (!empty($this->redirect)) {
            return $response->to(route($this->redirect));
        }

        return $response->back();
    }

}