<?php
global $query_string;
?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" class="span4 l-post-intro-block">
		<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail(array(450,250)); // Declare pixel size you need inside the array ?>
			</a>
		<?php endif; ?>
		
		<h2>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
		<a href="#" class="read-more">Read More</a>
	</div><!-- /@l-post-intro-block -->
<?php endwhile; ?>

<?php else: ?>

	<!-- Article -->
	<article>
		<h2><?php _e( 'No Events', 'html5blank' ); ?></h2>
	</article>
	<!-- /Article -->

<?php endif; ?>