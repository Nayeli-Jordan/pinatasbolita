<?php get_header(); ?>
<div id="product-novedades" class="sliderProduct">
	<section class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-timeout="0" data-cycle-slides="> article" data-cycle-prev="#prevProducts" data-cycle-next="#nextProducts">
		<?php
		    $args = array(
		        'post_type' 		=> 'product',
		        'posts_per_page' 	=> 15,
		        'orderby'			=> 'rand',
			    'date_query'    	=> array(
			        'column'  	=> 'post_date',
			        'after'   	=> '- 90 days'
			    )
	        );
		    $loop = new WP_Query( $args );
		    $i = 1;
		    if ( $loop->have_posts() ) {
		        while ( $loop->have_posts() ) : $loop->the_post(); 
		        	if($i === 1 || $i === 4 || $i === 7 || $i === 10 || $i === 13){
		        		echo "<article>";
		        	}

		        		include (TEMPLATEPATH . '/template/content-product.php');

		        	if($i === 3 || $i === 6 || $i === 9 || $i === 12|| $i === 15){
		        		echo "</article>";
		        	}
		        $i ++; endwhile;
		        if($i != 3 || $i != 6 || $i != 9 || $i != 12|| $i != 15){
	        		echo "</article>";
	        	}
		    } wp_reset_postdata(); ?>
	</section> <!-- end cycle-slideshow -->
	<?php if($i > 4): ?>
		<a href=# id="prevProducts" class=""><img src="<?php echo THEMEPATH; ?>images/arrow.png"><span>Anterior</span></a> 
		<a href=# id="nextProducts" class=""><img src="<?php echo THEMEPATH; ?>images/arrow.png"><span>Siguiente</span></a>
<?php endif; ?>
</div>
<?php get_footer(); ?>