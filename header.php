<?php
// Blog feed URL
if(get_option('wicketpixie_blog_feed_url') != false) :
	$blogfeed = get_option('wicketpixie_blog_feed_url');
else :
	$blogfeed = get_bloginfo_rss('rss2_url');
endif;
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
	<title><?php if (is_home()) :
	bloginfo('name');
	else: 
		wp_title('',true,''); ?> &raquo; <?php bloginfo('name'); ?>
	<?php endif; ?></title>
	<?php $time = time(); ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/reset.css?<?php echo $time; ?>" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/screen.css?<?php echo $time; ?>" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/print.css?<?php echo $time; ?>" type="text/css" media="print" />
	<!--[if IE]><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ie.css?<?php echo $time; ?>" type="text/css" media="screen, projection" /><![endif]-->
	<!--[if gte IE 7]><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ie7.css?<?php echo $time; ?>" type="text/css" media="screen, projection" /><![endif]-->
	<!--[if lte IE 6]><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ie6.css?<?php echo $time; ?>" type="text/css" media="screen, projection" /><![endif]-->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php echo $blogfeed; ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="shortcut icon" type="image/ico" href="<?php bloginfo('home'); ?>/favicon.ico" />
	<?php if(get_option('wicketpixie_enable_ajax_loader') == 'true') : ?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/loader.css?<?php echo time(); ?>" type="text/css" media="all" />
	<?php endif;
	ob_flush();
	flush(); ?>
	<style type="text/css">.recentcomments a {display: inline !important;padding: 0 !important;margin: 0 !important;}</style>
	<?php include_once (TEMPLATEPATH . '/plugins/random-posts.php');
	include_once (TEMPLATEPATH . '/plugins/search-excerpt.php');
	clearstatcache();
	if(!is_dir(ABSPATH.'wp-content/uploads/activity')) :
		if(!is_dir(ABSPATH.'wp-content/uploads')) :
			mkdir(ABSPATH.'wp-content/uploads',0777);
		endif;
		mkdir(ABSPATH.'wp-content/uploads/activity',0777);
	endif;
	if(!is_dir(TEMPLATEPATH . '/app/cache')) :
		mkdir(TEMPLATEPATH . '/app/cache',0777);
	endif;
	wp_head();
	echo "\n";
	wp_customheader();
	echo "\n";
	$blogurl = get_bloginfo('url');
	$currurl = $blogurl.$_SERVER['REQUEST_URI'];
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
<body>
	<?php if(get_option('wicketpixie_enable_ajax_loader') == 'true') : ?>
	<!-- AJAX DIV Loader, enable it in WicketPixie Settings -->
	<div id="loadingFrame">
		<div id="loading">
			<img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" alt="Loading"/><br />
			<b><?php _e('Loading....', 'wicketpixie') ?></b>
		</div>
	</div>
	<?php endif;
	flush(); ?>
<!-- google_ad_section_start(weight=ignore) -->
	<!-- topbar -->
	<div id="topbar">
		<!-- topbar-inner -->
		<div id="topbar-inner">
			<ul>
				<li id="topbar-subscribe"><a href="#"><?php _e('Subscribe', 'wicketpixie') ?></a></li>
				<?php if (is_user_logged_in()) : ?>
				<li id="topbar-admin"><a href="<?php bloginfo('wpurl'); ?>/wp-admin" rel="nofollow">Admin</a></li>
				<?php endif; ?>
			</ul>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</div>
		<!-- /topbar-inner -->
	</div>
	<!-- /topbar -->
	<!-- subscribe -->
	<div id="subscribe">
		<ul>
			<li><a href="<?php echo $blogfeed; ?>" title="<?php _e('Subscribe to my feed', 'wicketpixie') ?>" class="feed" rel="nofollow">RSS Feed</a></li>
			<li><a href="http://www.bloglines.com/sub/<?php echo $blogfeed; ?>" class="feed" rel="nofollow">Bloglines</a></li>
			<li><a href="http://fusion.google.com/add?feedurl=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">Google Reader</a></li>
			<li><a href="http://feeds.my.aol.com/add.jsp?url=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">My AOL</a></li>
			<li><a href="http://my.msn.com/addtomymsn.armx?id=rss&amp;ut=<?php echo $blogfeed; ?>&amp;ru=<?php echo get_settings('home'); ?>" class="feed" rel="nofollow">My MSN</a></li>
			<li><a href="http://add.my.yahoo.com/rss?url=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">My Yahoo!</a></li>
			<li><a href="http://www.newsgator.com/ngs/subscriber/subext.aspx?url=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">NewsGator</a></li>
			<li><a href="http://www.pageflakes.com/subscribe.aspx?url=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">Pageflakes</a></li>
			<li><a href="http://technorati.com/faves?add=<?php echo get_settings('home'); ?>" class="feed" rel="nofollow">Technorati</a></li>
			<li><a href="http://www.live.com/?add=<?php echo $blogfeed; ?>" class="feed" rel="nofollow">Windows Live</a></li>
		</ul>
	</div>
	<!-- /subscribe -->
	<!-- header -->
	<div id="header">
		<!-- header-inner -->
		<div id="header-inner">
			<div id="logo">
				<?php if(get_option('wicketpixie_theme_header_size')) :
					$fontsize = get_option('wicketpixie_theme_header_size');
					echo '<span style="font-size:',$fontsize,'px;">'; ?>
					<a href="<?php echo get_option('home'); ?>/" rel="nofollow"><?php bloginfo('name'); ?></a>
					<?php echo "</span>";
				else : ?>
				<a href="<?php echo get_option('home'); ?>/" rel="nofollow"><?php bloginfo('name'); ?></a>
				<?php endif; ?>
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
			<?php if(is_enabled_adsense() == true) : ?>
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
			<ul>
			<?php if (function_exists('wp_nav_menu')) :
				wp_nav_menu(array('theme_location' => 'primary'));
			else :
				if (!is_home()) : ?>
					<li><a href="<?php bloginfo('home'); ?>/">Home</a></li>
				<?php endif;
				if (get_option('wicketpixie_adsense_search_enabled') == 'true') :
					$sp = get_page_by_title('Search');
					$id = $sp->ID;
					wp_list_pages("depth=1&sort_column=menu_order&exclude=${id}&title_li=");
					echo "<!-- Excluding $id -->";
					unset($sp,$id);
				else :
					wp_list_pages("depth=1&sort_column=menu_order&title_li=");
				endif;
			endif; ?>
			</ul>
		</div>
		<!-- /nav -->
		<!-- google_ad_section_end -->
		<!-- mid -->
		<div id="mid" class="content">
