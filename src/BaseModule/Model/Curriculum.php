<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;

class Curriculum extends Model {

	//public static $_table = 'curriculum';
	public static $_table_use_short_name = true;

	public function hydrate( $data )
	{

	}

	public function courses()
	{
		return $this->has_many_through( 'Course' );
	}

} 