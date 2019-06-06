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

	// Clientes
	$labels = array(
		'name'          => 'Clientes',
		'singular_name' => 'Clientes',
		'add_new'       => 'Nuevo clientes',
		'add_new_item'  => 'Nuevo clientes',
		'edit_item'     => 'Editar clientes',
		'new_item'      => 'Nuevo clientes',
		'all_items'     => 'Todo',
		'view_item'     => 'Ver clientes',
		'search_items'  => 'Buscar clientes',
		'not_found'     => 'No hay clientes.',
		'menu_name'     => 'Clientes'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'clientes' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'editor' ),
		'menu_icon' 		 => 'dashicons-admin-users'
	);
	register_post_type( 'clientes', $args );	

});