<div id="modal-cerrar-pedido" class="modal modal-medium">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Cerrar pedido</p>
		<p class="text-center margin-bottom-20">Cierra el pedido únicamente si ya se ha realizado la entrega y se ha pagado en su totalidad. Al cerrar la venta se agregará este ingreso al registro.</p>
		<form id="closepedido-form" name="closepedido-form" action=""  method="post" class="validation row" data-parsley-pedido>
			<div class="col s12 input-field">
				<label for="pedidos_estatus">¿Cerrar el pedido?*:</label>
				<select name="pedidos_estatus" id="pedidos_estatus" required  data-parsley-required-message="Campo obligatorio">
                    <option value="Cerrado">Sí, cerrar el pedido</option>
                </select>
			</div>
			<p class="color-primary text-center margin-top-bottom-20">¿Deseas actualizar el stock de estos modelos?</p>
			<?php
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
		            $stock			= $product->get_stock_quantity();  

		            $piezas      	= 'piezas' . $post_id;

		            if (${$piezas} != '') { ?>

			            <div class="col s12 m6 l4 input-field no-padding-left no-padding-right">
							<div class="col s8 no-padding-right"><small><?php echo $productName; ?></small></div>
							<div class="col s4">
				    			<input type="number" name="actualizar_stock<?php echo $post_id; ?>" id="actualizar_stock<?php echo $post_id; ?>" value="<?php echo $stock ?>" min="0">
							</div>
						</div>	

		            <?php } 
		         endwhile;
		    }  wp_reset_postdata(); ?>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitClosePedido" name="mb_submitClosePedido" class="btn btn-primary inline-block" value="Cerrar pedido" />
				<input type="hidden" name="send_submitClosePedido" value="post" />
				<?php wp_nonce_field( 'closepedido-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitClosePedido'] )):

    $pedido_estatus      	= 'Cerrado';

	/* Actualizar post pedido */
	$post = array(
		'ID'           		=> $pedido_id,
	);
	$pedido_id = wp_update_post($post);
	update_post_meta($pedido_id,'pedidos_estatus',$pedido_estatus);

	/*Actualizar stock */
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
            $stock			= $product->get_stock_quantity();  

            $piezas      	= 'piezas' . $post_id;

            if (${$piezas} != '') {

				update_post_meta($post_id, '_stock', $_POST['actualizar_stock' . $post_id]);

           	} 
         endwhile;
    }  wp_reset_postdata();	

    /* Crear ingreso */
    $cuenta_concepto     	= 'Pedido cerrado - ' . $cliente;
    $cuenta_cantidad      	= $totalFin;
    $cuenta_categoria       = 'Pago';

	/* Crear post clientes */
	$post = array(
		'post_title'	=> wp_strip_all_tags($cuenta_concepto),
		'post_status'	=> 'private',
		'post_type' 	=> 'cuenta'
	);

	$cuenta_id = wp_insert_post($post);

	update_post_meta($cuenta_id,'cuenta_tipo', 'Ingreso');
	update_post_meta($cuenta_id,'cuenta_cantidad',$cuenta_cantidad);
	update_post_meta($cuenta_id,'cuenta_categoria',$cuenta_categoria);

endif; ?>