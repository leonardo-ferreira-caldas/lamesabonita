<div class="padding20px notoppadding topmargin-sm">

    <div class="fancy-title title-bottom-border">
        <h3>Faça sua reserva</h3>
    </div>

    <form action="{{ route('reservar.endereco', ['chef' => $chef_slug, 'tipo' => $tipo, 'menu' => $slug]) }}" method="GET">

        <div class="col_full">
            <label for="data">Data</label>
            <div class="input-icon-left">
                <input required type="text" id="data_reserva" name="data_reserva" class="sm-form-control required">
                <i class="fa fa-calendar-o"></i>
            </div>
        </div>

        <div class="col_full">
            <label for="horario_reserva">Hora</label>
            <div class="input-icon-left">
                <select required disabled type="text" id="horario_reserva" name="horario_reserva" class="sm-form-control required">
                    <option selected value="">Escolha seu horário...</option>
                </select>
                <i class="fa fa-clock-o"></i>
            </div>
        </div>

        <div class="col_full">
            <label for="qtd_clientes">Pessoas</label>
            <div class="input-icon-left">
                <select required type="text" id="qtd_clientes" name="qtd_clientes" class="sm-form-control required">
                    @for($i = 1; $i <= $qtd_maxima_cliente; $i++)
                        <option>{{str_pad($i, 2, '0', STR_PAD_LEFT)}}</option>
                    @endfor
                </select>
                <i class="fa fa-users"></i>
            </div>
        </div>

        <div class="col_full">
            <label for="observacao">Observação / Complemento</label>
            <textarea class="required sm-form-control" id="observacao" name="observacao" rows="6" cols="30"></textarea>
        </div>

        <div class="divider divider-center small-margin"><i class="fa fa-cutlery"></i></div>

        <button type="submit" class="topmargin-sm button button-3d nomargin pull-right">
            <i class="fa fa-book"></i> Reservar
        </button>

    </form>

</div>