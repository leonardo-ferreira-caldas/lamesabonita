@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Minhas Avaliações</h2>
        </div>

        @if(Auth::user()->chef->avaliacoes->count() == 0)
            <div class='col_full' style="margin-top: 70px;">
                <h3 class='text-center'>Vocẽ ainda não foi avaliado.</h3>
            </div>
        @endif

        @foreach(Auth::user()->chef->avaliacoes as $avaliacao)

          <div class="review review-chef">

            <div class='col_one_fourth left-review'>
              <span class='review_number'>{{ $avaliacao->nota }}</span>
              <div class="clear"></div>
              <span class="review_stars">
                  {!! $avaliacao->getStars() !!}
              </span>
            </div>

            <div class='col_three_fourth col_last'>
              <div class="review_user_avatar">
                <img width="64" src="/images/uploads/{{ $avaliacao->degustador->avatar }}">
              </div>
              <h4 class="nomargin review_user_name">{{ $avaliacao->degustador->user->name }}</h4>
              <p class="marginbottom10px">em {{ date("d/m/Y", strtotime($avaliacao->degustador->user->created_at)) }}</p>
              <div class="clear"></div>
              <br>
              <p>{{ $avaliacao->texto }}</p>
            </div>

          </div>

          <div class="divider divider-center nomargin"><i class="fa fa-cutlery"></i></div>

        @endforeach
            
    </div>
</div>
@endsection