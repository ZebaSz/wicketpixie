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
	for ($i = 1; $i <= 6; $i++): ?>
		<!-- sidebar$i -->
		<div id='sidebar<?php echo $i?>' class='widgets-container'>
		<?php dynamic_sidebar($i+1);
		if($i==5 && is_enabled_adsense()): ?>
			<br />
			<?php wp_adsense('blog_sidebar');
		endif; ?>
		</div>
		<!-- /sidebar<?php echo $i ?> -->
	<?php endfor; ?>
</div>
<?php else:
	include_once('sidebar-home.php');
endif; ?>
<!-- google_ad_section_end -->
