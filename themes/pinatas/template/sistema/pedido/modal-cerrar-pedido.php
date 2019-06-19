<div id="modal-cerrar-pedido" class="modal modal-medium">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Cerrar pedido</p>
		<p class="text-center margin-bottom-20">Cierra el pedido únicamente si ya se ha realizado la entrega y se ha pagado en su totalidad</p>
		<form id="closepedido-form" name="closepedido-form" action=""  method="post" class="validation row" data-parsley-pedido>
			<div class="col s12 input-field">
				<label for="pedidos_estatus">¿Cerrar el pedido?*:</label>
				<select name="pedidos_estatus" id="pedidos_estatus" required  data-parsley-required-message="Campo obligatorio">
                    <option value="Cerrado">Sí, cerrar el pedido</option>
                </select>
			</div>
			<div class="col s12 input-field margin-top-20">
				<p class="color-primary">El stock actual de este modelo es de "<?php echo $stock ?>" piezas. ¿Deseas actualizarlo?</p>
				<label for="actualizar_stock">Actualizar a:</label>
				<input type="number" name="actualizar_stock" id="actualizar_stock" value="<?php echo $stock ?>" min="0">
			</div>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitClosePedido" name="mb_submitClosePedido" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitClosePedido" value="post" />
				<?php wp_nonce_field( 'closepedido-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitClosePedido'] )):

    $pedido_estatus      	= 'Cerrado';
    $newStock   		   	= $_POST['actualizar_stock'];

	/* Actualizar post pedido */
	$post = array(
		'ID'           		=> $pedido_id,
	);
	$pedido_id = wp_update_post($post);
	update_post_meta($pedido_id,'pedidos_estatus',$pedido_estatus);

	/*Actualizar stock */
	update_post_meta($productId, '_stock', $newStock);

endif; ?>