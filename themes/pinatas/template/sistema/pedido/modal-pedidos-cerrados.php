<div id="modal-pedidos_<?php echo $productId; ?>_cerrados" class="modal modal-pedidos">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<i class="icon-close close-modal"></i>
		<p class="color-primary text-center margin-bottom-20 fz-20">Pedidos con <span class="uppercase"><?php echo $productName; ?></span> cerrados</p>
		<div class="row margin-bottom-10 hide-on-sm-and-down">
			<div class="col s12 m4 color-primary"><p>Cliente</p></div>
			<div class="col s12 m2 color-primary"><p>Piezas</p></div>
			<div class="col s12 m4 color-primary"><p>Entrega</p></div>
		</div>
		<?php 
		$modeloProduct = 'pedidos_modelo' . $productId;
		$piezasProduct = 'pedidos_piezas' . $productId;
		$argsPedido = array(
		    'post_type' 		=> 'pedidos',
		    'posts_per_page' 	=> -1,    
			'orderby' 			=> 'date',
			'order' 			=> 'ASC',
			'meta_query'	=> array(
				'relation' => 'AND', 
				array(
					'key'		=> 'pedidos_estatus',
					'value'		=> 'Cerrado',
					'compare'	=> '='
				), 
				array(
					'key'		=> $modeloProduct,
					'value'		=> $productName,
					'compare'	=> '='
				), 
				array(
					'key'		=> $piezasProduct,
					'value'		=> 1,
					'compare'	=> '>='
				)
			)
		);
		$loopPedido 	= new WP_Query( $argsPedido );
		$noCerradas 	= 0;
		//$noPiezasCerrada= 0;
		if ( $loopPedido->have_posts() ) {
		    while ( $loopPedido->have_posts() ) : $loopPedido->the_post();
		    	$noCerradas ++;
		    	$pedido_id  = get_the_ID();
				$piezas   = get_post_meta( $pedido_id, $piezasProduct, true );
				$cliente  = get_post_meta( $pedido_id, 'pedidos_cliente', true );
				$entrega  = get_post_meta( $pedido_id, 'pedidos_entrega', true ); 

				/* Calcular total piezas de este modelo */
				//$$noPiezasCerrada = $$noPiezasCerrada + $piezas;

				/* Cambiar formato fecha */
				setlocale(LC_ALL,"es_ES");
		        $entrega = strftime("%d/%B/%Y", strtotime($entrega)); ?>

				<div class="row margin-bottom-10">
					<div class="col s12 m4"><p><?php echo $cliente; ?></p></div>
					<div class="col s12 m2"><p><?php echo $piezas; ?> <span class="hide-on-med-and-up">piezas</span></p></div>
					<div class="col s12 m4"><p><?php echo $entrega; ?></p></div>
					<div class="col s12 m2"><p><a href="<?php echo get_permalink(); ?>" terget="_blank" class="color-primary">Ver</a></p></div>
				</div>

		    <?php endwhile;
		} wp_reset_postdata(); ?>
	</div>
</div>	