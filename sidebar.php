<!-- google_ad_section_start(weight=ignore) -->
<?php if (function_exists('dynamic_sidebar')): ?>
<div id="sidebar">
	<?php if (is_active_sidebar('sidebar_top')): ?>
	<!-- sidebar_top -->
	<div id="sidebar_top">
		<?php dynamic_sidebar('sidebar_top');?>
	</div>
	<!-- /sidebar_top -->
	<?php endif;
	for ($i = 1; $i <= 6; $i++):
		echo "<!-- sidebar$i --><div id='sidebar$i' class='widgets-container'>";
		dynamic_sidebar($i+1);
		echo "</div><!-- /sidebar$i -->";
	endfor; ?>
</div>
<?php else:
	include_once('sidebar-home.php');
endif; ?>
<!-- google_ad_section_end -->
