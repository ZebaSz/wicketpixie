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
<?php wp_footer();
wp_customcode("footer"); ?>
</body>
</html>
