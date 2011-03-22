<?php
/**
 * WicketPixie v1.3
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
		"name" => "Blog Feed URL",
		"description" => "RSS feed URL of your blog.",
		"id" => 'wicketpixie_blog_feed_url',
		"type" => "text"),
	array(
		"name" => "Enable AJAX Loader",
		"description" => "Show loading screen while page content loads.",
		"id" => 'wicketpixie_enable_ajax_loader',
		"std" => 'false',
		"type" => "checkbox"),
		array(
		"name" => "Show author on posts",
		"description" => "Whether or not to show who wrote a particular post.",
		"id" => 'wicketpixie_show_post_author',
		"std" => 'false',
		"type" => 'checkbox'),
);
$socnet_desc = <<<HTML
<p id="flickrid_tip">You can obtain your Flickr ID by using <a href="http://idgettr.com">idGettr</a>.</p>
<p id="ustreamchannel_tip">Your Ustream Channel is the name of the Ustream channel you'd like to stream from. For example, the channel 'Chris Pirillo Live' (url of which is http://ustream.tv/channel/chris-pirillo-live) would be entered as 'chris-pirillo-live'. (Like you'd see it in the Ustream URL.)</p>
<p id="facebook_tip">If you want to add a Facebook Page instead of your user, be sure to enter the URL as see it on your browser (something like 'pages/<i>your page</i>/<i>your page id</i> ', without 'facebook.com')</p>
HTML;
$socnet_settings = array(
	'name' => 'SEO & Social Networking',
	'desc' => $socnet_desc,
	array(
		"name" => "Flickr ID",
		"description" => "Flickr ID used to access Flickr photo stream.",
		"id" => 'wicketpixie_flickr_id',
		"type" => "text"),
	array(
		"name" => "Podcast Feed URL",
		"description" => "URL of your podcast's feed.",
		"id" => 'wicketpixie_podcast_feed_url',
		"type" => "text"),
	array(
		"name" => "Twitter Username",
		"description" => "Twitter Username",
		"id" => 'wicketpixie_twitter_id',
		"type" => "text"),
	array(
		"name" => "Ustream Channel",
		"description" => "Channel name of stream set for live video.",
		"id" => 'wicketpixie_ustream_channel',
		"type" => "text"),
	array(
		"name" => "YouTube Username",
		"description" => "Your username for YouTube.",
		"id" => 'wicketpixie_youtube_id',
		"type" => "text"),
	array(
		"name" => "Facebook Username/Page",
		"description" => "Your username/page for Facebook.",
		"id" => 'wicketpixie_facebook_id',
		"type" => "text"),
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
class WiPiAdmin extends AdminPage {
	function __construct() {
		parent::__construct('','wicketpixie-admin.php',null,array($GLOBALS['site_settings'],$GLOBALS['socnet_settings'],$GLOBALS['misc_settings']));
		$this->page_title = 'WicketPixie Admin';
		$this->page_name = 'WicketPixie';
		$this->page_description = 'WicketPixie requires some configuration before it works properly.';
	}
	function request_check() {
		parent::request_check();
		if (isset($_POST['action']) && $_POST['action'] == 'save-custom-code') :
			if(isset($_POST['file']) && $_POST['file'] == 'global_announcement') :
				require_once(TEMPLATEPATH .'/app/customcode.php');
				writeto($_POST['code'],"global_announcement.php");
			endif;
		endif;
	}
	function after_form() { ?>
		<h3>Global Announcement</h3>
		<?php require_once(TEMPLATEPATH .'/app/customcode.php');
		if(function_exists('fetchcustomcode')) :
			$glob = fetchcustomcode('global_announcement.php',true);
			if($glob == fetchcustomcode('idontexist.no')) :
				$glob = "";
			endif;
		else :
			$glob = "";
		endif; ?>
		<p>The text you enter here will appear on the home page and all your posts as a global announcement. HTML is allowed.</p>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>" class="form-table">
		<?php wp_nonce_field('wicketpixie-settings'); ?>
			<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="15" /><?php echo $glob; ?></textarea></p>
			<p class="submit">
				<input name="save" type="submit" value="Save Global Announcement" /> 
				<input type="hidden" name="action" value="save-custom-code" />
				<input type="hidden" name="file" value="global_announcement" />
			</p>
		</form>
	<?php }
	function __destruct() {
		unset($GLOBALS['site_settings'],$GLOBALS['socnet_settings'],$GLOBALS['misc_settings']);
		parent::__destruct();
	}
}
