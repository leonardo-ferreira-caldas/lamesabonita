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
                        <h2 class="lato fontlight nobottommargin notopmargin">Grand Plaza Serviced Apartments</h2>
                        <div class="mini-foto-perfil">
                            <img class="img-circle rightmargin-xsm" src="{{ crop($chef->avatar ?: 'avatar.jpg', 40, 40) }}">
                            {{ $chef->user->name . " " . $chef->sobrenome }} (<small><a href="{{ route('chef', ['slug' => $chef->slug]) }}" class="lato uppercase">Ver perfil</a></small>)
                            <span class="leftmargin-xsm color">{!! $chef->getReputacaoMedia() !!}</span>
                            <a href="/favorito/salvar/{{ $curso->slug }}/curso" class="leftmargin-xsm button button-mini button-pink button-3d nomargin">
                                <i class="fa fa-heart"></i> Favoritos
                            </a>

                            <h3 class="preco-menu-detalhes marginbottom10px pull-right lato">R$ {{ $curso->preco }} <small class="roboto">por pessoa</small></h3>
                        </div>

                    </div>

                    <div class="padding20px notoppadding norightpadding">

                        <div class="topdottedborder bottommargin-sm"></div>

                        <div class="clear"></div>

                        <div class="fslider" data-animation="fade" data-thumbs="true" data-arrows="true" data-speed="500" data-pause="5000">
                            <div class="flexslider">
                                <div class="slider-wrap">

                                    @foreach($curso->imagens as $idx => $picture)

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

                            @foreach ($curso->culinarias as $culinaria)
                                <span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $culinaria->nome_culinaria }}</span>
                            @endforeach

                            @foreach ($curso->refeicoes as $refeicao)
                                <span class="backgroundWhite bottommargin-xsm inline-block padding-xxsm rightmargin-xxsm">{{ $refeicao->nome_tipo_refeicao }}</span>
                            @endforeach


                            <div class="detalhes-menu">

                                <div class="fancy-title title-center topmargin-sm text-left bottommargin-sm">
                                    <h4 class="font17px color">Descrição do Curso</h4>
                                </div>

                                <div class="font14px text-center topmargin-sm bottommargin-sm">{{ $curso->descricao }}</div>


                                <div class="fancy-title title-center topmargin-sm text-left bottommargin-sm">
                                    <h4 class="font17px color">Incluso no Preço</h4>
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
                        'tipo'               => 'curso',
                        'slug'               => $curso->slug,
                        'qtd_maxima_cliente' => $curso->qtd_maxima_cliente
                    ])

                </div>

                <div class="clear"></div>

            </div>

            @include ('includes.avaliacoes', [
                'id_produto' => $curso->id_curso,
                'tipo'       => 'curso'
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