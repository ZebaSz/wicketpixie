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
class FavesAdmin extends DBAdmin {
	function __construct() {
		parent::__construct('Faves Manager','faves.php','wicketpixie-admin.php',null,array(),'wik_faves');
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
			dbDelta("CREATE TABLE {$this->table} (id int NOT NULL AUTO_INCREMENT, title varchar(255) NOT NULL, feed_url varchar(255) NOT NULL, favicon varchar(255) NOT NULL, sortorder tinyint(9) NOT NULL, UNIQUE KEY id (id));");
	}
	function check() {
		global $wpdb;
		if ($wpdb->get_var("SHOW TABLES LIKE '{$this->table}'") == $this->table)
			return true;
		return false;
	}
	function count() {
		global $wpdb;
		$total = $wpdb->get_results("SELECT ID as count FROM {$this->table}");
		if (isset($total[0]))
			return $total[0]->count;
		return 0;
	}
	function add($args) {
		global $wpdb;
		if ($args['title'] != 'Fave Title' && $args['url'] != 'Fave Feed URL') :
			if ($wpdb->get_var("SELECT id FROM {$this->table} WHERE feed_url = '{$args['url']}'") == null) :
				$id = $wpdb->get_var("SELECT sortorder FROM {$this->table} ORDER BY sortorder DESC LIMIT 1") + 1;
				$wpdb->query("INSERT INTO {$this->table} (id,title,feed_url,sortorder) VALUES('', '{$args['title']}', '{$args['url']}', $id)");
			else :
				echo($wpdb->get_var("SELECT id FROM {$this->table} WHERE feed_url = '{$args['url']}'"));
			endif;
		endif;
	}
	function collect() {
		global $wpdb;
		$sources = $wpdb->get_results("SELECT * FROM {$this->table}");
		if (is_array($sources))
			return $sources;
		return array();
	}
	function gather($id) {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM {$this->table} WHERE id = $id");
	}
	/**
	 * Edit the information for a given fave.
	 **/
	function edit($args) {
		global $wpdb;
		$wpdb->query("UPDATE {$this->table}  SET title = '{$args['title']}', feed_url = '{$args['url']}' WHERE id = {$args['id']}");
	}
	function burninate( $id ) {
		global $wpdb;
		$wpdb->query("DELETE FROM {$this->table} WHERE id = $id");
	}
	/**
	 * Method to grab all of our lifestream data from the DB.
	 * <code>
	 * foreach( $sources->show_streams() as $stream ) {
	 * 	// do something clever
	 * }
	 * </code>
	 **/
	function show_faves() {
		global $wpdb;
		return $wpdb->get_results("SELECT * FROM {$this->table} ORDER BY sortorder ASC");
	}
	function positions() {
		global $wpdb;
		return $wpdb->get_results("SELECT sortorder FROM {$this->table} ORDER BY sortorder ASC");
	}
	/**
	 * The admin menu for our faves system
	 **/
	function page_display() {
		if (isset($_GET['page']) && isset($_POST['action']) && $_GET['page'] == basename(__FILE__)) :
			if ($_POST['action'] == 'add')
				$this->add($_REQUEST);
			if ($_POST['action'] == 'edit')
				$this->edit($_REQUEST);
			if ($_POST['action'] == 'delete')
				$this->burninate($_REQUEST['id']);
			if ($_POST['action'] == 'install')
				$this->install();
		endif;
		if (isset($_REQUEST['add'])) : ?>
		<div id="message" class="updated fade"><p><strong>Fave saved.</strong></p></div>
		<?php endif; ?>
		<div class="wrap">
			<div id="admin-options">
				<h2>Manage My Faves</h2>
				<?php if ($this->check()) :
				$count = $this->count();
				if (!empty($count)) : ?>
				<table class="form-table" style="margin-bottom:30px;">
					<tr>
						<th>Title</th>
						<th style="text-align:center;">Feed</th>
						<th style="text-align:center;" colspan="2">Actions</th>
					</tr>
					<?php foreach ($this->collect() as $fave) : ?>
					<tr>
						<td><?php echo $fave->title; ?></td>
						<td style="text-align:center;"><a href="<?php echo $fave->feed_url; ?>" title="<?php echo $fave->feed_url; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-feed.gif" alt="View"/></a></td>
						<td style="text-align:center;">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>&amp;gather=true&amp;id=<?php echo $fave->id; ?>">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
								<input type="submit" value="Edit" />
								<input type="hidden" name="action" value="gather" />
							</form>
						</td>
						<td style="text-align:center;">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>&amp;delete=true&amp;id=<?php echo $fave->id; ?>">
							<?php wp_nonce_field('wicketpixie-settings'); ?>
								<input type="submit" name="action" value="Delete" />
								<input type="hidden" name="action" value="delete" />
							</form>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php else : ?>
				<p>You don't have any Favorites, why not add some?</p>
				<?php endif; ?>
				<?php if (isset($_REQUEST['gather'])) :
				$data = $this->gather( $_REQUEST['id'] ); ?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>&amp;edit=true">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<h2>Editing "<?php echo $data[0]->title; ?>"</h2>
					<p><input type="text" name="title" id="title" value="<?php echo $data[0]->title; ?>" /></p>
					<p><input type="text" name="url" id="url" value="<?php echo $data[0]->feed_url; ?>" /></p>
					<p class="submit">
						<input name="save" type="submit" value="Save Changes" />
						<input type="hidden" name="action" value="edit" />
						<input type="hidden" name="id" value="<?php echo $data[0]->id; ?>">
					</p>
				</form>
				<?php else : ?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>&amp;add=true" class="form-table">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<h2>Add a New Fave</h2>
					<p><input type="text" name="title" id="title" onfocus="if(this.value=='Fave Title')value=''" onblur="if(this.value=='')value='Fave Title';" value="Fave Title" /></p>
					<p><input type="text" name="url" id="url" onfocus="if(this.value=='Fave Feed URL')value=''" onblur="if(this.value=='')value='Fave Feed URL';" value="Fave Feed URL" /></p>
					<p class="submit">
						<input name="save" type="submit" value="Add Fave" />
						<input type="hidden" name="action" value="add" />
					</p>
				</form>
				<?php endif;
				else : ?>
				<p>Before you can add Faves, you must install the table first:</p>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>&amp;install=true">
					<p class="submit">
						<input name="save" type="submit" value="Install Faves" />
						<input type="hidden" name="action" value="install" />
					</p>
				</form>
				<?php endif; ?>
			</div>
			<?php include_once('advert.php');
	}
} ?>
