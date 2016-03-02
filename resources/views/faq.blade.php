@extends('template')

@section('after-header')
<!-- Page Title
============================================= -->
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        <h1><span>FAQ</span></h1>
    </div>

</section><!-- #page-title end -->
@endsection


@section('content')
<div class="content-wrap content-wrap-half-padding">

    <div class="container clearfix">

        <!-- Post Content
        ============================================= -->
        <div class="col_full nobottommargin clearfix">

            <div id="faqs" class="faqs">

                <div id="faqs-list" class="fancy-title title-bottom-border">
                    <h3>Algumas de suas perguntas</h3>
                </div>

                <div class="col_half">

                    <div class="fancy-title title-dotted-border title-left">
                        <h2>Cliente</h2>
                    </div>

                    @foreach($cliente as $faqAgrupadoCliente)

                        <div class="fancy-title title-bottom-border">
                            <h5><span>{{ $faqAgrupadoCliente['label'] }}</span></h5>
                        </div>

                        <ul class="iconlist faqlist">

                            @foreach($faqAgrupadoCliente['items'] as $listaAgrupadaCliente)
                                <li>
                                    <i class="icon-caret-right"></i><strong>
                                    <a href="#" data-scrollto="#faq-cliente-{{ $listaAgrupadaCliente->id_faq }}">{{ $listaAgrupadaCliente->pergunta }}</a></strong>
                                </li>
                            @endforeach

                        </ul>

                    @endforeach

                </div>

                <div class="col_half col_last">

                    <div class="fancy-title title-dotted-border title-left">
                        <h2>Chef</h2>
                    </div>

                    @foreach($chef as $faqAgrupadoChef)

                        <div class="fancy-title title-bottom-border">
                            <h5><span>{{ $faqAgrupadoChef['label'] }}</span></h5>
                        </div>

                        <ul class="iconlist faqlist">

                        @foreach($faqAgrupadoChef['items'] as $listaAgrupadaChef)
                            <li>
                                <i class="icon-caret-right"></i><strong>
                                    <a href="#" data-scrollto="#faq-chef-{{ $listaAgrupadaChef->id_faq }}">{{ $listaAgrupadaChef->pergunta }}</a></strong>
                            </li>
                        @endforeach

                        </ul>

                    @endforeach

                </div>

                <div class="clear"></div>

                @foreach($cliente as $faqAgrupadoCliente)

                    <div class="fancy-title title-dotted-border title-center">
                        <h2><span>Chef - {{ $faqAgrupadoCliente['label'] }}</span></h2>
                    </div>

                    @foreach($faqAgrupadoCliente['items'] as $idxCliente => $listaAgrupadaCliente)

                        <h3 id="faq-chef-{{ $listaAgrupadaCliente->id_faq }}"><strong>Q.</strong> {{ $listaAgrupadaCliente->pergunta }}</h3>
                        <p>{{ $listaAgrupadaCliente->resposta }}</p>

                        @if($idxCliente < count($faqAgrupadoCliente['items']) - 1)

                            <div class="divider divider-right"><a href="#" data-scrollto="#faqs-list"><i class="icon-chevron-up"></i></a></div>

                        @endif

                    @endforeach

                @endforeach

                @foreach($chef as $faqAgrupadoChef)

                    <div class="fancy-title title-dotted-border title-center">
                        <h2><span>Chef - {{ $faqAgrupadoChef['label'] }}</span></h2>
                    </div>

                    @foreach($faqAgrupadoChef['items'] as $idxChef => $listaAgrupadaChef)

                        <h3 id="faq-chef-{{ $listaAgrupadaChef->id_faq }}"><strong>Q.</strong> {{ $listaAgrupadaChef->pergunta }}</h3>
                        <p>{{ $listaAgrupadaChef->resposta }}</p>

                        @if($idxChef < count($faqAgrupadoChef['items']) - 1)

                            <div class="divider divider-right"><a href="#" data-scrollto="#faqs-list"><i class="icon-chevron-up"></i></a></div>

                        @endif

                    @endforeach

                @endforeach

            </div>

        </div><!-- .postcontent end -->

        <!-- Sidebar
        ============================================= -->
        {{--<div class="sidebar col_one_third col_last nobottommargin clearfix">--}}
            {{--<div class="sidebar-widgets-wrap">--}}

                {{--<div class="widget widget_links clearfix">--}}

                    {{--<div class="fancy-title title-bottom-border">--}}
                        {{--<h3>Faça uma pergunta</h3>--}}
                    {{--</div>--}}
                    {{----}}
                    {{--<form class="nobottommargin" id="template-contactform" name="template-contactform" action="include/sendemail.php" method="post" novalidate="novalidate">--}}

                        {{--<div class="form-process"></div>--}}

                        {{--<div class="col_full">--}}
                            {{--<label for="template-contactform-name">Nome <small>*</small></label>--}}
                            {{--<input type="text" id="template-contactform-name" name="template-contactform-name" value="" class="sm-form-control required" aria-required="true">--}}
                        {{--</div>--}}

                        {{--<div class="col_full">--}}
                            {{--<label for="template-contactform-email">Email <small>*</small></label>--}}
                            {{--<input type="email" id="template-contactform-email" name="template-contactform-email" value="" class="required email sm-form-control" aria-required="true">--}}
                        {{--</div>--}}

                        {{--<div class="clear"></div>--}}

                        {{--<div class="col_full">--}}
                            {{--<label for="template-contactform-subject">Assunto <small>*</small></label>--}}
                            {{--<input type="text" id="template-contactform-subject" name="template-contactform-subject" value="" class="required sm-form-control" aria-required="true">--}}
                        {{--</div>--}}

                        {{--<div class="clear"></div>--}}

                        {{--<div class="col_full">--}}
                            {{--<label for="template-contactform-message">Mensagem <small>*</small></label>--}}
                            {{--<textarea class="required sm-form-control" id="template-contactform-message" name="template-contactform-message" rows="6" cols="30" aria-required="true"></textarea>--}}
                        {{--</div>--}}

                        {{--<div class="col_full hidden">--}}
                            {{--<input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="sm-form-control">--}}
                        {{--</div>--}}

                        {{--<div class="col_full">--}}
                            {{--<button class="button button-3d nomargin" type="submit" id="template-contactform-submit" name="template-contactform-submit" value="submit">Enviar Pergunta</button>--}}
                        {{--</div>--}}

                    {{--</form>--}}

                {{--</div>--}}

            {{--</div>--}}
        {{--</div><!-- .sidebar end -->--}}

    </div>

</div>
@endsection