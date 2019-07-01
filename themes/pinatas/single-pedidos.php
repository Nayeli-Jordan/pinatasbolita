<?php 
	get_header();
	global $post;
	
	while ( have_posts() ) : the_post(); 
		$pedido_id  	= get_the_ID();

	    $args = array(
	        'post_type'         => 'product',
	        'posts_per_page'    => -1,
	        'orderby'           => 'title',
	        'order'             => 'ASC'
	    );
	    $loop = new WP_Query( $args );
	    if ( $loop->have_posts() ) {
	        while ( $loop->have_posts() ) : $loop->the_post();
	            $post_id        = get_the_ID();
	            $productName    = get_the_title( $post_id ); 

	            $modelo      = 'modelo' . $post_id;
	            $piezas      = 'piezas' . $post_id;
	            $precio      = 'precio' . $post_id;
	            $total       = 'total' . $post_id;
	            ${$modelo}   = get_post_meta( $pedido_id, 'pedidos_modelo' . $post_id, true ); 
	            ${$piezas}   = get_post_meta( $pedido_id, 'pedidos_piezas' . $post_id, true );
	            ${$precio}   = get_post_meta( $pedido_id, 'pedidos_precio' . $post_id, true );
	            ${$total}   = get_post_meta( $pedido_id, 'pedidos_total' . $post_id, true );

	        endwhile;
	    }  wp_reset_postdata();

		$cliente  		= get_post_meta( $pedido_id, 'pedidos_cliente', true );
		$entrega  		= get_post_meta( $pedido_id, 'pedidos_entrega', true );
		$estatus  		= get_post_meta( $pedido_id, 'pedidos_estatus', true );
		$alerta  		= get_post_meta( $pedido_id, 'pedidos_alerta', true );
		$totalOrd  		= get_post_meta( $pedido_id, 'pedidos_totalOrd', true );
		$totalPzs  		= get_post_meta( $pedido_id, 'pedidos_totalPzs', true );
		$entregaOrg		= $entrega;

		$pedidoContent 	= $post->post_content;

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
			include (TEMPLATEPATH . '/template/sistema/pedido/modal-editar-alerta.php');
		endif; ?>

	<section id="single" class="container single-content <?php if ($estatus === 'Cerrado') : echo 'single-pedido-cerrado'; endif; ?>">
		<div class="card-pedido">
			<p class="fz-20 margin-bottom-20 margin-right-20 uppercase inline-block">Detalles del pedido</p>
			<div id="btns-modificar-pedido" class="inline-block float-right">
				<p id="editar-pedido" class="open-modal text-underline color-primary inline-block margin-right-10">Editar pedido</p>|<p id="cerrar-pedido" class="open-modal text-underline color-primary inline-block margin-left-10">Cerrar pedido</p>
			</div>
			<table class="width-100p">
				<thead>
					<tr class="color-light">
						<th class="width-25p"><p>Modelo</p></th>
						<th class="width-25p"><p>Piezas</p></th>
						<th class="width-25p"><p>Precio</p></th>
						<th class="width-25p"><p>Total</p></th>
					</tr>					
				</thead>
				<tbody><?php
			    $args = array(
			        'post_type'         => 'product',
			        'posts_per_page'    => -1,
			        'orderby'           => 'title',
			        'order'             => 'ASC'
			    );
			    $loop = new WP_Query( $args );
			    if ( $loop->have_posts() ) {
			        while ( $loop->have_posts() ) : $loop->the_post();
			            $post_id        = get_the_ID();
			            $productName    = get_the_title( $post_id ); 

			            $modelo      = 'modelo' . $post_id;
			            $piezas      = 'piezas' . $post_id;
			            $precio      = 'precio' . $post_id;
			            $total       = 'total' . $post_id;  

			            if (${$piezas} != '') { ?>

				            <tr>
								<td><p><?php echo $productName ?></p></th>
								<td class="text-center"><p><?php echo ${$piezas}; ?></p></th>
								<td class="text-center"><p><?php echo ${$precio}; ?></p></th>
								<td class="text-center"><p><?php echo ${$total}; ?></p></th>
							</tr>

			            <?php } 
			         endwhile;
			    }  wp_reset_postdata(); ?>
				</tbody>
				<tfoot>
					<tr class="color-light">
						<td class="width-25p">Total:</td>
						<td class="width-25p"><?php echo $totalPzs; ?></td>
						<td class="width-25p">A pagar: </td>
						<td colspan="3" class="width-25p"><?php echo $totalOrd; ?></td>
					</tr>
				</tfoot>
			</table>
			<table>
				<tr>
					<th class="text-left padding-top-30"><p class="color-primary">Fecha de entrega:</p></th>
					<td colspan="2" class="padding-top-30"><p><?php echo $entrega; ?></p></td>
				</tr>
				<tr>
					<th class="text-left"><p class="color-primary">Observaciones:</p></th>
					<td colspan="2"><?php echo $pedidoContent; ?></td>
				</tr>
				<tr>
					<th class="text-left padding-top-50"><p class="color-primary">Cliente:</p></th>
					<td colspan="2" class="padding-top-50">
						<p class="margin-bottom-10"><?php echo $cliente; ?></p>
						<p><?php echo $infoCliente; ?></p>
						<p class="margin-top-20"><a href="<?php echo $linkCliente; ?>" class="enlace-primary">Ver pedidos cliente</a></p>
					</td>
				</tr>
				<tr>
					<th class="text-left padding-top-50"><p class="color-primary">Alerta:</p></th>
					<td class="padding-top-50"><?php echo $alerta; ?> días antes</td>
					<td class="padding-top-50"><p id="editar-alerta" class="open-modal text-underline color-primary inline-block margin-right-10">Editar alerta</p></td>
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
