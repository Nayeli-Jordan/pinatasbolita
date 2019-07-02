<?php $today = date("Y-m-d"); ?>
<div id="modal-nuevo-pedido" class="modal modal-medium">
	<div class="fondo-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Nuevo pedido</p>
		<form id="pedido-form" name="pedido-form" action=""  method="post" class="validation row" data-parsley-pedido>
			<div class="col s12 m6 input-field clearfix">
				<label for="pb_pedidos_cliente">Cliente*:</label>
				<select name="pb_pedidos_cliente" id="pb_pedidos_cliente" required  data-parsley-required-message="Campo obligatorio">
    				<option value=""></option>
                    <?php 
                    $pbClientes = array(
                        'post_type'         => 'clientes',
                        'posts_per_page'    => -1,
				        'orderby' 			=> 'title',
				        'order' 			=> 'ASC',

                    ); 
                    $loopClientes = new WP_Query( $pbClientes );
                    if ( $loopClientes->have_posts() ) {
                        while ( $loopClientes->have_posts() ) : $loopClientes->the_post(); 
                            $post_id        = get_the_ID();
                            $clienteName 	= get_the_title( $post_id ); ?>
                            <option value="<?php echo $clienteName; ?>"><?php echo $clienteName; ?></option>
                    <?php endwhile; } wp_reset_postdata(); ?>
                </select>
			</div>
			<div class="col s12 m6 input-field">
				<label for="pb_pedidos_entrega">Fecha de entrega*:</label>
   				<input type="date" min="<?php echo $today; ?>" name="pb_pedidos_entrega" id="pb_pedidos_entrega" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 input-field">
				<label for="pb_pedidos_observaciones">Observaciones:</label>
    			<textarea rows="2" name="pb_pedidos_observaciones" id="pb_pedidos_observaciones" placeholder="Otros detalles del pedido, la entrega, el pago, etc."></textarea>
			</div>
			<div class="col s12 input-field margin-bottom-30">
				<label for="pb_pedidos_alerta">¿Cuántos días antes se te notifica?: <small class="color-gray">(0 para desactivar notificación)</small></label>
   				<input type="number" min="0" name="pb_pedidos_alerta" id="pb_pedidos_alerta" placeholder="0">
			</div>
           	<?php /* Loop modelos y sus piezas */
	        $args = array(
	            'post_type' 		=> 'product',
	            'posts_per_page' 	=> 350,
	            'orderby' 			=> 'title',
	            'order' 			=> 'ASC'
	        );
	        $loop = new WP_Query( $args );
	        $i = 1;
	        if ( $loop->have_posts() ) {
	            while ( $loop->have_posts() ) : $loop->the_post();	
		    		$productId      = get_the_ID();
		    		$productName 	= get_the_title( $productId );

		    		/* Calcular total */
					$product        = wc_get_product( $productId );
					$price          = $product->get_regular_price();
					if ($price === '') { $price = 0; } /* Sin precio */ ?>

					<div class="col s12 m6 l4 input-field no-padding-left no-padding-right">
						<div class="col s8 no-padding-right relative">
							<input type="text" min="1" class="not-border" name="pb_pedidos_modelo<?php echo $productId; ?>" id="pb_pedidos_modelo<?php echo $productId; ?>" value="<?php echo $productName; ?>"><div class="block-input"></div>
						</div>
						<div class="col s4">
			    			<input type="number" min="1" name="pb_pedidos_piezas<?php echo $productId; ?>" id="pb_pedidos_piezas<?php echo $productId; ?>" placeholder="0" class="number-pinatas">
			    			<input type="number" min="0" name="pb_pedidos_precio<?php echo $productId; ?>" id="pb_pedidos_precio<?php echo $productId; ?>" value="<?php echo $price; ?>" class="input-hide">
						</div>
					</div>	
	            <?php endwhile;
	        }  wp_reset_postdata(); ?>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitPedido" name="mb_submitPedido" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitPedido" value="post" />
				<?php wp_nonce_field( 'pedido-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitPedido'] )):

	$pedido_cliente      	= $_POST['pb_pedidos_cliente'];
    $pedido_entrega        	= $_POST['pb_pedidos_entrega'];
    $pedido_observaciones 	= $_POST['pb_pedidos_observaciones'];
    $pedido_alerta 			= $_POST['pb_pedidos_alerta'];
    $pedido_infoCliente 	= '';
    $totalOrd 				= 0;
	$totalPzs 				= 0;

    /* Obtener Info cliente */
    $argsClient = array(
        'post_type' 		=> 'clientes',
        'posts_per_page' 	=> 1,
		'title' 			=> $pedido_cliente
    );
    $loopClient = new WP_Query( $argsClient );
    if ( $loopClient->have_posts() ) { 
        while ( $loopClient->have_posts() ) : $loopClient->the_post();
			$cliente_id = get_the_ID();
			$nivel   	= get_post_meta( $cliente_id, 'clientes_nivel', true );
			$correo   	= get_post_meta( $cliente_id, 'clientes_correo', true );
			$cel   		= get_post_meta( $cliente_id, 'clientes_cel', true );
			$tel   		= get_post_meta( $cliente_id, 'clientes_tel', true );
			$direccion  = get_post_meta( $cliente_id, 'clientes_direccion', true );
			
			$pedido_infoCliente .= '• Nivel: ' . $nivel . '</br>• ' . $direccion . '</br>• ' . $correo . '</br>• ' . $cel . '</br>• ' . $tel;

        endwhile;
	} wp_reset_postdata();

	/**
	** Crear post pedidos 
	**/
    $pedido_number  	= date("dmY");
	$pedido_title 		= $pedido_cliente . ' | ' . $pedido_number;
	$post_pedido = array(
		'post_title'	=> wp_strip_all_tags($pedido_title),
		'post_content'	=> $pedido_observaciones,
		'post_status'	=> 'private',
		'post_type' 	=> 'pedidos'
	);

	$pedido_id = wp_insert_post($post_pedido);

	update_post_meta($pedido_id, 'pedidos_cliente', $pedido_cliente);
	update_post_meta($pedido_id, 'pedidos_nivelCliente', $nivel);
	update_post_meta($pedido_id, 'pedidos_infoCliente', $pedido_infoCliente);
	update_post_meta($pedido_id, 'pedidos_entrega', $pedido_entrega);
	update_post_meta($pedido_id, 'pedidos_estatus', 'Abierto');
	update_post_meta($pedido_id, 'pedidos_alerta', $pedido_alerta);


	/* Productos */
    $argsProduct = array(
        'post_type' 		=> 'product',
        'posts_per_page' 	=> 300,
        'orderby' 			=> 'title',
        'order' 			=> 'ASC'
    );
    $loopProduct = new WP_Query( $argsProduct );
    if ( $loopProduct->have_posts() ) {
        while ( $loopProduct->have_posts() ) : $loopProduct->the_post();	
    		$productId      	= get_the_ID();

		    if ($_POST['pb_pedidos_piezas' . $productId] >= 1) {
			    $pedido_total 	= $_POST['pb_pedidos_piezas' . $productId] * $_POST['pb_pedidos_precio' . $productId];
			    $totalOrd 		= $totalOrd + $pedido_total;
			    $totalPzs 		= $totalPzs + $_POST['pb_pedidos_piezas' . $productId];

			    update_post_meta($pedido_id, 'pedidos_modelo' . $productId, $_POST['pb_pedidos_modelo' . $productId]);
			    update_post_meta($pedido_id, 'pedidos_piezas' . $productId, $_POST['pb_pedidos_piezas' . $productId]);
			    update_post_meta($pedido_id, 'pedidos_precio' . $productId, $_POST['pb_pedidos_precio' . $productId]);		    	
			    update_post_meta($pedido_id, 'pedidos_total' . $productId, $pedido_total);		    	
		    }

    	endwhile;
		update_post_meta($pedido_id, 'pedidos_totalOrd', $totalOrd);
		update_post_meta($pedido_id, 'pedidos_totalPzs', $totalPzs);    	
	}  wp_reset_postdata();

endif; ?>