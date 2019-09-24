<?php
return [
    'params' => [
        'adminEmail' => 'usp.app@lau.edu',
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=erp',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'fs' => [
            'class' => '\app\components\DropboxShell',
            'path' => '/pjt/',
            'accessToken' => 'q1yPqhd2J6gAAAAAAAAFdeH7qrNKFgX3KlurfP6BcVOXGULNMSn5cbFYR_SXEI3Q',
            'clientSecret' => 'znt2xznja84k15k',
            'clientId' => 'y7974d42350da0o',
        ]
    ]
];


