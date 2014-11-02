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
		$raw  = $this->request()->getBody();
		$model = new Course();
		$model->hydrate( json_decode( $raw, true ) );
		$model->save();
		$this->render( $model->as_array() );
	}

	/**
	 * @param $id
	 * @return mixed|void
	 */
	public function update($id)
	{
		$raw  = $this->request()->getBody();
		$model = Course::find( (int) $id );
		if ( empty( $model ) ) {
			$model = new Course();
		}
		$model->hydrate( json_decode( $raw, true ) );
		$model->save();
		$this->render( $model->as_array() );
	}

	/**
	 * @param $id
	 * @return mixed|void
	 */
	public function delete($id)
	{
		$model = Course::find( (int) $id );
		if ( !empty( $model ) ) {
			// TODO: Breaks because related to curriculum (SQL Constraint).
			$model->delete();
			$this->render( $model->as_array() );
		}
	}

}