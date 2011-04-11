<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!');
// Password protection check
if (post_password_required()) return; ?>
<!-- You can start editing here. -->
<!-- comments -->
<div id="comments">
	<h2><?php comments_number();?></h2>
	<ul class="commentlist"><?php wp_list_comments('callback=wicketpixie_comment');?></ul>
	<?php if (get_option('page_comments') && get_comment_pages_count() > 1) : ?>
	<div class="clearer" ></div>
	<div class="cpage navigation">
		<div class="left"><?php previous_comments_link(sprintf("<span>%s</span>",__('More', 'wicketpixie'))); ?></div>
		<div class="right"><?php next_comments_link(sprintf("<span>%s</span>",__('Newer', 'wicketpixie'))); ?></div>
	</div>
	<?php endif; // If there are comment pages to navigate through ?>
	<?php if (!comments_open()) : ?>
	<h3 class="nocomments"><?php _e('Comments are closed', 'wicketpixie'); ?></h3>
	<?php endif; // If comments are closed ?>
</div>
<div class="clearer" ></div>
<!-- /comments -->
<div id="comment-form">
	<?php comment_form(); ?>
</div>
