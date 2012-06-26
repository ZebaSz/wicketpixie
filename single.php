<?php get_header();
$wp_auth_credit= get_option('wicketpixie_show_post_author'); ?>
			<!-- content -->
			<div id="content">
				<!-- google_ad_section_start -->
				<?php if (have_posts()) :
				while (have_posts()) : the_post();
				$postid =  $post->ID; ?>
				<!-- post -->
				<div class="post" style="border-bottom:0;">
					<div class="announce"><?php wp_customcode('global_announcement'); ?></div>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>" style="text-decoration:none;"><?php the_title(); ?></a></h1>
					<div class="post-comments">
						<div class="post-comments-count"><a href="<?php the_permalink(); ?>#comments" title="<?php printf(__('View all %d Comments', 'wicketpixie'), get_comments_number()); ?>"><?php comments_number('0', '1', '%'); ?></a></div>
						<div class="post-comments-add"><a href="<?php the_permalink(); ?>#respond" title="<?php _e('Add a Comment', 'wicketpixie'); ?>"></a></div>
					</div>
					<div class="post-author">
						<?php if( $wp_auth_credit == 'true' ) :
						echo get_avatar( get_the_author_meta('email'), $size = '36', $default = 'images/avatar.jpg' ); ?>
						<p><strong><?php the_date() ?></strong><br/>
							<?php printf(__('by %s', 'wicketpixie'), sprintf('<a href="%1$s" title="%2$s">%3$s</a>', get_author_posts_url($authordata->ID, $authordata->user_nicename), esc_attr(sprintf(__('Posts by %s', 'wicketpixie'), get_the_author())), get_the_author())); edit_post_link(__('Edit', 'wicketpixie'), ' - ', ''); ?></p>
						<?php else : ?>
						<p><strong><?php the_date() ?></strong><br/>
							<?php printf(__('at %s', 'wicketpixie'), get_the_time()); edit_post_link(__('Edit', 'wicketpixie'), ' - ', ''); ?></p>
						<?php endif; ?>
					</div>
					<div class="clearer"></div>
						<?php if (get_option('wicketpixie_post_enable_aside') == 'true') : ?>
						<!-- post-ad -->
						<div id="post-ad">
							<?php if(is_enabled_adsense() == true) $adsense->wp_adsense('blog_post_side'); ?>
							<div style="margin: 15px 0 0 5px">
								<?php if(get_option('wicketpixie_tweetmeme_enable') == 'true') : ?>
								<p style="margin: 0px auto;width: inherit;">
									<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
								</p>
								<?php endif;
								if (is_plugin_active('wordpress-23-related-posts-plugin/wp_related_posts.php')) wp_related_posts(5); ?>
							</div>
						</div>
						<!-- /post-ad -->
						<?php endif; ?>
					<div class="KonaBody">
					<?php if(is_enabled_adsense() == true) : ?>
					<span style="float:left;display:block;clear:none;margin-right:10px;">
					<?php $adsense->wp_adsense('blog_post_front'); ?>
					</span>
					<?php endif;
					the_content(); ?>
					<?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __( 'Pages:', 'wicketpixie' ) . '</span>', 'after' => '</div>' ) ); ?>
					</div>
					<?php wp_customcode("afterposts"); ?>
				</div>
				<!-- /post -->
				<!-- google_ad_section_end -->
				<!-- post-meta -->
				<div class="post-meta">
					<?php if(is_plugin_active('wordpress-23-related-posts-plugin/wp_related_posts.php')) : ?>
					<!-- related-posts -->
					<div id="related-posts">
						<h3><?php _e('You might also be interested in...', 'wicketpixie'); ?></h3>
							<?php wp_related_posts(); ?>
					</div>
					<!-- /related-posts -->
					<?php endif; ?>
					<!-- post-meta-right -->
					<div class="post-meta-right">
						<!-- post-meta-tags -->
						<div class="post-meta-tags">
							<h6><?php _e('Tags', 'wicketpixie'); ?></h6>
							<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
						</div>
						<!-- /post-meta-tags -->
						<!-- post-meta-categories -->
						<div class="post-meta-categories">
							<h6><?php _e('Categories', 'wicketpixie'); ?></h6>
							<?php the_category(); ?>
						</div>
						<!-- /post-meta-categories -->
					</div>
					<!-- /post-meta-right -->
					<div class="clearer"></div>
				</div>
				<!-- /post-meta -->
				<?php endwhile;
				comments_template();
				endif; ?>
			</div>
			<!-- content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- sidebar -->
<?php get_footer(); ?>
