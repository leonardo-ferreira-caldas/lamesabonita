@extends('template')

@section('head')
    <link rel="stylesheet" href="/css/calendar.css" type="text/css" />
@endsection

@include("chef.perfil.foto_capa")

@section('container-class', 'chef-profile-content')

@section('content')
    <div class="container inner-pages">
        <div class="col_one_third">
            @include('chef.perfil.menu_lateral')
        </div>
        <div class="col_two_third col_last backgroundWhite">

            <div class="fancy-title title-bottom-border">
                <h2>Agenda</h2>
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
                <div id="calendar" class="calendario-agenda fc-calendar-container"></div>
            </div>

            <div class="divider divider-center marginbottom10px"><i class="fa fa-cutlery"></i></div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/js/jquery.calendario.js"></script>
<script type="text/javascript" src="/js/events-data.js"></script>
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
@endsection