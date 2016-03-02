@extends('template')

@section('after-header')
<!-- Page Title
============================================= -->
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        <h1><span>Minha Conta</span></h1>
    </div>

</section><!-- #page-title end -->
@endsection

@section('content')
<div class="container inner-pages">
    <div class="col_one_fourth">
        @include('usuario.sidebar')
    </div>
    <div class="col_three_fourth col_last backgroundWhite">
        <div class="fancy-title title-bottom-border">
            <h2>Meus Favoritos</h2>
        </div>
        @if (count($favoritos) == 0)
            <div class='col_full' style="margin-top: 70px;">
                <h3 class='text-center'>Vocẽ não possui nenhum menu/curso favorito.</h3>
            </div>

        @else

            @foreach ($favoritos as $favorito)
                @include("usuario.favoritos_produto")

                <div class='clear'></div>

                <div class="divider divider-center "><i class="fa fa-cutlery"></i></div>

            @endforeach

        @endif

    </div>
</div>
@endsection