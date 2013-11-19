<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
chdir(__DIR__);

$s = DIRECTORY_SEPARATOR;
$configuration = dirname(__DIR__) . $s . 'application.xml';
$application = null;

if (file_exists($configuration)) {
    $application = simplexml_load_file($configuration);
}

if ($application instanceof \SimpleXMLElement) {
    putenv('ZF2_PATH=' . $application->zendframework);

    $confZF = array(
        'module_listener_options' => array(
            'module_paths' => array(),
            'config_glob_paths' => array(),
        ),
        'modules' => array()
    );

    foreach ($application->configuration->modulepaths->path as $path) {
        $confZF['module_listener_options']['module_paths'][] = "{$application->appdir}{$s}{$path}";
    }

    foreach ($application->configuration->configpaths->path as $path) {
        $confZF['module_listener_options']['config_glob_paths'][] = "{$application->appdir}{$s}config{$s}autoload{$s}{$path}";
    }
    foreach ($application->configuration->modules->module as $module) {
        $confZF['modules'][] = "$module";
    }

    define('CONF_ZF', json_encode($confZF));
} else {
    throw new Exception('application.xml is not a file.');
}
