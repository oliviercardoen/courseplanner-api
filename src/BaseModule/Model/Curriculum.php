<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;

class Curriculum extends Model {

	public function hydrate( $data )
	{
		if ( !empty( $data ) ) {
			$this->name        = $data['name'];
			$this->code        = $data['code'];
			$this->timeslot_id = $data['timeslot_id'];
		}
	}

	public function courses()
	{
		return $this->has_many_through( 'Course' );
	}

} 