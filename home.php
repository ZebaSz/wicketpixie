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
						<div class="post-comments-count"><a href="<?php the_permalink(); ?>#comments" title="<?php printf(__('View all %d Comments', 'wicketpixie'), get_comments_number()); ?>"><?php comments_number('0', '1', '%'); ?></a></div>
						<div class="post-comments-add"><a href="<?php the_permalink(); ?>#respond" title="<?php _e('Add a Comment', 'wicketpixie'); ?>"><span>+</span></a></div>
					</div>
					<div class="post-author">
						<?php if( $wp_auth_credit == 'true' ) :
						echo get_avatar( get_the_author_email(), $size = '36', $default = 'images/avatar.jpg' ); ?>
						<p><strong><?php the_date() ?></strong><br/>
							<?php _e('by %s', 'wicketpixie'); ?> <?php the_author_posts_link(); ?></p>
						<?php else : ?>
						<p><strong><?php the_date() ?></strong><br/>
							<?php printf(__('at %s', 'wicketpixie'), get_the_time()); ?></p>
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
					<?php wp_customcode("afterhomepost"); ?>
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
				<?php wp_customcode("afterhomemeta"); ?>
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
			<?php get_sidebar('home'); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
