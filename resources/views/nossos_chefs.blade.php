@extends('template')

@section('after-header')
        <!-- Page Title
============================================= -->
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        <h1><span>Nossos Chefs</span></h1>
    </div>

</section><!-- #page-title end -->
@endsection


@section('content')
<div class="container nossos-chefs clearfix topmargin bottommargin-sm">

    <div class="fancy-title title-dotted-border title-center">
        <h3>Veja a nossa lista de chefs!</h3>
    </div>

    @if($chefs->count() > 0)

        @foreach ($chefs as $indChef => $chef)

            <div class="col_half menu-list-item backgroundWhite {{ $indChef % 2 > 0 ? 'col_last' : '' }}">
                <div class='menu-list-item-body' style="background-image: url('{{ crop($chef->foto_capa ?: 'chef_wallpaper.jpg', 450, 250) }}');">
                    <div class='menu-list-item-info'>
                        <div class='menu-list-item-info-wrapper'>
                            <div class="thumbnail noradius nopadding nomargin">
                                <img src="{{ crop($chef->avatar ?: 'avatar.jpg', 80, 80) }}">
                            </div>
                            <div class='chef-menu-name notopmargin'>
                                <div class="chef-name">{{ $chef->user->name }}</div>
                                <div>{{ $chef->menus->count() }} menu(s)</div>
                                <div>{{ $chef->cursos->count() }} curso(s)</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-price-box ">
                    <span class="stars-listagem-chef">{!! $chef->getReputacaoMedia() !!}</span>
                    @if ($chef->avaliacoes->count() == 0)
                        <span>(nenhuma avaliação)</span>
                    @elseif ($chef->avaliacoes->count() == 1)
                        <span>(1 avaliação)</span>
                    @else
                        <span>({{ $chef->avaliacoes->count() }} avaliações)</span>
                    @endif
                    <a href="{{ route('chef', ['slug' => $chef->slug]) }}" class="pull-right button button-mini button-3d nomargin">
                        <i class="fa fa-book"></i> Ver Perfil Chef
                    </a>
                </div>

            </div>

        @endforeach

    @else

        <div class='col_full' style="margin-top: 70px;">
            <h3 class='text-center'>Nenhum chef cadastrado.</h3>
        </div>

    @endif

</div>
@endsection