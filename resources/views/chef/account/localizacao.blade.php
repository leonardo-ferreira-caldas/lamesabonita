@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Localização</h2>
        </div>

        <form method="POST" class="use-ajax" action="/chef/alterar-localizacao">

            {!! csrf_field() !!}

            @include('includes/errors')

            <div class='col_full'>
                <div class='col_one_third'>
                    <label for="fk_pais">País <small>(obrigatório)</small></label>
                    <select required type="text" id="fk_pais" name="fk_pais" value="" placeholder="Pesquise..." class="sm-form-control required" aria-required="true">
                    <option value="">Selecione um país</option>
                        @foreach ($combos['paises'] as $pais)
                            <option
                                {{ $dados['pais'] == $pais->id_pais ? "selected" : "" }}
                                value="{{$pais->id_pais}}"
                            >{{$pais->nome_pais}}</option>
                        @endforeach
                    </select>
                </div>
                <div class='col_one_third'>
                    <label for="fk_estado">Estado <small>(obrigatório)</small></label>
                    <select required type="text" id="fk_estado" name="fk_estado" value="" placeholder="Pesquise..." class="sm-form-control required" aria-required="true">
                        <option value="">Selecione um estado</option>
                        @foreach ($combos['estados'] as $estado)
                            <option
                                {{ $dados['estado'] == $estado->id_estado ? "selected" : "" }}
                                value="{{$estado->id_estado}}">{{$estado->nome_estado}}</option>
                        @endforeach
                    </select>
                </div>
                <div class='col_one_third col_last'>
                    <label for="fk_cidade">Cidade <small>(obrigatório)</small></label>
                    <select {{ empty($combos['cidades']) ? 'disabled' : '' }} required type="text" id="fk_cidade" name="fk_cidade" class="sm-form-control required" aria-required="true">
                        <option value="">Selecione uma cidade</option>
                        @foreach ($combos['cidades'] as $cidade)
                            <option
                                {{ $dados['cidade'] == $cidade->id_cidade ? "selected" : "" }}
                                value="{{$cidade->id_cidade}}">{{$cidade->nome_cidade}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col_full">
                <div class='col_two_fifth'>
                    <label for="cep">CEP <small>*</small></label>
                    <input required type="text" id="cep" name="cep" value="{{ $dados['cep'] }}" class="sm-form-control required">
                </div>
                <div class='col_three_fifth col_last'>
                    <label for="cep">Bairro <small>*</small></label>
                    <input required type="text" id="bairro" name="bairro" value="{{ $dados['bairro'] }}" class="sm-form-control required">
                </div>
            </div>

            <div class='col_full'>
                <div class='col_three_fourth'>
                    <label for="logradouro">Rua/Logradouro <small>(obrigatório)</small></label>
                    <input required type="text" id="logradouro" name="logradouro" value="{{ $dados['logradouro'] }}" class="sm-form-control required">
                </div>
                <div class='col_one_fourth col_last'>
                    <label for="logradouro_numero">Número <small>*</small></label>
                    <input required type="text" id="logradouro_numero" name="logradouro_numero" value="{{ $dados['logradouro_numero'] }}" class="sm-form-control required">
                </div>

            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>
            <button type="submit" class="button button-3d nomargin mb-button-full">
                <i class="fa fa-share-square-o"></i> Salvar Minha Localização
            </button>

            <blockquote class="processing-form nobottommargin topmargin-sm"><p><i class="fa fa-spinner fa-spin rightmargin-xsm"></i> Aguarde! Salvando localização...</p></blockquote>

        </form>
    </div>
</div>

@endsection

@section('js')
    <script type="text/javascript" src="/js/jquery.mask.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("form.use-ajax").ajaxForm();

            $("#fk_estado").change(function() {
                if ($(this).val().toString().length <= 1) {
                    return;
                }
                $("#fk_cidade").attr("disabled", true).html('<option value="">Buscando cidades...</option>');

                $.getJSON('/filtrar-cidades/' + $(this).val(), function(data) {
                    var items = ['<option value="">Selecione uma cidade</option>'];
                    $.each( data, function( key, val ) {
                        items.push("<option value='" + val.id_cidade + "'>" + val.nome_cidade + "</option>");
                    });

                    $("#fk_cidade").attr("disabled", false).html(items.join(""));
                });
            });

            $("#ind_toda_cidade").change(function() {
                var slide = $("#range_distance").data("ionRangeSlider");
                var toDisable = true;
                var from = 5;

                if ($(this).val() == "0") {
                    toDisable = false;
                    from = slide.from;
                }

                slide.update({
                    disable: toDisable,
                    from: from
                });

            });

            $("#range_distance").ionRangeSlider({
                onFinish: function(data) {
                    $("#distancia_aceita").val(data.from);
                }
            });

            $("#cep").mask("99999-999");

        });
    </script>
    <script type="text/javascript" src="/js/ion.rangeSlider.min.js"></script>
@endsection