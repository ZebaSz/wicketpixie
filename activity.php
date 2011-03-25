<?php
/**
 * Template Name: Activity Stream
 * Template for the Activity Stream page
**/
require_once( ABSPATH . WPINC . '/rss-functions.php' );
SourceAdmin::archive_streams();
get_header(); ?>
			<!-- content -->
			<div id="content">
				<!-- page -->
				<div class="page">
					<?php if (have_posts()) :
					while (have_posts()) : the_post(); ?>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
					<!-- activity -->
					<div id="activity">
						<?php $data= SourceAdmin::show_streams();
						$page= ( isset( $_GET['page'] ) && ( $_GET['page'] > 0 ) ) ? intval( $_GET['page'] ) : 1;
						$view= 50;
						$results= array_chunk( $data, $view, true );
						$test= range( 1, count( $results ) );
						krsort( $test );
						$last= array_slice( $test, 0, 1);
						$get= $_GET;
						$day= '';
						$time_offset = get_option('gmt_offset') * 3600;
						foreach( (array)$results[$page - 1] as $stream ) :
						$source_data= SourceAdmin::source( $stream->name );
						$local_date= $stream->date + $time_offset;
						$this_day= date_i18n(__('F jS', 'wicketpixie'), $local_date);
						if ( $day != $this_day ) : ?>
						<h3><?php echo $this_day; ?></h3>
						<?php endif; ?>
						<div class="activity-entry">
							<div class="activity-data">
								<div class="activity-time"><?php echo date( get_option('time_format'), $local_date ); ?></div>
								<div class="activity-content"><a href="<?php echo $stream->link; ?>" rel="nofollow"><?php echo $stream->content; ?></a></div>
							</div>
							<div class="activity-source"><a href="<?php echo $source_data->profile_url; ?>" rel="nofollow"><img src="<?php echo $source_data->favicon; ?>" alt="<?php echo $stream->name; ?>" /></a></div>
						</div>
						<?php $day= $this_day;
						endforeach; ?>
					</div>
					<!-- /activity -->
					<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<!-- /page -->
				<div class="navigation">
					<?php if( $last[0] != $page ) : ?>
					<div class="left">
						<a href="<?php echo '?page=' . ( $page +1 ); ?>" title="<?php _e('More', 'wicketpixie') ?>"><span><?php _e('More', 'wicketpixie') ?></span></a>
					</div>
					<?php endif;
					if( $page != 1 ) : ?>
						<div class="right">
							<a href="<?php echo '?page=' . ( $page -1 ); ?>" title="<?php _e('Newer', 'wicketpixie') ?>"><span><?php _e('Newer', 'wicketpixie') ?></span></a>
						</div>
					<?php endif; ?>
				</div>
				<div class="clearer"></div>
			</div>
			<!-- content -->
			<!-- sidebar -->
			<?php get_sidebar(); ?>
			<!-- /sidebar -->
<?php get_footer(); ?>
