<?php
/**
 * WicketPixie v1.5
 * (c) 2006-2009 Eddie Ringle,
 *               Chris J. Davis,
 *               Dave Bates
 * Provided by Chris Pirillo
 *
 * (c) 2011-2012 Sebastian Szperling
 *
 * Licensed under the New BSD License.
 */
class SourceUpdate extends SourceAdmin {
	function __construct() {
		parent::__construct();
	}
	function __destruct() {
		parent::__destruct();
	}
	/**
	 * Checks to see if any source is used for our Updates
	 **/
	function check() {
		global $wpdb;
		if (parent::check()) :
			$sources = $wpdb->get_results("SELECT updates FROM {$this->table}");
			return !empty($sources);
		endif;
		return false;
	}
	/**
	* Selects the source whose feed will be used for updates,
	* then fetches the latest entry from the source's feed
	**/
	function fetchfeed() {
		require_once(CLASSFEEDPATH);
		global $wpdb;
		$source = $wpdb->get_results("SELECT * FROM {$this->table} WHERE updates = 1 LIMIT 1");
		$feed_path = $source[0]->feed_url;
		$feed = fetch_feed($feed_path);
		if (!is_wp_error($feed)) :
			$status = $feed->get_items(0,1);
			if (!empty($status)) :
				$status = $status[0];
				$update['title'] = $status->get_title();
				$update['link'] = $status->get_permalink();
				$update['date'] = strtotime(substr($status->get_date(),0,25));
				// This auto-hyperlinks URLs
				$update['title'] = preg_replace('((?:\S)+://\S+[[:alnum:]]/?)', '<a href="\0">\0</a>', $update['title']);
				// If Twitter is the source, then we hyperlink any '@username's to that user's Twitter profile.
				if (preg_match('/twitter\.com/',$feed_path))
					$update['title'] = preg_replace('/(@)([A-Za-z0-9_-]+)/', '<a href="http://twitter.com/\2">\0</a>', $update['title']);
				// We want dates in local time, as specified by user
				$local_time = $update['date'] + get_option('gmt_offset') * 3600;
				return substr($update['title'], 0, 1000)." &mdash; <a href=\"{$update['link']}\">".date(get_option('time_format'), $local_time).'</a>';
			endif;
		endif;
		return __('Thanks for exploring my world! Can you believe this avatar is talking to you?','wicketpixie');
	}
} ?>
