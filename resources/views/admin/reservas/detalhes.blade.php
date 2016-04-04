@extends('admin.template.layout')

@section('content')


    <body class="ui_charcoal" data-page="projects:new">
    <header class="header-expanded navbar navbar-fixed-top navbar-gitlab">
        <div class="container-fluid">
            <div class="header-content">
                @include('admin.includes.topo_formulario')
                <h1 class="title">Detalhes da Reserva</h1>
            </div>
        </div>
    </header>
    <div class="page-sidebar-expanded page-with-sidebar">

        @include("admin.includes.menu")

        <div class="content-wrapper" id="tipo_culinaria">
            <div class="container-fluid container-limited">
                <div class="content">
                    <div class="clearfix">

                        <div class="prepend-top-default"></div>

                        <form class="form-horizontal"
                              accept-charset="UTF-8"
                              onsubmit="return false;"
                              method="POST">

                            {!! csrf_field() !!}

                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label class="block-label" for="id_tipo_refeicao">Código</label>
                                    <input value="{{ $reserva->id_reserva }}" class="form-control" readonly
                                           type="text" name="id_reserva">
                                </div>
                                
                                <div class="col-sm-4">
                                    <label class="block-label" for="id_tipo_refeicao">Nome do Chef</label>
                                    <input value="{{ $reserva->chef_nome }}" class="form-control" readonly
                                           type="text" name="chef_nome">
                                </div>

                                <div class="col-sm-4">
                                    <label class="block-label" for="id_tipo_refeicao">Nome do Cliente</label>
                                    <input value="{{ $reserva->nome_cliente }}" class="form-control" readonly
                                           type="text" name="nome_cliente">
                                </div>

                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_proprietario_conta">Data Reserva</label>
                                    <input value="{{ $reserva->data_reserva }} {{ $reserva->horario_reserva }}" class="form-control" readonly
                                           type="text" name="data">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="block-label" for="banco_proprietario_conta">Email do Chef</label>
                                    <input value="{{ $reserva->chef_email }}" class="form-control" readonly
                                           type="text" name="chef_email">
                                </div>
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_proprietario_conta">Telefone Chef</label>
                                    <input value="{{ $reserva->chef_telefone }}" class="form-control" readonly
                                           type="text" name="chef_telefone">
                                </div>
                                <div class="col-sm-4">
                                    <label class="block-label" for="banco_proprietario_conta">Email do Cliente</label>
                                    <input value="{{ $reserva->email_cliente }}" class="form-control" readonly
                                           type="text" name="email_cliente">
                                </div>
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_proprietario_conta">Telefone Chef</label>
                                    <input value="{{ $reserva->chef_telefone }}" class="form-control" readonly
                                           type="text" name="chef_telefone">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_agencia">Reservado para</label>
                                    <input required readonly value="{{ $reserva->qtd_clientes }} {{ $reserva->qtd_clientes == 1 ? 'pessoa' : 'pessoas' }}" class="form-control"
                                           type="text" name="qtd_clientes">
                                </div>

                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_agencia_digito">Preço por Cliente</label>
                                    <input readonly value="R$ {{ formatar_monetario($reserva->preco_por_cliente) }}" class="form-control"
                                           type="text" name="preco_por_cliente">
                                </div>

                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_agencia_digito">Taxa LMB</label>
                                    <input value="R$ {{ formatar_monetario($reserva->taxa_lmb) }}" readonly class="form-control"
                                           type="text" name="taxa_lmb">
                                </div>

                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">Preço Total</label>
                                    <input readonly required value="R$ {{ formatar_monetario($reserva->preco_total) }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>

                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">Valor Divisão LMB</label>
                                    <input readonly required value="R$ {{ formatar_monetario($reserva->vlr_divisao_lmb) }}" class="form-control"
                                           type="text" name="vlr_divisao_lmb">
                                </div>

                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">Valor Divisão Chef</label>
                                    <input readonly required value="R$ {{ formatar_monetario($reserva->vlr_divisao_chef) }}" class="form-control"
                                           type="text" name="vlr_divisao_chef">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">Reserva Status</label>
                                    <input readonly required value="{{ $reserva->reserva_status }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">Produto Reservado</label>
                                    <input readonly required value="{{ $reserva->produto_tipo }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>
                                <div class="col-sm-4">
                                    <label class="block-label" for="banco_conta">Título do {{ $reserva->produto_tipo }}</label>
                                    <input readonly required value="{{ $reserva->titulo_produto }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">Preço do {{ $reserva->produto_tipo }}</label>
                                    <input readonly required value="R$ {{ formatar_monetario($reserva->preco_produto) }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-gray topmargin-md" target="_blank" href="/chef/{{ $reserva->chef_slug }}/{{ strtolower($reserva->produto_tipo) }}/{{ $reserva->slug_produto }}">
                                        <i class="fa fa-eye rightmargin-xsm"></i> Ver {{ $reserva->produto_tipo }}
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="block-label" for="banco_conta">Status Pagamento</label>
                                    <input readonly required value="{{ $reserva->pagamento_status }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">Bandeira Pagamento</label>
                                    <input readonly required value="{{ $reserva->pagamento_bandeira }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">Número Cartão</label>
                                    <input readonly required value="{{ $reserva->pagamento_numero_cartao }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>
                                <div class="col-sm-4">
                                    <label class="block-label" for="banco_conta">Titular Pagamento</label>
                                    <input readonly required value="{{ $reserva->pagamento_titular_cartao }}" class="form-control"
                                           type="text" name="preco_total">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label class="block-label" for="banco_conta">Endereço</label>
                                    <input readonly required value="{{ $reserva->logradouro }}" class="form-control"
                                           type="text" name="logradouro">
                                </div>
                                <div class="col-sm-1">
                                    <label class="block-label" for="banco_conta">Número</label>
                                    <input readonly required value="{{ $reserva->logradouro_numero }}" class="form-control"
                                           type="text" name="logradouro">
                                </div>
                                <div class="col-sm-2">
                                    <label class="block-label" for="banco_conta">CEP</label>
                                    <input readonly required value="{{ $reserva->cep }}" class="form-control"
                                           type="text" name="logradouro">
                                </div>
                                <div class="col-sm-3">
                                    <label class="block-label" for="banco_conta">Bairro</label>
                                    <input readonly required value="{{ $reserva->bairro }}" class="form-control"
                                           type="text" name="bairro">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="block-label" for="nome_cidade">Cidade</label>
                                    <input readonly required value="{{ $reserva->nome_cidade }}" class="form-control"
                                           type="text" name="nome_cidade">
                                </div>
                                <div class="col-sm-4">
                                    <label class="block-label" for="nome_estado">Estado</label>
                                    <input readonly required value="{{ $reserva->nome_estado }}" class="form-control"
                                           type="text" name="nome_estado">
                                </div>
                                <div class="col-sm-4">
                                    <label class="block-label" for="nome_pais">País</label>
                                    <input readonly required value="{{ $reserva->nome_pais }}" class="form-control"
                                           type="text" name="nome_pais">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="block-label" for="data_criacao_reserva">Data em que a reserva foi efetuada</label>
                                    <input readonly required value="{{ $reserva->datahora_criacao_reserva }}" class="form-control"
                                           type="text" name="data_criacao_reserva">
                                </div>
                            </div>

                            <div class="form-actions">
                                <a class="btn btn-gray" href="{{ route('backoffice.reserva.listar') }}">
                                    <i class="fa fa-list-alt rightmargin-xsm"></i> Voltar para a listagem de reservas
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
