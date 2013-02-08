<?php /* Template Name: Future Events */
get_header(); ?>
	
	<div role="document">
		<div class="row main" role="main">
			<h1>Past Exhibitions</h1>
			<?php global $querystr, $today; // not sure this is required in 3+
			
			date_default_timezone_set('GMT');
			$today = date('d/m/y');
			preg_replace('{/}', '', $today); // takes the date format and removes slashes to create a numeric string
			
			$querystr = "
				SELECT $wpdb->posts.*
				FROM $wpdb->posts, $wpdb->postmeta
				WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
				AND $wpdb->posts.post_type = 'event' 
				AND $wpdb->posts.post_status = 'publish' 
				ORDER BY $wpdb->posts.post_date ASC	 
			";
			
			$event_posts = $wpdb->get_results($querystr, OBJECT);
			
			if( $event_posts ) :
			global $post;
			foreach($event_posts as $post) : 
			setup_postdata($post); ?>
			
				<div id="post-<?php the_ID(); ?>" class="span4 l-post-intro-block">
					<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail(array(450,250)); // Declare pixel size you need inside the array ?>
						</a>
					<?php endif; ?>
					
					<h2>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h2>
					
					<?php the_excerpt(); ?>

					<p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="read-more">Read More</a></p>
				</div><!-- /@l-post-intro-block -->	
			
			<?php endforeach;
			else : ?>
			<p class="lede">We currently have no events scheduled for the future.</p>
			<?php endif; ?>
		</div><!-- /@main -->
		
		<div>
			<ul class="pager">
				<li><?php next_posts_link('Previous entries') ?></li>
				<li><?php previous_posts_link('Next entries') ?></li>
			</ul>
		</div>
	</div><!-- /@document -->
<?php wp_reset_query();
get_footer(); ?>

