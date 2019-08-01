<?php
	$config['global'] = array();
	$config['global']['appis'] = new stdClass();
	$config['global']['appis']->fb = '';				// fb api key
	$config['global']['appis']->tagmanager = '';				// Tag manager api key
	$config['global']['appis']->google_fonts = '';				// google fonts
	$config['global']['meta'] = array(
									'title' => '',
									'favicon' => (object) array(
													'type' => 'image/png',
													'src' => ''
													),
									'author' => '',
									'keywords' => '',
									'description' => '',
									'fb:app_id' => $config['global']['appis']->fb,
									'og:title' => '',
									'og:description' => '',
									'og:url' => '',
									'og:type' => '',
									'og:image' => '',
									);
	$config['global']['css'] = array(
								(object) array('name' => 'all.css', 'key' => '', 'path' => ':base_urlplugins/fontawesome_v5.5/css/'),
								'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
								'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/css/bootstrap-select.min.css',
								'common.css'
							);

	$config['global']['js'] = array(
								'https://cdn.jsdelivr.net/jquery/latest/jquery.min.js',
								'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
								'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
								'https://cdn.jsdelivr.net/npm/vue/dist/vue.js',
								'helpers/ajax.js',
								'helpers/input.js',
								'helpers/upload.js',
								'common.js'
							);