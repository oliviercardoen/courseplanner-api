<?php
namespace CoursePlanner\AuthenticationModule\Controller;

use App\App;
use CoursePlanner\AuthenticationModule\Model\User;
use CoursePlanner\BaseModule\Model\Curriculum;
use Octopix\Selene\Form\Input\Input;
use Octopix\Selene\Mvc\Controller\Controller;
use Octopix\Selene\Mvc\View\View;
use CoursePlanner\BaseModule\Model\Course;

class UserController extends Controller {

	/**
	 * Handle the authenticate action.
	 * Authenticate user from given email and password.
	 */
	public function authenticateAction()
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
	public function logoutAction()
	{
		App::user()->logout();
		$this->render( View::make( 'users/forms/login', array(
			'title' => 'Connexion'
		) ) );
	}

	public function profileAction()
	{
		$this->render( View::make( 'users/show', array(
			'title'  => App::user()->fullname(),
			'entity' => App::user()
		) ) );
	}

	/**
	 * Handle the delete action.
	 * Usually, controller will delete the entity.
	 */
	public function deleteAction() {}

	/**
	 * Handle the index action.
	 * Usually, controller will fetch entities and render a list.
	 */
	public function indexAction()
	{
		$this->render( View::make( 'users/forms/register' , array(
			'title'   => 'Nouvelle inscription pour Course Planner'
		) ) );
	}

	/**
	 * Handle the new action.
	 * Usually, the controller will display an empty form to create a new
	 * instance of a model and store in the database.
	 */
	public function newAction() {}

	/**
	 * Handle the show action.
	 * Usually, controller will fetch one record and render the entity.
	 * @param array $vars
	 */
	public function showAction($id) {}

	/**
	 * Handle the edit action.
	 * Usually, controller will fetch one record, render the entity
	 * and the form to edit the rendered entity.
	 */
	public function editAction($id) {}

	/**
	 * Handle the save action.
	 * Persist new user to perform registration.
	 */
	public function saveAction()
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