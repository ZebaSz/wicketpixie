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
			$('#logo, .content h1, .content h2, .content h3, .content h4, .content h5, .content h6, #sidebar h1, #sidebar h2, #sidebar h3, #sidebar h4, #sidebar h5, #sidebar h6').css('font-family', to);
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
			$('.content h1, .content h2, .content h3, .content h4, .content h5, .content h6, .content h1 a:link, .content h1 a:visited, .content h1 a:active, .content h2 a:link, .content h2 a:visited, .content h2 a:active, .content h3 a:link, .content h3 a:visited, .content h3 a:active, .content h4 a:link, .content h4 a:visited, .content h4 a:active, .content h5 a:link, .content h5 a:visited, .content h5 a:active, .content h6 a:link, .content h6 a:visited, .content h6 a:active').css('color', to);
		});
	});
	wp.customize('wicketpixie_theme_sidebar_headings_color',function(value) {
		value.bind(function(to) {
			$('#sidebar h1, #sidebar h2, #sidebar h3, #sidebar h3 a:link, #sidebar h3 a:visited, #sidebar h3 a:active, #sidebar h4, #sidebar h5, #sidebar h6').css('color', to);
		});
	});
	wp.customize('wicketpixie_theme_content_links_color',function(value) {
		value.bind(function(to) {
			$('.content a:link, .content a:visited, .content a:active, #content .comment h3 a:link, #content .comment h3 a:active, #content .comment h3 a:visited').css('color', to);
			$('.content a:hover, #content .comment h3 a:hover').css('border-bottom', '1px solid ' + to);
		});
	});
	wp.customize('wicketpixie_theme_sidebar_links_color',function(value) {
		value.bind(function(to) {
			$('#sidebar a:link, #sidebar a:visited, #sidebar a:active').css('color', to);
		});
	});
})(jQuery);
