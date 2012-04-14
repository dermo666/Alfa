<?php
return array(
    'modules' => array(
        'Application',
        'ZendSkeletonModule',    
        'Invoice',
        'Messaging',    
    ),
    'module_listener_options' => array( 
        'config_cache_enabled'     => false,
        'cache_dir'                => realpath(__DIR__ . '/../data/cache'),
    		'module_paths' => array(
    				realpath(__DIR__ . '/../module'),
    				realpath(__DIR__ . '/../vendor'),
    		),
    ),
);
