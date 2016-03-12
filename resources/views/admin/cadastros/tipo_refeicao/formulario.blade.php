@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <a class="logout" style="cursor: pointer;" title="Sair" rel="nofollow" data-toggle="tooltip"
                               data-placement="bottom"
                               href="{{ route("admin.logout") }}">
                                <i class="fa fa-sign-out"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <h1 class="title">Evento</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="tipo_culinaria">
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">

                        <div class="gray-content-block top-block">
                            Preencha os campos abaixo para inserir um novo evento.
                        </div>

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal"
                              action="{{ route('cadastro.tipo_refeicao.salvar') }}"
                              accept-charset="UTF-8"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="control-label" for="id_tipo_refeicao">Código</label>
                                        <div class="col-sm-10">
                                            <input value="{{ $registro->id_tipo_refeicao or '' }}" class="form-control" readonly="readonly"
                                                   type="text" name="id_tipo_refeicao">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="nome_tipo_refeicao">Nome</label>
                                        <div class="col-sm-10">

                                            <input value="{{ $registro->nome_tipo_refeicao or '' }}" class="form-control" required="required" type="text"
                                                   name="nome_tipo_refeicao">

                                            <span class="help-block">Entre com o nome do evento desejado.</span>
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Salvar
                                </button>

                                @if (isset($registro->id_tipo_refeicao))

                                <a class="btn btn-remove btn-delete leftmargin-sm"
                                   href="/backoffice/cadastro/tipo_refeicao/deletar?id={{ $registro->id_tipo_refeicao }}"><i
                                            class="fa fa-trash-o"></i> Remover</a>

                                @endif

                                <a class="btn btn-cancel btn-gray" href="{{ route('cadastro.tipo_refeicao.listar') }}">
                                    <i class="fa fa-list-alt rightmargin-xsm"></i> Voltar para a listagem
                                </a>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
