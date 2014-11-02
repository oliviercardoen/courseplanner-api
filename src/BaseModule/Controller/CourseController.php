<?php
namespace CoursePlanner\BaseModule\Controller;

use Octopix\Selene\Mvc\Controller\Rest\RestController;
use CoursePlanner\BaseModule\Model\Course;
use Octopix\Selene\Mvc\Model\ModelArray;

class CourseController extends RestController {

	/**
	 *
	 */
	public function index()
	{
		$this->render( ModelArray::each( Course::all() ) );
	}

	/**
	 * @param $id
	 * @return mixed|void
	 */
	public function show($id)
	{
		$this->render( ModelArray::one( Course::find( (int) $id ) ) );
	}

	/**
	 *
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
	 * @param $id
	 * @return mixed|void
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
	 * @param $id
	 * @return mixed|void
	 */
	public function delete($id)
	{
		$this->render( array(
			'deleted' => Course::find( (int) $id )->delete()
		) );
	}

}