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

                <h1 class="title">Novo Menu</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="menu-formulario">
            <div class="container-fluid container-limited container-bg-light">
                <div class="content">
                    <div class="clearfix">

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal"
                              action="{{ route('backoffice.menu.salvar') }}"
                              accept-charset="UTF-8"
                              enctype="multipart/form-data"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <label class="block-label" for="id_menu">Código</label>
                                            <input class="form-control" readonly="readonly"
                                                   type="text" name="id_menu">
                                          </div>

                                        <div class="col-sm-8">
                                            <label class="block-label" for="titulo">Titulo</label>
                                            <input class="form-control" required
                                                   type="text" name="titulo">
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="block-label" for="qtd_maxima_cliente">Preço</label>
                                            <input class="form-control" required
                                                   type="text" name="preco">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="block-label" for="qtd_maxima_cliente">Selecione o Chef</label>
                                            <select required="required" class="form-control" name="id_chef" id="id_chef">
                                                @foreach ($chefs as $chef)
                                                    <option value="{{ $chef->id_chef }}">{{ $chef->nome_completo }} / {{ $chef->email }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <label class="block-label" for="qtd_maxima_cliente">Qtd Máxima Clientes</label>
                                            <input class="form-control" required
                                                   type="text" name="qtd_maxima_cliente">
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="block-label" for="ind_ativo">Ativo</label>

                                            <select required="required" class="form-control" name="ind_ativo" id="ind_ativo">
                                                <option value="1">Sim</option>
                                                <option value="0">Não</option>
                                            </select>

                                        </div>

                                        <div class="col-sm-4">
                                            <label class="block-label" for="fk_status">Status</label>

                                            <select required="required" class="form-control" name="fk_status" id="fk_status">
                                                @foreach ($status as $s)
                                                    <option value="{{ $s->id_produto_status }}">{{ $s->descricao }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-sm-2">
                                            <label class="block-label" for="created_at">Criado em</label>
                                            <input class="form-control" readonly
                                                   type="text" name="created_at">
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="block-label" for="updated_at">Ultima Atualização</label>
                                            <input class="form-control" readonly
                                                   type="text" name="updated_at">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="block-label" for="aperitivo">Aperitivo</label>

                                            <textarea style="resize: none" required="required" class="form-control"
                                                      name="aperitivo" rows="3" cols="30"
                                                      rows="5"></textarea>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">

                                            <label class="block-label" for="entrada">Entrada</label>

                                            <textarea style="resize: none" required="required" class="form-control"
                                                      name="entrada" rows="3" cols="30"
                                                      rows="5"></textarea>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="block-label" for="prato_principal">Prato Principal</label>

                                            <textarea style="resize: none" required="required" class="form-control"
                                                      name="prato_principal" rows="3" cols="30"
                                                      rows="5"></textarea>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="block-label" for="sobremesa">Sobremesa</label>

                                            <textarea style="resize: none" required="required" class="form-control"
                                                      name="sobremesa" rows="3" cols="30"
                                                      rows="5"></textarea>

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

                                                            <input type="checkbox"
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
                                            <label class="block-label" for="descricao">Preços Por Clientes</label>
                                            <div class="allpadding-sm noleftpadding nobottompadding toppadding-xsm">
                                                <div class="form-group" v-for="preco in precos">

                                                    <div class="col-sm-2">
                                                        <label class="block-label">Preço</label>
                                                        <input class="form-control" type="text" name="menu_preco[]">
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <label class="block-label">Qtd Clientes</label>
                                                        <input class="form-control" type="text" name="qtd_minima_clientes[]">
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <label class="block-label" style="display: block">&nbsp;</label>

                                                        <button type="button" v-on:click="remover_preco($index)" class="btn btn-sm btn-danger leftmargin-sm">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>

                                            <button type="button" v-on:click="adicionar_preco" class="btn btn-info">
                                                <i class="fa fa-usd rightmargin-xsm"></i> Adicionar Preço por Cliente
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">

                                            <label class="block-label" for="descricao">Fotos</label>
                                            <div class="clearfix"></div>

                                            <div class="bg-white allpadding-sm gray-border topmargin-sm">

                                                <div v-for="foto in fotos" class="bottommargin-sm">
                                                    <input type="file" name="menu_foto[]" class="foto-upload">
                                                    <button type="button" v-on:click="remover($index)" class="btn btn-danger btn-sm leftmargin-sm">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>

                                                <button type="button" v-on:click="adicionar" class="btn btn-info">
                                                    <i class="fa fa-camera-retro rightmargin-xsm"></i> Adicionar Foto
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

    <script type="text/javascript" src="/admin/js/menu/formulario.vue.js"></script>

@endsection
