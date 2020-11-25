// JavaScript Document

jQuery(function(){
  jQuery('.menu-trigger').on('click',function(){
    if(jQuery(this).hasClass('active')){
      jQuery(this).removeClass('active');
      jQuery('nav').removeClass('open');
      jQuery('.overlay').removeClass('open');
        jQuery('html').removeClass('is-fixed');
    } else {
      jQuery(this).addClass('active');
      jQuery('nav').addClass('open');
      jQuery('.overlay').addClass('open');
        jQuery('html').addClass('is-fixed');
    }
  });
  jQuery('.overlay').on('click',function(){
    if(jQuery(this).hasClass('open')){
      jQuery(this).removeClass('open');
      jQuery('.menu-trigger').removeClass('active');
      jQuery('nav').removeClass('open');      
        jQuery('html').removeClass('is-fixed');
    }
  });
});




