(function($) {
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('#logo a').html(to);
		});
	});
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('#description').html(to);
		});
	});
	wp.customize('wicketpixie_theme_body_font',function(value) {
		value.bind(function(to) {
			$('#logo').css('font-family', to);
		});
	});
	wp.customize('wicketpixie_theme_headings_font',function(value) {
		value.bind(function(to) {
			$('#logo, #mid h1, #mid h2, #mid h3, #mid h4, #mid h5, #mid h6, #mid #sidebar h1, #mid #sidebar h2, #mid #sidebar h3, #mid #sidebar h4, #mid #sidebar h5, #mid #sidebar h6').css('font-family', to);
		});
	});
	wp.customize('wicketpixie_theme_header_size',function(value) {
		value.bind(function(to) {
			$('#logo').css('font-size', to + 'px');
		});
	});
	wp.customize('wicketpixie_theme_logo_color',function(value) {
		value.bind(function(to) {
			$('#logo, #logo a:link, #logo a:visited, #logo a:active').css('color', to);
		});
	});
	wp.customize('wicketpixie_theme_description_color',function(value) {
		value.bind(function(to) {
			$('#description, #status p, #status a:link, #status a:active, #status a:visited').css('color', to);
		});
	});
	wp.customize('wicketpixie_theme_titles_color',function(value) {
		value.bind(function(to) {
			$('#mid #content h1, #mid #content h2, #mid #content h3, #mid #content h4, #mid #content h5, #mid #content h6, #mid #content h1 a:link, #mid #content h1 a:visited, #mid #content h1 a:active, #mid #content h2 a:link, #mid #content h2 a:visited, #mid #content h2 a:active, #mid #content h3 a:link, #mid #content h3 a:visited, #mid #content h3 a:active, #mid #content h4 a:link, #mid #content h4 a:visited, #mid #content h4 a:active, #mid #content h5 a:link, #mid #content h5 a:visited, #mid #content h5 a:active, #mid #content h6 a:link, #mid #content h6 a:visited, #mid #content h6 a:active').css('color', to);
		});
	});
	wp.customize('wicketpixie_theme_sidebar_headings_color',function(value) {
		value.bind(function(to) {
			$('#mid #sidebar h1, #mid #sidebar h2, #mid #sidebar h3, #mid #sidebar h3 a:link, #mid #sidebar h3 a:visited, #mid #sidebar h3 a:active, #mid #sidebar h4, #mid #sidebar h5, #mid #sidebar h6').css('color', to);
		});
	});
	wp.customize('wicketpixie_theme_content_links_color',function(value) {
		value.bind(function(to) {
			$('#mid #content a:link, #mid #content a:visited, #mid #content a:active, #content .comment h3 a:link, #content .comment h3 a:active, #content .comment h3 a:visited').not('h1 a, h2 a, h3 a, h4 a, h5 a, h6 a').css('color', to);
			$('#mid a:hover, #mid h1 a:hover, #mid h2 a:hover, #mid h3 a:hover, #mid h4 a:hover, #mid h5 a:hover, #mid h6 a:hover, #mid #sidebar a:hover, #mid #sidebar h1 a:hover, #mid #sidebar h2 a:hover, #mid #sidebar h3 a:hover, #mid #sidebar h4 a:hover, #mid #sidebar h5 a:hover, #mid #sidebar h6 a:hover, #content .comment h3 a:hover').css('border-bottom', '1px solid ' + to);
		});
	});
	wp.customize('wicketpixie_theme_sidebar_links_color',function(value) {
		value.bind(function(to) {
			$('#mid #sidebar a:link, #mid #sidebar a:visited, #mid #sidebar a:active').css('color', to);
		});
	});
})(jQuery);
