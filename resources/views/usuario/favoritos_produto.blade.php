<div class='col_one_third booking-picture nobottommargin'>
    <div class="thumbnail">
        <img alt="Foto de Capa do Produto" src="{{ crop($favorito->produto_foto_capa, 280, 160) }}" style="width: 100%; display: block;">
    </div>
    <div class="thumbnail author">
        <div class="thumbnail_author_crop">
            <img width='68' alt="Foto de Perfil do Chef" src="{{ crop($favorito->chef_avatar, 68, 68) }}">
        </div>
    </div>
</div>
<div class='col_two_third col_last nobottommargin'>

    <div class="booking-text">
        <div class="booking-name">
            <a>{{ $favorito->produto_titulo }}</a>
        </div>

        <span class="booking-star">
            {!! Helpers::getStars($favorito->chef_avaliacao_media) !!}
        </span>
        <span class="booking-rating"><ins>{{ $favorito->chef_avaliacao_media }}</ins>
        <small><a href="/chef/{{ $favorito->produto_slug }}/avaliacoes">({{ $favorito->chef_avaliacao_count }} avaliações)</a></small></span>

        <p>{{ str_limit($favorito->produto_descricao, 200) }}</p>

        <div class="price-box">
            <div class="title-block">
                <h3><span class='price'>R$ {{ $favorito->produto_preco }}</span></h3>
                <span>preço por pessoa</span>
            </div>
            <div class='col_full marginbottom10px'>
                <a href="/chef/{{ $favorito->chef_slug }}/{{ $favorito->produto_tipo }}/{{ $favorito->produto_slug }}/" class="button button-3d button-small nomargin"><i class="fa fa-book"></i> Ver {{ $favorito->produto_tipo }}</a>
            </div>
            <div class='col_full'>
                <a href="/favorito/remover/{{ $favorito->produto_slug }}/{{ $favorito->produto_tipo }}" class="button button-3d button-red button-small nomargin"><i class="fa fa-trash-o"></i> Remover</a>
            </div>
        </div>
    </div>

</div>