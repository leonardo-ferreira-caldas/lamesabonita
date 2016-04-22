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
            <h2>Cursos</h2>
        </div>

        @if(count($cursos) == 0)

          <div class='col_full' style="margin-top: 70px;">
              <h3 class='text-center'>Este chef não possuí nenhum curso cadastrado.</h3>
          </div>

        @else

            @foreach($cursos as $curso)

                <div class="backgroundWhite nopadding">

                    @if(count($curso->imagens) > 0)

                        <div class="menu_cover" style="background-image: url('{{ route('image', ['w' => 730, 'h' => 250, 'i' => $curso->foto_capa ]) }}');"></div>

                        <div class="padding20px menu-thumb-pictures">

                            @foreach($curso->imagens as $idx => $imagem)

                                <div class="col_one_fifth menu-item-picture {{ ($idx+1) % 5 == 0 ? 'col_last' : '' }}">
                                    <div class="thumbnail nobottommargin">
                                        <a rel="{{ $curso->slug }}" href='{{ route('image', ['w' => 700, 'h' => 500, 'i' => $imagem->nome_imagem ]) }}' class="gallery">
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
                                <h4>{{ $curso->titulo }}</h4>
                            </div>

                            <div class="bottommargin-xsm topmargin-xsm">
                                {{--@foreach ($curso->culinarias as $culinaria)--}}
                                    {{--<span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $culinaria->nome_culinaria }}</span>--}}
                                {{--@endforeach--}}

                                {{--@foreach ($curso->refeicoes as $refeicao)--}}
                                    {{--<span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $refeicao->nome_tipo_refeicao }}</span>--}}
                                {{--@endforeach--}}
                            </div>

                            <div class="detalhes-menu font14px">

                                <span style="margin-right: 5px;">Detalhes do curso<em>:</em></span>{!! nl2br($curso->descricao) !!}

                            </div>
                        </div>

                        <br>
                        <div class="divider divider-left nomargin" style="margin-left: 10px !important;"><i class="fa fa-cutlery"></i></div>

                        <div class="bottom-menu">
                            <h4 class="lato" style="font-weight: 300;">R$ {{ $curso->preco }} <small>/por pessoa</small></h4>
                            <a href="/chef/{{ $chef->slug }}/curso/{{ $curso->slug }}" class="pull-right button button-mini button-3d nomargin"><i class="fa fa-book"></i> Reservar</a>
                            <a href="/favorito/salvar/{{ $curso->slug }}/curso" class="pull-right button button-mini button-pink button-3d nomargin"><i class="fa fa-heart"></i> Favoritos</a>
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
            var $curso   = $parent.find('.detalhes-menu');

            if ($curso.hasClass('mais-detalhes')) {
                $curso.removeClass('mais-detalhes');
                $(this).find('i').removeClass("fa-minus");
                $(this).find('i').addClass("fa-plus");
            } else {
                $curso.addClass('mais-detalhes');
                $(this).find('i').addClass("fa-minus");
                $(this).find('i').removeClass("fa-plus");
            }

        });

        $('a.gallery').colorbox();

    })
</script>
@endsection