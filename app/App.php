<?php
namespace App;

use CoursePlanner\AuthenticationModule\AuthenticationModule;
use CoursePlanner\AuthenticationModule\Model\User;
use CoursePlanner\BaseModule\BaseModule;
use CoursePlanner\BaseModule\Controller\CourseController;
use Octopix\Selene\Application\Application;

/**
 * Class App
 * @package App
 */
class App extends Application {

	/**
	 * @param array $args
	 */
	public function __construct( $args = array() )
	{
		parent::__construct( $args );
	}

	/**
	 * @return \Erp\UserModule\Model\User
	 */
	public static function user()
	{
		return UserModule::user();
	}

	/**
	 *
	 */
	public function registerRoutes()
	{
		$controllers = array();

		// @refactor: Laravel 4: Route::resource('tasks', 'TasksController');

		$controllers['course']     = new CourseController( $this );
//		$controllers['curriculum'] = new CurriculumController( $this );
//		$controllers['user']       = new UserController( $this );
//		$controllers['school']     = new SchoolController( $this );
//		$controllers['school_location'] = new SchoolLocationController( $this );

		/* Index route */
		$this->router->get( '/', function() {
			$user = self::user();
			header( 'Content-type: application/json' );
			echo json_encode( array(
				'message' => array(
					'You are not authorized to view this resource.'
				)
			) );
			exit;
		});

		/* Not found handler */
		$this->router->notFound( function() {
			echo 'This resource does not exist or has been moved permanently.';
			exit;
		});
	}

} 