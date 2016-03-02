@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite">
        <div class="fancy-title title-bottom-border">
            <h2>Detalhes da Reservas</h2>
        </div>
        <div class="my-profile">
            <div class="col_half">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>Informações</h3>
                </div>
                <ul>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Cód Reserva</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->id_reserva }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Status</span></div>
                        <div class="col_half col_last bottommargin-xsm"><b class="{{ $reserva->reserva_status_class }}">{{ $reserva->reserva_status }}</b></div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Data da Reserva</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->data_reserva }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Horário</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->horario_reserva  }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Reserva para</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->qtd_clientes }} pessoa(s)</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Reservado em</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->data_criacao_reserva }}</div>
                    </li>
                    @if(!empty($reserva->observacao))
                        <li>
                            <div class="col_half bottommargin-sm"><span>Observação</span></div>
                            <div class="col_half col_last bottommargin-xsm">{{ $reserva->observacao }}
                        </li>
                    @endif
                </ul>
            </div>
            <div class="col_half col_last">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>Endereço</h3>
                </div>
                <ul>
                    <li>
                        <div class="col_half bottommargin-sm"><span>CEP</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->cep }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Rua/Número</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->logradouro }}, {{ $reserva->logradouro_numero }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Bairro</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->bairro }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Cidade</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->nome_cidade }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Estado - País</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->nome_estado }} - {{ $reserva->nome_pais }}</div>
                    </li>
                </ul>
            </div>

            <div class="col_half">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>Cliente</h3>
                </div>
                <ul>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Foto</span></div>
                        <div class="col_half col_last bottommargin-xsm">
                            <img class="thumbnail nomargin" src="{{ crop($reserva->cliente_avatar, 60, 60) }}" alt="{{ $reserva->titulo_produto }}" />
                        </div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Nome Cliente</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->nome_cliente }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Telefone</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->cliente_telefone }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Email</span></div>
                        <div class="col_half col_last bottommargin-xsm breakword">{{ $reserva->email_cliente }}</div>
                    </li>
                </ul>
            </div>
            <div class="col_half col_last">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>Pagamento</h3>
                </div>
                <ul>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Valor Total Pago</span></div>
                        <div class="col_half col_last bottommargin-xsm">R$ {{ formatar_monetario($reserva->preco_total) }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Parcela Valor Chef</span></div>
                        <div class="col_half col_last bottommargin-xsm">R$ {{ formatar_monetario($reserva->vlr_divisao_chef) }} ({{ round($reserva->porcentagem_chef) }}%)</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Parcela Valor La Mesa Bonita</span></div>
                        <div class="col_half col_last bottommargin-xsm">R$ {{ formatar_monetario($reserva->vlr_divisao_lmb) }} ({{ 100 - $reserva->porcentagem_chef }}%)</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Status</span></div>
                        <div class="col_half col_last bottommargin-xsm">
                            <b class="{{ $reserva->pagamento_status_class }}">{{ $reserva->pagamento_status }}</b>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>

            <div class='row'>
                <div class='col-md-12'>
                    <a href="{{ route('chef.reserva.listar') }}" class="button button-3d button-rounded nomargin">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection