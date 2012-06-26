<?php get_header();
$wp_auth_credit= get_option('wicketpixie_show_post_author'); ?>
			<!-- content -->
			<div id="content">
				<!-- google_ad_section_start -->
				<div class="announce"><?php wp_customcode('global_announcement'); ?></div>
				<?php if (have_posts()) :
				while (have_posts()) : the_post(); ?>
				<!-- post -->
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>" style="text-decoration:none;"><?php the_title(); ?></a></h1>
					<div class="post-comments">
						<div class="post-comments-count"><a href="<?php the_permalink(); ?>#comments" title="<?php printf(__('View all %d Comments', 'wicketpixie'), get_comments_number()); ?>"><?php comments_number('0', '1', '%'); ?></a></div>
						<div class="post-comments-add"><a href="<?php the_permalink(); ?>#respond" title="<?php _e('Add a Comment', 'wicketpixie'); ?>"></a></div>
					</div>
					<div class="post-author">
						<?php if( $wp_auth_credit == 'true' ) :
						echo get_avatar( get_the_author_meta('email'), $size = '36', $default = 'images/avatar.jpg' ); ?>
						<p><strong><?php the_time(get_option('date_format')); ?></strong><br/>
							<?php printf(__('by %s', 'wicketpixie'), sprintf('<a href="%1$s" title="%2$s">%3$s</a>', get_author_posts_url($authordata->ID, $authordata->user_nicename), esc_attr(sprintf(__('Posts by %s','wicketpixie'), get_the_author())), get_the_author())); edit_post_link(__('Edit', 'wicketpixie'), ' - ', ''); ?></p>
						<?php else : ?>
						<p><strong><?php the_time(get_option('date_format')); ?></strong><br/>
							<?php printf(__('at %s', 'wicketpixie'), get_the_time()); edit_post_link(__('Edit', 'wicketpixie'), ' - ', ''); ?></p>
						<?php endif; ?>
					</div>
					<div class="clearer"></div>
					<div class="KonaBody">
					<?php the_content(__('Continue reading', 'wicketpixie').'&raquo;'); ?>
					</div>
					<?php wp_customcode("afterposts"); ?>
				</div>
				<!-- /post -->
				<!-- google_ad_section_end -->
				<?php endwhile; ?>
				<!-- Page Navigation -->
				<?php if (is_plugin_active('wp-pagenavi/wp-pagenavi.php')) : ?>
				<div id="paginator" style='text-align: center'><?php wp_pagenavi(); ?></div>
				<?php else : ?>
				<div class="navigation">
					<div class="left"><?php next_posts_link(sprintf('<span>%s</span>', __('More', 'wicketpixie'))) ?></div>
					<div class="right"><?php previous_posts_link(sprintf('<span>%s</span>', __('Newer', 'wicketpixie'))) ?></div>
				</div>
				<?php endif; // Page Navigation
				endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
