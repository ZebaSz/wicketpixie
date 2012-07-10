<?php
/**
 * WicketPixie v1.5
 * (c) 2006-2009 Eddie Ringle,
 *               Chris J. Davis,
 *               Dave Bates
 * Provided by Chris Pirillo
 *
 * (c) 2011-2021 Sebastian Szperling
 *
 * Licensed under the New BSD License.
 */
$help_content = array(
	array(
		'title' => 'AdSense Help',
		'id' => 'wicketpixie-adsense-help',
		'content' => '<p>'.__('In order to add ad slots, you must log in to Google AdSense and create an ad slot. You can check the available WicketPixie ad slots to select the appropriate mesures. Then, copy the corresponding javascript code, select the ad slot and paste the code into the ad code area. And that\'s it! Enjoy your new monetized blog!','wicketpixie').'</p><p>'.__('You can also enable AdSense for Search. In order to do that, you must first create an AdSense for Search slot in Google AdSense. From the code provided by AdSense, you must extract the PubID (you will find it as the value of the input tag named \'cx\'). Then, you must create a new WordPress page using the AdSense for Search template, enter the page URL in the settings box, and save. Make sure you have \'pretty permalinks\' enabled, or else this won\t work.','wicketpixie').'</p>'
	)
);
class AdsenseAdmin extends DBAdmin {
	function __construct() {
		parent::__construct('AdSense Settings','adsenseads.php','wicketpixie-admin.php',null,$GLOBALS['help_content'],'wik_adsense');
	}
	function __destruct() {
		parent::__destruct();
	}
	/**
	* Here we install the tables and initial data needed to
	* power our special functions
	*/
	function install() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$wipi_adsense_db_version = '1.5';
		if ($wpdb->get_var("show tables like '{$this->table}'" ) != $this->table) :
			dbDelta("CREATE TABLE {$this->table} (id int NOT NULL AUTO_INCREMENT, ad_code VARCHAR(512) NOT NULL, placement VARCHAR(255) NOT NULL, sortorder smallint(9) NOT NULL, UNIQUE KEY id (id))");
		endif;
		if ($wipi_adsense_db_version != get_option('wicketpixie_adsense_db_version')) :
			$wpdb->query("ALTER TABLE {$this->table} CHANGE ad_id ad_code varchar(255);");
			$wpdb->query("ALTER TABLE {$this->table} MODIFY ad_code VARCHAR(512);");
			update_option('wicketpixie_adsense_db_version',$wipi_adsense_db_version);
		endif;
	}
	// Adds an ad slot to the database
	function add($_REQUEST) {
		global $wpdb;
		$args = $_REQUEST;
		if ($args['ad_code'] == 'Ad Code') $args['ad_code'] = '';
		if (!$wpdb->get_var("SELECT id FROM {$this->table} WHERE ad_code = '{$args['ad_code']}'")) :
			$id = $wpdb->get_var("SELECT sortorder FROM {$this->table} ORDER BY sortorder DESC LIMIT 1");
			$id++;
			$wpdb->query("INSERT INTO {$this->table} (id,ad_code,placement,sortorder) VALUES('', '{$args['ad_code']}', '{$args['placement']}', $id)");
		endif;
	}
	// Turns WicketPixie's AdSense features on and off
	function toggle() {
		if (get_option('wicketpixie_enable_adsense') == 'true') :
			update_option('wicketpixie_enable_adsense','false');
		else :
			update_option('wicketpixie_enable_adsense','true');
		endif;
	}
	/**
	* Method to grab all of our lifestream data from the DB.
	* <code>
	* foreach ($sources->show_streams() as $stream) {
	* 	// do something clever
	* }
	* </code>
	*/
	function positions() {
		global $wpdb;
		return $wpdb->get_results( "SELECT sortorder FROM {$this->table} ORDER BY sortorder ASC" );
	}
	function adsearch() {
		if (isset($_POST['wicketpixie_adsense_search_enabled'])) :
			update_option('wicketpixie_adsense_search_enabled','true');
		else :
			update_option('wicketpixie_adsense_search_enabled','false');
		endif;
		update_option('wicketpixie_adsense_search_pubid',$_POST['wicketpixie_adsense_search_pubid']);
		wp_redirect($_SERVER['PHP_SELF'] .'?page='.$this->filename.'&saved=true');
	}
	function ad_display($placement) {
		global $wpdb;
		if ($this->check()):
			$ad_code = $wpdb->get_var("SELECT ad_code FROM {$this->table} WHERE placement= '$placement' LIMIT 1");
			return (empty($ad_code)) ? '<!-- No ad code found for this type, set one up on the WicketPixie AdSense Settings page. -->' : $ad_code;
		endif;
	}
	function request_check() {
		if (isset($_GET['page']) && $_GET['page'] == basename(__FILE__) && isset($_POST['action'])) :
			if ($_POST['action'] == 'add') $this->add( $_REQUEST );
			if ($_POST['action'] == 'toggle') $this->toggle();
			if ($_POST['action'] == 'delete') $this->burninate($_REQUEST['id']);
			if ($_POST['action'] == 'install') $this->install();
			if ($_POST['action'] == 'adsearch') $this->adsearch();
		endif;
	}
	/**
	* The admin menu for our AdSense system
	*/
	function page_display() {
		if (isset($_REQUEST['add'])) : ?>
		<div id="message" class="updated fade"><p><strong>Ad code added.</strong></p></div>
		<?php endif; ?>
			<div class="wrap wicketpixie">
				<div id="admin-options">
					<h2>AdSense Settings</h2>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=adsenseads.php&toggled=true" class="form-table">
					<?php wp_nonce_field('wicketpixie-settings'); ?>
						<h3>Toggle AdSense Ads</h3>
						<p class="submit">
						<input type="submit" name="toggle" value="Turn <?php echo (is_enabled_adsense()) ? 'off' : 'on'; ?> AdSense Ads" />
						<input type="hidden" name="action" value="toggle" />
						</p>
					</form>
					<?php if ($this->check()) :
					if ($this->count() != '') : ?>
					<table class="form-table" style="margin-bottom:30px;">
						<tr>
							<th>Ad Code</th>
							<th style="text-align:center;">Placement</th>
							<th style="text-align:center;" colspan="1">Actions</th>
						</tr>
						<?php foreach ($this->collect() as $adslot) : ?>
						<tr>
							<td><?php echo htmlentities($adslot->ad_code); ?></td>
							<td style="text-align:center;">
								<?php if ($adslot->placement == 'blog_header') :
									echo 'Blog Header (728x90)';
								elseif ($adslot->placement == 'blog_post_side') :
									echo 'Right of Blog Post (120x240)';
								elseif ($adslot->placement == 'blog_post_bottom') :
									echo 'Underneath Home Post (300x250)';
								elseif ($adslot->placement == 'blog_sidebar') :
									echo 'Bottom-left of Sidebar (120x600)';
								elseif ($adslot->placement == 'blog_home_post_front') :
									echo 'Home Post, Before Content (300x250)';
								elseif ($adslot->placement == 'blog_post_front') :
									echo 'Single Post, Before Content (300x250)';
								else :
									echo $adslot-placement;
								endif; ?>
							</td>
							<td style="text-align:center;">
								<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=adsenseads.php&amp;delete=true&amp;id=<?php echo $adslot->id; ?>">
								<?php wp_nonce_field('wicketpixie-settings'); ?>
									<input type="submit" name="action" value="Delete" />
									<input type="hidden" name="action" value="delete" />
								</form>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
					<?php else : ?>
					<p>You haven't added any ad slots, add them here.</p>
					<?php endif; ?>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=adsenseads.php&amp;add=true" class="form-table">
					<?php wp_nonce_field('wicketpixie-settings'); ?>
						<h3>Add an Ad Slot</h3>
						<p><textarea name="ad_code" id="ad_code" onfocus="if(this.innerHTML=='Ad Code') this.innerHTML = ''">Ad Code</textarea></p>
						<p><select name="placement" id="title">
							<option value="blog_header">Blog header (728x90)</option>
							<option value="blog_post_side">Right of Blog Post (120x240)</option>
							<option value="blog_post_bottom">Underneath Home Post (300x250)</option>
							<option value="blog_sidebar">Bottom-left of Sidebar (120x600)</option>
							<option value="blog_home_post_front">Home Post, Before Content (300x250)</option>
							<option value="blog_post_front">Single Post, Before Content (300x250)</option>
						</select></p>
						<p class="submit">
							<input name="save" type="submit" value="Add Ad Slot" /> 
							<input type="hidden" name="action" value="add" />
						</p>
					</form>
				<?php else : ?>
				<h3>Install AdSense table</h3>
				<p>You need to install the AdSense table before adding ad slots.</p>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=adsenseads.php&amp;install=true">
					<p class="submit">
						<input name="save" type="submit" value="Install AdSense table"/>
						<input type="hidden" name="action" value="install"/>
					</p>
				</form>
				<?php endif; ?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=adsenseads.php&adsearch=true" class="form-table">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<h3>AdSense for Search</h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row" style="font-size:12px;text-align:left;padding-right:10px;">
							Enable AdSense for Search
							</th>
							<td style="padding-right:10px;">
								<input type='checkbox' name='wicketpixie_adsense_search_enabled' id='wicketpixie_adsense_search_enabled' <?php if (get_option('wicketpixie_adsense_search_enabled') == 'true') echo 'checked="ckecked"'; ?> />
								<label for='wicketpixie_adsense_search_enabled'>&nbsp;</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" style="font-size:12px;text-align:left;padding-right:10px;">
							PubID
							</th>
							<td style="padding-right:10px;">
								<input type='text' name='wicketpixie_adsense_search_pubid' id='wicketpixie_adsense_search_pubid' value="<?php echo get_option('wicketpixie_adsense_search_pubid'); ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" style="font-size:12px;text-align:left;padding-right:10px;">
							Search Results URL
							</th>
							<td style="padding-right:10px;">
								<?php echo home_url(); ?><input type='text' name='wicketpixie_adsense_search_url' id='wicketpixie_adsense_search_url' value="/search/" disabled="disabled" />
							</td>
						</tr>
					</table>
					<p class="submit">
						<input name="adsearch" type="submit" value="Save AdSense for Search Settings" />
						<input type="hidden" name="action" value="adsearch" />
					</p>
				</form>
			</div>
			<?php include_once('advert.php');
	}
}
// This checks to see if WicketPixie's AdSense features are enabled
function is_enabled_adsense() {
	if(get_option('wicketpixie_enable_adsense') == 'true')
		return true;
	return false;
}
function wp_adsense($placement) {
	$adsense = new AdsenseAdmin;
	echo $adsense->ad_display($placement);
} ?>
