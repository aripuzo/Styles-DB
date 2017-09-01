<?php

return [
	'meta' => [
		/*
			         * The default configurations to be used by the meta generator.
		*/
		'defaults' => [
			'title' => env('APP_NAME'), // set false to total remove
			'description' => 'See latest aso ebi and native styles in ankara, lace etc from the best tailors and designers in Nigeria. Get trending styles for your next visit to the tailor', // set false to total remove
			'separator' => ' - ',
			'keywords' => ['styles', 'ankara', 'native', 'aso-ebi', 'tailor', 'sew', 'agbada', 'senator', 'lace', 'iro and buba', 'church outfit', 'african attire', 'aso ebi', 'fashion styles', 'kids fashion', 'tailor', 'tailor in Nigeria', 'aso ebi', 'style magazine'],
			'canonical' => null, // Set null for using Url::current(), set false to total remove
		],

		/*
			         * Webmaster tags are always added.
		*/
		'webmaster_tags' => [
			'google' => null,
			'bing' => null,
			'alexa' => null,
			'pinterest' => null,
			'yandex' => null,
		],
	],
	'opengraph' => [
		/*
			         * The default configurations to be used by the opengraph generator.
		*/
		'defaults' => [
			'title' => env('APP_NAME'), // set false to total remove
			'description' => 'See latest aso ebi and native styles from the best tailors and designers in Nigeria. Get trending styles for your next visit to the tailor', // set false to total remove
			'url' => null, // Set null for using Url::current(), set false to total remove
			'type' => 'website',
			'site_name' => env('APP_SITE_NAME'),
			'images' => [],
			'locale' => 'pt-br',
			'locale:alternate' => ['pt-pt', 'en-us'],
		],
	],
	'twitter' => [
		/*
			         * The default values to be used by the twitter cards generator.
		*/
		'defaults' => [
			'card' => 'summary',
			'site' => '@shakaradotng',
			'url' => env('APP_URL'),
			'description' => 'See latest aso ebi and native styles in ankara, lace etc from the best tailors and designers in Nigeria. Get trending styles for your next visit to the tailor',
		],
	],
];
