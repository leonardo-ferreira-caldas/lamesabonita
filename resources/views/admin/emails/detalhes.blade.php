@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')

                <a class="btn btn-success pull-right rightmargin-sm topmargin-sm"
                   href="{{ route('backoffice.email.reenviar', ['id' => $email->id_email]) }}">
                    <i class="fa fa-check"></i>&nbsp;
                    Reenviar E-mail
                </a>

                <h1 class="title">Detalhes do Email</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="tipo_culinaria">
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal">

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="block-label" for="id_tipo_refeicao">Assunto</label>

                                    <input value="{{ $email->assunto }}" class="form-control" readonly type="text">
                                </div>

                                <div class="col-sm-2">
                                    <label class="block-label" for="id_tipo_refeicao">Enviado?</label>

                                    <input value="{{ $email->ind_enviado ? 'Sim' : 'Não' }}" class="form-control" readonly type="text">
                                </div>

                                <div class="col-sm-3">
                                    <label class="block-label" for="id_tipo_refeicao">Data Criação</label>

                                    <input value="{{ formatar_datahora_br($email->data_criacao) }}" class="form-control" readonly type="text">
                                </div>

                                <div class="col-sm-3">
                                    <label class="block-label" for="id_tipo_refeicao">Data Envio</label>

                                    <input value="{{ formatar_datahora_br($email->data_envio) }}" class="form-control" readonly type="text">
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label class="block-label" for="id_tipo_refeicao">De</label>

                                    <input value="{{ $email->de_nome }} <{{ $email->de_email }}>" class="form-control" readonly type="text">
                                </div>
                                <div class="col-sm-6">
                                    <label class="block-label" for="id_tipo_refeicao">Para</label>

                                    <input value="{{ $email->para_nome }} <{{ $email->para_email }}>" class="form-control" readonly type="text">
                                </div>
                            </div>

                        </form>

                        <div class="prepend-top-default"></div>
                        <br>

                        <label class="block-label" for="id_tipo_refeicao">Corpo do Email</label>
                        <iframe width="100%" height="700" src="/backoffice/email/corpo_email/{{ $email->id_email }}" frameborder="0"></iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
