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
		$clienteContent = $post->post_content;

		/* Editar cliente */
		include (TEMPLATEPATH . '/template/sistema/clientes/modal-editar-cliente.php');
		include (TEMPLATEPATH . '/template/sistema/notice/notice-cliente-actualizado.php');

		if (is_user_logged_in() ): ?>
			<section id="single" class="container single-content">
				<div class="card-cliente">
					<p class="fz-20 margin-bottom-10 inline-block"><span class="color-primary"><?php echo $clienteName; ?></span> - Nivel: <?php echo $nivel; ?></p>
					<div class="inline-block float-right">
						<p id="editar-cliente" class="open-modal text-underline color-primary inline-block margin-right-10">Editar cliente</p>
					</div>
					<p class="margin-bottom-20"><?php 
					if ($direccion != '') { echo  '• ' . $direccion . '</br>'; }
					if ($correo != '') { echo  '• ' . $correo . '</br>'; }
					if ($cel != '') { echo  '• ' . $cel . ' '; }
					if ($tel != '') { echo  '• ' . $tel . '</br>'; } ?></p>
					<table class="width-100p text-left">
						<tr>
							<th class="color-primary width-20p">Entrega</th>
							<th class="color-primary width-10p">Piezas</th>
							<th class="color-primary width-10p">Total</th>
							<th class="color-primary width-10p">Dto.</th>
							<th class="color-primary width-10p">Pago</th>
							<th class="color-primary width-20p">Estatus</th>
							<th class="color-primary width-10p">Detalles</th>
						</tr>
						<?php 
						$argsPedido = array(
						    'post_type' 		=> 'pedidos',
						    'posts_per_page' 	=> -1,    
							'orderby' 			=> 'date',
							'order' 			=> 'DESC',
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
						    	$pedido_id  	= get_the_ID();
						    	$productName 	= get_the_title( $pedido_id );

								$cliente  = get_post_meta( $pedido_id, 'pedidos_cliente', true );
								$entrega  = get_post_meta( $pedido_id, 'pedidos_entrega', true );
								$estatus  = get_post_meta( $pedido_id, 'pedidos_estatus', true );
								$totalOrd = get_post_meta( $pedido_id, 'pedidos_totalOrd', true );
								$totalPzs = get_post_meta( $pedido_id, 'pedidos_totalPzs', true );

							    $linkPedido	= get_permalink();

								/* Cambiar formato fecha */
								setlocale(LC_ALL,"es_ES");
						        $entrega = strftime("%d/%B/%Y", strtotime($entrega));

								/* Obtener pedidos pendientes */
								if ($estatus === 'Abierto') { $pedidosAbiertos ++; } ?>
								
								<tr class="<?php if ($estatus === 'Cerrado') { echo "tab-disabled-strong";} ?>">
									<td><?php echo $entrega; ?></td>
									<td><?php echo $totalPzs; ?></td>
									<td><?php echo number_format($totalOrd); ?></td>
									<td><?php if ($nivel === 'Normal') {
										$descuento = 0;
									} else if ($nivel === 'Plata') {
										$descuento = $totalOrd * 10;
									} else if ($nivel === 'Oro') {
										$descuento = $totalOrd * 20;
									} echo $descuento; 
									$totalFin = $totalOrd - $descuento; ?></td>
									<td>$<?php echo  number_format($totalFin); ?></td>
									<td><?php echo $estatus; ?></td>
									<td><a href="<?php echo $linkPedido; ?>" terget="_blank" class="color-primary">Ver</a></td>
								</tr>
						    <?php endwhile;
						} wp_reset_postdata(); ?>
					</table>
					<div class="row row-complete margin-top-30">
						<div class="col s8">
							<p class="inline-block"><span class="color-primary">Total pedidos:</span> <?php echo $pedidos; ?></p><span class="color-gray"> | </span><p class="inline-block"><span class="color-primary">Pedidos pendientes:</span> <?php echo $pedidosAbiertos; ?></p>
						</div>
						<div class="col s4 text-right">
							<a href="<?php echo SITEURL; ?>stock-pinatas" class="btn btn-primary">Ir al stock</a>
						</div>
					</div>
				</div>
			</section>
		<?php else: 
			include (TEMPLATEPATH . '/template/template-404.php');
		endif;
	endwhile; // end of the loop.
	get_footer(); 
?>