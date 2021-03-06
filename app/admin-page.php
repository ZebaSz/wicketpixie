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
require_once get_template_directory() .'/functions.php';
class AdminPage {
	function __construct($name,$filename,$parent = null,$arrays = array(),$help_content = array()) {
		global $optpre;
		$this->page_title = "WicketPixie $name";
		$this->page_name = $name;
		$this->page_description = '';
		$this->filename = $filename;
		$this->parent = $parent;
		$this->arrays = $arrays;
		$this->help_content = $help_content;
		$this->optpre = $optpre;
	}
	function __destruct() {
		/**
		 * This specific array has the potential to consume a bunch of memory,
		 * so we unset it when we are done.
		 **/
		unset($this->arrays);
	}
	function default_save_types($value) {
		if (isset($value['id']) && isset($_POST[$value['id']])) :
			update_option($value['id'],$_POST[$value['id']]);
		endif;
	}
	function after_form() {
	}
	function save_hook() {
	}
	function save() {
		foreach($this->arrays as $array) :
			if ((isset($array['name']) && $array['name'] == $_POST['group']) || (!isset($array['name']) && $_POST['group'] == '')) :
				foreach ($array as $value) :
					if (is_array($value)) :
						if ($value['type'] == 'checkbox') :
							if (isset($_POST[$value['id']])) :
								update_option($value['id'],'true');
							else :
								update_option($value['id'],'false');
							endif;
						else :
							$this->default_save_types($value);
						endif;
					endif;
				endforeach;
			endif;
		endforeach;
		$this->save_hook();
		wp_redirect($_SERVER['PHP_SELF'] .'?page='.$this->filename.'&saved=true');
	}
	function add_page_to_menu() {
		$this->request_check();
		if ($this->parent == null) :
			$this->pagehook = add_menu_page($this->page_title,$this->page_name,'edit_themes',$this->filename,array($this,'page_display'),get_template_directory_uri() .'/images/wicketsmall.png');
		else :
			$this->pagehook = add_submenu_page($this->parent,$this->page_title,$this->page_name,'edit_themes',$this->filename,array($this,'page_display'));
		endif;
		add_action("load-{$this->pagehook}", array($this,'add_help_tabs'));
	}
	function add_help_tabs() {
		if (empty($this->help_content)) return;
		$screen = get_current_screen();
		if ($screen->id == $this->pagehook) :
			foreach ($this->help_content as $help_tab)
				$screen->add_help_tab(array(
					'title' => $help_tab['title'],
					'id' => $help_tab['id'],
					'content' => $help_tab['content'])
				);
		endif;
	}
	function request_check() {
		if (isset($_GET['page']) && isset($_POST['action'])) :
			if ($_GET['page'] == $this->filename && $_POST['action'] == 'save') :
				check_admin_referer('wicketpixie-settings');
				$this->save();
			endif;
		endif;
	}
	function page_display() { ?>
		<div class="wrap wicketpixie">
			<div id="admin-options">
				<h2><?php echo $this->page_name; ?></h2>
				<?php echo $this->page_description; ?>
				<?php foreach ($this->arrays as $array) : ?>
				<?php if (!empty($array['name'])) echo '<h3>',$array['name'],'</h3>'; ?>
				<?php if (!empty($array['desc'])) echo $array['desc']; ?>
				<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $this->filename; ?>">
					<?php wp_nonce_field('wicketpixie-settings'); ?>
					<table class="form-table">
						<?php foreach($array as $value) :
						if (is_array($value)) :
						$value['std'] = (!empty($value['std'])) ? $value['std'] : ''; ?>
						<tr valign="top">
							<th scope="row" style="font-size:12px;text-align:left;padding-right:10px;">
								<acronym title="<?php echo $value['description']; ?>"><?php echo $value['name']; ?></acronym>
								</th>
							<td style="padding-right:10px;">
								<?php $optdata = (get_option($value['id'])) ? get_option($value['id']) : $value['std'];
								if ($value['type'] == 'select') : ?>
								<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
									<?php foreach ($value['options'] as $option) : ?>
									<option value="<?php echo $option; ?>" <?php if ($optdata == $option) echo 'selected="selected"'; ?>><?php echo $option; ?></option>
									<?php endforeach; ?>
								</select>
								<?php else : ?>
								<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo $optdata; ?>" <?php if (($value['type'] == 'checkbox' || $value['type'] == 'radio') && $optdata == 'true') echo 'checked="checked"'; ?>;/>
								<?php if ($value['type'] == 'checkbox') : ?>
								<label for="<?php echo $value['id']; ?>">&nbsp;</label>
								<?php endif;
								endif; ?>
							</td>
						</tr>
						<?php endif;
						endforeach; ?>
					</table>
					<p class="submit">
						<input type="submit" name="save" value="Save changes" />
						<input type="hidden" name="action" value="save" />
						<input type="hidden" name="group" value="<?php echo (isset($array['name'])) ? $array['name'] : ''; ?>" />
					</p>
				</form>
				<?php endforeach;
				$this->after_form(); ?>
			</div>
			<?php include_once('advert.php');
	}
} ?>
