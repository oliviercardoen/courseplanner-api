<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;
use Octopix\Selene\Mvc\Model\ModelArray;

class Course extends Model {

	protected $curriculums;

	public function hydrate( $data )
	{
		if ( !empty( $data ) ) {
			exit( print_r( $data, true ));
			if ( isset( $data->id ) ) {
				$this->id = (int) $data->id;
			}
			$this->name               = $data->name;
			$this->start_date         = $data->start_date;
			$this->end_date           = $data->end_date;
			$this->reference_document = $data->reference_document;
			$this->code               = $data->code;
			$this->lesson_number      = $data->lesson_number;
		}
	}

	public function as_array()
	{
		return array_merge( parent::as_array(), array(
			'curriculums' => Model::as_arrays( $this->curriculums() )
		) );
	}

	public function curriculums()
	{
		if ( !isset( $this->curriculums ) ) {
			$orm = $this->has_many_through( 'CoursePlanner\BaseModule\Model\Curriculum', 'CourseCurriculum' );
			$this->curriculums = $orm->find_many();
		}
		return $this->curriculums;
	}

	public function delete()
	{
		$orm = $this->has_many( 'CoursePlanner\BaseModule\Model\CourseCurriculum' );
		$orm->delete_many();
		parent::delete();
	}

}