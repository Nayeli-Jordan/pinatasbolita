<div id="modal-nuevo-egreso" class="modal modal-medium">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Registrar nuevo egreso</p>
		<form id="egreso-form" name="egreso-form" action=""  method="post" class="validation row" data-parsley-egreso>
			<div class="col s12 input-field">
				<label for="cuenta_concepto">Concepto*:</label>
    			<input type="text" name="cuenta_concepto" id="cuenta_concepto" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 m6 input-field">
				<label for="cuenta_cantidad">Cantidad*:</label>
    			<input type="number" min="0" name="cuenta_cantidad" id="cuenta_cantidad">
			</div>
			<div class="col s12 m6 input-field">
				<label for="cuenta_categoria">Categoría*:</label>
    			<select name="cuenta_categoria" id="cuenta_categoria" required  data-parsley-required-message="Campo obligatorio">
                    <option value="Materiales">Materiales</option>
                    <option value="Servicios">Servicios</option>
                    <option value="Salarios">Salarios</option>
                    <option value="Viveres">Viveres</option>
                    <option value="Otros">Otros</option>
                </select>
			</div>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitEgreso" name="mb_submitEgreso" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitEgreso" value="post" />
				<?php wp_nonce_field( 'egreso-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEgreso'] )):

    $cuenta_concepto     	= $_POST['cuenta_concepto'];
    $cuenta_cantidad      	= $_POST['cuenta_cantidad'];
    $cuenta_categoria       = $_POST['cuenta_categoria'];

	/* Crear post clientes */
	$post = array(
		'post_title'	=> wp_strip_all_tags($cuenta_concepto),
		'post_status'	=> 'private',
		'post_type' 	=> 'cuenta'
	);

	$cuenta_id = wp_insert_post($post);

	update_post_meta($cuenta_id,'cuenta_tipo', 'Egreso');
	update_post_meta($cuenta_id,'cuenta_cantidad',$cuenta_cantidad);
	update_post_meta($cuenta_id,'cuenta_categoria',$cuenta_categoria);
endif; ?>