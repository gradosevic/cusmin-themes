new Vue({
    el: '#app',
    data: {
        message: 'Loading...',
        themes: []
    },
    created(){
        CusminThemes.load(function (data) {
            this.message = '';
            this.themes = data;
        }.bind(this));
    }
});