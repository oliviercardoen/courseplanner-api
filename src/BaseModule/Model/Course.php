<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;

class Course extends Model {

	public static $_table = 'course';

	public function hydrate( $data )
	{
		if ( !empty( $data ) ) {
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

}