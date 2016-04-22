<aside class="user-profile-sidebar chef-page-profile-sidebar">
    <div class="user-profile-avatar marginbottom10px text-center">
        <div class='profile_picture_wrapper'>
            <div class='profile_picture_wrapper_border'>
                <a href="{{ route('chef', ['slug' => $chef->slug]) }}" class="chef-avatar-sidebar">
                    <img src="{{ crop($chef->avatar ?: 'avatar.jpg', 160, 160) }}">
                </a>
            </div>
        </div>
        {{--<div class="chef-badge badge-en"> --}}
            {{--Chef<br>Selo<br>Gourmet--}}
        {{--</div>--}}
    </div>
    <h2 class="marginbottom10px text-center">
        <a href="{{ route('chef', ['slug' => $chef->slug]) }}" class="chef-name-sidebar">
            {{ $chef->user->name }}
        </a>
    </h2>

    <div class='chef-profile-stars text-center'>
        {!! $chef->getReputacaoMedia() !!}
        <p>MÉDIA: {{ $chef->getAvaliacaoMedia() }}/5.0</p>
    </div>

    <div class="col_full text-center marginbottom10px">
        <div class="list-group chef-profile-menu text-align" style="display: inline-block">
            <a class="list-group-item" href="{{ route('chef_perfil_menus', ['slug' => $chef->slug]) }}">
                <i class="fa fa-cutlery fa-fw"></i>&nbsp; Menus
                <span class="badge">{{ $chef->menus->count() }}</span>
            </a>
            <a class="list-group-item" href="{{ route('chef_perfil_cursos', ['slug' => $chef->slug]) }}">
                <i class="fa fa-graduation-cap fa-fw"></i>&nbsp; Cursos
                <span class="badge">{{ $chef->cursos->count() }}</span>
            </a>
            <a class="list-group-item" href="{{ route('chef', ['slug' => $chef->slug]) }}">
                <i class="fa fa-user fa-fw"></i>&nbsp; Sobre o Chef
            </a>
            <a class="list-group-item" href="{{ route('chef_perfil_agenda', ['slug' => $chef->slug]) }}">
                <i class="fa fa-calendar fa-fw"></i>&nbsp; Agenda
            </a>
            <a class="list-group-item" href="{{ route('chef-gallery', ['slug' => $chef->slug ]) }}">
                <i class="fa fa-camera fa-fw"></i>&nbsp; Galeria de Fotos
                <span class="badge">{{ count($chef->galeria()) }}</span>
            </a>
            {{--<a class="list-group-item" href="{{ route('chef_perfil_avaliacoes', ['slug' => $chef->slug]) }}">--}}
                {{--<i class="fa fa-comments fa-fw"></i>&nbsp; Avaliações--}}
                {{--<span class="badge">{{ $chef->avaliacoes->count() }}</span>--}}
            {{--</a>--}}
        </div>
    </div>

    <div class="clear"></div>
</aside>