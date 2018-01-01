/* Copyright (C) YOOtheme GmbH, YOOtheme Proprietary Use License (http://www.yootheme.com/license) */

(function($){

	$(document).ready(function() {

		var config = $('body').data('config') || {},
			settings = {};

		// Accordion menu
		$('.menu-sidebar').accordionMenu({ mode:'slide' });

		// Dropdown menu
		$('#menu').dropdownMenu({ mode: 'slide', duration: 300, dropdownSelector: 'div.dropdown'});

		// Smoothscroller
		$('a[href="#page"]').smoothScroller({ duration: 500 });

		// Fix Browser Rounding
		$('.grid-block').matchWidth('.grid-h');

		// Social buttons
		$('article[data-permalink]').socialButtons(config);

		// Match height of div tags
		var matchHeight = function(){
			$('#top-a .grid-h').matchHeight('.deepest');
			$('#top-b .grid-h').matchHeight('.deepest');
			$('#bottom-a .grid-h').matchHeight('.deepest');
			$('#bottom-b .grid-h').matchHeight('.deepest');
			$('#innertop .grid-h').matchHeight('.deepest');
			$('#innerbottom .grid-h').matchHeight('.deepest');
			$('#maininner, #sidebar-a, #sidebar-b').matchHeight();
			$('.page-body-1').css("min-height", $(window).height());
		};

		matchHeight();

		if(config["animatedbg"]){

			switch(config["animatedbg"]){
				case "red":
					settings = {
						bgcolor: "#ae000c",
						fallback: WarpThemePath + "/images/background/animated/animated_red.jpg"
					};
					break;

				default:
					settings = {
						bgcolor: "#234564", // background color
						fallback: WarpThemePath + "/images/background/animated/animated_default.jpg"
					};
			}

			$("body").prepend('<div id="webgl" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:-1;background-color:'+settings.bgcolor+';background-size:cover;"></div>');

			$("#webgl").css({ "background-image": 'url('+settings.fallback+')' });

		}

		// Socialbar for touch devices
		$(window).bind("load", matchHeight);

		if ("ontouchend" in document) {
			var socialbar = $("#socialbar").bind("click", function(){
				if (socialbar.hasClass("touched")) {
					socialbar.removeClass("touched").addClass("untouched");
				} else {
					socialbar.removeClass("untouched").addClass("touched");
				}
			});
		}

	});

})(jQuery);
