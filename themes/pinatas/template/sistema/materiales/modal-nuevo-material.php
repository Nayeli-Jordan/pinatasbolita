<div id="modal-nuevo-material" class="modal modal-medium">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Registrar nuevo material</p>
		<form id="material-form" name="material-form" action=""  method="post" class="validation row" data-parsley-material>
			<div class="col s12 m6 input-field">
				<label for="materiales_nombre">Nombre material*:</label>
    			<input type="text" name="materiales_nombre" id="materiales_nombre" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 m6 input-field">
				<label for="materiales_cantidad">Cantidad*:</label>
    			<input type="number" min="0" name="materiales_cantidad" id="materiales_cantidad" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 m12 input-field">
				<label for="materiales_presentacion">Presentación:</label>
    			<input type="text" name="materiales_presentacion" id="materiales_presentacion">
			</div>
			<div class="col s12 input-field">
				<label for="materiales_observaciones">Observaciones:</label>
    			<textarea name="materiales_observaciones" id="materiales_observaciones" placeholder="Otros detalles del material."></textarea>
			</div>
			<div class="col s12 input-field margin-top-30">
				<label for="materiales_cantidad">¿Agregar egreso? ($)</label>
    			<input type="number" min="0" name="materiales_egreso" id="materiales_egreso" placeholder="100">
			</div>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitMaterial" name="mb_submitMaterial" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitMaterial" value="post" />
				<?php wp_nonce_field( 'material-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitMaterial'] )):

    $material_nombre     		= $_POST['materiales_nombre'];
    $material_cantidad      	= $_POST['materiales_cantidad'];
    $material_observaciones 	= $_POST['materiales_observaciones'];

	/* Crear post materiales */
	$post = array(
		'post_title'	=> wp_strip_all_tags($material_nombre),
		'post_content'	=> $material_observaciones,
		'post_status'	=> 'private',
		'post_type' 	=> 'materiales'
	);

	$material_id = wp_insert_post($post);

	update_post_meta($material_id,'materiales_cantidad',$material_cantidad);

	/* Crear egreso */
    $cuenta_cantidad      	= $_POST['materiales_egreso'];
    $cuenta_categoria       = 'Materiales';

	/* Crear post cuenta */
	if ($cuenta_cantidad != '') {
		$post = array(
			'post_title'	=> wp_strip_all_tags($material_nombre),
			'post_status'	=> 'private',
			'post_type' 	=> 'cuenta'
		);

		$cuenta_id = wp_insert_post($post);

		update_post_meta($cuenta_id,'cuenta_tipo', 'Egreso');
		update_post_meta($cuenta_id,'cuenta_cantidad',$cuenta_cantidad);
		update_post_meta($cuenta_id,'cuenta_categoria',$cuenta_categoria);		
	}

endif; ?>