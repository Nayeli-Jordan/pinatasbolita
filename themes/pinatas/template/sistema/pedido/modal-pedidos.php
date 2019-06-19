<div id="modal-pedidos_<?php echo $productId; ?>" class="modal modal-pedidos">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<i class="icon-close close-modal"></i>
		<p class="color-primary text-center margin-bottom-20 fz-20">Pedidos <span class="uppercase"><?php echo $productName; ?></span></p>
		<div class="row margin-bottom-10 hide-on-sm-and-down">
			<div class="col s12 m4 color-primary"><p>Cliente</p></div>
			<div class="col s12 m2 color-primary"><p>Piezas</p></div>
			<div class="col s12 m4 color-primary"><p>Entrega</p></div>
		</div>
		<?php 
		$argsPedido = array(
		    'post_type' 		=> 'pedidos',
		    'posts_per_page' 	=> -1,    
			'orderby' 			=> 'date',
			'order' 			=> 'ASC',
			'title' 			=> $productName,
			'meta_query'	=> array(
				array(
					'key'		=> 'pedidos_estatus',
					'value'		=> 'Abierto',
					'compare'	=> '='
				)
			)
		);
		$loopPedido 	= new WP_Query( $argsPedido );
		$noPedidos 		= 0;
		$noPiezas 		= 0;
		if ( $loopPedido->have_posts() ) {
		    while ( $loopPedido->have_posts() ) : $loopPedido->the_post();
		    	$noPedidos ++;
		    	$pedido_id  = get_the_ID();
				$piezas   = get_post_meta( $pedido_id, 'pedidos_piezas', true );
				$cliente  = get_post_meta( $pedido_id, 'pedidos_cliente', true );
				$entrega  = get_post_meta( $pedido_id, 'pedidos_entrega', true ); 

				/* Calcular total piezas de este modelo */
				$noPiezas = $noPiezas + $piezas;

				/* Cambiar formato fecha */
				setlocale(LC_ALL,"es_ES");
		        $entrega = strftime("%d/%B/%Y", strtotime($entrega)); ?>

				<div class="row margin-bottom-10">
					<div class="col s12 m4"><p><?php echo $cliente; ?></p></div>
					<div class="col s12 m2"><p><?php echo $piezas; ?> <span class="hide-on-med-and-up">piezas</span></p></div>
					<div class="col s12 m4"><p><?php echo $entrega; ?></p></div>
					<div class="col s12 m2"><p><a href="<?php echo get_permalink(); ?>" class="color-primary">Ver</a></p></div>
				</div>

		    <?php endwhile;
		} wp_reset_postdata(); ?>
	</div>
</div>	