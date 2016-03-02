@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Tipos de Culinária</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")


        <div class="content-wrapper" id="tipo_culinaria" v-cloak>
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">
                        <div class="gray-content-block top-block">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="filter-item">
                                        <input v-model="filtro" type="text" placeholder="Pesquise culinárias..." class="search-input form-control ui-autocomplete-input" spellcheck="false" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="pull-right">
                                        <a class="btn btn-new" href="{{ route('cadastro.tipo_culinaria.inserir') }}">
                                            <i class="fa fa-plus"></i>
                                            &nbsp;Adicionar Nova Culinária
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
                                    <th>Nome Culinária</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-show="!culinarias.length">
                                    <td colspan="2" align="center">Nenhuma culinária encontrada.</td>
                                </tr>

                                <tr v-for="registro in registros | filterBy filtro">
                                    <td>@{{ registro.id_culinaria }}</td>
                                    <td>@{{ registro.nome_culinaria }}</td>
                                    <td>

                                        <a class="btn btn-sm btn-remove btn-delete pull-right leftmargin-sm"
                                           href="{{ route('cadastro.tipo_culinaria.deletar') }}?id=@{{ registro.id_culinaria }}"><i
                                                    class="fa fa-trash-o"></i> Remover</a>

                                        <a class="btn btn-sm btn-gray delete-key pull-right"
                                           href="{{ route('cadastro.tipo_culinaria.editar') }}?id=@{{ registro.id_culinaria }}"><i
                                                    class="fa fa-pencil"></i> Editar</a>

                                    </td>
                                </tr>

                                </tbody>
                            </table>

                            {{--<a class="btn btn-gray rightmargin-sm" v-on:click="page=(i+1)" :class="{'disabled': (i+1) == page}" href="#" v-for="i in pages">--}}
                                {{--@{{ i + 1 }}--}}
                            {{--</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/admin/js/cadastro/tipo_culinaria.vue.js"></script>

@endsection
