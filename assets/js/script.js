/* -----------------------------------------------------------------------------



File:           JS Core
Version:        1.0
Last change:    00/00/00 
-------------------------------------------------------------------------------- */
(function() {

	"use strict";

	var clinox = {
		init: function() {
			this.Basic.init();  
		},

		Basic: {
			init: function() {

				this.preloader();
				this.BackgroundImage();
				this.Animation();
				this.StickyHeader();
				this.HeroRipples();
				this.MobileMenu();
				this.scrollTop();
				this.SkillProgress();
				this.CounterUp();
				this.searchPopUp();
				this.TextAnimation();
				this.CarouselSliderJS();
				this.BeforeAfterProject();
				this.ProjectFilter();
				this.ShapeScrollImg();
				this.GoogleMap();
				
				
			},
			preloader: function (){
				jQuery(window).on('load', function(){
					jQuery('#preloader').fadeOut('slow',function(){jQuery(this).remove();});
				})
			},
			BackgroundImage: function (){
				$('[data-background]').each(function() {
					var src = $(this).attr('data-background');
					if (src) {
						$(this).css('background-image', 'url("' + src.replace(/"/g, '\\"') + '")');
					}
				});
			},
			Animation: function (){
				if($('.wow').length){
					var wow = new WOW(
					{
						boxClass:     'wow',
						animateClass: 'animated',
						offset:       0,
						mobile:       true,
						live:         true
					}
					);
					wow.init();
				}
			},
			StickyHeader: function (){
				var $header = jQuery('.clinox-header-section');
				function updateStickyHeader() {
					if (window.matchMedia && window.matchMedia('(max-width: 991px)').matches) {
						$header.removeClass('sticky-on');
						jQuery('body').css('padding-top', '');
						return;
					}

					if (jQuery(window).scrollTop() > 250) {
						$header.addClass('sticky-on');
						jQuery('body').css('padding-top', $header.outerHeight() + 'px');
					} else {
						$header.removeClass('sticky-on');
						jQuery('body').css('padding-top', '');
					}
				}

				jQuery(window).on('scroll resize', updateStickyHeader);
				updateStickyHeader();
			},
			HeroRipples: function () {
				var $hero = jQuery('#clinox-banner-3');
				if (!$hero.length) return; // home hero only
				if (typeof jQuery.fn.ripples !== 'function') return;
				if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

				try {
					$hero.ripples({
						// Use hero section background (set via data-background / CSS)
						resolution: 256,
						dropRadius: 18,
						perturbance: 0.02,
					});
				} catch (e) {
					// If WebGL/float textures unsupported, silently skip
				}
			},
			searchPopUp: function (){
				if($('.search-box-outer').length) {
					$('.search-box-outer').on('click', function() {
						$('body').addClass('search-active');
					});
					$('.close-search').on('click', function() {
						$('body').removeClass('search-active');
					});
				};
			},
			MobileMenu: function (){
				$('.open_mobile_menu').on("click", function() {
					$('.mobile_menu_wrap').toggleClass("mobile_menu_on");
				});
				$('.open_mobile_menu').on('click', function () {
					$('body').toggleClass('mobile_menu_overlay_on');
				});
				if($('.mobile_menu li.dropdown ul').length){
					$('.mobile_menu li.dropdown').append('<div class="dropdown-btn"><span class="fas fa-caret-right"></span></div>');
					$('.mobile_menu li.dropdown .dropdown-btn').on('click', function() {
						$(this).prev('ul').slideToggle(500);
					});
				}
				$(".dropdown-btn").on("click", function () {
					$(this).toggleClass("toggle-open");
				});
			},
			TextAnimation: function (){
				var $lat_anim = $('.pr-text-anim');
				var $display = $(window);

				function scroll_addclass() {
					var display_long = $(window).height() - 100;
					var display_aim = $display.scrollTop();
					var display_down = (display_aim + display_long);

					$.each($lat_anim, function () {
						var $item_s = $(this);
						var items_long = $item_s.outerHeight();
						var item_up = $item_s.offset().top;
						var item_down = (item_up + items_long);

						if ((item_down >= display_aim) &&
							(item_up <= display_down)) {
							$item_s.addClass('is_show');
					}
				});
				}

				$display.on('scroll resize', scroll_addclass);
				$display.trigger('scroll');


				var $c_slide_effect = $('.pr-text-in');
				var $display = $(window);
				function c_scroll_addclass() {
					var display_long = $(window).height() - 100;
					var display_aim = $display.scrollTop();
					var display_down = (display_aim + display_long);

					$.each($c_slide_effect, function () {
						var $item_s = $(this);
						var items_long = $item_s.outerHeight();
						var item_up = $item_s.offset().top;
						var item_down = (item_up + items_long);

						if ((item_down >= display_aim) &&
							(item_up <= display_down)) {
							$item_s.addClass('is_shown');
					}
				});
				}

				$display.on('scroll resize', c_scroll_addclass);
				$display.trigger('scroll');
			},
			scrollTop: function (){
				$(window).on("scroll", function() {
					if ($(this).scrollTop() > 200) {
						$('.scrollup').fadeIn();
					} else {
						$('.scrollup').fadeOut();
					}
				});

				$('.scrollup').on("click", function()  {
					$("html, body").animate({
						scrollTop: 0
					}, 800);
					return false;
				});
				$('.zoom-gallery').magnificPopup({
					delegate: 'a',
					type: 'image',
					closeOnContentClick: false,
					closeBtnInside: false,
					mainClass: 'mfp-with-zoom mfp-img-mobile',
					gallery: {
						enabled: true
					},
					zoom: {
						enabled: true,
						duration: 300, 
						opener: function(element) {
							return element.find('img');
						}
					}
				});
			},
			CarouselSliderJS: function (){
				$('.clinox-slider-content').slick({
					arrow: true,
					dots: false,
					infinite: true,
					slidesToShow: 1,
					fade: true,
					autoplay: false,
					slidesToScroll: 1,
					prevArrow: ".main_left_arrow",
					nextArrow: ".main_right_arrow",
				});
				$('.clinox-team-slider-wrap').slick({
					arrow: true,
					dots: false,
					infinite: false,
					slidesToShow: 3,
					slidesToScroll: 1,
					prevArrow: ".team_left_arrow",
					nextArrow: ".team_right_arrow",
					responsive: [
					{
						breakpoint: 1300,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3,
							infinite: true,
						}
					},
					{
						breakpoint: 1025,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2,
							infinite: true,
						}
					},
					{
						breakpoint: 800,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 500,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}

					]
				});
				$('.clinox-testimonial-slider').slick({
					arrow: true,
					dots: false,
					infinite: false,
					slidesToShow: 2,
					slidesToScroll: 1,
					prevArrow: ".testi-left_arrow",
					nextArrow: ".testi-right_arrow",
					responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
							infinite: true,
						}
					},
					{
						breakpoint: 1000,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 800,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 2
						}
					},
					{
						breakpoint: 500,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}

					]
				});
				$('.clinox-sponsor-slider').slick({
					arrow: false,
					dots: false,
					infinite: true,
					slidesToShow: 5,
					autoplay: true,
					slidesToScroll: 1,
					responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 1,
							infinite: true,
							dots: false
						}
					},
					{
						breakpoint: 800,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 400,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					]
				});
				$('.clinox-service-slider-2').slick({
					arrow: false,
					dots: true,
					infinite: true,
					slidesToShow: 3,
					autoplay: false,
					slidesToScroll: 1,
					responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 1,
							infinite: true,
							dots: false
						}
					},
					{
						breakpoint: 800,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 400,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					]
				});
				$('.clinox-project-slider').slick({
					arrow: false,
					dots: true,
					infinite: true,
					slidesToShow: 4,
					autoplay: false,
					slidesToScroll: 1,
					responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 1,
							infinite: true,
							dots: false
						}
					},
					{
						breakpoint: 800,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 400,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					]
				});
				$('.clinox-testimonial-slider-2').slick({
					centerMode: true,
					dots: true,
					nav: false,
					slidesToShow: 3,
					responsive: [
					{
						breakpoint: 1450,
						settings: {
							arrows: false,
							centerMode: true,
							slidesToShow: 3
						}
					},
					{
						breakpoint: 1100,
						settings: {
							arrows: false,
							centerMode: true,
							slidesToShow: 1
						}
					},
					{
						breakpoint: 850,
						settings: {
							arrows: false,
							centerMode: true,
							slidesToShow: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							arrows: false,
							centerMode: true,
							slidesToShow: 1
						}
					}
					]
				});
				var $projectSliderFor = $('.project-slider-for');
				var $projectSliderNav = $('.project-slider-nav');
				if ($projectSliderFor.length && $projectSliderNav.length) {
					$projectSliderFor.slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: false,
						asNavFor: '.project-slider-nav'
					});
					$projectSliderNav.slick({
						slidesToShow: 5,
						slidesToScroll: 1,
						infinite: true,
						asNavFor: '.project-slider-for',
						dots: true,
						arrows: false,
						focusOnSelect: true
					});
				}
				var $serviceSlider3 = $('.clinox-service-slider-3');
				if ($serviceSlider3.length) {
					var serviceSlider3Rtl = typeof nspData !== 'undefined' && !!nspData.isRtl;

					if ($serviceSlider3.hasClass('slick-initialized')) {
						$serviceSlider3.slick('unslick');
					}

					$serviceSlider3.attr('dir', serviceSlider3Rtl ? 'rtl' : 'ltr');
					$serviceSlider3.slick({
						arrows: true,
						dots: false,
						infinite: true,
						rtl: serviceSlider3Rtl,
						rows: 0,
						slidesToShow: 3,
						slidesToScroll: 1,
						swipeToSlide: true,
						waitForAnimate: false,
						prevArrow: ".ser3_left_arrow",
						nextArrow: ".ser3_right_arrow",
						responsive: [
						{
							breakpoint: 1300,
							settings: {
								slidesToShow: 3,
								slidesToScroll: 1,
								infinite: true,
							}
						},
						{
							breakpoint: 1025,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1,
								infinite: true,
							}
						},
						{
							breakpoint: 800,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1
							}
						},
						{
							breakpoint: 600,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
						},
						{
							breakpoint: 500,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
						}

						]
					});
				}
				var $projectSlider3 = $('.clinox-project-slider-3');
				if ($projectSlider3.length) {
					var projectSlider3Rtl = typeof nspData !== 'undefined' && !!nspData.isRtl;
					var initProjectSlider3 = function() {
						if ($projectSlider3.hasClass('slick-initialized')) {
							$projectSlider3.slick('unslick');
						}

						$projectSlider3.attr('dir', projectSlider3Rtl ? 'rtl' : 'ltr');
						$projectSlider3.slick({
							arrows: false,
							dots: true,
							infinite: false,
							rtl: projectSlider3Rtl,
							slidesToShow: 3,
							slidesToScroll: 1,
							responsive: [
							{
								breakpoint: 1300,
								settings: {
									slidesToShow: 3,
									slidesToScroll: 3,
									infinite: true,
									rtl: projectSlider3Rtl,
								}
							},
							{
								breakpoint: 1025,
								settings: {
									slidesToShow: 2,
									slidesToScroll: 2,
									infinite: true,
									rtl: projectSlider3Rtl,
								}
							},
							{
								breakpoint: 800,
								settings: {
									slidesToShow: 2,
									slidesToScroll: 1,
									rtl: projectSlider3Rtl,
								}
							},
							{
								breakpoint: 600,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									rtl: projectSlider3Rtl,
								}
							},
							{
								breakpoint: 500,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									rtl: projectSlider3Rtl,
								}
							}

							]
						});
					};

					initProjectSlider3();
					$(window).on('resize.nspProjectSlider3', function() {
						clearTimeout(window.nspProjectSlider3Resize);
						window.nspProjectSlider3Resize = setTimeout(initProjectSlider3, 150);
					});
				}
				$('.clinox-testimonial-slider-3').slick({
					arrow: false,
					dots: true,
					infinite: false,
					slidesToShow: 1,
					slidesToScroll: 1,
				});
				$('.clinox-sponsor-slider-3').slick({
					arrow: false,
					dots: false,
					infinite: true,
					slidesToShow: 5,
					autoplay: true,
					slidesToScroll: 1,
					responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 1,
							infinite: true,
							dots: false
						}
					},
					{
						breakpoint: 800,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 500,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1
						}
					},
					]
				});
			},
			CounterUp: function(){
				$('.counter').counterUp({
					delay: 10,
					time: 1000
				});
			},
			SkillProgress: function (){
				if ($(".progress-bar").length) {
					var $progress_bar = $('.progress-bar');
					$progress_bar.appear();
					$(document.body).on('appear', '.progress-bar', function() {
						var current_item = $(this);
						if (!current_item.hasClass('appeared')) {
							var percent = current_item.data('percent');
							current_item.css('width', percent + '%').addClass('appeared').parent().append('<span>' + percent + '%' + '</span>');
						}
						
					});
				};
			},
			BeforeAfterProject: function (){
				var setReveal = function($wrap, pct) {
					var right = 100 - pct;
					$wrap.find('.nsp-before-after__after').css({
						'clip-path': 'inset(0 ' + right + '% 0 0)',
						'-webkit-clip-path': 'inset(0 ' + right + '% 0 0)'
					});
					$wrap.find('.nsp-before-after__divider').css('left', pct + '%');
				};
				var getPageX = function(event) {
					var original = event.originalEvent || event;
					var touch = original.touches && original.touches.length ? original.touches[0] : null;
					touch = touch || (original.changedTouches && original.changedTouches.length ? original.changedTouches[0] : null);

					return touch ? touch.pageX : event.pageX;
				};
				var updateReveal = function(event) {
					var $wrap = $(this);
					var offset = $wrap.offset();
					var width = $wrap.outerWidth();
					var pageX = getPageX(event);

					if (!width || typeof pageX === 'undefined') {
						return;
					}

					var x = pageX - offset.left;
					var pct = Math.max(0, Math.min(100, (x / width) * 100));

					setReveal($wrap, pct);
				};

				$(document).on('mousemove mouseenter pointerdown pointermove click touchstart touchmove', '.nsp-before-after', updateReveal);

				$(document).on('mouseleave', '.nsp-before-after', function() {
					setReveal($(this), 50);
				});
			},
			ProjectFilter:  function (){
				jQuery(window).on('load', function(){
					var filterizd = $('.filtr-container');

					if(filterizd.length && $.fn.imagesLoaded && $.fn.filterizr) {
						filterizd.imagesLoaded ( function(){});
						filterizd.filterizr({

						});
						$('.filtr-button').on('click', function() {

							$('.filtr-button.filtr-active').removeClass('filtr-active');
							$(this).addClass('filtr-active');
						});
					}
				});
			},
			ShapeScrollImg: function (){
				(function($) {
					$.fn.visible = function(partial) {
						var $t            = $(this),
						$w            = $(window),
						viewTop       = $w.scrollTop(),
						viewBottom    = viewTop + $w.height(),
						_top          = $t.offset().top,
						_bottom       = _top + $t.height(),
						compareTop    = partial === true ? _bottom : _top,
						compareBottom = partial === true ? _top : _bottom;
						return ((compareBottom <= viewBottom) && (compareTop >= viewTop));
					};
				})(jQuery);
				$(window).on('scroll', function() {

					$(".bg-shape, .bg-img-area").each(function(i, el) {
						var el = $(el);
						if (el.visible(true)) {
							el.addClass("view-on"); 
						} else {
							el.removeClass("view-on");
						}
					});
				});
				$(document).on('ready', function() {
					$(".banner-img1, .banner-img2").each(function(i, el) {
						var el = $(el);
						if (el.visible(true)) {
							el.addClass("view-on"); 
						} else {
							el.removeClass("view-on");
						}
					});
				});
				if($('.quantity-input-2').length) {
					$('.quantity-input-2').inputarrow({
						renderNext: function(input) {
							return $('<span class="custom-next">+</span>').insertAfter(input);
						},
						renderPrev: function(input) {
							return $('<span class="custom-prev">-</span>').insertBefore(input);
						},
						disabledClassName: 'custom-disabled'
					});
				};
			},
			GoogleMap: function (){
				function isMobile() { 
					return ('ontouchstart' in document.documentElement);
				}
				function init_gmap() {
					if ( typeof google == 'undefined' ) return;
					var options = {
						center: [40.712784,-74.005941],
						zoom: 10,
						styles: [
						{
							"featureType": "all",
							"elementType": "geometry.fill",
							"stylers": [
							{
								"weight": "2.00"
							}
							]
						},
						{
							"featureType": "all",
							"elementType": "geometry.stroke",
							"stylers": [
							{
								"color": "#9c9c9c"
							}
							]
						},
						{
							"featureType": "all",
							"elementType": "labels.text",
							"stylers": [
							{
								"visibility": "on"
							}
							]
						},
						{
							"featureType": "landscape",
							"elementType": "all",
							"stylers": [
							{
								"color": "#f2f2f2"
							}
							]
						},
						{
							"featureType": "landscape",
							"elementType": "geometry.fill",
							"stylers": [
							{
								"color": "#ffffff"
							}
							]
						},
						{
							"featureType": "landscape.man_made",
							"elementType": "geometry.fill",
							"stylers": [
							{
								"color": "#ffffff"
							}
							]
						},
						{
							"featureType": "poi",
							"elementType": "all",
							"stylers": [
							{
								"visibility": "off"
							}
							]
						},
						{
							"featureType": "road",
							"elementType": "all",
							"stylers": [
							{
								"saturation": -100
							},
							{
								"lightness": 45
							}
							]
						},
						{
							"featureType": "road",
							"elementType": "geometry.fill",
							"stylers": [
							{
								"color": "#eeeeee"
							}
							]
						},
						{
							"featureType": "road",
							"elementType": "labels.text.fill",
							"stylers": [
							{
								"color": "#7b7b7b"
							}
							]
						},
						{
							"featureType": "road",
							"elementType": "labels.text.stroke",
							"stylers": [
							{
								"color": "#ffffff"
							}
							]
						},
						{
							"featureType": "road.highway",
							"elementType": "all",
							"stylers": [
							{
								"visibility": "simplified"
							}
							]
						},
						{
							"featureType": "road.arterial",
							"elementType": "labels.icon",
							"stylers": [
							{
								"visibility": "off"
							}
							]
						},
						{
							"featureType": "transit",
							"elementType": "all",
							"stylers": [
							{
								"visibility": "off"
							}
							]
						},
						{
							"featureType": "water",
							"elementType": "all",
							"stylers": [
							{
								"color": "#46bcec"
							},
							{
								"visibility": "on"
							}
							]
						},
						{
							"featureType": "water",
							"elementType": "geometry.fill",
							"stylers": [
							{
								"color": "#c8d7d4"
							}
							]
						},
						{
							"featureType": "water",
							"elementType": "labels.text.fill",
							"stylers": [
							{
								"color": "#070707"
							}
							]
						},
						{
							"featureType": "water",
							"elementType": "labels.text.stroke",
							"stylers": [
							{
								"color": "#ffffff"
							}
							]
						}
						],
						mapTypeControl: true,
						mapTypeControlOptions: {
							style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
						},
						navigationControl: true,
						scrollwheel: false,
						streetViewControl: true,
					}
					if (isMobile()) {
						options.draggable = false;
					}
					var assetRoot = window.location.pathname.replace(/[^/]+$/, '') + 'assets/img/map.png';
					$('#googleMaps').gmap3({
						map: {
							options: options
						},
						marker: {
							latLng: [40.712776,-74.005974],
							options: { icon: assetRoot }

						}
					});
				}
				init_gmap();
			},

		}
	}
	jQuery(document).ready(function (){
		clinox.init();
	});

})();
