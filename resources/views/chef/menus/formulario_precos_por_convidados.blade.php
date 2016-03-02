<div class='menu_price_rule'>
    <label for="">Preço: </label>
    <div class="input-icon-left menu_price_rule_field marginbottom10px">
        <input
            @if(isset($price->preco))
                value='{{ $price->preco }}'
            @endif
            required="required"
            type="text" 
            name="menu_preco[]"
            id="price"
            class="sm-form-control required">
        <i class="fa fa-usd input-icon"></i>
    </div>
</div>
<div class='menu_price_rule_guests'>
    <label for="">a partir de </label>
    <div class='menu_price_rule_guests_field'>
        <select required type="text" id="qtd_minima_clientes" name="qtd_minima_clientes[]" class="sm-form-control required" aria-required="true">
        @for($i = 2; $i < 30; $i++)
            <option
                @if(isset($price->qtd_minima_clientes) && $price->qtd_minima_clientes == $i)
                    selected="selected"
                @endif
                value='{{ $i }}'>{{ $i }}</option>
        @endfor
        </select>
    </div>
    <label for="" style="margin-left: 5px;"> pessoas</label>
</div>

<div class='menu_price_rule_remove'>
    <a href="#" class="remove-price-menu button button-small button-red button-3d nomargin">
        <i class="fa fa-trash"></i> Remover
    </a>
</div>