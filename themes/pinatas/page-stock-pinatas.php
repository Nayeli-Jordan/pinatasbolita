<?php get_header(); 
	/* Modals notice */
	include (TEMPLATEPATH . '/template/sistema/notice/notice-nuevo-cliente.php');
	if (have_posts()) : while (have_posts()) : the_post();?>
		<section class="[ container ] text-shadow-gray color-light padding-bottom-100">
			<div class="text-right margin-bottom-20">
				<p id="nuevo-pedido" class="btn btn-primary margin-left-right-10 open-modal">Nuevo pedido</p>
			</div>
			<?php include (TEMPLATEPATH . '/template/sistema/modal-nuevo-pedido.php'); ?>
			<table class="table-sistema table-head_desktop">
				<!-- Large and up -->
				<?php include (TEMPLATEPATH . '/template/sistema/stock-pinatas-thead.php'); ?>		
			</table>
			<div id="content_table">
				<table class="table-sistema table-head_mobile table-stock">
					<!-- Medium and down -->
					<?php include (TEMPLATEPATH . '/template/sistema/stock-pinatas-thead.php'); ?>
					<tbody>
					<?php
				        $args = array(
				            'post_type' => 'product',
				            'posts_per_page' => -1,
				            'orderby' => 'title',
				            'order' => 'ASC'
				        );
				        $loop = new WP_Query( $args );
				        if ( $loop->have_posts() ) { 
				        	global $product; $count = 0; $disponibles = 0;
				            while ( $loop->have_posts() ) : $loop->the_post(); 
								/* Obtener info del producto y guardarla en variables */
				            	$post_id        = get_the_ID();
				            	//$productSlug	= $post->post_name;
								$product 		= wc_get_product( $post_id );
								$productName 	= get_the_title( $post_id );

								$price 			= $product->get_regular_price();
								$stock			= $product->get_stock_quantity(); 
								$image 			= wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID), 'medium' ); 

								/* Obtener precios especiales */
								if ($price === '') { $price = 0; } /* Sin precio */
								$priceOnePercent= $price / 100;
								$pricePlata 	= $price - ($priceOnePercent * 10);
								$priceOro 		= $price - ($priceOnePercent * 20);

								/* Agregar a totales tabla */
								$disponibles	= $disponibles + $stock;
								?>

								<tr>
									<td><img class="img-pinata" src="<?php echo $image[0]; ?>"><?php echo $productName; ?></td>
									<td class="text-center">$<?php echo $price; ?></td>
									<td class="text-center">$<?php echo $pricePlata; ?></td>
									<td class="text-center">$<?php echo $priceOro; ?></td>
									<td></td>
									<td></td>
									<td class="text-center"><?php echo $stock ?></td>
									<td class="text-center"></td>
								</tr>

				            <?php $count++; endwhile;
						} wp_reset_postdata(); ?>
					</tbody>					
					<!-- Medium and down -->
					<?php include (TEMPLATEPATH . '/template/sistema/stock-pinatas-tfoot.php'); ?>
				</table>				
			</div>
			<table class="table-sistema table-foot_desktop">
				<!-- Lanrge and up -->
				<?php include (TEMPLATEPATH . '/template/sistema/stock-pinatas-tfoot.php'); ?>		
			</table>
		</section>
		<section class="[ container ] text-shadow-gray color-light padding-bottom-100">
			<div class="text-right margin-bottom-20">
				<p id="nuevo-cliente" class="btn btn-primary margin-left-right-10 open-modal">Nuevo cliente</p>
			</div>
			<?php include (TEMPLATEPATH . '/template/sistema/clientes/modal-nuevo-cliente.php'); ?>	
			<table class="table-sistema table-head_desktop">
				<!-- Lanrge and up -->
				<?php include (TEMPLATEPATH . '/template/sistema/clientes/stock-clientes-thead.php'); ?>		
			</table>
			<div id="content_table">
				<table class="table-sistema table-head_mobile table-clientes">
					<!-- Medium and down -->
					<?php include (TEMPLATEPATH . '/template/sistema/clientes/stock-clientes-thead.php'); ?>
					<tbody>
					<?php
				        $args = array(
				            'post_type' 		=> 'clientes',
				            'posts_per_page' 	=> -1,
				            'orderby'			=> 'title',
				            'order' 			=> 'ASC'
				        );
				        $loop = new WP_Query( $args );
				        if ( $loop->have_posts() ) { 
				        	$clients = 0;
				            while ( $loop->have_posts() ) : $loop->the_post();
		   						$post_id 	= get_the_ID();
								$nivel   	= get_post_meta( $post_id, 'clientes_nivel', true );
								$correo   	= get_post_meta( $post_id, 'clientes_correo', true );
								$cel   		= get_post_meta( $post_id, 'clientes_cel', true );
								$tel   		= get_post_meta( $post_id, 'clientes_tel', true );
								$direccion  = get_post_meta( $post_id, 'clientes_direccion', true ); ?>

								<tr>
									<td><?php the_title(); ?></td>
									<td><?php if ($nivel != '') { echo $nivel; } ?></td>
									<td><?php 
										if ($direccion != '') { echo $direccion . '</br>'; }
										if ($correo != '') { echo '• ' . $correo . '</br>'; }
										if ($cel != '') { echo '• ' . $cel . ' '; }
										if ($tel != '') { echo '• ' . $tel . '</br>'; }
									?></td>
									<td><?php the_content(); ?></td>
									<td></td>
								</tr>

				            <?php $clients++; endwhile;
						} wp_reset_postdata(); ?>
					</tbody>					
					<!-- Medium and down -->
					<?php include (TEMPLATEPATH . '/template/sistema/clientes/stock-clientes-tfoot.php'); ?>
				</table>				
			</div>
			<table class="table-sistema table-foot_desktop">
				<!-- Large and up -->
				<?php include (TEMPLATEPATH . '/template/sistema/clientes/stock-clientes-tfoot.php'); ?>		
			</table>
		</section>
	<?php endwhile; endif; 
get_footer(); ?>