<?php
namespace App;

use CoursePlanner\UserModule\UserModule;
use Octopix\Selene\Application\Application;

/**
 * Define application specific logic.
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

	public function render_message( $message )
	{
		header( 'Content-type: application/json' );
		echo json_encode( array(
			'message' => $message
		) );
		exit;
	}

	/**
	 * Register routes that have not been dynamically defined based on the config.php
	 * file.
	 */
	public function registerRoutes()
	{
		/* Index route */
		$this->router->get( '/', function() {
			$this->render_message( 'You are not authorized to view this resource.' );
		});

		$this->router->post( '/', function() {
			$this->render_message( 'You are not authorized to view this resource.' );
		});

		/* Not found handler */
		$this->router->notFound( function() {
			$this->render_message( 'This resource does not exist or has been moved permanently.' );
		});
	}

} 