@extends('template')

@section('container-class', 'chef-profile-content')

@section('content')
<div class="content-wrap nopadding">

    <div class="mb-nobottompadding mb-notoppadding mb-container nopadding toppadding-lg bottompadding-lg nobgmobile" style="background: url(/images/backgrounds/background_cadastro.jpg); background-size: cover;">

        <div class="container clearfix mb-nomargin mb-nopadding mb-nowidth">

            <div class="mb-noleftpadding accordion accordion-lg divcenter login-box backgroundWhite nobottommargin clearfix">

                <div class="acctitle">
                    <div class="mb-nobottomargin fancy-title title-dotted-border title-left">
                        <h2>Cadastrar-se</h2>
                    </div>
                </div>
                <div class="acc_content clearfix mb-nobottompadding">
                    @include('includes.errors')

                    <form action="/registrar" id="register-form" name="register-form" class="nobottommargin" method="POST">
                        {!! csrf_field() !!}

                        <input name='is_chef' value='0' type="hidden" />

                        <div class="col_full">
                            <label for="name">Nome:</label>
                            <input required type="text" id="name" name="name" value="{{ old('name') }}" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_full">
                            <label for="email">Email:</label>
                            <input required type="text" id="email" name="email" value="{{ old('email') }}" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_full">
                            <label for="password">Senha:</label>
                            <input required type="password" id="password" name="password" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_full">
                            <label for="password_confirmation">Repita Senha:</label>
                            <input required type="password" id="password_confirmation" name="password_confirmation" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_full checkbox agree-terms checkbox-normalize">
                            <input type="checkbox" class="checkbox" id="checkbox-terms" name="checkbox-terms">
                            <label for="checkbox-terms" class="checkbox">
                                Eu concordo com os <a href="{{ route('termos-degustador') }}">Termos de Uso</a> da La Mesa Bonita.
                            </label>
                        </div>

                        <div class="col_full nobottommargin">
                            <button class="button mb-button-full btn-full text-center button-3d nomargin" id="login-form-submit" name="login-form-submit" value="login">
                                <i class="fa fa-sign-in"></i> Cadastrar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="divider divider-center mb-leftmargin-xxsm"><i class="fa fa-cutlery"></i></div>

                <a href="/login">
                    <div class="fancy-title title-dotted-border title-left mb-leftmargin-sm">
                        <h3 class="mb-nopadding">Já poussui uma <span>conta</span>? Acesse-a agora mesmo</h3>
                    </div>
                </a>

            </div>

        </div>

    </div>

</div>
@endsection

@section("js")
    <script type="text/javascript">
        $(document).ready(function() {
            $("#register-form").submit(function (evt) {
                if (!$("#checkbox-terms").is(":checked")) {
                    Utils.alert.error("Não permitido!", "Para se cadastrar você precisa concordar com os termos de uso da La Mesa Bonita.");
                    evt.preventDefault();
                    return false;
                }

                return true;
            });
        });
    </script>
@endsection