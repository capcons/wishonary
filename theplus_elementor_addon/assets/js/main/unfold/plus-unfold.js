/*unfold*/
(function ($) {
	"use strict";
	var WidgetUnfoldHandler = function($scope, $) {
		var container = $scope.find('.tp-unfold-wrapper'),
		data_id = container.data("id"),
		data_icon_position = container.data("icon-position"),
		data_readmore = container.data("readmore"),
		data_readless = container.data("readless"),
		data_readmore_icon = container.data("readmore-icon"),
		data_readless_icon = container.data("readless-icon"),
		data_content_max_height = container.data("content-max-height"),
		data_content_max_height_m = container.data("content-max-height-m"),
		data_content_max_height_t = container.data("content-max-height-t"),
		data_transition_duration = container.data("transition-duration"),
		toggle1 = container.find(".tp-unfold-toggle");
		
		
		if(container.length){
			
			var get_height_of_div = container.find(".tp-unfold-description .tp-unfold-description-inner").outerHeight();
				if(get_height_of_div <= data_content_max_height ){
					container.find(".tp-unfold-last-toggle").css("display", "none");
					container.find(".tp-unfold-description").append("<style>.tp-unfold-wrapper."+ data_id + " .tp-unfold-description:after{min-height:0 !important;}</style>");
				}else{
					container.find(".tp-unfold-last-toggle").css("display", "flex");
				}
			
			toggle1.on('click',function(){
			  
				$(this).closest('.tp-unfold-wrapper').toggleClass("fullview");	
				if($(this).closest('.tp-unfold-wrapper').hasClass("fullview")){
					var outerhight = parseInt($(this).closest('.tp-unfold-wrapper').find(".tp-unfold-description-inner").outerHeight());
					
					if(data_icon_position=='tp_ic_pos_before' && data_icon_position !=undefined){
						$(this).closest('.tp-unfold-wrapper').find(".tp-unfold-toggle").html(data_readless_icon + data_readless);
					}else if(data_icon_position=='tp_ic_pos_after' && data_icon_position !=undefined){
						$(this).closest('.tp-unfold-wrapper').find(".tp-unfold-toggle").html(data_readless + data_readless_icon);
					}
					
					$(this).closest('.tp-unfold-wrapper').find(".tp-unfold-description").animate({height:outerhight},data_transition_duration);
				}else{
					
					if(data_icon_position=='tp_ic_pos_before' && data_icon_position !=undefined){						
						$(this).closest('.tp-unfold-wrapper').find(".tp-unfold-toggle").html(data_readmore_icon + data_readmore);
					}else if(data_icon_position=='tp_ic_pos_after' && data_icon_position !=undefined){
						$(this).closest('.tp-unfold-wrapper').find(".tp-unfold-toggle").html(data_readmore + data_readmore_icon);
					}
					
					
					var inw = $(window).innerWidth();
					if(inw >= 1025){
						$(this).closest('.tp-unfold-wrapper').find(".tp-unfold-description").animate({height:data_content_max_height},data_transition_duration);
					}else if(inw <= 1024 && inw >= 768){
						$(this).closest('.tp-unfold-wrapper').find(".tp-unfold-description").animate({height:data_content_max_height_t},data_transition_duration);						
					}else if(inw <= 767 ){
						$(this).closest('.tp-unfold-wrapper').find(".tp-unfold-description").animate({height:data_content_max_height_m},data_transition_duration);				
					}
				}
				if(container.closest(".post-inner-loop").length){	
					setTimeout(function(){
						container.closest(".post-inner-loop").isotope('layout');						
					}, data_transition_duration - 20);
				}
				
			});
		}		
	};	
	
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-unfold.default', WidgetUnfoldHandler);
	});
})(jQuery);