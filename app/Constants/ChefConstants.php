<?php

namespace App\Constants;

class ChefConstants {

    const DEFAULT_AVATAR = 'avatar_chef.jpg';
    const DEFAULT_CAPA = 'chef_wallpaper.jpg';

    const STATUS_ATIVO = 1;
    const STATUS_AGUARDANDO_FINALIZACAO_PERFIL = 2;
    const STATUS_AGUARDANDO_APROVACAO = 3;
    const STATUS_REPROVADO = 4;

    const SELO_NAO_POSSUI = 1;
    const SELO_SOLICITOU = 2;
    const SELO_EM_ANALISE = 3;
    const SELO_NAO_APROVADO = 4;
    const SELO_APROVADO = 5;

    const INCLUSO_PRECO_MENU = 1;
    const INCLUSO_PRECO_CURSO = 2;

}