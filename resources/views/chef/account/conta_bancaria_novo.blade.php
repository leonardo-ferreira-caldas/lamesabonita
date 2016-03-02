@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Conta Bancária</h2>
        </div>

        <form method="POST" id="salvar-conta-bancaria" class='use-ajax' action="{{ route('chef.dados_bancarios.novo_salvar') }}">

            {!! csrf_field() !!}

            <div class='col_full'>
                <label for="primeiro_nome">Banco <small>(obrigatório)</small></label>
                <select required type="text" id="fk_banco" name="fk_banco" class="sm-form-control required" aria-required="true">
                    <option value="">Selecione seu banco...</option>
                    @foreach ($bancos as $banco)
                        <option value="{{$banco->id_banco}}">
                            {{$banco->id_banco}} - {{$banco->nome_banco}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class='col_half'>
                <div class='col_two_third nobottommargin'>
                    <label for="banco_agencia">Agência <small>(obrigatório)</small></label>
                    <input required type="text" name="banco_agencia" id="banco_agencia" class="sm-form-control required">
                </div>
                <div class='col_one_third col_last nobottommargin'>
                    <label for="banco_agencia_digito">Digito</label>
                    <input type="text" name="banco_agencia_digito" id="banco_agencia_digito" class="sm-form-control required">
                </div>
            </div>
            <div class='col_half col_last'>
                <div class='col_two_third nobottommargin'>
                    <label for="banco_conta">Conta Corrente <small>(obrigatório)</small></label>
                    <input required type="text" name="banco_conta" id="banco_conta" class="sm-form-control required">
                </div>
                <div class='col_one_third col_last nobottommargin'>
                    <label for="banco_agencia_digito">Digito</label>
                    <input required type="text" name="banco_conta_digito" id="banco_conta_digito" class="sm-form-control required">
                </div>
            </div>

            <div class='col_full'>
                <label for="banco_proprietario_conta">Proprietário da Conta <small>(obrigatório)</small></label>
                <input required type="text" name="banco_proprietario_conta" id="banco_proprietario_conta" class="sm-form-control required">
            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>
            <button type="submit" class="button button-3d nomargin mb-btn-full"><i class="fa fa-share-square-o"></i> Cria Conta Bancária</button>

            <blockquote class="processing-form nobottommargin topmargin-sm"><p><i class="fa fa-spinner fa-spin rightmargin-xsm"></i> Aguarde! Salvando dados bancários...</p></blockquote>

        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $("form.use-ajax").ajaxForm({
            beforeSubmit: function() {
                var digitoAgencia = $("#banco_agencia_digito").val();

                if (!$.isNumeric($("#banco_agencia").val())) {
                    Utils.alert.info("Atenção!", "A agência deve conter apenas números.");
                    return;
                } else if (digitoAgencia.trim() != "" && !$.isNumeric(digitoAgencia)) {
                    Utils.alert.info("Atenção!", "O digito da agência deve conter apenas números.");
                    return;
                } else if (!$.isNumeric($("#banco_conta").val())) {
                    Utils.alert.info("Atenção!", "A conta corrente deve conter apenas números.");
                    return;
                } else if (!$.isNumeric($("#banco_conta_digito").val())) {
                    Utils.alert.info("Atenção!", "O digito da conta corrente deve conter apenas números.");
                    return;
                }

                return true;
            },
            afterSuccess: function() {
                $("form#salvar-conta-bancaria")[0].reset();
            }
        });
    });
</script>
@endsection