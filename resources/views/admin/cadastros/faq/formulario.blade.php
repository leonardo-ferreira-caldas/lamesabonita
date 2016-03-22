@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">FAQ</h1>
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
                              action="{{ route('cadastro.faq.salvar') }}"
                              accept-charset="UTF-8"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="control-label" for="id_faq">Código</label>
                                        <div class="col-sm-10">
                                            <input value="{{ $registro->id_faq or '' }}" class="form-control" readonly="readonly"
                                                   type="text" name="id_faq">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="id_faq">Tipo</label>
                                        <div class="col-sm-3">
                                            <select required name="fk_tipo" class="form-control">
                                                <option value="">Selecione...</option>
                                                <optgroup label="Chef">
                                                    @foreach($chefs as $tipo)
                                                        <option
                                                            @if(isset($registro->fk_tipo))
                                                                {{ $registro->fk_tipo == $tipo->id_faq_tipo ? 'selected' : '' }}
                                                            @endif
                                                            value="{{ $tipo->id_faq_tipo }}">{{ $tipo->descricao }}</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Clientes">
                                                    @foreach($clientes as $tipo)
                                                        <option
                                                            @if(isset($registro->fk_tipo))
                                                                {{ $registro->fk_tipo == $tipo->id_faq_tipo ? 'selected' : '' }}
                                                            @endif
                                                            value="{{ $tipo->id_faq_tipo }}">{{ $tipo->descricao }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="pergunta">Pergunta</label>
                                        <div class="col-sm-8">

                                            <textarea style="resize: none" required="required" class="form-control" name="pergunta" rows="2">{{ $registro->pergunta or '' }}</textarea>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="resposta">Resposta</label>
                                        <div class="col-sm-10">

                                            <textarea style="resize: none" required="required" class="form-control" name="resposta" rows="8">{{ $registro->resposta or '' }}</textarea>

                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Salvar
                                </button>

                                @if (isset($registro->id_faq))

                                <a class="btn btn-remove btn-delete leftmargin-sm"
                                   href="/backoffice/cadastro/faq/deletar?id={{ $registro->id_faq }}"><i
                                            class="fa fa-trash-o"></i> Remover</a>

                                @endif

                                <a class="btn btn-cancel btn-gray" href="{{ route('cadastro.faq.listar') }}">
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
