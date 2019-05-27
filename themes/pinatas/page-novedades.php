<?php get_header(); ?>
<div id="product-novedades" class="sliderProduct">
	<section class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-timeout="0" data-cycle-slides="> article" data-cycle-prev="#prevProducts" data-cycle-next="#nextProducts">
		<?php
		    $args = array(
		        'post_type' 		=> 'product',
		        'posts_per_page' 	=> -1,
		        'tax_query' 		=> array(
	                array(
	                    'taxonomy' => 'product_cat',
	                    'field'    => 'slug',
	                    'terms'    => 'princesas'
	                ),	                    
	            ),
	        );
		    $loop = new WP_Query( $args );
		    $i = 1;
		    if ( $loop->have_posts() ) {
		        while ( $loop->have_posts() ) : $loop->the_post(); 
		        	if(3 == $i){ echo "<article>";}

		        		include (TEMPLATEPATH . '/template/content-product.php');

		        	if(3 == $i){ echo "</article>";}
		        $i ++; endwhile;
		    } wp_reset_postdata(); ?>
	</section> <!-- end cycle-slideshow -->
	<a href=# id="prevProducts" class=""><img src="<?php echo THEMEPATH; ?>images/arrow.png"><span>Anterior</span></a> 
	<a href=# id="nextProducts" class=""><img src="<?php echo THEMEPATH; ?>images/arrow.png"><span>Siguiente</span></a>	
</div>
<?php get_footer(); ?>