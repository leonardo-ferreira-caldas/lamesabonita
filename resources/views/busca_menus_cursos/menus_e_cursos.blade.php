@if(count($produtos) > 0)

    @foreach ($produtos as $index => $item)

        <div class="col_half menu-list-item backgroundWhite {{ $index % 2 > 0 ? 'col_last' : '' }}">
            <div class='menu-list-item-body' style="background-image: url('{{ route('image', ['w' => 450, 'h' => 250, 'i' => $item->capa ]) }}');">
                <div class='menu-list-item-info'>
                    <div class='menu-list-item-info-wrapper'>
                        <h4>
                            <a href="/chef/{{ $item->chef_slug  }}/menu/{{ $item->produto_slug  }}">{{ $item->produto_titulo }}</a>
                        </h4>
                        <hr />
                        <div class="thumbnail author">
                            <div class='thumbnail_author_crop'>
                                <img src="{{ route('image', ['w' => 35, 'h' => 35, 'i' => $item->chef_avatar ]) }}">
                            </div>
                        </div>
                        <div class='chef-menu-name'>{{ $item->chef_nome }}</div>
                        <div class="menu-chef-reviews">
                            <span class='menu-chef-stars'>{!! Helpers::getStars($item->chef_avaliacao_media) !!}</span>
                            ({{ $item->chef_avaliacao_count }} avaliações)
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-price-box">
                <span class='menu-price'>R$ {{ formatar_monetario($item->produto_preco) }}</span>
                <span>/pessoa

                @if(!empty($item->precos))
                    para
                    <select class="sm-form-control menu-list-select-guests" style="width: 70px">
                        @foreach ($item->precos as $preco)
                            <option value="{{ $preco['preco']}}">{{ $preco['qtd'] }}</option>
                        @endforeach
                    </select>
                @endif

                </span>

                <a href="/chef/{{ $item->chef_slug }}/{{ $item->produto_tipo }}/{{ $item->produto_slug }}" class="pull-right button button-mini button-3d nomargin">
                    <i class="fa fa-book"></i> Ver {{ ucfirst($item->produto_tipo) }}
                </a>
            </div>

            @if($item->produto_tipo == 'curso')
                <div class="is_curso">
                    <div class="curso_label"><span>CURSO</span></div>
                </div>
            @endif

        </div>

    @endforeach

    <div class="clear"></div>

    <div class='menu-pagination'>

        <nav class='custom-pagination'>
            <a 
                href="/nossos-menus-cursos?page=1"
                data-pagina="1"
                class="button button-3d button-mini button-rounded button-white button-light">«</a>

            @for($i = Helpers::getInitialPage($filtros['pagina'], $paginas); $i <= Helpers::getFinalPage($filtros['pagina'], $paginas); $i++)
                <a href="/nossos-menus?page={{ $i }}" data-pagina="{{ $i }}" class="button button-3d button-mini button-rounded {{ $i == $filtros['pagina'] ? 'button-amber active' : 'button-white button-light' }}">
                    {{ $i }}
                </a>
            @endfor

            <a
                href="/nossos-menus-cursos?page={{ $paginas }}"
                data-pagina="{{ $paginas }}"
                class="button button-3d button-mini button-rounded button-white button-light">»</a>
        </nav>
    
        <div class="clear"></div>

    </div>

@else 

    <div class='col_full text-center' style="margin-top: 150px; margin-bottom: 150px;">
        <h3 class='text-center'>Nenhum menu/curso encontrado.</h3>
        <a href="/nossos-menus-cursos" class="button button-large button-3d nomargin"><i class="fa fa-book"></i> Ver Todos Menus/Cursos</a>
    </div>

@endif
