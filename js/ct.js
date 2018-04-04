var CusminThemes = {
    load:function(callback){
        this.callSvc('cusmin_themes_load', null, callback);
    },
    callSvc: function (action, data, callback) {
        jQuery.post(ajaxurl, {
            'action': action
        }, function(response) {
            callback(JSON.parse(response));
        });
    }
};
jQuery(document).ready(function($) {
    //CusminThemes.load();
});