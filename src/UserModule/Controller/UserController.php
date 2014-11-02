<?php
namespace CoursePlanner\UserModule\Controller;

use App\App;
use CoursePlanner\UserModule\Model\User;
use Octopix\Selene\Form\Input\Input;
use Octopix\Selene\Mvc\Controller\Controller;
use Octopix\Selene\Mvc\View\View;

class UserController extends Controller {

	/**
	 * Handle the authenticate action.
	 * Authenticate user from given email and password.
	 */
	public function login()
	{
		$user = new User();
		$user->email = Input::safe( $this->getRequest()->post('user_email') );
		$user->password = sha1( App::salt() . Input::safe( $this->getRequest()->post('user_password') ) );
		$authenticated = $user->authenticate();

		if ( $authenticated ) {
			$this->render( View::make( 'index' , array(
				'status'  => $authenticated,
				'message' => 'Bravo! Vous &ecirc;tes d&eacute;sormais connect&eacute;(e).',
				'title'   => sprintf( 'Bienvenue, %s!', $user->firstname ),
				'content' => '<p class="lead">Vous allez découvrir Course Planner. Le premier logiciel web de gestion de votre agenda de cours.</p>'
			) ) );
		}
		$this->render( View::make( 'index' , array(
			'status'  => $authenticated,
			'message' => 'Une erreur est survenue. Vos informations de connexion sont incorrectes.',
			'content' => View::make( 'users/forms/login', array(
				'title' => 'Connexion'
			) )
		) ) );
	}

	/**
	 * Handle the logout action.
	 * Delete the current session and redirect to login form.
	 */
	public function logout()
	{
		App::user()->logout();
		$this->render( View::make( 'users/forms/login', array(
			'title' => 'Connexion'
		) ) );
	}

	/**
	 *
	 */
	public function profile()
	{
		$this->render( View::make( 'users/show', array(
			'title'  => App::user()->fullname(),
			'entity' => App::user()
		) ) );
	}

	/**
	 * Handle the index action.
	 * Usually, controller will fetch entities and render a list.
	 */
	public function index()
	{
		$this->render( View::make( 'users/forms/register' , array(
			'title'   => 'Nouvelle inscription pour Course Planner'
		) ) );
	}

	/**
	 * Handle the save action.
	 * Persist new user to perform registration.
	 */
	public function register()
	{
		$message = 'Votre inscription n\'a pas &eacute;t&eacute; enregistr&eacute; car %s.';

		$user = new User();
		$user->firstname = Input::safe( $this->getRequest()->post('firstname') );
		$user->lastname = Input::safe( $this->getRequest()->post('lastname') );
		$user->email = Input::safe( $this->getRequest()->post('email') );
		$user->password = Input::safe( $this->getRequest()->post('password') );
		$saved = $user->save();

		if ( $saved ) {
			$message = 'Votre inscription a correctement &eacute;t&eacute; enregistr&eacute;.';
			$this->render( View::make( 'index' , array(
				'status'  => $saved,
				'message' => $message,
				'title'   => sprintf( 'Bravo, %s!', $user->firstname ),
				'content' => sprintf( '<p class="lead">Vous venez de cr&eacute;er un compte sur Course Planner. Vous pouvez d&eacute;sormais vous <a href="%s">connecter</a>.</p>', App::url( 'home' ) )
			) ) );
		}
		$this->render( View::make( 'users/forms/register' , array(
			'status'  => $saved,
			'message' => sprintf( $message, 'votre email existe d&eacute;j&agrave; dans notre base de donn&eacute;es' ),
			'title'   => 'Nouvelle inscription pour Course Planner'
		) ) );
	}

} 