<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	
	<!-- DNS Prefetch -->
	<link rel="dns-prefetch" href="//www.google-analytics.com">
	
	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
	
	<!-- Meta -->
	<meta name="viewport" content="initial-scale=1.0, width=device-width"/>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="Andy Parker">
	<meta name="keywords" content="Photography, Exhibition, Photographic, Brighton, Create">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		
	<!-- CSS + jQuery + JavaScript -->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="wrap">
		<div role="banner" class="row">
			<h1><a href="/" rel="home">Space @ Create</a></h1>
		</div><!-- /@banner -->
		
		<nav role="navigation" class="row menu">
			<?php html5blank_nav(); ?>
		</nav><!-- /@navigation -->