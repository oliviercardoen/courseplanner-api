<?php
namespace CoursePlanner\BaseModule\Model;

use Octopix\Selene\Mvc\Model\Model;

class Course extends Model {

	protected $curriculum_ids;
	protected $curriculums;

	public static function all( $table = '`course`' )
	{
		return parent::all( $table );
	}

	public function save()
	{
		if ( !$this->isNew() ) {
			$sql = 'UPDATE `course` SET  `name` = :name, `start_date` = :start_date , `end_date` = :end_date, `reference_document` = :reference_document, `code` = :code WHERE  `course`.`id` = :id;';
		} else {
			$sql = 'INSERT INTO `course` ( `id`, `name`, `start_date`, `end_date`, `reference_document`, `code`) VALUES ( :id, :name, :start_date, :end_date, :reference_document, :code );';
		}

		$query = parent::prepare( $sql );

		$query->bindValue(':id', $this->id );
		$query->bindValue(':name', $this->name );
		$query->bindValue(':code', $this->code );
		$query->bindValue(':start_date', $this->start_date );
		$query->bindValue(':end_date', $this->end_date );
		$query->bindValue(':reference_document', $this->reference_document );

		// Persist submitted course.
		$saved = (bool) $query->execute();

		if( $this->isNew() && $saved ) {
			$this->id = parent::connect()->lastInsertId();
		}

		// Persist relations with curriculums.
		if ( !empty( $this->curriculum_ids ) ) {
			$sql = 'INSERT INTO `course_curriculum` ( `course_id`, `curriculum_id` ) VALUES ( :course_id, :curriculum_id );';
			$query = parent::prepare( $sql );
			foreach( $this->curriculum_ids as $curriculum_id ) {
				$query->bindValue(':course_id', $this->id );
				$query->bindValue(':curriculum_id', (int) $curriculum_id );
				$saved = (bool) $query->execute();
			}
		}

		return $saved;
	}

	public function delete( $table = '`course`' )
	{
		return parent::delete( $table );
	}

	public function curriculums()
	{
		if ( !isset( $this->curriculums ) ) {
			$sql1 = 'SELECT * FROM `curriculum` WHERE `curriculum`.`id` IN (%s) ORDER BY `curriculum`.`id`';
			$sql2 = 'SELECT `curriculum_id` FROM `course_curriculum` WHERE `course_id` = %d';
			$sql = sprintf( $sql1, sprintf( $sql2, $this->id ) );
			$query = parent::query( $sql, '\CoursePlanner\BaseModule\Model\Curriculum' );
			$this->curriculums = $query->fetchAll();
			$query->closeCursor();
		}
		return $this->curriculums;
	}

	public function isRelatedCurriculum( $id )
	{
		$curriculums = $this->curriculums();
		if( !empty( $curriculums ) ) {
			foreach( $curriculums as $curriculum ) {
				if ( $id === $curriculum->id ) {
					return true;
				}
			}
		}
		return false;
	}

}