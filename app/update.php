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
		if (parent::check())
			return $wpdb->get_results("SELECT updates FROM {$this->table}");
		return false;
	}
	/**
	* Selects the source whose feed will be used for updates,
	* then fetches the latest entry from the source's feed
	**/
	function fetchfeed() {
		require_once(SIMPLEPIEPATH);
		global $wpdb;
		$feed = $wpdb->get_results("SELECT * FROM {$this->table} WHERE updates = 1 LIMIT 1");
		if (preg_match('/twitter\.com/',$feed[0]->feed_url))
			$istwitter = true;
		$feed_path = $feed[0]->feed_url;
		$feed = new SimplePie((string)$feed_path, ABSPATH . (string)'wp-content/uploads/activity');
		$this->clean_dir();
		$feed->handle_content_type();
		if ($feed->data) :
			foreach($feed->get_items() as $entry) :
				$update[]['title'] = $entry->get_title();
				$update[]['link'] = $entry->get_permalink();
				$update[]['date'] = strtotime(substr($entry->get_date(),0,25));
			endforeach;
			$return = array_slice($update,0,5);
			// This auto-hyperlinks URLs
			$return[0]['title'] = preg_replace('((?:\S)+://\S+[[:alnum:]]/?)', '<a href="\0">\0</a>', $return[0]['title']);
			/**
			 * If Twitter is the source, then we hyperlink any '@username's
			 * to that user's Twitter address.
			 **/
			if ($istwitter)
				$return[0]['title'] = preg_replace('/(@)([A-Za-z0-9_-]+)/', '<a href="http://twitter.com/\2">\0</a>', $return[0]['title']);
			// We want dates in local time, as specified by user
			$local_time = $return[2]['date'] + get_option('gmt_offset') * 3600;
			return substr($return[0]['title'], 0, 1000)." &mdash; <a href=\"{$return[1]['link']}\">".date(get_option('time_format'), $local_time).'</a>';
		else :
			return 'Thanks for exploring my world! Can you believe this avatar is talking to you?';
		endif;
	}
	/**
	* Checks the update cache
	**/
	function chkfile($f) {
		clearstatcache();
		// Check to see if the feed file exists
		if (is_file($f)) :
			// If it's newer than 45 seconds, we're OK
			$diff = time() - filemtime($f);
			if($diff < 45)
				return true;
		endif;
		// If it's older or non-existent, fetch it
		return false;
	}
	/**
	 * Calls fetchfeed() to create a new update cache file
	 **/
	function cacheit($f) {
		// Use SimplePie to fetch the latest feed
		$latest = $this->fetchfeed();
		// Store it in a file
		file_put_contents($f,$latest);
		// Set the file's last modified time to right now
		touch($f);
	}
	/**
	 * Displays the feed entry.
	 **/
	function display() {
		// The location of the update cache file
		$f = get_template_directory().'/app/cache/statusupdate.cache';
		// Check if feed file is recent, else store a new one
		if (!$this->chkfile($f))
			$this->cacheit($f);
		// Time to let people know what's up!
		return file_get_contents($f);
	}
} ?>
