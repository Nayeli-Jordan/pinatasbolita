<?php get_header(); 
	if (have_posts()) : while (have_posts()) : the_post();?>
		<section class="[ container ] text-shadow-gray color-light">
			<div class="row">
				<div class="col s12 l10 offset-l1">
					<h2 class="text-center margin-bottom-20"><?php the_title(); ?></h2>
					<div class="page-content">
						<?php the_content(); ?>
					</div>					
				</div>
			</div>
		</section>
	<?php endwhile; endif; 
get_footer(); ?>