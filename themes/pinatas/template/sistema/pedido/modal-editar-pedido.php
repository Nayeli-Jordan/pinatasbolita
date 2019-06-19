<?php $today = date("Y-m-d"); ?>
<div id="modal-editar-pedido" class="modal modal-medium">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Editar pedido</p>
		<form id="editpedido-form" name="editpedido-form" action=""  method="post" class="validation row" data-parsley-pedido>
			<div class="col s12 m6 input-field">
				<label for="pedidos_piezas">No. de piezas*:</label>
    			<input type="number" min="1" name="pedidos_piezas" id="pedidos_piezas" value="<?php echo $piezas; ?>" required data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 m6 input-field">
				<label for="pedidos_cliente">Cliente*:</label>
				<select name="pedidos_cliente" id="pedidos_cliente" required  data-parsley-required-message="Campo obligatorio">
    				<option value="<?php echo $cliente; ?>"><?php echo $cliente; ?></option>
                    <?php 
                    $pbClientes = array(
                        'post_type'         => 'clientes',
                        'posts_per_page'    => -1,
				        'orderby' 			=> 'title',
				        'order' 			=> 'ASC',
                        'post_status'       => 'publish'

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
			<div class="col s12 m12 input-field">
				<label for="pedidos_entrega">Fecha de entrega*:</label>
   				<input type="date" min="<?php echo $today; ?>" name="pedidos_entrega" id="pedidos_entrega" value="<?php echo $entregaOrg; ?>" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 input-field">
				<label for="pedidos_observaciones">Observaciones:</label>
    			<textarea name="pedidos_observaciones" id="pedidos_observaciones" placeholder="Otros detalles del pedido, la entrega, el pago, etc."><?php echo $pedidoContent; ?></textarea>
			</div>	
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitEditPedido" name="mb_submitEditPedido" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitEditPedido" value="post" />
				<?php wp_nonce_field( 'editpedido-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditPedido'] )):

    $pedido_piezas      	= $_POST['pedidos_piezas'];
    $pedido_cliente      	= $_POST['pedidos_cliente'];
    $pedido_entrega        	= $_POST['pedidos_entrega'];
    $pedido_observaciones 	= $_POST['pedidos_observaciones'];

	/* Crear post pedidos */
	$post = array(
		'ID'           		=> $pedido_id,
		'post_content'		=> $pedido_observaciones,
	);

	$pedido_id = wp_update_post($post);

	update_post_meta($pedido_id,'pedidos_piezas',$pedido_piezas);
	update_post_meta($pedido_id,'pedidos_cliente',$pedido_cliente);
	update_post_meta($pedido_id,'pedidos_entrega',$pedido_entrega);
endif; ?>