/*posts listing*/( function( $ ) {
	"use strict";
	var WidgetThePlusHandler = function ($scope, $) {
		var wid_sec=$scope.parents('section.elementor-element');

		if($scope.hasClass("elementor-widget") && $scope.find('.list-isotope').length>0){
			var b = window.theplus || {};
			b.window = $(window),
			b.document = $(document),
			b.windowHeight = b.window.height(),
			b.windowWidth = b.window.width();	
			b.list_isotope_Posts = function() {
				var c = function(c) {
					$('.list-isotope',$scope).each(function() {						
						var e, c = $(this), d = c.data("layout-type"),f = {
							itemSelector: ".grid-item",
							resizable: !0,
							sortBy: "original-order"
						};
						var uid=c.data("id");
						var inner_c=$('.'+uid).find(".post-inner-loop");
						$('.'+uid).addClass("pt-plus-isotope layout-" + d),
						e = "masonry" === d  ? "packery" : "fitRows",
						f.layoutMode = e,
						function() {
							//b.initMetroIsotope(),
							var generate_isotope = inner_c.isotope(f);
							generate_isotope.imagesLoaded().progress( function() {
								generate_isotope.isotope('layout');
							});
						}();
					});
				};
				if($scope.find('.list-isotope .post-filter-data').length>0){
					//List Isotope Filter Item
					$('.list-isotope .post-filter-data').find(".filter-category-list").on('click',function(event) {
						event.preventDefault();
						var p_list = $(this).closest(".list-isotope"),uid = p_list.data("id");
						
						var d = $(this).attr("data-filter");
						$(this).parent().parent().find(".active").removeClass("active"),
						$(this).addClass("active"),
						$('.'+uid).find(".post-inner-loop").isotope({
							filter: d
						}),
						$("body").trigger("isotope-sorted");
					});
				}
				b.window.on("resize", function() {
					c('[data-enable-isotope="1"]')
				}),
				b.document.on("load resize", function() {
					c('[data-enable-isotope="1"]')
				}),
				$(document).ready(function() {
					c('[data-enable-isotope="1"]')					
				}),
				$("body").on("post-load resort-isotope", function() {
					setTimeout(function() {
						c('[data-enable-isotope="1"]')
					}, 800)
				}),
				$("body").on("tabs-reinited", function() {
					setTimeout(function() {
						c('[data-enable-isotope="1"]')
					}, 800)
				});
			},
			b.init = function() {				
				b.list_isotope_Posts();				
			}
			,
			b.init();
		}
		if($scope.hasClass("elementor-widget") && $scope.find('.list-isotope-metro').length>0){
			$(window).on("resize", function() {
				theplus_setup_packery_portfolio('all');
				$('.list-isotope-metro .post-inner-loop').isotope('layout').isotope("reloadItems");
			});
			
			$("body").on("post-load resort-isotope", function() {
				setTimeout(function() {
					theplus_setup_packery_portfolio('all');
					$('.list-isotope-metro .post-inner-loop').isotope('layout');
				}, 800)
			});
			$("body").on("tabs-reinited", function() {
				setTimeout(function() {
					theplus_setup_packery_portfolio('all');
					$('.list-isotope-metro .post-inner-loop').isotope('layout');
				}, 800)
			});
		}
		if($scope.hasClass("elementor-widget") && $scope.find('.gallery-list.gallery-style-3').length>0){
			$('.gallery-list.gallery-style-3 .grid-item').each( function() { $(this).hoverdir(); } );
		}
		/* post listing out*/
		if($scope.hasClass("elementor-widget") && $scope.find('.dynamic-listing.dynamic-listing-style-1,.blog-list.blog-style-1,.gallery-list.gallery-style-2').length>0){
			$(document).ready(function($) {
				$(document).on('mouseenter',".dynamic-listing.dynamic-listing-style-1 .grid-item .blog-list-content,.blog-list.blog-style-1 .grid-item .blog-list-content,.gallery-list.gallery-style-2 .grid-item .gallery-list-content",function() {				
					$(this).find(".post-hover-content").slideDown(300)
				});
				$(document).on('mouseleave',".dynamic-listing.dynamic-listing-style-1 .grid-item .blog-list-content,.blog-list.blog-style-1 .grid-item .blog-list-content,.gallery-list.gallery-style-2 .grid-item .gallery-list-content",function() {
					$(this).find(".post-hover-content").slideUp(300)
				})
			});
		}
		
	};
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/global', WidgetThePlusHandler);
	});
})(jQuery);

/*----load more post ajax----------------*/
;( function($) {
	'use strict';
	$(document).ready(function(){
		if($(".post-load-more").length > 0){
			$(document).on("click",".post-load-more",function(e){
				
				e.preventDefault();
				var current_click= $(this);
				var a= $(this);
				var post_load=a.data('load');
				var post_type=a.data('post_type');
				var texonomy_category=a.data('texonomy_category');
				
				var page = a.attr('data-page');
				var total_page=a.data('total_page');
				var load_class= a.data('load-class');
				var layout=a.data('layout');
				var badge=a.data('badge');
				var variationprice=a.data('variationprice');
				var hoverimagepro=a.data('hoverimagepro');
				var desktop_column=a.data('desktop-column');
				var tablet_column=a.data('tablet-column');
				var mobile_column=a.data('mobile-column');
				var metro_column=a.data('metro_column');				
				var metro_style=a.data('metro_style');
				var responsive_tablet_metro=a.data('responsive_tablet_metro');
				var tablet_metro_column=a.data('tablet_metro_column');
				var tablet_metro_style=a.data('tablet_metro_style');
				var style=a.data('style');
				var style_layout=a.data('style_layout');
				var offset_posts=a.data('offset-posts');
				var category=a.data('category');
				var post_tags=a.data('post_tags');
				var ex_cat=a.data('ex_cat');
				var ex_tag=a.data('ex_tag');
				var post_authors=a.data('post_authors');
				var order_by=a.data('order_by');
				var post_order=a.data('post_order');
				var filter_category=a.data('filter_category');
				var display_post=a.data('display_post');
				var post_load_more=a.data('post_load_more');
				var cart_button=a.data('cart_button');
				var animated_columns=a.data('animated_columns');
				
				var display_post_title=a.data('display_post_title');
				
				var display_title_limit=a.data('display_title_limit');
				var display_title_by=a.data('display_title_by');
				var display_title_input=a.data('display_title_input');
				var display_title_3_dots=a.data('display_title_3_dots');
				
				var feature_image=a.data('feature_image');
				
				var display_post_meta=a.data('display_post_meta');
				var post_meta_tag_style=a.data('post_meta_tag_style');
				var display_post_meta_date=a.data('display_post_meta_date');
				var display_post_meta_author=a.data('display_post_meta_author');
				var display_post_meta_author_pic=a.data('display_post_meta_author_pic');
				var display_excerpt=a.data('display_excerpt');
				var post_excerpt_count=a.data('post_excerpt_count');
				var display_post_category=a.data('display_post_category');
				var post_category_style=a.data('post_category_style');
				var featured_image_type=a.data('featured_image_type');
				
				var display_thumbnail=a.data('display_thumbnail');
				var thumbnail=a.data('thumbnail');
				var thumbnail_car=a.data('thumbnail_car');
				
				var display_button=a.data('display_button');
				var button_style=a.data('button_style');
				var before_after=a.data('before_after');
				var button_text=a.data('button_text');
				var button_icon_style=a.data('button_icon_style');
				var button_icon=a.data('button_icon');
				var button_icons_mind=a.data('button_icons_mind');
				var current_text= a.text();
				var loaded_posts= a.data("loaded_posts");
				var tp_loading_text= a.data("tp_loading_text");
				var display_product= a.data("display_product");
				var display_catagory= a.data("display_catagory");
				var display_rating= a.data("display_rating");
				var dcb_single_product= a.data("dcb_single_product");
				var dcb_variation_product= a.data("dcb_variation_product");
				var skin_template= a.data("skin_template");
				if ( current_click.data('requestRunning') ) {
					return;
				}
				if(offset_posts==undefined || offset_posts==""){
					offset_posts=0;
				}
				current_click.data('requestRunning', true);
				if(total_page >= page){					
					var offset=(parseInt(page-1)*parseInt(post_load_more))+parseInt(display_post)+parseInt(offset_posts);
					$.ajax({
						type:'POST',
						data:'style='+style+'&style_layout='+style_layout+'&action=theplus_more_post&post_load='+post_load+'&post_type='+post_type+'&texonomy_category='+texonomy_category+'&layout='+layout+'&desktop_column='+desktop_column+'&tablet_column='+tablet_column+'&mobile_column='+mobile_column+'&offset='+offset+'&category='+category+'&post_tags='+post_tags+'&post_authors='+post_authors+'&display_post='+display_post+'&order_by='+order_by+'&filter_category='+filter_category+'&post_order='+post_order+'&animated_columns='+animated_columns+'&post_load_more='+post_load_more+'&cart_button='+cart_button+'&metro_column='+metro_column+'&metro_style='+metro_style+'&responsive_tablet_metro='+responsive_tablet_metro+'&tablet_metro_column='+tablet_metro_column+'&tablet_metro_style='+tablet_metro_style+'&display_post_meta='+display_post_meta+'&post_meta_tag_style='+post_meta_tag_style+'&display_post_meta_date='+display_post_meta_date+'&display_post_meta_author='+display_post_meta_author+'&display_post_meta_author_pic='+display_post_meta_author_pic+'&display_excerpt='+display_excerpt+'&post_excerpt_count='+post_excerpt_count+'&display_post_category='+display_post_category+'&post_category_style='+post_category_style+'&featured_image_type='+featured_image_type+'&display_button='+display_button+'&button_style='+button_style+'&before_after='+before_after+'&button_text='+button_text+'&button_icon_style='+button_icon_style+'&button_icon='+button_icon+'&button_icons_mind='+button_icons_mind+'&paged='+page+'&display_post_title='+display_post_title+'&skin_template='+skin_template+'&badge='+badge+'&variationprice='+variationprice+'&hoverimagepro='+hoverimagepro+
						'&display_thumbnail='+display_thumbnail+'&thumbnail='+thumbnail+'&thumbnail_car='+thumbnail_car+'&ex_cat='+ex_cat+'&ex_tag='+ex_tag+'&display_product='+display_product+'&display_catagory='+display_catagory+'&display_rating='+display_rating+'&dcb_single_product='+dcb_single_product+'&dcb_variation_product='+dcb_variation_product+'&display_title_limit='+display_title_limit+'&display_title_by='+display_title_by+'&display_title_input='+display_title_input+'&display_title_3_dots='+display_title_3_dots+'&feature_image='+feature_image,
						url:theplus_ajax_url,
						beforeSend: function() {
							$(current_click).text(tp_loading_text);
							},success: function(data) {         
							if(data==''){
								$(current_click).addClass("hide");								
							}else{
								$("."+load_class+' .post-inner-loop').append( data );
								if(layout=='grid' || layout=='masonry'){
									if(!$("."+load_class).hasClass("list-grid-client")){
										var $newItems = $('');
										$("."+load_class+' .post-inner-loop').isotope( 'insert', $newItems );
										$("."+load_class+' .post-inner-loop').isotope( 'layout' ).isotope( 'reloadItems' ); 
									}
								}
								if ($("."+load_class+'.list-isotope-metro .post-inner-loop').length > 0) {
									var container=$("."+load_class);
									var uid=container.data("id");
									var columns=container.attr('data-metro-columns');
									var metro_style=container.attr('data-metro-style');
									theplus_backend_packery_portfolio(uid,columns,metro_style);
									$("."+load_class+'.list-isotope-metro .post-inner-loop').isotope('layout').isotope( 'reloadItems' );
								}
								if($("."+load_class).parents(".animate-general").length){
									var c,d;
									if($("."+load_class).find(".animated-columns").length){
										var p = $("."+load_class).parents(".animate-general");
										var delay_time=p.data("animate-delay");
										var animation_stagger=p.data("animate-stagger");
										var d = p.data("animate-type");
										var animate_offset = p.data("animate-offset");
										p.css("opacity","1");
										c = p.find('.animated-columns');
										c.each(function() {
											var bc=$(this);
											bc.waypoint(function(direction) {
												if( direction === 'down'){
													if(!bc.hasClass("animation-done")){
														bc.addClass("animation-done").velocity(d,{ delay: delay_time,display:'auto'});
													}
												}
											}, {triggerOnce: true,  offset: animate_offset } );
										});
										}else{
										var b = $("."+load_class).parents(".animate-general");
										var delay_time=b.data("animate-delay");
										d = b.data("animate-type"),
										animate_offset = b.data("animate-offset"),
										b.waypoint(function(direction ) {
											if( direction === 'down'){
												if(!b.hasClass("animation-done")){
													b.addClass("animation-done").velocity(d, {delay: delay_time,display:'auto'});
												}
											}
										}, {triggerOnce: true,  offset: animate_offset } );
									}
								}
								
							}
							page++;
							if(page==total_page){
								$(current_click).addClass("hide");
								$(current_click).attr('data-page', page);
								$(current_click).parent(".ajax_load_more").append('<div class="plus-all-posts-loaded">'+loaded_posts+'</div>');
							}else{
								$(current_click).text(current_text);
								$(current_click).attr('data-page', page);
							}
							
							var list_audio = $("."+load_class+' .post-inner-loop').find(".tp-audio-player-wrapper");
							if(list_audio.length){
								list_audio.each(function(){
									var id = $(this).data("id");
									var style = container.data('style');
									loadinitAudio($('.'+id+' .playlist li:first-child'),id,style);
								});
							}
							
							},complete: function() {
							if($("."+load_class+' .post-filter-data').length){
								$("."+load_class+' .post-filter-data .category-filters > li > a').each(function(){
									var filter = $(this).data("filter");
									if(filter!='' && filter!=undefined && filter==='*'){
										var totle_count = $("."+load_class+' .post-inner-loop .grid-item').length;
									}else if(filter!='' && filter!=undefined){
										var totle_count = $("."+load_class+' .post-inner-loop .grid-item'+filter).length;
									}
									if(totle_count){
										$(this).find(".all_post_count").text(totle_count);
									}
								});
							}
							$('.elementor-widget-tp-row-background .elementor-widget-container').each(function(){
								var trig = $(this).html();
								$(this).closest('.elementor-section').prepend(trig);
								$(this).remove();
							});
							if(layout=='grid' || layout=='masonry'){
								if(!$("."+load_class).hasClass("list-grid-client")){
									setTimeout(function(){	
										$("."+load_class+' .post-inner-loop').isotope( 'layout' ).isotope( 'reloadItems' );
									}, 500);
								}
							}
							if ($("."+load_class+'.list-isotope-metro .post-inner-loop').length > 0) {
								var container=$("."+load_class);
								var uid=container.data("id");
								var columns=container.attr('data-metro-columns');
								var metro_style=container.attr('data-metro-style');
								theplus_backend_packery_portfolio(uid,columns,metro_style);
								$("."+load_class+'.list-isotope-metro .post-inner-loop').isotope('layout').isotope( 'reloadItems' );
							}
							
							current_click.data('requestRunning', false);
						}
						}).then(function(){
						if(!$("."+load_class).hasClass("list-grid-client")){
							if(layout=='grid' || layout=='masonry'){
								var container = $("."+load_class+' .post-inner-loop');
								container.isotope({
									itemSelector: '.grid-item',
								});						
							}
						}
						if ($("."+load_class+'.list-isotope-metro .post-inner-loop').length > 0) {
							var container=$("."+load_class);
							var uid=container.data("id");
							var columns=container.attr('data-metro-columns');
							var metro_style=container.attr('data-metro-style');
							theplus_backend_packery_portfolio(uid,columns,metro_style);
							$("."+load_class+'.list-isotope-metro .post-inner-loop').isotope('layout').isotope( 'reloadItems' );
						}
						
					});
				}else{
					$(current_click).addClass("hide");
				}
			});
		}
	});
})(jQuery );
/*----load more post ajax----------------*/
/*----lazy load ajax----------------*/
;( function($) {
	'use strict';
	$(window).load(function(){
		
		if($('body').find('.post-lazy-load').length>=1){
			
			var windowWidth, windowHeight, documentHeight, scrollTop, containerHeight, containerOffset, $window = $(window);
			
			var recalcValues = function() {
				windowWidth = $window.width();
				windowHeight = $window.height();
				documentHeight = $('body').height();
				containerHeight = $('.list-isotope,.list-isotope-metro').height();
				containerOffset = $('.list-isotope,.list-isotope-metro').offset().top+50;
				setTimeout(function(){
					containerHeight = $('.list-isotope,.list-isotope-metro').height();
					containerOffset = $('.list-isotope,.list-isotope-metro').offset().top+50;
				}, 50);
			};
			
			recalcValues();
			$window.resize(recalcValues);
			
			$window.bind('scroll', function(e) {
				
				e.preventDefault();
				recalcValues();
				scrollTop = $window.scrollTop();
				$('.list-isotope,.list-isotope-metro').each(function() {
					containerHeight = $(this).height();
					containerOffset = $(this).offset().top+50;
					if($(this).find(".post-lazy-load").length && scrollTop < documentHeight && scrollTop > (containerHeight + containerOffset - windowHeight)){
					
						var current_click= $(this).find(".post-lazy-load");
						var a= $(this).find(".post-lazy-load");
						var post_load=a.data('load');
						var post_type=a.data('post_type');
						var texonomy_category=a.data('texonomy_category');
							
						var page = a.attr('data-page');
						var total_page=a.data('total_page');
						var load_class= a.data('load-class');
						var layout=a.data('layout');
						var badge=a.data('badge');
						var variationprice=a.data('variationprice');
						var hoverimagepro=a.data('hoverimagepro');
						var desktop_column=a.data('desktop-column');
						var tablet_column=a.data('tablet-column');
						var mobile_column=a.data('mobile-column');
						var metro_column=a.data('metro_column');
						var metro_style=a.data('metro_style');
						var responsive_tablet_metro=a.data('responsive_tablet_metro');
						var tablet_metro_column=a.data('tablet_metro_column');
						var tablet_metro_style=a.data('tablet_metro_style');
						var style=a.data('style');
						var style_layout=a.data('style_layout');
						var offset_posts=a.data('offset-posts');
						var category=a.data('category');
						var post_tags=a.data('post_tags');
						var ex_cat=a.data('ex_cat');
						var ex_tag=a.data('ex_tag');
						var post_authors=a.data('post_authors');
						var order_by=a.data('order_by');
						var post_order=a.data('post_order');
						var filter_category=a.data('filter_category');
						var display_post=a.data('display_post');
						var post_load_more=a.data('post_load_more');
						var cart_button=a.data('cart_button');
						var animated_columns=a.data('animated_columns');
						
						var display_post_title=a.data('display_post_title');
						
						var display_title_limit=a.data('display_title_limit');
						var display_title_by=a.data('display_title_by');
						var display_title_input=a.data('display_title_input');
						var display_title_3_dots=a.data('display_title_3_dots');
						
						var feature_image=a.data('feature_image');
						
						var display_post_meta=a.data('display_post_meta');
						var post_meta_tag_style=a.data('post_meta_tag_style');
						var display_post_meta_date=a.data('display_post_meta_date');
						var display_post_meta_author=a.data('display_post_meta_author');
						var display_post_meta_author_pic=a.data('display_post_meta_author_pic');
						var display_excerpt=a.data('display_excerpt');
						var post_excerpt_count=a.data('post_excerpt_count');
						var display_post_category=a.data('display_post_category');
						var post_category_style=a.data('post_category_style');
						var featured_image_type=a.data('featured_image_type');
						
						var display_thumbnail=a.data('display_thumbnail');
						var thumbnail=a.data('thumbnail');
						var thumbnail_car=a.data('thumbnail_car');
						
						var display_button=a.data('display_button');
						var button_style=a.data('button_style');
						var before_after=a.data('before_after');
						var button_text=a.data('button_text');
						var button_icon_style=a.data('button_icon_style');
						var button_icon=a.data('button_icon');
						var button_icons_mind=a.data('button_icons_mind');
						
						var current_text= a.html();
						var loaded_posts= a.data("loaded_posts");
						var tp_loading_text= a.data("tp_loading_text");
						var display_product= a.data("display_product");
						var display_catagory= a.data("display_catagory");
						var display_rating= a.data("display_rating");
						var dcb_single_product= a.data("dcb_single_product");
						var dcb_variation_product= a.data("dcb_variation_product");
						var skin_template= a.data("skin_template");
						if ( current_click.data('requestRunning') ) {
							return;
						}
						if(offset_posts==undefined || offset_posts==""){
							offset_posts=0;
						}
						if(total_page > page){			
							current_click.data('requestRunning', true);
							var offset=(parseInt(page-1)*parseInt(post_load_more))+parseInt(display_post)+parseInt(offset_posts);							
							$.ajax({
								type:'POST',
								data:'style='+style+'&style_layout='+style_layout+'&action=theplus_more_post&post_load='+post_load+'&post_type='+post_type+'&texonomy_category='+texonomy_category+'&layout='+layout+'&desktop_column='+desktop_column+'&tablet_column='+tablet_column+'&mobile_column='+mobile_column+'&offset='+offset+'&category='+category+'&post_tags='+post_tags+'&post_authors='+post_authors+'&display_post='+display_post+'&order_by='+order_by+'&filter_category='+filter_category+'&post_order='+post_order+'&animated_columns='+animated_columns+'&post_load_more='+post_load_more+'&cart_button='+cart_button+'&metro_column='+metro_column+'&metro_style='+metro_style+'&responsive_tablet_metro='+responsive_tablet_metro+'&tablet_metro_column='+tablet_metro_column+'&tablet_metro_style='+tablet_metro_style+'&display_post_meta='+display_post_meta+'&post_meta_tag_style='+post_meta_tag_style+'&display_post_meta_date='+display_post_meta_date+'&display_post_meta_author='+display_post_meta_author+'&display_post_meta_author_pic='+display_post_meta_author_pic+'&display_excerpt='+display_excerpt+'&post_excerpt_count='+post_excerpt_count+'&display_post_category='+display_post_category+'&post_category_style='+post_category_style+'&featured_image_type='+featured_image_type+'&display_button='+display_button+'&button_style='+button_style+'&before_after='+before_after+'&button_text='+button_text+'&button_icon_style='+button_icon_style+'&button_icon='+button_icon+'&button_icons_mind='+button_icons_mind+'&paged='+page+'&display_post_title='+display_post_title+'&skin_template='+skin_template+'&badge='+badge+'&variationprice='+variationprice+'&hoverimagepro='+hoverimagepro+
								'&display_thumbnail='+display_thumbnail+'&thumbnail='+thumbnail+'&thumbnail_car='+thumbnail_car+'&ex_cat='+ex_cat+'&ex_tag='+ex_tag+'&display_product='+display_product+'&display_catagory='+display_catagory+'&display_rating='+display_rating+'&dcb_single_product='+dcb_single_product+'&dcb_variation_product='+dcb_variation_product+'&display_title_limit='+display_title_limit+'&display_title_by='+display_title_by+'&display_title_input='+display_title_input+'&display_title_3_dots='+display_title_3_dots+'&feature_image='+feature_image,
								url:theplus_ajax_url,
								beforeSend: function() {
									$(current_click).text(tp_loading_text);
									},success: function(data) {         
									if(data==''){
										$(current_click).addClass("hide");										
									}else{
										$("."+load_class+' .post-inner-loop').append( data );
										
										if(layout=='grid' || layout=='masonry'){
											if(!$("."+load_class).hasClass("list-grid-client")){
												var $newItems = $('');
												$("."+load_class+' .post-inner-loop').isotope( 'insert', $newItems );
												$("."+load_class+' .post-inner-loop').isotope( 'layout' ).isotope( 'reloadItems' ); 
											}
										}
										if ($("."+load_class+'.list-isotope-metro .post-inner-loop').length > 0) {
											var container=$("."+load_class);
											var uid=container.data("id");
											var columns=container.attr('data-metro-columns');
											var metro_style=container.attr('data-metro-style');
											theplus_backend_packery_portfolio(uid,columns,metro_style);
											$("."+load_class+'.list-isotope-metro .post-inner-loop').isotope('layout').isotope( 'reloadItems' );
										}
										
										if($("."+load_class).parents(".animate-general").length){
											var c,d;
											if($("."+load_class).find(".animated-columns").length){
												var p = $("."+load_class).parents(".animate-general");
												var delay_time=p.data("animate-delay");
												var animation_stagger=p.data("animate-stagger");
												var d = p.data("animate-type");
												var animate_offset = p.data("animate-offset");
												p.css("opacity","1");
												c = p.find('.animated-columns');
												c.each(function() {
													var bc=$(this);
													bc.waypoint(function(direction) {
														if( direction === 'down'){
															if(!bc.hasClass("animation-done")){
																bc.addClass("animation-done").velocity(d,{ delay: delay_time,display:'auto'});
															}
														}
													}, {triggerOnce: true,  offset: animate_offset } );
												});
												}else{
												var b = $("."+load_class).parents(".animate-general");
												var delay_time=b.data("animate-delay");
												d = b.data("animate-type"),
												animate_offset = b.data("animate-offset"),
												b.waypoint(function(direction ) {
													if( direction === 'down'){
														if(!b.hasClass("animation-done")){
															b.addClass("animation-done").velocity(d, {delay: delay_time,display:'auto'});
														}
													}
												}, {triggerOnce: true,  offset: animate_offset } );
											}
										}
									}
									page++;
									if(page==total_page){
										$(current_click).addClass("hide");
										$(current_click).attr('data-page', page);
										$(current_click).parent(".ajax_lazy_load").append('<div class="plus-all-posts-loaded">'+loaded_posts+'</div>');
									}else{
										$(current_click).html(current_text);
										$(current_click).attr('data-page', page);	
									}
									
									var list_audio = $("."+load_class+' .post-inner-loop').find(".tp-audio-player-wrapper");
									if(list_audio.length){
										list_audio.each(function(){
											var id = $(this).data("id");
											var style = container.data('style');
											loadinitAudio($('.'+id+' .playlist li:first-child'),id,style);
										});
									}
									
									},complete: function() {
									if($("."+load_class+' .post-filter-data').length){
										$("."+load_class+' .post-filter-data .category-filters > li > a').each(function(){
											var filter = $(this).data("filter");
											if(filter!='' && filter!=undefined && filter==='*'){
												var totle_count = $("."+load_class+' .post-inner-loop .grid-item').length;
											}else if(filter!='' && filter!=undefined){
												var totle_count = $("."+load_class+' .post-inner-loop .grid-item'+filter).length;
											}
											if(totle_count){
												$(this).find(".all_post_count").text(totle_count);
											}
										});
									}
									$('.elementor-widget-tp-row-background .elementor-widget-container').each(function(){
										var trig = $(this).html();
										$(this).closest('.elementor-section').prepend(trig);
										$(this).remove();
									});
									if(layout=='grid' || layout=='masonry'){
										if(!$("."+load_class).hasClass("list-grid-client")){
											setTimeout(function(){
												$("."+load_class+' .post-inner-loop').isotope( 'layout' ).isotope( 'reloadItems' );
											}, 500);
										}
									}
									if ($("."+load_class+'.list-isotope-metro .post-inner-loop').length > 0) {
										var container=$("."+load_class);
										var uid=container.data("id");
										var columns=container.attr('data-metro-columns');
										var metro_style=container.attr('data-metro-style');
										theplus_backend_packery_portfolio(uid,columns,metro_style);
										$("."+load_class+'.list-isotope-metro .post-inner-loop').isotope('layout').isotope( 'reloadItems' );
									}
									current_click.data('requestRunning', false);
								}
								}).then(function(){
								if(!$("."+load_class).hasClass("list-grid-client")){
									if(layout=='grid' || layout=='masonry'){
										var container = $("."+load_class+' .post-inner-loop');
										container.isotope({
											itemSelector: '.grid-item',
										});								
									}
								}
								if ($("."+load_class+'.list-isotope-metro .post-inner-loop').length > 0) {
									var container=$("."+load_class);
									var uid=container.data("id");
									var columns=container.attr('data-metro-columns');
									var metro_style=container.attr('data-metro-style');
									theplus_backend_packery_portfolio(uid,columns,metro_style);
									$("."+load_class+'.list-isotope-metro .post-inner-loop').isotope('layout').isotope( 'reloadItems' );
								}
								
							});
							
							}else{
							$(current_click).addClass("hide");
						}					
					}
				});
			});
		}
	});
})(jQuery );
/*-Lazy Load Post-*/