<?php //$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<div id="notice-pedido-actualizado" class="modal">
	<div class="fondo-modal"></div>
	<div class="modal-content text-center">
		<!-- <a href="<?php echo $actual_link; ?>" class="modal-redirect"><em class="icon-close"></em></a> -->
		<i class="icon-close close-modal"></i>
		<p class="color-primary text-center margin-bottom-20 fz-20">Pedido actualizado</p>
		<p class="fz-16">Se ha guardado la información del pedido.</p>
	</div>
</div>	