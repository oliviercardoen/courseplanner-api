<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;

class Curriculum extends Model {

	public function hydrate( $data )
	{

	}

	public function courses()
	{
		return $this->has_many_through( 'Course' );
	}

} 