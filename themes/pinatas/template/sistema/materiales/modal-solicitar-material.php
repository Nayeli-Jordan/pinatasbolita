<div id="modal-solicitar-material" class="modal modal-medium">
	<div class="fondo-modal"></div>
	<div class="modal-content">
		<em class="icon-close close-modal"></em>
		<p class="color-primary no-margin-top text-center fz-20 margin-bottom-20">Solicitar material</p>
		<form id="materialSolic-form" name="materialSolic-form" action=""  method="post" class="validation row" data-parsley-materialSolic>
			<div class="col s12 m6 input-field">
				<label for="materiales_cantidadReq">Cantidad requerida*:</label>
    			<input type="number" name="materiales_cantidadReq" id="materiales_cantidadReq" required  data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 m6 input-field">
				<label for="materiales_estatus">Solicitud*:</label>
				<select name="materiales_estatus" id="materiales_estatus" required  data-parsley-required-message="Campo obligatorio">
                    <option value="Normal">Normal</option>
                    <option value="Media">Media</option>
                    <option value="Urgente">Urgente</option>
                </select>
			</div>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitMaterialSolic" name="mb_submitMaterialSolic" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitMaterialSolic" value="post" />
				<?php wp_nonce_field( 'materialSolic-form' ); ?>	
			</div>
		</form>
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitMaterialSolic'] )):

    $material_nombre     		= $materialName;
    $material_cantidad      	= $cantidad;
    $material_observaciones 	= $materialContent;
    $material_cantidadReq  		= $_POST['materiales_cantidadReq'];
    $material_estatus   		= $_POST['materiales_estatus'];

	/* Enviar email */
	/* Cuerpo mensaje */
	include (TEMPLATEPATH . '/template/sistema/mail-body.php'); 
	$mailHeader	.= '<p style="margin-bottom: 20px;">Se ha enviado este email solicitando el siguiente material:</p>';

	$mailBody = '<p>Material: ' . $material_nombre . '</p>';
	$mailBody .= '<p>Cantidad actual: ' . $material_cantidad . '</p>';
	$mailBody .= '<p style="margin-bottom: 30px;">Observaciones: ' . $material_observaciones . '</p>';
	$mailBody .= '<p>Cantidad solicitada: ' . $material_cantidadReq . '</p>';
	$mailBody .= '<p>Estatus: ' . $material_estatus . '</p>';

	$message = $mailHeader . $mailBody . $mailFooter;
	/* Send email */
	$to 		= "nayeli@queonda.com.mx";
    $subject 	= "Solicitud de material PB";
    wp_mail($to, $subject, $message);
endif; ?>