$(document).ready(function() {
    $("#preco, .menu_price_rule_field input").maskMoney({thousands:'', decimal:'.'});

    Tipped.delegate('.tpp', {
        skin: 'light',
        size: 'large'
    });

    $('.remove-picture-menu').click(function(e) {
        if ($(this).parent().hasClass('cover-picture') && $(".uploaded-picture-menu").size() > 1) {
            e.preventDefault();
            Utils.alert.info("Informação", "Esta foto está definida como capa. Para remove-la é necessário definir outra foto como capa.")
        }
    });

    $('.define-as-cover').click(function(e) {
        if ($(this).parent().hasClass('cover-picture')) {
            e.preventDefault();
            Utils.alert.info("Informação", "Esta foto já está definida como capa.");
        }
    });

    $("#salvar_curso").submit(function(evt) {
        var empty = true;
        var size = false;

        $(".menu-form-pictures").find('input:file').each(function(elem, idx) {
            if ($(this).val().toString().length >= 5) {
                empty = false;
                return false;
            }
        });

        $(".menu-form-pictures").find('input:file').each(function(elem, idx) {
            if ($(this).val().toString().length >= 5 && typeof FileReader !== "undefined") {
                var tamanho = Math.round($(this)[0].files[0].size / 1000);
                if (tamanho >= 10240) {
                    size = true;
                    return false;
                }
            }
        });

        if (size) {
            Utils.alert.error("Validação", "O tamanho das imagens não deve ultrapassar 10 MB's.");
            $('.menu-picture-selected').find('input:file').each(function(elem, idx) {
                $(this).val('');
                $(this).parent().html($(this).parent().html());
            });
            $('.menu-picture-selected').find('input:file').change(selectMenuCursoPicture);
            $('.menu-picture-selected').removeClass('menu-picture-selected');
            evt.preventDefault();
            return false;
        }

        if ($(".checkbox_tipo_refeicao input:checked").size() == 0) {
            Utils.alert.error("Validação", "Selecione pelo menos um tipo de refeição para o seu curso.");
            return false;
        }

        if ($(".checkbox_tipo_culinaria input:checked").size() == 0) {
            Utils.alert.error("Validação", "Selecione pelo menos um tipo de culinária para o seu curso.");
            return false;
        }

        //if (empty && $(".uploaded-picture-menu").size() == 0) {
        //    Utils.alert.error("Validação", "Selecione pelo menos uma foto para o curso.");
        //    evt.preventDefault();
        //    return false;
        //}
    });
});