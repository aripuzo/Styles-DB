<?php

return [

	/*
		    |--------------------------------------------------------------------------
		    | Facebook Token
		    |--------------------------------------------------------------------------
		    |
		    | Your Facebook application you received after creating
		    | the messenger page / application on Facebook.
		    |
	*/
	'token' => env('FACEBOOK_TOKEN'),

	/*
		    |--------------------------------------------------------------------------
		    | Facebook App Secret
		    |--------------------------------------------------------------------------
		    |
		    | Your Facebook application secret, which is used to verify
		    | incoming requests from Facebook.
		    |
	*/
	'app_secret' => env('FACEBOOK_APP_SECRET'),

	/*
		    |--------------------------------------------------------------------------
		    | Facebook Verification
		    |--------------------------------------------------------------------------
		    |
		    | Your Facebook verification token, used to validate the webhooks.
		    |
	*/
	'verification' => env('FACEBOOK_VERIFICATION'),

	/*
		    |--------------------------------------------------------------------------
		    | Facebook Start Button Payload
		    |--------------------------------------------------------------------------
		    |
		    | The payload which is sent when the Get Started Button is clicked.
		    |
	*/
	'start_button_payload' => 'GET_STARTED',

	/*
		    |--------------------------------------------------------------------------
		    | Facebook Greeting Text
		    |--------------------------------------------------------------------------
		    |
		    | Your Facebook Greeting Text which will be shown on your message start screen.
		    |
	*/
	'greeting_text' => [
		'greeting' => [
			[
				'locale' => 'default',
				'text' => 'Get latest traditional styles to take to your tailor.',
			],
			[
				'locale' => 'en_US',
				'text' => 'Get latest traditional styles to take to your tailor.',
			],
		],
	],

	/*
		    |--------------------------------------------------------------------------
		    | Facebook Persistent Menu
		    |--------------------------------------------------------------------------
		    |
		    | Example items for your persistent Facebook menu.
		    |
	*/
	'persistent_menu' => [
		[
			'locale' => 'default',
			'composer_input_disabled' => 'true',
			'call_to_actions' => [
				[
					'title' => 'Category',
					'type' => 'nested',
					'call_to_actions' => [
						[
							'type' => 'web_url',
							'title' => 'Men Styles',
							'url' => 'https://shakara.ng/catalogue/men',
							'webview_height_ratio' => 'full',
						],
						[
							'type' => 'web_url',
							'title' => 'Women Styles',
							'url' => 'https://shakara.ng/catalogue/women',
							'webview_height_ratio' => 'full',
						],
						[
							'type' => 'web_url',
							'title' => 'Kid Styles',
							'url' => 'https://shakara.ng/catalogue/kids',
							'webview_height_ratio' => 'full',
						],
					],
				],
				[
					'type' => 'web_url',
					'title' => 'Latest Styles',
					'url' => 'https://shakara.ng?sort=latest',
					'webview_height_ratio' => 'full',
				],
				[
					'type' => 'web_url',
					'title' => 'Popular Styles',
					'url' => 'https://shakara.ng?sort=popular',
					'webview_height_ratio' => 'full',
				],
			],
		],
	],

	/*
		    |--------------------------------------------------------------------------
		    | Facebook Domain Whitelist
		    |--------------------------------------------------------------------------
		    |
		    | In order to use domains you need to whitelist them
		    |
	*/
	'whitelisted_domains' => [
		'https://shakara.ng',
	],
];
