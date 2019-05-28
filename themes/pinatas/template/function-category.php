<?php 
/* Obtener categoría de producto (categoría hijo)*/
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
foreach ($terms as $term) {
	$Cat_id 		= $term->term_id; /*Category child*/
	$Cat_slug 		= $term->slug;
	$Cat_parent_id	= $term->parent;  /*Category parent id*/
	//echo 'Hijo: ' . $Cat_id . ' ' . $Cat_slug;
	break;
}
/* Obtener el slug de la categoría de producto (categoría padre)*/
if( $parent = get_term_by( 'id', $Cat_parent_id, 'product_cat' ) ){
	$Cat_parent_slug = $parent->slug;
	//echo ' <br>Padre: ' . $Cat_parent_id . ' - ' . $Cat_parent_slug;
}
?>