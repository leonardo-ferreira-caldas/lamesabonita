@extends('template')

@section('head')
    <link rel="stylesheet" href="/css/colorbox.css" type="text/css" />
    <script type="text/javascript" src="//assets.moip.com.br/v2/moip.min.js"></script>
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
                            <i class="i-circled i-small fa fa-credit-card" style="background-color:#D2691E"></i>
                            Dados de Pagamento
                        </h3>
                    </div>

                    <div class="padding20px notoppadding norightpadding">

                        <div class="topdottedborder bottommargin-sm"></div>

                        <div class="clear"></div>

                        <form action="{{ route('reservar.finalizar') }}" id="form-pagamento" method="POST">

                            {!! csrf_field() !!}

                            <input type="hidden" name="id_degustador_endereco" value="{{ $endereco->id_degustador_endereco }}">
                            @if(!empty($produto->id_menu))
                                <input type="hidden" name="id_menu" value="{{ $produto->id_menu }}">
                            @else
                                <input type="hidden" name="id_curso" value="{{ $produto->id_curso }}">
                            @endif
                            <input type="hidden" name="id_chef" value="{{ $chef->id_chef }}">
                            <input type="hidden" name="data_reserva" value="{{ $data_reserva }}">
                            <input type="hidden" name="horario_reserva" value="{{ $horario_reserva }}">
                            <input type="hidden" name="qtd_clientes" value="{{ $qtd_clientes }}">
                            <input type="hidden" name="observacao" value="{{ $observacao }}">

                            <div class="col_half col_last">
                                <label for="numero_cartao">Número do Cartão</label>
                                <input required type="text" id="numero_cartao" class="sm-form-control required">
                                <div class="topmargin-xxsm">
                                    <i class="fa fa-cc-visa fa-2x"></i>
                                    <i class="fa fa-cc-mastercard fa-2x"></i>
                                    <i class="fa fa-cc-amex fa-2x"></i>
                                    <i class="fa fa-cc-diners-club fa-2x"></i>
                                </div>
                            </div>

                            <div class="clear"></div>

                            <div class="col_two_third col_last">
                                <label for="titular_cartao">Nome do titular no Cartão de crédito</label>
                                <input required type="text" id="titular_cartao" name="titular_cartao" class="sm-form-control required">
                                <small>Digite o nome exatamente como está impresso no cartão.</small>
                            </div>

                            <div class="clear"></div>

                            <div class="col_half col_last marginbottom10px">
                                <label for="codigo_seguranca">Código de Segurança</label>
                                <div class="col_two_third marginbottom10px">
                                    <input required type="text" id="codigo_seguranca" class="sm-form-control required">
                                </div>
                                <div class="col_one_third col_last marginbottom10px" style="margin-top: 4px">
                                    <img src="/images/icons/seguranca_cartao.png" />
                                </div>
                            </div>

                            <div class="clear"></div>

                            <div class="col_half col_last marginbottom10px">
                                <div class="col_half">
                                    <label for="">Válido até</label>
                                    <select required id="valido_ate_mes" type="text" class="sm-form-control required">
                                        @for($a = 1; $a <= 12; $a++)
                                            <option value="{{ str_pad($a, 2, '0', STR_PAD_LEFT) }}">
                                                {{ str_pad($a, 2, '0', STR_PAD_LEFT) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col_half col_last">
                                    <label for="">&nbsp;</label>
                                    <select required id="valido_ate_ano" type="text" class="sm-form-control required">
                                        @for($i = date("Y"); $i <= date("Y") + 15; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="clear"></div>

                            <button type="submit" id="btn-pagar" class="button button-3d nomargin"><i class="fa fa-credit-card"></i>
                                Pagar com cartão de credito
                            </button>

                            <blockquote id="pagamento-carregando" style="display: none" class="nobottommargin topmargin-sm"><p><i class="fa fa-spinner fa-spin rightmargin-xsm"></i> Aguarde! Processando pagamento...</p></blockquote>

                            <div class="clear"></div>

                            <div class="col_one_fifth col_last">&nbsp;</div>

                            <div class="clear"></div>

                            <textarea id="chave_publica" style="display: none">{{ $chave_publica }}</textarea>
                            <textarea id="hash_cartao" name="hash_cartao" style="display: none"></textarea>
                            <input id="cartao_credito" name="cartao_credito" type="hidden"  />

                        </form>

                        <p><b>Importante:</b> Mesmo no caso de pagamento em várias parcelas de pequeno valor, lembre-se que o valor total da compra não pode exceder o limite de seu cartão. Esta é a regra de aprovação adotada pelas administradoras de cartão de crédito.</p>

                    </div>

                </div>

                <div class="col_one_third col_last text-left nobottommargin">

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
                                    <td class="text-right">R$ {{ formatar_monetario($valor_pessoa * $qtd_clientes) }}</td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="topdottedborder bottommargin-sm"></div>

                            <a href="{{ route("detalhes_menu", ['slug_chef' => $chef->slug, 'slug_menu' => $produto->slug]) }}" class="button text-center btn-full button-3d nomargin pull-right">
                                <i class="fa fa-book"></i> Alterar Reserva
                            </a>

                        </div>

                        <div class="fancy-title title-dotted-border title-center topmargin-sm marginbottom10px">
                            <h4>Endereço</h4>
                        </div>

                        <p class="list-group-item-text">
                            CEP: {{ $endereco->cep }}
                        </p>
                        <p class="list-group-item-text">
                            {{ $endereco->logradouro }}, {{ $endereco->logradouro_numero }} - Bairro {{ $endereco->bairro }}
                        </p>
                        <p class="list-group-item-text">
                            {{ $endereco->cidade->nome_cidade }}, {{ $endereco->estado->nome_estado }} - {{ $endereco->pais->nome_pais }}
                        </p>
                        @if($endereco->complemento)
                            <p class="list-group-item-text">Complemento: {{ $endereco->complemento }}</p>
                        @endif

                        <form action="{{ route('reservar.endereco', ['chef' => $chef->slug, 'tipo' => $tipo, 'slug' => $produto->slug]) }}" method="GET">

                            <input type="hidden" name="data_reserva" value="{{ $data_reserva }}">
                            <input type="hidden" name="horario_reserva" value="{{ $horario_reserva }}">
                            <input type="hidden" name="qtd_clientes" value="{{ $qtd_clientes }}">
                            <input type="hidden" name="observacao" value="{{ $observacao }}">

                            <button type="submit" class="button text-center btn-full button-3d topmargin-sm norightmargin pull-right">
                                <i class="fa fa-map-marker"></i> Alterar Endereço
                            </button>

                        </form>

                        <div class="clear"></div>


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
            $("#form-pagamento").submit(function() {

                var cartao = $("#numero_cartao").val();

                var cc = new Moip.CreditCard({
                    number  : cartao,
                    cvc     : $("#codigo_seguranca").val(),
                    expMonth: $("#valido_ate_mes").val(),
                    expYear : $("#valido_ate_ano").val(),
                    pubKey  : $("#chave_publica").val()
                });

                if (!cc.isValid()){

                    $("#hash_cartao, #cartao_credito").val('');
                    Utils.alert.error("Cartão de crédito inválido. Verifique se os dados do cartão estão corretos.");

                    return false;

                }

                var cryped = new Array(12 + 1).join("#") + cartao.substring(cartao.length - 4, cartao.length);

                $("#codigo_seguranca, #numero_cartao, #valido_ate_mes, #valido_ate_ano, #titular_cartao").addClass("input-disabled").attr("readonly", true);
                $("#btn-pagar").addClass("btn-disabled");
                $("#pagamento-carregando").show();

                $("#hash_cartao").val(cc.hash());
                $("#cartao_credito").val(cryped);

                return true;

            });
        });
    </script>
@endsection