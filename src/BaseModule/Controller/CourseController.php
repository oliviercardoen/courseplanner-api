<?php
namespace CoursePlanner\BaseModule\Controller;

use Octopix\Selene\Form\Input\Input;
use Octopix\Selene\Mvc\Controller\Rest\RestController;
use CoursePlanner\BaseModule\Model\Course;

class CourseController extends RestController {

	/**
	 * Handle the index action.
	 * Usually, controller will fetch entities and render a list.
	 */
	public function index()
	{
		$this->render( Course::all() );
	}

	/**
	 * Handle the show action.
	 * Usually, controller will fetch one record and render the entity.
	 * @param array $vars
	 */
	public function show($id)
	{
		$this->render( Course::find( (int) $id ) );
	}

	/**
	 * Handle the save action.
	 * Usually, controller will persist the current entity.
	 */
	public function create()
	{
		$raw  = $this->getRequest()->getBody();
		$data = json_decode( $raw, true );

		$course = new Course();
		$course->id = (int) $data['id'];
		$course->name = Input::safe( $data['name'] );
		$course->code = Input::safe( $data['code'] );
		$course->start_date = Input::safe( $data['start_date'] );
		$course->end_date = Input::safe( $data['end_date'] );
		$course->reference_document = Input::safe( $data['reference_document'] );
		$course->save();

		$this->render( $course );
	}

	/**
	 * Handle the save action.
	 * Usually, controller will persist the current entity.
	 */
	public function update($id)
	{
		$raw  = $this->getRequest()->getBody();
		$data = json_decode( $raw, true );

		$course = Course::find( (int) $id );
		$course->name = Input::safe( $data['name'] );
		$course->code = Input::safe( $data['code'] );
		$course->start_date = Input::safe( $data['start_date'] );
		$course->end_date = Input::safe( $data['end_date'] );
		$course->reference_document = Input::safe( $data['reference_document'] );
		$course->save();

		$this->render( $course );
	}

	/**
	 * Handle the delete action [POST|DELETE].
	 * Usually, controller will delete the entity.
	 */
	public function delete($id)
	{
		$this->render( array(
			'deleted' => Course::find( (int) $id )->delete()
		) );
	}

}