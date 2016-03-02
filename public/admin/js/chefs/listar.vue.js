new Vue({
    el: "#chefs",
    data: {
        registros: [],
        filtro_nome: '',
        filtro_status: ''
    },
    ready: function() {
        this.$http.get('/backoffice/chef/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});