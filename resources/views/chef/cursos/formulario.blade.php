@extends('template')

@include('chef.account.foto_capa')

@section('head')
    <link rel="stylesheet" href="/css/tipped.css" type="text/css" />
@endsection

@section('content')
<div class="container inner-pages">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite">
        <div class="fancy-title title-bottom-border" id="menu_form">
            <h2>Editar Curso</h2>
            <a href="/chef/cursos/novo" class="btn-fancy-title button button-3d nomargin">
                <i class="fa fa-plus"></i> Adicionar Novo Curso
            </a>
        </div>

        <form action="{{ route('salvar-curso') }}" class="use-loading" id="salvar_curso" method="POST" enctype="multipart/form-data">

            {!! csrf_field() !!}

            @include('includes/errors')

            <input type="hidden" value="{{ $curso->id_curso }}" name="id_curso" id="id_curso" />

            <div class='col_full marginbottom10px'>
                <label for="titulo">Nome do Curso <small>(obrigatório)</small></label>
                <input value="{{ old('titulo') ?: $curso->titulo }}" required type="text" id="titulo" name="titulo" class="sm-form-control required">
            </div>

            <div class='col_half marginbottom10px'>
                <label for="qtd_maxima_cliente">Qtd Máxima Convidados <small>(*)</small></label>
                <select required id="qtd_maxima_cliente" name="qtd_maxima_cliente" class="sm-form-control required" aria-required="true">
                    @for ($i = 5; $i <= 25; $i+=5)
                        <option {{ (old('qtd_maxima_cliente') ?: $curso->qtd_maxima_cliente) == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class='col_half col_last marginbottom10px'>
                <label for="preco">Preço Por Pessoa <small>(*)</small></label>
                <div class="input-icon-left marginbottom10px">
                    <input value="{{ old('preco') ?: $curso->preco }}" required type="text" name="preco" id="preco" class="price sm-form-control required">
                    <i class="fa fa-usd input-icon"></i>
                </div>
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

                        {!! col_clear($i, 4) !!}
                    @endforeach

                </fieldset>
            </div>

            <div class='col_full checkbox_tipo_culinaria'>
                <fieldset class="marginbottom10px">
                    <legend class="marginbottom10px"><label for="titulo">Culinária <small>(obrigatório)</small></label></legend>

                    @foreach ($combos['culinarias'] as $i => $culinaria)
                        <div class="checkbox col_one_fourth notopmargin checkbox-normalize bottommargin-mini {{ col_last($i, 4) }}">
                            <input
                                {{ checked_in($culinaria->id_culinaria, $curso->culinarias, 'id_culinaria') }}
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
                                {{ checked_in($tipo_refeicao->id_tipo_refeicao, $curso->refeicoes, 'id_tipo_refeicao') }}
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
                <label for="menu_picture">Fotos do Curso <small>(opcional)</small></label>

                <div class="menu-form-pictures">

                    @foreach ($curso->imagens as $idxPicture => $imagem)

                        <div class="col_one_fifth uploaded-picture-menu {{ $imagem->ind_capa ? 'cover-picture' : '' }} {{ $idxPicture == 4 ? 'col_last' : '' }}">
                            <img src="{{ route('image', ['w' => 130, 'h' => 115, 'i' => $imagem->nome_imagem ]) }}" />
                            <a title="Remover imagem" class="tpp remove-picture-menu" href="{{ route('curso.deletar_foto', ['curso' => $curso->id_curso, 'id' => $imagem->id_curso_imagem]) }}">
                                <i class="fa fa-trash-o"></i>
                            </a>

                            <a
                                title="{{ $imagem->ind_capa ? 'Esta imagem está definida como capa' : 'Usar imagem como capa' }}"
                                class="tpp define-as-cover"
                                href="{{ route('curso.definir_capa', ['curso' => $curso->id_curso, 'id' => $imagem->id_curso_imagem]) }}">

                                <i class="fa fa-picture-o"></i>
                            </a>
                        </div>

                    @endforeach

                    @for($i = 1;$i <= 5 - count($curso->imagens); $i++)
                    <div class="col_one_fifth {{ 5 - count($curso->imagens) == $i ? 'col_last' : '' }}">
                        <div class="add-picture">
                            <i class="fa fa-camera"></i><br>
                            Adicionar Foto
                            <input type="file" style="cursor: pointer;" id="curso_foto_{{ $i }}" name="curso_foto[]" class="sm-form-control required">
                        </div>
                        <div class="edit-picture">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>
                    @endfor
                </div>

            </div>

            <div class='col_full'>
                <label for="descricao">Descreva sobre tudo que será ensinado, destacando pratos, tipos de culinária e outros detalhes imporatantes sobre o curso: <small>(obrigatório) (máximo de 1600 caracteres)</small></label>
                <textarea required maxlength="1600" class="required sm-form-control" id="descricao" name="descricao" rows="7" cols="30">{{ isset($curso->descricao) ? $curso->descricao : old('descricao') }}</textarea>
            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>
            <button type="submit" class="btn-loading button button-3d nomargin">
                <span class="before-loading"><i class="fa fa-share-square-o"></i> Salvar Curso</span>
                <span class="loading"><i class="fa fa-share-square-o"></i> Salvando...</span>
            </button>

            @if($curso->ind_ativo)
                <a href="{{ route('inativar-curso', ['id' => $curso->slug]) }}" class="btn-loading button button-red button-3d nomargin">
                    <i class="fa fa-ban"></i> Inativar Curso
                </a>
            @else
                <a href="{{ route('ativar-curso', ['id' => $curso->slug]) }}" class="btn-loading button button-green button-3d nomargin">
                    <i class="fa fa-check-square-o"></i> Ativar Curso
                </a>
            @endif

            <blockquote class="processing-form nobottommargin topmargin-sm"><p><i class="fa fa-spinner fa-spin rightmargin-xsm"></i> Aguarde! Salvando curso...</p></blockquote>

        </form>
    </div>
</div>

@endsection

@section('js')
    <script type="text/javascript" src="/js/tipped.js"></script>
    <script type="text/javascript" src="/js/curso_formulario.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("form.use-loading").formLoading();
        });
    </script>
@endsection

@section('footer.html')
<div class='col_full prices-template single-price-menu marginbottom10px'>
    @include('chef.cursos.formulario_preco_por_clientes')
</div>
@endsection