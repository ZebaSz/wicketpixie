<?php
/**
 * WicketPixie v1.4
 * (c) 2006-2009 Eddie Ringle,
 *               Chris J. Davis,
 *               Dave Bates
 * Provided by Chris Pirillo
 *
 * (c) 2011 Sebastian Szperling
 *
 * Licensed under the New BSD License.
 */
/**
* The convention for filenames is:
* header.php - included inbetween <head></head> tags
* footer.php - included before the </body> tag
* Please do not use a different file name for these two areas.
**/
define("CUSTOMPATH",get_template_directory()."/app/custom");
/**
* This is called in the admin page and every template that allows custom code.
* It returns the custom code if any. If not, returns an HTML comment.
**/
function wp_customcode($file) {
	if(file_exists(CUSTOMPATH) && file_exists(CUSTOMPATH ."/$file.php")) include(CUSTOMPATH ."/$file.php");
	else echo "<!-- No custom code found, add code on the WicketPixie Custom Code admin page. -->";
}
class CustomCodeAdmin extends AdminPage {
	function __construct() {
		parent::__construct('Custom Code','customcode.php','wicketpixie-admin.php',null);
	}
	function page_output() {
		$this->customcode_admin();
	}
	function __destruct() {
		parent::__destruct();
	}
	/**
	* The admin page where the user enters the custom header code.
	*/
	function customcode_admin() {
		if ( $_GET['page'] == basename(__FILE__) ) :
			if (isset($_POST['action']) && $_POST['action'] == 'add') :
				if (isset($_POST['file'])) :
					// Check and make sure everything is created and writable
					clearstatcache();
					if(!file_exists(CUSTOMPATH)) mkdir(CUSTOMPATH,0777);
					if(!file_exists(CUSTOMPATH ."/".$_POST['file'].".php")) touch(CUSTOMPATH ."/".$_POST['file'].".php");
					// Write the submitted code to the file
					file_put_contents(CUSTOMPATH ."/".$_POST['file'].".php",stripslashes($_POST['code']));
				endif;
			elseif (isset($_POST['action']) && $_POST['action'] == 'clear') :
				if (isset($_POST['file'])) :
					unlink(CUSTOMPATH."/".$_POST['file'].".php");
				endif;
			endif;
		endif;
		if ( isset( $_REQUEST['add'] ) ) : ?>
		<div id="message" class="updated fade"><p><strong>Custom Code saved.</strong></p></div>
		<?php elseif(isset($_REQUEST['clear'])) : ?>
		<div id="message" class="updated fade"><p><strong>Custom Code cleared.</strong></p></div>
		<?php endif; ?>
			<div class="wrap">
				<div id="admin-options">
					<h2>Custom Code</h2>
					<p>Click any title to enter special code (HTML, PHP, JavaScript) which will be included in the site template. If you want to delete any code, use the "Clear" buttons.</p>
					<?php $custom_codes = array(
						array('title' => 'Global Announcement','file' => 'global_announcement', 'desc' => 'on the home page and all your posts as a global announcement'),
						array('title' => 'Custom Header','file' => 'header', 'desc' => 'between the &lt;head&gt; and &lt;/head&gt; tags of your site'),
						array('title' => 'Custom Footer','file' => 'footer', 'desc' => 'just before the &lt;/body&gt; tag of your site'),
						array('title' => 'After-Home-Post','file'  => 'afterhomepost', 'desc' => 'between the post content and post meta-data on your homepage'),
						array('title' => 'After-Posts','file' => 'afterposts', 'desc' => 'between the post content and post meta-data on individual posts'),
						array('title' => 'After-Home-Meta','file' => 'afterhomemeta', 'desc' => 'after the post meta data but before the Flickr Widget, Embedded Video, etc'),
						array('title' => 'Custom Home Sidebar code','file' => 'homesidebar', 'desc' => 'after the Tag Cloud section of the homepage sidebar'),
						array('title' => 'Custom 404 code','file' => '404', 'desc' => 'in a 404 page (this will replace the default message)'));
					foreach ($custom_codes as $custom_code): ?>
					<h3><a href="javascript:;" onmousedown="toggleDiv('edit_<?php echo $custom_code['file']; ?>');"><?php echo $custom_code['title']; ?></a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear <?php echo $custom_code['desc']; ?>.</p>
					<div id="edit_<?php echo $custom_code['file']; ?>" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit <?php echo $custom_code['title']; ?></h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode($custom_code['file'],true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save <?php echo $custom_code['title']; ?>" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="<?php echo $custom_code['file']; ?>" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear <?php echo $custom_code['title']; ?></h4>
							<p>WARNING: This will delete all custom code you have entered, if you want to continue, click 'Clear <?php echo $custom_code['title']; ?>'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear <?php echo $custom_code['title']; ?>" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="<?php echo $custom_code['file']; ?>" />
							</p>
						</form>
					</div>
				<?php endforeach; ?>
				</div>
			<?php include_once('advert.php'); ?>
			<script language="javascript">function toggleDiv(divid){if(document.getElementById(divid).style.display == 'none'){document.getElementById(divid).style.display = 'block';}else{document.getElementById(divid).style.display = 'none';}}</script>
	<?php }
} ?>
