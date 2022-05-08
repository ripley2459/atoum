<?php

	class tag implements iDB {
		///////////////////////////////////////////////////////////////////////////////////////////////
		// Fields

		private $id;
		private $type;
		private $value;

		///////////////////////////////////////////////////////////////////////////////////////////////
		// Properties

		/**
		 * Propriété de id.
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * Propriété de type.
		 */
		public function setType( string $type ) {
			$this->type = $type;
		}

		public function getType() {
			return $this->type;
		}

		/**
		 * Propriété de value.
		 */
		public function setValue( string $value ) {
			$this->value = $value;
		}

		public function getValue() {
			return $this->value;
		}

		///////////////////////////////////////////////////////////////////////////////////////////////
		// Methods

		/**
		 * Constructeur.
		 */
		public function __construct( int $id ) {
			if( $id != -1 ) {
				global $DDB;
				$sql0 = 'SELECT * FROM rp_tags WHERE tag_id = :tag_id';
				$rqst_retrieve = $DDB->prepare( $sql0 );
				$rqst_retrieve->execute( [ ':tag_id'=>$id ] );
				if( $rqst_retrieve ) {
					$tag = $rqst_retrieve->fetch();
					$this->id = $tag[ 'tag_id' ];
					$this->type = $tag[ 'tag_type' ];
					$this->value = $tag[ 'tag_value' ];
				}
				$rqst_retrieve->closeCursor();
			}
		}

		/**
		 * Ajoute cette instance dans la base de données.
		 */
		public function register() {
			global $DDB;
			$sql0 = 'INSERT INTO rp_tags SET tag_type = :tag_type, tag_value = :tag_value';
			$rqst_register = $DDB->prepare( $sql0 );
			$rqst_register->execute( [
				':tag_type'=>$this->type,
				':tag_value'=>$this->value
			] );
			$rqst_register->closeCursor();
		}

		/**
		 * Suprimer cette instance de la base données un tag.
		 */
		public function unregister() {
			global $DDB;
			$sql0 = 'DELETE FROM rp_tags WHERE tag_id = :tag_id';
			$rqst_unregister = $DDB->prepare( $sql0 );
			$rqst_unregister->execute( [ ':tag_id'=>$this->id ] );
			$rqst_unregister->closeCursor();
		}

		/**
		 * Sauvegarde les changement appliqués sur cette instance dans la base de données.
		 */
		public function save() {
			global $DDB;
			// TODO
		}

		/**
		 * Donne tout les type de tag possible.
		 * Devrait être utilisé systématiquement.
		 */
		static function getTypes() {
			return [
				0 => 'Tag',
				1 => 'Category',
				2 => 'Trait'
			];
		}

		/**
		 * Donne toutes les personnes enrgistrées dans la base de données.
		 * @return person array.
		 */
		static function getAll() {
			global $DDB;
			$tags = [];
			$sql0 = 'SELECT tag_id FROM rp_tags';
			$sql0 = $DDB->prepare( $sql0 );
			$sql0->execute();
			while( $tag = $sql0->fetch() ) {
				$tag = new tag( $tag[ 'tag_id' ] );
				array_push( $tags, $tag );
			}
			$sql0->closeCursor();
			return $tags;
		}

		/**
		 * Affiche le tag sous forme d'une checkbox.
		 */
		public function displayAsCheckbox( bool $checked = false ) {
			$r = '<label for="tags[]"><input type="checkbox" value="' . $this->getId() . '" name="tags[]"';
			if( $checked ) $r .= ' checked';
			return $r .= '>' . $this->getValue() . '</label>';
		}

		/**
		 * Affiche tout les tags sous forme de checkbox.
		 */
		static function displayAll( int $contentId, int $relationType ) {
			$r = '';
			foreach( tag::getTypes() as $type => $value ) {
				$r .= tag::displayOnlyOfType( $contentId, $relationType, $type );
			}
			return $r;
		}

		/**
		 * Affiche les tags que du type donné sous forme de checkbox.
		 */
		static function displayOnlyOfType( int $contentId, int $relationType, int $tagType = 0 ) {
			$r ='';
			$relation = new relation( -1 );
			$relation->setA( $contentId );
			$relation->setType( $relationType );
			foreach ( tag::getAll() as $tag ) {
				if ( $tag->getType() == $tagType ) {
					$relation->setB( $tag->getId() );
					$r .= $tag->displayAsCheckbox( $relation->areLinked() );
				}
			}
			return $r;
		}
	}