<!-- comments -->
<div id="comments">
<?php 
// Password protection check
if (post_password_required()) : ?>
	<p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.','wicketpixie'); ?></p>
</div>
<!-- /comments -->
<?php return;
endif; ?>
<?php if (have_comments()) : ?>
	<h2><?php comments_number();?></h2>
	<ul class="commentlist"><?php wp_list_comments('callback=wicketpixie_comment');?></ul>
	<?php if (get_option('page_comments') && get_comment_pages_count() > 1) : ?>
	<div class="clearer" ></div>
	<div class="cpage navigation">
		<div class="left"><?php previous_comments_link(sprintf("<span>%s</span>",__('More', 'wicketpixie'))); ?></div>
		<div class="right"><?php next_comments_link(sprintf("<span>%s</span>",__('Newer', 'wicketpixie'))); ?></div>
	</div>
	<?php endif;
elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
	<h3 class="nocomments"><?php _e('Comments are closed', 'wicketpixie'); ?></h3>
<?php endif; // If comments are closed ?>
	<div class="clearer" ></div>
	<?php comment_form(); ?>
</div>
<div class="clearer" ></div>
<!-- /comments -->
