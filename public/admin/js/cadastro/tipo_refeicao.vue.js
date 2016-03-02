new Vue({
    el: "#tipo_refeicao",
    data: {
        registros: [],
        filtro: ''
    },
    ready: function() {
        this.$http.get('/backoffice/cadastro/tipo_refeicao/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});