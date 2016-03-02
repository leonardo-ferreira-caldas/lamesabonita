@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth marginbottom10px col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Solicitar Saque</h2>
        </div>

        <p>Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.</p>
        <p>Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado.</p>

        <form method="POST" action="{{ route('saque.realizar_saque') }}" id="solicitar-saque" class="nomargin nopadding">

            {!! csrf_field() !!}

            <div class="clear"></div>

            @if ($auth->getChef('saldo') <= 1)
                <div class="style-msg infomsg">
                    <div class="sb-msg"><i class="icon-info-sign"></i><strong>Aviso!</strong> Você não tem saldo suficiente para realizar um saque.</div>
                </div>

            @else

                <div class="col_two_third">
                    <label for="id_conta_bancaria">Selecione uma conta bancária: <small>(*)</small></label>
                    <select required id="id_conta_bancaria" name="id_conta_bancaria" class="sm-form-control required" aria-required="true">
                        <option value="">Selecione...</option>
                        @foreach ($contas_bancarias as $conta)
                            <option value="{{ $conta->id_conta_bancaria }}">
                                {{$conta->banco_descricao}} /
                                Conta: {{ $conta->conta_descricao }} /
                                Agencia: {{ $conta->agencia_descricao }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="clear"></div>

                <button type="submit" class="mb-button-full mb-nopadding text-center button button-3d button-green nomargin">
                    <i class="fa fa-usd"></i> Solicitar Saque
                </button>

            @endif

        </form>

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