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
 **/
/**
 * This class provides global database-related functions
 * that are used by some of our admin pages
 **/
class DBAdmin extends AdminPage {
	/**
	 * Class construct and destruct functions.
	 * Construct and destruct are not implicitly inherited,
	 * so we must make sure to call parent::__construct()
	 * and parent::destruct() in every class extend.
	 **/
	function __construct($name,$filename,$parent = null,$arrays = array(),$help_content = array(),$table) {
		parent::__construct($name,$filename,$parent,$arrays,$help_content);
		global $wpdb;
		$this->table = $wpdb->prefix.$table;
	}
	function __destruct() {
		parent::__destruct();
	}
	/**
	 * Check if we have installed the table for sources.
	 **/
	function check() {
		global $wpdb;
		if ($wpdb->get_var("show tables like '{$this->table}'" ) == $this->table)
			return true;
		return false;
	}
	/**
	 * Count the number of sources currently in the db.
	 **/
	function count() {
		global $wpdb;
		$total = $wpdb->get_results("SELECT ID as count FROM {$this->table}");
		if (isset($total[0]))
			return $total[0]->count;
		return 0;
	}
	/**
	 * Grab all the sources we have stored in the db.
	 **/
	function collect() {
		global $wpdb;
		$sources = $wpdb->get_results("SELECT * FROM {$this->table}");
		if (is_array($sources))
			return $sources;
		return array();
	}
	/**
	 * Gather a given source's information for editing.
	 **/
	function gather($id) {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM {$this->table} WHERE id = $id");
	}
	/**
	 * We call burninate so that Trogdor the Dragon-Man can
	 * burninate the peasants. Or sources as the case may be.
	 * Removes the selected record from the DB.
	 **/
	function burninate($id) {
		global $wpdb;
		$wpdb->query("DELETE FROM {$this->table} WHERE id = $id");
	}
	/**
	 * Sort a given source.
	 * Found in older versions, but apparently unused.
	 **/
	function sort($args) {
		global $wpdb;
		$orig_sort = $wpdb->get_results("SELECT sortorder FROM {$this->table} WHERE id = {$args['id']}");
		if ($orig_sort) :
			$old_value = $orig_sort[0]->sortorder;
			$wpdb->query("UPDATE {$this->table} SET sortorder = sortorder + 1 WHERE sortorder > {$args['newsort']}");
			$wpdb->query("UPDATE {$this->table} SET sortorder = {$args['newsort']} + 1 WHERE id = {$args['id']}");
			$wpdb->query("UPDATE {$this->table} SET sortorder = sortorder -1 WHERE sortorder > $old_value");
		endif;
	}
}
