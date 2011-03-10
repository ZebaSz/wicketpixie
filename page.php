<?php get_header(); ?>
			<!-- content -->
			<div id="content">
				<?php if (have_posts()) :
				while (have_posts()) : the_post();
				$postid =  $post->ID; ?>
				<!-- page -->
				<div class="page">
					<h1><?php the_title(); ?></h1>
					<?php the_content('Continue reading &raquo;'); ?>
				</div>
				<!-- /page -->
				<?php endwhile;
				endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
