@extends('template')

@section('head')
    <link rel="stylesheet" href="/css/colorbox.css" type="text/css" />
@endsection

@include("chef.perfil.foto_capa")

@section('container-class', 'chef-profile-content')

@section('content')
    <div class="container detalhes-item-chef">

        <div class="col_full">

            <div class="backgroundWhite nopadding">

                <div class="col_two_third nobottommargin noabsolute menu-detalhe-wrapper">
                    <div class="padding20px noabsolute">
                        <h3 class="roboto fontlight nobottommargin notopmargin">
                            <i class="i-circled i-small fa fa-map-marker" style="background-color:#D2691E"></i>
                            Escolha o local onde o chef irá cozinhar
                        </h3>
                    </div>

                    <div class="padding20px notoppadding norightpadding">

                        <div class="topdottedborder bottommargin-sm"></div>

                        <div class="clear"></div>

                        <form id="form-escolher-endereco" action="{{ route('reservar.pagamento', ['chef' => $chef->slug, 'tipo' => $tipo, 'slug' => $produto->slug]) }}" method="GET">

                            <input type="hidden" value="{{ $data_reserva }}" name="data_reserva">
                            <input type="hidden" value="{{ $horario_reserva }}" name="horario_reserva">
                            <input type="hidden" value="{{ $qtd_clientes }}" name="qtd_clientes">
                            <input type="hidden" value="{{ $observacao }}" name="observacao">


                            @if(count($enderecos) > 0)

                                <div class="list-group">

                                    @foreach($enderecos as $endereco)

                                        <a href="#" class="list-group-item">
                                            <input type="radio" name="id_degustador_endereco" value="{{ $endereco->id_degustador_endereco }}">

                                            <h4 class="leftmargin-xsm inline-block list-group-item-heading">{{ $endereco->descricao }}</h4>
                                            <p class="list-group-item-text">
                                                CEP: {{ $endereco->cep }}
                                            </p>
                                            <p class="list-group-item-text">
                                                {{ $endereco->logradouro }}, {{ $endereco->logradouro_numero }} - Bairro {{ $endereco->bairro }}
                                            </p>
                                            <p class="list-group-item-text">
                                                {{ $endereco->nome_cidade }}, {{ $endereco->nome_estado }} - {{ $endereco->nome_pais }}
                                            </p>
                                            @if($endereco->complemento)
                                                <p class="list-group-item-text">Complemento: {{ $endereco->complemento }}</p>
                                            @endif
                                        </a>

                                    @endforeach

                                </div>

                                <button type="submit" id="prosseguir" class="button button-3d nomargin pull-right">
                                    <i class="fa fa-credit-card"></i> Prosseguir para pagamento
                                </button>

                            @else

                                <p class="text-center">Nenhum endereço cadastrado.<br>Para prosseguir para o pagamento, cadastre um endereço.</p>

                            @endif

                        </form>

                        <div class="clear"></div>

                        <h3 class="roboto fontlight nobottommargin topmargin">
                            <i class="i-circled i-small fa fa-map-marker" style="background-color:#D2691E"></i>
                            Cadastrar Novo Endereço
                        </h3>

                        <div class="topdottedborder bottommargin-sm"></div>

                        <form id="form-salvar-endereco" class="nobottommargin" action="{{ route("degustador.salvar_endereco") }}" method="POST">

                            {!! csrf_field() !!}

                            @include('includes/errors')

                            <div class="col_full">
                                <label for="descricao">Descrição do Endereço: <small>(obrigatório)</small></label>
                                <input required placeholder="exemplo: casa, trabalho, casa do meu amigo..." type="text" id="descricao" name="descricao" class="sm-form-control">
                            </div>

                            <div class="col_half">
                                <label for="cep">CEP: <small>(obrigatório)</small></label>
                                <input required type="text" id="cep" name="cep" class="sm-form-control">
                            </div>

                            <div class="col_half col_last">
                                <label>&nbsp;</label>
                                <button type="button" id="buscar-cep" class="button button-teal text-center btn-full button-3d nomargin">
                                    <span class="show buscar"><i class="fa fa-search"></i> Buscar Endereço CEP</span>
                                    <span class="hide buscando"><i class="fa-li fa fa-spinner fa-spin" style="left: 0px;"></i> Buscando CEP...</span>
                                </button>
                            </div>

                            <div class="clear"></div>

                            <div class="col_half">
                                <label for="billing-form-companyname">País: <small>(obrigatório)</small></label>
                                <select required type="text" id="fk_pais" name="fk_pais" class="sm-form-control required" aria-required="true">
                                    <option value="BR" selected>Brasíl</option>
                                </select>
                            </div>

                            <div class="col_half col_last">
                                <label for="billing-form-address">Estado: <small>(obrigatório)</small></label>
                                <select required type="text" id="fk_estado" name="fk_estado" class="sm-form-control required" aria-required="true">
                                    <option value="">Selecione um estado</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{$estado->id_estado}}">{{$estado->nome_estado}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="clear"></div>

                            <div class="col_half">
                                <label for="billing-form-address">Cidade: <small>(obrigatório)</small></label>
                                <select required type="text" id="fk_cidade" name="fk_cidade" class="sm-form-control required" aria-required="true">
                                    <option value="">Selecione uma cidade</option>
                                </select>
                            </div>

                            <div class="col_half col_last">
                                <label for="bairro">Bairro <small>(obrigatório)</small></label>
                                <input required type="text" id="bairro" name="bairro" class="sm-form-control">
                            </div>

                            <div class="clear"></div>

                            <div class="col_two_third">
                                <label for="logradouro">Rua/Logradouro: <small>(obrigatório)</small></label>
                                <input required type="text" id="logradouro" name="logradouro" class="sm-form-control">
                            </div>

                            <div class="col_one_third col_last">
                                <label for="logradouro_numero">Número: <small>(obrigatório)</small></label>
                                <input required type="text" id="logradouro_numero" name="logradouro_numero" class="sm-form-control">
                            </div>

                            <div class="clear"></div>

                            <div class="col_full">
                                <label for="complemento">Complemento:</label>
                                <input type="text" id="complemento" name="complemento" class="sm-form-control">
                            </div>

                            <button type="submit" id="salvar-endereco" class="button button-3d nomargin pull-right rightmargin-xsm">
                                <i class="fa fa-sign-in"></i> Salvar Endereço
                            </button>

                            <div class="clear"></div>

                        </form>

                    </div>

                </div>

                <div class="col_one_third text-left col_last nobottommargin">

                    <div class="padding20px notoppadding topmargin-sm">

                        <div class="fancy-title marginbottom10px">
                            <h3 class="roboto fontlight nobottommargin notopmargin">
                                {{ $produto->titulo }}
                            </h3>
                        </div>

                        <div class="topdottedborder bottommargin-sm"></div>

                        <div class="thumbnail">
                            <img src="{{ crop($produto->foto_capa, 320, 200) }}" />
                        </div>

                        <div class="fancy-title title-dotted-border title-center marginbottom10px">
                            <h4>Informações & Valores</h4>
                        </div>


                        <div class="table-responsive">

                            <table class="table table-comparison nobottommargin">
                                <tbody>
                                    <tr>
                                        <td style="border-top: none;">Data da Reserva:</td>
                                        <td class="text-right" style="border-top: none;">{{ $data_reserva }}</td>
                                    </tr>
                                    <tr>
                                        <td>Horário:</td>
                                        <td class="text-right">{{ $horario_reserva }}</td>
                                    </tr>
                                    <tr>
                                        <td>Valor por Pessoa:</td>
                                        <td class="text-right">R$ {{ formatar_monetario($valor_pessoa) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quantidade de Pessoas:</td>
                                        <td class="text-right">{{ $qtd_clientes }}</td>
                                    </tr>
                                    <tr>
                                        <td>Valor Total:</td>
                                        <td class="text-right">R$ {{ formatar_monetario($valor_pessoa* $qtd_clientes) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="topdottedborder bottommargin-sm"></div>

                            <a href="{{ route("detalhes_menu", ['slug_chef' => $chef->slug, 'slug_menu' => $produto->slug]) }}" class="button text-center btn-full button-3d nomargin pull-right">
                                <i class="fa fa-book"></i> Alterar Reserva
                            </a>

                        </div>

                    </div>

                </div>

                <div class="clear"></div>

            </div>

        </div>
    </div>

@endsection

@section('js')
    <script src="/js/jquery.colorbox-min.js"></script>
    <script type="text/javascript" src="/js/jquery.mask.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".list-group-item").click(function(e) {
                $(".list-group-item.active").removeClass("active");
                $(this).addClass("active");
                $(this).find("input").prop("checked", true);
                e.preventDefault();
            });
            $("#cep").mask("99.999-999");

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

            $("#buscar-cep").click(function() {
                var cep = $("#cep").val();

                if (cep.toString().length == 0 || cep == "") {
                    Utils.alert.info("Informação", "Preencha o CEP.");
                    return;
                }

                cep = cep.toString().split(".").join("").split("-").join("");

                $(this).addClass("btn-disabled").prop("disabled", true);
                $(this).find(".buscar").removeClass("show").addClass("hide");
                $(this).find(".buscando").removeClass("hide").addClass("show");

                $.ajax({
                    url: "//api.postmon.com.br/v1/cep/" + cep,
                    dataType: "jsonp",
                    method: "GET",
                    timeout: 3000,
                    error:function (x, t, m){
                        if (t==="timeout") {
                            $(this).removeClass("btn-disabled").prop("disabled", false);
                            $(this).find(".buscar").removeClass("hide").addClass("show");
                            $(this).find(".buscando").removeClass("show").addClass("hide");
                            Utils.alert.info("Informação", "O CEP informado não existe.");
                        }
                    }.bind(this),
                    success: function(response) {

                        $("#bairro").val(response.bairro);
                        $("#logradouro").val(response.logradouro);
                        $("#fk_estado").val(response.estado);
                        $("#fk_estado").change();
                        cidadeCEP = response.cidade;

                        $(this).removeClass("btn-disabled").prop("disabled", false);
                        $(this).find(".buscar").removeClass("hide").addClass("show");
                        $(this).find(".buscando").removeClass("show").addClass("hide");
                    }.bind(this)
                });

            });

            $("#form-escolher-endereco").submit(function() {
                var checked = $("input[name=id_degustador_endereco]:checked").val();

                if (checked == undefined || typeof checked == "undefined" || checked.toString().length == 0) {
                    Utils.alert.info("Atenção!", "Escolha o local onde o chef irá cozinhar.");
                    return false;
                }

                return true;
            });

        });
    </script>
@endsection