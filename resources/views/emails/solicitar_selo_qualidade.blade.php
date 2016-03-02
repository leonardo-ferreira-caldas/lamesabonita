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
                                        <h2>Prezado Chef Parceiro La Mesa Bonita</h2>
                                    </td>
                                </tr>
                                <tr>
                                <tr>
                                    <td class="content-block">
                                        Estamos muito contentes com a notícia de que você tem interesse em se tornar um chef certificado com o Selo LMB. É uma oportunidade para você ter seu perfil e seus menus destacados no site e ser reconhecido pela qualidade do seu serviço. Os clientes podem confiar de olhos fechados nos chefs parceiros La Mesa Bonita que possuam o Selo LMB.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block line-space">
                                        Em breve entraremos em contato para acertar todos os detalhes do evento. Utilizaremos sua agenda disponível no site para definir uma data que seja adequada tanto para você quanto para os membros do Júri LMB.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block line-space">
                                        Cordialmente,<br>
                                        Equipe La Mesa Bonita
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">Você solicitou o selo de qualidade La Mesa Bonita.</td>
                        </tr>
                        <tr>
                            <td class="aligncenter content-block">Acesse <a itemprop="url" href="https://lamesabonita.com">www.lamesabonita.com</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>