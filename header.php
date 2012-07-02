<?php
if(get_option('wicketpixie_blog_feed_url') != false) $blogfeed = get_option('wicketpixie_blog_feed_url');
else $blogfeed = get_bloginfo_rss('rss2_url');
$time = time();
$status= new SourceUpdate;
global $optpre;
global $adsense;
$adsense = new AdsenseAdmin; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<!-- Debug: <?php echo $optpre; ?> -->
	<title>
	<?php if (is_home() || is_front_page()) :
		bloginfo('name');
	else :
		wp_title('',true,''); ?> &raquo; <?php bloginfo('name');
	endif; ?>
	</title>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?<?php echo $time; ?>" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/print.css?<?php echo $time; ?>" type="text/css" media="print" />
	<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css?<?php echo $time; ?>" type="text/css" media="screen, projection" /><![endif]-->
	<?php if(get_option('wicketpixie_blog_feed_url')) echo '<link rel="alternate" type="application/rss+xml" title="'.bloginfo('name').'RSS Feed" href="'.$blogfeed.'" />'; ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="shortcut icon" type="image/ico" href="<?php echo home_url(); ?>/favicon.ico" />
	<?php if(get_option('wicketpixie_enable_ajax_loader') == 'true') : ?>
	<?php endif;
	ob_flush();
	flush();
	include_once (get_template_directory() . '/plugins/random-posts.php');
	include_once (get_template_directory() . '/plugins/search-excerpt.php');
	include_once (ABSPATH . 'wp-admin/includes/plugin.php' );
	clearstatcache();
	if(!is_dir(ABSPATH.'wp-content/uploads/activity')) :
		if(!is_dir(ABSPATH.'wp-content/uploads')) mkdir(ABSPATH.'wp-content/uploads',0777);
		mkdir(ABSPATH.'wp-content/uploads/activity',0777);
	endif;
	if(!is_dir(get_template_directory() . '/app/cache')) mkdir(get_template_directory() . '/app/cache',0777);
	if (is_singular()) wp_enqueue_script('comment-reply');
	wp_head();
	wp_customcode("header");
	$currurl = home_url().$_SERVER['REQUEST_URI'];
	$currurl = preg_quote($currurl,'/');
	if(preg_match('/('.$currurl.'index.php)/','http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']) || preg_match('/('.$currurl.'index.php)/','https://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'])) :
		if(get_bloginfo('description') != '') :
			$metadesc = get_bloginfo('description'); // We're at the home page
		else :
			$supdate = new SourceUpdate;
			$metadesc = $supdate->display(0);
		endif;
	else :
		// We must be in a page or a post
		$postdata = get_post($postid,ARRAY_A);
		$metadesc = substr($postdata['post_content'],0,134) . ' [...]';
	endif;
	$metadesc = strip_tags($metadesc); ?>
	<meta name="description" content="<?php echo $metadesc; ?>" />
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
				<a href="<?php home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a>
			</div>
			<!-- google_ad_section_end -->
			<?php if (function_exists('aktt_latest_tweet')) : ?>
			<!-- status -->
			<div id="status">
				<div id="twitter-tools">
					<?php echo get_avatar('1', $size = '36', $default = 'images/avatar.jpg'); ?>
					<div id="status-box">
						<span id="status-arrow"></span>
						<p><?php aktt_latest_tweet(); ?></p>
					</div>
				</div>
			</div>
			<!-- /status -->
			<?php elseif ($status->select()) : ?>
			<!-- status -->
			<div id="status">
				<?php echo get_avatar('1', $size = '36', $default = 'images/avatar.jpg'); ?>
				<div id="status-box">
					<span id="status-arrow"></span>
					<p><?php echo $status->display(); ?></p>
				</div>
			</div>
			<!-- /status -->
			<?php else : ?>
			<div id="status">
				<?php echo get_avatar('1', $size = '36', $default = 'images/avatar.jpg'); ?>
				<div id="status-box">
					<span id="status-arrow"></span>
					<p id="description"><?php bloginfo('description'); ?></p>
				</div>
			</div>
			<?php endif; ?>
			<!-- google_ad_section_start(weight=ignore) -->
			<!-- leaderboard -->
			<?php if(is_enabled_adsense()) : ?>
				<!-- Enable Adsense on the WicketPixie Adsense Ads admin page. -->
				<div id="leaderboard">
				<?php $adsense->wp_adsense("blog_header"); ?>
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
			<?php wp_nav_menu("container=false"); ?>
		</div>
		<!-- /nav -->
		<!-- google_ad_section_end -->
		<!-- mid -->
		<div id="mid">
