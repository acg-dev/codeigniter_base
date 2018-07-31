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
								'fontawesome-all.css', 
								'common.css'
							);

	$config['global']['js'] = array(
								'common.js'
							);