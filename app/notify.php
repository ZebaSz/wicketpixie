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
$help_content = array(
	array(
		'title' => 'WicketPixie Notifications',
		'id' => 'wicketpixie-notifications-help',
		'content' => '<p>WicketPixie Notifications sends out messages to different services like Twitter and Ping.fm to let your followers know of any new blog posts. In order to activate them, you may only need to enter a username and password, you may only need to enter an API/App key, or you may enter both. It all depends on which service you select.</p><p>Here\'s some basic tips:</p><ul><li>Use of the Ping.fm service only requires you to enter your App key, which you can obtain <a href="http://ping.fm/key">here</a>.</li><li>Use of the Twitter service only requires you to enter your Twitter username and password, no API/App key required.</li><li>If you choose to use Ping.fm, unless the other services are not setup in your Ping.fm account please do not add your details for them, as the notification will be sent out twice.</li></ul>'
	)
);
class NotifyAdmin extends DBAdmin {
	function __construct() {
		parent::__construct('Notifications Manager','notify.php','wicketpixie-admin.php',array(),$GLOBALS['help_content'],'wik_notify');
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
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		if ($wpdb->get_var("show tables like '{$this->table}'") != $this->table)
			dbDelta("CREATE TABLE {$this->table} (id int NOT NULL AUTO_INCREMENT, service varchar(255) NOT NULL, username varchar(255) NULL, password varchar(255) NULL, apikey varchar(255) NULL, sortorder smallint(9) NOT NULL, UNIQUE KEY id (id));");
	}
	function add($args) {
		global $wpdb;
		if ($args['service'] != 'Service Name') :
			if ($args['apikey'] == "API Key") $args['apikey'] = "";
			if ($args['username'] == "Username") $args['username'] = "";
			if ($args['password'] == "Password") $args['password'] = "";
			if ($wpdb->get_var("SELECT id FROM {$this->table} WHERE service = '{$args['service']}'") == NULL) :
				$id = $wpdb->get_var("SELECT sortorder FROM {$this->table} ORDER BY sortorder DESC LIMIT 1") + 1;
				$wpdb->query("INSERT INTO {$this->table} (id,service,username,password,apikey,sortorder) VALUES('', '{$args['service']}', '{$args['username']}', '{$args['password']}','{$args['apikey']}', $id)");
			endif;
		endif;
	}
	/**
	 * Returns the list of services that WicketPixie will notify when
	 * a blog post is published.
	 **/
	function show_notifications() {
		global $wpdb;
		return $wpdb->get_results( "SELECT * FROM {$this->table} ORDER BY sortorder ASC" );
	}
	function positions() {
		global $wpdb;
		return $wpdb->get_results( "SELECT sortorder FROM {$this->table} ORDER BY sortorder ASC" );
	}
	/**
	 * Turns WicketPixie Notifications on and off
	 **/
	// Function is disabled and force-disables Notifications
	// while a new version is worked on.
	function toggle() {
		//if (get_option('wicketpixie_notifications_enable') == 'true') :
			update_option('wicketpixie_notifications_enable','false');
		//else :
		//	update_option('wicketpixie_notifications_enable','true');
		//endif;
		wp_redirect($_SERVER['PHP_SELF'].'?page='.$this->filename.'&toggled=true');
	}
	function request_check() {
		if (isset($_GET['page']) && isset($_POST['action']) && $_GET['page'] == basename(__FILE__)) :
			if ('add' == $_POST['action']) :
				$this->add( $_REQUEST );
			elseif ( 'delete' == $_POST['action'] ) :
				$this->burninate( $_REQUEST['id'] );
			elseif ( 'toggle' == $_POST['action'] ) :
				$this->toggle();
			elseif('install' == $_POST['action']) :
				$this->install();
			endif;
		endif;
		unset($notify);
	}
	/**
	* The admin page where the user selects the services that
	* should be notified whenever a blog post is published.
	*/
	function page_display() {
		// Feature requires rewrite, force disable
		if (get_option('wicketpixie_notifications_enable') == 'true') $this->toggle();
		if (isset($_REQUEST['add'])) : ?>
		<div id="message" class="updated fade"><p><strong>Service added.</strong></p></div>
		<?php endif; ?>
		<div class="wrap">
			<div id="admin-options">
				<h2>Notification Settings</h2>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>" class="form-table">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<h3>Toggle WicketPixie Notifications</h3>
					<p>This feature requires a rewrite. In the meantime, it has been disabled.</p>
<?php /*
					<p class="submit">
						<input type="submit" name="toggle" value="Turn <?php echo (get_option('wicketpixie_notifications_enable') == 'true') ? 'off' : 'on' ; ?> WicketPixie Notifications" />
						<input type="hidden" name="action" value="toggle" />
					</p>
				</form>
				<?php if($this->check()) :
				if ($this->count() != '') : ?>
				<table class="form-table" style="margin-bottom:30px;">
					<tr>
						<th>Service</th>
						<th style="text-align:center;">Username</th>
						<th style="text-align:center;" colspan="1">Actions</th>
					</tr>
					<?php foreach($this->collect() as $service) : ?>
					<tr>
						<td><?php echo $service->service; ?></td>
						<td style="text-align:center;"><?php echo $service->username; ?></td>
						<td style="text-align:center;">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=notify.php&amp;delete=true&amp;id=<?php echo $service->id; ?>">
								<input type="submit" name="action" value="Delete" />
								<input type="hidden" name="action" value="delete" />
							</form>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php else : ?>
				<p>You haven't added any services, add them here.</p>
				<?php endif; ?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=notify.php&amp;add=true" class="form-table">
				<?php wp_nonce_field('wicketpixie-settings'); ?>
					<h3>Add a Service</h3>
					<p><select name="service" id="title">
						<option value="ping.fm">Ping.fm</option>
						<option value="twitter">Twitter</option>
					</select></p>
					<p><input type="text" name="username" id="url" onfocus="if(this.value=='Username')value=''" onblur="if(this.value=='')value='Username';" value="Username" /></p>
					<p><input type="text" name="password" id="url" onfocus="if(this.value=='Password')value=''" onblur="if(this.value=='')value='Password';" value="Password" /></p>
					<p><input type="text" name="apikey" id="url" onfocus="if(this.value=='API/App Key')value=''" onblur="if(this.value=='')value='API/App Key';" value="API/App Key" /></p>
					<p class="submit">
						<input name="save" type="submit" value="Add Service" /> 
						<input type="hidden" name="action" value="add" />
					</p>
				</form>
				<?php else : ?>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>&amp;install=true">
					<p>Before you can add a service, you must install the table.</p>
					<p class="submit">
						<input name="save" type="submit" value="Install Notifications table"/>
						<input type="hidden" name="action" value="install"/>
					</p>
				</form>
				<?php endif; ?>
*/?>
			</div>
			<?php include_once('advert.php');
	}
}
/**
 * Notifications System
 **/
/**
 * This is called when a post is published and
 * prepares to notify all services listed in the database
 **/
function prep_notify($id) {
	global $wpdb;
	$table = $wpdb->posts;
	$post['title'] = $wpdb->get_var("SELECT post_title FROM $table WHERE ID = $id");
	$post['link'] = get_permalink($id);
	$post['id'] = $id;
	// Message to be sent
	$message = $post['title'] . " ~ " . $post['link'];
	/**
	 * Developer API Keys
	 * DO NOT MODIFY FOR ANY REASON!
	 **/
	$devkeys = array(
		'ping.fm' => '7cf76eb04856576acaec0b2abd2da88b'
	);
	notify($message,$devkeys);
	return $id;
}
/**
 * This calls each service's notification function
 **/
function notify($message,$devkeys) {
	$notify = new NotifyAdmin();
	foreach($notify->collect() as $services) :
		if ($services->service == 'ping.fm')
			$errnum = notify_pingfm($message,$services->apikey,$devkeys['ping.fm']);
		if ($services->service == 'twitter')
			$errnum = notify_twitter($message,$services);
	endforeach;
}
/**
 * Executes a cURL request and returns the output
 **/
function notify_go($service,$type,$postdata,$ident) {
	if($service == 'ping.fm') :
		// Set the url based on type
		$url = "http://api.ping.fm/v1/".$type;
		// Setup cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		// Send the data and close up shop
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	elseif ($service == 'twitter') :
		// Tidy $postdata before sending it
		$postdata = urlencode(stripslashes(urldecode($postdata)));
		// Set the url based on type and add the POST data
		$url = "http://twitter.com/$type?status=$postdata&source=wicketpixie";
		// Setup cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_USERPWD, $ident['user'].":".$ident['pass']);
		curl_setopt($ch, CURLOPT_URL, $url);
		// Send the data and fetch the HTTP code
		$output = curl_exec($ch);
		$outArray = curl_getinfo($ch);
		if($outArray['http_code'] == 200)
			return 1;
		return 0;
	endif;
}
/**
 * Ping.fm notification function
 **/
function notify_pingfm($message,$appkey,$apikey) {
	// First, we validate the user's app key
	$output = notify_go('ping.fm','user.validate',array('api_key' => $apikey, 'user_app_key' => $appkey),NULL);
	if (preg_match('/<rsp status="OK">/',$output)) :
		// Okay, app key validated, now we can continue
		$output = notify_go('ping.fm','user.post',array('api_key' => $apikey, 'user_app_key' => $appkey, 'post_method' => 'status', 'body' => $message),NULL);
		return preg_match('/<rsp status="OK">/',$output);
	endif;
}
/**
 * Twitter notification function
 **/
function notify_twitter($message,$dbdata) {
	// Put username and password into an array for easier passing
	$ident = array("user" => $dbdata->username,"pass" => $dbdata->password);
	// Choose update format (update.xml or update.json)
	return notify_go('twitter','statuses/update.xml',$message,$ident);
}
if(get_option('wicketpixie_notifications_enable') == 'true')
	add_action ('publish_post', 'prep_notify');
