new Vue({
    el: "#emails",
    data: {
        registros: [],
        page: 1,
        show: 8,
        filtro_de: '',
        filtro_para: '',
        filtro_assunto: '',
        filtro_enviado: ''
    },
    filters: {
        data: function(value) {
            if (value == null || value == '' || value == undefined || value.toString().length == 0) return;

            var split = value.toString().split(" ");
            return split[0].split('-').reverse().join('/') + " " + split[1];
        }
    },
    computed: {
        pageOffset: function() {
            return (this.page * this.show) - this.show;
        },
        pages: function() {
            return Math.ceil(this.registros.length / this.show);
        }
    },
    ready: function() {
        this.$http.get('/backoffice/email/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});