<?php
$config = array(
	'db' => array(
		'host'     => 'localhost',
		'name'     => 'php_courseplanner',
		'username' => 'root',
		'password' => 'root'
	),
	'salt' => sha1( 'PHP_COURSEPLANNER_20141102' ),
	'modules' => array(
		array(
			'name'      => 'BaseModule',
			'namespace' => 'CoursePlanner\BaseModule',
			'resources' => array(
				'/ingredients/' => 'IngredientController'
			)
		),
		array(
			'name'      => 'UserModule',
			'namespace' => 'CoursePlanner\UserModule'
		),
	)
);