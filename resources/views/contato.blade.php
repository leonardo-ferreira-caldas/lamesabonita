@extends('template')

@section('after-header')
<!-- Page Title
============================================= -->
<section id="page-title" class="page-title-center" style="background-image: url('/images/landing/inner_background_title_1.jpg') !important;">

    <div class="container clearfix">
        <h1><span>Contato</span></h1>
    </div>

</section><!-- #page-title end -->
@endsection

@section('content')
<div class="container inner-pages">

    <!-- Contact Form
    ============================================= -->
    <div class="col_two_third">

        <div class="fancy-title title-dotted-border">
            <h3>Fale Conosco</h3>
        </div>

        <form class="nobottommargin" action="/contato/enviar" method="POST">

            @include('includes.errors')

            {!! csrf_field() !!}

            <div class="col_two_third">
                <label for="name">Nome <small>*</small></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="sm-form-control required" />
            </div>

            <div class="col_one_third col_last">
                <label for="subject">Assunto <small>*</small></label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required class="sm-form-control" />
            </div>

            <div class="clear"></div>

            <div class="col_two_third">
                <label for="email">Email <small>*</small></label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" required class="required sm-form-control" />
            </div>

            <div class="col_one_third col_last">
                <label for="telephone">Telefone</label>
                <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}" class="sm-form-control" />
            </div>

            <div class="clear"></div>

            <div class="col_full">
                <label for="message">Mensagem <small>*</small></label>
                <textarea class="required sm-form-control" id="message" name="message" rows="6" cols="30">{{ old('message') }}</textarea>
            </div>

            <div class="col_full">
                <button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d nomargin">Enviar</button>
            </div>

        </form>

    </div><!-- Contact Form End -->

    <!-- Google Map
    ============================================= -->
    <div class="col_one_third col_last">

        <div class="fancy-title title-dotted-border">
            <h3>Contatos</h3>
        </div>

        <div class="title-block">
            <h4><span><i class="fa fa-envelope"></i> E-mail</span></h4>
            <span>contato@lamesabonita.com</span>
        </div>

        <div class="title-block">
            <h4><span><i class="fa fa-phone"></i> Telefones</span></h4>
            <span>(11) 94534‑7424</span>
        </div>

    </div>

    <div class="clear"></div>

    {{--<div class="col_full">--}}

        {{--<div class="fancy-title title-dotted-border">--}}
            {{--<h3>Localização</h3>--}}
        {{--</div>--}}

        {{--<section id="google-map" class="gmap" style="height: 410px;"></section>--}}

        {{--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>--}}
        {{--<script type="text/javascript" src="js/jquery.gmap.js"></script>--}}

        {{--<script type="text/javascript">--}}

            {{--jQuery('#google-map').gMap({--}}

                {{--address: 'Rua Quartzo, 237 - Uberlândia - Minas Gerais',--}}
                {{--maptype: 'ROADMAP',--}}
                {{--zoom: 14,--}}
                {{--markers: [--}}
                    {{--{--}}
                        {{--address: "Rua Quartzo, 237 - Uberlândia - Minas Gerais",--}}
                        {{--html: '<div style="width: 300px;"><h4 style="margin-bottom: 8px;">Endereço <span>LaMesaBonita</span></h4><p class="nobottommargin">Rua Quartzo, 237<br>Bairro Jardim Patrícia<br>Uberlândia - Minas Gerais</p></div>',--}}
                        {{--icon: {--}}
                            {{--image: "images/icons/map-icon-red.png",--}}
                            {{--iconsize: [32, 39],--}}
                            {{--iconanchor: [32,39]--}}
                        {{--}--}}
                    {{--}--}}
                {{--],--}}
                {{--doubleclickzoom: false,--}}
                {{--controls: {--}}
                    {{--panControl: true,--}}
                    {{--zoomControl: true,--}}
                    {{--mapTypeControl: true,--}}
                    {{--scaleControl: true,--}}
                    {{--streetViewControl: false,--}}
                    {{--overviewMapControl: false--}}
                {{--}--}}

            {{--});--}}

        {{--</script>--}}

    {{--</div>--}}

    <div class="clear"></div>

</div>
@endsection
