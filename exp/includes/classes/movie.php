<?php

	class movie implements iDB {
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

				$sql0 = 'SELECT * FROM rp_movies WHERE movie_id = :movie_id';
	
				$rqst_retrieve = $DDB->prepare( $sql0 );
				$rqst_retrieve->execute( [ ':movie_id'=>$id ] );
	
				if( $rqst_retrieve ) {
					$actor = $rqst_retrieve->fetch();
					$this->id = $actor[ 'movie_id' ];
					$this->name = $actor[ 'movie_name' ];
					$this->registration_date = $actor[ 'movie_registration_date' ];
				}
	
				$rqst_retrieve->closeCursor();
			};
		}

		/**
		 * Crée un dossier avec le nom normalisé du film, dépose les fichiers par défaut et enregistrer ce film dans la base de données.
		 */
		public function register() {
			global $DDB;

			// Ajout dans la base de données.
			$sql0 = 'INSERT INTO rp_movies SET movie_name = :movie_name';
			$rqst_register = $DDB->prepare( $sql0 );
			$rqst_register->execute( [
				':movie_name'=>$this->name,
			] );
			$rqst_register->closeCursor();

			$this->__construct( $DDB->lastInsertId() );

			// Crée un dossier
			mkdir( UPLOADS . 'movies/' . $this->getNormalizedFileName() );
			// Dépose des fichiers par défaut.
			copy( INCLUDES . 'placeholders/' . 'preview.png', UPLOADS . 'movies/' . $this->getNormalizedFileName() . '/preview.png' );
		}

		/**
		 * Ajoute "removed_" devant le nom dans le dossier du film.
		 * Si l'opération réussie, alors on supprime de la base de données ce film.
		 */
		public function unregister() {
			global $DDB;

			if( rename( UPLOADS . 'movies/' . $this->getNormalizedFileName(), UPLOADS . 'movies/removed_' . $this->getNormalizedFileName() ) ) {
				$sql0 = 'DELETE FROM rp_movies WHERE movie_id = :movie_id';
				$rqst_unregister = $DDB->prepare( $sql0 );
				$rqst_unregister->execute( [ ':movie_id'=>$this->id ] );
				$rqst_unregister->closeCursor();
			}
		}

		/**
		 * Sauvegarde les changement appliqués sur cette instance dans la base de données.
		 * Renome également le dossier.
		 */
		public function save() {
			global $DDB;

			$sql0 = 'UPDATE rp_movies SET movie_name = :movie_name WHERE movie_id = :movie_id';
			$rqst_save = $DDB->prepare( $sql0 );
			$rqst_save->execute( [
				':movie_name'=>$this->name,
				':movie_id'=>$this->id,
			] );
			$rqst_save->closeCursor();
		}

		/**
		 * Donne tous les films enrgistrés dans la base de données.
		 * @return person array.
		 */
		static function getAll() {
			global $DDB;
	
			$movies = [];
			$sql0 = 'SELECT movie_id FROM rp_movies ORDER BY movie_name';
			$rqst_get_movies = $DDB->prepare( $sql0 );
			$rqst_get_movies->execute();
			while( $movie = $rqst_get_movies->fetch() ) {
				$movie = new movie( $movie[ 'movie_id' ] );
				array_push( $movies, $movie );
			}
			$rqst_get_movies->closeCursor();
			return $movies;
		}

		/**
		 * Change le nom du fichier et dans la base de données du film.
		 */
		public function changeName( string $newName ) {
			rename( UPLOADS . 'movies/' . $this->getNormalizedFileName(),  UPLOADS . 'movies/' . normalize( $newName . '_' . $this->registration_date ) );
			$this->setName( $newName );
			$this->save();
		}

		public function getNormalizedFileName() {
			return normalize( $this->getFileName() );
		}

		public function getFileName() {
			return $this->name . '_' . $this->registration_date;
		}

		public function getPath() {
			return UPLOADS . 'movies/' . $this->getNormalizedFileName() . '/';
		}
	}