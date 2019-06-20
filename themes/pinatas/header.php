<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="es">
	<head>
		<meta charset="utf-8">
		<title><?php bloginfo('name'); ?></title>
		<!-- Sets initial viewport load and disables zooming -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- SEO -->
		<meta name="keywords" content="piñatas, piñatas infantiles, piñatas creativas, piñatas de princesas, piñatas de superheroes, fiestas infantiles, decoración para fiestas, eventos sociales">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<!-- Meta robots -->
		<meta name="robots" content="index, follow" />
		<meta name="googlebot" content="index, follow" />

		<!-- Favicon -->
		<link rel="icon" type="image/png" href="<?php echo THEMEPATH; ?>favicon/favicon-32x32.png" sizes="32x32" />
		<link rel="icon" type="image/png" href="<?php echo THEMEPATH; ?>favicon/favicon-16x16.png" sizes="16x16" />

		<!-- Facebook, Twitter metas -->
		<meta property="og:title" content="<?php bloginfo('name'); ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo site_url(); ?>" />
		<meta property="og:image" content="<?php echo THEMEPATH; ?>images/share.png">
		<meta property="og:description" content="<?php bloginfo('description'); ?>" />
		<meta name="twitter:description" content="<?php bloginfo('description'); ?>" />
		<meta name="twitter:image" content="<?php echo THEMEPATH; ?>images/share.png" />
		<meta name="twitter:title" content="<?php bloginfo('name'); ?>" />
		<meta property="og:image:width" content="210" />
		<meta property="og:image:height" content="110" />
		<meta property="fb:app_id" content="" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:site" content="@" />

		<!-- Google+ -->
		<link rel="publisher" href="https://plus.google.com/+">

		<!-- Compatibility -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="cleartype" content="on">

		<!-- Google font(s) -->
		<!-- <link href="https://fonts.googleapis.com/css?family=Rancho|Open+Sans:400" rel="stylesheet"> -->

		<!--Style-->
		<link type="text/css" rel="stylesheet" href="<?php echo THEMEPATH; ?>stylesheets/styles.css" media="screen,projection, print" />

		<!-- Canonical URL -->
		<link rel="canonical" href="<?php echo site_url(); ?>" />

		<!-- Sitemap Google Verify -->
		<meta name="google-site-verification" content="" />

		<!-- Noscript -->
		<noscript>Tu navegador no soporta JavaScript!</noscript>
		<?php wp_head(); ?>
	</head>
	<body class="<?php if(is_home()): echo 'pageHome'; elseif(is_404()): echo 'pageError'; elseif(is_page('stock-pinatas')): echo 'pageSistema'; endif; ?>">

		<?php if (is_product()) : 
			/* Obtener categorías de producto */
			include (TEMPLATEPATH . '/template/function-category.php');
		endif; ?>
		<?php if (is_user_logged_in() && (is_home() || is_product() || is_page('novedades') || is_page('aviso-de-privacidad'))): ?>
			<a href="<?php echo SITEURL; ?>stock-pinatas" class="btn btn-primary btn-stock">Stock</a>
		<?php endif ?>
		<?php if (!is_home()) :  ?>
			<header class="js-header relative">
				<div class="bg-fondo-azul"></div>
				<img src="<?php echo THEMEPATH; ?>/images/paisaje.png" class="img-paisaje responsive-img">	
				<nav class="container padding-top-20">
					<a href="<?php echo SITEURL; ?>" class="inline-block"><div class="logo-pb"></div></a>
					<div id="openNav" class="hide-on-med-and-up"><em class="icon-menu"></em></div>
					<ul class="pb-nav" itemscope>
						<div id="closeNav" class="hide-on-med-and-up"><em class="icon-close"></em></div>
						<?php
							$menu_name = 'top_menu';

							if (( $locations = get_nav_menu_locations()) && isset( $locations[ $menu_name ])) {
								$menu = wp_get_nav_menu_object( $locations[ $menu_name ]);
								$menu_items = wp_get_nav_menu_items( $menu->term_id );
								$menu_list = '';
								foreach ( (array) $menu_items as $key => $menu_item) {

									$url 				= $menu_item->url;
									$title 				= $menu_item->title;
									$class 				= esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $menu_item->classes ), $menu_item) ) );
									$slug 				= sanitize_title( $menu_item->title );



									/* Active en menú si es la misma categoría del producto*/
									if (is_product()) {
										if ($Cat_parent_slug === $slug) {
											$statusItem = 'active';
										} else {
											$statusItem = 'inactive';
										}										
									} else {
										$statusItem = '';
									}

									/* Obtener Url item inicial (producto random) */
									$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => $slug, 'orderby' => 'rand' );
									$loop = new WP_Query( $args );
									while ( $loop->have_posts() ) : $loop->the_post(); global $product;
										$url_item =  get_permalink( $loop->post->ID );
									endwhile;  wp_reset_query();
									/* Obtener demás productos */
									$subItems = '';
									$args = array( 'post_type' => 'product', 'posts_per_page' => -1, 'product_cat' => $slug );
									$loop = new WP_Query( $args );
									while ( $loop->have_posts() ) : $loop->the_post(); 
										global $product;
										$subItem_name = $product->get_title();
										$subItems .= '<li><a href="' . get_permalink( $loop->post->ID ) . '">' . $subItem_name . ' Bolita</a></li>';
									endwhile;  wp_reset_query();

									$menu_list .= '<li id="item_' . $slug . '" itemprop="actionOption" class="' . $statusItem . '">
										<a href="' . $url_item . '" title="Enlace a' . $slug . '">' . $title . '</a>
										<ul>' . $subItems . '</ul>
									</li>';
								}
							}

							/*Novedades */
							if (is_page('novedades')) {
								$estatusPage 	= 'active';
							} else {
								$estatusPage 	= '';
							}
							$menu_list .='<li itemprop="actionOption" class="' . $estatusPage . '"><a href="' .  SITEURL . 'novedades">Novedades</a></li>';
							echo $menu_list;
						?>				
					</ul>
				</nav>
			</header>
		<?php endif; ?>
		<div class="[ main-body ] <?php if(!is_home()): echo 'bg-body'; endif; ?>">