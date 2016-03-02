@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Incluso no Preço</h1>
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
                            Preencha os campos abaixo para inserir um novo item de incluso no preço
                        </div>

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal"
                              action="{{ route('cadastro.incluso_preco.salvar') }}"
                              accept-charset="UTF-8"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="control-label" for="id_incluso_preco">Código</label>
                                        <div class="col-sm-10">
                                            <input value="{{ $registro->id_incluso_preco or '' }}" class="form-control" readonly="readonly"
                                                   type="text" name="id_incluso_preco">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="descricao">Descrição</label>
                                        <div class="col-sm-10">

                                            <textarea style="resize: none" required="required" class="form-control" name="descricao" id="" cols="30" rows="5">{{ $registro->descricao or '' }}</textarea>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="descricao">Tipo</label>
                                        <div class="col-sm-5">

                                            <select required="required" class="form-control" name="fk_tipo" id="fk_tipo">
                                                <option value="">Selecione...</option>
                                                <option {{ isset($registro->fk_tipo) && $registro->fk_tipo == 1 ? 'selected' : '' }} value="1">Menu</option>
                                                <option {{ isset($registro->fk_tipo) && $registro->fk_tipo == 2 ? 'selected' : '' }} value="2">Curso</option>
                                            </select>

                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Salvar
                                </button>

                                @if (isset($registro->id_incluso_preco))

                                <a class="btn btn-remove btn-delete leftmargin-sm"
                                   href="/backoffice/cadastro/incluso_preco/deletar?id={{ $registro->id_incluso_preco }}"><i
                                            class="fa fa-trash-o"></i> Remover</a>

                                @endif

                                <a class="btn btn-cancel btn-gray" href="{{ route('cadastro.incluso_preco.listar') }}">
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
