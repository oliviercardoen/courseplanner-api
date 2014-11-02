<?php
namespace CoursePlanner\BaseModule\Controller;

use CoursePlanner\BaseModule\Model\Address;
use CoursePlanner\BaseModule\Model\Country;
use CoursePlanner\BaseModule\Model\School;
use CoursePlanner\BaseModule\Model\SchoolLocation;
use Octopix\Selene\Mvc\Controller\Controller;
use Octopix\Selene\Mvc\View\View;
use Octopix\Selene\Form\Input\Input;

class SchoolLocationController extends Controller {

	/**
	 * Handle the index action.
	 * Usually, controller will fetch entities and render a list.
	 */
	public function indexAction() {}

	/**
	 * Handle the new action.
	 * Usually, the controller will display an empty form to create a new
	 * instance of a model and store in the database.
	 */
	public function newAction()
	{
		$this->render( View::make( 'schools/locations/form' , array(
			'title'   => 'Ajouter une nouvelle implantation',
			'school_id' => (int) $this->getRequest()->get( 'school_id' )
		) ) );
	}

	/**
	 * Handle the show action.
	 * Usually, controller will fetch one record and render the entity.
	 * @param array $vars
	 */
	public function showAction($id)
	{
		$location = SchoolLocation::find( $id );
		$this->render( View::make( 'schools/locations/show', array(
			'title'   => $location->name,
			'entity'  => $location,
			'address' => $location->address(),
			'country' => Country::find( $location->address()->country_id )
		) ) );
	}

	/**
	 * Handle the edit action.
	 * Usually, controller will fetch one record, render the entity
	 * and the form to edit the rendered entity.
	 */
	public function editAction($id)
	{
		$location = SchoolLocation::find( $id );
		$this->render( View::make( 'schools/locations/form' , array(
			'title'     => sprintf( 'Modifier "%s"', $location->name ),
			'entity'    => $location,
			'address'   => $location->address(),
			'countries' => Country::all()
		) ) );
	}

	/**
	 * Handle the save action.
	 * Usually, controller will persist the current entity.
	 */
	public function saveAction()
	{
		$message = 'Une erreur est survenue. Votre implantation n\'a pas &eacute;t&eacute; enregistr&eacute;.';

		$location = new SchoolLocation();
		$location->id = (int) $this->getRequest()->post('id');
		$location->school_id = (int) $this->getRequest()->post('school_id');
		$location->name = Input::safe( $this->getRequest()->post('name') );
		$saved = $location->save();

		if ( $saved ) {
			$message = 'Votre implantation a correctement &eacute;t&eacute; enregistr&eacute;.';
			$address = new Address();
			$address->street = Input::safe( $this->getRequest()->post('address_street') );
			$address->city = Input::safe( $this->getRequest()->post('address_city') );
			$address->zipcode = Input::safe( $this->getRequest()->post('address_zipcode') );
			$address->country_id = (int) $this->getRequest()->post('address_country_id');
			$address->school_location_id = $location->id;
			$address->save();
		}
		$this->render( View::make( 'schools/locations/show', array(
			'status'  => $saved,
			'message' => $message,
			'title'   => $location->name,
			'entity'  => $location,
			'address' => $location->address(),
			'country' => Country::find( $location->address()->country_id )
		) ) );
	}

	/**
	 * Handle the delete action [POST|DELETE].
	 * Usually, controller will delete the entity.
	 */
	public function deleteAction()
	{
		$message = 'Une erreur est survenue. Votre implantation n\'a pas été supprimé.';

		$location = SchoolLocation::find( (int) $this->getRequest()->post('id') );
		$school = School::find( $location->school_id );
		$deleted = $location->delete();

		if ( $deleted ) {
			$message = 'Votre implantation a correctement &eacute;t&eacute; supprim&eacute;.';
		}
		$this->render( View::make( 'schools/show' , array(
			'status'  => $deleted,
			'message' => $message,
			'title'   => $school->name,
			'entity'  => $school
		) ) );
	}

} 