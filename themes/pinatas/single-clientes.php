<?php 
	get_header();
	global $post;
	
	while ( have_posts() ) : the_post(); 
		$cliente_id  	= get_the_ID();
		$clienteName 	= get_the_title( $cliente_id );
		$nivel   		= get_post_meta( $cliente_id, 'clientes_nivel', true );
		$correo   		= get_post_meta( $cliente_id, 'clientes_correo', true );
		$cel   			= get_post_meta( $cliente_id, 'clientes_cel', true );
		$tel   			= get_post_meta( $cliente_id, 'clientes_tel', true );
		$direccion  	= get_post_meta( $cliente_id, 'clientes_direccion', true );
?>
	<section id="single" class="container single-content">
		<div class="card-cliente">
			<p class="fz-20 margin-bottom-10"><span class="color-primary"><?php echo $clienteName; ?></span> - Nivel: <?php echo $nivel; ?></p>
			<p class="margin-bottom-20"><?php 
			if ($direccion != '') { echo  '• ' . $direccion . '</br>'; }
			if ($correo != '') { echo  '• ' . $correo . '</br>'; }
			if ($cel != '') { echo  '• ' . $cel . ' '; }
			if ($tel != '') { echo  '• ' . $tel . '</br>'; } ?></p>
			<table class="width-100p text-left">
				<tr>
					<th class="color-primary width-20p">Pedido</th>
					<th class="color-primary width-10p">Piezas</th>
					<th class="color-primary width-10p">Precio</th>
					<th class="color-primary width-10p">Total</th>
					<th class="color-primary width-20p">Entrega</th>
					<th class="color-primary width-20p">Estatus</th>
					<th class="color-primary width-10p">Detalles</th>
				</tr>
				<?php 
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
				$noPedidos 		= 0;
				if ( $loopPedido->have_posts() ) {
				    while ( $loopPedido->have_posts() ) : $loopPedido->the_post();
				    	$noPedidos ++;
				    	$pedido_id  	= get_the_ID();
				    	$productName 	= get_the_title( $pedido_id );
						$piezas   = get_post_meta( $pedido_id, 'pedidos_piezas', true );
						$cliente  = get_post_meta( $pedido_id, 'pedidos_cliente', true );
						$entrega  = get_post_meta( $pedido_id, 'pedidos_entrega', true );

					    $linkPedido	= get_permalink();

						/* Cambiar formato fecha */
						setlocale(LC_ALL,"es_ES");
				        $entrega = strftime("%d/%B/%Y", strtotime($entrega)); 


				        /* Obtener precios de la piñata del pedido */
						$args = array(
					        'post_type' 		=> 'product',
					        'posts_per_page' 	=> 1,
							'title' 			=> $productName
					    );
					    $loop = new WP_Query( $args );
					    if ( $loop->have_posts() ) { 
					    	global $product; $count = 0; $disponibles = 0;
					        while ( $loop->have_posts() ) : $loop->the_post();
					        	$post_id        = get_the_ID();
					        	$product 		= wc_get_product( $post_id );
					        	$price 			= $product->get_regular_price();

								if ($price === '') { $price = 0; } /* Sin precio */
								$priceOnePercent= $price / 100;
								$pricePlata 	= $price - ($priceOnePercent * 10);
								$priceOro 		= $price - ($priceOnePercent * 20);

							endwhile;
						} wp_reset_postdata(); 

						/* Obtener precio final de la piñata según el nivel del cliente */
						if ($nivel === 'Normal') {
							$price = $price;
						} elseif ($nivel === 'Plata') {
							$price = $pricePlata;
						} else {
							$price = $priceOro;
						} ?>
						
						<tr>
							<td><?php echo $productName;; ?></td>
							<td><?php echo $piezas; ?></td>
							<td>$<?php echo $price; ?></td>
							<td>$<?php echo $piezas * $price; ?></td>
							<td><?php echo $entrega; ?></td>
							<td>Estatus</td>
							<td><a href="<?php echo $linkPedido; ?>" terget="_blank" class="color-primary">Ver</a></td>
						</tr>
				    <?php endwhile;
				} wp_reset_postdata(); ?>
			</table>
			<div class="margin-top-30 text-right">
				<a href="<?php echo SITEURL; ?>stock-pinatas" class="btn btn-primary">Ir al stock</a>				
			</div>
		</div>
	</section>
<?php 
	endwhile; // end of the loop.
	get_footer(); 
?>