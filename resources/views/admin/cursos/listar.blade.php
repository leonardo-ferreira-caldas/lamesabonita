@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Cursos</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="cursos" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="issues-details-filters gray-content-block">
                            <form class="filter-form" action="/dashboard/merge_requests?scope=all&amp;sort=id_desc&amp;state=opened" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                <div class="row">
                                    <div class="col-md-2 norightpadding">
                                        <label class="block-label">Status</label>
                                        <select v-model="filtro_status" class="form-control">
                                            <option value="">Todos</option>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 norightpadding">
                                        <label class="block-label">Status</label>
                                        <select v-model="filtro_aprovado" class="form-control">
                                            <option value="">Todos</option>
                                            @foreach($status as $s)
                                                <option value="{{ $s->id_produto_status }}">{{ $s->descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 norightpadding">
                                        <label class="block-label">Busca por nome</label>
                                        <input type="search" name="filter_projects" id="filter_projects"
                                               placeholder="Digite o nome do curso..."
                                               v-model="filtro_nome"
                                               class="projects-list-filter form-control" spellcheck="false">
                                    </div>
                                    <div class="pull-right col-md-4 norightpadding">
                                        <div class="col-md-6 norightpadding">
                                            <label class="block-label">Ordenar por</label>
                                            <select v-model="ordem_campo" class="form-control">
                                                <option value="id_curso">Código</option>
                                                <option value="titulo">Titulo</option>
                                                <option value="preco">Preço</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="block-label">&nbsp;</label>
                                            <select v-model="ordem_dir" class="form-control">
                                                <option value="1">Crescente</option>
                                                <option value="-1">Decrescente</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                        <div class="table-holder topmargin-sm bottompadding-lg">
                            <table class="table">
                                <thead class="panel-heading">
                                <tr>
                                    <th>Cód</th>
                                    <th>Titulo</th>
                                    <th>Preço</th>
                                    <th>Ativo</th>
                                    <th>Status</th>
                                    <th nowrap="nowrap"></th>
                                </tr>
                                </thead>
                                <tbody>

                                    <tr v-show="registros.length == 0">
                                        <td colspan="6" align="center">Nenhum curso encontrado.</td>
                                    </tr>

                                    <tr v-for="curso in registros
                                        | filterBy filtro_nome in 'titulo'
                                        | filterBy filtro_status in 'ind_ativo'
                                        | filterBy filtro_aprovado in 'fk_status'
                                        | orderBy ordem_campo ordem_dir
                                    ">
                                        <td>@{{ curso.id_curso }}</td>
                                        <td>@{{ curso.titulo }}</td>
                                        <td>R$ @{{ curso.preco }}</td>
                                        <td style="color: @{{ curso.ind_ativo ? 'green' : 'red' }}">@{{ curso.ind_ativo ? 'Ativo' : 'Inativo' }}</td>
                                        <td style="color: @{{ curso.status_cor }}">
                                            @{{ curso.status_descricao }}
                                        </td>
                                        <td nowrap="nowrap">

                                            <a class="btn btn-sm btn-gray pull-right" target="_blank" href="/backoffice/curso/editar/@{{ curso.slug }}">
                                                <i class="fa fa-info-circle"></i>&nbsp; Ver Detalhes
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

    <script src="/admin/js/curso/listar.vue.js"></script>

@endsection
