<?php /* Crea el registro de los ingresos y egresos cada último del mes */
	
	get_header(); 
	$today       	= date("d-m-Y");
	$current_day    = date("Y-m-d");
	$latsDayMonth   = date("Y-m-t", strtotime($current_day));

	$current_date	= date("M Y");
	$current_year 	= date('Y');
	$current_month 	= date('m');
	if (have_posts()) : while (have_posts()) : the_post(); 
		/* Cuerpo mensaje */
		include (TEMPLATEPATH . '/template/sistema/mail-body.php');
		$mailBody = ''; ?>

		<section class="[ container ] color-light padding-bottom-100">
		<?php 
			$mailBody .= '<table>';
				$mailBody .= '<thead>
					<tr>
						<th colspan="4">Ingresos</th>
					</tr>
					<tr>
						<th style="width: 45%">Concepto</th>
						<th style="width: 10%">Cantidad</th>
						<th style="width: 15%">Categoría</th>
						<th style="width: 20%">Fecha</th>
					</tr>
				</thead>';
				$mailBody .= '<tbody>';

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

						$tIngreso = $tIngreso + $cantidad;

						$mailBody .= '<tr>
							<td>' . $cuentaName . '</td>
							<td>$' . $cantidad . '</td>
							<td>' . $categoria . '</td>
							<td><small>' . $cuentaDate .'</small></td>
						</tr>';

		            endwhile;
				} wp_reset_postdata();

				$mailBody .= '</tbody>';
				$mailBody .= '<tfoot>
					<tr>
						<td style="width: 40%">Total Ingresos:</td>
						<td style="width: 20%">$' . $tIngreso . '</td>
					</tr>
				</tfoot>';
			$mailBody .= '</table>';

			$mailBody .= '<table>';
				$mailBody .= '<thead>
					<tr>
						<th colspan="4">Egresos</th>
					</tr>
					<tr>
						<th style="width: 45%">Concepto</th>
						<th style="width: 10%">Cantidad</th>
						<th style="width: 15%">Categoría</th>
						<th style="width: 20%">Fecha</th>
					</tr>
				</thead>';
				$mailBody .= '<tbody>';

				$tEgreso = 0;
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

						$tEgreso = $tEgreso + $cantidad;

						$mailBody .= '<tr>
							<td>' . $cuentaName . '</td>
							<td>$' . $cantidad . '</td>
							<td>' . $categoria . '</td>
							<td><small>' . $cuentaDate .'</small></td>
						</tr>';

		            endwhile;
				} wp_reset_postdata();

				$mailBody .= '</tbody>';
				$mailBody .= '<tfoot>
					<tr>
						<td style="width: 40%">Total Egresos:</td>
						<td style="width: 20%">$' . $tEgreso . '</td>
					</tr>
				</tfoot>';
			$mailBody .= '</table>';

			$mailBody .= '<p>Estado del MES hasta el ' . $today . '</p>';

			$tCuenta = $tIngreso - $tEgreso;

			$mailBody .= '<table>
				<thead>
					<tr>
						<th style="width: 30%">Periodo</th>
						<th style="width: 20%">Ingresos</th>
						<th style="width: 20%">Egresos</th>
						<th style="width: 30%">Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>' .$current_date . '</td>
						<td>$' .$tIngreso . '</td>
						<td>$' .$tEgreso . '</td>
						<td>$' .$tCuenta . '</td>
					</tr>
				</tbody>
			</table>';			

			echo $mailBody;

			/* Guardar Registro */
			if ($current_day === $latsDayMonth) {

				echo "<p>Se ha guardado el registro del mes.</p>";

				$post = array(
				'post_title'	=> wp_strip_all_tags($current_date),
				'post_content'	=> $mailBody,
				'post_status'	=> 'private',
				'post_type' 	=> 'registro'
				);
				$registro_id = wp_insert_post($post);
				update_post_meta($registro_id,'registro_ingreso',$tIngreso);
				update_post_meta($registro_id,'registro_egreso',$tEgreso);
				update_post_meta($registro_id,'registro_total',$tCuenta);

			 	/* Send email */
				$to 		= "nayeli@queonda.com.mx";
			    $subject 	= "Registro Mensual PB";

			    $mailHeader .= '<p style="margin-bottom: 20px;">Registro Mensual | Ingresos - Egresos</p>';
				$message = $mailHeader . $mailBody . $mailFooter;
			    wp_mail($to, $subject, $message);

			} else {
				echo '<p class="margin-top: 30px;">No se ha guardado el registro, aún no es fin del mes</p>';
			}
			?>
		</section>
	<?php endwhile; endif; 
get_footer(); ?>