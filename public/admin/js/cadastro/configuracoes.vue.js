new Vue({
    el: "#configuracao",
    data: {
        registros: [],
        filtro: ''
    },
    ready: function() {
        this.$http.get('/backoffice/configuracao/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});