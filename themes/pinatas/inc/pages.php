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


});