<?php

	class relation implements iDB {
		///////////////////////////////////////////////////////////////////////////////////////////////
		// Fields

		private $id;
		private $type;
		private $a;
		private $b;

		///////////////////////////////////////////////////////////////////////////////////////////////
		// Properties

		/**
		 * Propriété de id.
		 */
		public function getid() {
			return $this->id;
		}

		/**
		 * Propriété de type.
		 */
		public function setType( int $type ) {
			$this->type = $type;
		}

		public function getType() {
			return $this->type;
		}

		/**
		 * Propriété de A.
		 */
		public function setA( int $a ) {
			$this->a = $a;
		}

		public function getA() {
			return $this->a;
		}

		/**
		 * Propriété de B.
		 */
		public function setB( int $b ) {
			$this->b = $b;
		}

		public function getB() {
			return $this->b;
		}

		///////////////////////////////////////////////////////////////////////////////////////////////
		// Mehods

		/**
		 * Constructeur.
		 */
		public function __construct( int $id ) {
			if( $id != -1 ) {
				global $DDB;
				$sql0 = 'SELECT * FROM rp_relations WHERE relation_id = :relation_id';
				$rqst_retrieve = $DDB->prepare( $sql0 );
				$rqst_retrieve->execute( [ ':relation_id'=>$id ] );
				if( $rqst_retrieve ) {
					$relation = $rqst_retrieve->fetch();
					$this->id = $relation[ 'relation_id' ];
					$this->type = $relation[ 'relation_type' ];
					$this->a = $relation[ 'relation_a_id' ];
					$this->b = $relation[ 'relation_b_id' ];
				}
				$rqst_retrieve->closeCursor();
			}
		}

		/**
		 * Ajoute cette instance dans la base de données.
		 */
		public function register() {
			global $DDB;
			$s = 'INSERT INTO rp_relations SET relation_type = :relation_type, relation_a_id = :relation_a_id, relation_b_id = :relation_b_id';
			$r = $DDB->prepare( $s );
			$r->execute( [ ':relation_type'=>$this->type, ':relation_a_id'=>$this->a, ':relation_b_id'=>$this->b ] );
			$r->closeCursor();
		}

		/**
		 * Suprimer cette instance de la base données un tag.
		 */
		public function unregister() {
			global $DDB;
			$s = 'DELETE FROM rp_relations WHERE relation_id = :relation_id';
			$r = $DDB->prepare( $s );
			$r->execute( [ ':relation_id'=>$this->id ] );
			$r->closeCursor();
		}

		/**
		 * Sauvegarde les changement appliqués sur cette instance dans la base de données.
		 */
		public function save() {
			global $DDB;
			// TODO
		}

		/**
		 * Donne un array de relation liées à l'id de l'objet étudié.
		 */
		static function getRelationsRelated( $relationType, $contentId ) {
			global $DDB;
			$relations = [];
			$s = 'SELECT relation_id FROM rp_relations WHERE relation_type = :relation_type AND relation_a_id = :relation_a_id';
			$r = $DDB->prepare( $s );
			$r->execute( [ ':relation_type'=>$relationType, ':relation_a_id'=>$contentId ] );
			while( $relation = $r->fetch() ) {
				$relation = new relation( $relation[ 'relation_id' ] );
				array_push( $relations, $relation );
			}
			$r->closeCursor();
			return $relations;
		}

		/**
		 * Détruit tout les relations d'un certain type d'un certain objet.
		 * Utilisé uniquement pour rebind des relations directement derrière.
		 */
		static function purgeRelationsRelated( $relationType, $contentId ) {
			foreach( relation::getRelationsRelated( $relationType, $contentId ) as $relation ) {
				$relation->unregister();
			}
		}

		/**
		 * Donne vrai ou faux si A et B sont liés.
		 */
		public function areLinked() {
			global $DDB;
			$sq = 'SELECT * FROM rp_relations WHERE relation_type = :relation_type AND relation_a_id = :relation_a_id AND relation_b_id = :relation_b_id';
			$rl = $DDB->prepare( $sq );
			$rl->execute( [ ':relation_type'=>$this->type, ':relation_a_id'=>$this->a, ':relation_b_id'=>$this->b ] );
			$relation = $rl->rowCount();
			if ( $relation > 0 ) {
				return true;
			}
			else {
				return false;
			}
			$rl->closeCursor();
		}
	}