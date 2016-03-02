new Vue({
    el: "#menu-vue",
    data: {
        open: ''
    },
    methods: {
        toggle: function(menu) {
            if (this.open == menu) {
                return this.open = '';
            }
            this.open = menu;
        }
    }
});