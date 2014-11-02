<?php
namespace CoursePlanner\BaseModule\Controller;

use CoursePlanner\BaseModule\Model\Timeslot;
use Octopix\Selene\Mvc\Controller\Controller;
use Octopix\Selene\Mvc\View\View;
use CoursePlanner\BaseModule\Model\Curriculum;

class CurriculumController extends Controller {

	/**
	 * Handle the delete action.
	 * Usually, controller will delete the entity.
	 */
	public function deleteAction()
	{
		$deleted = false;
		$message = 'Une erreur est survenue. Votre formation n\'a pas &eacute;t&eacute; supprim&eacute;.';

		$entity  = Curriculum::find( (int) $this->getRequest()->post('id') );
		$deleted = $entity->delete();

		if ( $deleted ) {
			$message = 'Votre formation a correctement &eacute;t&eacute; supprim&eacute;.';
		}

		$this->render( View::make( 'curriculums/index' , array(
			'status'    => $deleted,
			'message'   => $message,
			'title'     => 'Mes Formations',
			'entities'  => Curriculum::all()
		) ) );
	}

	/**
	 * Handle the index action.
	 * Usually, controller will fetch entities and render a list.
	 */
	public function indexAction()
	{
		$this->render( View::make( 'curriculums/index' , array(
			'title'    => 'Mes Formations',
			'entities' => Curriculum::all()
		) ) );
	}

	/**
	 * Handle the new action.
	 * Usually, the controller will display an empty form to create a new
	 * instance of a model and store in the database.
	 */
	public function newAction()
	{
		$this->render( View::make( 'curriculums/form' , array(
			'title'     => 'Ajouter une formation',
			'timeslots' => Timeslot::all()
		) ) );
	}

	/**
	 * Handle the show action.
	 * Usually, controller will fetch one record and render the entity.
	 * @param array $vars
	 */
	public function showAction($id)
	{
		$entity   = Curriculum::find( $id );
		$this->render( View::make( 'curriculums/show', array(
			'title'    => $entity->name,
			'entity'   => $entity,
			'timeslot' => $entity->timeslot(),
			'courses'  => $entity->courses()
		) ) );
	}

	/**
	 * Handle the edit action.
	 * Usually, controller will fetch one record, render the entity
	 * and the form to edit the rendered entity.
	 */
	public function editAction($id)
	{
		$curriculum = Curriculum::find( $id );
		$this->render( View::make( 'curriculums/form' , array(
			'title'     => sprintf( 'Modifier "%s"', $curriculum->name ),
			'entity'    => $curriculum,
			'timeslots' => Timeslot::all()
		) ) );
	}

	/**
	 * Handle the save action.
	 * Usually, controller will persist the current entity.
	 */
	public function saveAction()
	{
		$saved = false;
		$message = 'Une erreur est survenue. Votre cours n\'a pas &eacute;t&eacute; enregistr&eacute;.';

		$curriculum = new Curriculum();
		$curriculum->id = (int) $this->getRequest()->post('id');
		$curriculum->name = $this->getRequest()->post('name');
		$curriculum->timeslot_id = (int) $this->getRequest()->post('timeslot_id');

		if ( !empty( $curriculum->timeslot_id ) ) {
			$saved = $curriculum->save();
			if ( $saved ) {
				$message = 'Votre cours a correctement &eacute;t&eacute; enregistr&eacute;.';
			}
		} else {
			$message = 'Une erreur est survenue. Veuillez s&eacute;lectionner une p&eacute;riode.';
		}

		$this->render( View::make( 'curriculums/show' , array(
			'status'  => $saved,
			'message' => $message,
			'title'   => $curriculum->name,
			'entity'  => $curriculum,
			'courses' => $curriculum->courses()
		) ) );
	}

} 