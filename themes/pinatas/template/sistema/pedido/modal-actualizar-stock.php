<div id="modal-actualizar-stock" class="modal modal-pedidos">
	<div class="exit-modal"></div>
	<div class="modal-content">
		<i class="icon-close close-modal"></i>
		<p class="color-primary text-center margin-bottom-20 fz-20">Actualizar stock</p>
		<form id="stock-form" name="stock-form" action=""  method="post" class="validation row" data-parsley-stock>
			<div class="col s12 m6 input-field">
				<label for="modelo_stock">Modelo*:</label>
                <select name="modelo_stock" id="modelo_stock" required data-parsley-required-message="Campo obligatorio">
                	<option value=""></option>
           			<?php
				        $args = array(
				            'post_type' 		=> 'product',
				            'posts_per_page' 	=> -1,
				            'orderby' 			=> 'title',
				            'order' 			=> 'ASC'
				        );
				        $loop = new WP_Query( $args );
				        $i = 1;
				        if ( $loop->have_posts() ) {
				            while ( $loop->have_posts() ) : $loop->the_post();	

				            	$productId      = get_the_ID();
                           		$productName 	= get_the_title( $productId );?>
								<option value="<?php echo $productId; ?>"><?php echo $productName; ?></option>
				            <?php $i ++; endwhile;
				        } 
				        wp_reset_postdata();
				    ?>
                </select>
			</div>
			<div class="col s12 m6 input-field">
				<label for="number_stock">Actualizar a:</label>
				<input type="number" name="number_stock" id="number_stock" min="0" placeholder="0"required data-parsley-required-message="Campo obligatorio">
			</div>
			<div class="col s12 text-right margin-top">
				<input type="submit" id="mb_submitStock" name="mb_submitStock" class="btn btn-primary inline-block" value="Guardar" />
				<input type="hidden" name="send_submitStock" value="post" />
				<?php wp_nonce_field( 'stock-form' ); ?>	
			</div>
		</form>	
	</div>
</div>
<?php if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['send_submitStock'] )):

    $modeloStock = $_POST['modelo_stock'];
    $numberStock = $_POST['number_stock'];
	/*Actualizar stock */
	update_post_meta($modeloStock, '_stock', $numberStock);

endif; ?>