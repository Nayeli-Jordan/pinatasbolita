<?php

// CUSTOM POST TYPES /////////////////////////////////////////////////////////////////


add_action('init', function(){

	// Proveedores
	$labels = array(
		'name'          => 'Proveedor',
		'singular_name' => 'Proveedor',
		'add_new'       => 'Nuevo proveedor',
		'add_new_item'  => 'Nuevo proveedor',
		'edit_item'     => 'Editar proveedor',
		'new_item'      => 'Nuevo proveedor',
		'all_items'     => 'Todo',
		'view_item'     => 'Ver proveedor',
		'search_items'  => 'Buscar proveedor',
		'not_found'     => 'No hay proveedor.',
		'menu_name'     => 'Proveedor'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'pb_proveedor' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'editor' ),
		'menu_icon' 		 => 'dashicons-admin-users'
	);
	register_post_type( 'pb_proveedor', $args );	

});