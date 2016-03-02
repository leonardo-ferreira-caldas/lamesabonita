new Vue({
    el: "#incluso_preco",
    data: {
        registros: [],
        filtro: ''
    },
    ready: function() {
        this.$http.get('/backoffice/cadastro/incluso_preco/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});