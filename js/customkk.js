

jQuery(document).ready(function(){
	//powertpowert
	var selectImg = '#main';
	if(!(jQuery.browser.opera || jQuery.browser.msie)){
  jQuery('#main').kriesi_image_preloader({delay:100, callback:removeloader});
}// activates preloader for non-slideshow images
});







