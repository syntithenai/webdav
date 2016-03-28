<?php

Config::set('webdav', array(
	'version' => '0.0.1',
    'active' => true,
    'path' => 'system/modules',
    'topmenu' => true,
	'availableObjects' => ['Wiki'=>[],'TaskGroup'=>[],'Task'=>[],'User'=>[] ],
    'dependencies' => array(
        "sabre/dav" => "~3.1.2"
    )
));
