<?php

	namespace Atoum;

	class at_class_relation implements idb {

		///////////////////////////////////////////////////////////////////////////////////////////
		// fields

		/**
		 * @var int is the relation's id.
		 * @since 2021/06/15
		 */
		protected $id;

		/**
		 * @var int is the relation's type.
		 * @since 2021/06/15
		 */
		protected $type;

		/**
		 * @var int is the object a's id.
		 * @since 2021/06/15
		 */
		protected $a_id;

		/**
		 * @var int is the object B's id.
		 * @since 2021/06/15
		 */
		protected $b_id;

		///////////////////////////////////////////////////////////////////////////////////////////
		// properties

		/**
		 * This variable can't be set outside the class or without the __constructor.
		 * @property-read int $id return id.
		 * @since 2021/06/15
		 */
		public function set_id( int $id ) {
			$this->id = $id;
		}

		public function get_id() {
			return $this->id;
		}

		/**
		 * @property-read int $type return type.
		 * @property-write int $type set type.
		 * @since 2021/06/15
		 */
		public function set_type( int $type ) {
			$this->type = $type;
		}
		public function get_type() {
			return $this->type;
		}

		/**
		 * @property-read int $a_id return a_id.
		 * @property-write int $a_id set a_id.
		 * @since 2021/06/15
		 */
		public function set_a_id( int $a_id ) {
			$this->a_id = $a_id;
		}
		public function get_a_id() {
			return $this->a_id;
		}

		/**
		 * @property-read int $b_id return b_id.
		 * @property-write int $b_id set b_id.
		 * @since 2021/06/15
		 */
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

			$sql0 = 'INSERT INTO ' . PREFIX . 'relations SET relation_type = :relation_type, relation_a_id = :relation_a_id, relation_b_id = :relation_b_id';

			$rqst_register = $DDB->prepare( $sql0 );
			$rqst_register->execute( [ ':relation_type'=>$this->type, ':relation_a_id'=>$this->a_id, ':relation_b_id'=>$this->b_id ] );

			$rqst_register->closeCursor();
		}

		public function unregister() {
			global $DDB;

			$sql0 = 'DELETE FROM ' . PREFIX . 'relations WHERE relation_id = :relation_id';

			$rqst_unregister = $DDB->prepare( $sql0 );
			$rqst_unregister->execute( [ ':relation_id'=>$this->id ] );

			$rqst_unregister->closeCursor();
		}

		public function are_linked() {
			global $DDB;

			$sql0 = 'SELECT * FROM ' . PREFIX . 'relations WHERE relation_type = :relation_type AND relation_a_id = :relation_a_id AND relation_b_id = :relation_b_id';

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

		/**
		 * Retrieve
		 * Check if the relation exist in the database.
		 * If exist, retrieve informations and store its inside this instance.
		 * @since 2021/06/15
		 */
		private function retrieve( int $id ) {
			global $DDB;

			$sql0 = 'SELECT * FROM ' . PREFIX . 'relations WHERE relation_id = :relation_id';

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