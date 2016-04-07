@extends('template')

@section('container-class', 'chef-profile-content')

@section('content')
<div class="content-wrap nopadding">

    <div class="mb-nobottompadding mb-notoppadding mb-container nopadding toppadding-lg bottompadding-lg nobgmobile" style="background: url(/images/backgrounds/{{ $background }}); background-size: cover;">

        <div class="container clearfix mb-nomargin mb-nopadding mb-nowidth">

            <div class="mb-noleftpadding accordion accordion-lg divcenter login-box backgroundWhite nobottommargin clearfix">

                <div class="acctitle">
                    <div class="mb-nobottomargin fancy-title title-dotted-border title-left">
                        <h2>Acesse sua <span>conta</span></h2>
                    </div>
                </div>
                <div class="acc_content clearfix mb-nobottompadding">
                    @include('includes.errors')


                    <form id="login-form" name="login-form" class="nobottommargin" action="{{ route('post.login') }}" method="POST">
                        {!! csrf_field() !!}


                        <input style="display:none;" type="text" name="avoidAutoFillEmail" />
                        <input style="display:none;" type="password" name="avoidAutoFillPassword" />

                        <div class="col_full">
                            <label for="email">Email:</label>
                            <input required type="text" id="email" name="email" value="" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_full">
                            <label for="password">Senha:</label>
                            <input required type="password" id="password" name="password" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_half nobottommargin">
                            <div class="checkbox checkbox-normalize">
                                <input type="checkbox" class="checkbox" id="remember" name='remember'>
                                <label for="remember" class="checkbox login-checkbox">
                                    Lembre-se de mim
                                </label>
                            </div>
                        </div>

                        <div class="col_half col_last">
                            <a href="{{ url('recuperar-senha') }}" style="margin-top: 4px;" class="fright mb-nofloat">Esqueceu sua senha?</a>
                        </div>

                        <button class="button button-3d btn-full nomargin" value="login"><i class="fa fa-check-square-o"></i> Entrar</button>
                    </form>
                </div>

                <div class="divider divider-center mb-leftmargin-xxsm"><i class="fa fa-cutlery"></i></div>

                <a href="/registrar">
                {{--<a href="/registrar">--}}
                    <div class="fancy-title title-dotted-border title-left mb-leftmargin-sm mb-nopadding">
                        <h3 class="mb-nopadding">Não possui <span>conta</span>? Cadastre-se agora mesmo</h3>
                    </div>
                </a>

            </div>

        </div>

    </div>

</div>
@endsection