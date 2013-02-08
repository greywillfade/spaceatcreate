<?php /* Template Name: Current Events */
get_header(); ?>
	
	<div role="document">
		<div class="row main" role="main">
			<h1>Current Exhibitions</h1>
			<?php global $querystr; // not sure this is required in 3+
			
			date_default_timezone_set('GMT');
			
			$querystr = "
				SELECT p.*, pm.meta_key AS mk1, pm.meta_value AS eventstartdate, pm2.meta_key AS mk2, pm2.meta_value AS eventenddate
				FROM $wpdb->posts AS p
				LEFT JOIN $wpdb->postmeta AS pm
					ON (p.ID = pm.post_id)
				LEFT JOIN $wpdb->postmeta AS pm2
					ON (p.ID = pm2.post_id)
				WHERE
					p.post_type = 'event' 
				AND p.post_status = 'publish' 
				AND pm.meta_key = 'event_start_date'
				AND pm2.meta_key = 'event_end_date'
				AND DATEDIFF(STR_TO_DATE(pm.meta_value,'%d/%m/%Y'),date(now())) <= 0
				AND DATEDIFF(STR_TO_DATE(pm2.meta_value,'%d/%m/%Y'),date(now())) >= 0
				ORDER BY p.post_date ASC
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
			endif; ?>
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

