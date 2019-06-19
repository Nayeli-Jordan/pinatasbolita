<div id="modal-editar-alerta" class="modal modal-medium">
	<div class="fondo-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Editar alerta</p>
		<form id="editalerta-form" name="editalerta-form" action=""  method="post" class="validation row" data-parsley-alerta>
			<div class="col s12 input-field">
				<label for="pedidos_alerta">¿Cuántos días antes se te notifica?: <small>(0 para desactivar notificación)</small></label>
    			<input type="number" min="1" name="pedidos_alerta" id="pedidos_alerta" value="<?php echo $alerta; ?>" required data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitEditAlerta" name="mb_submitEditAlerta" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitEditAlerta" value="post" />
				<?php wp_nonce_field( 'editpedido-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditAlerta'] )):

    $pedido_alerta      	= $_POST['pedidos_alerta'];

	/* Crear post pedidos */
	$post = array(
		'ID'           		=> $pedido_id,
	);

	$pedido_id = wp_update_post($post);

	update_post_meta($pedido_id,'pedidos_alerta',$pedido_alerta);
endif; ?>