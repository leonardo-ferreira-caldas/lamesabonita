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
        <div class="col_two_third col_last backgroundWhite">

            <div class="fancy-title title-bottom-border">
                <h2>Sobre o Chef</h2>
            </div>

            <p>{{ $auth->getChef('sobre_chef') }}</p>

        </div>


    </div>
    </div>
@endsection

@section('js')
    <script src="/js/jquery.colorbox-min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('a.gallery').colorbox({rel: 'gal'});
        });
    </script>
@endsection