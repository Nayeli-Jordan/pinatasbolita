<?php $today = date("Y-m-d"); ?>
<div id="modal-nuevo-pedido" class="modal modal-medium">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Nuevo pedido</p>
		<form id="pedido-form" name="pedido-form" action=""  method="post" class="validation row" data-parsley-pedido>
			<div class="col s12 m6 input-field">
				<label for="pedidos_modelo">Modelo*:</label>
                <select name="pedidos_modelo" id="pedidos_modelo">
                	<option value=""></option>
           			<?php
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
                           		$productName 	= get_the_title( $post_id );?>
								<option value="<?php echo $productName; ?>"><?php echo $productName; ?></option>
				            <?php $i ++; endwhile;
				        } 
				        wp_reset_postdata();
				    ?>
                </select>
			</div>
			<div class="col s12 m6 input-field">
				<label for="pedidos_piezas">No. de piezas*:</label>
    			<input type="number" min="1" name="pedidos_piezas" id="pedidos_piezas" required data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 m6 input-field clearfix">
				<label for="pedidos_cliente">Cliente*:</label>
				<select name="pedidos_cliente" id="pedidos_cliente" required  data-parsley-required-message="Campo obligatorio">
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
				<label for="pedidos_entrega">Fecha de entrega*:</label>
   				<input type="date" min="<?php echo $today; ?>" name="pedidos_entrega" id="pedidos_entrega" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 input-field">
				<label for="pedidos_observaciones">Observaciones:</label>
    			<textarea name="pedidos_observaciones" id="pedidos_observaciones" placeholder="Otros detalles del pedido, la entrega, el pago, etc."></textarea>
			</div>
			<div class="col s12 input-field">
				<label for="pedidos_alerta">¿Cuántos días antes se te notifica?: <small class="color-gray">(0 para desactivar notificación)</small></label>
   				<input type="number" min="0" name="pedidos_alerta" id="pedidos_alerta" placeholder="0">
			</div>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitPedido" name="mb_submitPedido" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitPedido" value="post" />
				<?php wp_nonce_field( 'pedido-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitPedido'] )):

    $pedido_modelo     		= $_POST['pedidos_modelo'];
    $pedido_piezas      	= $_POST['pedidos_piezas'];
    $pedido_cliente      	= $_POST['pedidos_cliente'];
    $pedido_entrega        	= $_POST['pedidos_entrega'];
    $pedido_observaciones 	= $_POST['pedidos_observaciones'];
    $pedido_alerta 			= $_POST['pedidos_alerta'];

	/* Crear post pedidos */
	$post = array(
		'post_title'	=> wp_strip_all_tags($pedido_modelo),
		'post_content'	=> $pedido_observaciones,
		'post_status'	=> 'publish',
		'post_type' 	=> 'pedidos'
	);

	$pedido_id = wp_insert_post($post);

	update_post_meta($pedido_id,'pedidos_piezas',$pedido_piezas);
	update_post_meta($pedido_id,'pedidos_cliente',$pedido_cliente);
	update_post_meta($pedido_id,'pedidos_entrega',$pedido_entrega);
	update_post_meta($pedido_id,'pedidos_estatus', 'Abierto');
	update_post_meta($pedido_id,'pedidos_alerta',$pedido_alerta);
endif; ?>