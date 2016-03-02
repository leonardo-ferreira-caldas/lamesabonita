@extends('template')

@section('container-class', 'chef-profile-content')

@section('content')

<div class="content-wrap content-wrap-half-padding">

    <div class="container clearfix">

        <div class='backgroundWhite buscar-menus-inner'>

            <div class="fancy-title title-dotted-border marginbottom10px">
                <h3>Encontre seu menu agora!</h3>
            </div>

            @include('busca_menus_cursos.formulario')

        </div>


        @if(count($produtos) == 0)
            <div class='col_full text-center' style="margin-top: 150px; margin-bottom: 150px;">
                <h3 class='text-center'>Nenhum menu/curso encontrado.</h3>
                <a href="/nossos-menus-cursos" class="button button-large button-3d nomargin"><i class="fa fa-book"></i> Ver Todos Menus/Cursos</a>
            </div>

        @else

            <div class="col_one_fifth menu-filters backgroundWhite">

                @include('busca_menus_cursos.filtros')

            </div>

            <div class='col_four_fifth col_last menu-list'>

                <div class="fancy-title title-dotted-border title-menus-cursos">
                    <h3>Menus & Cursos</h3>
                </div>
                
                <div class='menu-list-content-wrapper'>
                    @include('busca_menus_cursos.menus_e_cursos')
                </div>

                <div class="clear"></div>

            </div>

        @endif

    </div>

</div>
@endsection

@section('footer.html')
<div class='overlay_menu_loading'>
    <div class='overlay_menu_loading_table'>
        <div class='overlay_menu_loading_cell'>
            <img src='/images/others/facebook.gif' />
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="js/ion.rangeSlider.min.js"></script>
@endsection