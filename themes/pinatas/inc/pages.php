<?php


// CUSTOM PAGES //////////////////////////////////////////////////////////////////////

add_action('init', function(){

	// Novedades
	if( ! get_page_by_path('novedades') ){
		$page = array(
			'post_author' => 1,
			'post_status' => 'publish',
			'post_title'  => 'Novedades',
			'post_name'   => 'novedades',
			'post_type'   => 'page'
		);
		wp_insert_post( $page, true );
	}

	// Stock
	if( ! get_page_by_path('stock-pinatas') ){
		$page = array(
			'post_author' => 1,
			'post_status' => 'publish',
			'post_title'  => 'Stock Piñatas',
			'post_name'   => 'stock-pinatas',
			'post_type'   => 'page'
		);
		wp_insert_post( $page, true );
	}

	// Alerta entregas
	if( ! get_page_by_path('alerta-entregas') ){
		$page = array(
			'post_author' => 1,
			'post_status' => 'publish',
			'post_title'  => 'Alerta entregas',
			'post_name'   => 'alerta-entregas',
			'post_type'   => 'page'
		);
		wp_insert_post( $page, true );
	}

	// Contabilidad
	if( ! get_page_by_path('contabilidad') ){
		$page = array(
			'post_author' => 1,
			'post_status' => 'publish',
			'post_title'  => 'Contabilidad',
			'post_name'   => 'contabilidad',
			'post_type'   => 'page'
		);
		wp_insert_post( $page, true );
	}
	if( ! get_page_by_path('save-registro') ){
		$page = array(
			'post_author' => 1,
			'post_status' => 'publish',
			'post_title'  => 'Guardar registro',
			'post_name'   => 'save-registro',
			'post_type'   => 'page'
		);
		wp_insert_post( $page, true );
	}

});