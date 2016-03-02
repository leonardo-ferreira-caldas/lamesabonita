@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Meus Menus</h2>
            <a href="/chef/menu/novo" class="btn-fancy-title text-center mb-button-full button button-3d nomargin"><i class="fa fa-plus"></i> Adicionar Novo Menu</a>
        </div>

        @if(count($menus) == 0)
            <div class='col_full' style="margin-top: 70px;">
                <h3 class='text-center'>Vocẽ não possui nenhum menu.</h3>
            </div>
        @endif

        @foreach ($menus as $menu)
    
            <div class='col_one_third booking-picture nobottommargin'>
                <div class="thumbnail">
                  <img alt="100%x180" src="{{ route('image', ['w' => 230, 'h' => 150, 'i' => $menu->foto_capa ]) }}" style="width: 100%; display: block;">
                </div>
            </div>
            <div class='col_two_third col_last nobottommargin'>

                <div class="booking-text">
                    <div class="booking-name">
                        <a>{{ $menu->titulo  }}</a>
                    </div>
                    <address class="booking-address">
                        {{ $menu->culinarias }} /
                        {{ $menu->tipos_refeicoes }}
                    </address>
                    <p>
                        {{
                            str_limit(
                                (!empty($menu->aperitivo) ? "Aperitivos: " . $menu->aperitivo : "") . " " .
                                (!empty($menu->entrada) ? "Prato de Entrada: " . $menu->entrada : "") . " " .
                                "Prato Principal: " . $menu->prato_principal . " " .
                                (!empty($menu->sobremesa) ? "Sobremesa: " . $menu->sobremesa : "")
                            , 200)
                        }}

                    </p>
                    <div class="price-box">
                        <div class="title-block">
                            <h3><span class='price'>R$ {{ $menu->preco }}</span></h3>
                            <span>preço por pessoa</span>
                        </div>
                        <div class='col_full marginbottom10px'><a href="/chef/menu/editar/{{ $menu->id_menu }}#menu_form" class="button button-3d button-small nomargin"><i class="fa fa-pencil-square-o"></i> Editar</a></div>
                        <div class='col_full nomargin'>
                            <a href="/chef/{{ $menu->chef_slug }}/menu/{{ $menu->slug }}" class="button button-3d button-leaf button-small nomargin">
                                <i class="fa fa-pencil-square-o"></i> Ver Menu
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <div class='clear'></div>

            <div class="divider divider-center "><i class="fa fa-cutlery"></i></div>

        @endforeach
    </div>
</div>
@endsection