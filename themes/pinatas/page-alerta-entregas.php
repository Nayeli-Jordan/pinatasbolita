<?php get_header(); 
	if (have_posts()) : while (have_posts()) : the_post();
		/* Cuerpo mensaje */
		include (TEMPLATEPATH . '/template/sistema/mail-body.php'); ?>
		<section class="[ container ] text-shadow-gray color-light">
			<h2 class="text-center margin-bottom-20"><?php the_title(); ?></h2>
			<div class="page-content">
			<?php $mailBody = ''; $noAlerts = 0;
			$argsPedido = array(
			    'post_type' 		=> 'pedidos',
			    'posts_per_page' 	=> -1,    
				'orderby' 			=> 'date',
				'order' 			=> 'ASC',
			);
			$loopPedido 	= new WP_Query( $argsPedido );
			if ( $loopPedido->have_posts() ) {
			    while ( $loopPedido->have_posts() ) : $loopPedido->the_post();
			    	$pedido_id  = get_the_ID();
			    	$postName= get_the_title( $pedido_id );
					$cliente  	= get_post_meta( $pedido_id, 'pedidos_cliente', true );
					$nivelCliente  	= get_post_meta( $pedido_id, 'pedidos_nivelCliente', true );
					$entrega  	= get_post_meta( $pedido_id, 'pedidos_entrega', true );
					$alerta  	= get_post_meta( $pedido_id, 'pedidos_alerta', true );
					$totalOrd  		= get_post_meta( $pedido_id, 'pedidos_totalOrd', true );
					$totalPzs  		= get_post_meta( $pedido_id, 'pedidos_totalPzs', true );
					$linkPedido = get_permalink();

					/* Calcular descuento y pago */
			        if ($nivelCliente === 'Normal') {
						$descuento = 0;
					} else if ($nivelCliente === 'Plata') {
						$descuento = $totalOrd * .10;
					} else if ($nivelCliente === 'Oro') {
						$descuento = $totalOrd * .20;
					} 
					$descuento = round($descuento);
					$totalFin = $totalOrd - $descuento;
 

			        if ($alerta != '' || $alerta != 0) { 
			        	$alertActive  	= date("Y-m-d", strtotime($entrega . '- ' . $alerta . ' days'));
			        	$today 			= date("Y-m-d");
			        	if ($today === $alertActive) { 
			        		$noAlerts ++;
							/* Cambiar formato fecha */
							setlocale(LC_ALL,"es_ES");
					        $entrega = strftime("%d/%B/%Y", strtotime($entrega));
					
							$mailBody .= '<div style="margin-bottom: 20px">
								<p>Pedido: ' . $postName . '</p></br>
								<p>Cliente: ' . $cliente . ' | Nivel: ' .  $nivelCliente . '</p>
								<p>Entrega: ' . $entrega . '</p>
								<p>Piezas: ' . $totalPzs . '</p></br>
								<p>Total: $' . number_format($totalOrd) . '</p>
								<p>Descuento : $' . number_format($descuento) . '</p>
								<p>A pagar: $' . number_format($totalFin) . '</p>
								<p><a href="' . $linkPedido . '"  class="color-primary">Ver</a></p>
							</div>';

			    		}
					}
				endwhile;
			} wp_reset_postdata();

		    $mailHeader .= '<p style="margin-bottom: 20px;">Se ha activado la alerta de las siguientes entregas:</p>';
			$message = $mailHeader . $mailBody . $mailFooter;
			if ($noAlerts > 0) {
			 	echo $message;
			 	/* Send email */
				$to 		= "nayeli@queonda.com.mx, manuel@pinatasbolita.com";
			    $subject 	= "Alerta de entregas PB";

			    wp_mail($to, $subject, $message);
			} ?>
			<div class="margin-top-30 text-right">
				<a href="<?php echo SITEURL; ?>stock-pinatas" class="btn btn-primary">Ir al stock</a>				
			</div>
		</section>
	<?php endwhile; endif; 
get_footer(); ?>