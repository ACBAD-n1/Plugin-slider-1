// Can also be used with $(document).ready()
jQuery(window).on('load', function() {
  jQuery('.flexslider').flexslider({
      animation: "slide",
      touch: true,
      directionNav: false,
      smoothHeight: true,
      controlNav: true //SLIDER_OPTIONS.controlNav,

    });
  });