<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;

class School extends Model {

	protected $locations;

	public function locations()
	{
		if ( !isset( $this->locations ) ) {
			$sql = 'SELECT * FROM `school_location` WHERE `school_id` = %s ORDER BY `school_location`.`id`';
			$query = parent::query( sprintf( $sql, $this->id ), '\CoursePlanner\BaseModule\Model\SchoolLocation' );
			$this->locations = $query->fetchAll();
			$query->closeCursor();
		}
		return $this->locations;
	}

	public static function all( $table = '`school`' )
	{
		return parent::all( $table );
	}

	public static function find( $id, $table = '`school`' )
	{
		return parent::find( $id, $table );
	}

	public function delete( $table = '`school`' )
	{
		return parent::delete( $table );
	}

	public function save()
	{
		if ( $this->isNew() ) {
			$sql = 'INSERT INTO `school` ( `id`, `name` ) VALUES ( :id, :name );';
		} else {
			$sql = 'UPDATE `school` SET  `name` = :name WHERE  `school`.`id` = :id;';
		}

		$query = parent::prepare( $sql );

		$query->bindValue(':id', $this->id );
		$query->bindValue(':name', $this->name );

		// Persist submitted course.
		$saved = (bool) $query->execute();

		if( $this->isNew() && $saved ) {
			$this->id = parent::connect()->lastInsertId();
		}

		return $saved;
	}

} 