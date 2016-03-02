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
                        Text widget can be used for putting text, images and some other elements in the widget areas. As an example you can add your short description about your hotel and add your logo in this area. Also you can add some useful information like notification in this area.
                    </p>
                   
               </div>

            </div>

            <div class="col_one_third">

                <div class="widget quick-contact-widget widget-linear-divisor clearfix">

                    <h4 class='title-raleway'>Notícias</h4>

                    <p class='footer-desc'>Gostaria de receber notícias e promoções?<br>Se inscreva agora mesmo no nosso newsletter!</p>

                    <div id="quick-contact-form-result" data-notify-type="success" data-notify-msg="<i class=icon-ok-sign></i> Message Sent Successfully!"></div>

                    <form id="quick-contact-form" name="quick-contact-form" action="include/quickcontact.php" method="post" class="quick-contact-form nobottommargin">

                        <div class="form-process"></div>

                        <div class="col_full">
                            <input type="text" placeholder="Email" id="template-contactform-subject" name="template-contactform-subject" value="" class="required sm-form-control gray-dark-input" aria-required="true">
                        </div>

                        <div class="col_full">
                            <button id="quick-newsletter-form" name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d button-rounded button-amber btn-full nomargin">Me Inscrever</button>
                        </div>
    
                    </form>

                    <script type="text/javascript">

                        $("#quick-contact-form").validate({
                            submitHandler: function(form) {
                                $(form).animate({ opacity: 0.4 });
                                $(form).find('.form-process').fadeIn();
                                $(form).ajaxSubmit({
                                    target: '#quick-contact-form-result',
                                    success: function() {
                                        $(form).animate({ opacity: 1 });
                                        $(form).find('.form-process').fadeOut();
                                        $(form).find('.form-control').val('');
                                        $('#quick-contact-form-result').attr('data-notify-msg', $('#quick-contact-form-result').html()).html('');
                                        SEMICOLON.widget.notifications($('#quick-contact-form-result'));
                                    }
                                });
                            }
                        });

                    </script>

                </div>

            </div>


            <div class="col_one_third col_last">

                <div class="widget clearfix widget-linear-divisor" style="background: url('images/world-map.png') no-repeat center center; background-size: 100%; background-position: 13px 50px;">

                    <h4 class='title-raleway'>Contato</h4>
                
                    <div>
                        <address style='margin-bottom: 15px;'>
                            <strong><i class="fa fa-map-marker"></i></strong>
                            Rua das Avencas, 159, Bairro Centro<br>
                            São Paulo - Sâo Paulo
                        </address>
                        <abbr class='noborder' title="Telefone"><i class="fa fa-calendar"></i></abbr> Seg à Sexta 08h às 18h e Sáb até 12h
                        <div class='mini-break'></div>
                        <abbr class='noborder' title="Skype"><i class="fa fa-phone"></i></abbr> (34) 3232-5666
                        <div class='mini-break'></div>
                        <abbr class='noborder' title="Email Address"><i class="fa fa-envelope"></i></abbr> contato@lamesabonita.com.br
                    
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
                &copy; lamesabonita.com.br 2015. Todos os direitos reservados.
            </div>

            <div class="col_half col_last tright">
                <div class="fright clearfix">
                    <div class="copyrights-menu copyright-links nobottommargin">
                        <a href="#">Home</a>/<a href="#">Nossos Chefs</a>/<a href="#">Login</a>/<a href="#">Cadastrar</a>/<a href="#">Sobre nós</a>/<a href="#">FAQ</a>/<a href="#">Contato</a>
                    </div>
                </div>
            </div>

        </div>

    </div><!-- #copyrights end -->

</footer><!-- #footer end -->

<div id="login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div id="login-wrapper">
                        <button id="facebook-login-btn" class="montserrat">
                            <i class="fa fa-facebook"></i>
                            Logar com Facebook
                        </button>
                        <button id="google-login-btn" class="montserrat">
                            <i class="fa fa-google-plus"></i>
                            Entrar com o Google
                        </button>
                        <div id="login-separator">
                            <span class="separator-text">ou</span>
                            <div class='line-hr'></div>
                        </div>
                        <div class='input-icon-left marginbottom10px'>
                            <input type="text" name="login" class="sm-form-control required" placeholder="Digite seu email">
                            <i id="icon-footer-email" class="fa fa-envelope input-icon"></i>
                        </div>
                        <div class='input-icon-left marginbottom10px'>
                            <i id="icon-footer-email" class="fa fa-unlock-alt input-icon"></i>
                            <input type="password" name="password" class="sm-form-control required" placeholder="Digite sua senha">
                        </div>
                        <div class="remember-me-wrapper">   
                            <div class="checkbox">
                                <input type="checkbox" class="checkbox" id="remmber-me" name='remmber-me'>
                                <label for="remmber-me" class="checkbox">
                                    Lembre-se de mim
                                </label>
                            </div>
                            <a href="/forgot_password" class="forgot-password pull-right">Esqueceu a senha?</a>
                        </div>
                        <button id="quick-newsletter-form" name="submit" type="submit" tabindex="5" value="Submit" class="button button-3d button-rounded button-amber btn-full nomargin">Entrar</button>
                         <div id="login-separator">
                            <span class="separator-text">ou</span>
                            <div class='line-hr'></div>
                        </div>
                        <span class='open-sans nao-possui-conta'>Não possui uma conta? <a href="#" data-toggle="modal" data-target="#cadastrar">Cadastre-se agora</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="cadastrar" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div id="login-wrapper">
                        <button id="facebook-cadastrar-btn" class="montserrat">
                            <i class="fa fa-facebook"></i>
                            <span>Criar uma conta com o Facebook</span>
                        </button>
                        <button id="google-cadastrar-btn" class="montserrat">
                            <i class="fa fa-google-plus"></i>
                            <span>Cadastrar-se com o Google</span>
                        </button>
                        <div id="login-separator">
                            <span class="separator-text">ou</span>
                            <div class='line-hr'></div>
                        </div>
                        <button id="criar-conta-email" name="submit" type="submit" tabindex="5" value="Submit" class="button button-3d button-rounded button-amber btn-full nomargin"><i class="fa fa-envelope-o"></i> Criar conta com email</button>
                        <p id="cadastrar-termos" class="open-sans">
                            Ao realizar seu cadastro, você concorda com os <a href="">Termos de Serviço</a>, <a href="">Política de Privacidade</a>, <a href="">Política de Reembolso</a> e <a href="">Termos da Garantia.</a>                              
                        </p>
                         <div id="login-separator" style='margin: 22px 0 11px 0'>
                            <div class='line-hr'></div>
                        </div>
                        <span>Já é um membro LaMesaBonita? <a href="#" target=""><b>Login</b></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>