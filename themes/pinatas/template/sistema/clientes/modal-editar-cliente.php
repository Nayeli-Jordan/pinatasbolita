<div id="modal-editar-cliente" class="modal modal-medium">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Editar cliente <?php echo $clienteName; ?></p>
		<form id="editcliente-form" name="editcliente-form" action=""  method="post" class="validation row" data-parsley-cliente>
			<div class="col s12 m6 input-field">
				<label for="clientes_nivel">Nivel*:</label>
				<select name="clientes_nivel" id="clientes_nivel" required  data-parsley-required-message="Campo obligatorio">
                    <option value="<?php echo $nivel; ?>"><?php echo $nivel; ?></option>
                    <option value="Normal">Normal</option>
                    <option value="Plata">Plata</option>
                    <option value="Oro">Oro</option>
                </select>
			</div>
			<div class="col s12 m6 input-field">
				<label for="clientes_correo">Correo:</label>
    			<input type="email" name="clientes_correo" id="clientes_correo" value="<?php echo $correo; ?>">
			</div>
			<div class="col s12 m6 input-field">
				<label for="clientes_cel">Celular:</label>
    			<input type="tel" name="clientes_cel" id="clientes_cel" value="<?php echo $cel; ?>">
			</div>
			<div class="col s12 m6 input-field">
				<label for="clientes_tel">Teléfono:</label>
    			<input type="tel" name="clientes_tel" id="clientes_tel" value="<?php echo $tel; ?>">
			</div>
			<div class="col s12 input-field">
				<label for="clientes_direccion">Dirección:</label>
    			<input type="text" name="clientes_direccion" id="clientes_direccion" value="<?php echo $direccion; ?>">
			</div>
			<div class="col s12 input-field">
				<label for="clientes_observaciones">Observaciones:</label>
    			<textarea name="clientes_observaciones" id="clientes_observaciones" placeholder="Otros detalles del cliente."><?php echo $clienteContent; ?></textarea>
			</div>	
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitEditCliente" name="mb_submitEditCliente" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitEditCliente" value="post" />
				<?php wp_nonce_field( 'editcliente-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditCliente'] )):

    $cliente_nivel      	= $_POST['clientes_nivel'];
    $cliente_correo      	= $_POST['clientes_correo'];
    $cliente_cel        	= $_POST['clientes_cel'];
    $cliente_tel        	= $_POST['clientes_tel'];
    $cliente_direccion 		= $_POST['clientes_direccion'];
    $cliente_observaciones 	= $_POST['clientes_observaciones'];

	/* Crear post clientes */
	$post = array(
		'ID'           		=> $cliente_id,
		'post_content'		=> $cliente_observaciones
	);

	$cliente_id = wp_update_post($post);

	update_post_meta($cliente_id,'clientes_nivel',$cliente_nivel);
	update_post_meta($cliente_id,'clientes_correo',$cliente_correo);
	update_post_meta($cliente_id,'clientes_cel',$cliente_cel);
	update_post_meta($cliente_id,'clientes_tel',$cliente_tel);
	update_post_meta($cliente_id,'clientes_direccion',$cliente_direccion);
endif; ?>