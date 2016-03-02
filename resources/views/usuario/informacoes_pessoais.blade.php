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
    <div class="col_three_fourth col_last my-account-form backgroundWhite">
        <div class="fancy-title title-bottom-border">
            <h2>Meus Dados</h2>
        </div>
        <form action="{{ route('degustador.alterar_informacoes_pessoais') }}" method="POST">
            {!! csrf_field() !!}
            
            <div class="col_half">
                <div class="fancy-title title-dotted-border title-left">
                    <h4>Informações Pessoais</h4>
                </div>

                 @include('includes/errors')

                <div class='col_full'>
                    <label for="name">Nome <small>*</small></label>
                    <div class="input-icon-left marginbottom10px">
                        <input required type="text" id="name" value="{{ old('name') ?: $dados->nome }}" name="name" class="sm-form-control required">
                        <i class="fa fa-user input-icon"></i>
                    </div>
                </div>

                <div class='col_full'>
                    <label for="email">E-mail <small>*</small></label>
                    <div class="input-icon-left marginbottom10px">
                        <input required readonly type="text" name="email" id="email" value="{{ old('email') ?: $dados->email }}" class="sm-form-control required">
                        <i class="fa fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class='col_full'>
                    <label for="fk_sexo">Sexo <small>*</small></label>
                    <select required type="text" id="fk_sexo" name="fk_sexo" class="sm-form-control required" aria-required="true">
                        <option value="">Selecione seu sexo...</option>
                        @foreach ($combos['sexos'] as $sexo)
                            <option
                                {{ (old('fk_sexo') ?: $dados->fk_sexo) == $sexo->id_sexo ? "selected='selected'" : "" }}
                                value="{{$sexo->id_sexo}}"
                            >
                                {{$sexo->descricao}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class='col_full'>
                    <label for="data_nascimento">Data de Nascimento <small>(*)</small></label>
                    <div class="input-icon-left">
                        <input required type="text" value="{{ old('data_nascimento') ?: $dados->data_nascimento }}" name="data_nascimento" id="data_nascimento" class="sm-form-control required">
                        <i class="fa fa-calendar input-icon"></i>
                    </div>
                </div>

                <div class='col_full'>
                    <label for="cpf">CPF <small>*</small></label>
                    <div class="input-icon-left marginbottom10px">
                        <input required type="text" id="cpf" value="{{ old('cpf') ?: $dados->cpf }}" name="cpf" class="sm-form-control required">
                        <i class="fa fa-user input-icon"></i>
                    </div>
                </div>

                <div class='col_full'>
                    <label for="telefone">Telefone <small>*</small></label>
                    <div class="input-icon-left marginbottom10px">
                        <input required type="text" id="telefone" name="telefone" value="{{ old('telefone') ?: $dados->telefone }}" class="sm-form-control required">
                        <i class="fa fa-phone input-icon"></i>
                    </div>
                </div>

            </div>
            <div class="col_half col_last">
                <div class="fancy-title title-dotted-border title-left">
                    <h4>Endereço</h4>
                </div>
                <div class='col_full'>
                    <label for="cep">CEP <small>*</small></label>
                    <input required type="text" id="cep" name="cep" value="{{ old('cep') ?: $dados->cep }}" class="sm-form-control required">
                </div>

                <div class='col_half'>
                    <label for="fk_pais">País <small>*</small></label>
                    <input type="hidden" name="fk_pais" value="BR">
                    <input required disabled type="text" value="Brasil" class="sm-form-control required">
                </div>

                <div class='col_half col_last'>
                    <label for="fk_estado">Estado <small>*</small></label>
                    <select required type="text" id="fk_estado" name="fk_estado" class="sm-form-control required" aria-required="true">
                        <option value="">Selecione um estado</option>
                        @foreach ($combos['estados'] as $estado)
                            <option
                                {{ (old('fk_estado') ?: $dados->fk_estado) == $estado->id_estado ? "selected='selected'" : "" }}
                                value="{{$estado->id_estado}}">{{$estado->nome_estado}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="clear"></div>

                <div class='col_full'>
                    <label for="fk_cidade">Cidade <small>*</small></label>
                    <select required type="text" id="fk_cidade" name="fk_cidade" class="sm-form-control required" aria-required="true">
                        <option value="">Selecione uma cidade</option>
                        @foreach ($combos['cidades'] as $cidade)
                            <option
                                {{ (old('fk_cidade') ?: $dados->fk_cidade) == $cidade->id_cidade ? "selected='selected'" : "" }}
                                value="{{$cidade->id_cidade}}">{{$cidade->nome_cidade}}</option>
                        @endforeach
                    </select>
                </div>

                <div class='col_full'>
                    <label for="bairro">Bairro <small>*</small></label>
                    <input required type="text" id="bairro" name="bairro" value="{{ old('bairro') ?: $dados->bairro }}" class="sm-form-control required">
                </div>

                <div class='col_full'>
                    <div class='col_three_fourth'>
                        <label for="logradouro">Rua/Logradouro <small>*</small></label>
                        <input required type="text" id="logradouro" name="logradouro" value="{{ old('logradouro') ?: $dados->logradouro }}" class="sm-form-control required">
                    </div>
                    <div class='col_one_fourth col_last'>
                        <label for="logradouro_numero">Número <small>*</small></label>
                        <input required type="text" id="logradouro_numero" name="logradouro_numero" value="{{ old('logradouro_numero') ?: $dados->logradouro_numero }}" class="sm-form-control required">
                    </div>
                </div>

                <div class='col_full'>
                    <label for="bairro">Complemento <small>*</small></label>
                    <input required type="text" id="complemento" name="complemento" value="{{ old('complemento') ?: $dados->complemento }}" class="sm-form-control required">
                </div>

            </div>
            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>
            <button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d nomargin"><i class="fa fa-share-square-o"></i> Salvar Alterações</button>
        </form>

    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="/js/jquery.mask.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#data_nascimento").mask("99/99/9999");
            $("#cep").mask("99999-999");
            $("#cpf").mask("999.999.999-99");

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
        });
    </script>
@endsection
