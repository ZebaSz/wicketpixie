<?php get_header(); ?>
			<!-- content -->
			<div id="content">
				<!-- page -->
				<div class="page">
					<?php if (wp_customcode("404") === false): ?>
					<h1><?php _e("We Can't Find the Droid You're Looking For", 'wicketpixie') ?></h1>
					<p><?php printf(__("The page may have been removed or renamed. Be sure to check your spelling. If all else fails, you can %s, return to the %s, or try searching.", 'wicketpixie'), '<a href="javascript:history.back()">'.__('go back to the page you came from', 'wicketpixie').'</a>', '<a href="'.home_url().'/">'.__('homepage', 'wicketpixie').'</a>') ?></p>
					<?php endif; ?>
				</div>
				<!-- /page -->
			</div>
			<!-- content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
