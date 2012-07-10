<?php get_header(); ?>
			<!-- content -->
			<div id="content">
				<?php if (have_posts()) :
					$hit_count = $wp_query->found_posts; ?>
					<p style="margin:0 20px 1.8em;"><?php printf(__('Your search for %s returned %d results.', 'wicketpixie'), '"<span class="hilite">'.get_search_query().'</span>"', $hit_count); ?></p>
				<?php $adsense_counter = 0;
				while (have_posts()) : the_post(); ?>
				<!-- post -->
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2 style="margin-bottom:0;"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permalink to %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
					<div class="post-author">
						<p><strong><?php the_time(get_option('date_format')); ?></strong> <?php printf(__('at %s', 'wicketpixie'), get_the_time()); ?></p>
					</div>
					<div class="clearer"></div>
					<div class="KonaBody">
					<?php the_excerpt(); ?>
					</div>
				</div>
				<!-- /post -->
				<?php if ($adsense_counter == 0 && is_enabled_adsense()) : ?>
				<div style="text-align: center; margin: 15px 0 30px 0">
					<?php wp_adsense('blog_post_bottom'); ?>
				</div>
				<?php else :
						$adsense_counter++;
				endif;
				endwhile; ?>
				<div class="navigation">
					<div class="left"><?php next_posts_link(sprintf('<span>%s</span>', __('More', 'wicketpixie'))) ?></div>
					<div class="right"><?php previous_posts_link(sprintf('<span>%s</span>', __('Newer', 'wicketpixie'))) ?></div>
				</div>
				<?php else : ?>
				<!-- post -->
				<div class="post">
					<h1><?php _e('Search Results', 'wicketpixie') ?></h1>
					<?php $hit_count = $wp_query->found_posts; ?>
					<p><?php printf(__('Your search for %s returned no results.', 'wicketpixie'), '"<span class="hilite">'.get_search_query().'</span>"') ?></p>
				</div>
				<!-- /post -->
				<?php endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
