jQuery(function(a){
// Smooth Scroll
function e(e){var n=null;try{n=a(e)}catch(e){
// Perhaps worth adding some error logging here in the future.
return!1}if((n=n.length?n:a("[name="+this.hash.slice(1)+"]")).length){var t=0;return"fixed"==a(".site-header").css("position")&&(t=a(".site-header").height()),a("body").hasClass("admin-bar")&&(t+=a("#wpadminbar").height()),a("html,body").animate({scrollTop:n.offset().top-t},1e3),!1}}
// -- Smooth scroll on pageload
window.location.hash&&e(window.location.hash),
// -- Smooth scroll on click
a('a[href*="#"]:not([href="#"]):not(.no-scroll)').click(function(){location.pathname.replace(/^\//,"")!=this.pathname.replace(/^\//,"")&&location.hostname!=this.hostname||e(this.hash)})}),// @codekit-prepend "smoothscroll.js"
jQuery(function(e){
// Mobile menu
e(".mobile-menu-toggle").click(function(){e("body").toggleClass("mobile-menu-expanded")}),e(".submenu-expand").click(function(){e(this).parent().toggleClass("submenu-active")})});