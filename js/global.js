jQuery(document).ready(function($){

	// FitVids
	$('.entry-content').fitVids();

	// Content and Sidebar, Equal Heights
	function sidebar_height() {
		var sidebarHeight = $(".sidebar-primary").outerHeight();
		var bodyHeight = $(".content-sidebar-wrap > .content").outerHeight();
	
		if ( bodyHeight > sidebarHeight) {
			$(".sidebar-primary").css( 'min-height', bodyHeight );
		};
	}
	$('body').one('load', sidebar_height);
	
/*	
	// Footer Widgets, Equal Heights
	function footer_widget_height() {
        if(window.innerWidth < 767) {
            $('.footer-widgets .widget-area').height('auto');
        } else {
            $('.footer-widgets .widget-area').equalHeights();
        }
    }
    footer_widget_height();
    $(window).resize(footer_widget_height);
*/

});
