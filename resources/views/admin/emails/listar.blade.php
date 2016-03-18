@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Emails</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="emails" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="issues-details-filters gray-content-block">
                            <form class="filter-form" action="/dashboard/merge_requests?scope=all&amp;sort=id_desc&amp;state=opened" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                <div class="row">

                                    <div class="col-md-3 norightpadding">
                                        <label class="block-label">De</label>
                                        <input type="text" id="filter_projects"
                                           placeholder="Digite o nome ou email..."
                                           v-model="filtro_de"
                                           class="projects-list-filter form-control" spellcheck="false">
                                    </div>

                                    <div class="col-md-3 norightpadding">
                                        <label class="block-label">Para</label>
                                        <input type="text" id="filter_projects"
                                           placeholder="Digite o nome ou email..."
                                           v-model="filtro_para"
                                           class="projects-list-filter form-control" spellcheck="false">
                                    </div>

                                    <div class="col-md-3 norightpadding">
                                        <label class="block-label">Assunto</label>
                                        <input type="text" id="filter_projects"
                                           placeholder="Digite o assunto..."
                                           v-model="filtro_assunto"
                                           class="projects-list-filter form-control" spellcheck="false">
                                    </div>

                                    <div class="col-md-2 norightpadding">
                                        <label class="block-label">Enviado?</label>
                                        <select v-model="filtro_enviado" class="form-control">
                                            <option value=''>Todos</option>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <div class="table-holder topmargin-sm bottompadding-lg">

                            <table class="table">
                                <thead class="panel-heading">
                                <tr>
                                    <th>De</th>
                                    <th>Para</th>
                                    <th>Assunto</th>
                                    <th>Enviado?</th>
                                    <th>Data Envio</th>
                                    <th nowrap="nowrap"></th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr v-show="registros.length == 0">
                                        <td colspan="6" align="center">Nenhuma conta bancária encontrado.</td>
                                    </tr>

                                    <tr v-for="email in registros
                                        | filterBy filtro_de in 'de_nome' 'de_email'
                                        | filterBy filtro_para in 'para_nome' 'para_email'
                                        | filterBy filtro_assunto in 'assunto'
                                        | filterBy filtro_enviado in 'ind_enviado'
                                    ">
                                        <td>@{{ email.de_nome }} <@{{ email.de_email }}></td>
                                        <td>@{{ email.para_nome }} <@{{ email.para_email }}></td>
                                        <td>@{{ email.assunto }}</td>
                                        <td style="color: @{{ email.ind_enviado == 1 ? 'green' : 'red'}}">@{{ email.ind_enviado == 1 ? 'Sim' : 'Não' }}</td>
                                        <td nowrap="nowrap">@{{ email.data_envio | data }}</td>
                                        <td nowrap="nowrap">

                                            <a title="Ver Detalhes" class="btn btn-sm btn-gray pull-right" href="/backoffice/email/detalhes/@{{ email.id_email }}">
                                                <i class="fa fa-eye fa-fw"></i>
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

    <script src="/admin/js/email/listar.vue.js"></script>

@endsection
