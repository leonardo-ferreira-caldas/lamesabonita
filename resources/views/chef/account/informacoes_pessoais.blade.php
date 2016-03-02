@extends('template')

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Informações Pessoais</h2>
        </div>

        <form method="POST" class="use-ajax" action="/chef/alterar-dados">

            {!! csrf_field() !!}

            @include('includes/errors')

            <div class='col_one_third'>
                <label for="name">Nome <small>(obrigatório)</small></label>
                <input required type="text" value="{{ $dados['nome'] }}" name="name" id="name" class="sm-form-control required">
            </div>

            <div class='col_one_third'>
                <label for="name">Sobrenome <small>(obrigatório)</small></label>
                <input required type="text" value="{{ $dados['sobrenome'] }}" name="sobrenome" id="sobrenome" class="sm-form-control required">
            </div>

            <div class='col_one_third col_last'>
                <label for="data_nascimento">Data de Nascimento <small>(*)</small></label>
                <input required type="text" value="{{ $dados['data_nascimento'] }}" name="data_nascimento" id="data_nascimento" class="sm-form-control date_picker required">
            </div>

            <div class="clear"></div>

            <div class='col_one_third'>
                <label for="cpf">CPF <small>(obrigatório)</small></label>
                <input required type="text" value="{{ $dados['cpf'] }}" name="cpf" id="cpf" class="sm-form-control required">
            </div>

            <div class='col_one_third'>
                <label for="cpf">RG <small>(obrigatório)</small></label>
                <input required type="text" value="{{ $dados['rg'] }}" name="rg" id="rg" class="sm-form-control required">
            </div>

            <div class='col_one_third col_last'>
                <label for="fk_sexo">Sexo <small>(*)</small></label>
                <select required type="text" id="fk_sexo" name="fk_sexo" class="sm-form-control required" aria-required="true">
                    <option value="">Selecione seu sexo...</option>
                    @foreach ($combos['sexos'] as $sexo)
                        <option
                            {{ $dados['sexo'] == $sexo->id_sexo ? "selected='selected'" : "" }}
                            value="{{$sexo->id_sexo}}">
                            {{$sexo->descricao}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class='col_two_third'>
                <label for="email">Email</label>
                <input required disabled type="text" value="{{ $dados['email'] }}" name="email" id="email" class="sm-form-control required">
            </div>

            <div class='col_one_third col_last'>
                <label for="telefone">Telefone <small>(obrigatório)</small></label>
                <input required type="text" value="{{ $dados['telefone'] }}" name="telefone" id="telefone" class="sm-form-control required">
            </div>

            <div class='col_full'>
                <label for="sobre_chef">Sobre o Chef (Histórico, Formação, Experiências, Paixões) <small>(obrigatório) (máximo de 1500 caracteres)</small></label>
                <textarea required maxlength="1500" class="required sm-form-control" id="sobre_chef" name="sobre_chef" rows="12" cols="30" aria-required="true">{{ $dados['sobre_chef'] }}</textarea>
            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>
            <button type="submit" class="button button-3d nomargin mb-button-full"><i class="fa fa-share-square-o"></i> Salvar Minha Informações</button>

            <blockquote class="processing-form nobottommargin topmargin-sm"><p><i class="fa fa-spinner fa-spin rightmargin-xsm"></i> Aguarde! Salvando informações pessoais...</p></blockquote>

        </form>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" src="/js/jquery.mask.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("form.use-ajax").ajaxForm();
            $("#data_nascimento").mask("99/99/9999");
            $("#cpf").mask("999.999.999-99");
        });
    </script>
@endsection