@extends('template')

@section('after-header')
<section id="slider" class="swiper_wrapper slide-home clearfix">
    <div class="swiper-container swiper-parent">
        <div class="swiper-wrapper">
            <div class="swiper-slide home-landing-background">
                <div class='overlay'>
                    <div class="container clearfix">
                        <div class="title-home">
                            <span class='roboto'>
                                Encontre o menu perfeito para você
                            </span>
                            <div>
                                Venha conhecer um mundo de sabores que você nunca experimentou
                            </div>
                        </div>
                        <div id="home-align-search">
                            <div id="home-search">
                                <div id="title" class="open-sans">
                                    <i class="fa fa-cutlery"></i> <span>Encontre seu menu agora</span>
                                </div>
                                <div class="body">
                                    @include('busca_menus_cursos.formulario')
                                   <div class='clear'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="slide-number"><div id="slide-number-current"></div><span></span><div id="slide-number-total"></div></div>
        </div>
    </div>
</section>
@overwrite

@section('content')
<div class="content-wrap content-wrap-half-padding">

    <div class="container clearfix">

        <div class="divider divider-short divider-rounded divider-center dividir-lmb">
            <i>Como Funciona</i>
        </div>

        <div class="clear"></div>

        <div class="como-funciona-wrapper topmargin-sm">

            <div class="como-funciona-items">

                <div class="col_one_fourth bottommargin-sm">
                    <div class="center">
                        <img src='/images/icones/chef_icone_grocery.png' class="fbox-icon-chef-ingredientes" />
                    </div>
                    <div class="center topmargin-sm bottommargin-xsm">
                        <span class="como-funciona-number">1</span>
                    </div>

                    <h3 class='como-funciona-text '>O chef compra os melhores ingredientes</h3>
                </div>

                <div class="col_one_fourth bottommargin-sm">
                    <div class="center">
                        <img src='/images/icones/chef_icone_cozinha.png' class="fbox-icon-chef-ingredientes" />
                    </div>
                    <div class="center topmargin-sm bottommargin-xsm">
                        <span class="como-funciona-number">2</span>
                    </div>

                    <h3 class='como-funciona-text topmargin-sm'>O chef cozinha para você e seus convidados</h3>
                </div>

                <div class="col_one_fourth bottommargin-sm">
                    <div class="center">
                        <img src='/images/icones/chef_icone_apresenta_menu.png' class="fbox-icon-chef-ingredientes" />
                    </div>
                    <div class="center topmargin-sm bottommargin-xsm">
                        <span class="como-funciona-number">3</span>
                    </div>

                    <h3 class='como-funciona-text topmargin-sm'>O chef apresenta o menu</h3>
                </div>

                <div class="col_one_fourth col_last bottommargin-sm">
                    <div class="center">
                        <img src='/images/icones/chef_icone_limpeza.png' class="fbox-icon-chef-ingredientes" />
                    </div>
                    <div class="center topmargin-sm bottommargin-xsm">
                        <span class="como-funciona-number">4</span>
                    </div>

                    <h3 class='como-funciona-text topmargin-sm'>O chef organiza sua cozinha</h3>
                </div>

            </div>

            <hr>

        </div>

        <div class="clear"></div>

        <div class="center topmargin-sm">
            <a href="/nossos-menus-cursos" class="button button-3d button-large button-rounded">Veja nossa lista de menus</a>
        </div>

    </div>

    <div class="clear"></div>

    <div class="section topmargin-lg notopborder" style="padding: 40px 0px 60px;">

        <div class="container center clearfix">
            <div class="heading-block" id="suporte">
                <h2>Conheça alguns de nossos menus</h2>
                <span class="sou-chef-lmb-subtitulo">ESCOLHA E RESERVE SEU MENU PREFERIDO. NOSSOS CHEFS PREPARAM NA SUA CASA.</span>
            </div>

            <div class="clear"></div>

            <div>
                @foreach($menus as $menu)

                    <article class="portfolio-item pf-media pf-icons nomargin">
                        <div class="portfolio-image">
                            <a href="portfolio-single.php">
                                <img src="{{ crop($menu->foto_capa, 284, 213) }}" alt="Open Imagination" style="visibility: visible; opacity: 1; display: block;">
                            </a>
                            <div class="portfolio-overlay">
                                <div class="portfolio-desc" style="margin-top: 53.5px;">
                                    <h3><a href="/chef/{{ $menu->chef_slug }}/menu/{{ $menu->slug }}">{{ $menu->titulo }}</a></h3>
                                    <span>Chef {{ $menu->nome_completo }}</span>
                                </div>
                                <a href="/chef/{{ $menu->chef_slug }}/menu/{{ $menu->slug }}" class="left-icon"><i class="icon-line-plus"></i></a>
                            </div>
                        </div>
                    </article>

                @endforeach
            </div>

            <div class="clear"></div>

            <div class="center topmargin-sm">
                <a href="/nossos-menus-cursos" class="button button-3d button-large button-rounded">Ver lista completa de menus</a>
            </div>

        </div>

    </div>

    <div class="clear"></div>

    <div class="container clearfix">

        <div class="clear"></div>

        <div class="fancy-title title-dotted-border title-center">
            <h1>Nossos <span>Testemunhos</span></h1>
        </div>

        <ul class="testimonials-grid clearfix">
            <li style="height: 147px;">
                <div class="testimonial">
                    <div class="testi-content">
                        <p>É a segunda experiência com a equipe de La Mesa Bonita.
                            <br>
                            Refeição glamoroso, com muito carinho, requinte e sabor. Além da praticidade de ter uma equipe eficiente e pratica para qualquer momento.</p>
                        <div class="testi-meta">
                            Beth
                        </div>
                    </div>
                </div>
            </li>
            <li style="height: 147px;">
                <div class="testimonial">
                    <div class="testi-content">
                        <p>La Mesa Bonita permite proporcionar em nossas casas um encontro com o melhor da gastronomia. Basta escolher um chef e acertar o menu. A experiência degustativa é deprimeira, da entrada à sobremesa, ou melhor, ao chocolatinho do café!</p>
                        <div class="testi-meta">
                            Maria
                        </div>
                    </div>
                </div>
            </li>
            <li style="height: 147px;">
                <div class="testimonial">
                    <div class="testi-content">
                        <p>Adorei o almoco e a companhia de vcs na sua linda casa! Quanto avaliacao: a comida nota 10, apresentacao 10, atendimento e simpatia dos chefs 10.</p>
                        <div class="testi-meta">
                            Marcia
                        </div>
                    </div>
                </div>
            </li>
            <li style="height: 147px;">
                <div class="testimonial">
                    <div class="testi-content">
                        <p>Experiência agradável que traz o requinte de um restaurante mas com o toque pessoaldos anfitriões! Cardápios que atendem ao paladar dos que gostam de novidades até os mais tradicionais!</p>
                        <div class="testi-meta">
                            Elide
                        </div>
                    </div>
                </div>
            </li>
            <li style="height: 147px; width: 100%">
                <div class="testimonial">
                    <div class="testi-content">
                        <p>La Mesa Bonita: Um experiência única, no aconchego da sua casa, os chefes Victor e Daniela criaram especiarias com sabores regionais espetaculares; geleia de umbu, molho de buriti, peixe grelhado com banana defumada e sorvete artesanal de camburi. Cozinha criativa, de qualidade, leveza, sofisticação e brasileiríssima!</p>
                        <div class="testi-meta">
                            Ana Laura
                        </div>
                    </div>
                </div>
            </li>
        </ul>

    </div>

</div>

@if(!$auth->isLoggedIn())
    <div class="promo promo-light promo-custom promo-custom-bordertop promo-full">
        <div class="container clearfix">
            <h3 class='weight-normal'>Gostaria de se cadastrar como chef na La Mesa Bonita?</h3>
            <a href="/sou-chef" class="button button-rounded button-reveal button-large button-amber tright">
                <i class="icon-line-arrow-right"></i><span>Sim, eu gostaria</span>
            </a>
        </div>
    </div>
@endif
@endsection

@section('js')
<script type="text/javascript" src='/js/morphext.min.js'></script>
<script type='text/javascript'>
    $(document).ready(function() {
        var animations = [["fadeInUp","fadeInDown"],["fadeInLeft","fadeInRight"]];
        var shuffle    = animations[Math.floor(Math.random()*animations.length)];

        $("#city_chef").focus();
    });
</script>
@endsection