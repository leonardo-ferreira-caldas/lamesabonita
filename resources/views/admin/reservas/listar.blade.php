@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Reservas</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="reserva" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="issues-details-filters gray-content-block">
                            <form class="filter-form" action="/dashboard/merge_requests?scope=all&amp;sort=id_desc&amp;state=opened" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                <div class="row">
                                    <div class="col-md-2 norightpadding">
                                        <label class="block-label">Status Reserva</label>
                                        <select v-model="filtro_status_reserva" class="form-control">
                                            <option value="">Todos</option>
                                            @foreach ($status_reserva as $sr)
                                                <option value="{{ $sr->id_reserva_status }}">{{ $sr->nome_status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 norightpadding">
                                        <label class="block-label">Status Pagamento</label>
                                        <select v-model="filtro_status_pagamento" class="form-control">
                                            <option value="">Todos</option>
                                            @foreach ($status_pagamento as $sp)
                                                <option value="{{ $sp->id_pagamento_status }}">{{ $sp->nome_pagamento_status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 norightpadding">
                                        <label class="block-label">Busca por chef</label>
                                        <input type="text" id="filter_projects"
                                               placeholder="Digite o nome do chef..."
                                               v-model="filtro_chef"
                                               class="projects-list-filter form-control" spellcheck="false">
                                    </div>
                                    <div class="col-md-3 norightpadding">
                                        <label class="block-label">Busca por cliente</label>
                                        <input type="text" id="filter_projects"
                                               placeholder="Digite o nome do cliente..."
                                               v-model="filtro_cliente"
                                               class="projects-list-filter form-control" spellcheck="false">
                                    </div>

                                </div>
                            </form>

                        </div>

                        <div class="table-holder topmargin-sm bottompadding-lg">
                            <table class="table">
                                <thead class="panel-heading">
                                <tr>
                                    <th>Chef</th>
                                    <th>Cliente</th>
                                    <th>Reservado para</th>
                                    <th>Valor</th>
                                    <th>Status Reserva</th>
                                    <th>Status Pagamento</th>
                                    <th nowrap="nowrap"></th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr v-show="registros.length == 0">
                                        <td colspan="6" align="center">Nenhuma reserva encontrado.</td>
                                    </tr>

                                    <tr v-for="reserva in registros
                                    | filterBy filtro_cliente in 'nome_cliente'
                                    | filterBy filtro_chef in 'chef_nome_completo'
                                    | filterBy filtro_status_reserva in 'id_reserva_status'
                                    | filterBy filtro_status_pagamento in 'id_pagamento_status'">

                                        <td>@{{ reserva.chef_nome_completo }}</td>
                                        <td>@{{ reserva.nome_cliente }}</td>
                                        <td>@{{ reserva.data_reserva }} @{{ reserva.horario_reserva }}</td>
                                        <td>R$ @{{ reserva.preco_total }}</td>
                                        <td>@{{ reserva.status_reserva }}</td>
                                        <td class="@{{ reserva.class_status_pagamento }}">@{{ reserva.nome_pagamento_status }}</td>
                                        <td nowrap="nowrap">

                                            <a class="btn btn-sm btn-gray pull-right" href="/backoffice/reservas/detalhes/@{{ reserva.id_reserva }}">
                                                <i class="fa fa-eye"></i>&nbsp; Detalhes
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

    <script src="/admin/js/reservas/listar.vue.js"></script>

@endsection
