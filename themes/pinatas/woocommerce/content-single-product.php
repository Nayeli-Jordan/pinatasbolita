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

/* ID single product */
$productID = $post->ID;

/* Categoría padre e hijos del producto */
$categories = get_the_terms( get_the_ID(), 'product_cat' );
if ( $categories && ! is_wp_error( $category ) ) : 
	foreach($categories as $category) :
		// Obtener ID categoría padre
		$parentId 		= $category->parent;
		
		if ($parentId == 0) {
			/* Si no hay padre entonces ya es categoría padre*/
			$categoryId = $category->term_id;
			/* Slug categoría padre */
			if( $term = get_term_by( 'id', $categoryId, 'product_cat' ) ){
				$catParent = $term->slug;
				//echo 'Categoría: ' . $categoryId . ' - ' . $catParent;
			}
			/* No hay categoría hijo */
			$finalHijo 		= 0; 
			$finalHijoId 	= 0;		
		} else {
			/* Slug categoría padre */
			if( $term = get_term_by( 'id', $parentId, 'product_cat' ) ){
				$catParent = $term->slug;
				//echo 'Padre: ' . $parentId . ' - ' . $catParent;
			}
		}

		// Saber si es la categoría del url actual
		//$urlSite 		= '$_SERVER["REQUEST_URI"]';
		$urlSite 		= 'video-juegos';
		$currentCat 	= strpos($urlSite, $catParent);
		if ($currentCat !== false) {
			/* $catParent sí es la categoría actual (url) */
			$finalCatParent 	= $catParent;

			if ($parentId != 0){
				$finalCatParentId 	= $parentId;

				//Obtener categoría hijo
				$children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $finalCatParent ));
				if ( count($children) == 0 ) {
					//echo '</br>Hijo: ' . $category->term_id . ' - ' . $category->slug;
					$finalHijo 		= $category->slug;
					$finalHijoId	= $category->term_id;
				} else {
					$finalHijo 		= 0; /* No hay categoría hijo */
					$finalHijoId 	= 0;
				}
				//echo "</br><br>";
				break; /* Si ya hay subcategoría, salir */				
			} else {
				$finalCatParentId 	= $categoryId;
			}
		}
	endforeach;
endif; 

/* Resultado final */
/*echo "<br><br>";
echo 'Padre final: '. $finalCatParentId . ' - ' . $finalCatParent . '</br>';
echo 'Hijo final: ' . $finalHijoId . ' - ' . $finalHijo . '</br></br>';*/

// Declarar array con categorías que se excluirán para productos sueltos
$excludeCats = array(); ?>

<div id="product-<?php the_ID(); ?>" class="sliderProduct">
	<section class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-timeout="0" data-cycle-slides="> article" data-cycle-prev="#prevProducts" data-cycle-next="#nextProducts">
		
		<?php
		if ($finalHijoId != 0) {
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
		                    'terms'    => $finalHijoId,
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
			    //include (TEMPLATEPATH . '/template/content-product_palazo.php');
			echo "</article>";

			//Agregar categoría a excluir
			array_push($excludeCats, $finalHijo);
		} else {
			echo "<article class='item-principal'>";
				/* Si producto NO tiene categoría hijo */
				// Img producto principal
				include (TEMPLATEPATH . '/template/content-product.php');
			    // Palazo
			    //include (TEMPLATEPATH . '/template/content-product_palazo.php');
			echo "</article>";
		}

		/* Obtener las demás subcategorías del padre ($finalCatParent) */
		$args = array(
		        'taxonomy'     		=> 'product_cat',
		        'child_of'     		=> 0,
		        'parent'       		=> $finalCatParentId,
		        'hide_empty'   		=> 0,
		        'exclude'    		=> $finalHijoId,
		);
		$sub_cats = get_categories( $args );
		if($sub_cats) {
		    foreach($sub_cats as $sub_category) {
		        $subCategory = $sub_category->slug;

				//Excluir categoría para productos sueltos
				//Agregar categoría a excluir
				array_push($excludeCats, $subCategory);

		        /* Obtener slide con hasta 3 productos por subcategoría extra */
		        $args = array(
			        'post_type' 		=> 'product',
			        'posts_per_page' 	=> 3,
		        	/* 'post__not_in' 		=> array($productID), No mostrar principal si esta en más de una subcategoría */
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
		} 

		/* Obtener productos que no tienen subcategoría (sueltos), excluirlas */
		// print_r($excludeCats);
		$args = array(
		    'post_type' 		=> 'product',
		    'posts_per_page' 	=> -1,
		    'post__not_in' 		=> array($productID), /* Excluir producto principal*/
		    'tax_query' 		=> array(
		        array(
		            'taxonomy' => 'product_cat',
		            'field'    => 'term_id',
		            'terms'    => $finalCatParentId,
		            'operator' => 'IN'
		        ),
		        array(
		            'taxonomy' => 'product_cat',
		            'field'    => 'slug',
		            'terms'    => $excludeCats,
		            'operator' => 'NOT IN'
		        ),	
		    ),
		);
		$loop = new WP_Query( $args );
		$i = 1;
		if ( $loop->have_posts() ) {
		    while ( $loop->have_posts() ) : $loop->the_post(); ?>
				
				<article class="item-individual"><?php include (TEMPLATEPATH . '/template/content-product.php'); ?></article>

		    <?php $i ++; endwhile;
		} wp_reset_postdata(); ?>

	</section> <!-- end cycle-slideshow -->
	<a href=# id="prevProducts" class=""><img src="<?php echo THEMEPATH; ?>images/arrow.png"><span>Anterior</span></a> 
	<a href=# id="nextProducts" class=""><img src="<?php echo THEMEPATH; ?>images/arrow.png"><span>Siguiente</span></a>	
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>