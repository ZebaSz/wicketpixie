<?php
/**
 * WicketPixie_FeedWidget Class
 **/
class Wicketpixie_FeedWidget extends WP_Widget {
	function Wicketpixie_FeedWidget() {
		parent::__construct('wicketpixie_feedwidget','Wicketpixie FeedWidget',array('description' => __('Lists feed items from a given feed added in the Social Me Manager.','wicketpixie')));
	}
	function widget($args,$instance) {
		extract($args);
		extract($instance);
		$sources = new SourceAdmin;
		$source = $sources->gather($feed);
		$source = $source[0];
		if (empty($title))
			$title = $source->title;
		echo $before_widget;
		echo "$before_title<img src=\"{$source->favicon}\" alt=\"$title\" />$title $after_title";
		$items = $sources->get_feed($source->feed_url); ?>
		<ul>
		<?php $i = 0;
		foreach ($items as $item) :
			if ($i != $total) :
				echo "<li><a href=\"{$item['link']}\" title=\"{$item['title']}\">{$item['title']}</a></li>";
				$i++;
			endif;
		endforeach; ?>
		</ul>
		<?php echo $after_widget;
	}
	function update($new_instance,$old_instance) {
		$new_instance = (array)$new_instance;
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['feed'] = intval($new_instance['feed']);
		$instance['total'] = intval($new_instance['total']);
		return $instance;
	}
	function form($instance) {
		$sources = new SourceAdmin;
		if ($sources->check()) :
		$instance = wp_parse_args((array)$instance,array('title'=>'','feed' => 0, 'total' => 5));
		$title = htmlspecialchars($instance['title']); ?>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wicketpixie'); ?></label><br />
		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /><br />
		<label for="<?php echo $this->get_field_id('feed'); ?>"><?php _e('Feed:', 'wicketpixie'); ?></label><br />
		<select id="<?php echo $this->get_field_id('feed'); ?>" name="<?php echo $this->get_field_name('feed'); ?>">
			<option value="0" <?php if ($source->id == $instance['feed']) echo 'selected="selected"'; ?>>&nbsp;</option>
			<?php foreach ($sources->collect() as $source) : ?>
			<option value="<?php echo $source->id; ?>" <?php if ($source->id == $instance['feed']) echo 'selected="selected"'; ?>><?php echo $source->title; ?></option>
			<?php endforeach; ?>
		</select><br />
		<label for="<?php echo $this->get_field_id('total'); ?>"><?php _e('Items to display:', 'wicketpixie'); ?></label>
		<input id="<?php echo $this->get_field_id('total'); ?>" name="<?php echo $this->get_field_name('total'); ?>" type="text" value="<?php echo $instance['total']; ?>" />
		<?php else :
			echo '<p>'.__('You must add a Social Me feed before using this widget.', 'wicketpixie').'</p>';
		endif;
	}
}
function FeedWidgetInit() {
	register_widget('WicketPixie_FeedWidget');
}
