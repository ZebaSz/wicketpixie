<?php get_header();
$wp_auth_credit= get_option('wicketpixie_show_post_author'); ?>
			<!-- content -->
			<div id="content">
				<!-- google_ad_section_start -->
				<?php query_posts('showposts=1');
				if (have_posts()) :
				while (have_posts()) : the_post(); ?>
				<!-- post -->
				<div class="post" style="border-bottom:0;">
					<?php require_once(TEMPLATEPATH .'/app/customcode.php');
					$glob = fetchcustomcode('global_announcement.php',true);
					if($glob != "" && $glob != fetchcustomcode('idontexist.no')): ?>
					<div class="highlight">
					<?php echo $glob; ?>
					</div>
					<?php endif; ?>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s', 'wicketpixie'), the_title_attribute('echo=0')); ?>" style="text-decoration:none;"><?php the_title(); ?></a></h1>
					<div class="post-comments">
						<ul>
							<li class="post-comments-count"><a href="<?php the_permalink(); ?>#comments" title="<?php printf(__('View all %d Comments', 'wicketpixie'), get_comments_number()); ?>"><?php comments_number('0', '1', '%'); ?></a></li>
							<li class="post-comments-add"><a href="<?php the_permalink(); ?>#respond" title="<?php _e('Add a Comment', 'wicketpixie'); ?>"><span>+</span></a></li>
						</ul>
					</div>
					<div class="post-author">
						<?php if( $wp_auth_credit == 'true' ) :
						echo get_avatar( get_the_author_email(), $size = '36', $default = 'images/avatar.jpg' ); ?>
						<p><strong><?php the_date() ?></strong><br/>
							<?php _e('by', 'wicketpixie'); ?> <?php the_author_posts_link(); ?></p>
						<?php else : ?>
						<p><strong><?php the_date() ?></strong><br/>
							<?php _e('at', 'wicketpixie'); ?> <?php the_time() ?></p>
						<?php endif; ?>
					</div>
					<div class="clearer"></div>
					<?php if (get_option('wicketpixie_home_enable_aside') == 'true') : ?>
					<!-- post-ad -->
						<div id="post-ad">
							<?php if(is_enabled_adsense() == true) $adsense->wp_adsense('blog_post_side'); ?>
							<div style="margin: 15px 0 0 5px">
								<?php if (get_option('wicketpixie_plugin_related-posts') == 'true') :
								wp_related_posts(5);
								endif; ?>
							</div>
						</div>
					<!-- /post-ad -->
					<?php endif; ?>
					<div class="KonaBody">
					<?php if(is_enabled_adsense() == true) : ?>
					<span style="float:left;display:block;clear:none;margin-right:10px;">
					<?php $adsense->wp_adsense('blog_home_post_front'); ?>
					</span>
					<?php endif;
					the_content(__('Continue reading %d', 'wicketpixie').'&raquo;'); ?>
					</div>
					<?php wp_after_home_post_code(); ?>
				</div>
				<!-- /post -->
				<!-- google_ad_section_end -->
				<!-- post-meta -->
				<div class="post-meta">
					<?php if(get_option('wicketpixie_plugin_related-posts') == 'true' && function_exists(wp_related_posts)) : ?>
					<!-- related-posts -->
					<div id="related-posts">
						<h3><?php _e('You might also be interested in...', 'wicketpixie'); ?></h3>
						 <?php wp_related_posts(5); ?>
					</div>
					<!-- /related-posts -->
					<?php endif; ?>
					<!-- post-meta-right -->
					<div class="post-meta-right">
						<!-- post-meta-tags -->
						<div class="post-meta-tags">
							<h6><?php _e('Tags', 'wicketpixie'); ?></h6>
							<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
						</div>
						<!-- /post-meta-tags -->
						<!-- post-meta-categories -->
						<div class="post-meta-categories">
							<h6><?php _e('Categories', 'wicketpixie'); ?></h6>
							<?php the_category(); ?>
						</div>
						<!-- /post-meta-categories -->
						<!-- post-bigbox -->
						<div class="post-bigbox">
						<?php if(is_enabled_adsense() == true) :
							$adsense->wp_adsense('blog_post_bottom');
						else: ?>
							<!-- Enable Adsense on the WicketPixie Adsense admin page. -->
						<?php endif; ?>
						</div>
						<!-- /post-bigbox -->
					</div>
					<!-- /post-meta-right -->
					<div class="clearer"></div>
				</div>
				<!-- /post-meta -->
				<!-- Custom Code Area -->
				<?php if(get_option('wicketpixie_home_custom_code') != false && get_option('wicketpixie_home_custom_code') != '') :
					echo stripslashes(get_option('wicketpixie_home_custom_code'));
				endif; ?>
				<!-- /Custom Code Area -->
				<?php endwhile;
				endif;
				if(get_option('wicketpixie_home_video_enable') == 'true') : ?>
				<div id="home-categories">
					<?php if(get_option('wicketpixie_home_show_video_heading') == 'true') :
						echo "<h2>".__('My Videos', 'wicketpixie')."</h2>";
					endif;
					if(get_option('wicketpixie_home_video_code') != false && get_option('wicketpixie_home_video_code') != '') :
								echo stripslashes(get_option('wicketpixie_home_video_code'));
					else : ?>
					<!-- Add video object code in the WicketPixie Home Editor -->
					<!-- Here's Chris Pirillo's YouTube object as an example: -->
					<!--[if !IE]> -->
					  <object type="application/x-shockwave-flash" data="http://www.youtube.com/cp/vjVQa1PpcFOi2GvexXT8XYrvBOsPoeQUt32UxT-AJgI=" width="500" height="285">
					<!-- <![endif]-->
					<!--[if IE]>
					  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="500" height="285">
						<param name="movie" value="http://www.youtube.com/cp/vjVQa1PpcFOi2GvexXT8XYrvBOsPoeQUt32UxT-AJgI=" />
					<!--><!-- http://Validifier.com -->
					  </object>
					<!-- <![endif]-->
					<?php endif; ?>
				</div>
				<?php endif;
				if(get_option('wicketpixie_home_flickr_enable') == 'true') : ?>
				<!-- home-photos -->
				<div id="home-photos">
					<?php if(get_option('wicketpixie_flickr_id') != false && get_option('wicketpixie_flickr_id') != 'false') :
						$flickrid = get_option('wicketpixie_flickr_id');
					else :
						$flickrid = '49503157467@N01';
					endif;
					if(get_option('wicketpixie_home_flickr_number') != false) :
						$num = get_option('wicketpixie_home_flickr_number');
					else :
						$num = '5';
					endif;
					if(get_option('wicketpixie_home_show_photo_heading') == 'true') :
						echo "<h2>".__('Recent Photos', 'wicketpixie')."</h2>";
					endif; ?>
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $num; ?>&amp;display=latest&amp;size=s&amp;layout=h&amp;source=user&amp;user=<?php echo $flickrid; ?>"></script>
				</div>
				<!-- /home-photos -->
				<div class="clearer"></div>
				<?php endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<div id="sidebar">
				<?php if(get_option('wicketpixie_home_social_buttons_enable') == 'true') : ?>
					<!-- social-buttons -->
					<?php $blogfeed = get_option('wicketpixie_blog_feed_url');
					$podcastfeed = get_option('wicketpixie_podcast_feed_url');
					$twitter = get_option('wicketpixie_twitter_id');
					$youtube = get_option('wicketpixie_youtube_id');
					$wcount = 0;
					$witem = array();
					if($blogfeed != false && $blogfeed != "") :
						$witem[$wcount] = "<a href='$blogfeed'><img src='".get_template_directory_uri()."/images/button-feed.png' style='float:left;padding:10px 10px 20px 14px;border:0px;' height='60' width='60' alt='Subscribe'/></a>\n";
						$wcount++;
					endif;
					if($podcastfeed != false && $podcastfeed != "") :
						$witem[$wcount] = "<a href='$podcastfeed'><img src='".get_template_directory_uri()."/images/button-podcast-feed.png' style='float:left;padding:10px 10px 20px 14px;border:0px;' height='60' width='60' alt='Podcast'/></a>\n";
						$wcount++;
					endif;
					if($twitter != false && $twitter != "") :
						$witem[$wcount] = "<a href='http://twitter.com/$twitter'><img src='".get_template_directory_uri()."/images/button-twitter.png' style='float:left;padding:10px 10px 20px 14px;border:0px;' height='60' width='60' alt='Twitter'/></a>\n";
						$wcount++;
					endif;
					if($youtube != false && $youtube != "") :
						$witem[$wcount] = "<a href='http://youtube.com/$youtube'><img src='".get_template_directory_uri()."/images/button-youtube.png' style='float:left;padding:10px 10px 20px 14px;border:0px;' height='60' width='60' alt='YouTube'/></a>\n";
						$wcount++;
					endif;
					$wwidget = ($wcount * 0.25) * 340;
					echo "<div style='margin:0px auto 0px auto;width:",$wwidget,"px'>";
					foreach($witem as $item) echo $item; ?>
					</div>
					<div style="clear:both"></div>
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
			<!-- /sidebar -->
<?php get_footer(); ?>
