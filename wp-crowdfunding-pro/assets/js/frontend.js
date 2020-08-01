jQuery(document).ready(function($){
    'use strict';
    $(document).on('click', '.wpcf-stripe-connect-deauth', function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url: wpcf_ajax_object.ajax_url,
            data: { action: 'wpcf_stripe_disconnect' },
            success:function(data) {
                if (wpcf_modal(data)){  }
            },
            error: function() {
                wpcf_modal({'success':0, 'message':'Error sending data'})
            }
        });
    });
});
