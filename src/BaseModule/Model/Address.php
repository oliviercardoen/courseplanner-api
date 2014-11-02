<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;

class Address extends Model {

	public function delete( $table = '`address`' )
	{
		return parent::delete( $table );
	}

	public static function all( $table = '`address`' )
	{
		return parent::all( $table );
	}

	public static function find( $id, $table = '`address`' )
	{
		return parent::find( $id, $table );
	}

	public function save()
	{
		if ( $this->isNew() ) {
			$sql = 'INSERT INTO `address` ( `id`, `street`, `city`, `zipcode`, `school_location_id`, `country_id` ) VALUES ( :id, :street, :city, :zipcode, :school_location_id, :country_id );';
		} else {
			$sql = 'UPDATE `address` SET  `street` = :street, `city` = :city, `zipcode` = :zipcode, `country_id` = :school_location_id, `country_id` = :country_id WHERE  `address`.`id` = :id;';
		}

		$query = parent::prepare( $sql );

		$query->bindValue(':id', $this->id );
		$query->bindValue(':street', $this->street );
		$query->bindValue(':city', $this->city );
		$query->bindValue(':zipcode', $this->zipcode );
		$query->bindValue(':school_location_id', $this->school_location_id );
		$query->bindValue(':country_id', $this->country_id );

		// Persist submitted course.
		$saved = (bool) $query->execute();

		if( $this->isNew() && $saved ) {
			$this->id = parent::connect()->lastInsertId();
		}

		return $saved;
	}

} 