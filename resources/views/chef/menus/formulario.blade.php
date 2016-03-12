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
            @if(isset($menu->id_menu))
                <h2>Editar Menu</h2>
                <a href="/chef/menu/novo" class="btn-fancy-title button button-3d nomargin"><i class="fa fa-plus"></i> Adicionar Novo Menu</a>
            @else
                <h2>Novo Menu</h2>
            @endif
        </div>

        <form action="{{ route('salvar-menu') }}" class="use-loading" id="salvar_menu" method="POST" enctype="multipart/form-data">

            {!! csrf_field() !!}

            @include('includes/errors')

            <input type="hidden" value="{{ isset($menu->id_menu) ? $menu->id_menu : '' }}" name="id_menu" id="id_menu" />

            <div class='col_full marginbottom10px'>
                <label for="titulo">Nome do Menu <small>(obrigatório)</small></label>
                <input value="{{ isset($menu->titulo) ? $menu->titulo : old('titulo') }}" required type="text" id="titulo" name="titulo" class="sm-form-control required">
            </div>

            <div class='col_half marginbottom10px'>
                <label for="qtd_maxima_cliente">Qtd Máxima Convidados <small>(*)</small></label>
                <select required type="text" id="qtd_maxima_cliente" name="qtd_maxima_cliente" class="sm-form-control required" aria-required="true">
                    @for ($i = 5; $i <= 25; $i+=5)
                        <option {{ isset($menu->id_menu) && $menu->qtd_maxima_cliente == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class='col_half col_last marginbottom10px'>
                <label for="preco">Preço Por Pessoa <small>(*)</small></label>
                <div class="input-icon-left marginbottom10px">
                    <input value="{{ isset($menu->preco) ? $menu->preco : old('preco') }}" required type="text" name="preco" id="preco" class="price sm-form-control required">
                    <i class="fa fa-usd input-icon"></i>
                </div>
            </div>

            <div class='col_full'>
                <fieldset class="marginbottom10px">
                    <legend class="marginbottom10px"><label for="titulo">Preços por convidados <small>(opcional)</small></label></legend>

                    <div id="prices_rules">

                        @if(isset($menu) && $menu->precos->count() > 0)
                            @foreach($menu->precos as $price)
                                <div class='col_full single-price-menu marginbottom10px'>
                                    @include('chef.menus.formulario_precos_por_convidados')
                                </div>
                            @endforeach
                            <span class="preco_fallback" style="display: none">Nenhum preço por convidado cadastrado.</span>
                        @else
                            <span class="preco_fallback">Nenhum preço por convidado cadastrado.</span>
                        @endif
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
                            @if(isset($menu))
                                {{ checked_in($culinaria->id_culinaria, $menu->culinarias, 'id_culinaria') }}
                            @endif
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
                                @if(isset($menu))
                                    {{ checked_in($tipo_refeicao->id_tipo_refeicao, $menu->refeicoes, 'id_tipo_refeicao') }}
                                @endif
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

                    @foreach ($menu->imagens as $idxPicture => $imagem)

                        <div class="col_one_fifth uploaded-picture-menu {{ $imagem->ind_capa ? 'cover-picture' : '' }} {{ $idxPicture == 4 ? 'col_last' : '' }}">
                            <img src="{{ route('image', ['w' => 130, 'h' => 115, 'i' => $imagem->nome_imagem ]) }}" />
                            <a title="Remover imagem" class="tpp remove-picture-menu" href="{{ route('menu.deletar_foto', ['menu' => $menu->id_menu, 'id' => $imagem->id_menu_imagem]) }}">
                                <i class="fa fa-trash-o"></i>
                            </a>

                            <a
                                title="{{ $imagem->ind_capa ? 'Esta imagem está definida como capa' : 'Usar imagem como capa' }}"
                                class="tpp define-as-cover"
                                href="{{ route('menu.definir_capa', ['menu' => $menu->id_menu, 'id' => $imagem->id_menu_imagem]) }}">

                                <i class="fa fa-picture-o"></i>
                            </a>
                        </div>

                    @endforeach

                    @for($i = 1;$i <= 5 - count($menu->imagens); $i++)
                        <div class="col_one_fifth {{ 5 - count($menu->imagens) == $i ? 'col_last' : '' }}">
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

            @if(isset($menu->id_menu))
                @if($menu->ind_ativo)
                    <a href="{{ route('inativar-menu', ['id' => $menu->slug]) }}" class="btn-loading button button-red button-3d nomargin">
                        <i class="fa fa-ban"></i> Inativar Menu
                    </a>
                @else
                    <a href="{{ route('ativar-menu', ['id' => $menu->slug]) }}" class="btn-loading button button-green button-3d nomargin">
                        <i class="fa fa-check-square-o"></i> Ativar Menu
                    </a>
                @endif
            @endif

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