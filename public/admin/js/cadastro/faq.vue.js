new Vue({
    el: "#faq",
    data: {
        registros: [],
        filtro: ''
    },
    ready: function() {
        this.$http.get('/backoffice/cadastro/faq/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});