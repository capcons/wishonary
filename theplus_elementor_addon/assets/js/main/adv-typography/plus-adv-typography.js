(function ($) {
	"use strict";
	var WidgetAdvancedTypographyHandler = function($scope, $) {
		var advance_typography = $scope.find('.pt-plus-adv-typo-wrapper');
		var typo_circular = advance_typography.find('.typo_circular ');
		var typo_blend_mode = advance_typography.find('.typo_bg_based_text ');
		 if(typo_circular.length > 0 ){
			$(typo_circular).each(function(){
				var $this = $(this); 
				var ids= $this.attr('id');
				var custom_radius = $this.data('custom-radius');
				var custom_reversed = $this.data('custom-reversed');
				var custom_resize = $this.data('custom-resize');
					if(custom_reversed == 'yes'){
						var circular_option = new CircleType(document.getElementById(ids)).dir(-1).radius(custom_radius);
					}else {
					var circular_option = new CircleType(document.getElementById(ids)).radius(custom_radius);
					}
				if(custom_resize == 'yes'){
					$( window ).resize(function() {
						 circular_option.radius(circular_option.element.offsetWidth / 2);
					});
				}
			});
		}
		if(typo_blend_mode.length > 0){
			var mode=$(typo_blend_mode).data("blend-mode");
			var fixed_mode=$(typo_blend_mode).closest(".elementor-fixed");
			var absolute_mode=$(typo_blend_mode).closest(".elementor-absolute");
			if(fixed_mode.length > 0){
				$(typo_blend_mode).closest(".elementor-fixed").css("mix-blend-mode",mode);
			}
			if(absolute_mode.length > 0){
				$(typo_blend_mode).closest(".elementor-absolute").css("mix-blend-mode",mode);
			}
		}
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-advanced-typography.default', WidgetAdvancedTypographyHandler);
	});
})(jQuery);