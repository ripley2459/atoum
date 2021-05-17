<?php

class at_class_relation {

	// fields

	private $id;
	private $type;
	private $a_id;
	private $b_id;

	// properties

	public function set_id( int $id ) {
		$this->id = $id;
	}

	public function get_id() {
		return $this->id;
	}

	public function set_type( int $type ) {
		$this->type = $type;
	}

	public function get_type() {
		return $this->type;
	}

	public function set_a_id( int $a_id ) {
		$this->a_id = $a_id;
	}

	public function get_a_id() {
		return $this->a_id;
	}

	public function set_b_id( int $b_id ) {
		$this->b_id = $b_id;
	}

	public function get_b_id() {
		return $this->b_id;
	}


	// methods

	public function __construct( int $id ) {
		if( $id != -1 ) $this->retrieve( $id );
	}

	public function register() {
		global $DDB;

		$sql0 = 'INSERT INTO rp_relations SET relation_type = :relation_type, relation_a_id = :relation_a_id, relation_b_id = :relation_b_id';

		$rqst_register = $DDB->prepare( $sql0 );
		$rqst_register->execute( [ ':relation_type'=>$this->type, ':relation_a_id'=>$this->a_id, ':relation_b_id'=>$this->b_id ] );

		$rqst_register->closeCursor();
	}

	public function unregister() {
		global $DDB;

		$sql0 = 'DELETE FROM rp_relations WHERE relation_id = :relation_id';

		$rqst_unregister = $DDB->prepare( $sql0 );
		$rqst_unregister->execute( [ ':relation_id'=>$this->id ] );

		$rqst_unregister->closeCursor();
	}

	public function are_linked() {
		global $DDB;

		$sql0 = 'SELECT * FROM rp_relations WHERE relation_type = :relation_type AND relation_a_id = :relation_a_id AND relation_b_id = :relation_b_id';

		$rqst_are_linked = $DDB->prepare( $sql0 );
		$rqst_are_linked->execute( [ ':relation_type'=>$this->type, ':relation_a_id'=>$this->a_id, ':relation_b_id'=>$this->b_id ] );

		$relation = $rqst_are_linked->rowCount();

		if ( $relation > 0 ) {
			return true;
		}
		else {
			return false;
		}

		$rqst_are_linked->closeCursor();
	}

	private function retrieve( int $id ) {
		global $DDB;

		$sql0 = 'SELECT * FROM rp_relations WHERE relation_id = :relation_id';

		$rqst_retrieve = $DDB->prepare( $sql0 );
		$rqst_retrieve->execute( [ ':relation_id'=>$id ] );

		if( $rqst_retrieve ) {
			$relation = $rqst_retrieve->fetch();

			$this->id = $relation[ 'relation_id' ];
			$this->type = $relation[ 'relation_type' ];
			$this->a_id = $relation[ 'relation_a_id' ];
			$this->b_id = $relation[ 'relation_b_id' ];
		}

		$rqst_retrieve->closeCursor();
	}
}