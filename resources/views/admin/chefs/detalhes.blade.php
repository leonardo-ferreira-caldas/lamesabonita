@extends('admin.template.layout')

    @section('head.css')
        <link rel="stylesheet" href="/css/calendar.css" type="text/css" />
        <link rel="stylesheet" href="/css/tipped.css" type="text/css" />
    @endsection

    @section('content')

    <body class="ui_charcoal" data-page="projects:new">

        <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
            <div class="container-fluid">
                <div class="header-content">
                    @include('admin.includes.topo_formulario')
                    <h1 class="title">{{ $chef->nome_completo }}</h1>
                </div>
            </div>
        </header>

        <div class="page-sidebar-expanded page-with-sidebar">

            @include("admin.includes.menu")

            <div class="content-wrapper">
                <div>
                    <div class="content">
                        <div class="clearfix">

                            <div class="cover-block">
                                @if($aguardando_aprovacao)
                                    <div class="cover-controls left">
                                        <a class="btn btn-success" href="{{ route('backoffice.chef.aprovar', ['slug' => $chef->slug]) }}">
                                            <i class="fa fa-check"></i>&nbsp;
                                            Aprovar Perfil
                                        </a>&nbsp;&nbsp;
                                        <a class="btn btn-danger" href="{{ route('backoffice.chef.reprovar', ['slug' => $chef->slug]) }}">
                                            <i class="fa fa-times"></i>&nbsp;
                                            Reprovar Perfil
                                        </a>
                                    </div>
                                @endif
                                <div class="cover-controls">
                                    <a class="btn btn-gray" href="{{ route('backoffice.chef.listar') }}">
                                        <i class="fa fa-arrow-left"></i>&nbsp;
                                        Ver Todos Chefs
                                    </a>&nbsp;&nbsp;
                                    <a class="btn btn-gray" href="{{ route('backoffice.chef.editar', ['slug' => $chef->slug]) }}">
                                        <i class="fa fa-pencil"></i>&nbsp; Editar Informações
                                    </a>&nbsp;&nbsp;
                                    <a class="btn btn-gray" target="_blank" href="/chef/{{ $chef->slug }}/perfil">
                                        <i class="fa fa-eye"></i>&nbsp; Ver Perfil
                                    </a>
                                </div>
                                <div class="avatar-holder">
                                    <img class="avatar s160" src="{{ crop($chef->avatar, 160, 160) }}">
                                </div>
                                <div>
                                    <a class="btn btn-gray" target="_blank" href="{{ route('backoffice.chef.alterar_fotos', ['slug' => $chef->slug]) }}">
                                        <i class="fa fa-picture-o"></i>&nbsp; Alterar Foto Perfil e Capa
                                    </a>
                                </div>
                                <div class="cover-title">
                                    {{ $chef->nome_completo }}
                                </div>
                                <div class="cover-desc">
                                <span>
                                   Status: <span style="color: {{ $chef->cor_texto }}">{{ $chef->status }}</span>
                                </span>
                                </div>
                                <div class="cover-desc">
                                <span>
                                    Cadastrado em: {{ $chef->cadastrado_em }}
                                </span>
                                </div>

                                <div class="cover-desc">
                                    <div class="profile-link-holder">
                                        <a href="mailto:{{ $chef->email }}">{{ $chef->email }}</a>
                                    </div>
                                </div>

                                <ul class="nav-links center">
                                    <li class="active">
                                        <a href="#visao_geral">
                                            Visão Geral
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#menus">
                                            Menus
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#cursos">
                                            Cursos
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#contas_bancarias">
                                            Contas Bancárias
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#agenda">
                                            Agenda
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="container-fluid container-limited">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="visao_geral">

                                        <div class="form-horizontal toppadding-md bottompadding-lg rightpadding-sm leftpadding-sm">

                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="block-label">Nome</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->nome }}">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="block-label">Sobrenome</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->sobrenome }}">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="block-label">Email</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->email }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="block-label">Saldo</label>
                                                    <input readonly class="form-control" type="text" value="R$ {{ $chef->saldo }}">
                                                </div>

                                                <div class="col-sm-3">
                                                    <label class="block-label">CPF</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->cpf }}">
                                                </div>

                                                <div class="col-sm-3">
                                                    <label class="block-label">RG</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->rg }}">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="block-label">Telefone</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->telefone }}">
                                                </div>

                                            </div>
                                            <div class="form-group">

                                                <div class="col-sm-2">
                                                    <label class="block-label">Data de Nascimento</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->data_nascimento }}">
                                                </div>

                                                <div class="col-sm-2">
                                                    <label class="block-label">Sexo</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->sexo_descricao }}">
                                                </div>

                                                <div class="col-sm-5">
                                                    <label class="block-label">Status Perfil</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->status }}">
                                                </div>

                                                <div class="col-sm-3">
                                                    <label class="block-label">Status Selo La Mesa Bonita</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->status_selo }}">
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <label class="block-label">Endereço</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->logradouro }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="block-label">Bairro</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->bairro }}">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="block-label">Número</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->logradouro_numero }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="block-label">CEP</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->cep }}">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="block-label">País</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->pais }}">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="block-label">Estado</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->estado }}">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="block-label">Cidade</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->cidade }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label class="block-label">Sobre o chef</label>
                                                    <textarea readonly class="form-control" name="sobre_chef" cols="30" rows="7">{{ $chef->sobre_chef }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <label class="block-label">Moip Id</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->moip_id }}">
                                                </div>
                                                <div class="col-sm-5">
                                                    <label class="block-label">Moip Login</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->moip_login }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="block-label">Moip Data Cadastro</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->moip_data_cadastro }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label class="block-label">Moip Token</label>
                                                    <input readonly class="form-control" type="text" value="{{ $chef->moip_access_token }}">
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="tab-pane" id="menus">

                                    <div class="table-holder topmargin-sm bottompadding-lg">
                                        <table class="table">
                                            <thead class="panel-heading">
                                            <tr>
                                                <th>Foto Capa</th>
                                                <th>Cód</th>
                                                <th>Titulo</th>
                                                <th>Preço</th>
                                                <th>Ativo</th>
                                                <th>Status</th>
                                                <th nowrap="nowrap"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if (count($menus) == 0)

                                                <tr>
                                                    <td colspan="7" align="center">Nenhum menu cadastrado para este chef.</td>
                                                </tr>

                                            @else

                                                @foreach ($menus as $menu)

                                                    <tr>
                                                        <td><img class="avatar project-avatar s46" src="{{ crop($menu->foto_capa, 46, 46) }}"></td>
                                                        <td>{{ $menu->id_menu }}</td>
                                                        <td>{{ $menu->titulo }}</td>
                                                        <td>R$ {{ $menu->preco }}</td>
                                                        <td style="color: {{ $menu->ativo_cor }}">{{ $menu->ativo_descricao }}</td>
                                                        <td style="color: {{ $menu->cor_status }}">{{ $menu->descricao_status }}</td>
                                                        <td nowrap="nowrap">

                                                            <a class="btn btn-sm btn-gray pull-right" target="_blank" href="{{ route('backoffice.menu.editar', ['slug' => $menu->slug]) }}">
                                                                <i class="fa fa-info-circle"></i>&nbsp; Ver Detalhes
                                                            </a>

                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane" id="cursos">

                                    <div class="table-holder topmargin-sm bottompadding-lg">
                                        <table class="table">
                                            <thead class="panel-heading">
                                            <tr>
                                                <th>Foto Capa</th>
                                                <th>Cód</th>
                                                <th>Titulo</th>
                                                <th>Preço</th>
                                                <th>Ativo</th>
                                                <th>Status</th>
                                                <th nowrap="nowrap"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if (count($cursos) == 0)

                                                <tr>
                                                    <td colspan="7" align="center">Nenhum curso cadastrado para este chef.</td>
                                                </tr>

                                            @else

                                                @foreach ($cursos as $curso)

                                                    <tr>
                                                        <td><img class="avatar project-avatar s46" src="{{ crop($curso->foto_capa, 46, 46) }}"></td>
                                                        <td>{{ $curso->id_curso }}</td>
                                                        <td>{{ $curso->titulo }}</td>
                                                        <td>R$ {{ $curso->preco }}</td>
                                                        <td style="color: {{ $curso->ativo_cor }}">{{ $curso->ativo_descricao }}</td>
                                                        <td style="color: {{ $curso->cor_status }}">{{ $curso->descricao_status }}</td>
                                                        <td nowrap="nowrap">

                                                            <a class="btn btn-sm btn-gray pull-right" target="_blank" href="{{ route('backoffice.curso.editar', ['slug' => $curso->slug]) }}">
                                                                <i class="fa fa-info-circle"></i>&nbsp; Ver Detalhes
                                                            </a>

                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif


                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane" id="contas_bancarias">

                                    <div class="table-holder topmargin-sm bottompadding-lg">
                                        <table class="table">
                                            <thead class="panel-heading">
                                            <tr>
                                                <th>Cód</th>
                                                <th>Banco</th>
                                                <th>Agência</th>
                                                <th>Conta</th>
                                                <th nowrap="nowrap"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if (count($contas_bancarias) == 0)

                                                <tr>
                                                    <td colspan="5" align="center">Nenhuma conta bancária cadastrada para este chef.</td>
                                                </tr>

                                            @else

                                                @foreach ($contas_bancarias as $contaBancaria)

                                                    <tr>
                                                        <td>{{ $contaBancaria->id_conta_bancaria }}</td>
                                                        <td>{{ $contaBancaria->banco_descricao }}</td>
                                                        <td>{{ $contaBancaria->agencia_descricao }}</td>
                                                        <td>{{ $contaBancaria->conta_descricao }}</td>
                                                        <td nowrap="nowrap">

                                                            <a
                                                                class="btn btn-sm btn-gray pull-right"
                                                                target="_blank"
                                                                href="{{ route('backoffice.conta_bancaria.editar', ['id' => $contaBancaria->id_conta_bancaria]) }}">
                                                                <i class="fa fa-info-circle"></i>&nbsp; Ver Detalhes
                                                            </a>

                                                        </td>
                                                    </tr>

                                                @endforeach

                                            @endif

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane" id="agenda">

                                    <div class="events-calendar">
                                        <div class="events-calendar-header clearfix">
                                            <h3 class="calendar-month-year">
                                                <span id="calendar-month" class="calendar-month"></span>
                                                <span id="calendar-year" class="calendar-year"></span>
                                                <nav>
                                                    <span id="calendar-prev" class="calendar-prev"><i class="fa fa-arrow-left"></i></span>
                                                    <span id="calendar-next" class="calendar-next"><i class="fa fa-arrow-right"></i></span>
                                                </nav>
                                            </h3>
                                        </div>
                                        <div id="calendar" class="fc-calendar-container"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>

        <script src="/admin/js/chefs/detalhes.js" type="text/javascript"></script>
        <script type="text/javascript" src="/js/jquery.calendario.js"></script>
        <script type="text/javascript" src="/js/tipped.js"></script>

        <script type="text/javascript">

            var schedules = {};
            var sch       = {!! $agenda !!};
            var idChef    = "{{ $chef->id_chef }}";

            for (var i in sch) {
                var from = sch[i].hora_de + (parseInt(sch[i].hora_de_hora) <= 12 ? ' a.m' : ' p.m');
                var to   = sch[i].hora_ate   + (parseInt(sch[i].hora_ate_hora) <= 12   ? ' a.m' : ' p.m');

                schedules[sch[i].data] = "<div class='schedule' data-from='" + sch[i].hora_de_hora + "' data-to='" + sch[i].hora_ate_hora + "' data-id='" + sch[i].id_chef_agenda + "'>De: " + from + "<br>Até: " + to + "</div>";

            }

        </script>

        <script type="text/javascript" src="/admin/js/chefs/calendar.js"></script>

        <div id="template-horario">
            <form method="" class="template-horario-agenda">
                <div class="col_full">
                    <label for="horario">Disponível de:</label>
                    <div class="input-icon-left">
                        <select required type="text" id="horario_de" name="horario_ate" class="form-control required">
                            @for($i=7;$i<=22;$i++)
                                <option
                                        value='{{str_pad($i, 2, '0', STR_PAD_LEFT)}}'
                                >{{str_pad($i, 2, '0', STR_PAD_LEFT)}}:00</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="clear"></div>

                <div class="col_full topmargin-sm">
                    <label for="horario">Até:</label>
                    <div class="input-icon-left">
                        <select required type="text" id="horario_ate" name="horario_ate" class="form-control required">
                            @for($i=7;$i<=22;$i++)
                                <option
                                        value='{{str_pad($i, 2, '0', STR_PAD_LEFT)}}'
                                        {{ $i == 22 ? 'selected' : '' }}
                                >{{str_pad($i, 2, '0', STR_PAD_LEFT)}}:00</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="clear"></div>

                <div class="divider divider-center allmargin-sm"><i class="fa fa-cutlery"></i></div>

                <div class="col_full nomargin">
                    <button type="submit" class="save-agenda btn btn-success btn-full text-center button button-3d nomargin">
                        <i class="fa fa-check"></i> <span>Salvar</span></button>
                </div>
                <div class="clear"></div>

                <div class="col_full not-available topmargin-sm">
                    <button type="button" class="remover-agenda button-small btn btn-danger btn-full text-center button button-3d nomargin">
                        <i class="fa fa-trash-o"></i> Remover Agenda
                    </button>
                </div>

            </form>
        </div>

@endsection
