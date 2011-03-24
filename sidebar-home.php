<div id="sidebar">
	<?php if(get_option('wicketpixie_home_social_buttons_enable') == 'true') : ?>
		<!-- social-buttons -->
		<?php require_once(TEMPLATEPATH .'/widgets/social-badges.php');
		SocialBadgesWidget::widget(array(),''); ?>
		<!-- /social-buttons -->
	<?php endif; ?>
	<!-- width = 340, height = 240 -->
	<?php if (get_option('wicketpixie_home_ustream_enable') == 'true') : ?>
	<div id="home-youtube">
		<?php echo "<h3>".get_option('wicketpixie_home_ustream_heading')."</h3>";
		$key = "uzhqbxc7pqzqyvqze84swcer";
		$ustream_channel = get_option('wicketpixie_ustream_channel');
		if ($ustream_channel != false && $ustream_channel != "") :
			$chan = $ustream_channel;
		else :
			$trip = true;
			$ustream_height = get_option('wicketpixie_home_ustream_height');
			if ($ustream_height != false && $ustream_height != "") :
				$height = $ustream_height;
			else :
				$trip = true;
			endif;
			$ustream_width = get_option('wicketpixie_home_ustream_width');
			if ($ustream_width != false && $ustream_width != "") :
				$width = $ustream_width;
			else :
				$trip = true;
			endif;
			if (get_option($optpre.'home_ustream_autoplay') == 'true') :
					$autoplay = true;
			else :
				$autoplay = false;
			endif;
			if ($trip == true) :
				$out = "<!-- Please go back to the Home Editor and set the settings for this widget. -->";
			else :
				$url = "http://api.ustream.tv/php/channel/$chan/getInfo?key=$key";
				$cl = curl_init($url);
				curl_setopt($cl,CURLOPT_HEADER,false);
				curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);
				$resp = curl_exec($cl);
				curl_close($cl);
				$resultsArray = unserialize($resp);
				$out = $resultsArray['results'];
			endif;
			echo '<!--[if !IE]> -->
	<object type="application/x-shockwave-flash" data="http://www.ustream.tv/flash/live/',$out['id'],'" width="',$width,'" height="',$height,'">
<!-- <![endif]-->
<!--[if IE]>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="',$width,'" height="',$height,'">
	<param name="movie" value="http://www.ustream.tv/flash/live/',$out['id'],'" />
<!--><!-- http://Validifier.com -->
	<param name="allowFullScreen" "value="true"/>
	<param value="always" name="allowScriptAccess" />
	<param value="transparent" name="wmode" />
	<param value="viewcount=true&amp;autoplay=',$autoplay,'" name="flashvars" />
	</object>
<!-- <![endif]-->';
		endif; ?>
	</div>
	<?php endif; ?>
	<!-- /youtube -->
	<!-- recent-posts -->
	<div id="sidebar1">
		<div class="widget">
			<h3><?php _e('What else is new?', 'wicketpixie') ?></h3>
			<?php query_posts('showposts=5&offset=1');
			while (have_posts()) : the_post(); ?>
			<!-- post -->
				<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Continue reading %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h5>
				<p style="font-size:1em"><?php the_time(get_option('date_format')) ?> | <?php comments_popup_link(); ?></p>
			<!-- /post -->
			<?php endwhile; ?>
			<div style="padding-bottom:15px"></div>
			<h3><?php _e('Recent Comments', 'wicketpixie') ?></h3>
			<ul class="recentcomments">
				<?php if(!$comments = wp_cache_get('recent_comments','widget')) :
					$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 5");
					wp_cache_add('recent_comments',$comments,'widget');
				endif;
				if($comments) : foreach((array)$comments as $comment) :
					echo '<li class="recentcomments">',sprintf(_x('%1$s on %2$s','widgets'),get_comment_author_link(),'<a href="'.esc_url(get_comment_link($comment->comment_ID)).'">'.get_the_title($comment->comment_post_ID).'</a>'),'</li>';
				endforeach; endif; ?>
			</ul>
			<div style="padding-bottom:15px"></div>
			<h3><?php _e('Random Posts From the Archive', 'wicketpixie') ?></h3>
			<?php query_posts('showposts=5&random=true');
			while (have_posts()) : the_post(); ?>
			<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Continue reading %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h5>
			<p style="font-size:1em"><?php the_time(get_option('date_format')) ?> | <?php comments_popup_link(); ?></p>
			<?php endwhile; ?>
			<div style="padding-bottom:15px"></div>
			<h3><?php _e('Popular Tags', 'wicketpixie') ?></h3>
			<span style="line-height:1.3em;">
			<?php wp_tag_cloud('orderby=count&order=DESC&unit=px&smallest=10&largest=16&format=flat'); ?>
			</span>
			<div style="padding-bottom:15px"></div>
			<!-- Custom Sidebar Code -->
			<?php require_once(TEMPLATEPATH .'/app/customcode.php');
			fetchcustomcode('homesidebar.php'); ?>
			<!-- /Custom Sidebar Code -->
			<div style="padding-bottom:15px"></div>
		</div>
	</div>
	<!-- /recent-posts -->
</div>
