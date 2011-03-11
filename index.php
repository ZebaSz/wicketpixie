<?php get_header();
$wp_auth_credit= get_option('wicketpixie_show_post_author'); ?>
			<!-- google_ad_section_start -->
			<!-- content -->
			<div id="content">
				<?php if (have_posts()) :
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
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" style="text-decoration:none;"><?php the_title(); ?></a></h1>
					<div class="post-comments">
						<ul>
						<?php $addlink="#respond";
						$countlink="#comments"; ?>
							<li class="post-comments-count"><a href="<?php the_permalink(); echo $countlink; ?>" title="View all <?php comments_number('0', '1', '%'); ?> Comments"><?php comments_number('0', '1', '%'); ?></a></li>
							<li class="post-comments-add"><a href="<?php the_permalink(); echo $addlink; ?>" title="Add a Comment"><span>+</span></a></li>
						</ul>
					</div>
					<div class="post-author">
						<?php if( $wp_auth_credit == 'true' ) :
						echo get_avatar( get_the_author_email(), $size = '36', $default = 'images/avatar.jpg' ); ?>
						<p><strong><?php the_time('l, F jS, Y') ?></strong><br/>
							by <?php the_author_posts_link(); ?><?php edit_post_link('Edit', ' - ', ''); ?></p>
						<?php else : ?>
						<p><strong><?php the_time('l, F jS, Y') ?></strong><br/>
							at <?php the_time('g:ia') ?><?php edit_post_link('Edit', ' - ', ''); ?></p>
						<?php endif; ?>
					</div>
					<div class="clearer"></div>
					<div class="KonaBody">
					<?php the_content('Continue reading &raquo;'); ?>
					</div>
					<?php wp_after_posts_code(); ?>
				</div>
				<!-- /post -->
				<!-- google_ad_section_end -->
				<?php endwhile; ?>
				<!-- Page Navigation -->
				<?php if (get_option('wicketpixie_plugin_pagenavi') == 'true') : ?>
				<div id="paginator" style='text-align: center'><?php if (function_exists('wp_pagenavi')) { wp_pagenavi(); }?></div>
				<?php else : ?>
				<div class="navigation">
					<div class="left"><?php next_posts_link('<span>&nbsp;</span>Older Posts'); ?> </div>
					<div class="right"><?php previous_posts_link('<span>&nbsp;</span>Newer Posts') ?></div>
				</div>
				<?php endif; // Page Navigation
				endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
