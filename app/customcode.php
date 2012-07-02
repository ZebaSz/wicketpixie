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
/**
* The convention for filenames is:
* header.php - included inbetween <head></head> tags
* footer.php - included before the </body> tag
* Please do not use a different file name for these two areas.
**/
define("CUSTOMPATH",get_template_directory()."/custom/");
/**
 * Custom code functions array
**/
$custom_codes = array(
	array(
		'title' => __('Global Announcement','wicketpixie'),
		'file' => 'global_announcement',
		'desc' => __('Upload a file containing code that you\'d like to appear on the home page and all your posts as a global announcement.','wicketpixie')),
	array(
		'title' => __('Custom Header','wicketpixie'),
		'file' => 'header',
		'desc' => __('Upload a file containing code that you\'d like to appear between the &lt;head&gt; and &lt;/head&gt; tags of your site.','wicketpixie')),
	array(
		'title' => __('Custom Footer','wicketpixie'),
		'file' => 'footer',
		'desc' => __('Upload a file containing code that you\'d like to appear just before the &lt;/body&gt; tag of your site.','wicketpixie')),
	array(
		'title' => __('After-Home-Post','wicketpixie'),
		'file'  => 'afterhomepost',
		'desc' => __('Upload a file containing code that you\'d like to appear between the post content and post meta-data on your homepage.','wicketpixie')),
	array(
		'title' => __('After-Posts','wicketpixie'),
		'file' => 'afterposts',
		'desc' => __('Upload a file containing code that you\'d like to appear between the post content and post meta-data on individual posts.','wicketpixie')),
	array(
		'title' => __('After-Home-Meta','wicketpixie'),
		'file' => 'afterhomemeta',
		'desc' => __('Upload a file containing code that you\'d like to appear after the post meta data but before the Flickr Widget, Embedded Video, etc.','wicketpixie')),
	array(
		'title' => __('Custom Home Sidebar code','wicketpixie'),
		'file' => 'homesidebar',
		'desc' => __('Upload a file containing code that you\'d like to appear after the Tag Cloud section of the homepage sidebar.','wicketpixie')),
	array(
		'title' => __('Custom 404 code','wicketpixie'),
		'file' => '404',
		'desc' => __('Upload a file containing code that you\'d like to appear in a 404 page (this will replace the default message).','wicketpixie'))
);
/**
* This is called in the admin page and every template that allows custom code.
* It returns the custom code if any. If not, returns an HTML comment.
**/

function wp_customcode($file) {
	if(file_exists(CUSTOMPATH ."$file.php")) include(CUSTOMPATH ."$file.php");
	else echo "<!-- No custom code found, add code on the WicketPixie Custom Code admin page. -->";
}
class CustomCodeAdmin extends AdminPage {
	function __construct() {
		parent::__construct(__('Custom Code','wicketpixie'),'customcode.php','wicketpixie-admin.php',null);
	}
	function page_output() {
		$this->customcode_admin();
	}
	function __destruct() {
		parent::__destruct();
	}
	/**
	 * The function in charge of file creation and deletion
	 **/
	function customcode_process() {
		// Check if the page has something to process
		if (isset($_POST['action'])) :
			// Define file location, then check what to do with it
			$custom_file = CUSTOMPATH.$_POST['file'].'.php';
			if ($_POST['action'] == 'add') :
				// Make sure the folder exists and is writable
				if(!file_exists(CUSTOMPATH)) mkdir(CUSTOMPATH,0777);
				// Write the submitted code to the file
				$uploaded = 'wicketpixie-custom-'.$_POST['file'];
				if(move_uploaded_file($_FILES[$uploaded]['tmp_name'], $custom_file)) : ?>
				<div id="message" class="updated fade"><p><strong><?php _e('Custom Code saved', 'wicketpixie'); ?></strong></p></div>
				<?php else :
				// We oopsed, let the user know
				?>
				<div id="message" class="error fade"><p><strong><?php _e('There has been an error with your upload', 'wicketpixie'); ?></strong></p></div>
				<?php endif;
			elseif ($_POST['action'] == 'clear') :
				// Check whether the file we are trying to delete is there
				if(file_exists($custom_file)) :
				unlink($custom_file); ?>
				<div id="message" class="updated fade"><p><strong><?php _e('Custom Code cleared', 'wicketpixie'); ?></strong></p></div>
				<?php else : ?>
				<div id="message" class="error fade"><p><strong><?php _e('The file does not exist', 'wicketpixie'); ?></strong></p></div>
				<?php endif;
			endif;
		endif;
	}
	/**
	 * The admin page where the user enters the custom header code.
	 **/
	function customcode_admin() {
		// Process requests if any
		$this->customcode_process(); ?>
		<div class="wrap">
			<div id="admin-options">
				<h2><?php _e('Custom Code','wicketpixie'); ?></h2>
				<p><?php _e('Here, you can upload PHP files containing any valid code (HTML, PHP, JavaScript) which will be included in the site template. Files can be edited later through the Wordpress Theme Editor. If you want to delete any file, use the "Clear" buttons.','wicketpixie'); ?></p>
				<?php global $custom_codes;
				foreach ($custom_codes as $custom_code): ?>
				<div style="clear: both">
					<h3><?php echo $custom_code['title']; ?></h3>
					<p><?php echo $custom_code['desc']; ?></p>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" enctype="multipart/form-data">
					<?php wp_nonce_field('wicketpixie-settings'); ?>
						<input type="file" name="wicketpixie-custom-<?php echo $custom_code['file'];  ?>" style="float: left" />
						<input type="submit" name="save" value="<?php _e('Save','wicketpixie'); ?>" class="button-primary" style="float: left" /> 
						<input type="hidden" name="action" value="add" />
						<input type="hidden" name="file" value="<?php echo $custom_code['file']; ?>" />
					</form>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" enctype="multipart/form-data">
					<?php wp_nonce_field('wicketpixie-settings'); ?>
						<input type="submit" name="clear" value="<?php _e('Clear','wicketpixie'); ?>" class="button-secondary" />
						<input type="hidden" name="action" value="clear" />
						<input type="hidden" name="file" value="<?php echo $custom_code['file']; ?>" />
					</form>
				</div>
			<?php endforeach; ?>
			</div>
		<?php include_once('advert.php');
	}
} ?>
