<?php get_header(); ?>
	<div role="document">
			<div class="row">
				<div role="main" class="main span12">
				<?php if (have_posts()): while (have_posts()) : the_post(); ?>
					<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail(); // Fullsize image for the single post ?>
						</a>
					<?php endif; ?>
					
					<h1>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h1>
					
					<h4>
						<?php
						$key1 = "event_start_date";
						$key2 = "event_end_date";
						echo get_post_meta($post->ID, $key1, true) . ' - ' . get_post_meta($post->ID, $key2, true);
						?>
					</h4>
					
					<?php the_content(); // Dynamic Content ?>
					
					<?php edit_post_link(); // Always handy to have Edit Post Links available ?>
				
				<?php
					endwhile;
					endif;
				?>
				</div><!-- /@main -->
			</div>
		</div><!-- /@document -->

<?php get_footer(); ?>