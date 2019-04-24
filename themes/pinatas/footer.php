			<?php if (!is_home()) : ?>
				<footer>
					<div class="text-center">
						<div class="btn btn-caracteristicas">Características</div>
						<div class="btn btn-ubicacion">Ubicación</div>
						<div class="btn btn-proveedores">Proveedores</div>
					</div>
					<div id="content-caracteristicas" class="container text-center padding-top-50 hide">
						<h3 class="uppercase color-light margin-bottom-30">Características</h3>
						<div class="row">
							<div class="col s12 hide-on-med-and-up color-light">
								<p class="fz-16 margin-bottom-10"><em>- 6 Kg de capacidad</em></p>
								<p class="fz-16 margin-bottom-10"><em>- No exponer al fuego</em></p>
								<p class="fz-16 margin-bottom-10"><em>- No exponer al agua</em></p>
								<p class="fz-16 margin-bottom-30"><em>- No exponer al sol</em></p>
							</div>
							<div class="col s6 m4">
								<img src="<?php echo THEMEPATH; ?>images/pinata-larga.png" class="responsive-img">
							</div>
							<div class="col m4 hide-on-sm-and-down color-light">
								<p class="fz-20 margin-bottom-10"><em>- 6 Kg de capacidad</em></p>
								<p class="fz-20 margin-bottom-10"><em>- No exponer al fuego</em></p>
								<p class="fz-20 margin-bottom-10"><em>- No exponer al agua</em></p>
								<p class="fz-20 margin-bottom-10"><em>- No exponer al sol</em></p>
							</div>
							<div class="col s6 m4">
								<img src="<?php echo THEMEPATH; ?>images/pinata-corta.png" class="responsive-img">
							</div>
						</div>
					</div>
					<div id="content-ubicacion" class="container padding-top-50 color-light hide text-center-sm-and-down">
						<h3 class="uppercase margin-bottom-30 text-center">Ubicación</h3>
						<div class="row">
							<div class="col s12 m4 margin-bottom-30 text-right-medium-and-up">
								<h4>Austria 5, Col. Centro Urbano, Cuautitlán Izcalli, Edo. Méx.</h4>
							</div>
							<div class="col s12 m4 margin-bottom-30">
								<div class="content-map margin-auto">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d939.2544322201544!2d-99.21060240268032!3d19.669249008942593!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x265f9ce7869dbc7a!2sPi%C3%B1atas+Bolita!5e0!3m2!1ses-419!2smx!4v1553190126194" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
								</div>								
							</div>
							<div class="col s12 m4 margin-bottom-30">
								<h5><a href="https://www.facebook.com/PinatasBolitaOficial/" target="_blank" class="color-light"><em class="icon-facebook"></em>/pinatasbolita</a></h5>
							</div>
						</div>
					</div>
					<div id="content-proveedores" class="container padding-top-50 color-light hide">
						<h3 class="uppercase margin-bottom-30 text-center">Proveedores</h3>
						<div class="row text-center">
						<?php
							$proveedor_args = array(
								'post_type' 		=> 'pb_proveedor',
								'posts_per_page' 	=> -1,
							);
							$proveedor_query = new WP_Query( $proveedor_args );
							if ( $proveedor_query->have_posts() ) : 
								$i = 1;
								while ( $proveedor_query->have_posts() ) : $proveedor_query->the_post(); ?>
									<div class="col s12 m4 margin-bottom-30">
										<h4><?php the_title(); ?></h4>
										<p><?php the_content(); ?></p>
									</div>	
							<?php $i ++; endwhile; wp_reset_postdata();
							endif; ?>
						</div>
					</div>					
					<div class="bg-distribuidor"><h4 class="hide">¿Deseas ser distribuidor? Contáctanos: 5558683573</h4></div>
				</footer>
			<?php endif; ?>
		</div> <!-- end main-body -->
		<?php wp_footer(); ?>
	</body>
</html>