@extends('template')

@section('after-header')
<!-- Page Title
============================================= -->
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        <h1><span>Minha Conta</span></h1>
    </div>

</section><!-- #page-title end -->
@endsection

@section('content')
<div class="container inner-pages">
    <div class="col_one_fourth">
        @include('usuario.sidebar')
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
                    <li><div class="col_half bottommargin-sm"><span>Cód Reserva</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->id_reserva }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Status</span></div><div class="col_half col_last bottommargin-xsm"> <b class="{{ $reserva->reserva_status_class }}">{{ $reserva->reserva_status }}</b></div></li>
                    <li><div class="col_half bottommargin-sm"><span>Data da Reserva</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->data_reserva }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Horário</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->horario_reserva  }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Reserva para</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->qtd_clientes }} pessoa(s)</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Reservado em</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->data_criacao_reserva }}</div></li>
                    @if(!empty($reserva->observacao))
                        <li><div class="col_half bottommargin-sm"><span>Observação</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->observacao }}</div></li>
                    @endif
                </ul>
            </div>
            <div class="col_half col_last">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>Endereço</h3>
                </div>
                <ul>
                    <li><div class="col_half bottommargin-sm"><span>CEP</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->cep }}</div></li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Rua/Número</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->logradouro }}, {{ $reserva->logradouro_numero }}</div>
                    </li>
                    <li><div class="col_half bottommargin-sm"><span>Bairro</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->bairro }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Cidade</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->nome_cidade }}</div></li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Estado - País</span></div>
                            <div class="col_half col_last bottommargin-xsm">{{ $reserva->nome_estado }} - {{ $reserva->nome_pais }}</div>
                    </li>
                </ul>
            </div>

            <div class="col_half">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>{{ $reserva->ind_menu ? 'Menu' : 'Curso' }}/Chef</h3>
                </div>
                <ul>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Foto</span></div>
                        <div class="col_half col_last bottommargin-xsm">
                            <img class="thumbnail nomargin" src="{{ crop($reserva->chef_avatar, 60, 60) }}" alt="{{ $reserva->titulo_produto }}" />
                        </div>
                    </li>
                        <div class="col_half bottommargin-sm"><span>Nome do Chef</span></div>
                        <div class="col_half col_last bottommargin-xsm">{{ $reserva->chef_nome }}</div>
                    </li>
                    <li><div class="col_half bottommargin-sm"><span>{{ $reserva->ind_menu ? 'Menu' : 'Curso' }} Reservado</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->titulo_produto }}</div></li>
                    <li><div class="col_half bottommargin-sm"><span>Telefone do Chef</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->chef_telefone }}</div></li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Email do Chef</span></div>
                        <div class="col_half col_last bottommargin-xsm breakword">{{ $reserva->chef_email }}</div>
                    </li>
                </ul>
            </div>
            <div class="col_half col_last">
                <div class="fancy-title title-dotted-border title-left marginbottom10px">
                    <h3>Pagamento</h3>
                </div>
                <ul>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Método Pagamento</span></div>
                        <div class="col_half col_last bottommargin-xsm breakword">Cartão de Crédito</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Status</span></div>
                        <div class="col_half col_last bottommargin-xsm breakword"><b class="{{ $reserva->pagamento_status_class }}">{{ $reserva->pagamento_status }}</b></div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Número Cartão</span></div>
                        <div class="col_half col_last bottommargin-xsm breakword">{{ $reserva->pagamento_numero_cartao }}</div>
                    </li>
                    <li><div class="col_half bottommargin-sm"><span>Titular Cartão</span></div><div class="col_half col_last bottommargin-xsm">{{ $reserva->pagamento_titular_cartao }}</div></li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Preço por Pessoa</span></div>
                        <div class="col_half col_last bottommargin-xsm breakword">R$ {{ formatar_monetario($reserva->preco_por_cliente) }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Taxa La Mesa Bonita</span></div>
                        <div class="col_half col_last bottommargin-xsm breakword">R$ {{ formatar_monetario($reserva->taxa_lmb) }}</div>
                    </li>
                    <li>
                        <div class="col_half bottommargin-sm"><span>Preço Total</span></div>
                        <div class="col_half col_last bottommargin-xsm breakword">R$ {{ formatar_monetario($reserva->preco_total) }}</div>
                    </li>
                </ul>
            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>

            <div class='row'>
                <div class='col-md-12'>
                    @if($reserva->ind_ativo)
                        <a href="{{ route('degustador.cancelar_reserva', ['reserva' => $reserva->id_reserva]) }}" class="button button-red button-3d button-rounded nomargin">
                            <i class="fa fa-remove"></i> Cancelar e Reembolsar Reserva
                        </a>
                    @endif

                    <a href="{{ route('degustador.reservas') }}" class="button button-3d button-rounded nomargin">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection