@inject('chefBO', 'App\Business\ChefBO')

<div class="profile_picture_mobile">

    <div class='profile_picture_wrapper'>
        <div id="upload_avatar_container"  class="profile_picture_wrapper_border">
            <img class='hide_on_upload' src="{{ crop($auth->getAvatar(), 160, 160) }}">
            <span class='uploading'>
                <img src='/images/others/ring-alt.gif' /><br>
                Aguarde...
            </span>
        </div>
    </div>

    <div class="btn_file btn_chef_avatar_profile">
        <div class='btn_file_wrapper button button-leaf button-3d button-mini'>
            <i class="fa fa-camera"></i> Alterar Foto
            <form class="form-foto-avatar" method="POST" action="/chef/alterar-foto" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="file" data-loading="upload_avatar_container" name="foto_perfil" class="foto_perfil" />
            </form>
        </div>
    </div>

</div>


<aside class="user-profile-sidebar xx-sm-hide">
    <div class="user-profile-avatar text-center">
        <div class='profile_picture_wrapper'>
            <div id="upload_avatar_container_mobile"  class="profile_picture_wrapper_border">
                <img class='hide_on_upload' src="{{ crop($auth->getAvatar(), 160, 160) }}">

                <span class='uploading'>
                    <img src='/images/others/ring-alt.gif' /><br>
                    Aguarde...                    
                </span>
            </div>
        </div>

        <div class="btn_file btn_chef_avatar_profile">
            <div class='btn_file_wrapper button button-leaf button-3d button-mini'>
                <i class="fa fa-camera"></i> Alterar Foto
                <form class="form-foto-avatar" method="POST" action="/chef/alterar-foto" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="file" data-loading="upload_avatar_container_mobile" name="foto_perfil" class="foto_perfil" />
                </form>
            </div>
        </div>

        <h5>{{ $auth->getName() }}</h5>
        <p class="marginbottom10px">Membro desde {{ $auth->getMemberSince() }}</p>

        <div class="saldo-menu-lateral">
            <h4 class="nobottommargin lato">Saldo: R$ {{ formatar_monetario($auth->getChef('saldo')) }}</h4>
            <a href="{{ route('saque.solicitar') }}" class="button button-3d button-mini button-rounded button-dirtygreen">Realizar Saque</a>
        </div>


        <p class="chef-status">
            Status:
            @if($chefBO->perfilAprovado())
                <span class='aprovado'>
            @elseif($chefBO->perfilReprovado())
                <span class='reprovado'>
            @else
                <span class='pendente'>
            @endif
                <b>{{ $auth->getChefStatus() }}</b>
            </span>
        </p>

        @if($chefBO->perfilAguardandoCadastro())
            <a style="margin-left: -5px;" href="{{ route('solicitar-aprovacao-perfil') }}" class="button button-3d button-mini button-rounded button-green">SOLICITAR APROVAÇÃO PERFIL</a>
        @endif

        <a href="{{ route('chef', ['slug' => $auth->getChef('slug')]) }}" class="button button-3d button-mini button-rounded button-amber">VER MEU PERFIL</a>
    </div>
    <ul class="list user-profile-nav list-unstyled">
        <li class="{{ $page == 'minha_conta' ? 'active' : "" }}">
            <a href="/chef/minha-conta"><i class="fa fa-tasks"></i>Visão Geral</a>
        </li>
        <li class="{{ $page == 'page' ? 'active' : "" }}">
            <a href="{{ route('saque.listar') }}"><i class="fa fa-usd"></i>Saques</a>
        </li>
        <li class="{{ $page == 'informacoes-pessoais' ? 'active' : "" }}">
            <a href="/chef/informacoes-pessoais"><i class="fa fa-user"></i>Informações Pessoais</a>
        </li>
        <li class="{{ $page == 'localiazcao' ? 'active' : "" }}">
            <a href="/chef/localizacao"><i class="fa fa-map-marker"></i>Minha Localização</a>
        </li>
        <li class="{{ $page == 'conta_bancaria' ? 'active' : "" }}">
            <a href="/chef/conta-bancaria"><i class="fa fa-university"></i>Dados Bancários</a>
        </li>
        <li class="{{ $page == 'menus' ? 'active' : "" }}">
            <a href="/chef/menu/listar"><i class="fa fa-cutlery"></i>Meus Menus ({{ Auth::user()->chef->menus->count() }})</a>
        </li>
        <li class="{{ $page == 'cursos' ? 'active' : "" }}">
            <a href="/chef/cursos/listar"><i class="fa fa-graduation-cap"></i>Meus Cursos ({{ Auth::user()->chef->cursos->count() }})</a>
        </li>
        <li class="{{ $page == 'agenda' ? 'active' : "" }}">
            <a href="/chef/agenda"><i class="fa fa-calendar"></i>Minha Agenda</a>
        </li>
        <li class="{{ $page == 'reservas' ? 'active' : "" }}">
            <a href="/chef/reservas"><i class="fa fa-calendar-check-o"></i>Reservas Agendadas (0)</a>
        </li>
        <li class="{{ $page == 'avaliacoes' ? 'active' : "" }}">
            <a href="/chef/avaliacoes"><i class="fa fa-heart-o"></i>Avaliações ({{ Auth::user()->chef->avaliacoes->count() }})</a>
        </li>
        <li class="{{ $page == 'selo_lmb' ? 'active' : "" }}">
            <a href="/chef/selo-la-mesa-bonita"><i class="fa fa-diamond"></i> Selo La Mesa Bonita</a>
        </li>
        <li class="{{ $page == 'alterar_senha' ? 'active' : "" }}">
            <a href="/chef/alterar-senha"><i class="fa fa-key"></i>Alterar Senha</a>
        </li>
        <li>
            <a href="/logout"><i class="fa fa-sign-out"></i>Sair da Conta / Deslogar</a>
        </li>
    </ul>
</aside>

<script type="text/javascript">
$(document).ready(function() {
    var types = ['jpg', 'jpeg', 'png'];

    var uploadFnc = function() {

        var $avatar = $(this);
        var ext = $avatar.val().split('.').pop();

        if ((ext.toString().length > 3 && types.indexOf(ext) == -1) || ext.toString().length < 3) {
            Utils.alert.error("Arquivo não permitido!", "Somente imagens com extensões .jpg, .jpeg, .png são permitidas.");
            $avatar.val('');
            return;
        }

        if ($avatar.val().toString().length >= 4 && typeof FileReader !== "undefined") {
            var tamanho = Math.round($avatar[0].files[0].size / 1000);
            if (tamanho >= 10240) {
                Utils.alert.error("Validação", "O tamanho da foto de perfil não deve ultrapassar 10 MBs.");
                return false;
            }
        }

        $("#" + $avatar.data("loading")).addClass("uploading-wrapper");
        console.log($("#" + $avatar.data("loading")), $avatar.data("loading"));
        $(this).closest("form").submit();

     };

    $(".foto_perfil").change(uploadFnc);

    $("#form_chef_perfil_avatar").submit(function(evt) {
        var ext = $(this).find("input[type=file]").val().split('.').pop();

        if ((ext.toString().length > 3 && types.indexOf(ext) == -1) || ext.toString().length < 3) {
            evt.preventDefault();
            return false;
        }
    });


});
</script>