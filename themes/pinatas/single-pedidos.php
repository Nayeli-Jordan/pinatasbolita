<?php 
	get_header();
	global $post;
	
	while ( have_posts() ) : the_post(); 
		$pedido_id  	= get_the_ID();
		$piezas   		= get_post_meta( $pedido_id, 'pedidos_piezas', true );
		$cliente  		= get_post_meta( $pedido_id, 'pedidos_cliente', true );
		$entrega  		= get_post_meta( $pedido_id, 'pedidos_entrega', true );
		$estatus  		= get_post_meta( $pedido_id, 'pedidos_estatus', true );
		$entregaOrg		= $entrega;

		$productName 	= get_the_title( $pedido_id );
		$pedidoContent 	= $post->post_content;

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
	        	$productId      = get_the_ID();
	        	$product 		= wc_get_product( $productId );
	        	$price 			= $product->get_regular_price();
	        	$stock			= $product->get_stock_quantity();

				if ($price === '') { $price = 0; } /* Sin precio */
				$priceOnePercent= $price / 100;
				$pricePlata 	= $price - ($priceOnePercent * 10);
				$priceOro 		= $price - ($priceOnePercent * 20);

			endwhile;
		} wp_reset_postdata();


		/* Obtener Info cliente */
        $args = array(
            'post_type' 		=> 'clientes',
            'posts_per_page' 	=> 1,
			'title' 			=> $cliente
        );
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) { 
            while ( $loop->have_posts() ) : $loop->the_post();
				$cliente_id 	= get_the_ID();
				$nivel   	= get_post_meta( $cliente_id, 'clientes_nivel', true );
				$correo   	= get_post_meta( $cliente_id, 'clientes_correo', true );
				$cel   		= get_post_meta( $cliente_id, 'clientes_cel', true );
				$tel   		= get_post_meta( $cliente_id, 'clientes_tel', true );
				$direccion  = get_post_meta( $cliente_id, 'clientes_direccion', true ); 

				$linkCliente= get_permalink();

				$infoCliente = '';
				if ($nivel != '') { $infoCliente .= '• Nivel: ' . $nivel . '</br>'; }
				if ($direccion != '') { $infoCliente .=  '• ' . $direccion . '</br>'; }
				if ($correo != '') { $infoCliente .=  '• ' . $correo . '</br>'; }
				if ($cel != '') { $infoCliente .=  '• ' . $cel . ' '; }
				if ($tel != '') { $infoCliente .=  '• ' . $tel . '</br>'; }

            endwhile;
		} wp_reset_postdata();

		/* Obtener precio final de la piñata según el nivel del cliente */
		if ($nivel === 'Normal') {
			$price = $price;
		} elseif ($nivel === 'Plata') {
			$price = $pricePlata;
		} else {
			$price = $priceOro;
		}

		/* Cambiar formato fecha */
		setlocale(LC_ALL,"es_ES");
        $entrega = strftime("%d/%B/%Y", strtotime($entrega)); 


        if ($estatus === 'Abierto') :
			/* Modals notice */
			include (TEMPLATEPATH . '/template/sistema/notice/notice-pedido-actualizado.php');
			include (TEMPLATEPATH . '/template/sistema/notice/notice-pedido-cerrado.php');
	        /* Editar pedido */
			include (TEMPLATEPATH . '/template/sistema/pedido/modal-editar-pedido.php');
	        /* Cerrar pedido */
			include (TEMPLATEPATH . '/template/sistema/pedido/modal-cerrar-pedido.php');
		endif; ?>

	<section id="single" class="container single-content <?php if ($estatus === 'Cerrado') : echo 'single-pedido-cerrado'; endif; ?>">
		<div class="card-pedido">
			<p class="fz-20 margin-bottom-20 margin-right-20 uppercase inline-block">Detalles del pedido</p>
			<div id="btns-modificar-pedido" class="inline-block float-right">
				<p id="editar-pedido" class="open-modal text-underline color-primary inline-block margin-right-10">Editar pedido</p>|<p id="cerrar-pedido" class="open-modal text-underline color-primary inline-block margin-left-10">Cerrar pedido</p>
			</div>
			<table class="width-100p">
				<tr>
					<th class="width-30p text-left"><p class="color-primary">Modelo:</p></th>
					<td class="width-70p"><p><?php the_title(); ?></p></td>
				</tr>
				<tr>
					<th class="text-left padding-top-30"><p class="color-primary">Piezas:</p></th>
					<td class=" padding-top-20"><p><?php echo $piezas; ?> unidades</p></td>
				</tr>
				<tr>
					<th class="text-left"><p class="color-primary">Costo:</p></th>
					<td><p>$<?php echo $price; ?> por piñata</p></td>
				</tr>
				<tr>
					<th class="text-left"><p class="color-primary">Total:</p></th>
					<td><p>$<?php echo $piezas * $price; ?></p></td>
				</tr>
				<tr>
					<th class="text-left padding-top-30"><p class="color-primary">Fecha de entrega:</p></th>
					<td class="padding-top-20"><p><?php echo $entrega; ?></p></td>
				</tr>
				<tr>
					<th class="text-left"><p class="color-primary">Observaciones:</p></th>
					<td><?php echo $pedidoContent; ?></td>
				</tr>
				<tr>
					<th class="text-left padding-top-50"><p class="color-primary">Cliente:</p></th>
					<td class="padding-top-50">
						<p class="margin-bottom-10"><?php echo $cliente; ?></p>
						<p><?php echo $infoCliente; ?></p>
						<p class="margin-top-20"><a href="<?php echo $linkCliente; ?>" class="enlace-primary">Ver pedidos cliente</a></p>
					</td>
				</tr>
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
