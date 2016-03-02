new Vue({
    el: "#menus",
    data: {
        registros: [],
        filtro_nome: '',
        filtro_aprovado: '',
        filtro_status: '',
        ordem_campo: 'id_menu',
        ordem_dir: 1
    },
    ready: function() {
        this.$http.get('/backoffice/menu/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});