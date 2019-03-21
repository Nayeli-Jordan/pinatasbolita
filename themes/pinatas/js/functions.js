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
			var idCategory = $(this).parent().attr('id');
			console.log('#' + idCategory + ' p');
			$('.pb-nav li > p').removeClass('active');
			if($('#' + idCategory + ' p').hasClass('active')){
				$('#' + idCategory + ' p').removeClass('active');
			} else {
				$('#' + idCategory + ' p').addClass('active');
			}
		});		

		$(".btn-caracteristicas").click(function() {
			$('#content-ubicacion').addClass('hide');
			$('.btn-ubicacion').removeClass('active');
			if($('#content-caracteristicas').hasClass('hide')){
				$('#content-caracteristicas').removeClass('hide');
				$('.btn-caracteristicas').addClass('active');
			} else {
				$('#content-caracteristicas').addClass('hide');
				$('.btn-caracteristicas').removeClass('active');
			}
			footerBottom();
		});	
		$(".btn-ubicacion").click(function() {
			$('#content-caracteristicas').addClass('hide');
			$('.btn-caracteristicas').removeClass('active');
			if($('#content-ubicacion').hasClass('hide')){
				$('#content-ubicacion').removeClass('hide');
				$('.btn-ubicacion').addClass('active');
			} else {
				$('#content-ubicacion').addClass('hide');
				$('.btn-ubicacion').removeClass('active');
			}
			footerBottom();
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

