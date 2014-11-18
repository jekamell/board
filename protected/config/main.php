<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Call-board',
    'language' => 'en',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.models.behaviors.*',
        'application.components.*',
        'application.components.filters.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '12345',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'api' => array(
        ),
    ),
    'components' => array(
        'user' => array(
            'class' => 'WebUser',
            'loginUrl' => array('/user/login'),
        ),
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => '/js/jq/jquery.js',
                'jquery.min.js' => '/js/jq/jquery.min.js',
            ),
            'coreScriptPosition' => CClientScript::POS_HEAD,
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=testdrive',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ),
        'messages' => array(

        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'product/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
        'ih' => array(
            'class' => 'ext.CImageHandler.CImageHandler',
        ),
        'userMailer' => array(
            'class'    => 'application.components.UserMailer',
            'host'     => '',
            'port'     => 0,
            'login'    => '',
            'password' => '',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '' => 'product/index',

                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>/<id>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',

                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

            ),
        ),
    ),
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'noreplyEmail' => 'no-reply@example.com',
        'image' => array(
            'maxSize' => 5, // Mb
            'savePath' => '/images/product/',
            'thumb' => array(
                'width' => 200,
                'height' => 200,
            )
        )
    ),
);
