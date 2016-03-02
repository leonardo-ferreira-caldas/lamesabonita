$.fn.formLoading = function(options) {
    var defaults = {
        btn: 'button[type=submit]',
        loader: '.processing-form',
        beforeSubmit: null
    };

    options = $.extend({}, defaults, options);

    var $btn = this.find(options.btn);
    var $loader = this.find(options.loader);

    $loader.hide();

    this.submit(function() {

        $btn.addClass("btn-disabled");
        $loader.show();

    });

};

$.fn.ajaxForm = function(options) {
    var defaults = {
        btn: 'button[type=submit]',
        loader: '.processing-form',
        beforeSubmit: null,
        afterSuccess: null
    };

    options = $.extend({}, defaults, options);

    var $btn = this.find(options.btn);
    var $loader = this.find(options.loader);
    var hasBeforeSubmit = typeof options.beforeSubmit == "function";
    var hasAfterSuccess = typeof options.afterSuccess == "function";
    var action = this.attr("action");
    var method = this.attr("method");

    $loader.hide();

    var running;

    this.submit(function() {
        if (running) {
            return false;
        }

        if (hasBeforeSubmit && options.beforeSubmit() !== true) {
            return false;
        }

        $btn.addClass("btn-disabled");
        $loader.show();

        var data = $(this).serialize();

        running = true;

        $.ajax({
            url: action,
            method: method,
            dataType: 'json',
            data: data,
            success: function(response) {

                running = false;

                if (response.type == "error") {
                    Utils.alert.error("Erro!", response.message);
                } else if (response.type == "info") {
                    Utils.alert.info("Erro!", response.message);
                } else if (response.type == "warn") {
                    Utils.alert.error("Atenção!", response.message);
                } else if (response.type == "success") {
                    if (typeof response.redirect != "undefined") {
                        Utils.alert.redirect(response.message, response.redirect.text, response.redirect.route);

                    } else {
                        Utils.alert.success("Sucesso!", response.message);
                    }

                }

                if (hasAfterSuccess) {
                    options.afterSuccess()
                }

                $btn.removeClass("btn-disabled");
                $loader.hide();

            },
            error: function(responseObj, b) {
                $btn.removeClass("btn-disabled");
                $loader.hide();
                running = false;

                if (responseObj.status == 422) {
                    var alertMessage = [];

                    for (var i in responseObj.responseJSON) {
                        for (var c = 0; c < responseObj.responseJSON[i].length; c++) {
                            alertMessage.push(responseObj.responseJSON[i][c]);
                        }
                    }

                    Utils.alert.error("Erro!", alertMessage.join("\n\n"));

                    return;
                }

                Utils.alert.error("Erro!", "Um erro inesperado ocorreu. Tente novamente ou entre em contato com a equipe La Mesa Bonita.");
            }
        });

        return false;

    });

};