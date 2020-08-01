( function( $ ) {
	"use strict";
	var WidgetDynamicListingHandler = function ($scope, $) {
		var container = $scope.find('.dynamic-listing');
		if(container.hasClass('.dynamic-listing.dynamic-listing-style-1')){
			$('.dynamic-listing.dynamic-listing-style-1 .grid-item .blog-list-content').on('mouseenter',function() {
				$(this).find(".post-hover-content").slideDown(300)				
			});
			$('.dynamic-listing.dynamic-listing-style-1 .grid-item .blog-list-content').on('mouseleave',function() {
				$(this).find(".post-hover-content").slideUp(300)				
			});
		}
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-dynamic-listing.default', WidgetDynamicListingHandler);
	});
})(jQuery);