<?php
namespace App;

use CoursePlanner\UserModule\UserModule;
use Octopix\Selene\Application\Application;

/**
 * App specific logic.
 * Class App
 * @package App
 */
class App extends Application {

	/**
	 * Create a static instance of a user model to be used across the whole app. This instance
	 * manage data from the logged in user during session.
	 * @return \CoursePlanner\UserModule\Model\User
	 */
	public static function user()
	{
		return UserModule::user();
	}

	/**
	 * Register routes that have not been dynamically defined based on the config.php
	 * file.
	 */
	public function registerRoutes()
	{
		/* Index route */
		$this->router->get( '/', function() {
			header( 'Content-type: application/json' );
			echo json_encode( array(
				'message' => 'You are not authorized to view this resource.'
			) );
			exit;
		});

		$this->router->post( '/', function() {
			$user = self::user();
			header( 'Content-type: application/json' );
			echo json_encode( array(
				'message' => 'You are not authorized to view this resource.'
			) );
			exit;
		});

		/* Not found handler */
		$this->router->notFound( function() {
			echo json_encode( array(
				'message' => array(
					'This resource does not exist or has been moved permanently.'
				)
			) );
			exit;
		});
	}

} 