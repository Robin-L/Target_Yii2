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
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1370511756292162',
                    'clientSecret' => '36b2348b026242fab903249f82b58207',
                ],
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => '822333a7293746d127ea',
                    'clientSecret' => 'ef355af4c232aacb5397443da82214089c759b61',
                ],
                // 'twitter' => [
                //     'class' => 'yii\authclient\clients\Twitter',
                //     'clientId' => 'your clinet id',
                //     'clientSecret' => 'your consumer secret'
                // ],
                // 'google' => [
                //     'class' => 'yii\authclient\clients\GoogleOAuth',
                //     'clientId' => 'your clinet id',
                //     'clientSecret' => 'your client secret',
                // ],
                // 'linkedin' => [
                //     'class' => 'yii\authclient\clients\LinkedIn',
                //     'clientId' => 'your clinet id',
                //     'clientSecret' => 'your client secret',
                // ],
            ],
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
