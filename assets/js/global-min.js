jQuery(function(e){
// Smooth Scroll
function t(t){var a=null;try{a=e(t)}catch(t){
// Perhaps worth adding some error logging here in the future.
return!1}if((a=a.length?a:e("[name="+this.hash.slice(1)+"]")).length){var n=0;return"fixed"==e(".site-header").css("position")&&(n=e(".site-header").height()),e("body").hasClass("admin-bar")&&(n+=e("#wpadminbar").height()),e("html,body").animate({scrollTop:a.offset().top-n},1e3),!1}}
// -- Smooth scroll on pageload
window.location.hash&&t(window.location.hash),
// -- Smooth scroll on click
e('a[href*="#"]:not([href="#"]):not(.no-scroll)').click(function(){location.pathname.replace(/^\//,"")!=this.pathname.replace(/^\//,"")&&location.hostname!=this.hostname||t(this.hash)})}),// @codekit-prepend "smoothscroll.js"
jQuery(function(t){});