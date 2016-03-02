@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Configurações</h1>
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

                        <form class="form-horizontal"
                              action="{{ route('backoffice.configuracao.salvar') }}"
                              accept-charset="UTF-8"
                              method="POST">

                            {!! csrf_field() !!}

                            <input type="hidden" name="chave_original" value="{{ $registro->chave or '' }}">

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="control-label" for="chave">Chave</label>
                                        <div class="col-sm-10">
                                            <input value="{{ $registro->chave or '' }}" class="form-control"
                                                   type="text" name="chave">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="valor">Valor</label>
                                        <div class="col-sm-10">

                                            <textarea required class="form-control" name="valor" cols="30" rows="10">{{ $registro->valor or '' }}</textarea>
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Salvar
                                </button>

                                @if (isset($registro->chave))

                                    <a class="btn btn-remove btn-delete leftmargin-sm"
                                       href="{{ route('backoffice.configuracao.deletar') }}?id={{ $registro->chave }}"><i
                                                class="fa fa-trash-o"></i> Remover</a>

                                @endif

                                <a class="btn btn-cancel btn-gray" href="{{ route('backoffice.configuracao.listar') }}">
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
