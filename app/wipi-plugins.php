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
require_once(TEMPLATEPATH .'/functions.php');
$plugins_desc = <<<HTML
<p>Some WiPi plugins were removed. This is because updating them is tiresome (whilst WordPress can update automatically most of them), and the same functionality can be obtained without integration (they can be installed separately). The following plugins were removed:
<ul>
<li>All In One SEO Pack</li>
<li>AskApache Google 404 (you can use <a href="admin.php?page=customcode.php">custom 404 code</a> to regain integration)</li>
<li>StatPress Reloaded</li>
</ul>
HTML;
$plugins = array(
	'name' => '',
	'desc' => $plugins_desc,
	array(
		"name" => "Automatically Hyperlink URLs",
		"description" => "Automatically hyperlinks URLs in post contents.",
		"id" => 'wicketpixie_plugin_autohyperlink-urls',
		'path' => TEMPLATEPATH .'/plugins/autohyperlink-urls/autohyperlink-urls.php',
		"std" => 'false',
		"type" => 'checkbox'),
	array(
		"name" => "Chitika",
		"description" => "Use Chitika for Search Targeted Advertising",
		"id" => 'wicketpixie_plugins_chitika',
		'path' => TEMPLATEPATH .'/plugins/chitika-premium/premium.php',
		"std" => 'false',
		"type" => 'checkbox'),
	array(
		"name" => "FAlbum",
		"description" => "Integrate Flickr albums into your blog.",
		"id" => 'wicketpixie_plugin_falbum',
		'path' => TEMPLATEPATH .'/plugins/falbum/wordpress-falbum-plugin.php',
		"std" => 'false',
		"type" => 'checkbox'),
	array(
		"name" => "Kontera",
		"description" => "Enable Kontera Advertising.",
		"id" => 'wicketpixie_plugin_kontera',
		'path' => TEMPLATEPATH .'/plugins/kontera/kontera.php',
		"std" => 'false',
		"type" => 'checkbox'),
	array(
		"name" => "NoFollow Navigation",
		"description" => "Adds nofollow to the generated page links.",
		"id" => 'wicketpixie_plugin_nofollow_navigation',
		'path' => TEMPLATEPATH .'/plugins/nofollow-navi/nofollow-navi.php',
		"std" => 'false',
		"type" => 'checkbox'),
	array(
		"name" => "Obfuscate Email",
		"description" => "Modifies email addresses to prevent email harvesting.",
		"id" => 'wicketpixie_plugin_obfuscate-email',
		'path' => TEMPLATEPATH .'/plugins/obfuscate-email/obfuscate-email.php',
		"std" => 'false',
		"type" => 'checkbox'),
	array(
		"name" => "WP PageNavi",
		"description" => "Adds a more advanced paging navigation to your WordPress blog.",
		"id" => 'wicketpixie_plugin_pagenavi',
		'path' => TEMPLATEPATH .'/plugins/wp-pagenavi/wp-pagenavi.php',
		"std" => 'false',
		"type" => 'checkbox'),
	array(
		"name" => "WP Related Posts",
		"description" => "Generates a list of related posts. Deselect if you prefer a different related posts plugin (that works with the commands we use!).",
		"id" => 'wicketpixie_plugin_related-posts',
		'path' => TEMPLATEPATH .'/plugins/related-posts.php',
		"std" => 'false',
		"type" => 'checkbox')
);
function add_plugins() {
	global $plugins;
	foreach($plugins as $plugin) :
		if(get_option($plugin['id']) == 'true' || $plugin['std'] == 'true') :
			require_once $plugin['path'];
		endif;
	endforeach;
}
class WiPiPlugins extends AdminPage {
	function __construct() {
		parent::__construct('WiPi Plugins','wipi-plugins.php',null,array($GLOBALS['plugins']));
		$this->page_title = 'WiPi Plugins';
	}
	function __destruct() {
		unset($GLOBALS['plugins']);
		parent::__destruct();
	}
}
