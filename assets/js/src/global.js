// @codekit-prepend "smoothscroll.js"

jQuery(function($){

	// Mobile Menu
	$('.mobile-menu-toggle').click(function(){
		$('.mobile-menu-toggle, .nav-primary').toggleClass('active');
	});
	$('.menu-item-has-children > .submenu-expand').click(function(e){
		$(this).toggleClass('expanded');
		e.preventDefault();
	});

});
