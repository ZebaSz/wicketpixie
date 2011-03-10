<?php get_header(); ?>
			<!-- content -->
			<div id="content">
				<!-- page -->
				<div class="page">
					<?php if (get_option($optpre.'plug_aagoog404') == 'true' && function_exists("aa_google_404")) :
					aa_google_404();
					else : ?>
					<h1>We Can't Find the Droid You're Looking For</h1>
					<p>The page may have been removed or renamed. Be sure to check your spelling.  If all else fails, you can <a href="javascript:history.back()">go back to the page you came from</a>, return to the <a href="<?php echo get_option('home'); ?>/">homepage</a>, or try searching.</p>
					<?php endif;?>
				</div>
				<!-- /page -->
			</div>
			<!-- content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
