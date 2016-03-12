@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')

                <a class="btn btn-cancel btn-gray pull-right topmargin-sm" href="{{ route('backoffice.menu.listar') }}">
                    <i class="fa fa-list-alt rightmargin-xsm"></i> Voltar para a listagem
                </a>

                <a class="btn btn-danger pull-right rightmargin-sm topmargin-sm"
                   href="{{ route('backoffice.curso.reprovar', ['slug' => $curso->slug]) }}">
                    <i class="fa fa-times"></i>&nbsp;
                    Reprovar
                </a>

                <a class="btn btn-success pull-right rightmargin-sm topmargin-sm"
                   href="{{ route('backoffice.curso.aprovar', ['slug' => $curso->slug]) }}">
                    <i class="fa fa-check"></i>&nbsp;
                    Aprovar
                </a>

                <h1 class="title">Curso</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="curso-formulario">
            <div class="container-fluid container-limited container-bg-light">
                <div class="content">
                    <div class="clearfix">

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal"
                              action="{{ route('backoffice.curso.salvar') }}"
                              accept-charset="UTF-8"
                              enctype="multipart/form-data"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <label class="block-label" for="id_curso">Código</label>
                                            <input value="{{ $curso->id_curso }}" class="form-control" readonly="readonly"
                                                   type="text" name="id_curso">
                                        </div>

                                        <div class="col-sm-8">
                                            <label class="block-label" for="titulo">Titulo</label>
                                            <input value="{{ $curso->titulo }}" class="form-control"
                                                   type="text" name="titulo">
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="block-label" for="qtd_maxima_cliente">Preço</label>
                                            <input value="{{ $curso->preco }}" class="form-control"
                                                   type="text" name="preco">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <label class="block-label" for="qtd_maxima_cliente">Qtd Máxima Clientes</label>
                                            <input value="{{ $curso->qtd_maxima_cliente }}" class="form-control"
                                                   type="text" name="qtd_maxima_cliente">
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="block-label" for="ind_ativo">Ativo</label>

                                            <select required="required" class="form-control" name="ind_ativo" id="ind_ativo">
                                                <option {{ $curso->ind_ativo ? 'selected' : '' }} value="1">Sim</option>
                                                <option {{ !$curso->ind_ativo ? 'selected' : '' }} value="0">Não</option>
                                            </select>

                                        </div>

                                        <div class="col-sm-4">
                                            <label class="block-label" for="fk_status">Status</label>

                                            <select required="required" class="form-control" name="fk_status" id="fk_status">
                                                @foreach ($status as $s)
                                                    <option
                                                        {{ $s->id_produto_status == $curso->fk_status ? 'selected' : '' }}
                                                        value="{{ $s->id_produto_status }}">{{ $s->descricao }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-sm-2">
                                            <label class="block-label" for="created_at">Criado em</label>
                                            <input value="{{ date("d/m/Y H:i", strtotime($curso->created_at)) }}" class="form-control" readonly
                                                   type="text" name="created_at">
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="block-label" for="updated_at">Ultima Atualização</label>
                                            <input value="{{ date("d/m/Y H:i", strtotime($curso->updated_at)) }}" class="form-control" readonly
                                                   type="text" name="updated_at">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="block-label" for="aperitivo">Descrição do Curso</label>

                                            <textarea style="resize: none" required="required" class="form-control"
                                                      name="descricao" rows="8" cols="30"
                                                      rows="5">{{ $curso->descricao }}</textarea>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="block-label" for="descricao">Eventos</label>
                                            <div class="gray-border bg-white allpadding-sm noleftpadding nobottompadding toppadding-xsm">
                                                <div class="radio">
                                                    @foreach($refeicoes as $refeicao)
                                                        <label class="bottompadding-sm" style="width: 22%">

                                                            <input
                                                               {{ in_array($refeicao->id_tipo_refeicao, $curso_refeicoes) ? 'checked' : '' }}
                                                               type="checkbox"
                                                               name="tipo_refeicao[]"
                                                               value="{{ $refeicao->id_tipo_refeicao }}">

                                                            <div class="option-title leftmargin-xsm inblock">
                                                                {{ $refeicao->nome_tipo_refeicao }}
                                                            </div>

                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="block-label" for="descricao">Tipos de Culinária</label>
                                            <div class="gray-border bg-white allpadding-sm noleftpadding nobottompadding toppadding-xsm">
                                                <div class="radio">
                                                    @foreach($culinarias as $culinaria)
                                                        <label class="bottompadding-sm" style="width: 22%">

                                                            <input {{ in_array($culinaria->id_culinaria, $curso_culinarias) ? 'checked' : '' }} type="checkbox"
                                                                   name="tipo_culinaria[]"
                                                                   value="{{ $culinaria->id_culinaria }}">

                                                            <div class="option-title leftmargin-xsm inblock">
                                                                {{ $culinaria->nome_culinaria }}
                                                            </div>

                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">

                                            <label class="block-label" for="descricao">Fotos</label>

                                            <div>

                                                @foreach ($imagens as $imagem)

                                                    <div class="picture rightmargin-sm bottommargin-sm" style="width: 200px;{{ $imagem->ind_capa ? 'background: #EAEAEA;' : '' }}">
                                                        <a target="_blank" href="/images/uploads/{{ $imagem->nome_imagem }}">
                                                            <img src="{{ crop($imagem->nome_imagem, 178, 100) }}">
                                                        </a>
                                                        <div class="row topmargin-sm">
                                                            <div class="col-md-12">
                                                                <a
                                                                    class="btn btn-sm btn-block btn-danger bottommargin-xsm"
                                                                    href="{{ route('backoffice.menu.imagem.deletar', ['id' => $imagem->id_curso_imagem]) }}"
                                                                >
                                                                    <i class="fa fa-trash rightmargin-xsm"></i> Deletar Foto
                                                                </a>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <a
                                                                    class="btn btn-sm btn-block btn-info bottommargin-xsm"
                                                                    href="{{ route('backoffice.menu.imagem.definir_capa', ['id' => $imagem->id_curso_imagem]) }}"
                                                                >
                                                                    <i class="fa fa-picture-o rightmargin-xsm"></i> Definir como principal
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endforeach

                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="bg-white allpadding-sm gray-border topmargin-sm">

                                                <div v-for="foto in fotos" class="bottommargin-sm">
                                                    <input type="file" name="curso_foto[]" class="foto-upload">
                                                    <button type="button" v-on:click="remover($index)" class="btn btn-danger btn-sm leftmargin-sm">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>

                                                <button type="button" v-on:click="adicionar" class="btn btn-success">
                                                    <i class="fa fa-camera-retro rightmargin-xsm"></i> Adiciona Foto
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="form-actions bg-white">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Salvar
                                </button>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/admin/js/curso/formulario.vue.js"></script>

@endsection
