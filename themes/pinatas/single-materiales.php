<?php 
	get_header();
	global $post;
	
	while ( have_posts() ) : the_post(); 
		$material_id  	= get_the_ID();
		$post_id 		= get_the_ID();
		$materialName	= get_the_title( $material_id );
		$cantidad   	= get_post_meta( $material_id, 'materiales_cantidad', true );
		$presentacion  	= get_post_meta( $material_id, 'materiales_presentacion', true );
		$materialContent = $post->post_content;

		/* Editar material */
		include (TEMPLATEPATH . '/template/sistema/materiales/modal-editar-material.php');
		include (TEMPLATEPATH . '/template/sistema/notice/notice-material-actualizado.php');
?>
	<section id="single" class="container single-content">
		<div class="card-material">
			<p class="fz-20 margin-bottom-10 inline-block"><span class="color-primary"><?php echo $materialName; ?></span></p>
			<div class="inline-block float-right">
				<p id="editar-material" class="open-modal text-underline color-primary inline-block margin-right-10">Editar material</p>
			</div>
			<table class="width-100p text-left">
				<tr>
					<th class="color-primary width-30p">Cantidad</th>
					<th class="color-primary width-30p">Presentación</th>
					<th class="color-primary width-40p">Observaciones</th>
				</tr>
				<tr>
					<td><?php echo $cantidad; ?></td>
					<td><?php echo $presentacion; ?></td>
					<td><?php the_content(); ?></td>
				</tr>
			</table>
			<div class="row row-complete margin-top-30">
				<div class="col s12 text-right">
					<a href="<?php echo SITEURL; ?>stock-pinatas" class="btn btn-primary">Ir al stock</a>
				</div>
			</div>
		</div>
	</section>
<?php 
	endwhile; // end of the loop.
	get_footer(); 
?>