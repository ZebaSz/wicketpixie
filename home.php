<?php if (!get_option('wicketpixie_theme_home_enable')) :	get_template_part('index');
else :
get_header();
$wp_auth_credit= get_option('wicketpixie_show_post_author'); ?>
			<!-- content -->
			<div id="content">
				<!-- google_ad_section_start -->
				<?php query_posts('showposts=1');
				if (have_posts()) :
				while (have_posts()) : the_post(); ?>
				<!-- post -->
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="border-bottom:0;">
					<div class="announce"><?php wp_customcode('global_announcement'); ?></div>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>" style="text-decoration:none;"><?php the_title(); ?></a></h1>
					<div class="post-comments">
						<div class="post-comments-count"><a href="<?php the_permalink(); ?>#comments" title="<?php printf(__('View all %d Comments', 'wicketpixie'), get_comments_number()); ?>"><?php comments_number('0', '1', '%'); ?></a></div>
						<div class="post-comments-add"><a href="<?php the_permalink(); ?>#respond" title="<?php _e('Add a Comment', 'wicketpixie'); ?>"></a></div>
					</div>
					<div class="post-author">
						<?php if( $wp_auth_credit == 'true' ) :
						echo get_avatar( get_the_author_meta('email'), $size = '36', $default = 'images/avatar.jpg' ); ?>
						<p><strong><?php the_date() ?></strong><br/>
							<?php printf(__('by %s', 'wicketpixie'), sprintf('<a href="%1$s" title="%2$s">%3$s</a>', get_author_posts_url($authordata->ID, $authordata->user_nicename), esc_attr(sprintf(__('Posts by %s','wicketpixie'), get_the_author())), get_the_author())); ?></p>
						<?php else : ?>
						<p><strong><?php the_date() ?></strong><br/>
							<?php printf(__('at %s', 'wicketpixie'), get_the_time()); ?></p>
						<?php endif; ?>
					</div>
					<div class="clearer"></div>
					<?php if (get_option('wicketpixie_home_enable_aside') == 'true') : ?>
					<!-- post-ad -->
						<div id="post-ad">
							<?php if(is_enabled_adsense() == true) $adsense->wp_adsense('blog_post_side'); ?>
							<div style="margin: 15px 0 0 5px">
								<?php if (is_plugin_active('wordpress-23-related-posts-plugin/wp_related_posts.php')) :
								wp_related_posts(5);
								endif; ?>
							</div>
						</div>
					<!-- /post-ad -->
					<?php endif; ?>
					<div class="KonaBody">
					<?php if(is_enabled_adsense() == true) : ?>
					<span style="float:left;display:block;clear:none;margin-right:10px;">
					<?php $adsense->wp_adsense('blog_home_post_front'); ?>
					</span>
					<?php endif;
					the_content(__('Continue reading %d', 'wicketpixie').'&raquo;'); ?>
					</div>
					<?php wp_customcode("afterhomepost"); ?>
				</div>
				<!-- /post -->
				<!-- google_ad_section_end -->
				<!-- post-meta -->
				<div class="post-meta">
					<?php if(is_plugin_active('wordpress-23-related-posts-plugin/wp_related_posts.php')) : ?>
					<!-- related-posts -->
					<div id="related-posts">
						<h3><?php _e('You might also be interested in...', 'wicketpixie'); ?></h3>
						 <?php wp_related_posts(5); ?>
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
						<!-- post-bigbox -->
						<div class="post-bigbox">
						<?php if(is_enabled_adsense() == true) :
							$adsense->wp_adsense('blog_post_bottom');
						else: ?>
							<!-- Enable Adsense on the WicketPixie Adsense admin page. -->
						<?php endif; ?>
						</div>
						<!-- /post-bigbox -->
					</div>
					<!-- /post-meta-right -->
					<div class="clearer"></div>
				</div>
				<!-- /post-meta -->
				<!-- Custom Code Area -->
				<?php wp_customcode("afterhomemeta"); ?>
				<!-- /Custom Code Area -->
				<?php endwhile;
				endif;
				if(get_option('wicketpixie_home_video_enable') == 'true') : ?>
				<!-- home-video -->
				<div id="home-categories">
					<?php if(get_option('wicketpixie_home_show_video_heading') == 'true') echo "<h2>".__('My Videos', 'wicketpixie')."</h2>";
					if(get_option('wicketpixie_home_video_code') != false && get_option('wicketpixie_home_video_code') != '') echo stripslashes(get_option('wicketpixie_home_video_code'));
					else echo '<!-- Add video object code in the WicketPixie Home Editor -->'; ?>
				</div>
				<!-- /home-video -->
				<?php endif;
				if(get_option('wicketpixie_home_flickr_enable') == 'true') : ?>
				<!-- home-photos -->
				<div id="home-photos">
					<?php if(get_option('wicketpixie_flickr_id') != false && get_option('wicketpixie_flickr_id') != 'false') $flickrid = get_option('wicketpixie_flickr_id');
					if(get_option('wicketpixie_home_flickr_number') != false) $num = get_option('wicketpixie_home_flickr_number');
					else $num = '5';
					if(get_option('wicketpixie_home_show_photo_heading') == 'true') :
						echo "<h2>".__('Recent Photos', 'wicketpixie')."</h2>";
					endif; ?>
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $num; ?>&amp;display=latest&amp;size=s&amp;layout=h&amp;source=user&amp;user=<?php echo $flickrid; ?>"></script>
				</div>
				<!-- /home-photos -->
				<div class="clearer"></div>
				<?php endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar('home'); ?>
			<!-- /sidebar -->
<?php get_footer();
endif; ?>
