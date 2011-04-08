<div id="sidebar">
	<?php if(get_option('wicketpixie_home_social_buttons_enable') == 'true') : ?>
		<!-- social-buttons -->
		<?php require_once(TEMPLATEPATH .'/widgets/social-badges.php');
		SocialBadgesWidget::widget(array(),''); ?>
		<!-- /social-buttons -->
	<?php endif; ?>
	<!-- ustream -->
	<?php if (get_option('wicketpixie_home_ustream_enable') == 'true') : ?>
	<div id="home-youtube">
		<?php require_once(TEMPLATEPATH.'/widgets/ustream-widget.php');
		UstreamWidget::widget(array('before_title'=>'<h3>','after_title'=>'</h3>'),array('title'=>get_option('wicketpixie_home_ustream_heading'),'channel'=>get_option('wicketpixie_ustream_channel'),'autoplay'=>get_option($optpre.'home_ustream_autoplay')), get_option('wicketpixie_home_ustream_height'), get_option('wicketpixie_home_ustream_width')); ?>
	</div>
	<?php endif; ?>
	<!-- /ustream -->
	<!-- recent-posts -->
	<div id="sidebar1">
		<div class="widget">
			<h3><?php _e('What else is new?', 'wicketpixie') ?></h3>
			<?php query_posts('showposts=5&offset=1');
			while (have_posts()) : the_post(); ?>
			<!-- post -->
				<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Continue reading %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h5>
				<p style="font-size:0.8em;color:#666;"><?php the_time(get_option('date_format')) ?> | <?php comments_popup_link(); ?></p>
			<!-- /post -->
			<?php endwhile; ?>
		</div>
		<?php the_widget('WP_Widget_Recent_Comments', 'number=5', 'before_title=<h3>&after_title=</h3>'); ?>
		<div class="widget">
			<h3><?php _e('Random Posts From the Archive', 'wicketpixie') ?></h3>
			<?php query_posts('showposts=5&random=true');
			while (have_posts()) : the_post(); ?>
			<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Continue reading %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h5>
			<p style="font-size:0.8em;color:#666;"><?php the_time(get_option('date_format')) ?> | <?php comments_popup_link(); ?></p>
			<?php endwhile; ?>
		</div>
		<?php the_widget( 'WP_Widget_Tag_Cloud', 'title='.__('Popular Tags', 'wicketpixie'), 'before_title=<h3>&after_title=</h3>'); ?>
		<div class="widget">
			<!-- Custom Sidebar Code -->
			<?php wp_customcode("homesidebar"); ?>
			<!-- /Custom Sidebar Code -->
		</div>
	</div>
	<!-- /recent-posts -->
</div>
