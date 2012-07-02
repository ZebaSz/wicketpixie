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
$site_settings = array(
	'name' => 'Site-wide Settings',
	array(
		'name' => 'Blog Feed URL',
		'description' => 'RSS feed URL of your blog.',
		'id' => 'wicketpixie_blog_feed_url',
		'type' => 'text'),
	array(
		'name' => 'Enable AJAX Loader',
		'description' => 'Show loading screen while page content loads.',
		'id' => 'wicketpixie_enable_ajax_loader',
		'std' => 'false',
		'type' => 'checkbox'),
		array(
		'name' => 'Show author on posts',
		'description' => 'Whether or not to show who wrote a particular post.',
		'id' => 'wicketpixie_show_post_author',
		'std' => 'false',
		'type' => 'checkbox'),
);
$socnet_settings = array(
	'name' => 'SEO & Social Networking',
	array(
		'name' => 'Flickr ID',
		'description' => 'Flickr ID used to access Flickr photo stream.',
		'id' => 'wicketpixie_flickr_id',
		'type' => 'text'),
	array(
		'name' => 'Podcast Feed URL',
		'description' => 'URL of your podcast\'s feed.',
		'id' => 'wicketpixie_podcast_feed_url',
		'type' => 'text'),
	array(
		'name' => 'Twitter Username',
		'description' => 'Twitter Username',
		'id' => 'wicketpixie_twitter_id',
		'type' => 'text'),
	array(
		'name' => 'Ustream Channel',
		'description' => 'Channel name of stream set for live video.',
		'id' => 'wicketpixie_ustream_channel',
		'type' => 'text'),
	array(
		'name' => 'YouTube Username',
		'description' => 'Your username for YouTube.',
		'id' => 'wicketpixie_youtube_id',
		'type' => 'text'),
	array(
		'name' => 'Facebook Username/Page',
		'description' => 'Your username/page for Facebook.',
		'id' => 'wicketpixie_facebook_id',
		'type' => 'text'),
);
$misc_settings = array(
	'name' => 'Miscellaneous Settings',
	array(
		'name' => 'Post side box',
		'description' => 'Enable the box that contains the AdSense ad, TweetMeme, and Related Posts.',
		'id' => 'wicketpixie_post_enable_aside',
		'type' => 'checkbox'),
	array(
		'name' => 'TweetMeme on Posts',
		'description' => 'Show the TweetMeme widget on post pages.',
		'id' => 'wicketpixie_tweetmeme_enable',
		'type' => 'checkbox')
);
$help_content = array(
	array(
		'title' => 'Wicketpixie',
		'id' => 'wicketpixie-help',
		'content' => '<p>WicketPixie requires some configuration before it works to its full potential.</p><p>Some social networks require special steps to obtain the ID:</p><ul><li>You can obtain your Flickr ID by using <a href="http://idgettr.com">idGettr</a>.</li><li>Your Ustream Channel is the name of the Ustream channel you\'d like to stream from, and can be taken from the URL ("http://ustream.tv/channel/<i>your-channel-name</i>"). Remember, only enter the channel name, not the whole URL.</li><li>To use the Facebook button, just add everything in the URL after "http://facebook.com/". If you have a vanity URL, it will just be the username or page you chose. If you don\'t, it will look something like "pages/<i>your-page</i>/<i>your-page-id</i>".</li></ul>'),
	array(
		'title' => 'WiPi Plugins',
		'id' => 'wipi-plugins-help',
		'content' => '<p>WiPi plugins have been removed. This is because, while the plugins are good, updating them is tiresome (whilst WordPress can automatically update most of them). You can either download them and install them manually, or install the via the built-in Plugin Manager.</p><p>The following plugins offer the same functionality without integration:</p><ul><li><a href="http://wordpress.org/extend/plugins/all-in-one-seo-pack/">All In One SEO Pack</a></li><li><a href="http://wordpress.org/extend/plugins/askapache-google-404/">AskApache Google 404</a> (you can use <a href="admin.php?page=customcode.php">custom 404 code</a> to regain integration)</li><li><a href="http://wordpress.org/extend/plugins/chitika-premium/">Chitika</a></li><li>FAlbum (not in Plugin Directory, available <a href="http://www.randombyte.net/blog/projects/falbum/">here</a>)</li><li><a href="http://wordpress.org/extend/plugins/statpress-reloaded/">StatPress Reloaded</a></li><li>Automatically Hyperlink URLs, NoFollow Navigation and Obfuscate Email (the same functionality is available in many plugins)</li></ul><p>The following plugins have their functionality integrated, but are no longer distributed with WicketPixie:</p><ul><li><a href="http://wordpress.org/extend/plugins/kontera-contentlink">Kontera ContentLinks</a></li><li><a href="http://wordpress.org/extend/plugins/wp-pagenavi/">PageNavi</a></li><li><a href="http://wordpress.org/extend/plugins/wordpress-23-related-posts-plugin/installation/">Related Posts</a></li></ul>'
	)
);
class WiPiAdmin extends AdminPage {
	function __construct() {
		parent::__construct('WicketPixie','wicketpixie-admin.php',null,array($GLOBALS['site_settings'],$GLOBALS['socnet_settings'],$GLOBALS['misc_settings']),$GLOBALS['help_content']);
		$this->page_title = 'WicketPixie Admin';
	}
	function __destruct() {
		unset($GLOBALS['site_settings'],$GLOBALS['socnet_settings'],$GLOBALS['misc_settings']);
		parent::__destruct();
	}
}
