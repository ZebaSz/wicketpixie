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
 * The convention for filenames is:
 * header.php - included inbetween <head></head> tags
 * footer.php - included before the </body> tag
 * Please do not use a different file name for these two areas.
 **/
define('CUSTOMPATH',get_template_directory().'/custom/');
/**
 * Custom code functions array
 **/
$custom_codes = array(
	array(
		'title' => __('Global Announcement','wicketpixie'),
		'file' => 'global_announcement'),
	array(
		'title' => __('Custom Header','wicketpixie'),
		'file' => 'header'),
	array(
		'title' => __('Custom Footer','wicketpixie'),
		'file' => 'footer'),
	array(
		'title' => __('After-Home-Post','wicketpixie'),
		'file'  => 'afterhomepost'),
	array(
		'title' => __('After-Posts','wicketpixie'),
		'file' => 'afterposts'),
	array(
		'title' => __('After-Home-Meta','wicketpixie'),
		'file' => 'afterhomemeta'),
	array(
		'title' => __('After-Home-Sidebar','wicketpixie'),
		'file' => 'homesidebar'),
	array(
		'title' => __('Custom 404','wicketpixie'),
		'file' => '404')
);
/**
 * This is called in the admin page and every template that allows custom code.
 * It returns the custom code if any. If not, returns an HTML comment.
 **/
function wp_customcode($file) {
	if (file_exists(CUSTOMPATH ."$file.php")): 
		include(CUSTOMPATH ."$file.php");
	else :
		echo "<!-- No custom code found, add code on the WicketPixie Custom Code admin page. -->";
	endif;
}
/**
 * Help tab
 **/
$help_content = array(
	array(
		'title' => 'Custom Code',
		'id' => 'wicketpixie-customcode-help',
		'content' => '<p>'.__('Here, you can upload PHP files containing any valid code (HTML, PHP, JavaScript) which will be included in the site template. Just select the hook for the custom file, and upload it! Files can be edited later through the <a href="theme-editor.php">Wordpress Theme Editor</a>. If you want to delete any file, select the corresponding hook and press the "Clear" button.','wicketpixie').'</p><p>'.__('Hook locations are as follows:','wicketpixie').'</p><ul><li>'.__('Global Announcement: before any of your posts, including in home pages. All text or HTML is enclosed in a yellow box.','wicketpixie').'</li><li>'.__('Custom Header: between the &lt;head&gt; and &lt;/head&gt; tags of your site.','wicketpixie').'</li><li>'.__('Custom Footer: just before the &lt;/body&gt; tag of your site.','wicketpixie').'</li><li>'.__('After-Home-Post: between the post content and post meta-data on your homepage.','wicketpixie').'</li><li>'.__('After-Posts: between the post content and post meta-data on individual posts.','wicketpixie').'</li><li>'.__('After-Home-Meta: after the post meta data but before the Flickr Widget, Embedded Video, etc.','wicketpixie').'</li><li>'.__('After-Home-Sidebar: after the Tag Cloud section of the homepage sidebar.','wicketpixie').'</li><li>'.__('Custom 404: replaces the default 404 message.','wicketpixie').'</li></ul>'
	)
);
class CustomCodeAdmin extends AdminPage {
	function __construct() {
		parent::__construct(__('Custom Code','wicketpixie'),'customcode.php','wicketpixie-admin.php',array(),$GLOBALS['help_content']);
	}
	function __destruct() {
		parent::__destruct();
	}
	/**
	 * The function in charge of file creation and deletion
	 **/
	function customcode_process() {
		// Check if the page has something to process
		if (isset($_POST['file'])) :
			// Define file location, then check what to do with it
			$custom_file = CUSTOMPATH.$_POST['file'].'.php';
			if (!empty($_POST['save'])) :
				// Make sure the folder exists and is writable
				if (!file_exists(CUSTOMPATH)) mkdir(CUSTOMPATH,0777);
				// Write the submitted code to the file
				if (move_uploaded_file($_FILES['wicketpixie-custom-file']['tmp_name'], $custom_file)) : ?>
				<div id="message" class="updated fade"><p><strong><?php _e('Custom Code saved', 'wicketpixie'); ?></strong></p></div>
				<?php else :
				// We oopsed, let the user know
				?>
				<div id="message" class="error fade"><p><strong><?php _e('There has been an error with your upload', 'wicketpixie'); ?></strong></p></div>
				<?php endif;
			elseif (!empty($_POST['clear'])) :
				// Check whether the file we are trying to delete is there
				if (file_exists($custom_file)) :
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
	function page_display() {
		// Process requests if any
		$this->customcode_process(); ?>
		<div class="wrap">
			<div id="admin-options">
				<h2><?php _e('Custom Code','wicketpixie'); ?></h2>
				<div style="clear: both">
					<p>This admin page will soon merge with other admin pages. In the meantime, the upload box is still provided.</p>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;custom=true" enctype="multipart/form-data">
					<?php wp_nonce_field('wicketpixie-settings'); ?>
						<select name="file" style="float: left">
							<?php global $custom_codes;
							foreach ($custom_codes as $custom_code): ?>
							<option value="<?php echo $custom_code['file']; ?>"><?php echo $custom_code['title']; ?></option>
							<?php endforeach; ?>
						</select>
						<input type="file" name="wicketpixie-custom-file" style="float: left" />
						<input type="submit" name="save" value="<?php _e('Save','wicketpixie'); ?>" class="button-primary" style="float: left" />
						<input type="submit" name="clear" value="<?php _e('Clear','wicketpixie'); ?>" class="button-secondary" />
					</form>
				</div>
			</div>
		<?php include_once('advert.php');
	}
} ?>
