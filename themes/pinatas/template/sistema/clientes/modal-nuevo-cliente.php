<div id="modal-nuevo-cliente" class="modal modal-medium">
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Registrar nuevo cliente</p>
		<form id="cliente-form" name="cliente-form" action=""  method="post" class="validation row" data-parsley-cliente>
			<div class="col s12 m6 l8 input-field">
				<label for="clientes_nombre">Nombre cliente*:</label>
    			<input type="text" name="clientes_nombre" id="clientes_nombre" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 m6 l4 input-field">
				<label for="clientes_nivel">Nivel*:</label>
				<select name="clientes_nivel" id="clientes_nivel" required  data-parsley-required-message="Campo obligatorio">
                    <option value="Normal">Normal</option>
                    <option value="Plata">Plata</option>
                    <option value="Oro">Oro</option>
                </select>
			</div>
			<div class="col s12 m6 l4 input-field">
				<label for="clientes_correo">Correo:</label>
    			<input type="email" name="clientes_correo" id="clientes_correo">
			</div>
			<div class="col s12 m6 l4 input-field">
				<label for="clientes_cel">Celular:</label>
    			<input type="tel" name="clientes_cel" id="clientes_cel">
			</div>
			<div class="col s12 m6 l4 input-field">
				<label for="clientes_tel">Teléfono:</label>
    			<input type="tel" name="clientes_tel" id="clientes_tel">
			</div>
			<div class="col s12 input-field">
				<label for="clientes_direccion">Dirección:</label>
    			<input type="text" name="clientes_direccion" id="clientes_direccion">
			</div>
			<div class="col s12 input-field">
				<label for="clientes_observaciones">Observaciones:</label>
    			<textarea name="clientes_observaciones" id="clientes_observaciones" placeholder="Otros detalles del cliente."></textarea>
			</div>	
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitCliente" name="mb_submitCliente" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitCliente" value="post" />
				<?php wp_nonce_field( 'cliente-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitCliente'] )):

    $cliente_nombre     	= $_POST['clientes_nombre'];
    $cliente_nivel      	= $_POST['clientes_nivel'];
    $cliente_correo      	= $_POST['clientes_correo'];
    $cliente_cel        	= $_POST['clientes_cel'];
    $cliente_tel        	= $_POST['clientes_tel'];
    $cliente_direccion 		= $_POST['clientes_direccion'];
    $cliente_observaciones 	= $_POST['clientes_observaciones'];

	/* Crear post clientes */
	$post = array(
		'post_title'	=> wp_strip_all_tags($cliente_nombre),
		'post_content'	=> $cliente_observaciones,
		'post_status'	=> 'private',
		'post_type' 	=> 'clientes'
	);

	$cliente_id = wp_insert_post($post);

	update_post_meta($cliente_id,'clientes_nivel',$cliente_nivel);
	update_post_meta($cliente_id,'clientes_correo',$cliente_correo);
	update_post_meta($cliente_id,'clientes_cel',$cliente_cel);
	update_post_meta($cliente_id,'clientes_tel',$cliente_tel);
	update_post_meta($cliente_id,'clientes_direccion',$cliente_direccion);
endif; ?>