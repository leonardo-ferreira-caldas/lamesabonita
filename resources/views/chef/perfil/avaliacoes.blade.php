@extends('template')

@section('head')
    <link rel="stylesheet" href="/css/colorbox.css" type="text/css" />
@endsection

@include("chef.perfil.foto_capa")

@section('container-class', 'chef-profile-content')

@section('content')
<div class="container inner-pages">
    <div class="col_one_third">
        @include('chef.perfil.menu_lateral')
    </div>
    <div class="col_two_third col_last">

        @include ('includes.avaliacoes')

    </div>
</div>
@endsection

@section('js')
<script src="/js/jquery.colorbox-min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.item-menu-mais-detalhes').click(function(evt) {
            evt.preventDefault();

            var $parent = $(this).closest('.chef-profile-menu-item');
            var $menu   = $parent.find('.detalhes-menu');

            if ($menu.hasClass('mais-detalhes')) {
                $menu.removeClass('mais-detalhes');
                $(this).find('i').removeClass("fa-minus");
                $(this).find('i').addClass("fa-plus");
            } else {
                $menu.addClass('mais-detalhes');
                $(this).find('i').addClass("fa-minus");
                $(this).find('i').removeClass("fa-plus");
            }

        });

        $('a.gallery').colorbox();

    })
</script>
@endsection