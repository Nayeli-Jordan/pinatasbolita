<?php get_header(); 
	if (have_posts()) : while (have_posts()) : the_post();

		$mailHeader 			= '<html style="font-family: Arial, sans-serif; font-size: 14px;"><body>';
		$mailHeader 		   .= '<h1 style="display: block; margin-bottom: 20px; text-align: center;  font-size: 20px; font-weight: 700; color: #992e8a; text-transform: uppercase;">Piñatas Bolita</h1>';
		$mailHeader 			.= '<p style="margin-bottom: 20px;">Se ha activado la alerta de las siguientes entregas:</p>';


		$mailFooter 			= '<div style="text-align: center; margin-bottom: 10px; margin-top: 20px;"><p><small>Este email fue enviado desde el sitio de Piñatas Bolita.</small></p></div>';
		$mailFooter 	        .= '</body></html>'; ?>
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
			    	$productName= get_the_title( $pedido_id );
					$piezas   	= get_post_meta( $pedido_id, 'pedidos_piezas', true );
					$cliente  	= get_post_meta( $pedido_id, 'pedidos_cliente', true );
					$entrega  	= get_post_meta( $pedido_id, 'pedidos_entrega', true );
					$estatus  	= get_post_meta( $pedido_id, 'pedidos_estatus', true );
					$alerta  	= get_post_meta( $pedido_id, 'pedidos_alerta', true );
					$linkPedido = get_permalink();
 

			        if ($alerta != '' || $alerta != 0) { 
			        	$alertActive  	= date("Y-m-d", strtotime($entrega . '- ' . $alerta . ' days'));
			        	$today 			= date("Y-m-d");
			        	if ($today === $alertActive) { 
			        		$noAlerts ++;
							/* Cambiar formato fecha */
							setlocale(LC_ALL,"es_ES");
					        $entrega = strftime("%d/%B/%Y", strtotime($entrega));
					
							$mailBody .= '<div style="margin-bottom: 20px">
								<p>Modelo: ' . $productName . '</p>
								<p>Cliente: ' . $cliente . '</p>
								<p>Piezas: ' . $piezas . '</p>
								<p>Entrega: ' . $entrega . '</p>
								<p><a href="' . $linkPedido . '"  class="color-primary">Ver</a></p>
							</div>';

			    		}
					}
				endwhile;
			} wp_reset_postdata();

			$message = $mailHeader . $mailBody . $mailFooter;
			if ($noAlerts > 0) {
			 	echo $message;
			 	/* Send email */
				$to 		= "nayeli@queonda.com.mx";
			    $subject 	= "Alerta de entregas PB";
			    wp_mail($to, $subject, $message);
			} ?>
			<div class="margin-top-30 text-right">
				<a href="<?php echo SITEURL; ?>stock-pinatas" class="btn btn-primary">Ir al stock</a>				
			</div>
		</section>
	<?php endwhile; endif; 
get_footer(); ?>