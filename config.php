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
				'/courses/'          => 'CourseController',
				'/curriculums/'      => 'CurriculumController',
				'/schools/'          => 'SchoolController',
				'/school-locations/' => 'SchoolLocationController',
				'/countries/'        => 'CountryController',
				'/timeslots/'        => 'TimeslotController',
				'/addresses/'        => 'AddressController'
			)
		),
		array(
			'name'      => 'UserModule',
			'namespace' => 'CoursePlanner\UserModule'
		),
	)
);