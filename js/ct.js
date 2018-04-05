var CusminThemes = {
    load: function (callback) {
        this.callSvc('cusmin_themes_load', null, callback);
    },
    install: function (themeSlug, callback) {
        this.callSvc('cusmin_themes_install', {theme: themeSlug}, callback);
    },
    activate: function (themeSlug, callback) {
        this.callSvc('cusmin_themes_activate', {theme: themeSlug}, callback);
    },
    deactivate: function (themeSlug, callback) {
        this.callSvc('cusmin_themes_deactivate', {theme: themeSlug}, callback);
    },
    callSvc: function (action, data, callback) {
        jQuery.post(ajaxurl, {
            'action': action,
             data:data
        }, function (response) {
            if(response){
                callback(JSON.parse(response));
            }else{
                callback();
            }
        });
    }
};
jQuery(document).ready(function ($) {
    //CusminThemes.load();
});