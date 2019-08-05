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
	// 'helpers/currency.js',
	'helpers/input.js',
	'helpers/upload.js',
	'common.js'
);

$config['application_version'] = '';
$config['application_uri_prefix'] = ''; // Admin esetén pl: admin/, public esetén üres.
$config['application_asset_folder'] = 'public';
$config['application_use_multilang'] = true; // Többnyelvű-e az oldal.
$config['application_language_storage'] = 'URL'; // URL | SESSION
$config['application_language_segment_no'] = 1; // Hányadik a nyelvi file az URI-ban
$config['application_default_language_key'] = 'hu';
$config['languages'] = array(
	'hu'=>array(
		'key'=>'hu',
		'folder'=>'hungarian',
		'date_format_full'=>'Y-m-d',
		'date_format_full_js'=>'yyyy-mm-dd',
		'time_format_short'=>'H:i',
		'time_format_long'=>'H:i:s',
		'datetime_format_full'=>'Y-m-d H:i:s',
		'user_name_order'=>'LF',
	),
	'en'=>array(
		'key'=>'en',
		'folder'=>'english',
		'date_format_full'=>'d/m/Y',
		'date_format_full_js'=>'dd/mm/yyyy',
		'time_format_short'=>'H:i',
		'time_format_long'=>'H:i:s',
		'datetime_format_full'=>'d/m/Y H:i:s',
		'user_name_order'=>'FL',
	),
	/*'de'=>array(
		'key'=>'de',
		'folder'=>'deusch',
		'date_format_full'=>'d/m/Y',
		'date_format_month'=>'m/Y',
		'time_format_short'=>'H:i',
    'datetime_format_full'=>'d/m/Y H:i:s',
		'time_format_long'=>'H:i:s',
    'user_name_order'=>'FL',
),*/
);
$config['application_default_currency_key'] = 'huf';
$config['currencies'] = array(
	'huf'=>array(
		'key'=>'huf',
		'label'=>'Ft.',
		'format'=>':value: :label:',
		'number_format'=>array(
			'thousend_delimiter'=>' ',
			'decimal_delimiter'=>',',
			'decimals'=> 4
		),
	),
	'eur'=>array(
		'key'=>'eur',
		'label'=>'€',
		'format'=>':label::value:',
		'number_format'=>array(
			'thousend_delimiter'=>' ',
			'decimal_delimiter'=>'.',
			'decimals'=>2
		),
	),
	'usd'=>array(
		'key'=>'usd',
		'label'=>'$',
		'format'=>':label::value:',
		'number_format'=>array(
			'thousend_delimiter'=>'.',
			'decimal_delimiter'=>',',
			'decimals'=>2
		),
	),
);