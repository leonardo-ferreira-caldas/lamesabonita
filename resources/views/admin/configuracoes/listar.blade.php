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

        <div class="content-wrapper" id="configuracao" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="gray-content-block top-block">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="filter-item">
                                        <input v-model="filtro" type="text" placeholder="Pesquisar configurações..." class="search-input form-control ui-autocomplete-input" spellcheck="false" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="pull-right">
                                        <a class="btn btn-new" href="{{ route('backoffice.configuracao.inserir') }}">
                                            <i class="fa fa-plus"></i>
                                            &nbsp;Adicionar Nova Configuração
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
                                    <th>Chave</th>
                                    <th>Valor</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-show="!culinarias.length">
                                    <td colspan="2" align="center">Nenhuma configuração encontrada.</td>
                                </tr>

                                <tr v-for="registro in registros | filterBy filtro in 'chave'">
                                    <td>@{{ registro.chave }}</td>
                                    <td>@{{ registro.valor }}</td>
                                    <td style="width: 120px">

                                        <a class="btn btn-sm btn-remove btn-delete pull-right leftmargin-sm"
                                           href="/backoffice/configuracao/deletar?id=@{{ registro.chave }}"><i
                                                    class="fa fa-trash-o"></i></a>

                                        <a class="btn btn-sm btn-gray delete-key pull-right"
                                           href="/backoffice/configuracao/editar?id=@{{ registro.chave }}"><i
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

    <script src="/admin/js/cadastro/configuracoes.vue.js"></script>

@endsection
