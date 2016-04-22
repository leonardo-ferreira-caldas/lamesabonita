@extends('template')

@include('chef.account.foto_capa')

@section('head')
    <link rel="stylesheet" href="/css/tipped.css" type="text/css" />
@endsection

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border" id="menu_form">
            <h2>Novo Menu</h2>
        </div>

        <form action="{{ route('salvar-menu') }}" class="use-loading" id="salvar_menu" method="POST" enctype="multipart/form-data">

            {!! csrf_field() !!}

            @include('includes/errors')

            <div class='col_full marginbottom10px'>
                <label for="titulo">Nome do Menu <small>(obrigatório)</small></label>
                <input value="{{ old('titulo') }}" required type="text" id="titulo" name="titulo" class="sm-form-control required">
            </div>

            <div class='col_half marginbottom10px'>
                <label for="qtd_maxima_cliente">Qtd Máxima Convidados <small>(*)</small></label>
                <select required="required" id="qtd_maxima_cliente" name="qtd_maxima_cliente" class="sm-form-control required" aria-required="true">
                    @for ($i = 5; $i <= 25; $i+=5)
                        <option {{ old('qtd_maxima_cliente') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class='col_half col_last marginbottom10px'>
                <label for="preco">Preço Por Pessoa <small>(*)</small></label>
                <div class="input-icon-left marginbottom10px">
                    <input value="{{ old('preco') }}" required type="text" name="preco" id="preco" class="price sm-form-control required">
                    <i class="fa fa-usd input-icon"></i>
                </div>
            </div>

            <div class='col_full'>
                <fieldset class="marginbottom10px">
                    <legend class="marginbottom10px"><label for="titulo">Preços por convidados <small>(opcional)</small></label></legend>

                    <div id="prices_rules">
                        <span class="preco_fallback">Nenhum preço por convidado cadastrado.</span>
                    </div>

                </fieldset>
                <a href="#" id="add_price_menu" class="text-center mb-button-full button button-small button-3d nomargin">
                    <i class="fa fa-plus"></i> Adicionar Preço Por Convidados
                </a>
            </div>

            <div class='col_full lista_incluso_preco'>
                <fieldset class="marginbottom10px">
                    <legend class="marginbottom10px"><label for="titulo">O que está incluso no preço</label></legend>

                    @foreach ($combos['incluso_preco'] as $i => $incluso_preco)
                        <div class="checkbox col_full notopmargin checkbox-normalize bottommargin-mini">

                            <span>
                                <i class="fa fa-check fa-fw"></i> {{ $incluso_preco->descricao }}
                            </span>
                        </div>

                    @endforeach

                </fieldset>
            </div>

            <div class='col_full checkbox_tipo_culinaria'>
                <fieldset class="marginbottom10px">
                    <legend class="marginbottom10px"><label for="titulo">Culinária <small>(obrigatório)</small></label></legend>

                    @foreach ($combos['culinarias'] as $i => $culinaria)
                    <div class="checkbox col_one_fourth notopmargin checkbox-normalize bottommargin-mini {{ col_last($i, 4) }}">
                        <input
                            type="checkbox"
                            class="checkbox"
                            name="tipo_culinaria[]"
                            value="{{$culinaria->id_culinaria}}"
                            id="tipo_culinaria_{{$culinaria->id_culinaria}}">

                        <label for="tipo_culinaria_{{$culinaria->id_culinaria}}" class="checkbox">
                            {{$culinaria->nome_culinaria}}
                        </label>
                    </div>
                    {!! col_clear($i, 4) !!}
                    @endforeach

                </fieldset>
            </div>

            <div class='col_full checkbox_tipo_refeicao'>
                <fieldset class="marginbottom10px">
                    <legend class="marginbottom10px"><label for="titulo">Tipo de Refeição <small>(obrigatório)</small></label></legend>

                    @foreach ($combos['tipo_refeicao'] as $i => $tipo_refeicao)
                        <div class="checkbox col_one_fourth notopmargin checkbox-normalize bottommargin-mini {{ col_last($i, 4) }}">
                            <input
                                type="checkbox"
                                class="checkbox"
                                name="tipo_refeicao[]"
                                value="{{$tipo_refeicao->id_tipo_refeicao}}"
                                id="tipo_refeicao_{{$tipo_refeicao->id_tipo_refeicao}}">

                            <label for="tipo_refeicao_{{$tipo_refeicao->id_tipo_refeicao}}" class="checkbox">
                                {{$tipo_refeicao->nome_tipo_refeicao}}
                            </label>
                        </div>
                        {!! col_clear($i, 4) !!}
                    @endforeach

                </fieldset>
            </div>

            <div class='col_full'>
                <label for="menu_picture">Fotos do Menu <small>(opcional)</small></label>

                <div class="menu-form-pictures">

                    @for($i = 1; $i <= 5; $i++)
                        <div class="col_one_fifth {{ 5 == $i ? 'col_last' : '' }}">
                            <div class="add-picture">
                                <i class="fa fa-camera"></i><br>
                                Adicionar Foto
                                <input type="file" style="cursor: pointer;" id="menu_foto_{{ $i }}" name="menu_foto[]" class="sm-form-control required">
                            </div>
                            <div class="edit-picture">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                    @endfor
                </div>

            </div>

            <div class='col_full'>
                <label for="aperitivo">Aperitivos</label>
                <textarea class="required sm-form-control" name="aperitivo" id="aperitivo" rows="4" cols="30" aria-required="true">{{ isset($menu->aperitivo) ? $menu->aperitivo : old('aperitivo') }}</textarea>
            </div>

            <div class='col_full'>
                <label for="entrada">Prato de Entrada</label>
                <textarea class="required sm-form-control" name="entrada" id="entrada" rows="4" cols="30" aria-required="true">{{ isset($menu->entrada) ? $menu->entrada : old('entrada') }}</textarea>
            </div>

            <div class='col_full'>
                <label for="prato_principal">Prato Principal <small>(obrigatório)</small></label>
                <textarea required class="required sm-form-control" id="prato_principal" name="prato_principal" rows="4" cols="30" aria-required="true">{{ isset($menu->prato_principal) ? $menu->prato_principal : old('prato_principal') }}</textarea>
            </div>

            <div class='col_full'>
                <label for="sobremesa">Sobremesa</label>
                <textarea class="required sm-form-control" id="sobremesa" name="sobremesa" rows="4" cols="30">{{ isset($menu->sobremesa) ? $menu->sobremesa : old('sobremesa') }}</textarea>
            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>
            <button type="submit" class="btn-loading button button-3d nomargin text-center mb-button-full">
                <span class="before-loading"><i class="fa fa-share-square-o"></i> Salvar Menu</span>
            </button>

            <blockquote class="processing-form nobottommargin topmargin-sm"><p><i class="fa fa-spinner fa-spin rightmargin-xsm"></i> Aguarde! Salvando menu...</p></blockquote>

        </form>
    </div>
</div>

@endsection

@section('js')
    <script type="text/javascript" src="/js/tipped.js"></script>
    <script type="text/javascript"  src="/js/menu_formulario.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("form.use-loading").formLoading();
        });
    </script>
@endsection

@section('footer.html')
    <div class='col_full prices-template single-price-menu marginbottom10px'>
        @include('chef.menus.formulario_precos_por_convidados')
    </div>
@endsection