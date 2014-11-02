<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;

class Curriculum extends Model {

	private $timeslot;

	public function courses()
	{
		$sql1 = 'SELECT * FROM `course` WHERE `course`.`id` IN (%s) ORDER BY `course`.`name` ASC';
		$sql2 = 'SELECT `course_id` FROM `course_curriculum` WHERE `curriculum_id` = %d';
		$sql = sprintf( $sql1, sprintf( $sql2, $this->id ) );
		$query = parent::query( $sql, '\CoursePlanner\BaseModule\Model\Course' );
		$results = $query->fetchAll();
		$query->closeCursor();
		return $results;
	}

	public function timeslot()
	{
		if ( !isset( $this->timeslot ) ) {
			$this->timeslot = Timeslot::find( $this->timeslot_id );
		}
		return $this->timeslot;
	}

	public static function all( $table = '`curriculum`' )
	{
		return parent::all( $table );
	}

	public static function find( $id, $table = '`curriculum`' )
	{
		return parent::find( $id, $table );
	}

	public function save()
	{
		if ( !$this->isNew() ) {
			$sql = 'UPDATE `curriculum` SET  `name` = :name, `timeslot_id` = :timeslot_id WHERE  `curriculum`.`id` = :id;';
		} else {
			$sql = 'INSERT INTO `curriculum` ( `id`, `name`, `timeslot_id`) VALUES ( :id, :name, :timeslot_id );';
		}

		$query = parent::prepare( $sql );

		$query->bindValue(':id', $this->id );
		$query->bindValue(':name', $this->name );
		$query->bindValue(':timeslot_id', $this->timeslot_id );

		return (bool) $query->execute();
	}

	public function delete( $table = '`curriculum`' )
	{
		return parent::delete( $table );
	}

} 