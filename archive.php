<?php get_header();
$wp_auth_credit= get_option('wicketpixie_show_post_author'); ?>
			<!-- content -->
			<div id="content">
				<?php require_once(TEMPLATEPATH .'/app/customcode.php');
				$glob = fetchcustomcode('global_announcement.php',true);
				if($glob != "" && $glob != fetchcustomcode('idontexist.no')) : ?>
				<div class="highlight" style="margin-left: 20px;margin-right: 20px">
				<?php echo $glob; ?>
				</div>
				<?php endif; ?>
				<div class="page">
					<h1 style="border-bottom:1px solid #ddd; padding-bottom:5px;"><?php wp_title('',true,''); ?></h1>
				</div>
				<?php if (have_posts()) :
				$adsense_counter = 0;
				while (have_posts()) : the_post(); ?>
				<!-- post -->
				<div class="post">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<div class="post-comments">
						<div class="post-comments">
						<ul>
						<?php $addlink="#respond";
						$countlink="#comments"; ?>
							<li class="post-comments-count"><a href="<?php the_permalink(); echo $countlink; ?>" title="View all <?php comments_number('0', '1', '%'); ?> Comments"><?php comments_number('0', '1', '%'); ?></a></li>
							<li class="post-comments-add"><a href="<?php the_permalink(); echo $addlink; ?>" title="Add a Comment"><span>&nbsp;</span>Add a Comment</a></li>
						</ul>
						</div>
					</div>
					<div class="post-author">
						<?php if( $wp_auth_credit == 1 ) :
						echo get_avatar( get_the_author_email(), $size = '36', $default = 'images/avatar.jpg' ); ?>
						<p><strong><?php the_time('l, F jS, Y') ?></strong><br/>
							by <?php the_author_posts_link(); edit_post_link('Edit', ' - ', ''); ?></p>
						<?php else : ?>
						<p><strong><?php the_time('l, F jS, Y') ?></strong><br/>
							at <?php the_time('g:ia'); edit_post_link('Edit', ' - ', ''); ?></p>
						<?php endif; ?>
					</div>
					<div class="clearer"></div>
					<div class=KonaBody><?php the_excerpt(); ?></div>
				</div>
				<?php if ($adsense_counter == 0) : ?>
				<div align="center" style="margin: 15px 0 30px 0">
					<?php $adsense->wp_adsense('blog_post_bottom'); ?>
				</div>
				<?php endif;
				$adsense_counter++; ?>
				<?php endwhile; ?>
				<!-- Page Navigation -->
				<?php if (get_option($optpre.'plug_pagenavi') == 'true'):?>
				<div id="paginator" style='text-align: center'><?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?></div>
				<?php else : ?>
				<div class="navigation">
					<div class="left"><?php next_posts_link('<span>&nbsp;</span>Older Posts'); ?> </div>
					<div class="right"><?php previous_posts_link('<span>&nbsp;</span>Newer Posts') ?></div>
				</div>
				<?php endif; //Page Navigation 
				endif; // Posts ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
