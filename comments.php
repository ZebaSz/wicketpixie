<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if (!empty($post->post_password)) : // if there's a password
	if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : // and it doesn't match the cookie ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.<p>
		<?php return;
	endif;
endif;
/* This variable is for alternating comment background */
$oddcomment = 'alt'; ?>
<!-- You can start editing here. -->
<!-- comments -->
<div id="comments">
<?php if (function_exists('wp_list_comments')) : ?>
	<h2><?php comments_number();?></h2>
	<ul class="commentlist"><?php wp_list_comments();?></ul>
<?php else :
if ($comments) : ?>
	<h2><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h2>
	<?php foreach ($comments as $comment) : ?>
	<!-- comment -->
	<div class="comment" id="comment-<?php comment_ID() ?>">
		<!-- comment meta -->
		<div class="meta">
			<h3 style="padding:5px 0 0 0;" title="Visit this author's website"><?php comment_author_link() ?></h3>
			<h5><a href="#comment-<?php comment_ID() ?>" title="Permanent Link to this comment"><strong><?php comment_time('F jS, Y') ?></strong><br/> at <?php comment_time('g:ia') ?></a></h5>
		</div>
		<!-- /comment meta -->
		<!-- comment content -->
		<div class="content">
			<?php echo get_avatar( get_comment_author_email(), $size = '36', $default = 'images/avatar.jpg' );
			if ($comment->comment_approved == '0') : ?>
			<p><em>Your comment is awaiting moderation.</em></p>
			<?php endif;
			comment_text() ?>
		</div>
		<!-- /comment content -->
	</div>
	<!-- /comment -->
	<?php endforeach; // end for each comment ?>
<?php else : // this is displayed if there are no comments so far
	if ('open' != $post->comment_status) : //comments are closed ?>
		<p class="nocomments">Comments are closed.</p>
	<?php endif; // If comments are closed
endif; // If there are no comments
endif; // check for wp_list_comments ?>
</div>
<!-- /comments -->
<?php if (function_exists('comment_form')) : ?>
	<div id="comment-form">
		<?php comment_form(); ?>
	</div>
<?php else:
if ('open' == $post->comment_status) : ?>
	<!-- comment form -->
	<div id="respond">
		<div id="comment-form">
			<h2><?php comment_form_title(); ?> <small><?php cancel_comment_reply_link(__('Cancel reply', 'wicketpixie')) ?></small></h2>
			<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
			<?php else : ?>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
				<div>
					<?php if ( $user_ID ) : ?>
					<p class="yourname" style="width:100%;">
						Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a>
					</p>
					<?php else : ?>
					<p class="yourname">
						<label for="author">Your Name: <?php if ($req) echo "*"; ?></label>
						<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="30" tabindex="1" class="inputfield" />
					</p>
					<p class="email">
						<label for="email">Email Address: <?php if ($req) echo "*"; ?></label>
						<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="30" tabindex="2" class="inputfield" />
					</p>
					<p class="website">
						<label for="url">Website:</label>
						<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="30" tabindex="3" class="inputfield" />
					</p>
					<?php endif; ?>
					<p>
						<label for="comment">Comment:</label>
						<textarea name="comment" id="comment-message" rows="10" cols="40" class="message" tabindex="4"></textarea>
					</p>
					<p>
						<input name="submit" type="submit" id="submit" value="<?php _e('Publish comment', 'wicketpixie') ?>" />
						<?php comment_id_fields(); ?>	
					</p>
				</div>
				<div class="clearer"></div>
				<?php do_action('comment_form', $post->ID); ?>
			</form>
		</div>
	</div>
	<!-- /comment form -->
	<?php endif; // If registration required and not logged in
endif; // If comments are open
endif; // check for comment_form ?>
