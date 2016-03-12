new Vue({
    el: "#menu-formulario",
    data: {
        fotos: []
    },
    methods: {
        adicionar: function() {
            this.fotos.push(this.fotos.length);
        },
        remover: function(foto) {
            this.fotos.splice(foto, 1);
        }
    }
});