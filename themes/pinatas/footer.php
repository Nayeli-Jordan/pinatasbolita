			<?php if (!is_home()) : ?>
				<footer>
					<?php if (!is_page('stock-pinatas') && !is_singular('pedidos') && !is_singular('clientes') && !is_page('contabilidad')) : ?>
						<div class="text-center">
							<div class="btn btn-scroll btn-caracteristicas">Características</div>
							<div class="btn btn-scroll btn-dcomprar">Dónde Comprar</div>
							<div class="btn btn-scroll btn-distribuidores">Quiero ser distribuidor</div>
						</div>
						<div class="info-footer">
							<div id="content-caracteristicas" class="container text-center padding-top-50 hide">
								<h3 class="uppercase color-light margin-bottom-30 text-shadow-purple">Características</h3>
								<div class="row">
									<div class="col s12 hide-on-med-and-up color-light">
										<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> 6 Kg de capacidad</em></p>
										<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> No exponer al fuego</em></p>
										<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> No exponer al agua</em></p>
										<p class="fz-16 margin-bottom-30 text-shadow-gray"><em><span class="color-primary">-</span> No exponer al sol</em></p>
									</div>
									<div class="col s6 m4">
										<img src="<?php echo THEMEPATH; ?>images/pinata-larga.png" class="responsive-img">
									</div>
									<div class="col m4 hide-on-sm-and-down color-light">
										<p class="fz-20 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> 6 Kg de capacidad</em></p>
										<p class="fz-20 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> No exponer al fuego</em></p>
										<p class="fz-20 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> No exponer al agua</em></p>
										<p class="fz-20 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> No exponer al sol</em></p>
										<div class="margin-top-50">
											<p class="fz-16 margin-bottom-10 text-shadow-gray">PALAZO</p>
											<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> Incluye 7m de lazo</em></p>
											<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> Diferentes colores</em></p>
											<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> Hecho de madera</em></p>
											<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> Medida: 70 cm</em></p>
											<img src="<?php echo THEMEPATH; ?>images/dibujo-palazo.png" class="responsive-img margin-top-20">
										</div>
									</div>
									<div class="col s6 m4">
										<img src="<?php echo THEMEPATH; ?>images/pinata-corta.png" class="responsive-img">
									</div>
									<div class="col s12 hide-on-med-and-up color-light margin-top-30">
										<p class="fz-16 margin-bottom-10 text-shadow-gray">PALAZO</p>
										<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> Incluye 7m de lazo</em></p>
										<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> Diferentes colores</em></p>
										<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> Hecho de madera</em></p>
										<p class="fz-16 margin-bottom-10 text-shadow-gray"><em><span class="color-primary">-</span> Medida: 70 cm</em></p>
										<img src="<?php echo THEMEPATH; ?>images/dibujo-palazo.png" class="responsive-img margin-top-20">
									</div>
								</div>
							</div>
							<div id="content-ubicacion" class="container padding-top-50 color-light hide text-center-sm-and-down">
								<h3 class="uppercase margin-bottom-30 text-center text-shadow-purple">Dónde Comprar</h3>
								<div class="row">							
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
												<h4 class="color-primary"><?php the_title(); ?></h4>
												<p><?php the_content(); ?></p>
											</div>	
									<?php $i ++; endwhile; wp_reset_postdata();
									endif; ?>
								</div>
							</div>
							<div id="content-proveedores" class="container padding-top-50 color-light hide">
								<h3 class="uppercase margin-bottom-30 text-center text-shadow-purple">Quiero ser distribuidor</h3>
								<div class="row text-center">							
									<div class="col s12 m8 offset-m2 l6 offset-l3 color-light">
										<p class="fz-20 margin-bottom-10 text-shadow-gray"><span class="color-primary">Contáctanos</span> al <a class="color-primary" href="tel:525558683573">(55) 5868-3573</a> o escríbenos por <span class="color-primary">Whatsapp</span> al <a class="color-primary" href="https://wa.me/5215551017159">5551017159</a></p>
									</div>
								</div>
							</div>						
						</div>
					<?php endif; ?>
					<p class="text-center color-light margin-top-30 text-shadow-gray"><a href="<?php echo SITEURL; ?>aviso-de-privacidad" target="_blank">Aviso de privacidad</a><br>Derechos Reservados Piñatas Bolita <?php echo date("Y"); ?><br>Creado por <a href="https://queonda.com.mx" target="_blank">¿Qué Onda? <span class="bg-image bg-contain logo-qo" style="background-image: url(<?php echo THEMEPATH; ?>images/qo.png)"></span></a></p>
				</footer>
			<?php endif; ?>
		</div> <!-- end main-body -->
		<?php wp_footer(); ?>
	</body>
</html>