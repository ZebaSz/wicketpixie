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
/**
* WicketPixie Home Editor
* Now you finally do not have to dig into the template files to
* modify your home page! Whee! \o/
**/
// Arrays that hold our options
$homeoptions = array(
	array(
	'name' => 'Enable Home Page',
	'description' => 'Enable the WicketPixie home. Wordpress front page settings are used otherwise.',
	'id' => 'wicketpixie_theme_home_enable',
	'std' => 'true',
	'type' => 'checkbox'),
	array(
	'name' => 'Flickr Badge',
	'description' => 'Display the Flickr badge on the home page.',
	'id' => 'wicketpixie_home_flickr_enable',
	'std' => 'false',
	'type' => 'checkbox'),
	array(
	'name' => '# of Flickr Images',
	'description' => 'Select how many images will be displayed in the Flickr badge.',
	'id' => 'wicketpixie_home_flickr_number',
	'std' => '5',
	'type' => 'select',
	'options' => array('3','4','5','6')),
	array(
	'name' => 'Video Embed',
	'description' => 'Enable the Video Embed Code entered below.',
	'id' => 'wicketpixie_home_video_enable',
	'std' => 'false',
	'type' => 'checkbox'),
	array(
	'name' => 'Video Object Code',
	'description' => 'Enter code for a video object. For example, a YouTube custom player.',
	'id' => 'wicketpixie_home_video_code',
	'std' => '',
	'type' => 'textarea'),
	array(
	'name' => 'Show "My Videos" heading',
	'description' => 'Show the "My Videos" heading above the video embed.',
	'id' => 'wicketpixie_home_show_video_heading',
	'std' => 'false',
	'type' => 'checkbox'),
	array(
	'name' => 'Show "Recent Photos" heading',
	'description' => 'Show the "Recent Photos" heading above the video embed.',
	'id' => 'wicketpixie_home_show_photo_heading',
	'std' => 'false',
	'type' => 'checkbox'),
	array(
	'name' => 'Enable Social Buttons Widget',
	'description' => 'Show the Social Buttons Widget in the homepage sidebar.',
	'id' => 'wicketpixie_home_social_buttons_enable',
	'std' => 'false',
	'type' => 'checkbox'),
	array(
	'name' => 'Ustream Widget',
	'description' => 'Check to enable the Ustream embed on the homepage sidebar.',
	'id' => 'wicketpixie_home_ustream_enable',
	'std' => 'false',
	'type' => 'checkbox'),
	array(
	'name' => 'Autoplay Ustream',
	'description' => 'Check if you want the Ustream object to automatically play on page load.',
	'id' => 'wicketpixie_home_ustream_autoplay',
	'std' => 'false',
	'type' => 'checkbox'),
	array(
	'name' => 'Ustream Object Heading',
	'description' => 'The heading that will appear above the Ustream Object.',
	'id' => 'wicketpixie_home_ustream_heading',
	'std' => 'Live Video',
	'type' => 'textbox'),
	array(
	'name' => 'Ustream Object Height',
	'description' => 'Enter height of the Ustream object in pixels. 293px is recommended.',
	'id' => 'wicketpixie_home_ustream_height',
	'std' => '293',
	'type' => 'textbox'),
	array(
	'name' => 'Ustream Object Width',
	'description' => 'Enter width of the Ustream object in pixels. 340px is recommended.',
	'id' => 'wicketpixie_home_ustream_width',
	'std' => '340',
	'type' => 'textbox'),
	array(
	'name' => 'Enable Post Sidebar',
	'description' => 'Enable the area next to the post containing the AdSense ad and Related Posts.',
	'id' => 'wicketpixie_home_enable_aside',
	'std' => 'false',
	'type' => 'checkbox')
);
class HomeAdmin extends AdminPage {
	function __construct() {
		parent::__construct('Home Editor','homeeditor.php','wicketpixie-admin.php',array($GLOBALS['homeoptions']));
	}
	function __destruct() {
		parent::__destruct();
		unset($GLOBALS['homeoptions']);
	}
} ?>
