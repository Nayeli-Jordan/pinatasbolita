<?php 
	get_header();
	global $post;
	
	while ( have_posts() ) : the_post(); 
?>
	<section id="single">

	</section>
<?php 
	endwhile; // end of the loop.
	get_footer(); 
?>
