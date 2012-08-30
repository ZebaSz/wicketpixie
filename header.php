<?php
$blogfeed = get_option('wicketpixie_blog_feed_url');
$time = time();
$status= new SourceUpdate; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title>
	<?php if (is_home() || is_front_page()) :
		bloginfo('name');
	else :
		wp_title('',true,''); ?> &raquo; <?php bloginfo('name');
	endif; ?>
	</title>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<?php if ($blogfeed) :
		echo '<link rel="alternate" type="application/rss+xml" title="'.get_bloginfo('name').'RSS Feed" href="'.$blogfeed.'" />';
	else:
		$blogfeed = get_bloginfo('rss2-url');
	endif; ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="shortcut icon" type="image/ico" href="<?php echo home_url(); ?>/favicon.ico" />
	<?php ob_flush();
	flush();
	include_once (get_template_directory() . '/plugins/random-posts.php');
	include_once (get_template_directory() . '/plugins/search-excerpt.php');
	include_once (ABSPATH . 'wp-admin/includes/plugin.php' );
	clearstatcache();
	if (is_singular())
		wp_enqueue_script('comment-reply');
	wp_head();
	wp_customcode('header'); ?>
	<meta name="description" content="<?php bloginfo('description'); ?>" />
</head>
<body <?php body_class(); ?>>
	<?php if(get_option('wicketpixie_enable_ajax_loader') == 'true') include_once('loader.php');
	flush(); ?>
<!-- google_ad_section_start(weight=ignore) -->
	<?php if (!is_admin_bar_showing()) : ?>
	<!-- topbar -->
	<div id="topbar">
		<!-- topbar-inner -->
		<div id="topbar-inner">
			<ul>
				<!-- subscribe -->
				<li id="topbar-subscribe">
					<a href="#"><?php _e('Subscribe', 'wicketpixie') ?></a>
					<div id="subscribe">
						<ul>
							<li><a href="<?php echo $blogfeed; ?>" title="<?php _e('Subscribe to my feed', 'wicketpixie') ?>" class="feed" rel="nofollow">RSS Feed</a></li>
							<li><a href="http://www.bloglines.com/sub/<?php echo $blogfeed; ?>" class="feed" rel="nofollow">Bloglines</a></li>
							<li><a href="http://fusion.google.com/add?feedurl=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">Google Reader</a></li>
							<li><a href="http://feeds.my.aol.com/add.jsp?url=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">My AOL</a></li>
							<li><a href="http://my.msn.com/addtomymsn.armx?id=rss&amp;ut=<?php echo $blogfeed; ?>&amp;ru=<?php echo home_url(); ?>" class="feed" rel="nofollow">My MSN</a></li>
							<li><a href="http://add.my.yahoo.com/rss?url=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">My Yahoo!</a></li>
							<li><a href="http://www.newsgator.com/ngs/subscriber/subext.aspx?url=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">NewsGator</a></li>
							<li><a href="http://www.pageflakes.com/subscribe.aspx?url=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">Pageflakes</a></li>
							<li><a href="http://technorati.com/faves?add=<?php echo home_url(); ?>" class="feed" rel="nofollow">Technorati</a></li>
							<li><a href="http://www.live.com/?add=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">Windows Live</a></li>
						</ul>
					</div>
				</li>
				<!-- /subscribe -->
				<?php if (is_user_logged_in()) : ?>
				<li id="topbar-admin"><a href="<?php echo network_admin_url(); ?>" rel="nofollow">Admin</a></li>
				<?php endif; ?>
			</ul>
			<?php get_search_form(); ?>
		</div>
		<!-- /topbar-inner -->
	</div>
	<!-- /topbar -->
	<?php endif; ?>
	<!-- header -->
	<div id="header">
		<!-- header-inner -->
		<div id="header-inner">
			<div id="logo">
				<a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a>
			</div>
			<!-- google_ad_section_end -->
			<?php if (function_exists('aktt_latest_tweet')) : ?>
			<!-- status -->
			<div id="status">
				<div id="twitter-tools">
					<?php echo get_avatar('1','36'); ?>
					<div id="status-box">
						<span id="status-arrow"></span>
						<p><?php aktt_latest_tweet(); ?></p>
					</div>
				</div>
			</div>
			<!-- /status -->
			<?php elseif ($status->check()) : ?>
			<!-- status -->
			<div id="status">
				<?php echo get_avatar('1','36'); ?>
				<div id="status-box">
					<span id="status-arrow"></span>
					<p><?php echo $status->fetchfeed(); ?></p>
				</div>
			</div>
			<!-- /status -->
			<?php else : ?>
			<div id="status">
				<?php echo get_avatar('1','36'); ?>
				<div id="status-box">
					<span id="status-arrow"></span>
					<p id="description"><?php bloginfo('description'); ?></p>
				</div>
			</div>
			<?php endif; ?>
			<!-- google_ad_section_start(weight=ignore) -->
			<!-- leaderboard -->
			<?php if (is_enabled_adsense()) : ?>
				<div id="leaderboard">
				<?php wp_adsense('blog_header'); ?>
				</div>
			<?php endif; ?>
			<!-- /leaderboard -->
		</div>
		<!-- /header-inner -->
	</div>
	<!-- /header -->
	<!-- wrapper -->
	<div id="wrapper">
		<!-- nav -->
		<div id="nav">
			<?php wp_nav_menu('container=false'); ?>
		</div>
		<!-- /nav -->
		<!-- google_ad_section_end -->
		<!-- mid -->
		<div id="mid">
