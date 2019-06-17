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

	// Pedidos
	$labels = array(
		'name'          => 'Pedidos',
		'singular_name' => 'Pedidos',
		'add_new'       => 'Nuevo pedidos',
		'add_new_item'  => 'Nuevo pedidos',
		'edit_item'     => 'Editar pedidos',
		'new_item'      => 'Nuevo pedidos',
		'all_items'     => 'Todo',
		'view_item'     => 'Ver pedidos',
		'search_items'  => 'Buscar pedidos',
		'not_found'     => 'No hay pedidos.',
		'menu_name'     => 'Pedidos'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'pedidos' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'editor' ),
		'menu_icon' 		 => 'dashicons-admin-users'
	);
	register_post_type( 'pedidos', $args );	

	// Materiales
	$labels = array(
		'name'          => 'Materiales',
		'singular_name' => 'Materiales',
		'add_new'       => 'Nuevo material',
		'add_new_item'  => 'Nuevo material',
		'edit_item'     => 'Editar material',
		'new_item'      => 'Nuevo material',
		'all_items'     => 'Todo',
		'view_item'     => 'Ver material',
		'search_items'  => 'Buscar material',
		'not_found'     => 'No hay material.',
		'menu_name'     => 'Materiales'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'materiales' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'editor' ),
	);
	register_post_type( 'materiales', $args );	

});