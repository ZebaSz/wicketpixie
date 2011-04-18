<?php
/**
 * WicketPixie v1.4
 * (c) 2006-2009 Eddie Ringle,
 *               Chris J. Davis,
 *               Dave Bates
 * Provided by Chris Pirillo
 *
 * (c) 2011 Sebastian Szperling
 *
 * Licensed under the New BSD License.
 */

$optpre = 'wicketpixie_';
include_once( TEMPLATEPATH . '/widgets/sources.php' );
define(SIMPLEPIEPATH,ABSPATH.'wp-includes/class-simplepie.php');

// No spaces in this constant please (use hyphens)
/*
* a = alpha (unstable, most likely broken)
* b = beta (testing, works but may have bugs)
* rc = release candidate (stable testing, minor issues are left)
*/
define('WIK_VERSION',"1.4-b");

/* Debug settings */
define(DEBUG,false);
if (DEBUG == true) :
	error_reporting(E_ALL);
endif;

/* Dynamic (Widget-enabled) Sidebar */
if ( function_exists('register_sidebar') ) :
	register_sidebar(array('name'=>'sidebar_top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name'=>'sidebar1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name'=>'sidebar2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name'=>'sidebar3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name'=>'sidebar4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name'=>'sidebar5',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array('name'=>'sidebar6',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
endif;

// i18n support
load_theme_textdomain('wicketpixie', TEMPLATEPATH.'/i18n');

// Nav menu
if (function_exists('register_nav_menus')) :
	register_nav_menus(array('primary' => 'Primary Menu'));
endif;

// Custom Background
if (function_exists('add_custom_background')) :
	add_custom_background();
endif;

// Comments walker
function wicketpixie_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-meta">
				<h3><?php comment_author_link(); ?></h3>
				<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
				<strong><?php comment_date(); ?></strong><br /><?php printf(__('at %s', 'wicketpixie'), get_comment_time()); ?></a>
			</div>
			<?php echo get_avatar($comment, 48); ?>
			<?php if ($comment->comment_approved == '0') : ?>
			<p class="comment-awaiting-moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'wicketpixie' ); ?></em></p>
			<?php endif; ?>
			<?php comment_text(); ?>
			<p><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); edit_comment_link(__('Edit', 'wicketpixie'), ' - '); ?></p>
			<div class="clearer" ></div>
		</div>
<?php }

/* Admin Pages */
// The parent AdminPage class
require_once(TEMPLATEPATH .'/app/admin-page.php');
// WicketPixie Admin page
require_once( TEMPLATEPATH .'/app/wicketpixie-admin.php');
$a = new WiPiAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
// WiPi Plugins page
require_once( TEMPLATEPATH .'/app/wipi-plugins.php');
$a = new WiPiPlugins();
add_action('admin_menu',array($a,'add_page_to_menu'));
add_plugins();
unset($a);
// Adsense Settings page
require_once( TEMPLATEPATH .'/app/adsenseads.php');
$a = new AdsenseAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
register_activation_hook('/app/adsenseads.php',array('AdsenseAdmin','install'));
// Custom Code page
require_once( TEMPLATEPATH .'/app/customcode.php');
$a = new CustomCodeAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
// Faves Manager
require_once( TEMPLATEPATH .'/app/faves.php');
$a = new FavesAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
register_activation_hook('/app/faves.php',array('FavesAdmin','install'));
// Home Editor
require_once( TEMPLATEPATH .'/app/homeeditor.php');
$a = new HomeAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
// WicketPixie Notifications page
require_once( TEMPLATEPATH .'/app/notify.php');
$a = new NotifyAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
register_activation_hook('/app/notify.php',array('NotifyAdmin','install'));
// Social Me Manager
require_once( TEMPLATEPATH .'/app/sourcemanager.php' );
$a = new SourceAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
register_activation_hook('/app/sourcemanager.php', array( 'SourceAdmin', 'install' ) );
// Theme Options
require_once(TEMPLATEPATH .'/app/theme-options.php');
$a = new ThemeOptions();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
add_action('admin_head', 'wicketpixie_admin_head');
add_action('wp_head', 'wicketpixie_wp_head');

/* Version number in admin footer */
function wicketpixie_add_admin_footer() {
	echo "Thank you for using WicketPixie v".WIK_VERSION.", a free premium WordPress theme maintained by <a href='http://zeblog.com.ar/'>Sebastián Szperling</a>.<br/>";
}
add_action('in_admin_footer', 'wicketpixie_add_admin_footer');

/* Status updates */
require_once( TEMPLATEPATH .'/app/update.php');

/* Widgets */
if(function_exists('register_widget')) :
	// My Profiles
	require_once(TEMPLATEPATH .'/widgets/my-profiles.php');
	add_action('widgets_init','MyProfilesInit');
	// Social Badges
	require_once(TEMPLATEPATH .'/widgets/social-badges.php');
	add_action('widgets_init','SocialBadgesInit');
	// Ustream
	require_once(TEMPLATEPATH .'/widgets/ustream-widget.php');
	add_action('widgets_init','UstreamWidgetInit');
	// Social Me Feed Widgets
	include_once(TEMPLATEPATH .'/widgets/sources.php');
	foreach( SourceAdmin::collect() as $widget ) :
		if(SourceAdmin::feed_check($widget->title) == 1) :
			$source_title = $widget->title;
			$t_title = str_replace(' ','',$source_title);
			$cleaned= strtolower( $source_title );
			$cleaned= preg_replace( '/\W/', ' ', $cleaned );
			$cleaned= str_replace( " ", "", $cleaned );
			if(is_file(TEMPLATEPATH .'/widgets/'.$cleaned.'.php')) :
				add_action('widgets_init',"${t_title}Init");
			endif;
		endif;
	endforeach;
endif; ?>
