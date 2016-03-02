@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth marginbottom10px col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Meus Saques</h2>
        </div>

        <div class="col_one_third nobottommargin">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Saldo Atual</b></h3>
                </div>
                <div class="panel-body">
                    <h2 class="nomargin nopadding lato">R$ {{ formatar_monetario($saldo) }}</h2>
                </div>
            </div>
        </div>

        <div class="col_one_third nobottommargin">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Pendente</b></h3>
                </div>
                <div class="panel-body">
                    <h2 class="nomargin nopadding lato">R$ {{ formatar_monetario($saques_realizados->aguardando_conclusao) }}</h2>
                </div>
            </div>
        </div>

        <div class="col_one_third col_last nobottommargin">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Total Sacado</b></h3>
                </div>
                <div class="panel-body">
                    <h2 class="nomargin nopadding lato">R$ {{ formatar_monetario($saques_realizados->total_sacado) }}</h2>
                </div>
            </div>
        </div>

        <div class="clear"></div>

        <a href="{{ route('saque.solicitar') }}" class="noleftmargin button button-3d button-small button-rounded button-dirtygreen">
            <i class="fa fa-usd"></i> Realizar Novo Saque
        </a>

        <table class="topmargin-xsm table table-bordered table-striped table-booking-history">
            <thead>
            <tr>
                <th>Cód</th>
                <th>Conta Bancária</th>
                <th>Valor</th>
                <th>Taxa</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
                @if(count($saques) == 0)
                    <tr>
                        <td colspan="6" class="text-center">Nenhum saque foi realizado/encontrado.</td>
                    </tr>
                @else
                    @foreach($saques as $saque)
                        <tr>
                            <td>{{ $saque->id_saque }}</td>
                            <td>{{ $saque->banco_descricao }} /
                                Conta: {{ $saque->conta_descricao }} /
                                Agencia: {{ $saque->agencia_descricao }}</td>
                            <td>{{ formatar_monetario($saque->valor_saque) }}</td>
                            <td>{{ formatar_monetario($saque->valor_taxa) }}</td>
                            <td>{{ $saque->status }}</td>
                            <td>{{ $saque->data_solicitacao }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $("#solicitar-saque").submit(function() {

            if ($("#id_conta_bancaria").val() == "") {
                Utils.alert.info("Atenção!", "Selecione uma conta bancária.");
                return false;
            }

            if ($(this).hasClass("confirmado")) {
                return true;
            }

            swal({
                title: 'Atenção!',
                text: 'Você tem certeza que deseja realizar um saque na conta bancária selecionada?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Não, quero cancelar!',
                confirmButtonText: 'Sim, eu tenho!',
                closeOnConfirm: false
            }, function () {
                $("#solicitar-saque").addClass('confirmado');
                $("#solicitar-saque").trigger("submit");
            });

            return false;

        });
    });
</script>
@endsection