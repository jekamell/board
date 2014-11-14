<?php
$config = array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    'preload' => array('log'),
    'components' => array(
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
);

$configLocal = dirname(__FILE__) . '/local.php';

if (is_file($configLocal)) {
    $config = CMap::mergeArray($config, require($configLocal));
}

return $config;