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
$help_content = array(
	array(
		'title' => __('Social Me Help', 'wicketpixie'),
		'id' => 'wicketpixie-socialme-help',
		'content' => '<p>'.__('If you\'d like to let your visitors know where else they may find you throughout the Web, you can do it easily through your "Social Me" page. This is an exclusive feature of the WicketPixie theme for WordPress. If you have accounts on other blogs, social networks, forums, Web sites, etc, add them here. For example, you might add your Twitter, YouTube, and Flickr accounts here - making sure you use the corresponding RSS (or Atom) feeds for your profile, so that WicketPixie can display your latest content from them on your Social Me page.', 'wicketpixie').'</p><p>'.__('You can also include the list of these accounts in your sidebar by adding the WicketPixie FeedWidget and choosing a feed.', 'wicketpixie').'</p>')
);
class SourceAdmin extends DBAdmin {
	/**
	 * Class construct
	 **/
	function __construct() {
		parent::__construct('Social Me Manager','sourcemanager.php','wicketpixie-admin.php',null,$GLOBALS['help_content'],'wik_sources');
		global $wpdb;
		$this->life = $wpdb->prefix . 'wik_life_data';
		$this->types = $wpdb->prefix . 'wik_source_types';
	}
	function __destruct() {
		parent::__destruct();
	}
	/**
	 * Here we install the tables and initial data needed to
	 * power our special functions
	 **/
	function install() {
		global $wpdb;
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		if ($wpdb->get_var("show tables like '{$this->table}'") != $this->table)
			dbDelta("CREATE TABLE {$this->table} (id int NOT NULL AUTO_INCREMENT, title varchar(255) NOT NULL, profile_url varchar(255) NOT NULL, feed_url varchar(255) NOT NULL, type boolean NOT NULL, lifestream boolean NOT NULL, updates boolean NOT NULL, favicon varchar(255) NOT NULL, UNIQUE KEY id (id));");
		if ($wpdb->get_var("show tables like '{$this->life}'") != $this->life)
			dbDelta("CREATE TABLE {$this->life} (id int NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL, content TEXT NOT NULL, date varchar(255) NOT NULL, link varchar(255) NOT NULL, enabled boolean NOT NULL, UNIQUE KEY id (id));");
		if ($wpdb->get_var("show tables like '{$this->types}'") != $this->types)
			dbDelta("CREATE TABLE {$this->types} (id int NOT NULL AUTO_INCREMENT, type_id tinyint(4) NOT NULL, name varchar(255) NOT NULL, UNIQUE KEY id (id));");
		$types = array(
			array('type_id' => '3', 'name' => 'Social Network'),
			array('type_id' => '2', 'name' => 'Website/Blog'),
			array('type_id' => '1', 'name' => 'Images')
		);
		foreach ($types as $type)
			if (!$wpdb->get_var("SELECT type_id FROM {$this->types} WHERE type_id = {$type['type_id']}"))
				$wpdb->query("INSERT INTO {$this->types} (id,type_id,name) VALUES('', '{$type['type_id']}', '{$type['name']}')");
		$wicketpixie_sources_db_version = '1.5';
		if ($wicketpixie_sources_db_version != get_option('wicketpixie_sources_db_version'))
			update_option('wicketpixie_sources_db_version',$wicketpixie_sources_db_version);
	}
	function get_streams() {
		global $wpdb;
		require_once(CLASSFEEDPATH);
		$streams = $wpdb->get_results("SELECT title,feed_url FROM {$this->table} WHERE lifestream = 1");
		foreach ($streams as $stream) :
			$feed = fetch_feed($stream->feed_url);
			if (!is_wp_error($feed)) :
				foreach ($feed->get_items() as $entry) :
					$date = strtotime(substr($entry->get_date(), 0, 25));
					$stream_contents[$date]['name'] = $stream->title;
					$stream_contents[$date]['title'] = $entry->get_title();
					$stream_contents[$date]['link'] = $entry->get_permalink();
					$stream_contents[$date]['date'] = $date;
					if ($enclosure = $entry->get_enclosure(0))
						$stream_contents[$date]['enclosure'] = $enclosure->get_link();
				endforeach;
			endif;
		endforeach;
		krsort($stream_contents);
		return $stream_contents;
	}
	function archive_streams() {
		global $wpdb;
		$archives = $this->get_streams();
		foreach ($archives as $archive) 
			if (!$wpdb->get_var("SELECT id FROM {$this->life} WHERE link = '{$archive['link']}' AND date = {$archive['date']}"))
				$wpdb->query("INSERT INTO {$this->life} (id,name,content,date,link,enabled) VALUES('', '".addslashes($archive['name'])."', '".addslashes($archive['title'])."', '{$archive['date']}', '{$archive['link']}', 1)");
	}
	/**
	 * Method to grab all of our lifestream data from the DB.
	 * <code>
	 * foreach (SourceAdmin::show_streams() as $stream) {
	 * 	// do something clever
	 * }
	 * </code>
	 **/
	function show_streams() {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM {$this->life} WHERE enabled = 1 ORDER BY date DESC");
	}
	function flush_streams($stream) {
		global $wpdb;
		$wpdb->get_results("DELETE FROM {$this->life} WHERE name = '$stream'");
	}
	function source ($name) {
		global $wpdb;
		$source = $wpdb->get_results("SELECT profile_url, favicon FROM {$this->table} WHERE title = '$name'");
		return $source[0];
	}
	function feed_check ($name) {
		global $wpdb;
		$feedlink = $wpdb->get_var("SELECT feed_url FROM {$this->table} WHERE title = '$name'");
		if (!empty($feedlink))
			return 1;
		return 0;
	}
	function legend_types() {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM {$this->table} ORDER BY title");
	}
	/**
	 * Add a source to the database.
	 **/
	function add($args) {
		global $wpdb;
		$stream = (!empty($args['lifestream'])) ? 1 : 0;
		$update = (!empty($args['updates'])) ? 1 : 0;
		$dbfeedurl = ($args['url'] == 'Profile Feed URL') ? '' : $args['url'];
		$profurl = ($args['profile'] == 'Profile URL')? '' : $args['profile'];
		$favicon_url = $this->get_favicon($profurl);
		if ($args['title'] != 'Social Me Title (required)') :
			if (!$wpdb->get_var("SELECT id FROM {$this->table} WHERE feed_url = '{$args['url']}'")) :
				$wpdb->query("INSERT INTO {$this->table} (id,title,profile_url,feed_url,type,lifestream,updates,favicon) VALUES('', '{$args['title']}', '$profurl', '$dbfeedurl', {$args['type']}, $stream, $update, '$favicon_url')");
				return array('updated','Social Me Account saved.');
			else :
				return array('error','There already exists a Social Me with the specified feed.');
			endif;
		else :
			return array('error','You forgot to fill out some information, please try again.');
		endif;
	}
	/**
	 * Edit the information for a given source.
	 **/
	function edit($args) {
		global $wpdb;
		$stream = (!empty($args['lifestream'])) ? 1 : 0;
		$update = (!empty($args['updates'])) ? 1 : 0;
		$feedurl = ($args['url'] == 'Profile Feed URL') ? '' : $args['url'];
		$profurl = ($args['profile'] == 'Profile URL')? '' : $args['profile'];
		$favicon_url = $this->get_favicon($profurl);
		$wpdb->query("UPDATE {$this->table} SET title = '{$args['title']}', profile_url = '$profurl', feed_url = '{$feedurl}', type = {$args['type']}, lifestream = $stream, updates = $update, favicon = '$favicon_url' WHERE id = {$args['id']}");
		$this->toggle($args['id'], $stream);
	}
	function toggle($id, $direction) {
		global $wpdb;
		$name = $wpdb->get_results("SELECT title FROM {$this->table} WHERE id = $id");
		$wpdb->query("UPDATE {$this->life} SET enabled = $direction WHERE name = '{$name[0]->title}'");
	}
	/**
	 * Rebuild widgets and remove from Status Update when burninating.
	 **/
	function burninate($id) {
		parent::burninate($id);
		$this->toggle($id, 0);
	}
	/**
	 * We call hulk_smash when the tables make Hulk angry.
	 * The tables wouldn't want to see Hulk when he's angry.
	 * Drops the Social Me tables.
	 **/
	function hulk_smash() {
		global $wpdb;
		$wpdb->query("DROP TABLE {$this->table}, {$this->life}, {$this->types}");
	}
	/**
	 * Method to fetch the types of sources we have stored in the db.
	 **/
	function types() {
		global $wpdb;
		$types = $wpdb->get_results("SELECT * FROM {$this->types}");
		if (is_array($types)) return $types;
		return array();
	}
	/**
	 * Helper method to return the human readable name
	 * of a type, given a type_id.
	 **/
	function type_name($id) {
		global $wpdb;
		$name = $wpdb->get_results("SELECT name FROM {$this->types} WHERE type_id = '$id'");
		return $name[0]->name;
	}
	function get_feed($url) {
		require_once (CLASSFEEDPATH);
		$feed = fetch_feed($url);
		if (!is_wp_error($feed)) :
			foreach ($feed->get_items() as $entry) :
				$date = strtotime(substr($entry->get_date(), 0, 25));
				$widget_contents[$date]['title'] = $entry->get_title();
				$widget_contents[$date]['link'] = $entry->get_permalink();
				$widget_contents[$date]['date'] = $date;
				if ($enclosure = $entry->get_enclosure(0))
					$widget_contents[$date]['enclosure'] = $enclosure->get_link();
			endforeach;
		endif;
		return $widget_contents;
	}
	/**
	 * The admin page for our sources/activity system.
	 **/
	function page_display() {
		if (isset($_GET['page']) && isset($_POST['action']) && $_GET['page'] == basename(__FILE__)) :
			if ($_POST['action'] == 'add') :
				$added = $this->add($_REQUEST); ?>
				<div id="message" class="<?php echo $added[0]; ?> fade"><p><strong><?php echo $added[1]; ?></strong></p></div>
			<?php elseif ($_POST['action'] == 'gather') :
				$this->gather($_REQUEST['id']);
			elseif ($_POST['action'] ==  'edit'):
				$this->edit($_REQUEST); ?>
				<div id="message" class="updated fade"><p><strong>Social Me Account modified.</strong></p></div>
			<?php elseif ($_POST['action'] ==  'delete') :
				$this->burninate($_REQUEST['id']); ?>
				<div id="message" class="updated fade"><p><strong>Social Me Account removed.</strong></p></div>
			<?php elseif ($_POST['action'] == 'hulk_smash'):
				$this->hulk_smash(); ?>
				<div id="message" class="updated fade"><p><strong>Social Me database cleared.</strong></p></div>
			<?php elseif ($_POST['action'] == 'install'):
				$this->install(); ?>
				<div id="message" class="updated fade"><p><strong>Social Me Manager installed.</strong></p></div>
			<?php elseif ($_POST['action'] == 'flush'):
				$this->flush_streams($_REQUEST['flush_name']); ?>
				<div id="message" class="updated fade"><p><strong>Social Me Account flushed.</strong></p></div>
			<?php endif;
		endif; ?>
		<div class="wrap wicketpixie">
			<div id="admin-options">
				<h2>Manage My "Social Me" Page</h2>
				<?php if ($this->check()) :
				if ($this->count()) : ?>
				<h3>Social Me Listing</h3>
				<form>
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<p style="margin-bottom:0;">Sort by: <select name="type" id="type">
						<?php foreach ($this->types() as $type) : ?>
							<option value="<?php echo $type->type_id; ?>"><?php echo $type->name; ?></option>
						<?php endforeach; ?>
					</select> </p>
				</form>
				<table class="form-table" style="margin-bottom:20px;">
					<tr>
						<th>Icon</th>
						<th>Title</th>
						<th style="text-align:center;">Feed</th>
						<th style="text-align:center;">Type</th>
						<th style="text-align:center;">Activity</th>
						<th style="text-align:center;" colspan="3">Actions</th>
					</tr>
					<?php foreach ($this->collect() as $source) :
							$isfeed = $this->feed_check($source->title); ?>
					<tr>
						<td style="width:16px;"><img src="<?php echo $source->favicon; ?>" alt="Favicon" style="width: 16px; height: 16;" /></td>
						<td><a href="<?php echo $source->profile_url; ?>"><?php echo $source->title; ?></a></td>
						
						<td style="text-align:center;">
							<?php if ($isfeed == 1) : ?>
							<a href="<?php echo $source->feed_url; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-feed.gif" alt="View"/></a></td>
							<?php elseif ($isfeed == 0) :
								echo 'N/A';
							else :
								echo '?';
							endif; ?>
						</td>
						<td style="text-align:center;"><?php echo $this->type_name( $source->type ); ?></td>
						<td style="text-align:center;"><?php echo ($source->lifestream == 0) ? 'No' : 'Yes'; ?></td>
						<td>
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=sourcemanager.php&amp;gather=true&amp;id=<?php echo $source->id; ?>">
								<?php wp_nonce_field('wicketpixie-settings'); ?>
								<input type="submit" value="Edit" />
								<input type="hidden" name="action" value="gather" />
							</form>
						</td>
						<td>
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=sourcemanager.php&amp;delete=true&amp;id=<?php echo $source->id; ?>">
								<?php wp_nonce_field('wicketpixie-settings'); ?>
								<input type="submit" name="action" value="Delete" />
								<input type="hidden" name="action" value="delete" />
							</form>
						</td>
						<?php if ($isfeed == 1) : ?>
						<td>
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=sourcemanager.php&amp;flush=true&amp;id=<?php echo $source->id; ?>">
								<?php wp_nonce_field('wicketpixie-settings'); ?>
								<input type="submit" value="Flush" />
								<input type="hidden" name="action" value="flush" />
								<input type="hidden" name="flush_name" value="<?php echo $source->title; ?>" />
							</form>
						</td>
						<?php endif; ?>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php else : ?>
				<p>You don't have any Social Mes, why not add some?</p>
				<?php endif;
				if (isset($_REQUEST['gather'])) :
				$data = $this->gather($_REQUEST['id']); ?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=sourcemanager.php&amp;edit=true" class="form-table" style="margin-bottom:30px;">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<h2>Editing "<?php echo $data[0]->title; ?>"</h2>
					<p><input type="text" name="title" id="title" value="<?php echo $data[0]->title; ?>" /></p>
					<p><input type="text" name="profile" id="profile" value="<?php echo $data[0]->profile_url; ?>" /></p>
					<p><input type="text" name="url" id="url" value="<?php echo $data[0]->feed_url; ?>" /></p>
					<p><input type="checkbox" name="lifestream" id="lifestream" value="1" <?php if( $data[0]->lifestream == '1' ) echo 'checked'; ?>><label for="lifestream">&nbsp;</label>Add to Activity?</p>
					<p><input type="checkbox" name="updates" id="updates" value="1" <?php if( $data[0]->updates == '1' ) echo 'checked'; ?>><label for="updates">&nbsp;</label>Use for Status Updates?</p>
					<p>Type:
						<select name="type" id="type">
							<?php foreach ($this->types() as $type) : ?>
								<option value="<?php echo $type->type_id; ?>" <?php if ($type->type_id == $data[0]->type) echo 'selected'; ?>><?php echo $type->name; ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<p class="submit">
						<input name="save" type="submit" value="Save Social Me" />
						<input type="hidden" name="action" value="edit" />
						<input type="hidden" name="id" value="<?php echo $data[0]->id; ?>">
					</p>
				</form>
				<?php else : ?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=sourcemanager.php&amp;add=true" class="form-table" style="margin-bottom:30px;">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<h2>Add a New Social Me</h2>
					<p><input type="text" name="title" id="title" onfocus="if(this.value=='Social Me Title (required)')value=''" onblur="if(this.value=='')value='Social Me Title (required)';" value="Social Me Title (required)" /></p>
					<p><input type="text" name="profile" id="profile" onfocus="if(this.value=='Profile URL')value=''" onblur="if(this.value=='')value='Profile URL';" value="Profile URL" /></p>
					<p><input type="text" name="url" id="url" onfocus="if(this.value=='Profile Feed URL')value=''" onblur="if(this.value=='')value='Profile Feed URL';" value="Profile Feed URL" /></p>
					<p><input type="checkbox" name="lifestream" id="lifestream" value="1" checked="checked"><label for="lifestream">&nbsp;</label>Add to Activity Stream?</p>
					<p><input type="checkbox" name="updates" id="updates" value="1"><label for="updates">&nbsp;</label>Use for Status Updates?</p>
					<p>Type:
						<select name="type" id="type">
							<?php foreach ($this->types() as $type) : ?>
								<option value="<?php echo $type->type_id; ?>"><?php echo $type->name; ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<p class="submit">
						<input type="submit" name="save" value="Save Social Me" />
						<input type="hidden" name="action" value="add" />
					</p>
				</form>
				<?php endif; ?>
				<form name="hulk_smash" id="hulk_smash" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=sourcemanager.php&amp;hulk_smash=true">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<h2>Delete the Social Mes Table</h2>
					<p>Please note, this is undoable and will result in the loss of all the data you have stored to date. Only do this if you are having problems with your social mes and you have exhausted every other option.</p>
					<p class="submit">
						<input type="submit" name="save" value="Delete Social Mes" />
						<input type="hidden" name="action" value="hulk_smash" />
					</p>
				</form>
				<?php else : ?>
				<form name="install" id="install" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=sourcemanager.php&amp;install=true">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<p>Before you start using Social Mes, you need to install the corresponding table into your database.</p>
					<p class="submit">
						<input type="hidden" name="action" value="install" />
						<input type="submit" value="Install Social Me" />
					</p>
				</form>
				<?php endif; ?>
			</div>
			<?php include_once('advert.php');
	}
} ?>
