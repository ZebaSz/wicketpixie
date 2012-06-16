<?php
/**
 * WicketPixie v1.4
 * (c) 2006-2009 Eddie Ringle,
 *               Chris J. Davis,
 *               Dave Bates
 * Provided by Chris Pirillo
 *
 * (c) 2011 Sebastian Szperling
 *
 * Licensed under the New BSD License.
 */
$theme_options = array (
	array(
		'name' => __('Body Font Family','wicketpixie'),
		'id' => 'wicketpixie_theme_body_font',
		'std' => 'Lucida Grande, Arial, Verdana, sans-serif',
		'type' => 'font'),
	array(
		'name' => __('Headings Font Family','wicketpixie'),
		'id' => 'wicketpixie_theme_headings_font',
		'std' => 'Georgia, Times New Roman, Times, serif',
		'type' => 'font'),
	array(
		'name' => __('Logo Font Size (in pixels)','wicketpixie'),
		'id' => 'wicketpixie_theme_header_size',
		'std' => '40',
		'type' => 'font'),
	array(
		'name' => __('Logo Text','wicketpixie'),
		'id' => 'wicketpixie_theme_logo_color',
		'std' => '#fff0a5',
		'type' => 'color'),
	array(  
		'name' => __('Status/Description Text','wicketpixie'),
		'id' => 'wicketpixie_theme_description_color',
		'std' => '#9e6839',
		'type' => 'color'),
	array(
		'name' => __('Titles/Content Headings','wicketpixie'),
		'id' => 'wicketpixie_theme_titles_color',
		'std' => '#b64926',
		'type' => 'color'),
	array(
		'name' => __('Sidebar Headings','wicketpixie'),
		'id' => 'wicketpixie_theme_sidebar_headings_color',
		'std' => '#8e2800',
		'type' => 'color'),
	array(
		'name' => __('Content Links','wicketpixie'),
		'id' => 'wicketpixie_theme_content_links_color',
		'std' => '#8e2800',
		'type' => 'color'),
	array(
		'name' => __('Sidebar Links','wicketpixie'),
		'id' => 'wicketpixie_theme_sidebar_links_color',
		'std' => '#333',
		'type' => 'color')
);
function wicketpixie_customize_register($wp_customize) {
  global $theme_options;
  $wp_customize->add_section('wicketpixie_fonts', array(
		'title' => __('Fonts','wicketpixie'),
		'priority' => 50
	));
  foreach($theme_options as $option)
  {
		// Add the setting to the database
		$wp_customize->add_setting( $option['id'], array('default' => $option['std'], 'type' => 'option', 'capability' => 'edit_theme_options'));
		// Add the appropriate control to the customizer
		if ($option['type'] == 'color') {
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $option['id'], array('label' => $option['name'], 'section' => 'colors', 'settings' => $color['id'], 'priority' => -5)));
		}
		if ($option['type'] == 'font') {
			$wp_customize->add_control($option['id'], array( 'label' => $option['name'], 'section' => 'wicketpixie_fonts', 'settings' => $option['id']));
		}
  }
}
add_action('customize_register', 'wicketpixie_customize_register');
function wicketpixie_theme_print_options() { ?>
	<style type='text/css'>
		body { font-family: <?php echo get_option('wicketpixie_theme_body_font'); ?>; }
		#logo { font-family: <?php echo get_option('wicketpixie_theme_headings_font'); ?>; color: <?php echo get_option('wicketpixie_theme_logo_color'); ?>; }
		#logo a:link, #logo a:visited, #logo a:active { color: <?php echo get_option('wicketpixie_theme_logo_color'); ?>; }
		#logo a:hover { color: #fff; }
		#description, #status p, #status a:link, #status a:active, #status a:visited { color: <?php echo get_option('wicketpixie_theme_description_color'); ?>; }
		.content a:link, .content a:visited, .content a:active { color: <?php echo get_option('wicketpixie_theme_content_links_color'); ?>; }
		.content a:hover { color: #000; border-bottom: 1px solid <?php echo get_option('wicketpixie_theme_content_links_color'); ?>; }
		.content h1, .content h2, .content h3, .content h4, .content h5, .content h6 { color: <?php echo get_option('wicketpixie_theme_titles_color'); ?>; font-family: <?php echo get_option('wicketpixie_theme_headings_font'); ?>; font-weight: bold; }
		.content h1 a:link, .content h1 a:visited, .content h1 a:active, .content h2 a:link, .content h2 a:visited, .content h2 a:active, .content h3 a:link, .content h3 a:visited, .content h3 a:active, .content h4 a:link, .content h4 a:visited, .content h4 a:active, .content h5 a:link, .content h5 a:visited, .content h5 a:active, .content h6 a:link, .content h6 a:visited, .content h6 a:active { color: <?php echo get_option('wicketpixie_theme_titles_color'); ?>; }
		.content h1 a:hover, .content h2 a:hover, .content h3 a:hover, .content h4 a:hover, .content h5 a:hover, .content h6 a:hover { color: #000; }
		#content .comment h3 a:link, #content .comment h3 a:active, #content .comment h3 a:visited { color: <?php echo get_option('wicketpixie_theme_content_links_color'); ?>; }
		#content .comment h3 a:hover { color: #000; border-bottom: 1px solid <?php echo get_option('wicketpixie_theme_content_links_color'); ?>; }
		#content .comment h5 { font-family: <?php echo get_option('wicketpixie_theme_body_font'); ?>; }
		#comment-form input, #comment-form textarea { font-family: <?php echo get_option('wicketpixie_theme_body_font'); ?>; }
		#sidebar a:link, #sidebar a:visited, #sidebar a:active { color: <?php echo get_option('wicketpixie_theme_sidebar_links_color'); ?>; }
		#sidebar a:hover { color: #000; }
		#sidebar h1, #sidebar h2, #sidebar h3, #sidebar h3 a:link, #sidebar h3 a:visited, #sidebar h3 a:active, #sidebar h4, #sidebar h5, #sidebar h6 { color: <?php echo get_option('wicketpixie_theme_sidebar_headings_color'); ?>; font-family: <?php echo get_option('wicketpixie_theme_headings_font'); ?>; font-weight: bold; }
		#sidebar h5 { font-family: <?php echo get_option('wicketpixie_theme_body_font'); ?>; }
	</style>
<?php }
add_action('wp_head', 'wicketpixie_theme_print_options'); ?>
