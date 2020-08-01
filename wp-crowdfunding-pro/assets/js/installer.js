jQuery(document).ready(function($){
    'use strict';
    $(document).on('click', '.install-crowdfunding-button', function(e){
        e.preventDefault();
        var $btn = $(this);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {install_plugin: 'wp-crowdfunding', action: 'install_crowdfunding_plugin'},
            beforeSend: function(){
                $btn.addClass('updating-message');
            },
            success: function (data) {
                $('.install-crowdfunding-button').remove();
                $('#crowdfunding_install_msg').html(data);
            },
            complete: function () {
                $btn.removeClass('updating-message');
            }
        });
    });
});
