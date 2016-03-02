@section('container-class', 'chef-profile-content')

@section('after-header')
<!-- Page Title
============================================= -->
<section id="page-title" class="page-title-center chef-profile" style="background-image: url('/images/uploads/{{ $auth->getChefCover() }}');">
    <div class="container">
        <div class="alterar_wallpaper">
            <div class='alterar_wrapper button button-amber button-3d button-small'>
                <i class="fa fa-camera"></i> Alterar Foto de Capa
                <form id="form_chef_cover" method="POST" action="/chef/alterar-capa" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="file" name="foto_capa" id="foto_capa" />
                </form>
            </div>
        </div>
    </div>

    <span class='uploading_chef_cover'>
        <img src='/images/others/ring-alt.gif' /><br>
        Aguarde...                    
    </span>
</section><!-- #page-title end -->


<script type="text/javascript">
$(document).ready(function() {
    var types = ['jpg', 'jpeg', 'png'];

    var uploadFnc = function() {
        var $fotoCapa = $("#form_chef_cover input[type=file]");
        var ext = $fotoCapa.val().split('.').pop();

        if ((ext.toString().length > 3 && types.indexOf(ext) == -1) || ext.toString().length < 3) {
            Utils.alert.error("Arquivo não permitido!", "Somente imagens com extensões .jpg, .jpeg, .png são permitidas.");
            $("#form_chef_cover input").val('');
            return;
        }

        if ($fotoCapa.val().toString().length >= 4 && typeof FileReader !== "undefined") {
            var tamanho = Math.round($fotoCapa[0].files[0].size / 1000);
            if (tamanho >= 10240) {
                Utils.alert.error("Validação", "O tamanho da foto de perfil não deve ultrapassar 10 MB's.");
                return false;
            }
        }

        $("#page-title").addClass("uploading-chef-cover-wrapper");
        $("#form_chef_cover").submit();

     };

    $("#form_chef_cover").submit(function(evt) {
        var ext = $(this).find("input[type=file]").val().split('.').pop();
        if ((ext.toString().length > 3 && types.indexOf(ext) == -1) || ext.toString().length < 3) {
            evt.preventDefault();
            return false;
        }
    });

    $("#foto_capa").change(uploadFnc);
});
</script>
@endsection