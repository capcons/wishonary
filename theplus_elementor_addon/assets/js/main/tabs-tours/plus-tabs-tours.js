/*tabs & tours*/(function($) {
	"use strict";
	var WidgetTabHandler = function ($scope, $) {
		var $currentTab = $scope.find('.theplus-tabs-wrapper'),
		$TabHover = $currentTab.data('tab-hover'),
		$currentTabId = '#' + $currentTab.attr('id').toString();
		
		$($currentTabId + ' ul.plus-tabs-nav li .plus-tab-header').each( function(index) {
			var default_active=$(this).closest('.theplus-tabs-wrapper').data("tab-default");
			if( default_active == index ) {
			
				$(this).removeClass('inactive').addClass('active');

				var Connection=$(this).closest(".theplus-tabs-wrapper").data('connection');
				if(Connection!='' && Connection!=undefined && $("."+Connection).length){
					setTimeout(function(){
						plus_tabs_connection(parseInt(default_active+1),Connection);
					}, 150);
				}
				var row_bg_conn=$(this).closest(".theplus-tabs-wrapper").data('row-bg-conn');
				if(row_bg_conn!='' && row_bg_conn!=undefined && $("#"+row_bg_conn).length ){
					background_accordion_tabs_conn(default_active+1,row_bg_conn);
				}
			}
			
		});

		$($currentTabId + ' .theplus-tabs-content-wrapper .plus-tab-content').each( function(index) {
			var default_active=$(this).closest('.theplus-tabs-wrapper').data("tab-default");
			if( default_active == index ) {
				$(this).removeClass('inactive').addClass('active');
				if($($currentTabId+' .list-isotope-metro .post-inner-loop').length || $($currentTabId+' .list-isotope .post-inner-loop').length){
					setTimeout(function(){
						$($currentTabId+' .list-isotope-metro .post-inner-loop',$currentTabId+' .list-isotope .post-inner-loop').isotope('layout');
					}, 10);
				}
			}
		});
		
		if('no' == $TabHover){
			$($currentTabId + ' ul.plus-tabs-nav li .plus-tab-header').on('click',function(){
				var currentTabIndex = $(this).data("tab");
				var tabsContainer = $(this).closest('.theplus-tabs-wrapper');
				var tabsNav = $(tabsContainer).children('ul.plus-tabs-nav').children('li').children('.plus-tab-header');
				var tabsContent = $(tabsContainer).children('.theplus-tabs-content-wrapper').children('.plus-tab-content');
				
				$(tabsContainer).find(">.theplus-tabs-nav-wrapper .plus-tab-header").removeClass('active default-active').addClass('inactive');
				$(this).addClass('active').removeClass('inactive');
				
				$(tabsContainer).find(">.theplus-tabs-content-wrapper>.plus-tab-content").removeClass('active').addClass('inactive');
				$(">.theplus-tabs-content-wrapper>.plus-tab-content[data-tab='"+currentTabIndex+"']",tabsContainer).addClass('active').removeClass('inactive');
			
				$(tabsContent).each( function(index) {
					$(this).removeClass('default-active');
				});
				if($(">.theplus-tabs-content-wrapper>.plus-tab-content[data-tab='"+currentTabIndex+"'] .pt_plus_before_after",tabsContainer).length){
					size_Elements()
				}
				var Connection=$(this).closest(".theplus-tabs-wrapper").data('connection');
				if(Connection!='' && Connection!=undefined && $("."+Connection).length){
						var tab_index=$(this).data("tab");
						plus_tabs_connection(tab_index,Connection);
				}
				var row_bg_conn=$(this).closest(".theplus-tabs-wrapper").data('row-bg-conn');
				if(row_bg_conn!='' && row_bg_conn!=undefined && $("#"+row_bg_conn).length ){
					var tab_index=$(this).data("tab");
					background_accordion_tabs_conn(tab_index,row_bg_conn);
				}
				if($($currentTabId+" .list-carousel-slick > .post-inner-loop").length){
					$($currentTabId+" .list-carousel-slick > .post-inner-loop").slick('setPosition');	
				}
				if($($currentTabId+" .elementor-background-video-embed").length){
					setTimeout(function(){
					var e = $('.theplus-tabs-content-wrapper',tabsContainer).find("[data-tab='"+currentTabIndex+"'] .elementor-background-video-embed").closest(".elementor-background-video-container").outerWidth()
					  , t = $('.theplus-tabs-content-wrapper',tabsContainer).find("[data-tab='"+currentTabIndex+"'] .elementor-background-video-embed").closest(".elementor-background-video-container").outerHeight()
					  , n = "16:9".split(":")
					  , i = n[0] / n[1]
					  , o = e / t > i;
						var w= o ? e : t * i,
						h= o ? e / i : t;
						if(h==100){
							w="100%";h="100%";
						}
						$($currentTabId+" .elementor-background-video-embed").width(w).height(h);
					}, 50);
				}
				if($($currentTabId+" iframe.pt-plus-bg-video").length){
					setTimeout(function(){
					var e = $($currentTabId+" iframe.pt-plus-bg-video").closest(".columns-video-bg").outerWidth()
					  , t = $($currentTabId+" iframe.pt-plus-bg-video").closest(".columns-video-bg").outerHeight()
					  , n = "16:9".split(":")
					  , i = n[0] / n[1]
					  , o = e / t > i;
						var w= o ? e : t * i,
						h= o ? e / i : t;
						$($currentTabId+" iframe.pt-plus-bg-video").width(w).height(h);
					}, 100);
				}
				if($($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro .post-inner-loop").length){
					
					var container=$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro");
					var uid=container.data("id");
					var columns=container.attr('data-metro-columns');
					var metro_style=container.attr('data-metro-style');
					theplus_backend_packery_portfolio(uid,columns,metro_style);
					
					$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro .post-inner-loop").isotope('layout');
				}
				if($($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope .post-inner-loop").length){
					setTimeout(function(){						
						$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope .post-inner-loop").isotope('layout');
					}, 30);
				}
			});
		}
		if('yes' == $TabHover){
			$($currentTabId + ' ul.plus-tabs-nav li .plus-tab-header').mouseover(function(){
				var currentTabIndex = $(this).data("tab");
				var tabsContainer = $(this).closest('.theplus-tabs-wrapper');
				var tabsNav = $(tabsContainer).children('ul.plus-tabs-nav').children('li').children('.plus-tab-header');
				var tabsContent = $(tabsContainer).children('.theplus-tabs-content-wrapper').children('.plus-tab-content');
			
				$(tabsContainer).find(">.theplus-tabs-nav-wrapper .plus-tab-header").removeClass('active default-active').addClass('inactive');
				$(this).addClass('active').removeClass('inactive');
			
				$(tabsContainer).find(">.theplus-tabs-content-wrapper>.plus-tab-content").removeClass('active').addClass('inactive');
				$(">.theplus-tabs-content-wrapper>.plus-tab-content[data-tab='"+currentTabIndex+"']",tabsContainer).addClass('active').removeClass('inactive');
			
				$(tabsContent).each( function(index) {
					$(this).removeClass('default-active');
				});
				if($(">.theplus-tabs-content-wrapper>.plus-tab-content[data-tab='"+currentTabIndex+"'] .pt_plus_before_after",tabsContainer).length){
					size_Elements()
				}
				var Connection=$(this).closest(".theplus-tabs-wrapper").data('connection');
				if(Connection!='' && Connection!=undefined && $("."+Connection).length){
						var tab_index=$(this).data("tab");
						plus_tabs_connection(tab_index,Connection);
				}
				var row_bg_conn=$(this).closest(".theplus-tabs-wrapper").data('row-bg-conn');
				if(row_bg_conn!='' && row_bg_conn!=undefined && $("#"+row_bg_conn).length ){
					var tab_index=$(this).data("tab");
					background_accordion_tabs_conn(tab_index,row_bg_conn);
				}
				if($($currentTabId+" .list-carousel-slick > .post-inner-loop").length){
					$($currentTabId+" .list-carousel-slick > .post-inner-loop").slick('setPosition');
				}
				if($($currentTabId+" .elementor-background-video-embed").length){
					setTimeout(function(){
					var e = $('.theplus-tabs-content-wrapper',tabsContainer).find("[data-tab='"+currentTabIndex+"'] .elementor-background-video-embed").closest(".elementor-background-video-container").outerWidth()
					  , t = $('.theplus-tabs-content-wrapper',tabsContainer).find("[data-tab='"+currentTabIndex+"'] .elementor-background-video-embed").closest(".elementor-background-video-container").outerHeight()
					  , n = "16:9".split(":")
					  , i = n[0] / n[1]
					  , o = e / t > i;
						var w= o ? e : t * i,
						h= o ? e / i : t;
						if(h==100){
							w="100%";h="100%";
						}
						$($currentTabId+" .elementor-background-video-embed").width(w).height(h);
					}, 50);
				}
				if($($currentTabId+" iframe.pt-plus-bg-video").length){
					setTimeout(function(){
					var e = $($currentTabId+" iframe.pt-plus-bg-video").closest(".columns-video-bg").outerWidth()
					  , t = $($currentTabId+" iframe.pt-plus-bg-video").closest(".columns-video-bg").outerHeight()
					  , n = "16:9".split(":")
					  , i = n[0] / n[1]
					  , o = e / t > i;
						var w= o ? e : t * i,
						h= o ? e / i : t;
						$($currentTabId+" iframe.pt-plus-bg-video").width(w).height(h);
					}, 100);
				}
				if($($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro .post-inner-loop").length){
					
					var container=$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro");
					var uid=container.data("id");
					var columns=container.attr('data-metro-columns');
					var metro_style=container.attr('data-metro-style');
					theplus_backend_packery_portfolio(uid,columns,metro_style);
					
					$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro .post-inner-loop").isotope('layout');
				}
				if($($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope .post-inner-loop").length){
					setTimeout(function(){						
						$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope .post-inner-loop").isotope('layout');
					}, 30);
				}
			});
		}
		
		/*
		 *	Swiper Tabbing
		*/
		if($('.theplus-tabs-wrapper.swiper-container').length > 0){
			new Swiper(".theplus-tabs-wrapper.swiper-container",{
				slidesPerView: "auto",
				mousewheelControl: !0,
				freeMode: !0,
			});
		}
		
		
		if($($currentTabId).hasClass("mobile-accordion")){
			$(window).resize(function(){
				if($(window).innerWidth() <= 600){
					$($currentTabId).addClass("mobile-accordion-tab");
				}
			});
			$($currentTabId + ' .theplus-tabs-content-wrapper .elementor-tab-mobile-title').on('click',function(){
				var currentTabIndex = $(this).data("tab");
				var tabsContainer = $(this).closest('.theplus-tabs-wrapper');
				var tabsNav = $(tabsContainer).children('.theplus-tabs-content-wrapper').children('.elementor-tab-mobile-title');
				var tabsContent = $(tabsContainer).children('.theplus-tabs-content-wrapper').children('.plus-tab-content');
			
				$(tabsContainer).find(">.theplus-tabs-content-wrapper .elementor-tab-mobile-title").removeClass('active default-active').addClass('inactive');
				$(this).addClass('active').removeClass('inactive');
			
				$(tabsContainer).find(">.theplus-tabs-content-wrapper>.plus-tab-content").removeClass('active').addClass('inactive');
				$(">.theplus-tabs-content-wrapper>.plus-tab-content[data-tab='"+currentTabIndex+"']",tabsContainer).addClass('active').removeClass('inactive');
			
				$(tabsContent).each( function(index) {
					$(this).removeClass('default-active');
				});
				var Connection=$(this).closest(".theplus-tabs-wrapper").data('connection');
				if(Connection!='' && Connection!=undefined && $("."+Connection).length){
						var tab_index=$(this).data("tab");
						plus_tabs_connection(tab_index,Connection);
				}
				var row_bg_conn=$(this).closest(".theplus-tabs-wrapper").data('row-bg-conn');
				if(row_bg_conn!='' && row_bg_conn!=undefined && $("#"+row_bg_conn).length ){
					var tab_index=$(this).data("tab");
					background_accordion_tabs_conn(tab_index,row_bg_conn);
				}
				if($($currentTabId+" .list-carousel-slick > .post-inner-loop").length){
					$($currentTabId+" .list-carousel-slick > .post-inner-loop").slick('setPosition');
				}
				if($($currentTabId+" .elementor-background-video-embed").length){
					setTimeout(function(){
					var e = $('.theplus-tabs-content-wrapper',tabsContainer).find("[data-tab='"+currentTabIndex+"'] .elementor-background-video-embed").closest(".elementor-background-video-container").outerWidth()
					  , t = $('.theplus-tabs-content-wrapper',tabsContainer).find("[data-tab='"+currentTabIndex+"'] .elementor-background-video-embed").closest(".elementor-background-video-container").outerHeight()
					  , n = "16:9".split(":")
					  , i = n[0] / n[1]
					  , o = e / t > i;
						var w= o ? e : t * i,
						h= o ? e / i : t;
						if(h==100){
							w="100%";h="100%";
						}
						$($currentTabId+" .elementor-background-video-embed").width(w).height(h);
					}, 50);
				}
				if($($currentTabId+" iframe.pt-plus-bg-video").length){
					setTimeout(function(){
					var e = $($currentTabId+" iframe.pt-plus-bg-video").closest(".columns-video-bg").outerWidth()
					  , t = $($currentTabId+" iframe.pt-plus-bg-video").closest(".columns-video-bg").outerHeight()
					  , n = "16:9".split(":")
					  , i = n[0] / n[1]
					  , o = e / t > i;
						var w= o ? e : t * i,
						h= o ? e / i : t;
						$($currentTabId+" iframe.pt-plus-bg-video").width(w).height(h);
					}, 100);
				}
				if($($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro .post-inner-loop").length){
					
					var container=$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro");
					var uid=container.data("id");
					var columns=container.attr('data-metro-columns');
					var metro_style=container.attr('data-metro-style');
					theplus_backend_packery_portfolio(uid,columns,metro_style);
					
					$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope-metro .post-inner-loop").isotope('layout');
				}
				if($($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope .post-inner-loop").length){
					setTimeout(function(){						
						$($currentTabId+" .plus-tab-content[data-tab='"+currentTabIndex+"'] .list-isotope .post-inner-loop").isotope('layout');
					}, 30);
				}
			});
		}
		
		var hash = window.location.hash;
		if(hash!='' && hash!=undefined && !$(hash).hasClass("active") && $(hash).length){
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 1500);
			$(hash+".plus-tab-header").trigger("click");
			var tab_index=$(hash).data("tab");
			$(".elementor-tab-mobile-title[data-tab='"+tab_index+"']").trigger("click");
		}
		
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-tabs-tours.default', WidgetTabHandler);
	});
})(jQuery);
function plus_tabs_connection(tab_index,connection){
	var $=jQuery;
	if(connection!='' && $("."+connection).length==1){
		var current=$('.'+connection+' > .post-inner-loop').slick('slickCurrentSlide');
		if(current!=(tab_index-1)){
			$('.'+connection+' > .post-inner-loop').slick('slickGoTo', tab_index-1);
		}
	}
}