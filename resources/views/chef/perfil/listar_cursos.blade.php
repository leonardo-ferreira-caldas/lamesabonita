@extends('template')

@inject('cursoRepository', 'App\Repositories\CursoRepository')

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

        @if($chef->cursos->count() == 0)

          <div class='col_full' style="margin-top: 70px;">
              <h3 class='text-center'>Este chef não possuí nenhum curso cadastrado.</h3>
          </div>

        @else

            @foreach($chef->cursos as $curso)

                <div class="backgroundWhite nopadding">

                    @if($curso->imagens->count() > 0)

                        <div class="menu_cover" style="background-image: url('{{ route('image', ['w' => 730, 'h' => 250, 'i' => $curso->fotoCapa() ]) }}');"></div>

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
                                <h3>{{ $curso->titulo }}</h3>
                            </div>

                            <div class="bottommargin-xsm topmargin-xsm">
                                @foreach ($curso->culinarias as $culinaria)
                                    <span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $culinaria->nome_culinaria }}</span>
                                @endforeach

                                @foreach ($curso->refeicoes as $refeicao)
                                    <span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $refeicao->nome_tipo_refeicao }}</span>
                                @endforeach
                            </div>

                            <div class="detalhes-menu">

                                <span>Detalhes do curso<em>:</em></span> {{ $curso->descricao }}

                                <div class="divider"><i class="icon-circle"></i></div>

                                <div class="hide-when-closed">

                                    <div class='col_full lista_incluso_preco'>
                                        <fieldset class="marginbottom10px">
                                            <legend class="marginbottom10px"><label for="titulo">O que está incluso no preço</label></legend>

                                            @foreach ($cursoRepository->buscarListaInclusoPreco() as $incluso_preco)
                                                <div class="checkbox text-left font14px col_full notopmargin checkbox-normalize bottommargin-mini">

                                                    <div>
                                                        <i class="fa fa-check fa-fw"></i> {{ $incluso_preco->descricao }}
                                                    </div>
                                                </div>

                                            @endforeach

                                        </fieldset>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <br>
                        <div class="divider divider-left nomargin" style="margin-left: 10px !important;"><i class="fa fa-cutlery"></i></div>

                        <div class="bottom-menu">
                            <h4>R$ {{ $curso->preco }} <small>/por pessoa</small></h4>
                            {{--<a href="/reservar/escolher-data" class="pull-right button button-mini button-3d nomargin"><i class="fa fa-book"></i> Reservar</a>--}}
                            <a href="#" class="pull-right item-menu-mais-detalhes button button-mini button-leaf button-3d nomargin"><i class="fa fa-plus"></i> Detalhes</a>
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