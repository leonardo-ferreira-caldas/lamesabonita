@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Tipos de Culinária</h1>
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
                            Preencha os campos abaixo para inserir uma nova culinária.
                        </div>

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal"
                              action="{{ route('cadastro.tipo_culinaria.salvar') }}"
                              accept-charset="UTF-8"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="control-label" for="user_email">Código</label>
                                        <div class="col-sm-10">
                                            <input value="{{ $registro->id_culinaria or '' }}" class="form-control" readonly="readonly"
                                                   type="text" name="id_culinaria">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="user_name">Nome</label>
                                        <div class="col-sm-10">

                                            <input value="{{ $registro->nome_culinaria or '' }}" class="form-control" required="required" type="text"
                                                   name="nome_culinaria">

                                            <span class="help-block">Entre com o nome da culinária desejada.</span>
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Salvar
                                </button>

                                @if (isset($registro->id_culinaria))

                                    <a class="btn btn-remove btn-delete leftmargin-sm"
                                       href="{{ route('cadastro.tipo_culinaria.deletar') }}?id={{ $registro->id_culinaria }}"><i
                                                class="fa fa-trash-o"></i> Remover</a>

                                @endif

                                <a class="btn btn-cancel btn-gray" href="{{ route('cadastro.tipo_culinaria.listar') }}">
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
