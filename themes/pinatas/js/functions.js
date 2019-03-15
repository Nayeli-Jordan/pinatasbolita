var $=jQuery.noConflict();
 
(function($){
	"use strict";
	$(function(){
 
		/*------------------------------------*\
			#GLOBAL
		\*------------------------------------*/

		$(document).ready(function() {
			footerBottom();
		});
 
		$(window).on('resize', function(){
			footerBottom();
		});
 
		$(document).scroll(function() {

		});
 
		// if( parseInt( isHome ) ){

		// } 

		// if( parseInt( isSingular ) ){

		// } 

		// Nav Mobile
		$("#openNav").click(function() {
			$('.js-header nav ul.pb-nav').addClass('open');
			$('body').addClass('overflow-hide');
		});
		$("#closeNav").click(function() {
			$('.js-header nav ul.pb-nav').removeClass('open');
			$('body').removeClass('overflow-hide');
		});

		//Products category
		$(".pb-nav li > p").click(function() {
			console.log('click');
			var idCategory = $(this).parent().attr('id');
			console.log('#' + idCategory + ' p');
			if($('#' + idCategory + ' p').hasClass('active')){
				$('#' + idCategory + ' p').removeClass('active');
			} else {
				$('#' + idCategory + ' p').addClass('active');
			}
			
		});		

	});
})(jQuery);
 
/**
 * Fija el footer abajo
 */
function footerBottom(){
	var alturaFooter = getFooterHeight();
	$('.main-body').css('padding-bottom', alturaFooter );
}
function getHeaderHeight(){
	return $('.js-header').outerHeight();
}// getHeaderHeight
function getFooterHeight(){
	return $('footer').outerHeight();
}// getFooterHeight

