var $=jQuery.noConflict();
 
(function($){
	"use strict";
	$(function(){
 
		/*------------------------------------*\
			#GLOBAL
		\*------------------------------------*/

		$(document).ready(function() {
			footerBottom();

			/* #comprar */
			if(window.location.href.indexOf("#comprar") > -1) {
				$('html, body').animate({		
					scrollTop: $('.btn-dcomprar').offset().top // - 50
				}, 1000);
				$( ".btn-dcomprar" ).click();
			}
			/* #distribuidores */
			if(window.location.href.indexOf("#distribuidores") > -1) {
				$('html, body').animate({		
					scrollTop: $('.btn-distribuidores').offset().top // - 50
				}, 1000);
				$( ".btn-distribuidores" ).click();
			}

			/* Si se guardo el cliente */
			if(window.location.href.indexOf("#cliente_creado") > -1) {
				$('#notice-nuevo-cliente').show();
			}
			/* Si se actualizo el cliente */
			if(window.location.href.indexOf("#cliente_actualizado") > -1) {
				$('#notice-cliente-actualizado').show();
			}

			/* Si se guardo el pedido */
			if(window.location.href.indexOf("#pedido_creado") > -1) {
				$('#notice-nuevo-pedido').show();
			}
			/* Si se actualizo el cliente */
			if(window.location.href.indexOf("#material_actualizado") > -1) {
				$('#notice-material-actualizado').show();
			}
			/* Si se actualizo el pedido */
			if(window.location.href.indexOf("#pedido_actualizado") > -1) {
				$('#notice-pedido-actualizado').show();
			}
			/* Si se cerro el pedido */
			if(window.location.href.indexOf("#pedido_cerrado") > -1) {
				$('#notice-pedido-cerrado').show();
			}
			/* Si se actualiza el stock */
			if(window.location.href.indexOf("#stock_actualizado") > -1) {
				$('#notice-stock-actualizado').show();
			}
			/* Si se guardo el material */
			if(window.location.href.indexOf("#material_creado") > -1) {
				$('#notice-nuevo-material').show();
			}
			/* Si se envio el email de solicitud de material */
			if(window.location.href.indexOf("#material_solicitado") > -1) {
				$('#notice-material-solicitado').show();
			}
			/* Si se envio la cuenta */
			if(window.location.href.indexOf("#ingreso_creado") > -1) {
				$('#notice-nuevo-ingreso').show();
			}
			if(window.location.href.indexOf("#egreso_creado") > -1) {
				$('#notice-nuevo-egreso').show();
			}
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
			$('#content-ubicacion, #content-proveedores').addClass('hide');
			$('.btn-dcomprar, .btn-distribuidores').removeClass('active');
			if($('#content-caracteristicas').hasClass('hide')){
				$('#content-caracteristicas').removeClass('hide');
				$('.btn-caracteristicas').addClass('active');
			} else {
				$('#content-caracteristicas').addClass('hide');
				$('.btn-caracteristicas').removeClass('active');
			}
			footerBottom();
		});	
		$(".btn-dcomprar").click(function() {
			$('#content-caracteristicas, #content-proveedores').addClass('hide');
			$('.btn-caracteristicas, .btn-distribuidores').removeClass('active');
			if($('#content-ubicacion').hasClass('hide')){
				$('#content-ubicacion').removeClass('hide');
				$('.btn-dcomprar').addClass('active');
			} else {
				$('#content-ubicacion').addClass('hide');
				$('.btn-dcomprar').removeClass('active');
			}
			footerBottom();
		});	
		$(".btn-distribuidores").click(function() {
			$('#content-caracteristicas, #content-ubicacion').addClass('hide');
			$('.btn-caracteristicas, .btn-dcomprar').removeClass('active');
			if($('#content-proveedores').hasClass('hide')){
				$('#content-proveedores').removeClass('hide');
				$('.btn-distribuidores').addClass('active');
			} else {
				$('#content-proveedores').addClass('hide');
				$('.btn-distribuidores').removeClass('active');
			}
			footerBottom();
		});	

		//Scroll menú
		$(".btn-scroll").click(function() { 
			$('html, body').animate({		
				scrollTop: $('.info-footer').offset().top // - 50
			}, 1000);
		});	

		
		// Modal
		$(".open-modal").click(function() {
			var idModal = $(this).attr('id');
			$('#modal-' + idModal).show();
			$('body').addClass('overflow-hide');
		});
		$(".close-modal, .exit-modal").click(function() {
			console.log('click');
			$('.modal').hide();
			$('body').removeClass('overflow-hide');
		});
		$(".modal form input[type='submit']").click(function() {
			$('#modal-cargando').show();
			$('body').addClass('overflow-hide');
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

