jQuery(function($){
    "use strict";

        // Canvas
        $('.site-navigation-btn').click(function(){
            $('body').toggleClass('push-left');
            return false;
        });

        // MENU ITEMS
        $('.menu-item').click(function(){
            $('body').toggleClass('push-left');
        });

        $(document).click(function(e) {
            if (e.target.id != 'canvas' && !$('#canvas').find(e.target).length) {
                $('body').removeClass('push-left');
            }
        });

});