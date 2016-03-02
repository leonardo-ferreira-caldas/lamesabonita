@if (count($avaliacoes) > 0)
    <div class="fancy-title title-bottom-border" id="chef-reviews">
        <h2>Leia as avaliações deste chef</h2>

        <a href="#" data-scrollto="#avaliar_chef_form" class="btn-fancy-title button button-3d nomargin"><i class="fa fa-comment"></i> Avaliar este chef</a>
    </div>

    <div class="backgroundWhite noleftpadding">

    @foreach($avaliacoes as $index => $avaliacao)

        @if ($index > 0)
            <div class="topborderdashed leftmargin"></div>
        @endif

        <div class="review">
            <div class="col_one_fourth text-center left-review" style="padding-left: 15px;">
                <span class="review_number">{{ $avaliacao->nota }}</span>
                <div class="clear"></div>
                <span class="review_stars">
                    {{--{!! $avaliacao->getStars() !!}--}}
                </span>
            </div>

            <div class="col_three_fourth col_last">
                <div class="review_user_avatar">
                    <img width="64" src="{{ crop($avaliacao->avatar, 64, 64) }}">
                </div>
                <h4 class="nomargin review_user_name">{{ $avaliacao->nome_cliente }}</h4>
                <p class="marginbottom10px">em {{ $avaliacao->data_avaliacao }}</p>
                <div class="clear"></div>
                <br>
                <p class='review_text'>{{ $avaliacao->texto }}</p>
            </div>
        </div>

    @endforeach

    </div>

@endif

<div class="backgroundWhite">
  <div class="fancy-title title-bottom-border">
      <h2>Deixe sua avaliação deste chef</h2>
  </div>

  <form id="avaliar_chef_form" method="POST" action="/chef/salvar-avaliacao">

      {!! csrf_field() !!}

      @include('includes/errors')

      <input type="hidden" name="id_chef" value="{{ $chef->id_chef }}" />
      <input type="hidden" name="id_produto" value="{{ $id_produto }}" />
      <input type="hidden" name="tipo" value="{{ $tipo }}" />

      <div class='col_one_third'>
          <label for="nota">Nota <small>(obrigatório)</small></label>
          <select required id="nota" name="nota" class="sm-form-control required" aria-required="true">
              @for ($i = 5; $i >= 0; $i-=0.5)
                <option value="{{ number_format($i, 1) }}">{{ number_format($i, 1) }}</option>
              @endfor
          </select>
      </div>

      <div class='col_two_third col_last'>
        <div id="review_form_stars" class='chef-profile-stars chef-review-stars'>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </div>
      </div>

      <div class="clear"></div>

      <br>

      <div class='col_full'>
          <label for="texto">Avaliação <small>(obrigatório)</small></label>
          <textarea required class="required sm-form-control" id="texto" name="texto" rows="6" cols="30" aria-required="true"></textarea>
      </div>

      <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>
      <button type="submit" class="button button-3d nomargin"><i class="fa fa-share-square-o"></i> Enviar Avaliação</button>

  </form>
</div>

<script type="text/javascript">
$(document).ready(function() {

  $("#nota").change(function() {

      var review = $(this).val();
      var stars  = [];

      var blank  = parseInt(5 - review);
      var full   = parseInt(review);

      for (var i = 1; i <= full; i++) {
          stars.push('<i class="fa fa-star"></i>');
      }

      if ((review - full) > 0) {
          stars.push('<i class="fa fa-star-half-o"></i>');
      }

      for (var i = 1; i <= blank; i++) {
          stars.push('<i class="fa fa-star-o"></i>');
      }

      $("#review_form_stars").html(stars.join(' '));

  });

});
</script>