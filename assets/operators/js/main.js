
jQuery(document).ready(function() {

  // Header Shrink
  jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 50){  
      jQuery('.navbar').addClass("navbar-shrink");
      }
      else{
        jQuery('.navbar').removeClass("navbar-shrink");
      }
    });

});


