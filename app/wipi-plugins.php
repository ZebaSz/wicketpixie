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
require_once(get_template_directory() .'/functions.php');
class WiPiPlugins extends AdminPage {
	function __construct() {
		parent::__construct('WiPi Plugins','wipi-plugins.php','wicketpixie-admin.php');
		$this->page_title = 'WiPi Plugins';
	}
	function __destruct() {
		unset($GLOBALS['plugins']);
		parent::__destruct();
	}
	function page_display() { ?>
		<div class="wrap">
			<div id="admin-options">
				<h2>WiPi Plugins</h2>
				<p>WiPi plugins have been removed. This is because, while the plugins are good, updating them is tiresome (whilst WordPress can automatically update most of them). You can either download them and install them manually, or install the via the built-in Plugin Manager.</p>
				<p>The following plugins offer the same functionality without integration:</p>
				<ul>
					<li><a href="http://wordpress.org/extend/plugins/all-in-one-seo-pack/">All In One SEO Pack</a></li>
					<li><a href="http://wordpress.org/extend/plugins/askapache-google-404/">AskApache Google 404</a> (you can use <a href='admin.php?page=customcode.php'>custom 404 code</a> to regain integration)</li>
					<li><a href="http://wordpress.org/extend/plugins/chitika-premium/">Chitika</a></li>
					<li>FAlbum (not in Plugin Directory, available <a href="http://www.randombyte.net/blog/projects/falbum/">here</a>)</li>
					<li><a href="http://wordpress.org/extend/plugins/statpress-reloaded/">StatPress Reloaded</a></li>
					<li>Automatically Hyperlink URLs, NoFollow Navigation and Obfuscate Email (the same functionality is available in many plugins)</li>
				</ul>
				<p>The following plugins have their functionality integrated, but are no longer distributed with WicketPixie:</p>
				<ul>
					<li><a href="http://wordpress.org/extend/plugins/kontera-contentlink">Kontera ContentLinks</a></li>
					<li><a href="http://wordpress.org/extend/plugins/wp-pagenavi/">PageNavi</a></li>
					<li><a href="http://wordpress.org/extend/plugins/wordpress-23-related-posts-plugin/installation/">Related Posts</a></li>
				</ul>
			</div>
			<?php include_once('advert.php');
		}
} ?>
