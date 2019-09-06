$(document).ready(function(){

	var width = window.innerWidth || document.body.clientWidth;
	var $newSlick = $('.new_resources_slider');
	var $featuredSlick = $('.featured_resources_slider');

// destroy slick if you are using smart resize
// smartresize url: https://gist.github.com/Pushplaybang/3341936
// $slick.slick('unslick');

if(width < 480) {
 $newSlick.slick({
        dots: true,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
 });
 $featuredSlick.slick({
        dots: true,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
 });
} 
else
{
  $newSlick.slick({
        rows: 2,
        slidesPerRow:4,
        dots: true,
        arrows: true,
        infinite: true,
        speed: 300
 });
  $featuredSlick.slick({
        rows: 2,
        slidesPerRow:4,
        dots: true,
        arrows: true,
        infinite: true,
        speed: 300
 });
}      

   
     
    $('.testimonials_slider').slick({
		  slidesToShow: 3,
		  slidesToScroll: 1,
		  arrows: true,
		  dots: false,
		  centerMode: true,
		  variableWidth: true,
		  infinite: true,
		  focusOnSelect: true,
		  cssEase: 'linear',
		  touchMove: true,
		  prevArrow:'<button class="slick-prev">&nbsp; </button>',
		  nextArrow:'<button class="slick-next">&nbsp;</button>',
		  
		});

   });