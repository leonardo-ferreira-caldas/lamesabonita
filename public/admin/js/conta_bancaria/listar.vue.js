new Vue({
    el: "#conta_bancaria",
    data: {
        registros: [],
        filtro_banco: '',
        filtro_chef: ''
    },
    ready: function() {
        this.$http.get('/backoffice/conta_bancaria/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});