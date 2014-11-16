<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Call-board',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.models.behaviors.*',
        'application.components.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '12345',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    'components' => array(
        'user' => array(
            'class' => 'WebUser',
            'loginUrl' => array('/user/login'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '' => 'product/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=testdrive',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
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
    ),
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'image' => array(
            'maxSize' => 5, // Mb
            'savePath' => '/images/product/',
        )
    ),
);
