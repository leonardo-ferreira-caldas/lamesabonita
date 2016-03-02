@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Contas Bancárias</h2>
        </div>

        <a href="{{ route('chef.dados_bancarios.novo') }}" class="button button-3d nomargin button-small">
            <i class="fa fa-plus"></i> Nova Conta Bancária
        </a>

        <div class="clear"></div>

        <table class="table table-bordered table-striped table-booking-history topmargin-sm">
            <thead>
            <tr>
                <th width='100'>Cód Conta</th>
                <th>Banco</th>
                <th>Agencia</th>
                <th>Conta</th>
                <th>Proprietário</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if(empty($contas_bancarias))
            <tr>
                <td class="text-center" colspan="6">Nenhuma conta bancária cadastrada.</td>
            </tr>
            @else
                @foreach($contas_bancarias as $conta)
                    <tr>
                        <td>{{ $conta->id_conta_bancaria }}</td>
                        <td>{{ $conta->banco_descricao }}</td>
                        <td>{{ $conta->banco_agencia }}-{{ $conta->banco_agencia_digito }}</td>
                        <td>{{ $conta->banco_conta }}-{{ $conta->banco_conta_digito }}</td>
                        <td>{{ $conta->banco_proprietario_conta }}</td>
                        <td class="text-center">
                            <a class="btn btn-default btn-sm" href="{{ route('chef.dados_bancarios.editar', ['id' => $conta->id_conta_bancaria]) }}">
                                <i class="fa fa-pencil-square-o"></i> Editar</a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

    </div>
</div>
@endsection