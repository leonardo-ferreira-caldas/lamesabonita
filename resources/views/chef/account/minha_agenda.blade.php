@extends('template')

@section('head')
<link rel="stylesheet" href="/css/calendar.css" type="text/css" />
<link rel="stylesheet" href="/css/tipped.css" type="text/css" />
@endsection

@include('chef.account.foto_capa')

@section('content')
<div class="container inner-pages mb-nomargin mb-nopadding mb-nowidth">
    <div class="col_one_fourth">
        @include('chef.account.menu_lateral')
    </div>
    <div class="col_three_fourth col_last backgroundWhite mb-noborder mb-leftpadding-xsm mb-rightpadding-xsm mb-nobottomargin">
        <div class="fancy-title title-bottom-border">
            <h2>Minha Agenda</h2>
        </div>

        <div class="events-calendar">
          <div class="events-calendar-header clearfix">
            <h3 class="calendar-month-year">
              <span id="calendar-month" class="calendar-month"></span>
              <span id="calendar-year" class="calendar-year"></span>
              <nav>
                <span id="calendar-prev" class="calendar-prev"><i class="icon-chevron-left"></i></span>
                <span id="calendar-next" class="calendar-next"><i class="icon-chevron-right"></i></span>
              </nav>
            </h3>
          </div>
          <div id="calendar" class="fc-calendar-container"></div>
        </div>

        <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/js/jquery.calendario.js"></script>
<script type="text/javascript" src="/js/tipped.js"></script>
<script type="text/javascript">

    var schedules = {};
    var sch       = {!! $schedules !!};

    for (var i in sch) {
        var from = sch[i].hora_de + (parseInt(sch[i].hora_de_hora) <= 12 ? ' a.m' : ' p.m');
        var to   = sch[i].hora_ate   + (parseInt(sch[i].hora_ate_hora) <= 12   ? ' a.m' : ' p.m');

        schedules[sch[i].data] = "<div class='schedule' data-from='" + sch[i].hora_de_hora + "' data-to='" + sch[i].hora_ate_hora + "' data-id='" + sch[i].id_chef_agenda + "'>De: " + from + "<br>Até: " + to + "</div>";

    }

</script>

<script type="text/javascript" src="/js/calendar.js"></script>

    <div id="template-horario">
        <form method="" class="template-horario-agenda">
            <div class="col_full">
                <label for="horario">Disponível de:</label>
                <div class="input-icon-left">
                    <select required type="text" id="horario_de" name="horario_ate" class="sm-form-control required">
                        @for($i=7;$i<=22;$i++)
                            <option
                                value='{{str_pad($i, 2, '0', STR_PAD_LEFT)}}'
                                >{{str_pad($i, 2, '0', STR_PAD_LEFT)}}:00</option>
                        @endfor
                    </select>
                    <i class="fa fa-clock-o"></i>
                </div>
            </div>
            <div class="clear"></div>

            <div class="col_full">
                <label for="horario">Até:</label>
                <div class="input-icon-left">
                    <select required type="text" id="horario_ate" name="horario_ate" class="sm-form-control required">
                        @for($i=7;$i<=22;$i++)
                            <option
                                    value='{{str_pad($i, 2, '0', STR_PAD_LEFT)}}'
                                    {{ $i == 22 ? 'selected' : '' }}
                                    >{{str_pad($i, 2, '0', STR_PAD_LEFT)}}:00</option>
                        @endfor
                    </select>
                    <i class="fa fa-clock-o"></i>
                </div>
            </div>
            <div class="clear"></div>

            <div class="divider divider-center nomargin marginbottom10px"><i class="fa fa-cutlery"></i></div>

            <div class="col_full nomargin">
                <button type="submit" class="save-agenda button-small btn-full text-center button button-3d nomargin"><i class="icon-ok"></i> <span>Salvar</span></button>
            </div>
            <div class="clear"></div>

            <div class="col_full not-available nomargin">
                <button type="button" class="remover-agenda button-small button-red btn-full text-center button button-3d nomargin">
                    <i class="fa fa-trash-o"></i> Remover Agenda
                </button>
            </div>

        </form>
    </div>

@endsection