@extends('/template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Alterar Senha</h2>
        </div>

        @include('includes.errors')

        <form method="POST" action="/chef/alterar-senha">
            {!! csrf_field() !!}

            <div class="col_half">

                <div class='col_full'>
                    <label for="current_password">Senha Atual <small>*</small></label>
                    <div class="input-icon-left marginbottom10px">
                        <input type="password" id="current_password" name="current_password" class="sm-form-control required">
                        <i class="fa fa-lock input-icon"></i>
                    </div>
                </div>

                <div class='col_full'>
                    <label for="password">Nova Senha <small>*</small></label>
                    <div class="input-icon-left marginbottom10px">
                        <input type="password" id="password" name="password" class="sm-form-control required">
                        <i class="fa fa-lock input-icon"></i>
                    </div>
                </div>

                <div class='col_full'>
                    <label for="password_confirmation">Nova Senha Novamente <small>*</small></label>
                    <div class="input-icon-left marginbottom10px">
                        <input type="password" name='password_confirmation' class="sm-form-control required">
                        <i class="fa fa-lock input-icon"></i>
                    </div>
                </div>

            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>
            <button name="submit" type="submit" id="submit-button" value="Submit" class="mb-button-full button button-3d nomargin"><i class="fa fa-key"></i> Salvar Senha</button>
        </form>


    </div>
</div>
@endsection