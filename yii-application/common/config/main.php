<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mycomponent' => [
        	'class' => 'components\MyComponent',
        ],
        'faqwidget'	=> [
        	'class' => 'components\FaqWidget',
        ],
    ],
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'modules' => [
    	'social' => [
    		'class' => 'kartik\social\Module',
    		'disqus'=> [
    			'settings' => ['shortname' => 'DISQUS_SHORTNAME']
    		],
    		'facebook' => [
    			'appId'	=> 'your id',
    			'secret'=> 'your secret',
    		],
    		'google' => [
    			'clientId'	=> 'GOOGLE_API_CLIENT_ID',
    			'pageId'	=> 'GOOGLE_PLUS_PAGE_ID',
    			'profileId' => 'GOOGLE_PLUS_PROFILE_ID',
    		],
    		'googleAnalytics' => [
    			'id'	=> 'TRACKING_ID',
    			'domain'=> 'TRAKING_DOMAIN',
    		],
    		'twitter' => [
    			'screenName' => 'TWITTER_SCREEN_NAME'
    		],
    	]
    ],
];
