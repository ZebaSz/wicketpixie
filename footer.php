		</div>
		<!-- /mid -->
		<!-- footer -->
		<div id="footer">
			<p id="footer-credits" class="left">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>, <?php _e('All Rights Reserved', 'wicketpixie') ?></p>
			<p id="footer-meta" class="right"><a href="http://github.com/ZebaSz/wicketpixie/issues"><?php _e('Bugs or Suggestions?', 'wicketpixie') ?></a> - <?php _e('Powered by', 'wicketpixie') ?> <a href="http://github.com/ZebaSz/wicketpixie/">WicketPixie v<?php echo WIK_VERSION; ?></a></p>
			<div class="clearer"></div>
		</div>
		<!-- footer -->
	</div>
	<!-- wrapper -->
	<!-- jQuery -->
	<script type="text/javascript" src="<?php bloginfo('home'); ?>/wp-includes/js/jquery/jquery.js?ver=1.3.2"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/wp-global.js"></script>
<?php wp_footer(); ?>
<?php echo "\n"; ?>
<?php wp_customcode("footer"); ?>
<?php echo "\n"; ?>
</body>
</html>
