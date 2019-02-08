// @codekit-prepend "smoothscroll.js"

jQuery(function($){

	// Mobile menu
	$('.mobile-menu-toggle').click(function(){
		$('body').toggleClass('mobile-menu-expanded');
	});
	$('.submenu-expand').click(function(){
		$(this).parent().toggleClass('submenu-active');
	});
	
});
