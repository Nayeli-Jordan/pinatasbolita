<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

/* Obtener categorías de producto */
include (TEMPLATEPATH . '/template/function-category.php');

/* ID single product */
$productID = $post->ID; 

/* Nota: No se mostraran productos sueltos que no estén en alguna subcategoría */ ?>

<div id="product-<?php the_ID(); ?>" class="sliderProduct">
	<section class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-timeout="0" data-cycle-slides="> article" data-cycle-prev="#prevProducts" data-cycle-next="#nextProducts">
		
		<?php
		/* Si producto tiene categoría hijo */
		echo "<article class='item-principal'>";
			// Img producto principal
			include (TEMPLATEPATH . '/template/content-product.php');
			// Img´s productos de la misma categoría hijo
		    $args = array(
		        'post_type' 		=> 'product',
		        'posts_per_page' 	=> 3,
		        'post__not_in' 		=> array($productID),
		        'tax_query' 		=> array(
	                array(
	                    'taxonomy' => 'product_cat',
	                    'field'    => 'term_id',
	                    'terms'    => $Cat_id,
	                    'operator' => 'IN'
	                ),	                    
	            ),
	        );
		    $loop = new WP_Query( $args );
		    $i = 1;
		    if ( $loop->have_posts() ) {
		        while ( $loop->have_posts() ) : $loop->the_post(); 

		        	include (TEMPLATEPATH . '/template/content-product.php');

		        $i ++; endwhile;
		    } wp_reset_postdata();
		    // Palazo
		    include (TEMPLATEPATH . '/template/content-product_palazo.php');
		echo "</article>";

		/* Obtener las demás subcategorías del padre ($finalCatParent) */
		$args = array(
		        'taxonomy'     		=> 'product_cat',
		        'child_of'     		=> 0,
		        'parent'       		=> $Cat_parent_id,
		        'hide_empty'   		=> 0,
		        'exclude'    		=> $Cat_id,
		);
		$sub_cats = get_categories( $args );
		if($sub_cats) {
		    foreach($sub_cats as $sub_category) {
		        $subCategory = $sub_category->slug;
		        /* Obtener slide con hasta 3 productos por subcategoría extra */
		        $args = array(
			        'post_type' 		=> 'product',
			        'posts_per_page' 	=> 3,
			        'tax_query' 		=> array(
		                array(
		                    'taxonomy' => 'product_cat',
		                    'field'    => 'slug',
		                    'terms'    => $subCategory,
		                    'operator' => 'IN'
		                ),	                    
		            ),
		        );
			    $loop = new WP_Query( $args );
			    $i = 1;
			    if ( $loop->have_posts() ) {
					echo "<article class='item-subcategory'>";
				        while ( $loop->have_posts() ) : $loop->the_post(); 
				        	
				        	include (TEMPLATEPATH . '/template/content-product.php');

				        $i ++; endwhile;
					echo "</article>";
			    } wp_reset_postdata();
		    }
		} ?>

	</section> <!-- end cycle-slideshow -->
	<a href=# id="prevProducts" class=""><img src="<?php echo THEMEPATH; ?>images/arrow.png"><span>Anterior</span></a> 
	<a href=# id="nextProducts" class=""><img src="<?php echo THEMEPATH; ?>images/arrow.png"><span>Siguiente</span></a>	
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>