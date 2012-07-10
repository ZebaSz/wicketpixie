<?php
/**
 * Template Name: Faves
**/
get_header();
$faves = new FavesAdmin;
if (is_user_logged_in() && isset($_REQUEST['action']) && $_REQUEST['action'] == 'sort')
	$faves->sort($_REQUEST); ?>
			<!-- content -->
			<div id="content">
				<?php if (have_posts()) :
				while (have_posts()) : the_post(); ?>
				<!-- page -->
				<div class="page">
					<h1><?php the_title(); ?></h1>
					<?php the_content(sprintf(esc_attr__('Continue reading %s', 'wicketpixie'), '&raquo;')); ?>
					<!-- faves -->
					<div id="faves">
						<!-- faves-feed -->
						<?php $i= 0;
						require_once (CLASSFEEDPATH);
						if ($faves->check()) :
						foreach ($faves->show_faves() as $fave) :
						$class = ($i++ & 1) ? ' odd' : '';
						$feed_path = $fave->feed_url;
						$feed = fetch_feed($feed_path);
						if (!is_wp_error($feed)) : ?>
						<div class="faves-feed<?php echo $class; ?>">
							<?php $favicon_url = $faves->get_favicon($fave->feed_url); ?>
							<h3><img src="<?php echo $favicon_url; ?>" alt="<?php echo $fave->title; ?>" /><?php echo $fave->title; ?></h3>
							<?php if (is_user_logged_in()) : ?>
							<form name"re-order-<?php echo $fave->id; ?>" method="post" action="<?php the_permalink(); ?>?sort=true&amp;id=<?php echo $fave->id; ?>">
							<input type="hidden" name="action" value="sort">
							<input type="hidden" name="id" value="<?php echo $fave->id; ?>">
							<strong>Current Place: <?php echo $fave->sortorder; ?></strong> | New Place <select name="newsort" id="newsort-<?php echo $fave->id; ?>">
								<?php foreach ($faves->positions() as $place) : ?>
									<option value="<?php echo $place->sortorder; ?>"><?php echo $place->sortorder; ?></option>
								<?php endforeach; ?>
							</select>
							<input type="submit" value="Sort" />
							</form>
							<?php endif; ?>
							<ul>
							<?php $c = 0;
							$total = 5;
							foreach ($feed->get_items() as $entry) :
								if ($c != $total) : ?>
								<li><a href="<?php echo $entry->get_permalink(); ?>" rel="nofollow"><?php echo $entry->get_title(); $c++; ?></a></li>
								<?php endif;
							endforeach; ?>
							</ul>
						</div>
						<?php endif;
						endforeach;
						endif; ?>
						<!-- /faves-feed -->
					</div>
					<!-- /faves -->
				</div>
				<!-- /page -->
				<?php endwhile;
				endif; ?>
			</div>
			<!-- /content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<script type="text/javascript">
	jQuery(document).ready(
		function ($) {
			$('div.groupWrapper').Sortable(
				{
					accept: 'groupItem',
					helperclass: 'sortHelper',
					activeclass : 'sortableactive',
					hoverclass : 'sortablehover',
					handle: 'div.itemHeader',
					tolerance: 'pointer',
						onChange : function(ser) {
						},
						onStart : function() {
							$.iAutoscroller.start(this, document.getElementsByTagName('body'));
						},
						onStop : function() {
							$.iAutoscroller.stop();
						}
					}
				);
			}
	);
</script>
<?php get_footer(); ?>
