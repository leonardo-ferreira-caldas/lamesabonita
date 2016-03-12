<form action="/nossos-menus-cursos" method="GET">
    <div class="home-sf-cidade">
        <label for="city_chef">Cidade</label>
        <div class="input-icon-left">
            <input 
                value="{{ $filtros['cidade'] or '' }}"
                id="city_chef"
                required
                type="text"
                placeholder="Exemplo: São Paulo"
                name="cidade"
                class="sm-form-control required">
            <i class="fa fa-map-marker"></i>
        </div>
    </div>
    <div class="home-sf-date">
        <label for="data">Data</label>
        <div class="input-icon-left">
            <input required type="text" id="data" value="{{ $filtros['data'] or date('d/m/Y', time()+86400) }}" name="data" class="sm-form-control required date_picker">
            <i class="fa fa-calendar-o"></i>
        </div>
    </div>
    <div class="home-sf-mini">
        <label for="horario">Hora</label>
        <div class="input-icon-left">
            <select required type="text" id="horario" name="horario" class="sm-form-control required">
                @for($i=7;$i<=22;$i++)
                    <option
                        value='{{ $i }}'
                        {{ !empty($filtros['horario']) && $filtros['horario'] == $i ? 'selected' : '' }}
                    >{{str_pad($i, 2, '0', STR_PAD_LEFT)}}:00</option>
                @endfor
            </select>
            <i class="fa fa-clock-o"></i>
        </div>
    </div>
    <div class="home-sf-mini-pessoas">
        <label for="pessoas">Pessoas</label>
        <div class="input-icon-left">
            <select required type="text" id="pessoas" name="pessoas" class="sm-form-control required">
                @for($i=1;$i<=30;$i++)
                    <option
                        value='{{ $i }}'
                        {{ !empty($filtros['pessoas']) && $filtros['pessoas'] == $i ? 'selected' : '' }}
                    >{{str_pad($i, 2, '0', STR_PAD_LEFT)}}</option>
                @endfor
            </select>
            <i class="fa fa-users"></i>
        </div>
   </div>
    <div class="home-sf-btn">
        <button type="submit" class="home-src-btn button button-rounded button-reveal button-large tright">
            <i class="fa fa-search"></i><span>Pesquisar</span>
        </button>
    </div>
    <div class="clear"></div>
</form>