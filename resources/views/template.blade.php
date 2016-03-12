<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">

    <!-- Stylesheets
    ============================================= -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="//fonts.googleapis.com/css?family=Playball|Montserrat:400,700|Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic|Open+Sans:400italic,400,300,300italic,600|Roboto:400,300,100,500,700" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/lamesabonita.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if lt IE 9]>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js">4</script>
    <![endif]-->

    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/plugins.js"></script>
    <script type="text/javascript" src="/js/utils.js"></script>
    <script type="text/javascript" src='/js/jquery.autocomplete.js'></script>
    <script type="text/javascript" src="/js/jquery.maskmoney.js"></script>
    <script type="text/javascript" src="/js/bootstrap-datepicker.min.js"></script>

    <script src="/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/sweetalert.css">

    <!-- Document Title
    ============================================= -->
    <title>La Mesa Bonita</title>

    @yield('head')
</head>

<body class="stretched no-transition">

    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Header
        ============================================= -->
        <header id="header" class="@yield('header-class')" data-sticky-class="not-dark">

            <div id="header-wrap">

                <div class="container clearfix">

                    @include('menu_superior')

                </div>

            </div>

        </header><!-- #header end -->

        @yield('after-header')

        <!-- Content
        ============================================= -->
        <section id="content" class="@yield('container-class')">

            @yield('content')

        </section><!-- #content end -->

        <!-- Footer
        ============================================= -->
        <footer id="footer" class="dark">

            <div class="container">

                <!-- Footer Widgets
                ============================================= -->
                <div class="footer-widgets-wrap clearfix">

                    <div class="col_one_third">

                        <div class="widget clearfix">
                            <h4 class='title-raleway'>Sobre Nós</h4>

                            <p class='footer-desc'>
                                Combine a qualidade gastronômica de um bom restaurante com a simpatia de um personal chef no conforto da sua casa. Seja para um almoço entre amigos, um jantar romântico, um aniversário ou um curso de alta gastronomia: La Mesa Bonita oferece sempre uma experiência única.
                            </p>
                           
                       </div>

                    </div>

                    <div class="col_one_third">

                        <div class="widget quick-contact-widget widget-linear-divisor clearfix">

                            <h4 class='title-raleway'>Notícias</h4>

                            <p class='footer-desc'>Gostaria de receber notícias e promoções?<br>Se inscreva agora mesmo no nosso newsletter!</p>

                            <div id="quick-contact-form-result" data-notify-type="success" data-notify-msg="<i class=icon-ok-sign></i> Message Sent Successfully!"></div>

                            <form id="newsletter-form" name="newsletter-form" action="/newsletter" method="POST" class="quick-contact-form nobottommargin">

                                {!! csrf_field() !!}

                                <div class="form-process"></div>

                                <div class="col_full">
                                    <input type="text" placeholder="Email" id="email-newsletter" name="email" value="" class="required sm-form-control gray-dark-input" aria-required="true">
                                </div>

                                <div class="col_full">
                                    <button id="quick-newsletter-form" name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d button-rounded btn-full nomargin">Inscreva-se aqui</button>
                                </div>
            
                            </form>

                        </div>

                    </div>


                    <div class="col_one_third col_last">

                        <div class="widget clearfix widget-linear-divisor" style="background: url('/images/world-map.png') no-repeat center center; background-size: 100%; background-position: 13px 50px;">

                            <h4 class='title-raleway'>Contato</h4>
                        
                            <div>
                                <address style='margin-bottom: 15px;'>
                                    Você tem uma dúvida? Entre em contato conosco através do telefone ou email listados abaixo:
                                </address>
                                <div class='mini-break'></div>
                                <abbr class='noborder' title="Skype"><i class="fa fa-phone"></i></abbr> (11) 94534‑7424
                                <div class='mini-break'></div>
                                <abbr class='noborder' title="Email Address"><i class="fa fa-envelope"></i></abbr> contato@lamesabonita.com
                            
                                <ul id="social-icons" class="list-unstyled list-inline">
                                    <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                    <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                    <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                                </ul>


                            </div>

                        </div>

                    </div>

                </div><!-- .footer-widgets-wrap end -->

            </div>

            <!-- Copyrights
            ============================================= -->
            <div id="copyrights">

                <div class="container clearfix">

                    <div class="col_half">
                        &copy; lamesabonita.com 2015. Todos os direitos reservados.
                    </div>

                    <div class="col_half col_last tright">
                        <div class="fright clearfix">
                            <div class="copyrights-menu copyright-links nobottommargin">
                                <a href="/">Home</a>/
                                <a href="/nossos-chefs">Nossos Chefs</a>/
                                <a href="/login">Login</a>/
                                <a href="/sou-chef/cadastrar">Cadastrar</a>/
                                <a href="/sobre-nos">Sobre nós</a>/
                                <a href="/faq">FAQ</a>/
                                <a href="/contato">Contato</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div><!-- #copyrights end -->

        </footer><!-- #footer end -->

    </div><!-- #wrapper end -->

    <div id="login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div id="login-wrapper">
                            <div class="col_full marginbottom10px">
                                <a href="{{ url('facebook/login') }}" class="button btn-full button-3d button-rounded button-facebook text-center button-blue"><i class="fa fa-facebook"></i> ENTRAR COM FACEBOOK</a>
                            </div>

                            <div class="col_full marginbottom10px">
                                <a href="#" class="button btn-full button-3d button-rounded button-google-plus text-center button-red"><i class="fa fa-google-plus"></i> ENTRAR COM O GOOGLE+</a>
                            </div>
                            <div id="login-separator">
                                <span class="separator-text">ou</span>
                                <div class='line-hr'></div>
                            </div>
                            <form method="POST" class="nomargin" action="/login" >
                                {!! csrf_field() !!}

                                <input style="display:none;" type="text" name="avoidAutoFillEmail" />
                                <input style="display:none;" type="password" name="avoidAutoFillPassword" />
                            
                                <div class='input-icon-left marginbottom10px'>
                                    <input
                                        type="text"
                                        name="email"
                                        required
                                        autofill="off"
                                        autocapitalize="off" 
                                        autocorrect="off"
                                        class="sm-form-control required"
                                        placeholder="Digite seu email"
                                    >
                                    <i id="icon-footer-email" class="fa fa-envelope input-icon"></i>
                                </div>
                                <div class='input-icon-left marginbottom10px'>
                                    <i id="icon-footer-email" class="fa fa-unlock-alt input-icon"></i>
                                    <input
                                        type="password"
                                        name="password"
                                        required
                                        autofill="off"
                                        autocapitalize="off"
                                        autocorrect="off"
                                        autocomplete="off"
                                        class="sm-form-control required"
                                        placeholder="Digite sua senha"
                                    >
                                </div>
                                <div class="remember-me-wrapper">   
                                    <div class="checkbox">
                                        <input type="checkbox" class="checkbox" id="remember" name='remember'>
                                        <label for="remember" class="checkbox">
                                            Lembre-se de mim
                                        </label>
                                    </div>
                                    <a href="{{ url('recuperar-senha') }}" class="forgot-password pull-right">Esqueceu a senha?</a>
                                </div>
                                <button class="button btn-full nomargin button-3d nomargin" id="login-form-submit" name="login-form-submit" value="login"><i class="fa fa-check-square-o"></i> ENTRAR</button>
                            </form>
                             <div id="login-separator">
                                <span class="separator-text">ou</span>
                                <div class='line-hr'></div>
                            </div>
                            <span class='open-sans nao-possui-conta'>Não possui uma conta? <a href="/registrar">Cadastre-se agora</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('footer.html')

    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>

     @yield('js')

    <!-- Footer Scripts
    ============================================= -->
    <script type="text/javascript" src="/js/functions.js"></script>
    <script type="text/javascript" src="/js/form-ajax.js"></script>

    @if(session()->has('sweet_alert'))
    <script type="text/javascript">
        swal({
            title: "{!! session('sweet_alert.title') !!}",
            text: "{!! session('sweet_alert.message') !!}",
            type: "{{ session('sweet_alert.type') }}",
            confirmButtonText: "OK"
        });
    </script>
    @endif

</body>
</html>