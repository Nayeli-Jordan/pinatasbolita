<?php


// TAXONOMIES ////////////////////////////////////////////////////////////////////////
add_action( 'init', 'custom_taxonomies_callback', 0 );
function custom_taxonomies_callback(){

	// 
	// if( ! taxonomy_exists('servicio')){

	// 	$labels = array(
	// 		'name'              => 'Servicio del paquete',
	// 		'singular_name'     => 'Servicio del paquete',
	// 		'search_items'      => 'Buscar',
	// 		'all_items'         => 'Todos',
	// 		'edit_item'         => 'Editar servicio',
	// 		'update_item'       => 'Actualizar servicio',
	// 		'add_new_item'      => 'Nueva servicio',
	// 		'menu_name'         => 'Servicio del paquete'
	// 	);
	// 	$args = array(
	// 		'hierarchical'      => true,
	// 		'labels'            => $labels,
	// 		'show_ui'           => true,
	// 		'show_admin_column' => true,
	// 		'show_in_nav_menus' => true,
	// 		'query_var'         => true,
	// 		'rewrite'           => array( 'slug' => 'servicio' ),
	// 	);

	// 	register_taxonomy( 'servicio', 'paquete', $args );
	// }	

}