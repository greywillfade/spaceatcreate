<?php /* Template Name: Home Page */ ?>

<?php get_header(); ?>
	<div role="document">
		<div class="row">
			<div role="main" class="main span12">
				<?php if (have_posts()): while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
					
					<?php edit_post_link(); ?>
				<?php endwhile; endif; ?>
			</div><!-- /@main -->
		</div>

		<div role="complementary" class="row">
			<div class="span4">
				<a href="#"><img class="thumb" src="http://placehold.it/450x250"></a>
				
				<h2><a href="#">Current</a></h2>
				
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<a href="#" class="read-more">Read More</a>
			</div>
			<div class="span4">
				<a href="#"><img class="thumb" src="http://placehold.it/450x250"></a>
			
				<h2><a href="#">Upcoming</a></h2>
				
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<a href="#" class="read-more">Read More</a>
			</div>
			<div class="span4">
				<a href="#"><img class="thumb" src="http://placehold.it/450x250"></a>
				
				<h2><a href="#">Past</a></h2>
				
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<a href="#" class="read-more">Read More</a>
			</div>
		</div><!-- /@complementary-->
	</div><!-- /@document -->
<?php get_footer(); ?>