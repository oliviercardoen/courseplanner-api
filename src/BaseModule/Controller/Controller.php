<?php
namespace CoursePlanner\BaseModule\Controller;

use Octopix\Selene\Mvc\Controller\Rest\RestController;

/**
 * Class Controller
 * @package CoursePlanner\BaseModule\Controller
 */
abstract class Controller extends RestController {

	/**
	 * Define the class of the model related to the current
	 * controller instance. Allow late binding and lightweight
	 * controllers using PHP reflexion.
	 * @var $_model_class
	 */
	protected static $_model_class;

	/**
	 * @return mixed|void
	 */
	public function index()
	{
		$data   = array();
		$class  = static::$_model_class;
		$models = $class::all();

		if ( !empty( $models ) ) {
			foreach( $models as $model ) {
				$data[] = $model->as_array();
			}
		}
		$this->render( $data );
	}

	/**
	 * @param $id
	 * @return mixed|void
	 */
	public function show( $id )
	{
		$data  = array();
		$class = static::$_model_class;
		$model = $class::find( $id );

		if ( !empty( $model ) ) {
			$data = $model->as_array();
		}
		$this->render( $data );
	}

	/**
	 * @return mixed|void
	 */
	public function create()
	{
		$class = static::$_model_class;
		$model = new $class();

		$raw   = $this->request()->getBody();

		$model->hydrate( json_decode( $raw, true ) );
		$model->save();
		$this->render( $model->as_array() );
	}

	/**
	 * @param $id
	 * @return mixed|void
	 */
	public function update( $id )
	{
		// TODO: Refactor
		print_r($this->request()->put());
		exit;
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
	public function delete( $id )
	{
		$data  = array();
		$class = static::$_model_class;
		$model = $class::find( (int) $id );

		if ( !empty( $model ) ) {
			$data = $model->as_array();
			$model->delete();
		}
		$this->render( $data );
	}


} 