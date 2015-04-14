<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(

	'language'=>'pt_br',
	'defaultController' => 'site/login/',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'EMVIPOL',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.phpass*',
	),

	/*
	'behaviors' => array(
		'onBeginRequest' => array(
			'class' => 'application.components.RequireLogin'
		),
	),
	*/

	'modules'=>array(
		
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password' => 'emvipol',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters' => array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(

/*		'hasher'=>array(
			'class'=>'ext.phpass.Phpass',
			'hashPortable'=>false,
			'hashCostLog2'=>10,
		),*/


		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=emvipol',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'admin',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(

			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				/*				
				array(
	                'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
	                'ipFilters'=>array('127.0.0.1','192.168.1.215'),
            	),*/

				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'andrewillams@gmail.com',
		'dbconf' => array(
			'dns'=>'mysql:host=localhost;dbname=emvipol;charset=utf8',
			'user'=>'root',
			'pass'=>'admin'
		),
	),

	
);