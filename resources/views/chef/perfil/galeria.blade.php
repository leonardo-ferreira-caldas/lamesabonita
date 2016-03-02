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
                <h2>Galeria</h2>
            </div>

            @if(count($chef->galeria()) == 0)

                <div class='col_full' style="margin-top: 70px;">
                    <h3 class='text-center'>Este chef não possuí fotos cadastradas.</h3>
                </div>

            @else

                @foreach ($chef->galeria() as $idx => $galeria)

                <div class="col_one_third {{ ($idx+1) % 3 == 0 ? 'col_last' : '' }}">
                    <div class="thumbnail">
                        <a href='{{ route('image', ['w' => 700, 'h' => 500, 'i' => $galeria['nome_imagem'] ]) }}' class="gallery">
                            <img src="{{ route('image', ['w' => 200, 'h' => 130, 'i' => $galeria['nome_imagem'] ]) }}" />
                        </a>
                    </div>
                </div>
                @endforeach

             @endif

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