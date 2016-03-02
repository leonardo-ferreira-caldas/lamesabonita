$(document).ready(function ($) {

    $("body").delegate("a.btn-delete", "click", function (e) {
        var href = $(this).attr("href");

        swal({
            title: 'Você tem certeza?',
            text: 'Essa ação não pode ser desfeita!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, quero deletar!',
            closeOnConfirm: false
        }, function () {
            location.href = href;
        });

        e.preventDefault();
        e.stopPropagation();
        return false;
    });

});