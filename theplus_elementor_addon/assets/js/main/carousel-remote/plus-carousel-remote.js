(function($) {
	"use strict";
	var WidgetCarouselRemoteHandler = function ($scope, $) {		
		
		var $target = $('.theplus-carousel-remote', $scope);
		if($target.length){
			$(".theplus-carousel-remote .custom-nav-remote").on("click", function(e){
				e.preventDefault();
				
				var remote_uid=$(this).data("id");
				var remote_type = $(this).closest(".theplus-carousel-remote").data("remote");
				
				if(remote_uid!='' && remote_uid!=undefined && remote_type=='carousel'){	
				
					var carousel_slide=$(this).data("nav");
					
					if(carousel_slide=='next'){
						$('.'+remote_uid+' > .post-inner-loop').slick("slickNext");
					} else if(carousel_slide=='prev'){
						$('.'+remote_uid+' > .post-inner-loop').slick("slickPrev");
					}
					
				}else if(remote_uid!='' && remote_uid!=undefined && remote_type=='switcher'){
					
					var switcher_toggle=$(this).data("nav");
					
					var switch_toggle = $('#'+remote_uid).find('.switch-toggle');
					var switch_1_toggle = $('#'+remote_uid).find('.switch-1');
					var switch_2_toggle = $('#'+remote_uid).find('.switch-2');
					
					$(".theplus-carousel-remote .custom-nav-remote").removeClass("active");
					$(this).addClass("active");
					
					if(switcher_toggle=='next'){
						switch_2_toggle.trigger("click");							
					} else if(switcher_toggle=='prev'){	
						switch_1_toggle.trigger("click");
					}
				}
			});
		}
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-carousel-remote.default', WidgetCarouselRemoteHandler);
	});
})(jQuery);