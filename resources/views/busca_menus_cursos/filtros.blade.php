<input type='hidden' class='menu_filters_hidden' name='cidade' value="{{ $filtros['cidade'] or '' }}" />
<input type='hidden' class='menu_filters_hidden' name='data' value="{{ $filtros['data'] or '' }}" />
<input type='hidden' class='menu_filters_hidden' name='horario' value="{{ $filtros['horario'] or '' }}" />
<input type='hidden' class='menu_filters_hidden' name='pessoas' value="{{ $filtros['pessoas'] or ''}}" />

<div class="fancy-title title-dotted-border">
    <h4>Listar</h4>
</div>

<div class='col_full' style="margin-bottom: 20px;">

    <div style='padding-left: 5px'>

        <div class="checkbox">
            <input type="checkbox" checked class="checkbox" name='tipo' value='menu' id="tipo_menu">
            <label for="tipo_menu" class="checkbox">Menus</label>
        </div>

        <div class="checkbox">
            <input type="checkbox" checked class="checkbox" name='tipo' value='curso' id="tipo_cursos">
            <label for="tipo_cursos" class="checkbox">Cursos</label>
        </div>

    </div>

</div>

<div class="fancy-title title-dotted-border">
    <h4>Preço</h4>
</div>

<div class='col_full'>

    <span 
        id="range_money"
        data-prefix="R$"
        data-from="{{ $preco->minimo_preco }}"
        data-to="{{ $preco->maximo_preco }}"
        data-min="{{ $preco->minimo_preco }}"
        data-max="{{ $preco->maximo_preco }}"
        data-type="double"
        data-grid="true">
    </span>

</div>

<div class="fancy-title title-dotted-border">
    <h4>Reputação</h4>
</div>

<div class='col_full'>

    <div style='padding-left: 5px'>

        @foreach ($stars as $star)
            <div class="checkbox">
                <input type="checkbox" name='reputacao' value='{{ $star->stars }}' class="checkbox" id="{{ $star->stars }}_stars">
                <label for="{{ $star->stars }}_stars" class="checkbox">
                <span class="stars">
                    {!! Helpers::getStars($star->stars) !!}
                </span>
                    <span class='small-font'>({{ $star->qtd }})</span>
                </label>
            </div>
        @endforeach

    </div>

</div>

<div class="fancy-title title-dotted-border">
    <h4>Tipos de Refeição</h4>
</div>

<div class='col_full'>

    <div style='padding-left: 5px'>

        @foreach ($refeicoes as $refeicao)

            <div class="checkbox">
                <input type="checkbox" class="checkbox" name='tipo_refeicao' value='{{ $refeicao->id_tipo_refeicao }}' id="{{ $refeicao->nome_tipo_refeicao }}">
                <label for="{{ $refeicao->nome_tipo_refeicao }}" class="checkbox">
                    {{ $refeicao->nome_tipo_refeicao }} ({{ $refeicao->qtd_produtos }})
                </label>
            </div>

        @endforeach

    </div>

</div>

<div class="fancy-title title-dotted-border">
    <h4>Culinária</h4>
</div>

<div class='col_full'>

    <div style='padding-left: 5px'>

        @foreach ($culinarias as $culinaria)

            <div class="checkbox">
                <input type="checkbox" class="checkbox" name='culinaria' value='{{ $culinaria->id_culinaria }}' id="{{ $culinaria->nome_culinaria }}">
                <label for="{{ $culinaria->nome_culinaria }}" class="checkbox">
                    {{ $culinaria->nome_culinaria }} ({{ $culinaria->qtd_produtos }})
                </label>
            </div>

        @endforeach

    </div>

</div>
