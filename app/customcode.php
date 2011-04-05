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
define("CUSTOMPATH",TEMPLATEPATH ."/app/custom");
/**
* This is called in the admin page and every template that allows custom code.
* It returns the custom code if any. If not, returns an HTML comment.
**/
function wp_customcode($file,$raw = false) {
	if(file_exists(CUSTOMPATH) && file_exists(CUSTOMPATH ."/$file.php")) :
		if(!$raw) :
			include(CUSTOMPATH ."/$file.php");
		else :
			return file_get_contents(CUSTOMPATH ."/$file.php");
		endif;
	else :
		echo "<!-- No custom code found, add code on the WicketPixie Custom Code admin page. -->";
		return false;
	endif;
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
					<h3><a href="javascript:;" onmousedown="toggleDiv('edit_global_announcement');">Global Announcement</a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear on the home page and all your posts as a global announcement.</p>
					<div id="edit_global_announcement" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit Global Announcement file</h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode("global_announcement",true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save Global Announcement" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="global_announcement" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear Global Announcement</h4>
							<p>WARNING: This will delete all custom code you have entered for your header, if you want to continue, click 'Clear Global Announcement'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear Global Announcement" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="global_announcement" />
							</p>
						</form>
					</div>
					<h3><a href="javascript:;" onmousedown="toggleDiv('edit_custom_header');">Custom Header</a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear the &lt;head&gt; and &lt;/head&gt; tags of your site.</p>
					<div id="edit_custom_header" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit Custom Header file</h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode("header",true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save Custom Header" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="header" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear custom header</h4>
							<p>WARNING: This will delete all custom code you have entered for your header, if you want to continue, click 'Clear Custom Header'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear Custom Header" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="header" />
							</p>
						</form>
					</div>
					<h3><a href="javascript:;" onmousedown="toggleDiv('edit_custom_footer');">Custom Footer</a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear just before the &lt;/body&gt; tag of your site.</p>
					<div id="edit_custom_footer" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit Custom Footer file</h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode("footer",true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save Custom Footer" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="footer" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear custom footer</h4>
							<p>WARNING: This will delete all custom code you have entered for your footer, if you want to continue, click 'Clear Custom Footer'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear Custom Footer" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="footer" />
							</p>
						</form>
					</div>
					<h3><a href="javascript:;" onmousedown="toggleDiv('edit_after_home');">After-Home-Post</a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear between the post content and post meta-data on your homepage.</p>
					<div id="edit_after_home" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit After-Home-Post code</h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode("afterhomepost",true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save After-Home-Post code" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="afterhomepost" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear After-Home-Post code</h4>
							<p>WARNING: This will delete all custom code you have entered to appear after posts on the homepage, if you want to continue, click 'Clear After-Home-Post code'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear After-Home-Post code" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="afterhomepost" />
							</p>
						</form>
					</div>
					<h3><a href="javascript:;" onmousedown="toggleDiv('edit_after_posts');">After-Posts</a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear between the post content and post meta-data on individual posts.</p>
					<div id="edit_after_posts" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit After-Posts code</h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode("afterposts",true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save After-Posts code" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="afterposts" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear After-Posts code</h4>
							<p>WARNING: This will delete all custom code you have entered to appear after individual posts, if you want to continue, click 'Clear After-Posts code'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear After-Posts code" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="afterposts" />
							</p>
						</form>
					</div>
					<h3><a href="javascript:;" onmousedown="toggleDiv('edit_after_home_meta');">After-Home-Meta</a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear after the post meta data but before the Flickr Widget, Embedded Video, etc.</p>
					<div id="edit_after_home_meta" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit After-Home-Meta code</h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode("afterhomemeta",true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save After-Home-Meta code" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="afterhomemeta" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear After-Home-Meta code</h4>
							<p>WARNING: This will delete all custom code you have entered to appear after the post meta data on the homepage, if you want to continue, click 'Clear After-Home-Meta code'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear After-Home-Meta code" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="afterhomemeta" />
							</p>
						</form>
					</div>
					<h3><a href="javascript:;" onmousedown="toggleDiv('custom_home_sidebar');">Custom Sidebar Code</a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear after the Tag Cloud section of the homepage sidebar.</p>
					<div id="custom_home_sidebar" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit Custom Home Sidebar code</h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode("homesidebar",true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save Custom Home Sidebar code" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="homesidebar" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear Custom Home Sidebar code</h4>
							<p>WARNING: This will delete all custom code you have entered to appear after the Tag Cloud section of the homepage sidebar, if you want to continue, click 'Clear Custom Home Sidebar code'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear Custom Home Sidebar code" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="homesidebar" />
							</p>
						</form>
					</div>
					<h3><a href="javascript:;" onmousedown="toggleDiv('edit_custom_404');">Custom 404 page</a></h3>
					<p>Enter HTML markup, PHP code, or JavaScript that you would like to appear in a 404 page (this will replace the default message).</p>
					<div id="edit_custom_404" style="display: none;">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;add=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Edit 404 code</h4>
							<p><textarea name="code" id="code" style="border: 1px solid #999999;" cols="80" rows="25" /><?php echo wp_customcode("404",true); ?></textarea></p>
							<p class="submit">
								<input name="save" type="submit" value="Save 404 code" /> 
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="file" value="404" />
							</p>
						</form>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=customcode.php&amp;clear=true" class="form-table">
						<?php wp_nonce_field('wicketpixie-settings'); ?>
							<h4>Clear 404 code</h4>
							<p>WARNING: This will delete all custom code you have entered to appear in 404 pages, if you want to continue, click 'Clear 404 code'</p>
							<p class="submit">
								<input name="clear" type="submit" value="Clear 404 code" />
								<input type="hidden" name="action" value="clear" />
								<input type="hidden" name="file" value="404" />
							</p>
						</form>
					</div>
				</div>
			<?php include_once('advert.php'); ?>
			<script language="javascript">function toggleDiv(divid){if(document.getElementById(divid).style.display == 'none'){document.getElementById(divid).style.display = 'block';}else{document.getElementById(divid).style.display = 'none';}}</script>
	<?php }
} ?>
