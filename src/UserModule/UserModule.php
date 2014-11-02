<?php
namespace CoursePlanner\UserModule;

use CoursePlanner\UserModule\Model\User;
use Octopix\Selene\Application\Module\ApplicationModule;

class UserModule extends ApplicationModule {

	private static $user;

	/**
	 * @return mixed
	 */
	public function run()
	{
		// TODO: Implement run() method.
	}


	public static function user()
	{
		if ( !isset( self::$user ) ) {
			self::$user = new User();
		}
		return self::$user;
	}

} 