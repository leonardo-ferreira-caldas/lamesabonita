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
                               onclick="location.href='{{ route("admin.logout") }}'">
                                <i class="fa fa-sign-out"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <h1 class="title">Eventos</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="tipo_refeicao" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="gray-content-block top-block">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="filter-item">
                                        <input v-model="filtro" type="text" placeholder="Pesquise eventos..." class="search-input form-control ui-autocomplete-input" spellcheck="false" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="pull-right">
                                        <a class="btn btn-new" href="{{ route('cadastro.tipo_refeicao.inserir') }}">
                                            <i class="fa fa-plus"></i>
                                            &nbsp;Adicionar Novo Evento
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
                                    <th>Nome Evento</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-show="!registros.length">
                                    <td colspan="2" align="center">Nenhum tipo de refeição encontrado.</td>
                                </tr>

                                <tr v-for="registro in registros | filterBy filtro">
                                    <td>@{{ registro.id_tipo_refeicao }}</td>
                                    <td>@{{ registro.nome_tipo_refeicao }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-remove btn-delete pull-right leftmargin-sm"
                                           href="/backoffice/cadastro/tipo_refeicao/deletar?id=@{{ registro.id_tipo_refeicao }}"><i
                                                    class="fa fa-trash-o"></i> Remover</a>

                                        <a class="btn btn-sm btn-gray delete-key pull-right"
                                           href="/backoffice/cadastro/tipo_refeicao/editar?id=@{{ registro.id_tipo_refeicao }}"><i
                                                    class="fa fa-pencil"></i> Editar</a>

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

    <script src="/admin/js/cadastro/tipo_refeicao.vue.js"></script>

@endsection
