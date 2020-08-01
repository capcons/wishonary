(function($) {
    "use strict";

    $( function() {
      $( "#htpmpro_accordion" ).accordion({
      	active: false ,
      	collapsible: true,
      	heightStyle: 'content'
      });
    } );

    // Reapeter Field Increase
    $( '.htpmpro-add-row' ).on('click', function() {
        var row = $(this).parent().closest('tr').clone(true);
        row.removeClass( 'htpmpro-empty-row screen-reader-text' );
        $(this).parent().closest('tr').after(row);
        return false;
    });

    // Reapeter Field Decrease
    $( '.htpmpro-remove-row' ).on('click', function() {
        $(this).parent().parent().remove();
        return false;
    });


    $('.htpmpro_single_accordion .htpmpro_uri_type').on('change', function(){
    	var select_val = $(this).val();

    	if(select_val == 'page'){
    		$(this).parent().parent().attr('data-htpmpro_uri_type', 'page');
    	} else if(select_val == 'post'){
    		$(this).parent().parent().attr('data-htpmpro_uri_type', 'post');
    	} else if(select_val == 'page_post'){
    		$(this).parent().parent().attr('data-htpmpro_uri_type', 'page_post');
    	} else if(select_val == 'custom'){
    		$(this).parent().parent().attr('data-htpmpro_uri_type', 'custom');
    	}
    });

    // select2 activation
    $(document).ready(function() {
        $('.htpmpro_select2_active').select2();
    });
})(jQuery);