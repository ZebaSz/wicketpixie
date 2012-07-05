<?php
/**
 * WicketPixie v1.5
 * (c) 2006-2009 Eddie Ringle,
 *               Chris J. Davis,
 *               Dave Bates
 * Provided by Chris Pirillo
 *
 * (c) 2011-2012 Sebastian Szperling
 *
 * Licensed under the New BSD License.
 */
// Settings array - kept for compatibility for the time being
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
// Register Theme Customizer settings controls
add_action('customize_register', 'wicketpixie_customize_register');
function wicketpixie_customize_register($wp_customize) {
	$wp_customize->get_setting('blogname')->transport='postMessage';
	$wp_customize->get_setting('blogdescription')->transport='postMessage';
	global $theme_options;
	$wp_customize->add_section('wicketpixie_fonts', array(
		'title' => __('Fonts','wicketpixie'),
		'priority' => 50
	));
	foreach($theme_options as $option)
	{
		// Add the setting to the database
		$wp_customize->add_setting($option['id'], array('default' => $option['std'], 'type' => 'option', 'capability' => 'edit_theme_options', 'transport' => 'postMessage'));
		// Add the appropriate control to the Customizer
		if ($option['type'] == 'color') $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $option['id'], array('label' => $option['name'], 'section' => 'colors', 'settings' => $option['id'], 'priority' => -5)));
		if ($option['type'] == 'font') $wp_customize->add_control($option['id'], array('label' => $option['name'], 'section' => 'wicketpixie_fonts', 'settings' => $option['id']));
	}
}
// AJAX for live previews
add_action('customize_preview_init', 'wicketpixie_customize_preview');
function wicketpixie_customize_preview() {
	wp_enqueue_script('wicketpixie-customizer', get_template_directory_uri().'/app/theme-customizer.js', array('customize-preview'), false, true);
}
// Output settings
add_action('wp_head', 'wicketpixie_theme_print_options');
function wicketpixie_theme_print_options() { ?>
	<style type='text/css'>
		body, #comment-form input, #comment-form textarea, #content .comment h5, #mid #sidebar h5 {font-family: <?php echo get_option('wicketpixie_theme_body_font'); ?>;}
		#logo {font-size: <?php echo get_option('wicketpixie_theme_header_size'); ?>px;}
		#logo, #mid h1, #mid h2, #mid h3, #mid h4, #mid h5, #mid h6, #mid #sidebar h1, #mid #sidebar h2, #mid #sidebar h3, #mid #sidebar h4, #mid #sidebar h5, #mid #sidebar h6 {font-family: <?php echo get_option('wicketpixie_theme_headings_font'); ?>;}
		#logo, #logo a:link, #logo a:visited, #logo a:active {color: <?php echo get_option('wicketpixie_theme_logo_color'); ?>;}
		#logo a:hover {color: #fff;}
		#description, #status p, #status a:link, #status a:active, #status a:visited {color: <?php echo get_option('wicketpixie_theme_description_color'); ?>;}
		#content a:link, #content a:visited, #content a:active, #content .comment h3 a:link, #content .comment h3 a:active, #content .comment h3 a:visited {color: <?php echo get_option('wicketpixie_theme_content_links_color'); ?>;}
		#mid h1, #mid h2, #mid h3, #mid h4, #mid h5, #mid h6, #mid #sidebar h1, #mid #sidebar h2, #mid #sidebar h3, #mid #sidebar h4, #mid #sidebar h5, #mid #sidebar h6 {font-weight: bold;}
		#mid h1, #mid h2, #mid h3, #mid h4, #mid h5, #mid h6, #mid h1 a:link, #mid h1 a:visited, #mid h1 a:active, #mid h2 a:link, #mid h2 a:visited, #mid h2 a:active, #mid h3 a:link, #mid h3 a:visited, #mid h3 a:active, #mid h4 a:link, #mid h4 a:visited, #mid h4 a:active, #mid h5 a:link, #mid h5 a:visited, #mid h5 a:active, #mid h6 a:link, #mid h6 a:visited, #mid h6 a:active {color: <?php echo get_option('wicketpixie_theme_titles_color'); ?>;}
		#mid #sidebar a:link, #mid #sidebar a:visited, #mid #sidebar a:active {color: <?php echo get_option('wicketpixie_theme_sidebar_links_color'); ?>;}
		#mid a:hover, #mid h1 a:hover, #mid h2 a:hover, #mid h3 a:hover, #mid h4 a:hover, #mid h5 a:hover, #mid h6 a:hover, #mid #sidebar a:hover, #mid #sidebar h1 a:hover, #mid #sidebar h2 a:hover, #mid #sidebar h3 a:hover, #mid #sidebar h4 a:hover, #mid #sidebar h5 a:hover, #mid #sidebar h6 a:hover, #content .comment h3 a:hover {color: #000;border-bottom: 1px solid <?php echo get_option('wicketpixie_theme_content_links_color'); ?>;}
		#mid #sidebar h1, #mid #sidebar h2, #mid #sidebar h3, #mid #sidebar h3 a:link, #mid #sidebar h3 a:visited, #mid #sidebar h3 a:active, #mid #sidebar h4, #mid #sidebar h5, #mid #sidebar h6 {color: <?php echo get_option('wicketpixie_theme_sidebar_headings_color'); ?>;}
	</style>
<?php } ?>
