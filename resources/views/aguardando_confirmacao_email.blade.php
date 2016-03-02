@extends('template')

@section('container-class', 'chef-profile-content')

@section('content')
<div class="content-wrap nopadding">

    <div style="padding: 100px 0 140px 0;">

        <div class="container clearfix">

            <div class="accordion accordion-lg divcenter login-box backgroundWhite nobottommargin clearfix">

                <div class="acctitle">
                    <div class="fancy-title title-dotted-border title-left">
                        <h2>Confirmação <span>E-mail</span></h2>
                    </div>
                </div>
                <div class="acc_content clearfix">
                    <p>
                        Um e-mail de confirmação foi enviado para {{ Auth::user()->email }}.
                        <br>
                        Pedimos a gentileza de confirmar seu interesse clicando no link enviado por e-mail.
                    </p>

                    <p>Não recebeu o e-mail de confirmaçao? Clique no botão abaixo para reenviar.</p>
                    <a class="button button-3d nomargin" href="{{ route('reenviar-confirmacao-email') }}">
                        <i class="fa fa-share-square-o"></i> Reenviar E-mail de Confirmação
                    </a>
                </div>

                <div class="clear"></div>
                <br>

            </div>

        </div>

    </div>

</div>
@endsection