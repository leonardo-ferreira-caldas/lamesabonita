<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="UTF-8">
    <title>{{ $assunto }}</title>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage">

@include('emails.css.bemvindo_css')

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table width="100%">
                    <tr>
                        <td class="aligncenter content-block">
                            <img width="280" src='{{ env('WEBSITE_URL') }}/images/logo.png' />
                        </td>
                    </tr>
                </table>
                <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction">

                    <tr>
                        <td class="content-wrap">
                            <meta itemprop="name" content="Confirm Email"/>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block">
                                        <h2>Bem vindo ao La Mesa Bonita!</h2>
                                    </td>
                                </tr>
                                <tr>
                                <tr>
                                    <td class="content-block">
                                        Você está recebendo este e-mail porque visitou nosso site e preencheu o cadastro para tornar-se um chef parceiro La Mesa Bonita.
                                        <br>
                                        Pedimos a gentileza de confirmar seu interesse clicando no link abaixo:
                                    </td>
                                </tr>
                                <tr>
                                    <td class="aligncenter content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler">
                                        <a href="{{ $url_confirmacao }}" class="btn-primary" itemprop="url">Clique aqui para confirmar seu e-mail</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block line-space">
                                        Ao clicar no link acima, você será direcionado para uma página que confirmará seu cadastro e trará todas as orientações necessárias para o preenchimento de todos os dados necessários para compor seu perfil La Mesa Bonita da melhor forma possível.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">Você se cadastrou com sucesso na LaMesaBonita.</td>
                        </tr>
                        <tr>
                            <td class="aligncenter content-block">Acesse <a itemprop="url" href="https://lamesabonita.com">www.lamesabonita.com</a></td>
                        </tr>
                    </table>
                </div></div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>