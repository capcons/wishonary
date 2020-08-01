/*Switcher*/( function( $ ) {
	"use strict";
	var WidgetSwitcherHandler = function ($scope, $) {
		if($scope.find('.theplus-switcher').length>0){
			var target = $scope.find('.theplus-switcher');
			var ids = target.data("id");
			var switch_toggle = target.find('.switch-toggle');
			var switch_1_toggle = target.find('.switch-1');
			var switch_2_toggle = target.find('.switch-2');
				
			var i,n,f,r;
			$(switch_toggle).unbind().on('click',function(e) {
				i = $(this).closest(".theplus-switcher").find(".switcher-section-1");
				n = $(this).closest(".theplus-switcher").find(".switcher-section-2");
				f = $(this).closest(".theplus-switcher").find(".switcher-toggle");
				i.toggle();
				n.toggle();
				if(f.hasClass("active")){ (f.removeClass("active").addClass("inactive"));}else{ (f.removeClass("inactive").addClass("active"));}
				if($("#"+ids+" .list-isotope-metro .post-inner-loop").length || $("#"+ids+" .list-isotope .post-inner-loop").length){		
					setTimeout(function(){ $("#"+ids+" .list-isotope-metro .post-inner-loop,#"+ids+" .list-isotope .post-inner-loop").isotope('layout'); }, 10);
				}
			});
			$(switch_1_toggle).unbind().on("click", function(e) {
				i = $(this).parents(".theplus-switcher").find(".switcher-section-1");
				n = $(this).parents(".theplus-switcher").find(".switcher-section-2");
				f = $(this).parents(".theplus-switcher").find(".switcher-toggle");
				r = $(this).parents(".theplus-switcher").find(".switch-toggle");
				r.prop("checked", !1),
				i.show(),
				n.hide(),
				f.hasClass("active") ? (f.removeClass("active").addClass("inactive")) : (f.removeClass("inactive").addClass("active"))
				if($("#"+ids+" .list-isotope-metro .post-inner-loop").length || $("#"+ids+" .list-isotope .post-inner-loop").length){		
					setTimeout(function(){ $("#"+ids+" .list-isotope-metro .post-inner-loop,#"+ids+" .list-isotope .post-inner-loop").isotope('layout'); }, 10);
				}
			});
			$(switch_2_toggle).unbind().on("click", function(e) {
				i = $(this).parents(".theplus-switcher").find(".switcher-section-1");
				n = $(this).parents(".theplus-switcher").find(".switcher-section-2");
				f = $(this).parents(".theplus-switcher").find(".switcher-toggle");
				r = $(this).parents(".theplus-switcher").find(".switch-toggle");
				r.prop("checked", !0),
				i.hide(),
				n.show(),
				f.hasClass("active") ? (f.removeClass("active").addClass("inactive")) : (f.removeClass("inactive").addClass("active"))
				if($("#"+ids+" .list-isotope-metro .post-inner-loop").length || $("#"+ids+" .list-isotope .post-inner-loop").length){		
					setTimeout(function(){ $("#"+ids+" .list-isotope-metro .post-inner-loop,#"+ids+" .list-isotope .post-inner-loop").isotope('layout'); }, 10);
				}
			});
				
		}
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-switcher.default', WidgetSwitcherHandler);
	});
})(jQuery);