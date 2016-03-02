new Vue({
    el: "#cursos",
    data: {
        registros: [],
        filtro_nome: '',
        filtro_aprovado: '',
        filtro_status: '',
        ordem_campo: 'id_curso',
        ordem_dir: 1
    },
    ready: function() {
        this.$http.get('/backoffice/curso/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});