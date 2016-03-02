var Utils = {

    alert: {

        error: function(title, text) {
            text = text.split("\\n").join("<br>");

            swal({
                title: title,
                text: text,
                type: "error",
                html: true,
                confirmButtonText: "OK"
            });

            $('.sweet-alert').css({
                'margin-left': '-256px',
                'width' : '480px'
            });
        },

        success: function(title, text, fallback) {
            text = text.split("\\n").join("<br>");

            swal({
                title: title,
                text: text,
                type: "success",
                html: true,
                confirmButtonText: "OK"
            }, function() {
                if (typeof fallback == "function") {
                    fallback();
                }
            });

            $('.sweet-alert').css({
                'margin-left': '-256px',
                'width' : '480px'
            });
        },

        info: function(title, text) {
            text = text.split("\\n").join("<br>");

            swal({
                title: title,
                text: text,
                html: true,
                type: "info",
                confirmButtonText: "OK"
            });

            $('.sweet-alert').css({
                'margin-left': '-256px',
                'width' : '480px'
            });
        },

        redirect: function(message, redirectText, redirectRoute) {
            message = message.split("\\n").join("<br>");

            swal({
                title: 'Sucesso!',
                text: message,
                type: 'success',
                width: 780,
                html: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: redirectText,
                cancelButtonText: 'Permanecer na página atual',
                confirmButtonClass: 'confirm-class',
                cancelButtonClass: 'cancel-class',
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    location.href = redirectRoute;
                }
            });

            $('.sweet-alert').css({
                'margin-left': '-375px',
                'width' : '780px'
            });

        }

    },

    serializeObject: function($elem) {
        var obj = {};

        var fields = $elem.find("input, textarea, select").serializeArray();

        jQuery.each(fields, function(i, field ) {
            obj[field.name] = field.value;
        });

        return obj;
    }

};