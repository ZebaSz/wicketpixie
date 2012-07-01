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
include_once(get_template_directory().'/widgets/sources.php');
define('SIMPLEPIEPATH',ABSPATH.WPINC.'/class-simplepie.php');

// No spaces in this constant please (use hyphens)
/*
* a = alpha (unstable, most likely broken)
* b = beta (testing, works but may have bugs)
* rc = release candidate (stable testing, minor issues are left)
*/
define('WIK_VERSION',"1.5-a");

/* Dynamic (Widget-enabled) Sidebar */
if ( function_exists('register_sidebar') ) :
	register_sidebar(array(
		'name'=>__('Sidebar top'),
		'id'=>'sidebar_top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebars(6, array(
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
endif;

// i18n support
load_theme_textdomain('wicketpixie', get_template_directory() .'/i18n');

// Nav menu
register_nav_menus(array('primary' => 'Primary Menu'));

// Custom Background
add_theme_support('custom-background');

// Automatic Feed Links
add_theme_support( 'automatic-feed-links' );

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
<?php };

// Theme Options
require(get_template_directory() .'/app/theme-options.php');

// Content Width
if (!isset($content_width)) $content_width = 500;

/* Admin Pages */
// Admin page style
function admin_style() {
    echo "<link rel='stylesheet' type='text/css' href='".get_template_directory_uri()."/css/admin.css' />";
}
add_action('admin_head', 'admin_style');
// The parent AdminPage class
require_once( get_template_directory() .'/app/admin-page.php');
// WicketPixie Admin page
require_once( get_template_directory() .'/app/wicketpixie-admin.php');
$a = new WiPiAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
// WiPi Plugins page
require_once( get_template_directory() .'/app/wipi-plugins.php');
$a = new WiPiPlugins();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
// Adsense Settings page
require_once( get_template_directory() .'/app/adsenseads.php');
$a = new AdsenseAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
register_activation_hook('/app/adsenseads.php',array('AdsenseAdmin','install'));
// Custom Code page
require_once( get_template_directory() .'/app/customcode.php');
$a = new CustomCodeAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
// Faves Manager
require_once( get_template_directory() .'/app/faves.php');
$a = new FavesAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
register_activation_hook('/app/faves.php',array('FavesAdmin','install'));
// Home Editor
require_once( get_template_directory() .'/app/homeeditor.php');
$a = new HomeAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
// WicketPixie Notifications page
require_once( get_template_directory() .'/app/notify.php');
$a = new NotifyAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
register_activation_hook('/app/notify.php',array('NotifyAdmin','install'));
// Social Me Manager
require_once( get_template_directory() .'/app/sourcemanager.php' );
$a = new SourceAdmin();
add_action('admin_menu',array($a,'add_page_to_menu'));
unset($a);
register_activation_hook('/app/sourcemanager.php', array( 'SourceAdmin', 'install' ) );

/* Version number in admin footer */
function wicketpixie_add_admin_footer() {
	echo "Thank you for using WicketPixie v".WIK_VERSION.", a free premium WordPress theme maintained by <a href='http://zeblog.com.ar/'>Sebastián Szperling</a>.<br/>";
}
add_action('in_admin_footer', 'wicketpixie_add_admin_footer');

/* Status updates */
require_once( get_template_directory() .'/app/update.php');

/* Widgets */
// My Profiles
require_once(get_template_directory() .'/widgets/my-profiles.php');
add_action('widgets_init','MyProfilesInit');
// Social Badges
require_once(get_template_directory() .'/widgets/social-badges.php');
add_action('widgets_init','SocialBadgesInit');
// Ustream
require_once(get_template_directory() .'/widgets/ustream-widget.php');
add_action('widgets_init','UstreamWidgetInit');
// Social Me Feed Widgets
include_once(get_template_directory() .'/widgets/sources.php');
foreach( SourceAdmin::collect() as $widget ) :
	if(SourceAdmin::feed_check($widget->title) == 1) :
		$source_title = $widget->title;
		$t_title = str_replace(' ','',$source_title);
		$cleaned= strtolower( $source_title );
		$cleaned= preg_replace( '/\W/', ' ', $cleaned );
		$cleaned= str_replace( " ", "", $cleaned );
		if(is_file(get_template_directory() .'/widgets/'.$cleaned.'.php')) :
			add_action('widgets_init',"${t_title}Init");
		endif;
	endif;
endforeach;
