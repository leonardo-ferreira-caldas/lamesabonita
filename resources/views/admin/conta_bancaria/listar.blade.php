@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Contas Bancárias</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="conta_bancaria" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="issues-details-filters gray-content-block">
                            <form class="filter-form" action="/dashboard/merge_requests?scope=all&amp;sort=id_desc&amp;state=opened" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                <div class="row">
                                    <div class="col-md-4 norightpadding">
                                        <label class="block-label">Banco</label>
                                        <select v-model="filtro_banco" class="form-control">
                                            <option value="">Todos</option>
                                            @foreach($bancos as $banco)
                                                <option value="{{ $banco->id_banco }}">{{ $banco->id_banco . ' - ' . $banco->nome_banco }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 norightpadding">
                                        <label class="block-label">Busca por chef</label>
                                        <input type="text" id="filter_projects"
                                               placeholder="Digite o nome do chef..."
                                               v-model="filtro_chef"
                                               class="projects-list-filter form-control" spellcheck="false">
                                    </div>

                                </div>
                            </form>

                        </div>

                        <div class="table-holder topmargin-sm bottompadding-lg">
                            <table class="table">
                                <thead class="panel-heading">
                                <tr>
                                    <th>Cód</th>
                                    <th>Chef</th>
                                    <th>Banco</th>
                                    <th>Agência</th>
                                    <th>Conta</th>
                                    <th nowrap="nowrap"></th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr v-show="registros.length == 0">
                                        <td colspan="6" align="center">Nenhuma conta bancária encontrado.</td>
                                    </tr>

                                    <tr v-for="conta_bancaria in registros
                                        | filterBy filtro_banco in 'id_banco'
                                        | filterBy filtro_chef in 'chef_nome_completo'
                                    ">
                                        <td>@{{ conta_bancaria.id_conta_bancaria }}</td>
                                        <td>@{{ conta_bancaria.chef_nome_completo }}</td>
                                        <td>@{{ conta_bancaria.banco_descricao }}</td>
                                        <td>@{{ conta_bancaria.agencia_descricao }}</td>
                                        <td>@{{ conta_bancaria.conta_descricao }}</td>
                                        <td nowrap="nowrap">

                                            <a class="btn btn-sm btn-gray pull-right" href="/backoffice/conta_bancaria/editar/@{{ conta_bancaria.id_conta_bancaria }}">
                                                <i class="fa fa-pencil"></i>&nbsp; Editar
                                            </a>

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

    <script src="/admin/js/conta_bancaria/listar.vue.js"></script>

@endsection
