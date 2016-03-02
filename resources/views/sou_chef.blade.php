@extends('template')

@section('head')
<link rel="stylesheet" type="text/css" href="/css/animate.css">
@endsection

@section('after-header')
<section id="slider" class="mb-noheight swiper_wrapper slide-home clearfix chef-landing-background-wrapper mb-topmargin-sm">
    <div class="swiper-container swiper-parent nobgmobile">
        <div class="swiper-wrapper">
            <div class="swiper-slide chef-landing-background nobgmobile">
                <div class="overlay-wrapper nobgmobile" style="background: rgba(0, 0, 0, 0.3);">
                    <div class="container clearfix">
                        <div class='row'>
                            <div class='col-md-12 text-center'>
                                <div class="title-home">
                                    <p class="title-sou-chef-lead mb-font-md">AUMENTE O ALCANCE DA SUA CULINÁRIA</p>
                                    <span class='roboto title-sou-chef mb-font-md'>
                                        Seja um chef La Mesa Bonita!
                                    </span>
                                    <div class="subtitle-sou-chef mb-font-medium mb-topmargin-sm">
                                        Crie seu perfil e multiplique as oportunidades para crescer em sua carreira. Participe desse novo conceito de gastronomia e faça parte da rede de chefs La Mesa Bonita.
                                    </div>

                                    <br>
                                    <div class='col_full'>
                                        <a href="/sou-chef/cadastrar" class="btn-cool mb-btn-full nomargin mb-padding-xsm mb-bottompadding-xxsm mb-toppadding-xxsm" style="margin-right: 30px !important;" id="login-form-submit" name="login-form-submit">
                                            <i class="fa fa-sign-in fa-lg"></i>
                                            Cadastre-se e crie seu perfil
                                        </a>
                                        <div class="clear hidden mb-show mb-topmargin-sm"></div>

                                        <a href="/login" class="btn-cool nomargin mb-btn-full mb-padding-xsm mb-bottompadding-xxsm mb-toppadding-xxsm" id="login-form-submit" name="login-form-submit">
                                            <i class="fa fa-user"></i> acesse sua conta
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="slide-number"><div id="slide-number-current"></div><span></span><div id="slide-number-total"></div></div>
    </div>

</section>
@overwrite

@section('content')
<div class="divider divider-short divider-center hidden mb-show"><i class="icon-circle"></i></div>

<div class="content-wrap content-wrap-half-padding mb-notoppadding" style="padding-bottom: 0px;">

    <div class="section lmb-gerencie-atividades nomargin notopborder nobg" style="padding: 0;">
        <div class="container center clearfix">

            <h4 class="font-open-sans">Menu Navegação</h4>

            <ul class="pagination nomargin bottommargin-sm sou-chef-pagination">
                <li><a class='mb-noleftmargin mb-noradius mb-block mb-nofloat' href="#" data-scrollto="#como-funciona"><i class="fa fa-question"></i> Como Funciona</a></li>
                <li><a class='mb-noleftmargin mb-noradius mb-block mb-nofloat' href="#" data-scrollto="#rede-lmb"><i class="fa fa-sitemap"></i> A Rede La Mesa Bonita</a></li>
                <li><a class='mb-noleftmargin mb-noradius mb-block mb-nofloat' href="#" data-scrollto="#precos"><i class="fa fa-credit-card"></i> Preços</a></li>
                <li><a class='mb-noleftmargin mb-noradius mb-block mb-nofloat' href="#" data-scrollto="#suporte"><i class="fa fa-envelope-o"></i> Suporte</a></li>
                <li><a class='mb-noleftmargin mb-noradius mb-block mb-nofloat' href="#" data-scrollto="#seus-deveres"><i class="fa fa-check-square-o"></i> Seu Deveres</a></li>
            </ul>

            <div class="divider divider-short divider-center"><i class="icon-circle"></i></div>

            <div class="heading-block" id="como-funciona">
                <h2>COMO FUNCIONA</h2>
                <span class='sou-chef-lmb-subtitulo'>La Mesa Bonita oferece ao chef total autonomia para definir tudo o que diz respeito ao seu trabalho e perfil, através de uma plataforma intuitiva.</span>
            </div>

            <div class="clear"></div>

            <div class="row gerenciar-tarefas-chef">

                <div class="col-md-3 gerenciar-tarefa-box dark col-padding mb-padding-sm ohidden" style="background-color: rgb(26, 188, 156);">
                    <div>
                        <h3 class="uppercase mb-font-big">Perfil, menus e agenda</h3>
                        <p class='mb-font-medium'>Você monta seu perfil de acordo com suas características profissionais e preferências, cria seus menus e define seus preços, determina seus dias e horários disponíveis e a distância que está disposto a percorrer até o cliente: você é o dono da sua imagem. Todas essas informações podem ser alteradas a qualquer momento, acessando sua conta com sua senha pessoal.</p>
                        <i class="fa fa-user bgicon"></i>
                    </div>
                </div>

                <div class="col-md-3 dark gerenciar-tarefa-box col-padding mb-padding-sm ohidden" style="background-color: rgb(52, 73, 94);">
                    <div>
                        <h3 class="uppercase mb-font-big">Reservas e pagamentos</h3>
                        <p class='mb-font-medium'>O cliente escolhe um menu entre as opções oferecidas e faz o pagamento pelo site La Mesa Bonita no momento da reserva. Isso é a garantia de que você receberá por seu trabalho. Após o evento, nós repassamos os valores para sua conta bancária, com o desconto da comissão La Mesa Bonita. Isso poupa você do desgaste de tratar questões financeiras com o cliente.</p>
                        <i class="icomoon-credit-card bgicon"></i>
                    </div>
                </div>

                <div class="col-md-3 dark gerenciar-tarefa-box col-padding mb-padding-sm ohidden" style="background-color: rgb(231, 76, 60);">
                    <div>
                        <h3 class="uppercase mb-font-big">Contato com<br>O cliente</h3>
                        <p class='mb-font-medium'>Após a reserva, você contata diretamente o cliente e alinha todos os detalhes, para que tudo ocorra sem surpresas no dia do evento. Isso permite que você saiba com antecedência exatamente a estrutura que a cozinha do local oferece, além de outras questões relevantes, como a sugestão das bebidas mais adequadas, cuja compra é de responsabilidade do cliente.</p>
                        <i class="fa fa-envelope-o bgicon"></i>
                    </div>
                </div>

                <div class="col-md-3 dark gerenciar-tarefa-box col-padding mb-padding-sm ohidden" style="background-color: #e67e22;">
                    <div>
                        <h3 class="uppercase mb-font-big">No dia do<br>evento</h3>
                        <p class='mb-font-medium'>Você chegará na casa do cliente com antecedência para preparar seu menu, levando os ingredientes e equipamentos que não estejam disponíveis. A presença de um chef profissional em casa é uma atração especial para o cliente e seus convidados: aproveite para explicar os detalhes dos pratos e fale da sua carreira e formação como chef. No final, é responsabilidade do chef arrumar e limpar a cozinha.</p>
                        <i class="fa fa-calendar bgicon"></i>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="divider divider-short divider-center"><i class="icon-circle"></i></div>

    <div class="section notopborder nomargin nobgmobile bottompaddign-xt mb-nobottompadding" style="background: url('/images/backgrounds/background_chef_rede.jpg'); background-position: center; background-size: cover;">

        <div class="container clearfix">

            <div class="heading-block dark center nobottomborder bottommargin-lg" id="rede-lmb">
                <h1 class="mb-light">A REDE LA MESA BONITA</h1>
                <span class="sou-chef-lmb-subtitulo mb-light" style="color: #fff">Criamos a rede de chefs La Mesa Bonita para revelar e divulgar chefs talentosos e profissionais a uma rede de clientes que compartilham o amor pela gastronomia.</span>
            </div>

            <div class="col_one_third topmargin nobottommargin">
                <div class="feature-box fbox-personalized fbox-center fbox-outline">
                    <div class="fbox-icon" style="border-color: #708090;">
                        <i class="icomoon-price-ribbon i-alt" style="font-size: 60px; background-color:#708090"></i>
                    </div>
                    <h3 class="marginbottom10px">SELO DE <span>QUALIDADE</span></h3>
                    <p>Você pode ter seu perfil e seus menus destacados no site ao ser certificado com o Selo LMB, uma distinção disponível a todos os chefs. O Selo LMB aumenta o status do profissional e valoriza sua marca. A avaliação acontece durante um evento especifico para este fim, no qual o júri La Mesa Bonita experimenta um dos menus do candidato. Nós oferecemos os ingredientes e o veredicto é divulgado dias após o evento. Entre em contato para mais detalhes.</p>
                </div>
            </div>

            <div class="col_one_third topmargin nobottommargin">
                <div class="feature-box fbox-personalized fbox-center fbox-outline">
                    <div class="fbox-icon" style="border-color: #e74c3c;">
                        <i class="icomoon-heartbeat i-alt" style="font-size: 52px; background-color:#e74c3c"></i>
                    </div>
                    <h3 class="marginbottom10px">Feedback dos <span>clientes</span></h3>
                    <p>Após os eventos, nossos clientes são convidados a avaliar o desempenho dos chefs. Quanto maior o número de eventos realizados e de avaliações positivas acumuladas, mais crescerá sua reputação entre os clientes La Mesa Bonita. As avaliações ficam disponíveis para todos os clientes na página do seu perfil. Isso permitirá que você colecione fãs, e com isso crie novos e mais requintados menus.</p>
                </div>
            </div>

            <div class="col_one_third topmargin nobottommargin col_last">
                <div class="feature-box fbox-personalized fbox-center fbox-outline">
                    <div class="fbox-icon" style="border-color: #F7CA18;">
                        <i class="fa fa-star i-alt" style="font-size: 55px; background-color:#F7CA18"></i>
                    </div>
                    <h3 class="marginbottom10px">Garantia de <span>visibilidade</span></h3>
                    <p>A qualidade dos nossos serviços é – e sempre será – nossa melhor propaganda. Contamos com profissionais qualificados dedicados a divulgar nossa marca para os nossos clientes. Fazem parte de nossa estratégia a divulgação da marca na mídia e nas redes sociais e a presença constante em eventos gastronômicos. Participar da rede La Mesa Bonita proporciona ao chef a divulgação do seu nome no mercado e multiplica suas oportunidades de trabalho.</p>
                </div>
            </div>

            <div class="clear"></div>

        </div>

    </div>

    <div class="divider divider-short divider-center hidden mb-show"><i class="icon-circle"></i></div>

    <div class="section nomargin notopborder nobg" style="padding: 40px 0px 0;">
        <div class="container center clearfix">

            <div class="col_one_third text-center">
                <img class="mb-mw-big" src="/images/others/sou_chef_precos.png" width="300" />
            </div>

            <div class="col_two_third col_last" id="precos">
                <div class="heading-block text-center">
                    <h2>Seus preços</h2>
                </div>

                <p class='sou-chef-lmb-subtitulo text-left mb-font-medium' style="font-weight: 300">
                    Você tem total liberdade para definir os valores cobrados pelo seu serviço. Encorajamos os chefs, porém, a determinarem faixas decrescentes de preço quando o número de convidados aumenta. Isso incentiva os nossos clientes a contratarem eventos para mais pessoas, aumentando sua margem de lucro.
                </p>
            </div>

            <div class="clear"></div>

        </div>
    </div>

    <div class="clear"></div>

    <div class="section nomargin notopborder" style="padding: 40px 0px 60px;">
        <div class="container lmb-nossas-garantias center clearfix">

            <div class="heading-block" id="suporte">
                <h2>Suporte</h2>
                <span class='sou-chef-lmb-subtitulo'>La Mesa Bonita oferece a você total autonomia para criar sua imagem em nossa rede. Mas também disponibiliza uma estrutura para você ter a melhor experiência possível conosco.</span>
            </div>

            <div class="clear"></div>

            <div class="col_one_third nobottommargin">
                <div class="feature-box center media-box fbox-bg">
                    <div class="fbox-media">
                        <img class="image_fade" src="/images/others/nossas_garantias_fotografia.jpg" alt="Featured Box Image" style="opacity: 1;">
                    </div>
                    <div class="fbox-desc">
                        <h3>FOTOGRAFIA PROFISSIONAL</h3>
                        <span>Temos parcerias com fotógrafos profissionais especializados, o que garante preços especiais para produção das fotos utilizadas no seu perfil.</span>
                    </div>
                </div>
            </div>

            <div class="col_one_third nobottommargin">
                <div class="feature-box center media-box fbox-bg">
                    <div class="fbox-media">
                        <img class="image_fade" src="/images/others/nossas_garantias_apoio_total.jpg" alt="Featured Box Image" style="opacity: 1;">
                    </div>
                    <div class="fbox-desc">
                        <h3>APOIA TOTAL</h3>
                        <span>A equipe La Mesa Bonita está sempre disponível para responder suas perguntas e comentários de forma ágil e profissional, por telefone ou e-mail.</span>
                    </div>
                </div>
            </div>


            <div class="col_one_third nobottommargin col_last">
                <div class="feature-box center media-box fbox-bg">
                    <div class="fbox-media">
                        <img class="image_fade" src="/images/others/nossas_garantias_burocracia.jpg" alt="Featured Box Image" style="opacity: 1;">
                    </div>
                    <div class="fbox-desc">
                        <h3>BUROCRACIAS</h3>
                        <span>Oferecemos orientação e indicamos profissionais adequados caso você tenha alguma dificuldade para emissão das notas fiscais referentes aos pagamentos.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="clear"></div>

    <div class="section chef-deveres nomargin dark bottompadding-xt mb-nobottompadding nobgmobile" style="background: url('/images/backgrounds/background_chef_deveres.jpg'); background-position: center; background-size: cover;">

        <div class="container clear-bottommargin clearfix">

            <div class="heading-block center" id="seus-deveres">
                <h2 class="mb-light">Seus deveres</h2>
                <span class="sou-chef-lmb-subtitulo mb-light">Entenda quais são as suas responsabilidades</span>
            </div>

            <div class="clear"></div>

            <div class="col_half">
                <div class="feature-box fbox-rounded">
                    <div class="fbox-icon">
                        <a><i style="font-size: 40px" class="icomoon-food2 i-alt"></i></a>
                    </div>
                    <h3 class="mb-light">Equipamento de Trabalho</h3>
                    <p>O chef deve entrar em contato com o cliente com antecedência para avaliar a necessidade de providenciar os equipamentos que não estejam disponíveis.</p>
                </div>
            </div>

            <div class="col_half col_last">
                <div class="feature-box fbox-rounded">
                    <div class="fbox-icon">
                        <i style="font-size: 40px" class="icomoon-microwave i-alt"></i>
                    </div>
                    <h3 class="mb-light">Notas Fiscais</h3>
                    <p>O chef deve estar apto a emitir documentos fiscais. Oferecemos orientação e indicamos profissionais confiáveis que podem lhe ajudar com essas questões.</p>
                </div>
            </div>

            <div class="clear"></div>

            <div class="col_half">
                <div class="feature-box fbox-rounded">
                    <div class="fbox-icon">
                        <i style="font-size: 40px" class="icomoon-food i-alt"></i>
                    </div>
                    <h3 class="mb-light">Ingredientes</h3>
                    <p>Você é responsável pela escolha e pela compra dos ingredientes necessários para preparar os pratos que compõem o menu que será oferecido ao cliente.</p>
                </div>
            </div>

            <div class="col_half col_last">
                <div class="feature-box fbox-rounded">
                    <div class="fbox-icon">
                        <i style="font-size: 40px" class="icomoon-user-tie i-alt"></i>
                    </div>
                    <h3 class="mb-light">Uniforme</h3>
                    <p>É parte do padrão de qualidade La Mesa Bonita que o chef esteja uniformizado no dia do evento. Providenciar o uniforme é também responsabilidade do chef.</p>
                </div>
            </div>

            <div class="clear"></div>

            <div class="col_half">
                <div class="feature-box fbox-rounded">
                    <div class="fbox-icon">
                        <i style="font-size: 40px" class="icomoon-heart i-alt"></i>
                    </div>
                    <h3 class="mb-light">Apresentação do Menu</h3>
                    <p>Ao servir os convidados, o chef terá a oportunidade de descrever detalhes e curiosidades do seu menu e falar também sobre sua experiência profissional.</p>
                </div>
            </div>

            <div class="col_half col_last">
                <div class="feature-box fbox-rounded">
                    <div class="fbox-icon">
                        <i style="font-size: 50px" class="icomoon-drink2 i-alt"></i>
                    </div>
                    <h3 class="mb-light">Bebidas</h3>
                    <p>A compra das bebidas é de responsabilidade do cliente, mas encorajamos você a fazer sugestões das bebidas que melhor combinam com o menu escolhido.</p>
                </div>
            </div>

        </div>

    </div>

    <div class="divider divider-short divider-center hidden mb-show"><i class="icon-circle"></i></div>

    <div class="clear"></div>

    <div class="section nobg nomargin">

        <div class="container clearfix">

            <div id="section-buy" class="heading-block title-center nobottomborder page-section">
                <h2>Entendeu? Comece agora mesmo!</h2>
                <span>Crie sua conta chef e comece a receber reservas</span>
            </div>

            <div class="center">

                <a href="/login" data-animate="tada" class="button button-3d button-teal button-lg nobottommargin tada animated">
                    <i class="fa fa-sign-in"></i>Acesse sua conta
                </a>
                 <span class="mb-show mb-margin-mini">- OU -</span>
                <a href="/sou-chef/cadastrar" data-scrollto="#section-pricing" class="button button-3d button-lg nobottommargin">
                    <i class="icon-user2"></i>Cadastre-se como chef
                </a>

            </div>

        </div>

    </div>

    <div class="clear"></div>

</div>
@endsection