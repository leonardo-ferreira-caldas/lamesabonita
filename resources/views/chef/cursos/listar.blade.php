@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Meus Cursos</h2>
            <a href="/chef/cursos/novo" class="btn-fancy-title text-center mb-button-full button button-3d nomargin">
                <i class="fa fa-plus"></i> Adicionar Novo Curso</a>
        </div>

        @if(count($cursos) == 0)
            <div class='col_full' style="margin-top: 70px;">
                <h3 class='text-center'>Vocẽ não possui nenhum curso.</h3>
            </div>
        @endif

        @foreach ($cursos as $curso)
    
            <div class='col_one_third booking-picture nobottommargin'>
                <div class="thumbnail">
                  <img alt="100%x180" src="{{ route('image', ['w' => 230, 'h' => 150, 'i' => $curso->foto_capa ]) }}" style="width: 100%; display: block;">
                </div>
            </div>
            <div class='col_two_third col_last nobottommargin'>

                <div class="booking-text">
                    <div class="booking-name">
                        <a>{{ $curso->titulo  }}</a>
                    </div>
                    <address class="booking-address">
                        {{ $curso->culinarias }} /
                        {{ $curso->tipos_refeicoes }}
                    </address>
                    <p>
                        <span>Detalhes do curso<em>:</em></span> {{ $curso->descricao }}
                    </p>
                    <div class="price-box">
                        <div class="title-block">
                            <h3><span class='price'>R$ {{ $curso->preco }}</span></h3>
                            <span>preço por cliente</span>
                        </div>
                        <div class='col_full marginbottom10px'><a href="/chef/cursos/editar/{{ $curso->id_curso }}" class="button button-3d button-small nomargin"><i class="fa fa-pencil-square-o"></i> Editar</a></div>
                        <div class='col_full nomargin'>
                            <a href="/chef/{{ $curso->chef_slug }}/curso/{{ $curso->slug }}" class="button button-3d button-leaf button-small nomargin">
                                <i class="fa fa-pencil-square-o"></i> Ver Curso
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