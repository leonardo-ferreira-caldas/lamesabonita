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
                    <h2 class="roboto fontlight nobottommargin notopmargin">{{ $menu->titulo }}</h2>
                    <div class="mini-foto-perfil">
                        <img class="img-circle rightmargin-xsm" src="{{ crop($chef->avatar ?: 'avatar.jpg', 40, 40) }}">
                        {{ $chef->user->name }} (<small><a href="{{ route('chef', ['slug' => $chef->slug]) }}" class="lato uppercase">Ver perfil</a></small>)
                        <span class="leftmargin-xsm color">{!! $chef->getReputacaoMedia() !!}</span>
                        <a href="/favorito/salvar/{{ $menu->slug }}/menu" class="leftmargin-xsm button button-mini button-pink button-3d nomargin">
                            <i class="fa fa-heart"></i> Favoritos
                        </a>

                        <h3 class="preco-menu-detalhes marginbottom10px pull-right roboto">R$ {{ $menu->preco }} <small class="roboto">por pessoa</small></h3>
                    </div>

                </div>

                <div class="padding20px notoppadding norightpadding">

                    <div class="topdottedborder bottommargin-sm"></div>

                    <div class="clear"></div>

                    <div class="fslider" data-animation="fade" data-thumbs="true" data-arrows="true" data-speed="500" data-pause="5000">
                        <div class="flexslider">
                            <div class="slider-wrap">

                                @foreach($menu->imagens as $idx => $picture)

                                    <div class="slide" data-thumb="{{ crop($picture->nome_imagem, 100, 75) }}">
                                        <img src="{{ crop($picture->nome_imagem, 745, 420) }}" alt="{{ $picture->nome_imagem }}">
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <div class="nopadding topmargin-sm">

                        <span class="rightmargin-xsm roboto font16px">Tags: </span>

                        @foreach ($menu->culinarias as $culinaria)
                            <span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $culinaria->nome_culinaria }}</span>
                        @endforeach

                        @foreach ($menu->refeicoes as $refeicao)
                            <span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $refeicao->nome_tipo_refeicao }}</span>
                        @endforeach


                        <div class="detalhes-menu">

                            @if(!empty($menu->aperitivo ))
                                <div class="fancy-title title-dotted-border text-left bottommargin-sm">
                                    <h4 class="font17px">Aperitivos</h4>
                                </div>

                                <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $menu->aperitivo }}</div>
                            @endif

                            @if(!empty($menu->entrada ))
                                <div class="fancy-title title-dotted-border topmargin-sm text-left bottommargin-sm">
                                    <h4 class="font17px">Prato de Entrada</h4>
                                </div>

                                <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $menu->entrada }}</div>
                            @endif

                            <div class="fancy-title title-dotted-border topmargin-sm text-left bottommargin-sm">
                                <h4 class="font17px">Prato Principal</h4>
                            </div>

                            <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $menu->prato_principal }}</div>

                            @if(!empty($menu->sobremesa ))
                                <div class="fancy-title title-dotted-border topmargin-sm text-left bottommargin-sm">
                                    <h4 class="font17px">Sobremesa</h4>
                                </div>

                                <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $menu->sobremesa }}</div>

                            @endif

                            <div class="fancy-title title-dotted-border topmargin-sm text-left bottommargin-sm">
                                <h4 class="font17px">Incluso no Preço</h4>
                            </div>

                            <div class='lista_incluso_preco font14px'>

                                @foreach ($incluso_preco as $i => $incluso_preco)
                                    <div class="checkbox col_full notopmargin text-left checkbox-normalize bottommargin-mini">
                                        <span>
                                            <i class="fa fa-check fa-fw"></i> {{ $incluso_preco->descricao }}
                                        </span>
                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col_one_third text-left col_last nobottommargin">

                @include('includes.form_faca_sua_reserva', [
                    'chef_slug'          => $chef->slug,
                    'slug'               => $menu->slug,
                    'tipo'               => 'menu',
                    'qtd_maxima_cliente' => $menu->qtd_maxima_cliente
                ])

            </div>

            <div class="clear"></div>

        </div>

        @include ('includes.avaliacoes', [
            'id_produto' => $menu->id_menu,
            'tipo'       => 'menu'
        ])

    </div>
</div>
@endsection

@section('js')
<script src="/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="/js/jquery.mask.js"></script>
<script type="text/javascript">
    var route_buscar_horario = '{{ route('chef.buscar_horario_data', ['slug' => $chef->slug]) }}';
    var diasDisponiveis = {!! $datas_reserva !!};
</script>
<script type="text/javascript" src="/js/form_faca_sua_reserva.js"></script>
@endsection