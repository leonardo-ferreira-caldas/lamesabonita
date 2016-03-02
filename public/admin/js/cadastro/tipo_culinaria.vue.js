new Vue({
    el: "#tipo_culinaria",
    data: {
        registros: [],
        page: 1,
        show: 8,
        filtro: ''
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
        this.$http.get('/backoffice/cadastro/tipo_culinaria/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});