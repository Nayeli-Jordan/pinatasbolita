<?php get_header(); ?>
	<section class="padding-top-60 padding-bottom-80 text-center">
		<div class="bg-ruleta_indicador"></div>
		<span class="content-ruleta inline-block relative">
			<div class="bg-ruleta_centro"></div>
			<img src="<?php echo THEMEPATH; ?>images/ruleta-base.png" class="img-ruleta_base">
			<div class="bg-ruleta_opciones">
				<?php $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'princesas', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_1" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Princesas"><span class="hide">Princesas</span></a>
				<?php endwhile;  wp_reset_query(); 

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'heroes', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_2" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Héroes"><span class="hide">Héroes</span></a>
				<?php endwhile;  wp_reset_query();

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'television', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_3" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Televisión"><span class="hide">Televisión</span></a>
				<?php endwhile;  wp_reset_query(); 

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'cine', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_4" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Cine"><span class="hide">Cine</span></a>
				<?php endwhile;  wp_reset_query(); 

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'video-juegos', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_5" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Video Juegos"><span class="hide">Video Juegos</span></a>
				<?php endwhile;  wp_reset_query(); 

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'otros', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_6" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Otros"><span class="hide">Otros</span></a>
				<?php endwhile;  wp_reset_query(); 

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'animales', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_7" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Animales"><span class="hide">Animales</span></a>
				<?php endwhile;  wp_reset_query(); 

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'mexicanas', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_8" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Mexicanas"><span class="hide">Mexicanas</span></a>
				<?php endwhile;  wp_reset_query(); 

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'dia-de-muertos', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_9" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Día de Muertos"><span class="hide">Día de Muertos</span></a>
				<?php endwhile;  wp_reset_query(); 

				$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => 'navidad', 'orderby' => 'rand' );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				    <a id="ruleta_link_10" href="<?php echo get_permalink( $loop->post->ID ) ?>"  title="Enlace a Navidad"><span class="hide">Navidad</span></a>
				<?php endwhile;  wp_reset_query(); ?>
			</div>
			<a id="ruleta_pinatas" href="<?php echo SITEURL; ?>"></a>
			<a id="ruleta_pedidos" href="<?php echo SITEURL; ?>"></a>
		</span>
	</section>
<?php get_footer(); ?>