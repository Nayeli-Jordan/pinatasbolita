<?php get_header(); 
	if (have_posts()) : while (have_posts()) : the_post();?>
		<section class="[ container ]">

		</section>
	<?php endwhile; endif; 
get_footer(); ?>