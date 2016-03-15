new Vue({
    el: "#menu-formulario",
    data: {
        fotos: [],
        precos: []
    },
    methods: {
        adicionar: function() {
            this.fotos.push(this.fotos.length);
        },
        adicionar_preco: function() {
            this.precos.push(this.precos.length);
        },
        remover: function(foto) {
            this.fotos.splice(foto, 1);
        },
        remover_preco: function(preco) {
            this.precos.splice(preco, 1);
        }
    }
});