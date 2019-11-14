jQuery(function($){

	// Mobile Menu
	$('.menu-toggle').click(function(){
		$('.search-toggle, .search-wrap').removeClass('active');
		$('.menu-toggle, .nav-primary').toggleClass('active');
	});
	$('.menu-item-has-children > .submenu-expand').click(function(e){
		$(this).toggleClass('expanded');
		e.preventDefault();
	});

	// Search toggle
	$('.search-toggle').click(function(){
		$('.menu-toggle, .nav-primary').removeClass('active');
		$('.search-toggle, .header-search').toggleClass('active');
		$('.site-header .search-field').focus();
	});

});
