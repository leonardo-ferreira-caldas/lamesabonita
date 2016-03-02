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

        <div class="col_one_fourth">
            <div class="feature-box fbox-center fbox-bg fbox-border fbox-effect fbox-small-padding">
                <div class="fbox-icon fbox-icon-chef">
                    <img src='images/icones/chef_ingredientes.jpg' class="fbox-icon-chef-ingredientes" />
                </div>
                <h3>O chef compra os melhores ingredientes</h3>
            </div>
        </div>

        <div class="col_one_fourth">
            <div class="feature-box fbox-center fbox-bg fbox-border fbox-effect fbox-small-padding">
                <div class="fbox-icon fbox-icon-chef">
                    <img src='images/icones/chef_cozinha.jpg' class="fbox-icon-chef-cozinha" />
                </div>
                <h3>O chef cozinha para você na sua casa</h3>
            </div>
        </div>

        <div class="col_one_fourth">
            <div class="feature-box fbox-center fbox-bg fbox-border fbox-effect">
                <div class="fbox-icon fbox-icon-chef">
                    <img src='images/icones/chef_serve_voce.jpg' class="fbox-icon-chef-serve-na-mesa" />
                </div>
                <h3>O chef te serve na mesa</h3>
            </div>
        </div>

        <div class="col_one_fourth col_last">
            <div class="feature-box fbox-center fbox-bg fbox-border fbox-effect">
                <div class="fbox-icon fbox-icon-chef">
                    <img src='images/icones/chef_icone_lava_louca.png' class="fbox-icon-chef-lava-louca" />
                </div>
                <h3>O chef deixa sua cozinha brilhando</h3>
            </div>
        </div>

        <div class="clear"></div>

        <div class="fancy-title title-dotted-border title-right">
            <h3>Comece agora mesmo</h3>
        </div>

        <div class='col_half'>
            <a class="thumbnail">
              <img alt="100%x180" src="images/others/esta_pronto.jpg" style="width: 100%; display: block;">
            </a>
        </div>

        <div class='col_half col_last'>
            <div class="title-block">
                <h3>Está pronto?</h3>
                <span>Em apenas três passos, você já terá reservado seu chef particular</span>
            </div>

            <div class="col_full single-feature">
                <div class="icon-feature"><span>1</span></div>
                <h4>
                    Escolha um menu
                    <small>Navegue dentre todas as variedades culinárias</small>
                </h4>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>

            <div class="col_full single-feature">
                <div class="icon-feature"><span>2</span></div>
                <h4>
                    Conheça seu chef
                    <small>Os melhores chefs do brasil você só encontra aqui</small>
                </h4>
                <div class="clear"></div>
            </div>


            <div class="col_full single-feature">
                <div class="icon-feature"><span>3</span></div>
                <h4>
                    Aproveite!
                    <small>Relaxe enquanto um chef profissional cozinha pra você</small>
                </h4>
            </div>

        </div>

        <div class="clear"></div>

        <div class="fancy-title title-dotted-border title-center">
            <h1>Nossos <span>Testemunhos</span></h1>
        </div>

        <ul class="testimonials-grid clearfix">
            <li style="height: 147px;">
                <div class="testimonial">
                    <div class="testi-image">
                        <a href="#"><img src="images/testimonials/1.jpg" alt="Customer Testimonails"></a>
                    </div>
                    <div class="testi-content">
                        <p>Incidunt deleniti blanditiis quas aperiam recusandae consequatur ullam quibusdam cum libero illo rerum!</p>
                        <div class="testi-meta">
                            John Doe
                            <span>XYZ Inc.</span>
                        </div>
                    </div>
                </div>
            </li>
            <li style="height: 147px;">
                <div class="testimonial">
                    <div class="testi-image">
                        <a href="#"><img src="images/testimonials/2.jpg" alt="Customer Testimonails"></a>
                    </div>
                    <div class="testi-content">
                        <p>Natus voluptatum enim quod necessitatibus quis expedita harum provident eos obcaecati id culpa corporis molestias.</p>
                        <div class="testi-meta">
                            Collis Ta'eed
                            <span>Envato Inc.</span>
                        </div>
                    </div>
                </div>
            </li>
            <li style="height: 147px;">
                <div class="testimonial">
                    <div class="testi-image">
                        <a href="#"><img src="images/testimonials/4.jpg" alt="Customer Testimonails"></a>
                    </div>
                    <div class="testi-content">
                        <p>Fugit officia dolor sed harum excepturi ex iusto magnam asperiores molestiae qui natus obcaecati facere sint amet.</p>
                        <div class="testi-meta">
                            Mary Jane
                            <span>Google Inc.</span>
                        </div>
                    </div>
                </div>
            </li>
            <li style="height: 147px;">
                <div class="testimonial">
                    <div class="testi-image">
                        <a href="#"><img src="images/testimonials/3.jpg" alt="Customer Testimonails"></a>
                    </div>
                    <div class="testi-content">
                        <p>Similique fugit repellendus expedita excepturi iure perferendis provident quia eaque. Repellendus, vero numquam?</p>
                        <div class="testi-meta">
                            Steve Jobs
                            <span>Apple Inc.</span>
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
//        $(".title-home span").Morphext({
//            animation: shuffle[0],
//            separator: ",",
//            speed: 5000
//        });
//        $(".title-home div").Morphext({
//            animation: shuffle[1] || shuffle[0],
//            separator: ",",
//            speed: 5000
//        });

        $("#city_chef").focus();
    });
</script>
@endsection