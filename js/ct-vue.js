new Vue({
    el: '#app',
    data: {
        message: 'Loading...',
        themes: []
    },
    methods:{
        activateTheme(e){
            e.preventDefault();
            const slug = e.target.attributes['data-slug'].value;
            CusminThemes.activate(slug, function(data){
                window.location.reload();
            });
        },
        deactivateTheme(e){
            e.preventDefault();
            const slug = e.target.attributes['data-slug'].value;
            CusminThemes.deactivate(slug, function(data){
                window.location.reload();
            });
        },
        installTheme(e){
            const slug = e.target.attributes['data-slug'].value;
            CusminThemes.install(slug, function(data){
                window.location.reload();
            });
        }
    },
    created(){
        CusminThemes.load(function (data) {
            this.message = '';
            this.themes = data;
        }.bind(this));
    }
});