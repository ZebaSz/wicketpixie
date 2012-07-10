<?php get_header(); ?>
			<!-- content -->
			<div id="content">
				<?php if (have_posts()) :
				while (have_posts()) : the_post();
				$postid = $post->ID; ?>
				<!-- page -->
				<div class="page">
					<h1><?php the_title(); ?><small><?php edit_post_link(__('Edit', 'wicketpixie'), ' - ', ''); ?></small></h1>
					<?php the_content(sprintf(esc_attr__('Continue reading %s', 'wicketpixie'), '&raquo;'));
					wp_link_pages(array('before' => '<div class="page-link"><span>' . __( 'Pages:', 'wicketpixie' ) . '</span>', 'after' => '</div>' ) ); ?>
				</div>
				<!-- /page -->
				<?php endwhile;
				comments_template();
				endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
