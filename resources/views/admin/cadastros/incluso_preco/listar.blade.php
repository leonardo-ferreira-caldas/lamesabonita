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

        <div class="content-wrapper" id="incluso_preco" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="gray-content-block top-block">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="filter-item">
                                        <input v-model="filtro" type="text" placeholder="Pesquise os itens..." class="search-input form-control ui-autocomplete-input" spellcheck="false" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="pull-right">
                                        <a class="btn btn-new" href="{{ route('cadastro.incluso_preco.inserir') }}">
                                            <i class="fa fa-plus"></i>
                                            &nbsp;Adicionar Novo Item
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="prepend-top-default"></div>
                        <div class="table-holder">
                            <table class="table">
                                <thead class="panel-heading">
                                <tr>
                                    <th>Cód</th>
                                    <th>Descrição</th>
                                    <th>Tipo</th>
                                    <th nowrap="nowrap"></th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-show="!registros.length">
                                    <td colspan="3" align="center">Nenhum item incluso no preço foi encontrado.</td>
                                </tr>

                                <tr v-for="registro in registros | filterBy filtro">
                                    <td>@{{ registro.id_incluso_preco }}</td>
                                    <td>@{{ registro.descricao }}</td>
                                    <td>@{{ registro.tipo }}</td>
                                    <td nowrap="nowrap">
                                        <a class="btn btn-sm btn-remove btn-delete pull-right leftmargin-sm"
                                           href="/backoffice/cadastro/incluso_preco/deletar?id=@{{ registro.id_incluso_preco }}"><i
                                                    class="fa fa-trash-o"></i></a>

                                        <a class="btn btn-sm btn-gray delete-key pull-right"
                                           href="/backoffice/cadastro/incluso_preco/editar?id=@{{ registro.id_incluso_preco }}"><i
                                                    class="fa fa-pencil"></i></a>

                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/admin/js/cadastro/incluso_preco.vue.js"></script>

@endsection
