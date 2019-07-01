<?php get_header(); 
	/* Modals notice */
	include (TEMPLATEPATH . '/template/sistema/load.php');
	include (TEMPLATEPATH . '/template/sistema/notice/notice-nuevo-pedido.php');
	include (TEMPLATEPATH . '/template/sistema/notice/notice-nuevo-cliente.php');
	include (TEMPLATEPATH . '/template/sistema/notice/notice-stock-actualizado.php');
	include (TEMPLATEPATH . '/template/sistema/notice/notice-nuevo-material.php');
	if (have_posts()) : while (have_posts()) : the_post();?>
		<section class="[ container ] color-light padding-bottom-100">
			<div class="text-right margin-bottom-20">
				<p id="actualizar-stock" class="btn btn-primary margin-left-right-10 open-modal">Actualizar stock</p>
				<p id="nuevo-pedido" class="btn btn-primary margin-left-right-10 open-modal">Nuevo pedido</p>
			</div>
			<?php 
				include (TEMPLATEPATH . '/template/sistema/pedido/modal-nuevo-pedido.php'); 
				include (TEMPLATEPATH . '/template/sistema/pedido/modal-actualizar-stock.php'); ?>
			<table class="table-sistema table-head_desktop">
				<!-- Large and up -->
				<?php include (TEMPLATEPATH . '/template/sistema/pedido/stock-pinatas-thead.php'); ?>		
			</table>
			<div id="content_table">
				<table class="table-sistema table-head_mobile table-stock">
					<!-- Medium and down -->
					<?php include (TEMPLATEPATH . '/template/sistema/pedido/stock-pinatas-thead.php'); ?>
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
				        	global $product; $count = 0; $ordenes = 0; $pinatas = 0; $disponibles = 0; $faltantes = 0; $cerradas = 0;
				            while ( $loop->have_posts() ) : $loop->the_post(); 
								/* Obtener info del producto y guardarla en variables */
				            	$productId      = get_the_ID();
				            	//$productSlug	= $post->post_name;
								$product 		= wc_get_product( $productId );
								$productName 	= get_the_title( $productId );

								$price 			= $product->get_regular_price();
								$stock			= $product->get_stock_quantity(); 
								$image 			= wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID), 'medium' );

								/* Si no hay stock = 0 */
								if (empty($stock)) { $stock = 0; }		

								/* Obtener precios especiales */
								if ($price === '') { $price = 0; } /* Sin precio */
								$priceOnePercent= $price / 100;
								$pricePlata 	= $price - ($priceOnePercent * 10);
								$priceOro 		= $price - ($priceOnePercent * 20);

								/* Obtener ordener de la piñata */
								include (TEMPLATEPATH . '/template/sistema/pedido/modal-pedidos.php');
								include (TEMPLATEPATH . '/template/sistema/pedido/modal-pedidos-cerrados.php');

								/* Obtener faltante */
								if ($noPiezas === 0) {
									$faltan = 0;
								} else {
									$faltan = $noPiezas - $stock;
								}

								/* Agregar a totales tabla */
								$ordenes		= $ordenes + $noPedidos;
								$pinatas		= $pinatas + $noPiezas;
								$disponibles	= $disponibles + $stock;
								$faltantes		= $faltantes + $faltan;
								$cerradas		= $cerradas + $noCerradas; ?>

								<tr>
									<td><img class="img-pinata" src="<?php echo $image[0]; ?>"><?php echo $productName; ?></td>
									<td class="text-center">$<?php echo $price; ?></td>
									<td class="text-center">$<?php echo $pricePlata; ?></td>
									<td class="text-center">$<?php echo $priceOro; ?></td>
									<td class="text-center <?php if ($noPedidos === 0) { echo "tab-disabled";} ?>"><p <?php if ($noPedidos > 0) { ?> id="pedidos_<?php echo $productId; ?>" class="open-modal btn btn-primary" <?php } ?>><?php echo $noPedidos; ?></p></td>
									<td class="text-center <?php if ($noPiezas === 0) { echo "tab-disabled";} ?>"><?php echo $noPiezas; ?></td>
									<td class="text-center <?php if ($stock === 0) { echo "tab-disabled-strong";} ?>"><?php echo $stock ?></td>
									<td class="text-center <?php if ($faltan === 0) { echo "tab-disabled";} if ($faltan < 0) { echo "tab-disabled-strong";} ?>"><?php echo $faltan; ?></td>
									<td class="text-center <?php if ($noCerradas === 0) { echo "tab-disabled";} ?>"><p <?php if ($noCerradas > 0) { ?> id="pedidos_<?php echo $productId; ?>_cerrados" class="open-modal btn btn-primary" <?php } ?>><?php echo $noCerradas; ?></p></td>
								</tr>

				            <?php $count++; endwhile;
						} wp_reset_postdata(); ?>
					</tbody>					
					<!-- Medium and down -->
					<?php include (TEMPLATEPATH . '/template/sistema/pedido/stock-pinatas-tfoot.php'); ?>
				</table>				
			</div>
			<table class="table-sistema table-foot_desktop">
				<!-- Lanrge and up -->
				<?php include (TEMPLATEPATH . '/template/sistema/pedido/stock-pinatas-tfoot.php'); ?>		
			</table>
		</section>
		<section class="[ container ] color-light padding-bottom-100">
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
		   						$clienteName= get_the_title( $post_id );
								$nivel   	= get_post_meta( $post_id, 'clientes_nivel', true );
								$correo   	= get_post_meta( $post_id, 'clientes_correo', true );
								$cel   		= get_post_meta( $post_id, 'clientes_cel', true );
								$tel   		= get_post_meta( $post_id, 'clientes_tel', true );
								$direccion  = get_post_meta( $post_id, 'clientes_direccion', true ); 

								$linkCliente= get_permalink();

								/*Obtener no. pedidos del cliente*/
								$argsPedido = array(
								    'post_type' 		=> 'pedidos',
								    'posts_per_page' 	=> -1,    
									'orderby' 			=> 'date',
									'order' 			=> 'ASC',
									'meta_query'	=> array(
										array(
											'key'		=> 'pedidos_cliente',
											'value'		=> $clienteName,
											'compare'	=> '='
										)
									)
								);
								$loopPedido 	= new WP_Query( $argsPedido );
								$pedidos 		= 0;
								$pedidosAbiertos= 0;
								if ( $loopPedido->have_posts() ) {
								    while ( $loopPedido->have_posts() ) : $loopPedido->the_post();
								    	$pedidos  ++;
								    	$pedido_id  = get_the_ID();
								    	$estatus  	= get_post_meta( $pedido_id, 'pedidos_estatus', true );
										/* Obtener pedidos pendientes */
										if ($estatus === 'Abierto') { $pedidosAbiertos ++; }
									endwhile;
								} wp_reset_postdata(); ?>

								<tr>
									<td><a href="<?php echo $linkCliente; ?>" class="color-dark text-underline-hover"><?php echo $clienteName; ?></a></td>
									<td><?php if ($nivel != '') { echo $nivel; } ?></td>
									<td><?php 
										if ($direccion != '') { echo $direccion . '</br>'; }
										if ($correo != '') { echo '• ' . $correo . '</br>'; }
										if ($cel != '') { echo '• ' . $cel . ' '; }
										if ($tel != '') { echo '• ' . $tel . '</br>'; }
									?></td>
									<td><?php the_content(); ?></td>
									<td><?php echo $pedidos; ?></td>
									<td><?php echo $pedidosAbiertos; ?></td>
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
		<section class="[ container ] color-light padding-bottom-100">
			<div class="text-right margin-bottom-20">
				<p id="nuevo-material" class="btn btn-primary margin-left-right-10 open-modal">Nuevo material</p>
			</div>
			<?php include (TEMPLATEPATH . '/template/sistema/materiales/modal-nuevo-material.php'); ?>	
			<table class="table-sistema table-head_desktop">
				<!-- Lanrge and up -->
				<?php include (TEMPLATEPATH . '/template/sistema/materiales/stock-materiales-thead.php'); ?>		
			</table>
			<div id="content_table">
				<table class="table-sistema table-head_mobile table-materiales">
					<!-- Medium and down -->
					<?php include (TEMPLATEPATH . '/template/sistema/materiales/stock-materiales-thead.php'); ?>
					<tbody>
					<?php
				        $args = array(
				            'post_type' 		=> 'materiales',
				            'posts_per_page' 	=> -1,
				            'orderby'			=> 'title',
				            'order' 			=> 'ASC'
				        );
				        $loop = new WP_Query( $args );
				        if ( $loop->have_posts() ) { 
				        	$materials = 0;
				            while ( $loop->have_posts() ) : $loop->the_post();
		   						$post_id 		= get_the_ID();
		   						$materialName	= get_the_title( $post_id );
								$cantidad   	= get_post_meta( $post_id, 'materiales_cantidad', true );
								$presentacion  	= get_post_meta( $post_id, 'materiales_presentacion', true ); 

								$linkMaterial 	= get_permalink();?>

								<tr>
									<td><a href="<?php echo $linkMaterial; ?>" class="color-dark text-underline-hover"><?php echo $materialName; ?></a></td>
									<td><?php if ($cantidad != '') { echo $cantidad; } ?></td>
									<td><?php if ($presentacion != '') { echo $presentacion; } ?></td>
									<td><?php the_content(); ?></td>
								</tr>

				            <?php $materials++; endwhile;
						} wp_reset_postdata(); ?>
					</tbody>
				</table>				
			</div>
		</section>
	<?php endwhile; endif; 
get_footer(); ?>