@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Chefs</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="chefs" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="issues-details-filters gray-content-block">
                            <form class="filter-form" action="/dashboard/merge_requests?scope=all&amp;sort=id_desc&amp;state=opened" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                <div class="row">
                                    <div class="col-md-4 norightpadding">
                                        <label class="block-label">Status</label>
                                        <select v-model="filtro_status" class="form-control">
                                            <option value=''>Todos</option>
                                            <option value="1">Ativo/Aprovado</option>
                                            <option value="2">Aguardando finalização do perfil</option>
                                            <option value="3">Aguardando aprovação da equipe La Mesa Bonita</option>
                                            <option value="4">Reprovado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5 norightpadding">
                                        <label class="block-label">Busca por nome</label>
                                        <input type="text" name="filter_projects"
                                               placeholder="Digite o nome do chef..."
                                               v-model="filtro_nome"
                                               class="projects-list-filter form-control" spellcheck="false">
                                    </div>

                                </div>
                            </form>

                        </div>

                        <div class="table-holder topmargin-sm bottompadding-lg">
                            <table class="table">
                                <thead class="panel-heading">
                                <tr>
                                    <th>Foto Perfil</th>
                                    <th>Nome Completo</th>
                                    <th>Status</th>
                                    <th nowrap="nowrap"></th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr v-show="registros.length == 0">
                                        <td colspan="7" align="center">Nenhum chef cadastrado.</td>
                                    </tr>

                                    <tr v-for="registro in registros
                                    | filterBy filtro_nome in 'nome_completo'
                                    | filterBy filtro_status in 'status'">
                                        <td>
                                            <div class="dash-project-avatar">
                                                <img class="avatar project-avatar s46" src="/image/46/46/@{{ registro.avatar }}">
                                            </div>
                                        </td>
                                        <td>@{{ registro.nome_completo }}</td>
                                        <td style="color: @{{ registro.status_cor }}">@{{ registro.status_descricao }}</td>
                                        <td nowrap="nowrap">

                                            <a class="btn btn-sm btn-gray pull-right" href="/backoffice/chef/detalhes/@{{ registro.slug }}">
                                                <i class="fa fa-eye"></i>&nbsp; Ver Detalhes
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

    <script src="/admin/js/chefs/listar.vue.js"></script>

@endsection
