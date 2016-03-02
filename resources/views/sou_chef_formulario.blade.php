@extends('template')

@section('container-class', 'chef-profile-content')

@section('content')
<div style="background: url(/images/backgrounds/background_cadastro_chef.jpg); background-size: cover;" class="nobgmobile">
    <div class="container">
        <div class="row">
            <div class="backgroundWhite col-md-8 col-md-offset-2 mb-noborder topmargin-lg bottommargin-lg mb-nobottommargin mb-notopmargin">

                <div class="fancy-title title-dotted-border title-left">
                    <h2>Criar conta <span>chef</span></h2>
                </div>

                <form action="/registrar" id="register-form" name="register-form" class="nobottommargin" method="POST">

                    @include('includes.errors')
                    {!! csrf_field() !!}

                    <input name='ind_chef' value='1' type="hidden" />

                    <div class="col_half">
                        <label for="name">Nome:</label>
                        <input required type="text" id="name" name="name" value="{{ old('name') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="col_half col_last">
                        <label for="sobrenome">Sobrenome:</label>
                        <input required type="text" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="clear"></div>

                    <div class="col_one_third">
                        <label for="telefone">CPF:</label>
                        <input required type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class='col_one_third'>
                        <label for="data_nascimento">Data de Nascimento <small>(*)</small></label>
                        <input required type="text" value="{{  old('data_nascimento') }}" name="data_nascimento" id="data_nascimento" class="sm-form-control required">
                    </div>

                    <div class="col_one_third col_last">
                        <label for="telefone">Telefone:</label>
                        <input required type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="clear"></div>

                    <div class="col_half">
                        <label for="email">Email:</label>
                        <input required type="text" id="email" name="email" value="{{ old('email') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="col_one_fourth">
                        <label for="email">Sexo:</label>
                        <select required type="text" id="fk_sexo" name="fk_sexo" class="sm-form-control required" aria-required="true">
                            <option value="">Selecione...</option>
                            <option value="1">Masculino</option>
                            <option value="2">Feminino</option>
                        </select>
                    </div>

                    <div class="col_one_fourth col_last">
                        <label for="email">CEP:</label>
                        <input required type="text" id="cep" name="cep" value="{{ old('cep') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="clear"></div>

                    <div class='col_one_third'>
                        <label for="fk_estado">Estado</label>
                        <select required type="text" id="fk_estado" name="fk_estado" class="sm-form-control required" aria-required="true">
                            <option value="">Selecione um estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{$estado->id_estado}}">{{$estado->nome_estado}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class='col_one_third'>
                        <label for="fk_estado">Cidade</label>
                        <select required disabled type="text" id="fk_cidade" name="fk_cidade" class="sm-form-control required" aria-required="true">
                            <option value="">Selecione uma cidade</option>
                        </select>
                    </div>

                    <div class="col_one_third col_last">
                        <label for="telefone">Bairro:</label>
                        <input required type="text" id="bairro" name="bairro" value="{{ old('bairro') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="clear"></div>

                    <div class="col_two_third">
                        <label for="telefone">Endereço/Logradouro:</label>
                        <input required type="text" id="logradouro" name="logradouro" value="{{ old('logradouro') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="col_one_third col_last">
                        <label for="telefone">Número:</label>
                        <input required type="text" id="logradouro_numero" name="logradouro_numero" value="{{ old('logradouro_numero') }}" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="clear"></div>

                    <div class="col_half">
                        <label for="password">Senha:</label>
                        <input required type="password" id="password" name="password" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="col_half col_last">
                        <label for="password_confirmation">Repita Senha:</label>
                        <input required type="password" id="password_confirmation" name="password_confirmation" class="sm-form-control required" aria-required="true">
                    </div>

                    <div class="col_full checkbox agree-terms checkbox-normalize">
                        <input type="checkbox" class="checkbox" id="checkbox-terms" name="checkbox-terms">
                        <label for="checkbox-terms" id="aceitar-termos" class="checkbox">
                            Eu concordo com os <a href="{{ route('termos-chef') }}" target="_blank">Termos de Uso</a> da La Mesa Bonita.
                        </label>
                    </div>

                    <div class="col_full nobottommargin">
                        <button class="button button-3d nomargin" id="cadastrar-chef-btn" name="cadastrar-chef-btn" value="login"><i class="fa fa-sign-in"></i> Cadastrar</button>
                    </div>
                </form>

            </div>


            <div class="clear"></div>
        </div>
    </div>
</div>
@endsection

@section("js")
    <script type="text/javascript" src="/js/jquery.mask.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#register-form").submit(function (evt) {
                if (!$("#checkbox-terms").is(":checked")) {
                    Utils.alert.error("Não permitido!", "Para se cadastrar como chef você precisa concordar com os termos de uso do La Mesa Bonita.");
                    evt.preventDefault();
                    return false;
                }

                return true;
            });

            var cidadeCEP = "";

            $("#fk_estado").change(function() {
                if ($(this).val().toString().length <= 1) {
                    return;
                }

                $("#fk_cidade").prop("disabled", true).html('<option value="">Buscando cidades...</option>');

                $.getJSON('/filtrar-cidades/' + $(this).val(), function(data) {
                    var items = ['<option value="">Selecione uma cidade</option>'];
                    $.each(data, function( key, val ) {
                        var selected = "";
                        if (val.nome_cidade == cidadeCEP) {
                            selected = 'selected';
                        }
                        items.push("<option value='" + val.id_cidade + "' " + selected + ">" + val.nome_cidade + "</option>");
                    });

                    $("#fk_cidade").attr("disabled", false).html(items.join(""));
                });
            });

            $("#cep").change(function() {

                var cep = $(this).val();

                if (cep.toString().length == 0 || cep == "") {
                    return;
                }

                cep = cep.toString().split(".").join("").split("-").join("");

                $.ajax({
                    url: "//api.postmon.com.br/v1/cep/" + cep,
                    dataType: "jsonp",
                    method: "GET",
                    timeout: 3000,
                    error:function (x, t, m){},
                    success: function(response) {

                        $("#bairro").val(response.bairro);
                        $("#logradouro").val(response.logradouro);
                        $("#fk_estado").val(response.estado);
                        $("#fk_estado").change();
                        cidadeCEP = response.cidade;

                    }
                });

            });

            $("#cpf").mask("999.999.999-99");
            $("#cep").mask("99.999-999");
            $("#telefone").mask("(99) 99999999?9");
            $("#data_nascimento").mask("99/99/9999");
        });
    </script>
@endsection