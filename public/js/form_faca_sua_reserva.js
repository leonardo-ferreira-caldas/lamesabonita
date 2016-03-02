$(document).ready(function () {

    $('a.gallery').colorbox({rel: 'gal'});
    $("#data_reserva").mask("99/99/9999");
    $("#data_reserva").datepicker({
        language: "pt-BR",
        selectOtherMonths: false,
        showOtherMonths: false,
        format: 'dd/mm/yyyy',
        autoclose: true,
        beforeShowMonth: function (year, month, dateObj) {
            $(".old.dia-habilitado, .new.dia-habilitado").removeClass('dia-habilitado').addClass("disabled");
        },
        beforeShowDay: function (date) {
            var month = date.getMonth() + 1;
            month = month < 10 ? "0" + month : month;
            var day = date.getDate();
            day = day < 10 ? "0" + day : day;
            dmy = date.getFullYear() + "-" + month + "-" + day;

            var habilitado = $.inArray(dmy, diasDisponiveis) !== -1;

            return {
                enabled: habilitado,
                classes: habilitado ? "dia-habilitado" : "",
                tooltip: ""
            };
        }
    });

    var control = false;

    $("#data_reserva").change(function () {
        if ($(this).val().toString().length == 0) {
            return;
        }

        if (control) {
            return;
        }

        control = true;
        $("#horario_reserva").html('<option value="" selected>Carregando horários...</option>');

        $.ajax({
            url: route_buscar_horario,
            method: 'GET',
            data: {'data': $(this).val()},
            success: function (response) {
                control = false;
                var $hora = $("#horario_reserva");
                $hora.empty();

                if (response.length == 0) {
                    Utils.alert.info("Informação", "O chef não está disponível na data informada.");
                    $hora.html('<option value="" selected>Escolha o horário desejado...</option>');
                    $hora.prop('disabled', true);
                    $("#data_reserva").val('');
                    return;
                }

                for (var i = 0; i < response.length; i++) {
                    $hora.append('<option value="' + response[i] + '">' + response[i] + '</option>');
                }

                $hora.prop('disabled', false);

            },
            dataType: 'json'
        });
    });
});