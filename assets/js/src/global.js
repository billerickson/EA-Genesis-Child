// @codekit-prepend "jquery.fitvids.js"
// @codekit-prepend "jquery.sidr.min.js"
// @codekit-prepend "smoothscroll.js"

jQuery(function($){

	// FitVids
	$('.entry-content').fitVids();

	// Mobile Menu
	$('.mobile-menu-toggle').sidr({
		name: 'sidr-mobile-menu',
		side: 'right',
		renaming: false,
		displace: false,
	});
	$('.menu-item-has-children').prepend('<span class="submenu-toggle">' );
	$('.menu-item-has-children.sidr-class-current-menu-item').addClass('submenu-active');
	$('.menu-item-has-children > .submenu-toggle').click(function(e){
		$(this).parent().toggleClass('submenu-active');
		e.preventDefault();
	});
	$('.sidr a').click(function(){
		$.sidr('close', 'sidr-mobile-menu');
	});
	$('.sidr-menu-close').click(function(e){
		e.preventDefault();
	});
	$(document).on( 'mouseup touchend', (function (e){
		var container = $("#sidr-mobile-menu");
		if (!container.is(e.target) && container.has(e.target).length === 0) {
			$.sidr('close', 'sidr-mobile-menu');
		}
	}));

});
