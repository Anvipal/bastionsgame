<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'uk',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'class' => 'common\components\i18n\I18N',
            'translations' => [
                'frontend' => [
                    'class' => '\yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages/frontend'
                ],
                'backend' => [
                    'class' => '\yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages/backend'
                ],
                'common' => [
                    'class' => '\yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages/common'
                ],
            ],
        ],
    ],
];
