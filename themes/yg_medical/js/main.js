(function ($) {

Drupal.behaviors.exampleModule = {
  attach: function (context, settings) {

 'use strict';
 
jQuery(document).ready(function( $ ) {
  $('.loop').owlCarousel({
    loop: true,
    margin: 10,
    responsive: {
      0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }    
    }
  });

  $('.news').owlCarousel({
    loop: true,
    margin: 10,
    dots: false,
    nav: true,
    responsive: {
      0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }    
    }
  });
   $(document).ready(function() {
      $('#datetimepicker1').datepicker({
        language: 'pt-BR'
      });
      });

      $('.region').removeClass('row')

  });

}}})(jQuery, Drupal);

   


// jQuery(window).scroll(function(){
//     var scroll = $(window).scrollTop();
//     if (scroll >= 100) {
//         $("#header").addClass("sticky");
//     } else {
//         $("#header").removeClass("sticky");
//     }
// });



