@extends('template')

@section('head')
    <link rel="stylesheet" href="/css/colorbox.css" type="text/css" />
@endsection

@include("chef.perfil.foto_capa")

@section('container-class', 'chef-profile-content')

@section('content')
<div class="container inner-pages">
    <div class="col_one_third">
        @include('chef.perfil.menu_lateral')
    </div>
    <div class="col_two_third col_last">

        <div class="fancy-title title-bottom-border">
            <h2>Menus</h2>
        </div>

        @if(count($menus) == 0)

          <div class='col_full' style="margin-top: 70px;">
              <h3 class='text-center'>Este chef não possuí nenhum menu cadastrado.</h3>
          </div>

        @else

            @foreach($menus as $menu)

                <div class="backgroundWhite nopadding">

                    @if(count($menu->imagens) > 0)

                        <div class="menu_cover" style="background-image: url('{{ route('image', ['w' => 730, 'h' => 250, 'i' => $menu->foto_capa ]) }}');"></div>

                        <div class="padding20px menu-thumb-pictures">

                            @foreach($menu->imagens as $idx => $imagem)

                                <div class="col_one_fifth menu-item-picture {{ ($idx+1) % 5 == 0 ? 'col_last' : '' }}">
                                    <div class="thumbnail nobottommargin">
                                        <a rel="{{ $menu->slug }}" href='{{ route('image', ['w' => 700, 'h' => 500, 'i' => $imagem->nome_imagem ]) }}' class="gallery">
                                            <img src="{{ route('image', ['w' => 120, 'h' => 80, 'i' => $imagem->nome_imagem ]) }}" />
                                        </a>
                                    </div>
                                </div>

                            @endforeach

                        </div>

                        <div class="clear"></div>

                    @endif

                    <div class="chef-profile-menu-item">

                        <div class="padding20px">
                            <div class="fancy-title title-dotted-border title-left marginbottom10px">
                                <h4>{{ $menu->titulo }}</h4>
                            </div>

                            <div class="bottommargin-xsm topmargin-xsm">
                                @foreach ($menu->culinarias as $culinaria)
                                    <span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $culinaria }}</span>
                                @endforeach

                                @foreach ($menu->refeicoes as $refeicao)
                                    <span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $refeicao }}</span>
                                @endforeach
                            </div>


                            <div class="detalhes-menu">
                                @if(count($menu->precos) > 0)
                                    <div class="fancy-title title-center text-left bottommargin-sm">
                                        <h4 class="font17px color">Preços por Convidados</h4>
                                    </div>

                                    <table class="table table-striped font14px table-condensed table-bordered text-center" style="width: 60%; margin: 0 20% 30px">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Quantidade de Pessoas</th>
                                            <th class="text-center">Valor</th>
                                        </tr>
                                        </thead>
                                        @foreach ($menu->precos as $preco)
                                            <tr>
                                                <td>A partir de {{ $preco->qtd_minima_clientes }} pessoas</td>
                                                <td>R$ {{ formatar_monetario($preco->preco) }} por pessoa</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif

                                @if(!empty($menu->aperitivo))
                                    <div class="fancy-title title-center text-left bottommargin-sm">
                                        <h4 class="font17px color">Aperitivos</h4>
                                    </div>

                                    <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $menu->aperitivo }}</div>
                                @endif

                                @if(!empty($menu->entrada))
                                    <div class="fancy-title title-center topmargin-sm text-left bottommargin-sm">
                                        <h4 class="font17px color">Prato de Entrada</h4>
                                    </div>

                                    <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $menu->entrada }}</div>
                                @endif

                                <div class="fancy-title title-center topmargin-sm text-left bottommargin-sm">
                                    <h4 class="font17px color">Prato Principal</h4>
                                </div>

                                <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $menu->prato_principal }}</div>

                                @if(!empty($menu->sobremesa))
                                    <div class="fancy-title title-center topmargin-sm text-left bottommargin-sm">
                                        <h4 class="font17px color">Sobremesa</h4>
                                    </div>

                                    <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $menu->sobremesa }}</div>

                                @endif

                            </div>
                        </div>

                        <br>
                        <div class="divider divider-left nomargin" style="margin-left: 10px !important;"><i class="fa fa-cutlery"></i></div>

                        <div class="bottom-menu">
                            <h4 class="lato" style="font-weight: 300;">R$ {{ $menu->preco }} <small>/por pessoa</small></h4>
                            <a href="/chef/{{ $chef->slug }}/menu/{{ $menu->slug }}" class="pull-right button button-mini button-3d nomargin"><i class="fa fa-book"></i> Reservar</a>
                            <a href="/favorito/salvar/{{ $menu->slug }}/menu" class="pull-right button button-mini button-pink button-3d nomargin"><i class="fa fa-heart"></i> Favoritos</a>
                        </div>

                        <div class="clear"></div>

                    </div>

                </div>

            @endforeach

        @endif

  </div>


    </div>
</div>
@endsection

@section('js')
<script src="/js/jquery.colorbox-min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.item-menu-mais-detalhes').click(function(evt) {
            evt.preventDefault();

            var $parent = $(this).closest('.chef-profile-menu-item');
            var $menu   = $parent.find('.detalhes-menu');

            if ($menu.hasClass('mais-detalhes')) {
                $menu.removeClass('mais-detalhes');
                $(this).find('i').removeClass("fa-minus");
                $(this).find('i').addClass("fa-plus");
            } else {
                $menu.addClass('mais-detalhes');
                $(this).find('i').addClass("fa-minus");
                $(this).find('i').removeClass("fa-plus");
            }

        });

        $('a.gallery').colorbox();

    })
</script>
@endsection