@section('container-class', 'chef-profile-content')

<aside class="user-profile-sidebar">
    <div class="user-profile-avatar text-center">
        <div class='profile_picture_wrapper'>
            <div id="avatar_user_id" class="profile_picture_wrapper_border">

                <img class='hide_on_upload' width="160" src="{{ route('image', ['w' => 160, 'h' => 160, 'i' => $auth->getAvatar()]) }}">

                <span class='uploading'>
                    <img src='/images/others/ring-alt.gif' /><br>
                    Aguarde...                    
                </span>

            </div>
        </div>

        <div class="btn_file btn_chef_avatar_profile">
            <div class='btn_file_wrapper button button-leaf button-3d button-mini'>
                <i class="fa fa-camera"></i> Alterar Foto
                <form id="form_user_avatar" method="POST" action="/minha-conta/alterar-foto" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="file" name="user_avatar" id="avatar_user" />
                </form>
            </div>
        </div>

        <h5>{{ Auth::user()->name }}</h5>
        <p>Membro desde {{ date('d/m/Y', strtotime(Auth::user()->created_at)) }}</p>
    </div>
    <ul class="list user-profile-nav list-unstyled">
        <li class="{{ $page == 'visao_geral' ? 'active' : "" }}">
            <a href="/minha-conta/"><i class="fa fa-bar-chart"></i>Visão Geral</a>
        </li>
        <li class="{{ $page == 'informacoes_pessoais' ? 'active' : "" }}">
            <a href="/minha-conta/informacoes-pessoais"><i class="fa fa-user"></i>Informações Pessoais</a>
        </li>
        <li class="{{ $page == 'reservas' ? 'active' : "" }}">
            <a href="/minha-conta/reservas"><i class="fa fa-clock-o"></i>Minhas Reservas</a>
        </li>
        <li class="{{ $page == 'favoritos' ? 'active' : "" }}">
            <a href="/minha-conta/favoritos"><i class="fa fa-heart-o"></i>Favoritos</a>
        </li>
        <li class="{{ $page == 'alterar_senha' ? 'active' : "" }}">
            <a href="/minha-conta/alterar-senha"><i class="fa fa-key"></i>Alterar Senha</a>
        </li>
        <li>
            <a href="/logout"><i class="fa fa-sign-out"></i>Sair da Conta</a>
        </li>
    </ul>
</aside>

<script type="text/javascript">
$(document).ready(function() {
    var types = ['jpg', 'jpeg', 'png'];

    var uploadFnc = function() {
        var ext = $("#form_user_avatar input[type=file]").val().split('.').pop();

        if ((ext.toString().length > 3 && types.indexOf(ext) == -1) || ext.toString().length < 3) {
            swal({
                title: "Arquivo não permitido!",
                text: "Somente imagens com extensões .jpg, .jpeg, .png são permitidas.  ",
                type: "error",
                confirmButtonText: "OK"
            });
            $("#form_user_avatar input").val('');
            return;
        }

        $("#avatar_user_id").addClass("uploading-wrapper");
        $("#form_user_avatar").submit();

     };

    $("#form_user_avatar").submit(function(evt) {
        var ext = $(this).find("input[type=file]").val().split('.').pop();
        if ((ext.toString().length > 3 && types.indexOf(ext) == -1) || ext.toString().length < 3) {
            evt.preventDefault();
            return false;
        }
    });

    $("#avatar_user").change(uploadFnc);
});
</script>