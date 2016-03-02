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
            <h2>Minhas Reservas</h2>
        </div>
        
        <div class="tabs clearfix" id="tab-1">

            <ul class="tab-nav clearfix">
                <li><a href="#ativos">Agendadas</a></li>
                <li><a href="#realizados">Realizados</a></li>
                <li><a href="#cancelados">Cancelados</a></li>
            </ul>

            <div class="tab-container">
            
                <div class="tab-content clearfix" id="ativos">
                    <table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr>
                                <th>Cód</th>
                                <th>Menu</th>
                                <th>Data Reserva</th>
                                <th>Preço</th>
                                <th>Status Pagamento</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($reservas_ativas) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">Nenhuma reserva ativa foi encontrada.</td>
                                </tr>
                            @else
                                @foreach($reservas_ativas as $reserva_ativa)
                                    <tr>
                                        <td nowrap="nowrap">{{ $reserva_ativa->id_reserva }}</td>
                                        <td>{{ $reserva_ativa->titulo_produto }}</td>
                                        <td nowrap="nowrap">{{ $reserva_ativa->data_reserva }} {{ $reserva_ativa->horario_reserva }}</td>
                                        <td nowrap="nowrap">R$ {{ formatar_monetario($reserva_ativa->preco_total) }}</td>
                                        <td class="{{ $reserva_ativa->class_status_pagamento }}">
                                            {{ $reserva_ativa->nome_pagamento_status }}
                                        </td>
                                        <td nowrap="nowrap" class="text-center">
                                            <a class="btn btn-default btn-sm" href="{{ route('degustador.reserva_detalhes', ['reserva' => $reserva_ativa->id_reserva]) }}">Detalhes</a>
                                            <a class="btn btn-default btn-sm" href="{{ route('degustador.cancelar_reserva', ['reserva' => $reserva_ativa->id_reserva]) }}">Cancelar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="tab-content clearfix" id="realizados">
                    <table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr>
                                <th>Cód</th>
                                <th>Menu</th>
                                <th>Data Reserva</th>
                                <th>Preço</th>
                                <th>Status Pagamento</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($reservas_realizadas) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">Nenhuma reserva realizada foi encontrada.</td>
                                </tr>
                            @else
                                @foreach($reservas_realizadas as $reserva_realizada)
                                    <tr>
                                        <td nowrap="nowrap">{{ $reserva_realizada->id_reserva }}</td>
                                        <td>{{ $reserva_realizada->titulo_produto }}</td>
                                        <td nowrap="nowrap">{{ $reserva_realizada->data_reserva }} {{ $reserva_realizada->horario_reserva }}</td>
                                        <td nowrap="nowrap">R$ {{ formatar_monetario($reserva_realizada->preco_total) }}</td>
                                        <td class="{{ $reserva_realizada->class_status_pagamento }}">
                                            {{ $reserva_realizada->nome_pagamento_status }}
                                        </td>
                                        <td nowrap="nowrap" class="text-center">
                                            <a class="btn btn-default btn-sm" href="{{ route('degustador.reserva_detalhes', ['reserva' => $reserva_realizada->id_reserva]) }}">Detalhes</a>
                                            <a class="btn btn-default btn-sm" href="{{ route('degustador.cancelar_reserva', ['reserva' => $reserva_realizada->id_reserva]) }}">Cancelar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="tab-content clearfix" id="cancelados">
                    <table class="table table-bordered table-striped table-booking-history">
                        <thead>
                            <tr>
                                <th>Cód</th>
                                <th>Menu</th>
                                <th>Data Reserva</th>
                                <th>Preço</th>
                                <th>Status Pagamento</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($reservas_canceladas) == 0)
                                <tr>
                                    <td colspan="6" class="text-center">Nenhuma reserva cancelada foi encontrada.</td>
                                </tr>
                            @else
                                @foreach($reservas_canceladas as $reservas_cancelada)
                                    <tr>
                                        <td nowrap="nowrap">{{ $reservas_cancelada->id_reserva }}</td>
                                        <td>{{ $reservas_cancelada->titulo_produto }}</td>
                                        <td nowrap="nowrap">{{ $reservas_cancelada->data_reserva }} {{ $reservas_cancelada->horario_reserva }}</td>
                                        <td nowrap="nowrap">R$ {{ formatar_monetario($reservas_cancelada->preco_total) }}</td>
                                        <td class="{{ $reservas_cancelada->class_status_pagamento }}">
                                            {{ $reservas_cancelada->nome_pagamento_status }}
                                        </td>
                                        <td nowrap="nowrap" class="text-center">
                                            <a class="btn btn-default btn-sm" href="{{ route('degustador.reserva_detalhes', ['reserva' => $reservas_cancelada->id_reserva]) }}">Detalhes</a>
                                            <a class="btn btn-default btn-sm" href="{{ route('degustador.cancelar_reserva', ['reserva' => $reservas_cancelada->id_reserva]) }}">Cancelar</a>
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
</div>
@endsection