@extends('template')

@section('content')
<div class="content-wrap nopadding" style="position: relative; background-size: cover; background-repeat: no-repeat; width: 100%;background-image: url('/images/backgrounds/1.jpg');">

    <div style="width: 100%; min-height: 500px; padding-bottom: 100px; padding-top: 100px; background: rgba(0,0,0,0.6);">

        <div class="container clearfix">

            <div class="accordion accordion-lg divcenter login-box backgroundWhite nobottommargin clearfix">

                <div class="acctitle">
                    <div class="fancy-title title-dotted-border title-left">
                        <h2>Alterar <span>Senha</span></h2>
                    </div>
                </div>
                <div class="acc_content clearfix">
                    @include('includes.errors')

                    <form id="login-form" name="login-form" class="nobottommargin" action="{{ url('resetar-senha') }}" method="POST">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="col_full">
                            <label for="password">Nova Senha:</label>
                            <input required type="password" id="password" name="password" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_full">
                            <label for="password_confirmation">Repita Senha:</label>
                            <input required type="password" id="password_confirmation" name="password_confirmation" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_full nobottommargin">
                            <button class="button button-3d nomargin" id="login-form-submit" name="login-form-submit" value="login"><i class="fa fa-check-square-o"></i> Alterar Senha</button>
                        </div>
                    </form>
                </div>

                <div class="clear"></div>
                <br>

            </div>

        </div>

    </div>

</div>
@endsection