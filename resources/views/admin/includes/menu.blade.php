<div class="nicescroll sidebar-expanded sidebar-wrapper" tabindex="25" style="overflow: hidden; outline: none;" id="menu-vue">
    <div class="header-logo">
        <a class="home" id="js-shortcuts-home" href="{{ route('admin.dashboard') }}"
           data-original-title="Dashboard">
            <img src="/images/logo@white.png"/>
        </a>
    </div>
    <ul class="nav nav-sidebar" v-cloak>
        <li class="">
            <a title="Groups" href="{{ route('admin.dashboard') }}">
                <i class="fa fa-tachometer fa-fw"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="">
            <a title="Groups" href="{{ route('backoffice.chef.listar') }}">
                <i class="fa fa-group fa-fw"></i>
                <span>Chefs</span>
            </a>
        </li>
        <li class="">
            <a title="Groups" href="{{ route('backoffice.menu.listar') }}">
                <i class="fa fa-cutlery fa-fw"></i>
                <span>Menus</span>
            </a>
        </li>
        <li class="">
            <a title="Groups" href="{{ route('backoffice.curso.listar') }}">
                <i class="fa fa-graduation-cap fa-fw"></i>
                <span>Cursos</span>
            </a>
        </li>
        <li class="">
            <a title="Groups" href="{{ route('backoffice.conta_bancaria.listar') }}">
                <i class="fa fa-university fa-fw"></i>
                <span>Contas Bancárias</span>
            </a>
        </li>
        <li v-on:click="toggle('menu')">
            <a title="Merge Requests" v-bind:class="{'submenu-open': open == 'menu'}"  class="shortcuts-merge_requests" href="#">
                <i class="fa fa-tasks fa-fw"></i>
                <span>Cadastros</span>
            </a>
        </li>
        <li v-show="open == 'menu'">
            <a title="Merge Requests" class="shortcuts-merge_requests submenu" href="{{ route('cadastro.tipo_culinaria.listar') }}">
                <i class="fa fa-angle-double-right fa-fw"></i>
                <span>Tipos de Culinária</span>
            </a>
        </li>
        <li v-show="open == 'menu'">
            <a title="Merge Requests" class="shortcuts-merge_requests submenu" href="{{ route('cadastro.tipo_refeicao.listar') }}">
                <i class="fa fa-angle-double-right fa-fw"></i>
                <span>Eventos</span>
            </a>
        </li>
        <li v-show="open == 'menu'">
            <a title="Merge Requests" class="shortcuts-merge_requests submenu" href="{{ route('cadastro.incluso_preco.listar') }}">
                <i class="fa fa-angle-double-right fa-fw"></i>
                <span>Incluso no Preço</span>
            </a>
        </li>
        <li v-show="open == 'menu'">
            <a title="Merge Requests" class="shortcuts-merge_requests submenu" href="{{ route('cadastro.faq.listar') }}">
                <i class="fa fa-angle-double-right fa-fw"></i>
                <span>FAQ</span>
            </a>
        </li>

        <li class="separate-item"></li>

        <li class="">
            <a title="Profile Settings" data-placement="bottom"
               href="{{ route('backoffice.configuracao.listar') }}">
                <i class="fa fa-dashboard fa-fw"></i>
                    <span>Configurações</span>
            </a>
        </li>
    </ul>

</div>
