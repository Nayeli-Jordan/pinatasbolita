<?php $today = date("Y-m-d"); ?>
<div id="modal-cerrar-pedido" class="modal modal-medium">
	<div class="fondo-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Cerrar pedido</p>
		<p class="text-center margin-bottom-20">Cierra el pedido únicamente si ya se ha realizado la entrega y se ha pagado en su totalidad</p>
		<form id="closepedido-form" name="closepedido-form" action=""  method="post" class="validation row" data-parsley-pedido>
			<div class="col s12 input-field">
				<label for="pedidos_estatus">Estatus pedido*:</label>
				<select name="pedidos_estatus" id="pedidos_estatus" required  data-parsley-required-message="Campo obligatorio">
    				<option value="<?php echo $estatus; ?>"><?php echo $estatus; ?></option>
                    <option value="Cerrado">Cerrado</option>
                </select>
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

    $pedido_estatus      	= $_POST['pedidos_estatus'];

	/* Crear post pedidos */
	$post = array(
		'ID'           		=> $pedido_id,
	);

	$pedido_id = wp_update_post($post);

	update_post_meta($pedido_id,'pedidos_estatus',$pedido_estatus);
endif; ?>