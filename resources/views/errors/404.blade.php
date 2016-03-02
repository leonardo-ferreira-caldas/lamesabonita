@extends('template')

@section('after-header')
        <!-- Page Title
============================================= -->
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        <h1><span>Página Não Encontrada</span></h1>
    </div>

</section><!-- #page-title end -->
@endsection

@section('content')

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="col_half nobottommargin">
                <div class="error404 center">404</div>
            </div>

            <div class="col_half nobottommargin col_last">

                <div class="heading-block nobottomborder">
                    <h4>Ooopps.! Não encontramos a página que você está procurando.</h4>
                    <span>Tente encontrar a página que está procurando na lista de links abaixo:</span>
                </div>

                <div class="col_one_third widget_links nobottommargin">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Sou Chef</a></li>
                        <li><a href="#">Cadastrar</a></li>
                    </ul>
                </div>

                <div class="col_one_third widget_links nobottommargin">
                    <ul>
                        <li><a href="#">Sobre Nós</a></li>
                        <li><a href="#">Nossos Chefs</a></li>
                        <li><a href="#">Login</a></li>
                    </ul>
                </div>

                <div class="col_one_third widget_links nobottommargin col_last">
                    <ul>
                        <li><a href="#">Contato</a></li>
                    </ul>
                </div>

            </div>

        </div>

    </div>

@endsection