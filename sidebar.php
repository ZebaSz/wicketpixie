<!-- google_ad_section_start(weight=ignore) -->
<div id="sidebar">
	<!-- sidebar_top -->
	<div id="sidebar_top">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar_top') ) : ?><?php endif;?>
	</div>
	<!-- /sidebar_top -->
	<!-- sidebar1 -->
	<?php if ( is_active_sidebar(2) ) : ?>
	<div id="sidebar1">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar1') ) : ?><?php endif; ?>
	</div>
	<?php endif; ?>
	<!-- /sidebar1 -->
	<!-- sidebar2 -->
	<div id="sidebar2">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar2') ) : ?><?php endif; ?>
	</div>
	<!-- /sidebar2 -->
	<!-- sidebar3 -->
	<div id="sidebar3">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar3') ) : ?><?php endif; ?>
	</div>
	<!-- /sidebar3 -->
	<!-- sidebar4 -->
	<div id="sidebar4">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar4') ) : ?><?php endif; ?>
	</div>
	<!-- /sidebar4 -->
	<!-- sidebar5 -->
	<div id="sidebar5">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar5') ) : ?><?php endif; ?>
		<br />
		<?php if(is_enabled_adsense() == true) :
		$adsense = new AdsenseAdmin;
		$adsense->wp_adsense('blog_sidebar');
		endif;?>
	</div>
	<!-- /sidebar5 -->
	<!-- sidebar6 -->
	<div id="sidebar6">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar6') ) : ?><?php endif; ?>
	</div>
	<!-- /sidebar6 -->
</div>
<!-- google_ad_section_end -->
