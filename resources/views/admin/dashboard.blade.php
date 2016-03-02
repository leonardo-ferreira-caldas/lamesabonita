@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">

    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Dashboard</h1>
            </div>
        </div>
    </header>

    <div class="page-sidebar-expanded page-with-sidebar bottompadding-lg">

        @include("admin.includes.menu")

        <div class="prepend-top-default"></div>

        <div class="leftpadding-md rightpadding-md">

            <div class="gray-border" style="border-top: 2px solid #526CAF;">

                <div class="gray-content-block top-block allpadding-xsm"">
                    <h5 class="center">Chef's aguardando aprovação de perfil da equipe</h5>
                </div>

                <div class="table-holder">
                    <table class="table nobottompadding nobottommargin">
                        <thead class="panel-heading">
                        <tr>
                            <th>Cód</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">

                        @if(count($chefs) == 0)

                        <tr>
                            <td colspan="5" align="center">Nenhum chef aguardando aprovação do perfil.</td>
                        </tr>

                        @else

                            @foreach($chefs as $chef)

                            <tr>
                                <td>{{ $chef->id_chef }}</td>
                                <td>{{ $chef->nome_completo }}</td>
                                <td>{{ $chef->email }}</td>
                                <td>{{ $chef->telefone }}</td>
                                <td>

                                    <a class="btn btn-sm btn-gray pull-right" target="_blank" href="{{ route('backoffice.chef.detalhes', ['slug' => $chef->slug]) }}">
                                        <i class="fa fa-eye"></i> Detalhes
                                    </a>

                                </td>
                            </tr>

                            @endforeach

                        @endif

                        </tbody>
                    </table>

                </div>

            </div>

        </div>

        <div class="row topmargin-md rightmargin-md leftmargin-md">

            <div class="col-md-6 rightpadding-xsm noleftpadding">

                <div class="gray-border" style="border-top: 2px solid #526CAF;">

                    <div class="gray-content-block top-block allpadding-xsm">
                        <h5 class="center">Menus aguardando aprovação</h5>
                    </div>

                    <div class="table-holder">
                        <table class="table nobottommargin nobottompadding">
                            <thead class="panel-heading">
                            <tr>
                                <th>Título</th>
                                <th>Preço</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">

                            @if(count($menus) == 0)

                                <tr>
                                    <td colspan="3" align="center">Nenhum menu aguardando aprovação.</td>
                                </tr>

                            @else

                                @foreach($menus as $menu)

                                    <tr>
                                        <td>{{ $menu->titulo }}</td>
                                        <td>R$ {{ $menu->preco }}</td>
                                        <td>

                                            <a class="btn btn-sm btn-gray pull-right" target="_blank" href="{{ route('backoffice.menu.editar', ['slug' => $menu->slug]) }}">
                                                <i class="fa fa-eye"></i> Detalhes
                                            </a>

                                        </td>
                                    </tr>

                                @endforeach

                            @endif

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

            <div class="col-md-6 leftpadding-xsm norightpadding">

                <div class="gray-border" style="border-top: 2px solid #526CAF;">

                    <div class="gray-content-block top-block allpadding-xsm">
                        <h5 class="center">Cursos aguardando aprovação</h5>
                    </div>

                    <div class="table-holder">
                        <table class="table nobottompadding nobottommargin">
                            <thead class="panel-heading">
                            <tr>
                                <th>Título</th>
                                <th>Preço</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">

                            @if(count($cursos) == 0)

                                <tr>
                                    <td colspan="3" align="center">Nenhum curso aguardando aprovação.</td>
                                </tr>

                            @else

                                @foreach($cursos as $curso)

                                    <tr>
                                        <td>{{ $curso->titulo }}</td>
                                        <td>R$ {{ $curso->preco }}</td>
                                        <td>

                                            <a class="btn btn-sm btn-gray pull-right" target="_blank" href="{{ route('backoffice.curso.editar', ['slug' => $curso->slug]) }}">
                                                <i class="fa fa-eye"></i> Detalhes
                                            </a>

                                        </td>
                                    </tr>

                                @endforeach

                            @endif

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="prepend-top-default"></div>

        <div class="leftpadding-md rightpadding-md topmargin-md">

            <div class="gray-border" style="border-top: 2px solid #526CAF;">

                <div class="gray-content-block top-block allpadding-xsm">
                    <h5 class="center">Comentários/Avaliações aguardando aprovação</h5>
                </div>

                <div class="table-holder">
                    <table class="table nobottompadding nobottommargin">
                        <thead class="panel-heading">
                        <tr>
                            <th>Comentário/Texto</th>
                            <th>Avaliação</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">

                        @if(count($avaliacoes) == 0)

                            <tr>
                                <td colspan="3" align="center">Nenhuma avaliação aguardando aprovação.</td>
                            </tr>

                        @else

                            @foreach($avaliacoes as $avaliacao)

                                <tr>
                                    <td>{{ $avaliacao->texto }}</td>
                                    <td>{{ $avaliacao->nota }}</td>
                                    <td>

                                        <a class="btn btn-sm btn-danger pull-right leftmargin-sm" href="{{ route('admin.avaliacao.reprovar', ['id' => $avaliacao->id_avaliacao]) }}">
                                            <i class="fa fa-times"></i> Reprovar
                                        </a>

                                        <a class="btn btn-sm btn-success pull-right" href="{{ route('admin.avaliacao.aprovar', ['id' => $avaliacao->id_avaliacao]) }}">
                                            <i class="fa fa-check"></i> Aprovar
                                        </a>

                                    </td>
                                </tr>

                            @endforeach

                        @endif

                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>

    </body>

@endsection
