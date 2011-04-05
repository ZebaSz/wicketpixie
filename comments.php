<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!');
// Password protection check
if (post_password_required()) return; ?>
<!-- You can start editing here. -->
<!-- comments -->
<div id="comments">
	<h2><?php comments_number();?></h2>
	<ul class="commentlist"><?php wp_list_comments();?></ul>
	<?php if ('open' != $post->comment_status) : //comments are closed ?>
	<h3 class="nocomments"><?php _e('Comments are closed', 'wicketpixie'); ?></h3>
	<?php endif; // If comments are closed ?>
</div>
<!-- /comments -->
<div id="comment-form">
	<?php comment_form(); ?>
</div>
