<?php $today = date("Y-m-d"); ?>
<div id="modal-nuevo-pedido" class="modal modal-medium">
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Registrar nuevo pedido</p>
		<form id="orden-form" name="orden-form" action=""  method="post" class="validation row" data-parsley-orden>
			<div class="col s12 m6 input-field">
				<label for="pedido_modelo">Modelo*:</label>
				<div class="content_pedido_modeloFabrica">
	                <select name="pedido_modeloFabrica" id="pedido_modeloFabrica">
	                	<option value=""></option>
	           			<?php
					        $args = array(
					            'post_type' => 'product',
					            'posts_per_page' => -1,
					            'orderby' => 'title',
					            'order' => 'ASC'
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
			</div>
			<div class="col s12 m6 input-field">
				<label for="pedido_piezas">No. de piezas*:</label>
    			<input type="number" min="0" name="pedido_piezas" id="pedido_piezas" placeholder="0" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 m6 input-field clearfix">
				<label for="pedido_cliente">Cliente*:</label>
				<select name="pedido_cliente" id="pedido_cliente" required  data-parsley-required-message="Campo obligatorio">
    				<option value=""></option>
                    <option value="estatus_abierta">Venta abierta</option>
                    <option value="estatus_cerrada">Venta cerrada</option>
                    <option value="estatus_cancelada">Venta cancelada</option>
                </select>
			</div>
			<div class="col s12 m6 input-field">
				<label for="pedido_fecha">Fecha de entrega*:</label>
   				<input type="date" min="<?php echo $today; ?>" name="pedido_fecha" id="pedido_fecha" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 input-field">
				<label for="pedido_observaciones">Observaciones:</label>
    			<textarea name="pedido_observaciones" id="pedido_observaciones" placeholder="Otros detalles del pedido, la entrega, el pago, etc."></textarea>
			</div>	
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitOrden" name="mb_submitOrden" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitOrden" value="post" />
				<?php wp_nonce_field( 'orden-form' ); ?>	
			</div>
		</form>
	</div>
</div>
