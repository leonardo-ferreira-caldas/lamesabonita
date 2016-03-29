$(document).ready(function() {
    var STR_PAD_LEFT = 1;
    var STR_PAD_RIGHT = 2;
    var STR_PAD_BOTH = 3;

    function pad(str, len, pad, dir) {

        if (typeof(len) == "undefined") { var len = 0; }
        if (typeof(pad) == "undefined") { var pad = ' '; }
        if (typeof(dir) == "undefined") { var dir = STR_PAD_RIGHT; }

        if (len + 1 >= str.toString().length) {

            switch (dir){

                case STR_PAD_LEFT:
                    str = Array(len + 1 - str.toString().length).join(pad) + str;
                    break;

                case STR_PAD_BOTH:
                    var right = Math.ceil((padlen = len - str.toString().length) / 2);
                    var left = padlen - right;
                    str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
                    break;

                default:
                    str = str + Array(len + 1 - str.toString().length).join(pad);
                    break;

            } // switch

        }

        return str;

    }

    var cal;

    cal = $('#calendar').calendario({
        onDayClick: function ($el, $contentEl, dateProperties) {


        },
        displayWeekAbbr: true,
        weeks: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        weekabbrs: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Augosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthabbrs: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],

        caldata: schedules
    }),

    $month = $('#calendar-month').html(cal.getMonthName()),
    $year = $('#calendar-year').html(cal.getYear());

    $('#calendar-next').on('click', function () {
        cal.gotoNextMonth(updateMonthYear);
        $('.schedule').parent().parent().addClass("available");
    });

    $('#calendar-prev').on('click', function () {
        cal.gotoPreviousMonth(updateMonthYear);
        $('.schedule').parent().parent().addClass("available");
    });

    $('#calendar-current').on('click', function () {
        cal.gotoNow(updateMonthYear);
        $('.schedule').parent().parent().addClass("available");
    });

    $('.schedule').parent().parent().addClass("available");

    function updateMonthYear() {
        $month.html(cal.getMonthName());
        $year.html(cal.getYear());
    }

    var $calendario = $('#calendar:not(.calendario-agenda)');

    $calendario.on('mouseenter mouseleave', '.fc-row > div:not(:empty)', function (event) {
        if (event.type === 'mouseenter') {
            $(this).addClass('hover');
        } else if (event.type === 'mouseleave') {
            $(this).removeClass('hover');
        }
    });

    if ($calendario.size() > 0) {

        Tipped.setStartingZIndex(100);
        Tipped.delegate('.fc-row > div:not(:empty)', function (element) {
            return {
                title: 'Horário Disponível',
                content: $("#template-horario").html()
            };
        }, {
            skin: 'light',
            position: 'right',
            close: true,
            hideOn: false,
            showOn: 'click',
            showDelay: 15,
            maxWidth: 400,
            onShow: function (content, element) {

                Tipped.hide('.editing');

                $(".editing").each(function () {
                    if (!$(this).find('.schedule').size()) {
                        $(this).removeClass('available');
                    }

                    $(this).removeClass('editing');
                });

                $(element).addClass('available editing');

                if ($(element).find('.schedule').size()) {
                    $(content).find("form").addClass('on-edit');
                    $(content).find('.save-agenda span').text('Atualizar');

                    var from = $(element).find('.schedule').data('from');
                    var to = $(element).find('.schedule').data('to');

                    $(content).find('#horario_de').val(from);
                    $(content).find('#horario_ate').val(to);

                } else {
                    $(content).find('.save-agenda span').text('Salvar');
                    $(content).find("form").removeClass('on-edit');
                }

                Tipped.refresh('.fc-row > div:not(:empty)');

            },
            afterHide: function (content, element) {
                if (!$(element).find('.schedule').size()) {
                    $(element).removeClass('available');
                }

                $(element).removeClass('editing');
            }
        });

        $('body').on('submit', '.template-horario-agenda', function (evt) {
            var $form, $de, $ate;

            $form = $(this);
            $de = $form.find("#horario_de").val();
            $ate = $form.find("#horario_ate").val();

            if (parseInt($de) >= parseInt($ate)) {
                swal({
                    title: "Não Permitido!",
                    text: "O horário de fim deve ser maior que o hoŕario de início.",
                    type: "error",
                    confirmButtonText: "OK"
                });
                return false;
            }

            var $deHtml = $de + ":00 " + ($de <= 12 ? 'a.m' : 'p.m');
            var $ateHtml = $ate + ":00 " + ($ate <= 12 ? 'a.m' : 'p.m');

            var obj = {};
            var month = pad(cal.getMonth(), 2, '0', STR_PAD_LEFT);
            var day = pad($('.editing .fc-date').text(), 2, '0', STR_PAD_LEFT);

            var idSchedule = $('.editing .schedule').data('id') || null;
            var inserted = 'inserted_' + new Date().getTime();

            var htmlSchedule = "<div id='" + inserted + "' class='schedule' data-from='" + $de + "' data-to='" + $ate + "' data-id='" + idSchedule + "'>De: " + $deHtml + "<br>Até: " + $ateHtml + "</div>";

            obj[month + '-' + day + '-' + cal.getYear()] = htmlSchedule;

            var d = new Date();
            var currMonth = pad(d.getMonth() + 1, 2, '0', STR_PAD_LEFT);
            var currDay = pad(d.getDate(), 2, '0', STR_PAD_LEFT);
            var currentDate = d.getFullYear() + "-" + currMonth + "-" + currDay;
            var scheduleDate = cal.getYear() + '-' + month + '-' + day;

            if (currentDate >= scheduleDate) {
                swal({
                    title: "Não Permitido!",
                    text: "Não é possível agendar horários para o dia atual ou para datas anteriores.",
                    type: "error",
                    confirmButtonText: "OK"
                });
                Tipped.hide('.fc-row > div:not(:empty)');
                return false;
            }

            cal.setData(obj);
            $('.schedule').parent().parent().addClass("available");

            $('.editing .schedule').remove();
            $('.editing').append(htmlSchedule);
            Tipped.hide('.fc-row > div:not(:empty)');

            var postData = {
                'year': cal.getYear(),
                'month': cal.getMonth(),
                'day': day,
                'time_from': $de,
                'time_to': $ate
            };

            var url = '/backoffice/chef/agenda/salvar/' + idChef;

            if (idSchedule) {
                url = '/backoffice/chef/agenda/atualizar/' + idChef + "/" + idSchedule;
            }

            $.get(url, postData, function (response) {
                if (!idSchedule) {

                    $('#' + inserted).attr('data-id', response);

                    var html = $('#' + inserted).parent().html();

                    var obj = {};
                    obj[month + '-' + day + '-' + cal.getYear()] = html;

                    cal.setData(obj);
                    $('.schedule').parent().parent().addClass("available");

                }
            });

            return false;

        })

        .on('click', '.remover-agenda', function (evt) {
            var $schedule = $('.editing .schedule');

            var day = pad($schedule.parent().parent().find('.fc-date').text(), 2, '0', STR_PAD_LEFT);
            var month = pad(cal.getMonth(), 2, '0', STR_PAD_LEFT);

            var d = new Date();
            var currMonth = pad(d.getMonth() + 1, 2, '0', STR_PAD_LEFT);
            var currDay = pad(d.getDate(), 2, '0', STR_PAD_LEFT);
            var currentDate = d.getFullYear() + "-" + currMonth + "-" + currDay;
            var scheduleDate = cal.getYear() + '-' + month + '-' + day;

            if (currentDate >= scheduleDate) {
                swal({
                    title: "Não Permitido!",
                    text: "Não é possível remover agendamentos do dia atual ou de datas anteriores.",
                    type: "error",
                    confirmButtonText: "OK"
                });
                Tipped.hide('.fc-row > div:not(:empty)');
                return false;
            }

            $.get('/backoffice/chef/agenda/deletar/' + idChef + "/" + $schedule.data('id'));

            var obj = {};
            obj[month + '-' + day + '-' + cal.getYear()] = '';

            cal.setData(obj);
            $('.schedule').parent().parent().addClass("available");

            $schedule.remove();
            Tipped.hide('.fc-row > div:not(:empty)');

        });

    }

});