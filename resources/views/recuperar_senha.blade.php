@extends('template')

@section('container-class', 'chef-profile-content')

@section('content')
<div class="content-wrap nopadding">

    <div style="padding: 100px 0 140px 0;">

        <div class="container clearfix">

            <div class="accordion accordion-lg divcenter login-box backgroundWhite nobottommargin clearfix">

                <div class="acctitle">
                    <div class="fancy-title title-dotted-border title-left">
                        <h2>Recuperar <span>Senha</span></h2>
                    </div>
                </div>
                <div class="acc_content clearfix">
                    @include('includes.errors')

                    <form id="login-form" name="login-form" class="nobottommargin" action="{{ url('recuperar-senha/enviar') }}" method="POST">
                        {!! csrf_field() !!}

                        <div class="col_full">
                            <label for="email">Email:</label>
                            <input required type="text" id="email" name="email" value="" class="sm-form-control required" aria-required="true">
                        </div>

                        <div class="col_full nobottommargin">
                            <button class="button button-3d nomargin" id="login-form-submit" name="login-form-submit" value="login"><i class="fa fa-check-square-o"></i> Enviar</button>
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