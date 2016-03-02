@inject('auth', 'App\Utils\AuthHelper')

<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

<!-- Logo
============================================= -->
<div id="logo">
    <a href="/" class="standard-logo" data-dark-logo="/images/logo.png"><img src="/images/logo.png" alt="Canvas Logo"></a>
    <a href="/" class="retina-logo" data-dark-logo="/images/logo.png"><img src="/images/logo.png" alt="Canvas Logo"></a>
</div><!-- #logo end -->

<!-- Primary Navigation
============================================= -->
<nav id="primary-menu" class="style-3">

    @if($auth->isLoggedIn())

        <div class='pull-right top-menu-user'>
            <div class="dropdown dropmenu">


                @if($auth->isDegustador())

                    <div class='dropdown-toggle' id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <h5 class="nome-usuario">{{ $auth->getName() }}</h5>
                        <img width="20" src="/images/icons/arrow_down.png" />
                    </div>

                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a href="/minha-conta"><i class="fa fa-bar-chart"></i> Minha Conta</a></li>
                        <li><a href="/minha-conta/reservas"><i class="fa fa-book"></i> Minha Reservas</a></li>
                        <li><a href="/minha-conta/informacoes-pessoais"><i class="fa fa-user"></i> Meus Dados</a></li>
                        <li><a href="/minha-conta/favoritos"><i class="fa fa-heart-o"></i> Favoritos</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/minha-conta/alterar-senha"><i class="fa fa-key"></i> Alterar Senha</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>

                @else

                    <div class='dropdown-toggle dropdown-toggle-chef' id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <h5 class="nome-usuario">
                            {{ $auth->getName() }}
                            <small class="saldo">Saldo: R$ {{ formatar_monetario($auth->getChef('saldo')) }}</small>
                        </h5>

                        <img width="20" src="/images/icons/arrow_down.png" />
                    </div>

                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a href="{{ route('chef', ['slug' => $auth->getChef('slug')]) }}"><i class="fa fa-user"></i> Ver Meu Perfil</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/chef/"><i class="fa fa-bar-chart"></i> Visão Geral</a></li>
                        <li><a href="/chef/informacoes-pessoais"><i class="fa fa-user"></i> Informações Pessoais</a></li>
                        <li><a href="/chef/localizacao"><i class="fa fa-map-marker"></i> Minha Localização</a></li>
                        <li><a href="/chef/conta-bancaria"><i class="fa fa-university"></i> Dados Bancários</a></li>
                        <li><a href="/chef/menu/listar"><i class="fa fa-cutlery"></i> Meus Menus</a></li>
                        <li><a href="/chef/cursos/listar"><i class="fa fa-graduation-cap"></i> Meus Cursos</a></li>
                        <li><a href="/chef/agenda"><i class="fa fa-calendar"></i> Minha Agenda</a></li>
                        <li><a href="/chef/reservas"><i class="fa fa-calendar-check-o"></i> Reservas Agendadas </a></li>
                        <li><a href="/chef/avaliacoes"><i class="fa fa-heart-o"></i> Avaliações</a></li>
                        <li><a href="/chef/selo-la-mesa-bonita"><i class="fa fa-diamond"></i> Selo La Mesa Bonita</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/chef/alterar-senha"><i class="fa fa-key"></i> Alterar Senha</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>

                @endif
            </div>
        </div>

    @endif

    <ul class="header-menus pull-right {{$auth->isLoggedIn() ? 'logged-in' : ''}}">
        <li><a href="/nossos-menus-cursos"><div>Menus / Cursos</div></a></li>
        <li><a href="/faq"><div>FAQ</div></a></li>
        <li><a href="/sobre-nos"><div>Sobre Nós</div></a></li>
        {{--<li><a href="/contato"><div>Contato</div></a></li>--}}
        <li class='hide_on_logged_in'><a href="/login"><div>Entrar</div></a></li>
        <li class='hide_on_logged_in'><a href="/registrar"><div>Cadastre-se</div></a></li>
        <li class="current hide_on_logged_in"><a href="/sou-chef"><div>Sou Chef</div></a></li>

        @if($auth->isLoggedIn())
            @if($auth->isDegustador())

            @else
                <li class="sub-menu visible-xs">
                    <a href="#">Menus do Chef</a>
                    <ul>
                        <li><a href="{{ route('chef', ['slug' => $auth->getChef('slug')]) }}"><i class="fa fa-user"></i> Ver Meu Perfil</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/chef/"><i class="fa fa-bar-chart"></i> Visão Geral</a></li>
                        <li><a href="/chef/informacoes-pessoais"><i class="fa fa-user"></i> Informações Pessoais</a></li>
                        <li><a href="/chef/localizacao"><i class="fa fa-map-marker"></i> Minha Localização</a></li>
                        <li><a href="/chef/conta-bancaria"><i class="fa fa-university"></i> Dados Bancários</a></li>
                        <li><a href="/chef/menu/listar"><i class="fa fa-cutlery"></i> Meus Menus</a></li>
                        <li><a href="/chef/cursos/listar"><i class="fa fa-graduation-cap"></i> Meus Cursos</a></li>
                        <li><a href="/chef/agenda"><i class="fa fa-calendar"></i> Minha Agenda</a></li>
                        <li><a href="/chef/reservas"><i class="fa fa-calendar-check-o"></i> Reservas Agendadas </a></li>
                        <li><a href="/chef/avaliacoes"><i class="fa fa-heart-o"></i> Avaliações</a></li>
                        <li><a href="/chef/selo-la-mesa-bonita"><i class="fa fa-diamond"></i> Selo La Mesa Bonita</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/chef/alterar-senha"><i class="fa fa-key"></i> Alterar Senha</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>
            @endif
        @endif
    </ul>
    
</nav><!-- #primary-menu end -->