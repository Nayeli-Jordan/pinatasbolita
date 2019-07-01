<?php $today = date("Y-m-d"); ?>
<div id="modal-editar-pedido" class="modal modal-medium">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Editar pedido</p>
		<form id="editpedido-form" name="editpedido-form" action=""  method="post" class="validation row" data-parsley-pedido>
			<div class="col s12 input-field">
				<label for="pedidos_entrega">Fecha de entrega*:</label>
   				<input type="date" min="<?php echo $today; ?>" name="pedidos_entrega" id="pedidos_entrega" value="<?php echo $entregaOrg; ?>" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 input-field">
				<label for="pedidos_observaciones">Observaciones:</label>
    			<textarea rows="2" name="pedidos_observaciones" id="pedidos_observaciones" placeholder="Otros detalles del pedido, la entrega, el pago, etc."><?php echo $pedidoContent; ?></textarea>
			</div>
           	<?php /* Loop modelos y sus piezas */
	        $args = array(
	            'post_type' 		=> 'product',
	            'posts_per_page' 	=> -1,
	            'orderby' 			=> 'title',
	            'order' 			=> 'ASC'
	        );
	        $loop = new WP_Query( $args );
	        $i = 1;
	        if ( $loop->have_posts() ) {
	            while ( $loop->have_posts() ) : $loop->the_post();	

	            	$post_id        = get_the_ID();
               		$productName 	= get_the_title( $post_id ); 
               		$piezas      	= 'piezas' . $post_id; ?>
					<div class="col s12 m6 l4 input-field no-padding-left no-padding-right">
						<div class="col s8 no-padding-right">
							<input type="text" min="1" class="not-border" name="pedidos_modelo<?php echo $post_id; ?>" id="pedidos_modelo<?php echo $post_id; ?>" value="<?php echo $productName; ?>" disabled>	
						</div>
						<div class="col s4">
			    			<input type="number" min="1" name="pedidos_piezas<?php echo $post_id; ?>" id="pedidos_piezas<?php echo $post_id; ?>" placeholder="0" value="<?php echo ${$piezas}; ?>">	
						</div>
					</div>	
	            <?php endwhile;
	        }  wp_reset_postdata(); ?>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitEditPedido" name="mb_submitEditPedido" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitEditPedido" value="post" />
				<?php wp_nonce_field( 'editpedido-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditPedido'] )):

    $args = array(
        'post_type' 		=> 'product',
        'posts_per_page' 	=> -1,
        'orderby' 			=> 'title',
        'order' 			=> 'ASC'
    );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();	
    	$post_id        = get_the_ID();

	    	//Modelo disabled, guardado desde functions.php
	        $pedido_piezas      = 'pedido_piezas' . $post_id;
		    ${$pedido_piezas}   = $_POST['pedidos_piezas' . $post_id];

    	endwhile;
	}  wp_reset_postdata();

    $pedido_cliente      	= $_POST['pedidos_cliente'];
    $pedido_entrega        	= $_POST['pedidos_entrega'];
    $pedido_observaciones 	= $_POST['pedidos_observaciones'];

    /* Obtener Info cliente */
    $args = array(
        'post_type' 		=> 'clientes',
        'posts_per_page' 	=> 1,
		'title' 			=> $pedido_cliente
    );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) { 
        while ( $loop->have_posts() ) : $loop->the_post();
			$cliente_id = get_the_ID();
			$nivel   	= get_post_meta( $cliente_id, 'clientes_nivel', true );
			$correo   	= get_post_meta( $cliente_id, 'clientes_correo', true );
			$cel   		= get_post_meta( $cliente_id, 'clientes_cel', true );
			$tel   		= get_post_meta( $cliente_id, 'clientes_tel', true );
			$direccion  = get_post_meta( $cliente_id, 'clientes_direccion', true ); 

			//$linkCliente= get_permalink();

			$pedido_infoCliente = '';
			if ($nivel != '') { $pedido_infoCliente .= '• Nivel: ' . $nivel . '</br>'; }
			if ($direccion != '') { $pedido_infoCliente .=  '• ' . $direccion . '</br>'; }
			if ($correo != '') { $pedido_infoCliente .=  '• ' . $correo . '</br>'; }
			if ($cel != '') { $pedido_infoCliente .=  '• ' . $cel . ' '; }
			if ($tel != '') { $pedido_infoCliente .=  '• ' . $tel . '</br>'; }

        endwhile;
	} wp_reset_postdata();

	/**
	** Crear post pedidos 
	**/

	/* Fecha en español */
    setlocale(LC_ALL,"es_ES");
    $pedido_entregaEsp = strftime("%d/%B/%Y", strtotime($pedido_entrega)); 

	$post = array(
		'ID'           		=> $pedido_id,
		'post_content'		=> $pedido_observaciones,
	);

	$pedido_id = wp_update_post($post);

    $args = array(
        'post_type' 		=> 'product',
        'posts_per_page' 	=> -1,
        'orderby' 			=> 'title',
        'order' 			=> 'ASC'
    );
    $loop = new WP_Query( $args );
    $totalOrd = 0;
    $totalPzs = 0;
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();	
    		$post_id        = get_the_ID();
			/* Calcular total */
			$product        = wc_get_product( $post_id );
			$price          = $product->get_regular_price();
			if ($price === '') { $price = 0; } /* Sin precio */

			//Total
			$pedido_piezas 		= ${'pedido_piezas' . $post_id};
		    $pedido_total   	= $pedido_piezas * $price;
		    $totalOrd			= $totalOrd + $pedido_total;
		    $totalPzs			= $totalPzs + $pedido_piezas;

			//Modelo disabled, guardado desde functions.php
		    update_post_meta($pedido_id,'pedidos_piezas' . $post_id, $pedido_piezas);
		    update_post_meta($pedido_id,'pedidos_total' . $post_id, $pedido_total);
		    //Se guarda precio de otro modo sólo se imprime en el post pero no en front (como si no se guardara)
		    update_post_meta($pedido_id,'pedidos_precio' . $post_id, $price);

    	endwhile;
	}  wp_reset_postdata();

	update_post_meta($pedido_id,'pedidos_cliente',$pedido_cliente);
	update_post_meta($pedido_id,'pedidos_nivelCliente',$nivel);
	update_post_meta($pedido_id,'pedidos_infoCliente',$pedido_infoCliente);
	update_post_meta($pedido_id,'pedidos_entrega',$pedido_entrega);
	update_post_meta($pedido_id,'pedidos_totalOrd',$totalOrd);
	update_post_meta($pedido_id,'pedidos_totalPzs',$totalPzs);
endif; ?>