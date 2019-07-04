<?php

// CUSTOM POST TYPES /////////////////////////////////////////////////////////////////


add_action('init', function(){

	// Proveedores
	$labels = array(
		'name'          => 'Distribuidor',
		'singular_name' => 'Distribuidor',
		'add_new'       => 'Nuevo distribuidor',
		'add_new_item'  => 'Nuevo distribuidor',
		'edit_item'     => 'Editar distribuidor',
		'new_item'      => 'Nuevo distribuidor',
		'all_items'     => 'Todo',
		'view_item'     => 'Ver distribuidor',
		'search_items'  => 'Buscar distribuidor',
		'not_found'     => 'No hay distribuidor.',
		'menu_name'     => 'Distribuidor'
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
		'menu_icon' 		 => 'dashicons-groups'
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
		'menu_icon' 		 => 'dashicons-clipboard'
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
		'menu_icon' 		 => 'dashicons-art'
	);
	register_post_type( 'materiales', $args );	

	// Contabilidad
	$labels = array(
		'name'          => 'Contabilidad',
		'singular_name' => 'Contabilidad',
		'add_new'       => 'Nueva cuenta',
		'add_new_item'  => 'Nueva cuenta',
		'edit_item'     => 'Editar cuenta',
		'new_item'      => 'Nueva cuenta',
		'all_items'     => 'Todo',
		'view_item'     => 'Ver cuenta',
		'search_items'  => 'Buscar cuenta',
		'not_found'     => 'No hay cuenta.',
		'menu_name'     => 'Contabilidad'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'cuenta' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array( 'title' ),
		'menu_icon' 		 => 'dashicons-chart-area'
	);
	register_post_type( 'cuenta', $args );	

	// Registro
	$labels = array(
		'name'          => 'Registro',
		'singular_name' => 'Registro',
		'add_new'       => 'Nuevo registro',
		'add_new_item'  => 'Nuevo registro',
		'edit_item'     => 'Editar registro',
		'new_item'      => 'Nuevo registro',
		'all_items'     => 'Registros',
		'view_item'     => 'Ver registro',
		'search_items'  => 'Buscar registro',
		'not_found'     => 'No hay registro.',
		'menu_name'     => 'Registro'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'registro' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'editor' ),
		'menu_icon' 		 => 'dashicons-chart-area'
	);
	register_post_type( 'registro', $args );	

});