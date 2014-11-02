<?php
namespace CoursePlanner\BaseModule\Controller;

use CoursePlanner\BaseModule\Model\School;
use Octopix\Selene\Form\Input\Input;
use Octopix\Selene\Mvc\Controller\Controller;
use Octopix\Selene\Mvc\View\View;

class SchoolController extends Controller {

	/**
	 * Handle the index action.
	 * Usually, controller will fetch entities and render a list.
	 */
	public function indexAction()
	{
		$this->render( View::make( 'schools/index' , array(
			'title'     => 'Mes &Eacute;coles',
			'entities'  => School::all()
		) ) );
	}

	/**
	 * Handle the new action.
	 * Usually, the controller will display an empty form to create a new
	 * instance of a model and store in the database.
	 */
	public function newAction()
	{
		$this->render( View::make( 'schools/form' , array(
			'title'   => 'Ajouter une nouvelle &eacute;cole'
		) ) );
	}

	/**
	 * Handle the show action.
	 * Usually, controller will fetch one record and render the entity.
	 * @param array $vars
	 */
	public function showAction($id)
	{
		$school = School::find( $id );
		$this->render( View::make( 'schools/show', array(
			'title'     => $school->name,
			'entity'    => $school,
			'locations' => $school->locations()
		) ) );
	}

	/**
	 * Handle the edit action.
	 * Usually, controller will fetch one record, render the entity
	 * and the form to edit the rendered entity.
	 */
	public function editAction($id)
	{
		$school = School::find( $id );
		$this->render( View::make( 'schools/form' , array(
			'title'  => sprintf( 'Modifier "%s"', $school->name ),
			'entity' => $school
		) ) );
	}

	/**
	 * Handle the save action.
	 * Usually, controller will persist the current entity.
	 */
	public function saveAction()
	{
		$message = 'Une erreur est survenue. Votre &eacute;cole n\'a pas &eacute;t&eacute; enregistr&eacute;.';

		$school = new School();
		$school->id = (int) $this->getRequest()->post('id');
		$school->name = Input::safe( $this->getRequest()->post('name') );
		$saved = $school->save();

		if ( $saved ) {
			$message = 'Votre &eacute;cole a correctement &eacute;t&eacute; enregistr&eacute;.';
		}
		$this->render( View::make( 'schools/show' , array(
			'status'  => $saved,
			'message' => $message,
			'title'   => $school->name,
			'entity'  => $school
		) ) );
	}

	/**
	 * Handle the delete action [POST|DELETE].
	 * Usually, controller will delete the entity.
	 */
	public function deleteAction()
	{
		$message = 'Une erreur est survenue. Votre &eacute;cole n\'a pas été supprimé.';

		$school = School::find( (int) $this->getRequest()->post('id') );
		$deleted = $school->delete();

		if ( $deleted ) {
			$message = 'Votre &eacute; a correctement été supprimé.';
		}
		$this->render( View::make( 'schools/index' , array(
			'status'   => $deleted,
			'message'  => $message,
			'title'    => 'Mes &Eacute;coles',
			'entities' => School::all()
		) ) );
	}

} 