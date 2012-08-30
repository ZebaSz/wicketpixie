<?php
/**
 * SocialBadgesWidget Class
 */
class SocialBadgesWidget extends WP_Widget {
	function SocialBadgesWidget() {
		$widget_ops = array('classname' => 'widget_social_badges','description' => __('Displays badges with links to different social sites as defined in WicketPixie Admin.','wicketpixie'));
		$this->WP_Widget('socialbadges','Social Badges',$widget_ops,null);
	}
	function widget($args,$instance) {
		extract($args);
		$blogfeed = get_option('wicketpixie_blog_feed_url');
		$podcastfeed = get_option('wicketpixie_podcast_feed_url');
		$twitter = get_option('wicketpixie_twitter_id');
		$youtube = get_option('wicketpixie_youtube_id');
		$facebook = get_option('wicketpixie_facebook_id'); ?>
		<div class="social-badges">
		<?php if(!empty($blogfeed)) echo "<a href='$blogfeed' class='button-feed'>&nbsp</a>";
		if(!empty($podcastfeed)) echo "<a href='$podcastfeed' class='button-podcast-feed'>&nbsp</a>";
		if(!empty($twitter)) echo "<a href='http://twitter.com/$twitter' class='button-twitter'>&nbsp</a>";
		if(!empty($youtube)) echo "<a href='http://youtube.com/$youtube' class='button-youtube'>&nbsp</a>";
		if(!empty($facebook)) echo "<a href='http://facebook.com/$facebook' class='button-facebook'>&nbsp</a>"; ?>
		</div>
		<div style="clear:both"></div>
	<?php }
	function update($new_instance,$old_instance) {
		return $old_instance;
	}
	function form($instance) {
	}
}
function SocialBadgesInit() {
	register_widget('SocialBadgesWidget');
}
