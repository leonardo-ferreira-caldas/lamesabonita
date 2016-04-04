new Vue({
    el: "#reserva",
    data: {
        registros: [],
        filtro_cliente: '',
        filtro_chef: '',
        filtro_status_reserva: '',
        filtro_status_pagamento: ''
    },
    ready: function() {
        this.$http.get('/backoffice/reservas/buscar').then(function(response) {
            this.registros = response.data;
        });
    }
});