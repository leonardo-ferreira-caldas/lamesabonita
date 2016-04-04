@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')

                <a class="btn btn-success pull-right rightmargin-sm topmargin-sm" href="{{ route('backoffice.chef.novo_registro') }}">
                    <i class="fa fa-plus"></i>&nbsp;
                    Adicionar Novo Chef
                </a>

                <h1 class="title">Chefs</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="tipo_culinaria">
            <div class="container-fluid container-limited container-bg-light">
                <div class="content">
                    <div class="clearfix">

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal"
                              action="{{ route('backoffice.chef.salvar') }}"
                              accept-charset="UTF-8"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label class="block-label">Código</label>
                                    <input readonly class="form-control" name="id_chef" type="text" value="{{ $chef->id_chef }}">
                                </div>
                                <div class="col-sm-3">
                                    <label class="block-label">Nome</label>
                                    <input required class="form-control" type="text" name="name" value="{{ $chef->nome }}">
                                </div>
                                <div class="col-sm-3">
                                    <label class="block-label">Sobrenome</label>
                                    <input required class="form-control" type="text" name="sobrenome" value="{{ $chef->sobrenome }}">
                                </div>
                                <div class="col-sm-4">
                                    <label class="block-label">Email</label>
                                    <input required class="form-control" type="text" name="email" value="{{ $chef->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="block-label">Saldo</label>
                                    <input readonly class="form-control" type="text" value="R$ {{ $chef->saldo }}">
                                </div>

                                <div class="col-sm-3">
                                    <label class="block-label">CPF</label>
                                    <input required id="cpf" class="form-control" name="cpf" type="text" value="{{ $chef->cpf }}">
                                </div>

                                <div class="col-sm-3">
                                    <label class="block-label">RG</label>
                                    <input required class="form-control" name="rg" type="text" value="{{ $chef->rg }}">
                                </div>
                                <div class="col-sm-3">
                                    <label class="block-label">Telefone</label>
                                    <input required class="form-control" name="telefone" type="text" value="{{ $chef->telefone }}">
                                </div>

                            </div>
                            <div class="form-group">

                                <div class="col-sm-2">
                                    <label class="block-label">Data de Nascimento</label>
                                    <input required name="data_nascimento" id="data_nascimento" class="form-control" type="text" value="{{ $chef->data_nascimento }}">
                                </div>

                                <div class="col-sm-2">
                                    <label class="block-label">Sexo</label>
                                    <select class="form-control" name="fk_sexo" required>
                                        @foreach($sexos as $sexo)
                                            <option {{ $sexo->id_sexo == $chef->fk_sexo ? 'selected' : '' }} value="{{ $sexo->id_sexo }}">{{ $sexo->descricao }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-5">
                                    <label class="block-label">Status Perfil</label>
                                    <select disabled class="form-control" name="fk_status" required>
                                        @foreach($status as $s)
                                            <option {{ $s->id_chef_status == $chef->fk_status ? 'selected' : '' }} value="{{ $s->id_chef_status }}">{{ $s->descricao }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label class="block-label">Status Selo La Mesa Bonita</label>
                                    <select disabled class="form-control" name="fk_selo_status" required>
                                        @foreach($selo as $statusSelo)
                                            <option {{ $statusSelo->id_selo_status == $chef->fk_selo_status ? 'selected' : '' }} value="{{ $statusSelo->id_selo_status }}">
                                                {{ $statusSelo->descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label class="block-label">Endereço</label>
                                    <input class="form-control" name="logradouro" type="text" value="{{ $chef->logradouro }}">
                                </div>
                                <div class="col-sm-2">
                                    <label class="block-label">Número</label>
                                    <input class="form-control" name="logradouro_numero" type="text" value="{{ $chef->logradouro_numero }}">
                                </div>
                                <div class="col-sm-4">
                                    <label class="block-label">Bairro</label>
                                    <input class="form-control" name="bairro" type="text" value="{{ $chef->bairro }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="block-label">CEP</label>
                                    <input id="cep" name="cep" class="form-control" type="text" value="{{ $chef->cep }}">
                                </div>
                                <div class="col-sm-3">
                                    <label class="block-label">País</label>
                                    <input class="form-control" readonly type="text" value="{{ $chef->pais }}">
                                </div>
                                <div class="col-sm-3">
                                    <label class="block-label">Estado</label>
                                    <select class="form-control" name="fk_estado" id="fk_estado" required>
                                        @foreach($estados as $estado)
                                            <option {{ $chef->fk_estado == $estado->id_estado ? 'selected' : '' }} value="{{ $estado->id_estado }}">
                                                {{ $estado->nome_estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="block-label">Cidade</label>
                                    <select class="form-control" name="fk_cidade" id="fk_cidade" required>
                                        @foreach($cidades as $cidade)
                                            <option {{ $chef->fk_cidade == $cidade->id_cidade ? 'selected' : '' }} value="{{ $cidade->id_cidade }}">
                                                {{ $cidade->nome_cidade }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="block-label">Sobre o chef</label>
                                    <textarea class="form-control" name="sobre_chef" cols="30" rows="7">{{ $chef->sobre_chef }}</textarea>
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


                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o rightmargin-xsm"></i> Salvar
                                </button>

                                @if (isset($registro->id_incluso_preco))

                                <a class="btn btn-remove btn-delete leftmargin-sm"
                                   href="/backoffice/cadastro/incluso_preco/deletar?id={{ $registro->id_incluso_preco }}"><i
                                            class="fa fa-trash-o"></i> Remover</a>

                                @endif

                                <a class="btn btn-cancel btn-gray" href="{{ route('backoffice.chef.detalhes', ['slug' => $chef->slug]) }}">
                                    <i class="fa fa-list-alt rightmargin-xsm"></i> Ver Detalhes
                                </a>

                                <a class="btn btn-cancel btn-gray rightmargin-sm" href="{{ route('backoffice.chef.listar') }}">
                                    <i class="fa fa-list-alt rightmargin-xsm"></i> Ver Todos Chefs
                                </a>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/jquery.mask.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#data_nascimento").mask('99/99/9999');
            $("#cpf").mask('999.999.999-99');
            $("#cep").mask('99999-999');
            $("#fk_estado").change(function() {
                $("#fk_cidade").attr('readonly', true).html("<option value=''>Carregando...</option>");

                $.ajax({
                    url: '/backoffice/chef/buscar_cidade/' + $(this).val(),
                    method: 'GET',
                    dataType: 'json',
                    success: function(sucesso) {
                        $("#fk_cidade").attr('readonly', false).html('');

                        for (var i in sucesso) {
                            $("#fk_cidade").append("<option value='" + sucesso[i].id_cidade + "'>" + sucesso[i].nome_cidade + "</option>");
                        }
                    }
                });

            });
        });
    </script>

@endsection
