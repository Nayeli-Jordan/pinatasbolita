<?php get_header(); 
	$today       	= date("d-m-Y");
	$current_date	= date("M Y");
	$current_year 	= date('Y');
	$current_month 	= date('m');
	if (have_posts()) : while (have_posts()) : the_post(); 
		include (TEMPLATEPATH . '/template/sistema/contabilidad/modal-ingreso.php');
		include (TEMPLATEPATH . '/template/sistema/contabilidad/modal-egreso.php');
		include (TEMPLATEPATH . '/template/sistema/contabilidad/notice/notice-nuevo-ingreso.php');
		include (TEMPLATEPATH . '/template/sistema/contabilidad/notice/notice-nuevo-egreso.php'); ?>
		<section class="[ container ] color-light padding-bottom-100">
			<div class="row">
				<div class="col s12 l6 margin-bottom-30">
					<div class="text-right margin-bottom-20">
						<p id="nuevo-ingreso" class="btn btn-primary margin-left-right-10 open-modal">Agregar Ingreso</p>
					</div>
					<div id="content_table" class="content_table_complete">
						<table class="table-sistema table-head_mobile table-contabilidad">
							<!-- Medium and down -->
							<?php include (TEMPLATEPATH . '/template/sistema/contabilidad/ingreso-thead.php'); ?>
							<tbody>
							<?php
								$tIngreso = 0;
						        $args = array(
						            'post_type' 	 => 'cuenta',
						            'posts_per_page' => -1,
						            'orderby' 		 => 'date',
						            'order' 		 => 'ASC',
									'year'     		 => $current_year,
									'monthnum' 		 => $current_month,
									'meta_query'	=> array(
										array(
											'key'		=> 'cuenta_tipo',
											'value'		=> 'Ingreso',
											'compare'	=> '='
										)
									)
						        );
						        $loop = new WP_Query( $args );
						        if ( $loop->have_posts() ) { 
						            while ( $loop->have_posts() ) : $loop->the_post(); 
						            	$cuenta_id 	= get_the_ID();
				   						$cuentaName = get_the_title( $cuenta_id );
				   						$cuentaDate = get_the_date( 'j-M-y' );
										$tipo       = get_post_meta( $cuenta_id, 'cuenta_tipo', true );
										$cantidad   = get_post_meta( $cuenta_id, 'cuenta_cantidad', true );
										$categoria  = get_post_meta( $cuenta_id, 'cuenta_categoria', true );

										$tIngreso = $tIngreso + $cantidad; ?>

										<tr>
											<td><?php echo $cuentaName; ?></td>
											<td class="text-center">$<?php echo $cantidad; ?></td>
											<td><?php echo $categoria; ?></td>
											<td class="text-center"><small><?php echo $cuentaDate; ?></small></td>
										</tr>

						            <?php endwhile;
								} wp_reset_postdata(); ?>
							</tbody>					
							<!-- Medium and down -->
							<?php include (TEMPLATEPATH . '/template/sistema/contabilidad/ingreso-tfoot.php'); ?>
						</table>				
					</div>				
				</div>
				<div class="col s12 l6 margin-bottom-30">
					<div class="text-right margin-bottom-20">
						<p id="nuevo-egreso" class="btn btn-primary margin-left-right-10 open-modal">Agregar egreso</p>
					</div>
					<div id="content_table">
						<table class="table-sistema table-head_mobile table-contabilidad">
							<!-- Medium and down -->
							<?php include (TEMPLATEPATH . '/template/sistema/contabilidad/egreso-thead.php'); ?>
							<tbody>
							<?php
								$tEgreso = 0;
						        $args = array(
						            'post_type' 	 => 'cuenta',
						            'posts_per_page' => -1,
						            'orderby' 		 => 'date',
						            'order' 		 => 'ASC',
									'year'     		 => $current_year,
									'monthnum' 		 => $current_month,
									'meta_query'	 => array(
										array(
											'key'		=> 'cuenta_tipo',
											'value'		=> 'Egreso',
											'compare'	=> '='
										)
									)
						        );
						        $loop = new WP_Query( $args );
						        if ( $loop->have_posts() ) { 
						            while ( $loop->have_posts() ) : $loop->the_post(); 
						            	$cuenta_id 	= get_the_ID();
				   						$cuentaName = get_the_title( $cuenta_id );
				   						$cuentaDate = get_the_date( 'j-M-y' );
										$tipo       = get_post_meta( $cuenta_id, 'cuenta_tipo', true );
										$cantidad   = get_post_meta( $cuenta_id, 'cuenta_cantidad', true );
										$categoria  = get_post_meta( $cuenta_id, 'cuenta_categoria', true ); 

										$tEgreso = $tEgreso + $cantidad;?>

										<tr>
											<td><?php echo $cuentaName; ?></td>
											<td class="text-center">$<?php echo $cantidad; ?></td>
											<td><?php echo $categoria; ?></td>
											<td class="text-center"><small><?php echo $cuentaDate; ?></small></td>
										</tr>

						            <?php endwhile;
								} wp_reset_postdata(); ?>
							</tbody>					
							<!-- Medium and down -->
							<?php include (TEMPLATEPATH . '/template/sistema/contabilidad/egreso-tfoot.php'); ?>
						</table>				
					</div>						
				</div>
				<div class="col s12 margin-bottom-100">
					<p class="color-primary text-center margin-bottom-10">Estado del MES hasta el <?php echo $today; ?></p>
					<div id="content_table">
						<?php  $tCuenta = $tIngreso - $tEgreso; ?>
						<table class="table-sistema table-head_mobile table-contabilidad">
							<thead>
								<tr>
									<th class="width-30p">Periodo</th>
									<th class="width-20p">Egresos</th>
									<th class="width-20p">Ingresos</th>
									<th class="width-30p">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center"><?php echo $current_date; ?></td>
									<td class="text-center">$<?php echo $tIngreso; ?></td>
									<td class="text-center">$<?php echo $tEgreso; ?></td>
									<td class="text-center <?php if ($tCuenta < 0) { echo 'color-alert'; } ?>">$<?php echo $tCuenta; ?></td>
								</tr>
							</tbody>
						</table>				
					</div>	
				</div>
				<div class="col s12">
					<p class="color-primary text-center margin-bottom-10">Registro de los ÚLTIMOS MESES</p>
					<div id="content_table">
						<table class="table-sistema table-head_mobile table-contabilidad">
							<thead>
								<tr>
									<th class="width-30p">Periodo</th>
									<th class="width-20p">Ingresos</th>
									<th class="width-20p">Egresos</th>
									<th class="width-30p">Total</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$tRegistro = 0;
						        $args = array(
						            'post_type' 	 => 'registro',
						            'posts_per_page' => 12,
						            'orderby' 		 => 'date',
						            'order' 		 => 'ASC',
						        );
						        $loop = new WP_Query( $args );
						        if ( $loop->have_posts() ) { 
									while ( $loop->have_posts() ) : $loop->the_post();$registro_id 	= get_the_ID();
										$registroName = get_the_title( $registro_id );
										$ingreso    = get_post_meta( $registro_id, 'registro_ingreso', true );
										$egreso     = get_post_meta( $registro_id, 'registro_egreso', true );
										$total      = get_post_meta( $registro_id, 'registro_total', true ); 

										$tRegistro = $tRegistro + $total; ?>

										<tr>
											<td class="text-center"><?php echo $registroName; ?></td>
											<td class="text-center">$<?php echo $ingreso; ?></td>
											<td class="text-center">$<?php echo $egreso; ?></td>
											<td class="text-center <?php if ($total < 0) { echo 'color-alert'; } ?>">$<?php echo $total; ?></td>
										</tr>

						            <?php endwhile;
								} wp_reset_postdata(); ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2" class="width-50p tdInvisible">-</td>
									<td class="width-20p">Total Registro:</td>
									<td class="width-30p">$<?php echo $tRegistro; ?></td>
								</tr>
							</tfoot>
						</table>				
					</div>	
				</div>
			</div>
		</section>
	<?php endwhile; endif; 
get_footer(); ?>