@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite">
        <div class="fancy-title title-bottom-border">
            <h2>Reservas Agendadas</h2>
        </div>

        <div class="tabs clearfix" id="tab-1">

            <ul class="tab-nav clearfix">
                <li><a href="#tabs-ativas">Ativas</a></li>
                <li><a href="#tabs-ativas">Canceladas</a></li>
                <li><a href="#tabs-ativas">Realizadas</a></li>
                <li><a href="#tabs-ativas">Todas</a></li>
            </ul>

            <div class="tab-container">

                <div class="tab-content clearfix" id="tabs-ativas">

                    <table class="table table-bordered table-striped table-booking-history">
                        <thead>
                        <tr>
                            <th width='100'>Cód</th>
                            <th>Cliente</th>
                            <th>Menu/Curso</th>
                            <th>Preço</th>
                            <th>Data/Horário</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($reservas_todas) == 0)
                            <tr>
                                <td class="text-center" colspan="7">Nenhuma reserva encontrada.</td>
                            </tr>
                        @else

                            @foreach($reservas_todas as $reserva)
                                <tr>
                                    <td nowrap="nowrap">{{ $reserva->id_reserva }}</td>
                                    <td>{{ $reserva->nome_cliente }}</td>
                                    <td>{{ $reserva->titulo_produto }}</td>
                                    <td nowrap="nowrap">R$ {{ formatar_monetario($reserva->vlr_divisao_chef) }}</td>
                                    <td nowrap="nowrap">{{ $reserva->data_reserva }} {{ $reserva->horario_reserva }}</td>
                                    <td class="{{ $reserva->reserva_status_class }}">
                                        {{ $reserva->reserva_status_descricao }}
                                    </td>
                                    <td nowrap="nowrap" class="text-center">
                                        <a class="btn btn-default btn-sm" href="{{ route('chef.reserva.detalhes', ['reserva' => $reserva->id_reserva]) }}">Detalhes</a>
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