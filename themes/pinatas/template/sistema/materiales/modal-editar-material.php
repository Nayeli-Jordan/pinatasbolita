<div id="modal-editar-material" class="modal modal-medium">
	<div class="fondo-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Editar <?php echo $materialName; ?></p>
		<form id="editmaterial-form" name="editmaterial-form" action=""  method="post" class="validation row" data-parsley-material>
			<div class="col s12 input-field">
				<label for="materiales_cantidad">Cantidad:</label>
    			<input type="number" min="0" name="materiales_cantidad" id="materiales_cantidad" value="<?php echo $cantidad ?>">
			</div>
			<div class="col s12 input-field">
				<label for="materiales_presentacion">Presentación:</label>
    			<input type="text" name="materiales_presentacion" id="materiales_presentacion" value="<?php echo $presentacion; ?>">
			</div>
			<div class="col s12 input-field">
				<label for="materiales_observaciones">Observaciones:</label>
    			<textarea name="materiales_observaciones" id="materiales_observaciones" placeholder="Otros detalles del material."><?php echo $materialContent; ?></textarea>
			</div>	
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitEditMaterial" name="mb_submitEditMaterial" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitEditMaterial" value="post" />
				<?php wp_nonce_field( 'editmaterial-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitEditMaterial'] )):

    $material_cantidad      	= $_POST['materiales_cantidad'];
    $material_presentacion      = $_POST['materiales_presentacion'];
    $material_observaciones     = $_POST['materiales_observaciones'];

	/* Crear post materiales */
	$post = array(
		'ID'           		=> $material_id,
		'post_content'		=> $material_observaciones
	);

	$material_id = wp_update_post($post);

	update_post_meta($material_id,'materiales_cantidad',$material_cantidad);
	update_post_meta($material_id,'materiales_presentacion',$material_presentacion);
endif; ?>