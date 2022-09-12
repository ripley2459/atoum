<?php

	class person implements iDB {
		///////////////////////////////////////////////////////////////////////////////////////////////
		// Fields

		private $id;
		private $name;
		private $registration_date;

		///////////////////////////////////////////////////////////////////////////////////////////////
		// Properties

		/**
		 * Propriété de id.
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * Propriété de name.
		 */
		public function setName( string $name ) {
			$this->name = $name;
		}

		public function getName() {
			return $this->name;
		}

		/**
		 * Propriété de la date d'inscription.
		 */
		public function getRegistrationDate() {
			return $this->registration_date;
		}

		///////////////////////////////////////////////////////////////////////////////////////////////
		// Methods

		/**
		 * Constructeur.
		 */
		public function __construct( int $id ) {
			if( $id != -1 ) {
				global $DDB;

				$sql0 = 'SELECT * FROM rp_persons WHERE person_id = :person_id';
	
				$rqst_retrieve = $DDB->prepare( $sql0 );
				$rqst_retrieve->execute( [ ':person_id'=>$id ] );
	
				if( $rqst_retrieve ) {
					$actor = $rqst_retrieve->fetch();
					$this->id = $actor[ 'person_id' ];
					$this->name = $actor[ 'person_name' ];
					$this->registration_date = $actor[ 'person_registration_date' ];
				}
	
				$rqst_retrieve->closeCursor();
			};
		}

		/**
		 * Crée un dossier avec le nom normalisé de la personne, déposer les fichiers par défaut et enregistrer cette personne dans la base de données.
		 */
		public function register() {
			global $DDB;

			// Ajout dans la base de données.
			$sql0 = 'INSERT INTO rp_persons SET person_name = :person_name';
			$rqst_register = $DDB->prepare( $sql0 );
			$rqst_register->execute( [
				':person_name'=>$this->name,
			] );
			$rqst_register->closeCursor();

			$this->__construct( $DDB->lastInsertId() );

			mkdir( UPLOADS . 'profiles/' . $this->getNormalizedFileName() );

			// Dépose des fichiers par défaut.
			copy( INCLUDES . 'placeholders/' . 'profile.png', UPLOADS . 'profiles/' . $this->getNormalizedFileName() . '/profile.png' );
			copy( INCLUDES . 'placeholders/' . 'background1.png', UPLOADS . 'profiles/' . $this->getNormalizedFileName() . '/background1.png' );
			copy( INCLUDES . 'placeholders/' . 'background2.png', UPLOADS . 'profiles/' . $this->getNormalizedFileName() . '/background2.png' );
		}

		/**
		 * Ajoute "removed_" devant le nom dans le dossier de la personne.
		 * Si l'opération réussie, alors on supprime de la base de données cette personne.
		 */
		public function unregister() {
			global $DDB;

			if( rename( UPLOADS . 'profiles/' . $this->getNormalizedFileName(), UPLOADS . 'profiles/removed_' . $this->getNormalizedFileName() ) ) {
				$sql0 = 'DELETE FROM rp_persons WHERE person_id = :person_id';
				$rqst_unregister = $DDB->prepare( $sql0 );
				$rqst_unregister->execute( [ ':person_id'=>$this->id ] );
				$rqst_unregister->closeCursor();
			}
		}

		/**
		 * Sauvegarde les changement appliqués sur cette instance dans la base de données.
		 * Renome également le dossier.
		 */
		public function save() {
			global $DDB;

			$sql0 = 'UPDATE rp_persons SET person_name = :person_name WHERE person_id = :person_id';
			$rqst_save = $DDB->prepare( $sql0 );
			$rqst_save->execute( [
				':person_name'=>$this->name,
				':person_id'=>$this->id,
			] );
			$rqst_save->closeCursor();
		}

		/**
		 * Donne toutes les personnes enrgistrées dans la base de données.
		 * @return person array.
		 */
		static function getAll() {
			global $DDB;
	
			$persons = [];
			$sql0 = 'SELECT person_id FROM rp_persons ORDER BY person_name';
			$rqst_get_persons = $DDB->prepare( $sql0 );
			$rqst_get_persons->execute();
			while( $person = $rqst_get_persons->fetch() ) {
				$person = new person( $person[ 'person_id' ] );
				array_push( $persons, $person );
			}
			$rqst_get_persons->closeCursor();
			return $persons;
		}

		/**
		 * Change le nom du fichier et dans la base de données de la personne.
		 */
		public function changeName( string $newName ) {
			rename( UPLOADS . 'profiles/' . $this->getNormalizedFileName(),  UPLOADS . 'profiles/' . normalize( $newName . '_' . $this->registration_date ) );
			$this->setName( $newName );
			$this->save();
		}

		public function getNormalizedFileName() {
			return normalize( $this->getFileName() );
		}

		public function getFileName() {
			return $this->name . '_' . $this->registration_date;
		}

		/**
		 * Affiche toutes les personnes sous forme d'une checkbox.
		 * Exploitable en HTML.
		 */
		static function displayAllAsCheckBox( int $contentId, int $relationType ) {
			$r ='';
			$relation = new relation( -1 );
			$relation->setA( $contentId );
			$relation->setType( $relationType );
			foreach ( person::getAll() as $person ) {
				$relation->setB( $person->getid() );
				$r .= $person->displayAsCheckbox( $relation->areLinked() );
			}
			return $r;
		}

		/**
		 * Affiche cette personne sous forme d'une checkbox.
		 * Exploitable en HTML.
		 */
		public function displayAsCheckbox( bool $checked = false ) {
			$r = '<label for="persons[]"><input type="checkbox" value="' . $this->id . '" name="persons[]"';
			if( $checked ) $r .= ' checked';
			return $r .= '>' . $this->name . '</label>';
		}

        /**
         * Affiche toutes les personnes sous forme d'un élément d'une liste de données.
         * Exploitable en HTML.
         */
        static function displayAllAsDataList( $id ) {
            $r = '<datalist id="' . $id . '">';
            foreach ( person::getAll() as $person ) {
                $r .= $person->displayAsDataList();
            }
            return $r . '</datalist>';
        }

        /**
         * Affiche cette personne sous forme d'un élément d'une liste de données.
         * Exploitable en HTML.
         */
        public function displayAsDataList() {
            return '<option value="' . $this->getName() . '">' . $this->getid() . '</option>';
        }

		/**
		 * Affiche la photo de profile
		 */
		public function getProfilePicture() {
			return '<img src="' . UPLOADSDFROMURL . 'profiles/' . $this->getNormalizedFileName() . '/profile.png">';
		}

		/**
		 * Exploitable en HTML.
		 */
		public function getChip() {
			return '<a href="person.php?person=' . $this->getId() . '" id="' . $this->getId() . '" class="chip person">' . $this->getProfilePicture() . $this->getName() . '</a>';
		}
	}