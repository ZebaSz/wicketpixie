<?php get_header();
$wp_auth_credit= get_option('wicketpixie_show_post_author'); ?>
			<!-- content -->
			<div id="content">
				<!-- google_ad_section_start -->
				<?php if (have_posts()) :
				while (have_posts()) : the_post(); ?>
				<!-- post -->
				<div class="post" style="border-bottom:0;">
					<?php require_once(TEMPLATEPATH .'/app/customcode.php');
					$glob = fetchcustomcode('global_announcement.php',true);
					if($glob != "" && $glob != fetchcustomcode('idontexist.no')): ?>
					<div class="highlight">
					<?php echo $glob; ?>
					</div>
					<?php endif; ?>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %d', 'wicketpixie'), the_title_attribute('echo = 0')); ?>" style="text-decoration:none;"><?php the_title(); ?></a></h1>
					<div class="post-comments">
						<ul>
							<li class="post-comments-count"><a href="<?php the_permalink(); ?>#comments" title="<?php printf(__('View all %d Comments', 'wicketpixie'), get_comments_number()); ?>"><?php comments_number('0', '1', '%'); ?></a></li>
							<li class="post-comments-add"><a href="<?php the_permalink(); ?>#respond" title="<?php _e('Add a Comment', 'wicketpixie'); ?>"><span>+</span></a></li>
						</ul>
					</div>
					<div class="post-author">
						<?php if( $wp_auth_credit == 'true' ) :
						echo get_avatar( get_the_author_email(), $size = '36', $default = 'images/avatar.jpg' ); ?>
						<p><strong><?php the_time(get_option('date_format')); ?></strong><br/>
							<?php _e('by', 'wicketpixie'); ?> <?php the_author_posts_link(); edit_post_link(__('Edit', 'wicketpixie'), ' - ', ''); ?></p>
						<?php else : ?>
						<p><strong><?php the_time(get_option('date_format')); ?></strong><br/>
							<?php _e('at', 'wicketpixie'); ?> <?php the_time(); edit_post_link(__('Edit', 'wicketpixie'), ' - ', ''); ?></p>
						<?php endif; ?>
					</div>
					<div class="clearer"></div>
					<div class="KonaBody">
					<?php the_content(printf(__('Continue reading %d', 'wicketpixie'), '&raquo;')); ?>
					</div>
					<?php wp_after_posts_code(); ?>
				</div>
				<!-- /post -->
				<!-- google_ad_section_end -->
				<?php endwhile; ?>
				<!-- Page Navigation -->
				<?php if (get_option('wicketpixie_plugin_pagenavi') == 'true') : ?>
				<div id="paginator" style='text-align: center'><?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?></div>
				<?php else : ?>
				<div class="navigation">
					<div class="left"><?php next_posts_link('<span>'.__('More', 'wicketpixie').'</span>'); ?></div>
					<div class="right"><?php previous_posts_link('<span>'.__('Newer', 'wicketpixie').'</span>') ?></div>
				</div>
				<?php endif; // Page Navigation
				endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
