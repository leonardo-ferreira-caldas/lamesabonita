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

                <div class="col_full nobottommargin noabsolute menu-detalhe-wrapper">

                    <div class="padding20px notoppadding bottommargin-lg norightpadding">

                        <div class="topdottedborder bottommargin-sm"></div>

                        <div class="clear"></div>

                        <div class="text-center reserva-concluida topmargin-lg">
                            <i class="fa fa-check reserva-concluida-icon"></i>
                            <h3 class="nobottommargin roboto fontlight darkgray font-lg">{{ $reserva->nome_cliente }}, sua reserva foi concluída!</h3>
                            <h5 class="roboto informacoes-reserva darkgray fontlight">Os detalhes da sua reserva foram enviados para {{ $reserva->email_cliente }}.</h5>
                        </div>

                        <div class="row">
                            <div class="topmargin-sm col-md-8 col-md-offset-2">
                                <div class="roboto borderdashed bottommargin-sm padding20px">
                                    <i class="fa fa-cutlery fa-2x pull-left topmargin-xsm"></i>
                                    <div class="font19px pull-left leftmargin-xsm">
                                        {{ $reserva->titulo_produto }}<br>
                                        <small class="font-small">{{ $reserva->data_reserva }} {{ $reserva->horario_reserva }}</small>
                                    </div>
                                    <div class="pull-right text-right font19px">
                                        Total<br>
                                        R$ {{ formatar_monetario($reserva->preco_total) }}
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <a href="{{ route('degustador.reservas') }}" id="salvar-endereco" class="button button-3d nomargin pull-left">
                                    <i class="fa fa-book"></i> Ver Minhas Reservas
                                </a>
                                <a href="{{ route('menus_e_cursos') }}" id="salvar-endereco" class="button button-3d nomargin pull-right">
                                    <i class="fa fa-search"></i> Ver Outros Menus/Cursos
                                </a>
                            </div>
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
            $("#numero_cartao").mask("9999-9999-9999-9999");
        });
    </script>
@endsection